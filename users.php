<?php
session_start();

include 'dbconnect.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_image = $user['image'] ?? 'img/undraw_profile.svg';

$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

$sql = "SELECT * FROM users WHERE username LIKE '%$search%' OR role LIKE '%$search%'";
$result = $conn->query($sql);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <!-- SB Admin 2 Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .inventory-header {
            margin-bottom: 20px;
        }
        .inventory-header .btn {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .inventory-header .input-group {
            position: relative;
            margin-bottom: 10px;
            display: flex;
            width: 100%;
        }
        .inventory-header .input-group input {
            flex: 1;
            padding: 10px 20px;
            border-radius: 50px 0 0 50px;
            border: 1px solid #e3e6f0;
            background-color: #f8f9fc;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.075);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .inventory-header .input-group input:focus {
            border-color: #a1a1a1;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .inventory-header .input-group .btn {
            border-radius: 0 50px 50px 0;
        }
        .filter-btn-group {
            display: flex;
            align-items: center;
        }
        .filter-btn-group .btn {
            margin-left: 5px;
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .filter-btn-group .filter-label {
            margin: 0 10px;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }
        .inventory-item {
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .inventory-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .inventory-item h5 {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }
        .inventory-item p {
            margin-bottom: 5px;
            color: #6c757d;
        }

        .input-group {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .input-group input {
            border-radius: 20px 0 0 20px;
        }

        .input-group button {
            border-radius: 0 20px 20px 0;
        }
        .table-responsive td {
            color: black;
        }
        .table-responsive th {
            color: black;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-text mx-3">SERVPRO</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- Nav Item - Inventory -->
            <li class="nav-item">
                <a class="nav-link" href="inventory.php">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Inventory</span></a>
            </li>

            <!-- Nav Item - Withdraw --> 
            <li class="nav-item">
                <a class="nav-link" href="withdraw.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span> Inventory Withdrawal</span></a>
            </li>

            <!-- Nav Item - Status -->
            <li class="nav-item">
                <a class="nav-link" href="toolstatus.php">
                    <i class="fas fa-fw fa-ellipsis-h"></i>
                    <span>Status</span></a>
            </li>

            <!-- Nav Item - Users -->
            <li class="nav-item active">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Users</span></a>
            </li>
            
            <!-- Nav Item - History -->
            <li class="nav-item">
                <a class="nav-link" href="history.php">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle  -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars($user_image); ?>" alt="User Image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="LOGIN.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Log Out
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Users</h1>
                    </div>

                    <!-- Search and Add Button -->
                    <div class="d-flex align-items-center mb-4">
                        <form action="users.php" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="ml-auto mb-4">
                    <a href="adduser.php">
                        <button class="btn btn-primary">
                            Add User
                        </button>
                    </a>
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT * FROM users WHERE username LIKE '%$search%' OR role LIKE '%$search%'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td><img src='" . $row["image"] . "' alt='User Image' width='50' height='50'></td>";
                                        echo "<td>" . $row["username"] . "</td>";
                                        echo "<td>" . $row["role"] . "</td>";
                                        echo "<td>" . $row["date_added"] . "</td>";
                                        echo "<td>
                                                <button class='btn btn-secondary btn-sm edit-user-btn' data-id='" . $row["id"] . "' data-username='" . $row["username"] . "' data-role='" . $row["role"] . "' data-image='" . $row["image"] . "'>Edit</button>
                                                <button class='btn btn-danger btn-sm delete-user-btn' data-id='" . $row["id"] . "'>Delete</button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No users found</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="edit-user-id" name="id">
                        <div class="form-group">
                            <label for="edit-username">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-role">Role</label>
                            <input type="text" class="form-control" id="edit-role" name="role" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-password">Password</label>
                            <input type="password" class="form-control" id="edit-password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="edit-image">Profile Image</label>
                            <input type="file" class="form-control" id="edit-image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Edit User Modal
            $(document).on('click', '.edit-user-btn', function() {
                var id = $(this).data('id');
                var username = $(this).data('username');
                var role = $(this).data('role');
                var image = $(this).data('image');

                $('#edit-user-id').val(id);
                $('#edit-username').val(username);
                $('#edit-role').val(role);
                $('#editUserModal').modal('show');
            });

            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'edit_user.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editUserModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Failed to update user: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        alert('AJAX error: ' + error);
                    }
                });
            });

            // Delete User
            $(document).on('click', '.delete-user-btn', function() {
                var id = $(this).data('id');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: 'delete_user.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Failed to delete user: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error);
                            alert('AJAX error: ' + error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
