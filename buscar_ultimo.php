<?php

include 'connect.php';
include 'salvar_dados.php';

if ($stmt->execute()) {

    $last_id = $conn->insert_id;
    $query = $conn->query("SELECT rpm, kph FROM monitoramento WHERE id = $last_id");
    
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        echo json_encode([
            'rpm' => $row['rpm'], 
            'kph' => $row['kph']
        ]);
    } else {

        echo json_encode(['error' => 'Record inserted but failed to fetch']);
    }
} else {
    echo json_encode(['error' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
