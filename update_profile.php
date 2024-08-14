<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$password = $_POST['password'];
$image = $_FILES['image'];

// Handle password update
$password_query = "";
$params = [$username, $user_id]; 

if (!empty($password)) {
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $password_query = ", password = ?";
    $params = [$username, $password_hashed, $user_id];
}

// image upload
$image_query = "";
if (isset($image) && $image['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $image_query = ", image = ?";
        array_splice($params, -1, 0, $target_file); 
    }
}

// Construct the SQL query
$sql = "UPDATE users SET username = ? {$password_query} {$image_query} WHERE id = ?";
$stmt = $conn->prepare($sql);

// Bind parameters dynamically based on whether the password and/or image are included
$types = str_repeat('s', count($params) - 1) . 'i'; // All string types except last (user_id)
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    header("Location: profile.php");
} else {
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
