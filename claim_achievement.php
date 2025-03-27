<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the raw POST data
    $rawPostData = file_get_contents('php://input');
    file_put_contents('debug.log', "Raw POST Data: " . $rawPostData . "\n", FILE_APPEND);

    // Try to parse as form data first
    $postData = $_POST;

    // If $_POST is empty, try to parse as JSON
    if (empty($postData)) {
        $jsonData = json_decode($rawPostData, true);
        if ($jsonData !== null) {
            $postData = $jsonData;
        }
    }

    // Log the parsed POST data for debugging
    file_put_contents('debug.log', "POST Data: " . print_r($postData, true) . "\n", FILE_APPEND);

    // Check if POST data exists
    if (empty($postData)) {
        file_put_contents('debug.log', "Error: No POST data received\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'No POST data received'
        ]);
        exit;
    }

    // Get POST data
    $user = isset($postData['username']) ? $postData['username'] : null;
    $device_id = isset($postData['device_id']) ? $postData['device_id'] : null;
    $level = isset($postData['level']) ? (int) $postData['level'] : null;
    $quiz_ids = isset($postData['quiz_ids']) ? $postData['quiz_ids'] : null;

    // Validate required fields
    if (!$user || !$device_id || !$level || !$quiz_ids) {
        file_put_contents('debug.log', "Error: Missing required fields (username=$user, device_id=$device_id, level=$level, quiz_ids=$quiz_ids)\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields'
        ]);
        exit;
    }

    // Validate device_id against the users table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND device_id = ?");
    $stmt->execute([$user, $device_id]);
    $userExists = $stmt->fetchColumn();

    if ($userExists == 0) {
        file_put_contents('debug.log', "Error: Invalid username or device_id\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid username or device_id'
        ]);
        exit;
    }

    // Log the received data
    file_put_contents('debug.log', "Received: username=$user, device_id=$device_id, level=$level, quiz_ids=$quiz_ids\n", FILE_APPEND);

    // Check if achievement already claimed
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM achievements WHERE username = ? AND level = ?");
    $checkStmt->execute([$user, $level]);
    $count = $checkStmt->fetchColumn();

    file_put_contents('debug.log', "Check result: count=$count\n", FILE_APPEND);

    if ($count > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Achievement already claimed'
        ]);
        exit;
    }

    // Insert achievement record
    $stmt = $pdo->prepare("
        INSERT INTO achievements (username, device_id, level, quiz_ids, claim_date) 
        VALUES (?, ?, ?, ?, NOW())
    ");

    try {
        $success = $stmt->execute([$user, $device_id, $level, $quiz_ids]);
    } catch (PDOException $e) {
        file_put_contents('debug.log', "Insert error: " . $e->getMessage() . "\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'Insert error: ' . $e->getMessage()
        ]);
        exit;
    }

    if ($success) {
        file_put_contents('debug.log', "Success: Achievement inserted\n", FILE_APPEND);
        echo json_encode([
            'status' => 'success',
            'message' => 'Achievement claimed successfully'
        ]);
    } else {
        file_put_contents('debug.log', "Error: Failed to insert achievement (no specific error)\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to claim achievement (no specific error)'
        ]);
    }

} catch (PDOException $e) {
    file_put_contents('debug.log', "Database error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>