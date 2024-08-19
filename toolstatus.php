<?php
session_start();
include 'dbconnect.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_image = $user['image'] ?? 'img/undraw_profile.svg';

$role = $_SESSION['role'];

$sql = "SELECT * FROM toolstatus WHERE date_returned IS NULL";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <!-- SB Admin 2 Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
        }
        .card-body {
            color: black;
        }

        .card-header h5 {
            margin: 0;
        }

        .card-body .details {
            display: flex;
            justify-content: space-between;
        }

        .card-body .details .left,
        .card-body .details .right {
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-body .details {
                flex-direction: column;
            }

            .card-body .details .right {
                align-items: flex-start;
                margin-top: 1rem;
            }

            .btn {
                width: 100%;
            }
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
            <li class="nav-item active">
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
                        <h1 class="h3 mb-0 text-gray-800">Status</h1>
                    </div>

                    <!-- Card -->
                    <div class="row">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <div class="col-12">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Technician: <?= htmlspecialchars($row['username']) ?></h5>
                                            <small class="text-muted">Taken at: <?= htmlspecialchars($row['date_taken']) ?></small>
                                        </div>
                                        <div class="card-body">
                                            <div class="details">
                                                <div class="left">
                                                    <p>Tools: 
                                                        <?php
                                                        $toolstatus_id = $row['id'];
                                                        $tools_sql = "SELECT tools.name, toolstatus_tools.quantity FROM toolstatus_tools JOIN tools ON toolstatus_tools.tool_id = tools.id WHERE toolstatus_tools.toolstatus_id = ?";
                                                        $stmt = $conn->prepare($tools_sql);
                                                        $stmt->bind_param("i", $toolstatus_id);
                                                        $stmt->execute();
                                                        $tools_result = $stmt->get_result();
                                                        $tools = [];
                                                        while($tool = $tools_result->fetch_assoc()) {
                                                            $tools[] = $tool['name'] . " (Quantity: " . $tool['quantity'] . ")";
                                                        }
                                                        echo implode(', ', $tools);
                                                        $stmt->close();
                                                        ?>
                                                    </p>
                                                    <p>Materials: 
                                                        <?php
                                                        $materials_sql = "SELECT materials.name, toolstatus_materials.quantity FROM toolstatus_materials JOIN materials ON toolstatus_materials.material_id = materials.id WHERE toolstatus_materials.toolstatus_id = ?";
                                                        $stmt = $conn->prepare($materials_sql);
                                                        $stmt->bind_param("i", $toolstatus_id);
                                                        $stmt->execute();
                                                        $materials_result = $stmt->get_result();
                                                        $materials = [];
                                                        while($material = $materials_result->fetch_assoc()) {
                                                            $materials[] = $material['name'] . " (Quantity: " . $material['quantity'] . ")";
                                                        }
                                                        echo implode(', ', $materials);
                                                        $stmt->close();
                                                        ?>
                                                    </p>
                                                    <p>Remarks: <?= htmlspecialchars($row['remarks']) ?></p>
                                                </div>
                                                <div class="right">
                                                    <form action="return_tools.php" method="POST" onsubmit="return confirm('Are you sure you want to mark this tool as done?');">
                                                        <input type="hidden" name="toolstatus_id" value="<?= htmlspecialchars($row['id']) ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm">Mark as Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No tools or materials are currently checked out.</p>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
            <!-- End of Main Content -->

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- SB Admin 2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

</body>
</html>
