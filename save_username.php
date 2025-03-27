<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));
if ($data === null || !isset($data->device_id) || !isset($data->username)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
    exit();
}

$deviceId = $data->device_id;
$username = $data->username;

// Check if device already has a user
$checkSql = "SELECT username FROM users WHERE device_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $deviceId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "This device is already assigned to a user."]);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Insert new user
$sql = "INSERT INTO users (device_id, username) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $deviceId, $username);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Username saved successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save username: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>