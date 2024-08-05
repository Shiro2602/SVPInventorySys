<?php
include 'dbconnect.php';

$name = $_POST['name'];
$type = $_POST['type'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

if($type === 'tool') {
    $sql = "INSERT INTO tools (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
} else if ($type === 'material') {
    $sql = "INSERT INTO materials (name, quantity, price, date_addded) VALUES (?, ?, ?, NOW())";
} else {
    echo json_encode(['success' => false]);
    exit();
}

$stmt = $conn->prepare($sql);
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
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>