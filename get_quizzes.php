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

// Query untuk mengambil semua quiz
$sql = "SELECT id, title, subtitle, description, question_count, duration, icon_path FROM quizzes";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare SQL statement: " . $conn->error
    ]);
    exit;
}

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
$quizzes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Pastikan tipe data yang benar untuk field numerik
        $row['id'] = (int) $row['id'];
        $row['question_count'] = (int) $row['question_count'];
        $quizzes[] = $row;
    }
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();

// Kembalikan respons JSON
echo json_encode([
    "status" => "success",
    "data" => $quizzes
]);
?>