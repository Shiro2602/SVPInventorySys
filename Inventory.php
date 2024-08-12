<?php
session_start();

// Include the database connection file
include 'dbconnect.php';

// Ensure the user is logged in and the role is set in the session
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$role = $_SESSION['role']; // Get the user's role from the session

?>

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
        .table-responsive td {
            color: black;
        }
        .table-responsive th {
            color: black;
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="filter-btn-group">
                            <?php if ($role === 'admin'): ?>
                                <button class="btn btn-dark" data-toggle="modal" data-target="#addItemModal">Add</button>
                                <span class="filter-label">|</span>
                            <?php endif; ?>
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
                                    if ($role === 'admin') {
                                        echo "<button class='btn btn-primary btn-sm edit-item-btn' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-quantity='" . $row["quantity"] . "' data-price='" . $row["price"] . "' data-type='tool'>Edit</button>";
                                    }
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
                                    if ($role === 'admin') {
                                        echo "<button class='btn btn-primary btn-sm edit-item-btn' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-quantity='" . $row["quantity"] . "' data-price='" . $row["price"] . "' data-type='material'>Edit</button>";
                                    }
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

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm">
                        <input type="hidden" id="edit-item-id" name="id">
                        <div class="form-group">
                            <label for="edit-item-name">Item Name</label>
                            <input type="text" class="form-control" id="edit-item-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-item-quantity">Quantity</label>
                            <input type="number" class="form-control" id="edit-item-quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-item-price">Price</label>
                            <input type="number" class="form-control" id="edit-item-price" name="price" step="0.01" required>
                        </div>
                        <input type="hidden" id="edit-item-type" name="type">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- SB Admin 2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
$(document).ready(function() {
    // Open Edit Item Modal
    $(document).on('click', '.edit-item-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var quantity = $(this).data('quantity');
        var price = $(this).data('price');
        var type = $(this).data('type');

        $('#edit-item-id').val(id);
        $('#edit-item-name').val(name);
        $('#edit-item-quantity').val(quantity);
        $('#edit-item-price').val(price);
        $('#edit-item-type').val(type);
        $('#editItemModal').modal('show');
    });

    // Handle Edit Item Form submission
    $('#editItemForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'edititem.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response); // Debugging line
                if (response.success) {
                    // Close the modal
                    $('#editItemModal').modal('hide');

                    // Update the item details on the page without refreshing
                    var itemId = $('#edit-item-id').val();
                    var itemType = $('#edit-item-type').val();

                    // Find the card for the updated item
                    $('button.edit-item-btn[data-id="' + itemId + '"][data-type="' + itemType + '"]').closest('.inventory-item').find('h5').text($('#edit-item-name').val() + ' (' + (itemType.charAt(0).toUpperCase() + itemType.slice(1)) + ')');
                    $('button.edit-item-btn[data-id="' + itemId + '"][data-type="' + itemType + '"]').closest('.inventory-item').find('p:contains("Quantity")').text('Quantity: ' + $('#edit-item-quantity').val());
                    $('button.edit-item-btn[data-id="' + itemId + '"][data-type="' + itemType + '"]').closest('.inventory-item').find('p:contains("Price")').text('Price: ₱' + $('#edit-item-price').val());
                } else {
                    alert('Failed to update item: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('AJAX error: ' + error);
            }
        });
    });
});
    </script>

</body>
</html>
