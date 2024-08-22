<?php
session_start();
include 'dbconnect.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0; 
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0; 

    // Insert item into the correct table
    if ($type === 'tool') {
        $sql = "INSERT INTO tools (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idi", $name, $quantity, $price);
    } else if ($type === 'material') {
        $sql = "INSERT INTO materials (name, quantity, price, date_added) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idi", $name, $quantity, $price);
    } else {
        $response['message'] = 'Invalid item type';
        echo json_encode($response);
        exit();
    }

    if ($stmt->execute()) {
        $id = $stmt->insert_id;

        // Insert into audit log
        $action_type = 'Add Item';
        $technician_name = $_SESSION['username'];
        $tools = $type === 'tool' ? $name : null;
        $materials = $type === 'material' ? $name : null;

        $sql = "INSERT INTO history (action_type, technician_name, tools, materials, quantity, price, action_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $action_type, $technician_name, $tools, $materials, $quantity, $price);
        
        if ($stmt->execute()) {
            $data = [
                'id' => $id,
                'name' => $name,
                'type' => $type,
                'quantity' => $quantity,
                'price' => $price
            ];
            $response['success'] = true;
            $response['data'] = $data;
        } else {
            $response['message'] = 'Error logging addition: ' . $stmt->error;
        }
    } else {
        $response['message'] = 'Error adding item: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
}
?>