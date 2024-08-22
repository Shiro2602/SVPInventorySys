<?php
session_start();
include 'dbconnect.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['type'])) {
    $id = (int) $_POST['id'];
    $type = $_POST['type'];
    $table = ($type === 'tool') ? 'tools' : 'materials';

    // Fetch details of the item before deletion
    $details_sql = "SELECT * FROM $table WHERE id = ?";
    $details_stmt = $conn->prepare($details_sql);
    $details_stmt->bind_param("i", $id);
    $details_stmt->execute();
    $details_result = $details_stmt->get_result();
    $item = $details_result->fetch_assoc();

    if ($item) {
        $item_name = $item['name'];
        $item_quantity = isset($item['quantity']) ? $item['quantity'] : 0; // Default to 0 if quantity is not set
        $item_price = isset($item['price']) ? $item['price'] : 0; // Default to 0 if price is not set

        // Perform deletion
        $delete_sql = "DELETE FROM $table WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            // Prepare values for history
            $action_type = 'Delete Item';
            $technician_name = $_SESSION['username'];
            $remarks = '';

            if ($type === 'tool') {
                $tools = $item_name;
                $materials = ''; // Empty for tools
            } else {
                $tools = '';
                $materials = $item_name; // Empty for materials
            }

            // Insert deletion record into history
            $insert_history_sql = "INSERT INTO history (action_type, technician_name, tools, materials, quantity, price, remarks, action_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $insert_history_stmt = $conn->prepare($insert_history_sql);
            $insert_history_stmt->bind_param("sssssss", $action_type, $technician_name, $tools, $materials, $item_quantity, $item_price, $remarks);

            if ($insert_history_stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['message'] = 'Error logging deletion: ' . $conn->error;
            }

            $insert_history_stmt->close();
        } else {
            $response['message'] = 'Error deleting item: ' . $conn->error;
        }

        $delete_stmt->close();
    } else {
        $response['message'] = 'Item not found';
    }

    $details_stmt->close();
}

$conn->close();

echo json_encode($response);
?>
