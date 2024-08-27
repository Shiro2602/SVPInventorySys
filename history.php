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

$searchTerm = filter_var($_GET['search'] ?? '', FILTER_SANITIZE_STRING);
$startDate = filter_var($_GET['start_date'] ?? '', FILTER_SANITIZE_STRING);
$endDate = filter_var($_GET['end_date'] ?? '', FILTER_SANITIZE_STRING);

$itemsPerPage = 10;
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM history WHERE 
        (action_type LIKE ? OR 
        technician_name LIKE ? OR 
        tools LIKE ? OR 
        materials LIKE ?)";

$params = ['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%'];

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND action_date BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
}

$sql .= " ORDER BY action_date DESC LIMIT ? OFFSET ?";
$params[] = $itemsPerPage;
$params[] = $offset;

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

$totalRecords = $conn->query("SELECT FOUND_ROWS()")->fetch_assoc()['FOUND_ROWS()'];
$totalPages = ceil($totalRecords / $itemsPerPage);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- SB Admin 2 Bootstrap CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<style>
  .history-card p {
    color: black;
  }
  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  .page-item {
    margin: 0 5px;
  }
</style>

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
                <a class="nav-link" href="Inventory.php">
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

            <?php if ($role === 'admin'): ?>
            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas  fa-fw fa-user-circle"></i>
                    <span>Users</span></a>
            </li>
            <?php endif; ?>

            <!-- Nav Item - History -->
            <li class="nav-item active">
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

                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Dropdown -->
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
                    
                    <h1 class="h3 mb-4 text-gray-800">History</h1>

                    <div class="mb-4 d-flex align-items-center">
                        <input type="text" id="searchInput" class="form-control form-control-sm w-25 mr-2" placeholder="Search...">
                    </div>
                    <div class="mb-4 d-flex align-items-center">
                        <input type="date" id="startDate" class="form-control form-control-sm w-25 mr-2">
                        <input type="date" id="endDate" class="form-control form-control-sm w-25 ">
                        <button id="filterButton" class="btn btn-primary btn-sm ml-2">Filter</button> 
                    </div>

                    <div class="row">

                        <div class="col-lg-12 mb-4" id="historyContainer">

                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>

                                    <div class="card shadow mb-4 history-card">
                                        <div class="card-body">
                                            <p>Action Type: <?= htmlspecialchars($row['action_type']) ?></p>
                                            <p>Technician: <?= htmlspecialchars($row['technician_name']) ?></p>
                                            <p>Tools: <?= htmlspecialchars($row['tools']) ?></p>
                                            <p>Materials: <?= htmlspecialchars($row['materials']) ?></p>
                                            <?php if ($row['action_type'] === 'Add Item' || $row['action_type'] === 'Delete Item'): ?>
                                                <p>Quantity: <?= htmlspecialchars($row['quantity']) ?></p>
                                            <?php endif; ?>
                                            <p>
                                                <?php if ($row['action_type'] === 'Add Item' || $row['action_type'] === 'Delete Item'): ?>
                                                    Price: <?= htmlspecialchars($row['price']) ?>
                                                <?php else: ?>
                                                    Remarks: <?= htmlspecialchars($row['remarks']) ?>
                                                <?php endif; ?>
                                            </p>
                                            <div class="text-right text-gray-500">
                                                <?= htmlspecialchars($row['action_date']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No history records found.</p>
                            <?php endif; ?>
                        </div>

                    </div>

                    <nav class="pagination">
                        <?php if ($page > 1): ?>
                            <a class="page-item" href="?page=<?= $page - 1 ?>&search=<?= urlencode($searchTerm) ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>">Previous</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a class="page-item <?= $i == $page ? 'active' : '' ?>" href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <a class="page-item" href="?page=<?= $page + 1 ?>&search=<?= urlencode($searchTerm) ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>">Next</a>
                        <?php endif; ?>
                    </nav>
                </div>

            </div>

        </div>

    </div>


    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- SB Admin 2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

    <script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        updatePaginationLinks(searchValue, startDate, endDate);
        fetch(`history.php?search=${encodeURIComponent(searchValue)}&start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const historyContent = doc.getElementById('historyContainer').innerHTML;
                document.getElementById('historyContainer').innerHTML = historyContent;
            });
    });

    document.getElementById('filterButton').addEventListener('click', function() {
        const searchValue = document.getElementById('searchInput').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        updatePaginationLinks(searchValue, startDate, endDate);
        fetch(`history.php?search=${encodeURIComponent(searchValue)}&start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const historyContent = doc.getElementById('historyContainer').innerHTML;
                document.getElementById('historyContainer').innerHTML = historyContent;
            });
    });

    function updatePaginationLinks(searchValue, startDate, endDate) {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            const href = link.href;
            const url = new URL(href, window.location.href);
            url.searchParams.set('search', searchValue);
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            link.href = url.href;
        });
    }        
    </script>


</body>

</html>