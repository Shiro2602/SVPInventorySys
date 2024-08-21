<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toolstatus_id = $_POST['toolstatus_id'];
    date_default_timezone_set('Asia/Manila');
    $date_returned = date('Y-m-d H:i:s');

    // Fetch details for history
    $sql = "SELECT * FROM toolstatus WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $toolstatus_id);
    $stmt->execute();
    $toolstatus = $stmt->get_result()->fetch_assoc();

    // Insert history record
    $action_type = 'Return';
    $technician_name = $toolstatus['username'];
    
    // Tools
    $tools_sql = "SELECT tools.name, toolstatus_tools.quantity FROM toolstatus_tools JOIN tools ON toolstatus_tools.tool_id = tools.id WHERE toolstatus_tools.toolstatus_id = ?";
    $stmt = $conn->prepare($tools_sql);
    $stmt->bind_param("i", $toolstatus_id);
    $stmt->execute();
    $tools_result = $stmt->get_result();
    $tools = [];
    while($tool = $tools_result->fetch_assoc()) {
        $tools[] = $tool['name'] . " (Quantity: " . $tool['quantity'] . ")";
    }
    $tools_text = implode(', ', $tools);
    
    // Materials
    $materials_sql = "SELECT materials.name, toolstatus_materials.quantity FROM toolstatus_materials JOIN materials ON toolstatus_materials.material_id = materials.id WHERE toolstatus_materials.toolstatus_id = ?";
    $stmt = $conn->prepare($materials_sql);
    $stmt->bind_param("i", $toolstatus_id);
    $stmt->execute();
    $materials_result = $stmt->get_result();
    $materials = [];
    while($material = $materials_result->fetch_assoc()) {
        $materials[] = $material['name'] . " (Quantity: " . $material['quantity'] . ")";
    }
    $materials_text = implode(', ', $materials);
    
    $remarks = $toolstatus['remarks'];

    $history_sql = "INSERT INTO return_audit (action_type, technician_name, tools, materials, remarks, action_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($history_sql);
    $stmt->bind_param("ssssss", $action_type, $technician_name, $tools_text, $materials_text, $remarks, $date_returned);
    $stmt->execute();
    $stmt->close();

    // Update tool status
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

    header("Location: toolstatus.php");
    exit();
} else {
    header("Location: toolstatus.php");
    exit();
}
?>
