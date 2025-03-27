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

    // Log the raw GET data for debugging
    file_put_contents('debug.log', "GET Data: " . print_r($_GET, true) . "\n", FILE_APPEND);

    // Get the username from the query parameter
    $user = isset($_GET['username']) ? $_GET['username'] : null;

    // Validate the username
    if (!$user) {
        file_put_contents('debug.log', "Error: Username is required\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'Username is required'
        ]);
        exit;
    }

    // Query to fetch the device_id for the given username
    $stmt = $pdo->prepare("SELECT device_id FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        file_put_contents('debug.log', "Success: Device ID found for username=$user\n", FILE_APPEND);
        echo json_encode([
            'status' => 'success',
            'data' => [
                'device_id' => $result['device_id']
            ]
        ]);
    } else {
        file_put_contents('debug.log', "Error: User not found for username=$user\n", FILE_APPEND);
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found'
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