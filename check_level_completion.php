<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Konfigurasi database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "neoquiz"; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(array(
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    )));
}

// Validasi input
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Invalid input: user_id is missing or empty."
    ));
    exit;
}

$userId = $_GET['user_id']; // Ambil user_id dari query parameter

// Query untuk mengambil status penyelesaian level
$sql = "SELECT username, level1_completed, level2_completed, level3_completed, level4_completed FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Failed to prepare SQL statement: " . $conn->error
    ));
    exit;
}

// Bind parameter ke query
$stmt->bind_param("i", $userId);

// Eksekusi query
if (!$stmt->execute()) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Failed to execute SQL statement: " . $stmt->error
    ));
    exit;
}

// Bind hasil query ke variabel
$stmt->bind_result($username, $level1_completed, $level2_completed, $level3_completed, $level4_completed);

// Ambil data
if ($stmt->fetch()) {
    $response = array(
        "status" => "success",
        "username" => $username,
        "level1_completed" => (bool) $level1_completed,
        "level2_completed" => (bool) $level2_completed,
        "level3_completed" => (bool) $level3_completed,
        "level4_completed" => (bool) $level4_completed
    );
} else {
    $response = array(
        "status" => "error",
        "message" => "User not found."
    );
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();

// Kembalikan respons dalam format JSON
echo json_encode($response);
?>