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
    $date_taken = date('Y-m-d H:i:s');

    if ($username === null) {
        // Handle the error appropriately, e.g., redirect to login page or show an error message
        die("User is not logged in.");
    }

    // Insert into toolstatus table
    $sql = "INSERT INTO toolstatus (username, remarks, date_taken) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $username, $remarks, $date_taken);
    $stmt->execute();
    $toolstatus_id = $stmt->insert_id;
    $stmt->close();

    // Process tools
    foreach ($tools as $tool_id) {
        $quantity = $tool_quantities[$tool_id];
        // Update tools quantity
        $sql = "UPDATE tools SET quantity = quantity - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $quantity, $tool_id);
        $stmt->execute();
        $stmt->close();

        // Insert into toolstatus_tools
        $sql = "INSERT INTO toolstatus_tools (toolstatus_id, tool_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iii", $toolstatus_id, $tool_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    // Process materials
    foreach ($materials as $material_id) {
        $quantity = $material_quantities[$material_id];
        // Update materials quantity
        $sql = "UPDATE materials SET quantity = quantity - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $quantity, $material_id);
        $stmt->execute();
        $stmt->close();

        // Insert into toolstatus_materials
        $sql = "INSERT INTO toolstatus_materials (toolstatus_id, material_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iii", $toolstatus_id, $material_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: toolstatus.php");
    exit();
} else {
    header("Location: withdraw.php");
    exit();
}
?>
