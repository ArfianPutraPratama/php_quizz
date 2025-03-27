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

    // Get the username and level from the query parameters
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    $level = isset($_GET['level']) ? (int) $_GET['level'] : null;

    // Validate required fields
    if (!$username || $level === null) {
        file_put_contents('debug.log', "Error: Missing required fields (username=$username, level=$level)\n", FILE_APPEND);
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => "Parameters 'username' and 'level' are required."
        ]);
        exit;
    }

    // Check if the achievement has been claimed
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM achievements 
        WHERE username = ? AND level = ?
    ");
    $stmt->execute([$username, $level]);
    $count = $stmt->fetchColumn();

    // Log the result
    file_put_contents('debug.log', "Achievement claimed check for username=$username, level=$level: count=$count\n", FILE_APPEND);

    // Return the response
    echo json_encode([
        'status' => 'success',
        'is_claimed' => $count > 0
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