<?php
require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $user->view();
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'View count incremented']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to increment view count']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
