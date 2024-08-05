<?php
require_once('./config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO user ( `name`, email,`password`) VALUES ( ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param('sss', $name, $email, $password);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'New member added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: Unable to prepare statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
