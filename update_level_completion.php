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
if ($data === null || !isset($data['device_id']) || !isset($data['level']) || !isset($data['quiz_id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid input data. 'device_id', 'level', and 'quiz_id' are required."]);
    exit();
}

$deviceId = $data['device_id'];
$level = (int) $data['level'];
$quizId = (int) $data['quiz_id'];
$questionIds = isset($data['question_ids']) ? implode(',', $data['question_ids']) : null;

if ($level < 1 || $level > 4) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid level. Must be between 1 and 4."]);
    exit();
}

$sql = "INSERT INTO user_level_completions (device_id, quiz_id, level, completed, completed_questions) 
        VALUES (?, ?, ?, 1, ?) 
        ON DUPLICATE KEY UPDATE completed = 1, completed_questions = ?";
$stmt = $conn->prepare($sql);

if ($questionIds !== null) {
    $stmt->bind_param("siiss", $deviceId, $quizId, $level, $questionIds, $questionIds);
} else {
    $stmt->bind_param("siii", $deviceId, $quizId, $level, 1);
}

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Level $level completion updated successfully for quiz $quizId."
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update level completion: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>