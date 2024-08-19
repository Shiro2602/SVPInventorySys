<?php
include 'dbconnect.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    if ($type == 'tool') {
        $sql = "UPDATE tools SET name = ?, quantity = ?, price = ? WHERE id = ?";
    } else if ($type == 'material') {
        $sql = "UPDATE materials SET name = ?, quantity = ?, price = ? WHERE id = ?";
    } else {
        $response['message'] = 'Invalid item type';
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sidi', $name, $quantity, $price, $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Item updated successfully';
        } else {
            $response['message'] = 'Error executing query: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error preparing query: ' . $conn->error;
    }
} else {
    $response['message'] = 'Invalid request method';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
