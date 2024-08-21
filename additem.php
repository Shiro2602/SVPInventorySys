<?php
session_start();
include 'dbconnect.php';

$name = $_POST['name'];
$type = $_POST['type'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

// Insert item into the correct table
if ($type === 'tool') {
    $sql = "INSERT INTO tools (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sid", $name, $quantity, $price);
} else if ($type === 'material') {
    $sql = "INSERT INTO materials (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sid", $name, $quantity, $price);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid item type']);
    exit();
}

if ($stmt->execute()) {
    $id = $stmt->insert_id;

    // Insert into audit log
    $action_type = 'Add Item';
    $technician_name = $_SESSION['username'];
    $tools = $type === 'tool' ? $name : null;
    $materials = $type === 'material' ? $name : null;

    $sql = "INSERT INTO history (action_type, technician_name, tools, materials, price, action_date) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssd", $action_type, $technician_name, $tools, $materials, $price);
    $stmt->execute();

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
