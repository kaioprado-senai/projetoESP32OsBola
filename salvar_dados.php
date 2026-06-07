<?php
include 'connect.php';

$kph = $_POST['velocidade'] ?? 0; // ✅ corrigido
$rpm = $_POST['rpm'] ?? 0;        // ✅ corrigido

$stmt = $conn->prepare("INSERT INTO monitoramento (rpm, kph) VALUES (?, ?)");
$stmt->bind_param("dd", $rpm, $kph); // ✅ "dd" para dois floats
$stmt->execute(); // ✅ faltava isso
$stmt->close();
$conn->close();
?>