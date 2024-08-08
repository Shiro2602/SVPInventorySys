<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
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
            color: #000000;
        }
        .inventory-item h5 {
            color: #000000;
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
    </style>
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
            <li class="nav-item active">
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
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas  fa-fw fa-user-circle"></i>
                    <span>Users</span></a>
            </li>

            <!-- Nav Item - History -->
            <li class="nav-item">
                <a class="nav-link" href="history.php">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History</span></a>
            </li>

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

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Username</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Inventory</h1>
                    </div>

                    <!-- Inventory Content -->
                    <div class="inventory-header">
                        <form method="GET" action="inventory.php" class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <div class="filter-btn-group">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#addItemModal">Add</button>
                            <span class="filter-label">|</span>
                            <span class="filter-label">Filter:</span>
                            <a href="inventory.php?filter=tools" class="btn btn-dark">Tools</a>
                            <a href="inventory.php?filter=materials" class="btn btn-dark">Materials</a>
                        </div>
                    </div>

                    <div class="row" id="inventory-items">
                        <?php
                        // Database connection
                        include 'dbconnect.php';

                        // Fetch search query and filter
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                        // Fetch tools data
                        if ($filter == 'all' || $filter == 'tools') {
                            $sql_tools = "SELECT id, name, quantity, price FROM tools";
                            if ($search) {
                                $sql_tools .= " WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";
                            }
                            $result_tools = $conn->query($sql_tools);

                            if ($result_tools->num_rows > 0) {
                                while ($row = $result_tools->fetch_assoc()) {
                                    echo "<div class='col-md-4'>";
                                    echo "<div class='inventory-item'>";
                                    echo "<h5>" . htmlspecialchars($row['name']) . " (Tool)</h5>";
                                    echo "<p>ID: " . htmlspecialchars($row['id']) . "</p>";
                                    echo "<p>Quantity: " . htmlspecialchars($row['quantity']) . "</p>";
                                    echo "<p>Price: ₱" . htmlspecialchars($row['price']) . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else if ($filter == 'tools') {
                                echo "<div class='col-md-12'>";
                                echo "<div class='inventory-item'>";
                                echo "<p>No tools found</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }

                        // Fetch materials data
                        if ($filter == 'all' || $filter == 'materials') {
                            $sql_materials = "SELECT id, name, quantity, price FROM materials";
                            if ($search) {
                                $sql_materials .= " WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";
                            }
                            $result_materials = $conn->query($sql_materials);

                            if ($result_materials->num_rows > 0) {
                                while ($row = $result_materials->fetch_assoc()) {
                                    echo "<div class='col-md-4'>";
                                    echo "<div class='inventory-item'>";
                                    echo "<h5>" . htmlspecialchars($row['name']) . " (Material)</h5>";
                                    echo "<p>ID: " . htmlspecialchars($row['id']) . "</p>";
                                    echo "<p>Quantity: " . htmlspecialchars($row['quantity']) . "</p>";
                                    echo "<p>Price: ₱" . htmlspecialchars($row['price']) . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else if ($filter == 'materials') {
                                echo "<div class='col-md-12'>";
                                echo "<div class='inventory-item'>";
                                echo "<p>No materials found</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }

                        $conn->close();
                        ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="form-group">
                            <label for="item-name">Item Name</label>
                            <input type="text" class="form-control" id="item-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="item-type">Type</label>
                            <select class="form-control" id="item-type" name="type" required>
                                <option value="tool">Tool</option>
                                <option value="material">Material</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item-quantity">Quantity</label>
                            <input type="number" class="form-control" id="item-quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="item-price">Price</label>
                            <input type="number" class="form-control" id="item-price" name="price" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- SB Admin 2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            $('#addItemForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'additem.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json', 
                    success: function(response) {
                        console.log(response); 
                        if (response.success) {
                            // Close 
                            $('#addItemModal').modal('hide');
                            $('#addItemForm')[0].reset();
                            // Append the new item to the inventory
                            var newItem = '<div class="col-md-4">' +
                                            '<div class="inventory-item">' +
                                            '<h5>' + response.data.name + ' (' + response.data.type.charAt(0).toUpperCase() + response.data.type.slice(1) + ')</h5>' +
                                            '<p>ID: ' + response.data.id + '</p>' +
                                            '<p>Quantity: ' + response.data.quantity + '</p>' +
                                            '<p>Price: ₱' + response.data.price + '</p>' +
                                            '</div>' +
                                        '</div>';
                            $('#inventory-items').prepend(newItem);
                        } else {
                            alert('Failed to add item: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        console.log(xhr.responseText); 
                        alert('AJAX error: ' + error);
                    }
                });
            });
        });
    </script>

</body>
</html>
