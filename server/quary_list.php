<?php
require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare('INSERT INTO summary (name, price, amount) VALUES (?, ?, ?)');
    $stmt->bind_param('sdi', $name, $price, $amount);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert data']);
    }

    $stmt->close();
    $conn->close();
}
?>
