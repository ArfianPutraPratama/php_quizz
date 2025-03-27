<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

try {
    // Create database connection using PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Log the raw GET data for debugging
    file_put_contents('debug.log', "GET Data: " . print_r($_GET, true) . "\n", FILE_APPEND);

    // Get the device_id and level from the query parameters
    $device_id = isset($_GET['device_id']) ? $_GET['device_id'] : null;
    $level = isset($_GET['level']) ? (int) $_GET['level'] : null;

    // Validate required fields
    if (!$device_id || $level === null) {
        file_put_contents('debug.log', "Error: Missing required fields (device_id=$device_id, level=$level)\n", FILE_APPEND);
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => "Parameter 'device_id' and 'level' are required."
        ]);
        exit;
    }

    // Query to fetch completed quiz IDs for the given device_id and level (case-insensitive device_id)
    $stmt = $pdo->prepare("
        SELECT quiz_id 
        FROM user_scores 
        WHERE LOWER(device_id) = LOWER(?) AND level = ? AND score >= 70
    ");
    $stmt->execute([$device_id, $level]);
    $completedQuizzes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Log the completed quizzes for debugging
    file_put_contents('debug.log', "Completed quizzes for device_id=$device_id, level=$level: " . print_r($completedQuizzes, true) . "\n", FILE_APPEND);

    // Return the response
    echo json_encode([
        'status' => 'success',
        'data' => [
            'completed_quizzes' => array_map('intval', $completedQuizzes) // Ensure quiz IDs are integers
        ]
    ]);

} catch (PDOException $e) {
    file_put_contents('debug.log', "Database error: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>