<?php
session_start();
include 'dbconnect.php';

// Fetch tools and materials from the database
$tools_sql = "SELECT * FROM tools";
$materials_sql = "SELECT * FROM materials";

$tools_result = $conn->query($tools_sql);
$materials_result = $conn->query($materials_sql);

$user_id = $_SESSION['user_id'];

// Fetch the user's image from the database
$sql = "SELECT image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Set a default image if no image is found
$user_image = $user['image'] ?? 'img/undraw_profile.svg';

$role = $_SESSION['role']; // Get the user's role from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Tools and Materials</title>
    <!-- SB Admin 2 Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-text mx-3">SERVPRO</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Inventory -->
            <li class="nav-item">
                <a class="nav-link" href="inventory.php">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Inventory</span></a>
            </li>
            <!-- Nav Item - Withdraw--> 
            <li class="nav-item active">
                <a class="nav-link" href="inventory.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Inventory Withdrawal</span></a>
            </li>
            <!-- Nav Item - Status -->
            <li class="nav-item">
                <a class="nav-link" href="toolstatus.php">
                    <i class="fas fa-fw fa-ellipsis-h"></i>
                    <span>Status</span></a>
            </li>
            <?php if ($role === 'admin'): ?>
            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas  fa-fw fa-user-circle"></i>
                    <span>Users</span></a>
            </li>
            <?php endif; ?>
            <!-- Nav Item - History -->
            <li class="nav-item">
                <a class="nav-link" href="history.php">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Withdraw Tools and Materials</h1>
                    </div>

                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search tools or materials...">
                    </div>

                    <!-- Withdraw Form -->
                    <form action="withdraw_action.php" method="POST">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tools-tab" data-toggle="tab" href="#tools" role="tab" aria-controls="tools" aria-selected="true">Tools</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="materials-tab" data-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="false">Materials</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- Tools Tab -->
                            <div class="tab-pane fade show active" id="tools" role="tabpanel" aria-labelledby="tools-tab">
                                <div id="toolsList">
                                    <?php if ($tools_result->num_rows > 0): ?>
                                        <?php while($tool = $tools_result->fetch_assoc()): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tools[]" value="<?= $tool['id'] ?>">
                                                <label class="form-check-label"><?= $tool['name'] ?> (Available: <?= $tool['quantity'] ?>)</label>
                                                <input type="number" name="tool_quantities[<?= $tool['id'] ?>]" class="form-control" placeholder="Quantity" min="1" max="<?= $tool['quantity'] ?>">
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p>No tools available</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Materials Tab -->
                            <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                <div id="materialsList">
                                    <?php if ($materials_result->num_rows > 0): ?>
                                        <?php while($material = $materials_result->fetch_assoc()): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="materials[]" value="<?= $material['id'] ?>">
                                                <label class="form-check-label"><?= $material['name'] ?> (Available: <?= $material['quantity'] ?>)</label>
                                                <input type="number" name="material_quantities[<?= $material['id'] ?>]" class="form-control" placeholder="Quantity" min="1" max="<?= $material['quantity'] ?>">
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p>No materials available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks and Submit -->
                        <div class="form-group mt-4">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Withdraw</button>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

    <!-- Search Functionality -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let tools = document.querySelectorAll('#toolsList .form-check');
            let materials = document.querySelectorAll('#materialsList .form-check');

            tools.forEach(function(tool) {
                let text = tool.textContent.toLowerCase();
                tool.style.display = text.includes(filter) ? '' : 'none';
            });

            materials.forEach(function(material) {
                let text = material.textContent.toLowerCase();
                material.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>
</html>
