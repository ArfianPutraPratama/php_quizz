<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

// Validasi input
if (!isset($_GET['device_id']) || empty($_GET['device_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'device_id' is required."
    ]);
    exit;
}

if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'quiz_id' is required."
    ]);
    exit;
}

if (!isset($_GET['level']) || empty($_GET['level'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter 'level' is required."
    ]);
    exit;
}

$deviceId = $_GET['device_id'];
$quizId = (int) $_GET['quiz_id'];
$level = (int) $_GET['level'];

// Query untuk mengambil skor berdasarkan device_id, quiz_id, dan level
$sql = "SELECT score FROM user_scores WHERE device_id = ? AND quiz_id = ? AND level = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare SQL statement: " . $conn->error
    ]);
    exit;
}

// Bind parameter ke query
$stmt->bind_param("sii", $deviceId, $quizId, $level);

// Eksekusi query
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to execute SQL statement: " . $stmt->error
    ]);
    exit;
}

// Ambil hasil query
$result = $stmt->get_result();
$scoreData = null;

if ($result->num_rows > 0) {
    $scoreData = $result->fetch_assoc();
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();

// Kembalikan respons JSON
if ($scoreData) {
    echo json_encode([
        "status" => "success",
        "data" => [
            "score" => (int) $scoreData['score']
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No percentage score found for the given device_id, quiz_id, and level."
    ]);
}
?>