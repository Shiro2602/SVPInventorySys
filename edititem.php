<?php
include 'dbconnect.php';

// Initialize the response array
$response = array('success' => false, 'message' => '');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $type = $_POST['type']; // Tool or Material

    // Prepare SQL statement based on the item type
    if ($type == 'tool') {
        $sql = "UPDATE tools SET name = ?, quantity = ?, price = ? WHERE id = ?";
    } else if ($type == 'material') {
        $sql = "UPDATE materials SET name = ?, quantity = ?, price = ? WHERE id = ?";
    } else {
        $response['message'] = 'Invalid item type';
        echo json_encode($response);
        exit();
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters and execute the query
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

// Close the database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
