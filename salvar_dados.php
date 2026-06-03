<?php

include 'connect.php';

$kph = isset($_POST['velocidade']);
$rpm = isset($_POST['rpm']);


$stmt = $conn->prepare("INSERT INTO monitoramento (rpm, kph) VALUES (?, ?)");
$stmt->bind_param("id", $rpm, $kph); 
$conn->close();

?>