<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $materials = isset($_POST['materials']) ? $_POST['materials'] : [];
    $tool_quantities = isset($_POST['tool_quantities']) ? $_POST['tool_quantities'] : [];
    $material_quantities = isset($_POST['material_quantities']) ? $_POST['material_quantities'] : [];
    $remarks = $_POST['remarks'];
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    date_default_timezone_set('Asia/Manila');
    $date_taken = date('Y-m-d H:i:s');

    if ($username === null) {
        die("User is not logged in.");
    }

    $conn->autocommit(FALSE); // Start transaction

    try {
        // Insert into toolstatus
        $sql = "INSERT INTO toolstatus (username, remarks, date_taken) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $remarks, $date_taken);
        $stmt->execute();
        $toolstatus_id = $stmt->insert_id;
        $stmt->close();

        // Fetch tool names and update quantities
        $tool_names = [];
        if (!empty($tools)) {
            $tool_ids = implode(',', array_map('intval', $tools));
            $sql = "SELECT id, name FROM tools WHERE id IN ($tool_ids)";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $tool_names[$row['id']] = $row['name'];
            }
        }

        foreach ($tools as $tool_id) {
            $quantity = $tool_quantities[$tool_id];
            $sql = "UPDATE tools SET quantity = quantity - ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $quantity, $tool_id);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO toolstatus_tools (toolstatus_id, tool_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $toolstatus_id, $tool_id, $quantity);
            $stmt->execute();
            $stmt->close();
        }

        // Fetch material names and update quantities
        $material_names = [];
        if (!empty($materials)) {
            $material_ids = implode(',', array_map('intval', $materials));
            $sql = "SELECT id, name FROM materials WHERE id IN ($material_ids)";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $material_names[$row['id']] = $row['name'];
            }
        }

        foreach ($materials as $material_id) {
            $quantity = $material_quantities[$material_id];
            $sql = "UPDATE materials SET quantity = quantity - ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $quantity, $material_id);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO toolstatus_materials (toolstatus_id, material_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $toolstatus_id, $material_id, $quantity);
            $stmt->execute();
            $stmt->close();
        }

        // Prepare data for return_audit
        $action_type = 'Withdrawal';
        $price = 0;

        $tools_list = implode(", ", array_map(function($id) use ($tool_quantities, $tool_names) {
            return "{$tool_names[$id]} (Quantity: {$tool_quantities[$id]})";
        }, $tools));

        $materials_list = implode(", ", array_map(function($id) use ($material_quantities, $material_names) {
            return "{$material_names[$id]} (Quantity: {$material_quantities[$id]})";
        }, $materials));

        // Insert into return_audit
        $sql = "INSERT INTO history (action_type, technician_name, tools, materials, price, remarks, action_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $action_type, $username, $tools_list, $materials_list, $price, $remarks, $date_taken);
        $stmt->execute();
        $stmt->close();

        $conn->commit(); // Commit transaction
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction
        die("Error: " . $e->getMessage());
    }

    header("Location: toolstatus.php");
    exit();
} else {
    header("Location: withdraw.php");
    exit();
}
?>
