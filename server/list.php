<?php
require_once 'config.php';

$stmt = $conn->prepare("SELECT * FROM `list`");
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$categorizedData = [
    'food' => [],
    'water' => [],
    'dessert' => []
];

foreach ($data as $item) {
    switch ($item['type']) {
        case 'food':
            $categorizedData['food'][] = $item;
            break;
        case 'water':
            $categorizedData['water'][] = $item;
            break;
        case 'dessert':
            $categorizedData['dessert'][] = $item;
            break;
    }
}

echo json_encode($categorizedData);
?>
