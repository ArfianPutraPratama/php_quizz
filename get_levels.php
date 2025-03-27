<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neoquiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$quiz_id = $_GET['quiz_id'];

$sql = "SELECT * FROM levels WHERE quiz_id = $quiz_id";
$result = $conn->query($sql);

$levels = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $levels[] = $row;
    }
}

echo json_encode($levels);

$conn->close();
?>