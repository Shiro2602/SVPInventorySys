<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'dbconnect.php';

$name = $_POST['name'];
$type = $_POST['type'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

if ($type === 'tool') {
    $sql = "INSERT INTO tools (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
} else if ($type === 'material') {
    $sql = "INSERT INTO materials (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid item type']);
    exit();
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("sid", $name, $quantity, $price);
if ($stmt->execute()) {
    $id = $stmt->insert_id;
    $data = [
        'id' => $id,
        'name' => $name,
        'type' => $type,
        'quantity' => $quantity,
        'price' => $price
    ];
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
