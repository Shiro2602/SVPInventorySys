<?php
include 'dbconnect.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    $table = ($type === 'tool') ? 'tools' : 'materials';

    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Error deleting item: ' . $conn->error;
    }

    $stmt->close();
}

$conn->close();

echo json_encode($response);
?>
