<?php
header("Content-Type: application/json");

// Ambil parameter dengan validasi
$device_id = isset($_GET['device_id']) ? trim($_GET['device_id']) : '';
$quiz_id = isset($_GET['quiz_id']) ? (int) $_GET['quiz_id'] : 1; // Default quiz_id = 1 sesuai database

if (empty($device_id)) {
    echo json_encode(["status" => "error", "message" => "device_id is required"]);
    exit;
}

$conn = new mysqli("localhost", "root", "", "neoquiz");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// 1. Cek user exist
$sql_user = "SELECT username FROM users WHERE device_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $device_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    $stmt_user->close();
    $conn->close();
    exit;
}

$user = $result_user->fetch_assoc();
$stmt_user->close();

// 2. Ambil data level completions
$sql_levels = "SELECT level, completed, completed_questions 
               FROM user_level_completions 
               WHERE device_id = ? AND quiz_id = ?";
$stmt_levels = $conn->prepare($sql_levels);
$stmt_levels->bind_param("si", $device_id, $quiz_id);
$stmt_levels->execute();
$result_levels = $stmt_levels->get_result();

// Siapkan response dasar
$response = [
    "status" => "success",
    "username" => $user['username'],
    "quiz_id" => $quiz_id
];

// Proses data level
$levels_data = [];
while ($row = $result_levels->fetch_assoc()) {
    $level = (int) $row['level'];
    $levels_data[$level] = [
        'completed' => (int) $row['completed'],
        'questions' => $row['completed_questions']
    ];
}

// Format response untuk semua level (1-4)
for ($i = 1; $i <= 4; $i++) {
    if (isset($levels_data[$i])) {
        $response["level{$i}_completed"] = $levels_data[$i]['completed'];
        $response["level{$i}_questions"] = $levels_data[$i]['questions'];
    } else {
        // Hanya tampilkan level yang ada di database
        // $response["level{$i}_completed"] = 0; // Opsional: uncomment jika ingin menampilkan semua level
    }
}

$stmt_levels->close();
$conn->close();

echo json_encode($response);
?>