<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbconnect.php';

$message = '';

// Ensure the uploads directory exists
$uploadDir = 'uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $image = $_FILES['image'];

    // Check if image is uploaded
    if ($image && $image['tmp_name']) {
        $imagePath = $uploadDir . '/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, role, password, image, date_added) VALUES (?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $message = 'Prepare failed: ' . $conn->error;
            } else {
                $stmt->bind_param("ssss", $username, $role, $hashed_password, $imagePath);
                if ($stmt->execute()) {
                    $message = 'User registered successfully';
                } else {
                    $message = 'Execute failed: ' . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            $message = 'Failed to upload image';
        }
    } else {
        $message = 'Image upload required';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <!-- SB Admin 2 Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .bg-register-image {
            background: url('img/register-bg.jpg');
            background-position: center;
            background-size: cover;
        }
        .register-form-container {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg my-5 register-form-container">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <?php if ($message): ?>
                                    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                                <?php endif; ?>
                                <form class="user" method="POST" action="adduser.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="role" name="role" placeholder="Role" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Profile Image:</label>
                                        <input type="file" class="form-control" id="image" name="image" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="dashboard.php">Back to Dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>
</body>
</html>
