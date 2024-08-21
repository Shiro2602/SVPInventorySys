<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toolstatus_id = $_POST['toolstatus_id'];
    date_default_timezone_set('Asia/Manila');
    $date_returned = date('Y-m-d H:i:s');

    $sql = "UPDATE toolstatus SET date_returned = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $date_returned, $toolstatus_id);
    $stmt->execute();
    $stmt->close();

    // Update tools quantity
    $tools_sql = "SELECT tool_id, quantity FROM toolstatus_tools WHERE toolstatus_id = ?";
    $stmt = $conn->prepare($tools_sql);
    $stmt->bind_param("i", $toolstatus_id);
    $stmt->execute();
    $tools_result = $stmt->get_result();
    while($tool = $tools_result->fetch_assoc()) {
        $tool_id = $tool['tool_id'];
        $quantity = $tool['quantity'];
        $update_sql = "UPDATE tools SET quantity = quantity + ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $quantity, $tool_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
    $stmt->close();

    header("Location: toolstatus.php");
    exit();
} else {
    header("Location: toolstatus.php");
    exit();
}
?>