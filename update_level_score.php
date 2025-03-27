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
    http_response_code(500);
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
if ($data === null || !isset($data['device_id']) || !isset($data['quiz_id']) || !isset($data['level']) || !isset($data['score'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid input data. 'device_id', 'quiz_id', 'level', and 'score' are required."]);
    exit();
}

$deviceId = $data['device_id'];
$quizId = (int) $data['quiz_id'];
$level = (int) $data['level'];
$score = (int) $data['score']; // This is now the percentage score (e.g., 80)

error_log("Received data: device_id=$deviceId, quiz_id=$quizId, level=$level, score=$score"); // Debug log

if ($level < 1 || $level > 4) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid level. Must be between 1 and 4."]);
    exit();
}

if ($score < 0 || $score > 100) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Score must be between 0 and 100."]);
    exit();
}

$sql = "INSERT INTO user_scores (device_id, quiz_id, level, score) 
        VALUES (?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE score = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to prepare statement: " . $conn->error]);
    exit();
}

$stmt->bind_param("siiii", $deviceId, $quizId, $level, $score, $score);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Percentage score for quiz $quizId, level $level updated successfully."
    ]);
} else {
    error_log("Failed to update score: " . $stmt->error); // Debug log
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update score: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>