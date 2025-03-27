<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Izinkan akses dari semua domain (untuk development)
header("Access-Control-Allow-Methods: GET"); // Izinkan hanya metode GET

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    die(json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

// Validasi input
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'quiz_id' is required."
    ]);
    exit;
}

if (!isset($_GET['level_id']) || empty($_GET['level_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'level_id' is required."
    ]);
    exit;
}

$quiz_id = intval($_GET['quiz_id']); // Konversi ke integer untuk keamanan
$level_id = intval($_GET['level_id']); // Konversi ke integer untuk keamanan

// Query untuk mengambil soal berdasarkan quiz_id dan level_id
$sql = "SELECT * FROM questions WHERE quiz_id = ? AND level_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare SQL statement: " . $conn->error
    ]);
    exit;
}

// Bind parameter ke query
$stmt->bind_param("ii", $quiz_id, $level_id);

// Eksekusi query
if (!$stmt->execute()) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "status" => "error",
        "message" => "Failed to execute SQL statement: " . $stmt->error
    ]);
    exit;
}

// Ambil hasil query
$result = $stmt->get_result();
$questions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();

// Kembalikan respons JSON
echo json_encode([
    "status" => "success",
    "data" => $questions
]);
?>