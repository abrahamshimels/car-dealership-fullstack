<?php
session_start();

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: /car-dealership-fullstack/App/views/auth/login.php");
    exit();
}
//connect database
require_once __DIR__ . '/../../../Core/Database.php';
$db = new App\Core\Database();
$conn = $db->getConnection();
// Fetch test drive requests
$cars_stmt = $conn->prepare("SELECT car_id, username, preferred_date, status FROM test_drives");
$cars_stmt->execute();
$result = $cars_stmt->get_result();
$cars = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Initialize variables to avoid undefined variable errors
$successMessage = $successMessage ?? '';
$errorMessage = $errorMessage ?? '';
$statusErr = $statusErr ?? '';
$emailErr = $emailErr ?? '';
$phoneErr = $phoneErr ?? '';
$dateErr = $dateErr ?? '';
$carIdErr = $carIdErr ?? '';
$cars = $cars ?? [];
$pending_cars = $pending_cars ?? [];
$existing_bookings = $existing_bookings ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Test Drives</title>
    <link rel="shortcut icon" href="/car-dealership-fullstack/public/assets/Images/logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/car-dealership-fullstack/public/assets/CSS/style.css">
    <style>
        body {
            background: #fff;
        }
        .bg-approve {
            background-color:rgb(231, 175, 156) !important;
        }
        .text-approve {
            color: #fc4203 !important;
        }
        .btn-approve {
            background-color: #fc4203 !important;
            color: #fff !important;
            border: none;
        }
        .btn-approve:hover {
            background-color: #d93a00 !important;
            color: #fff !important;
        }
        .table-approve thead {
            background-color: #fc4203 !important;
            color: #fff;
        }
        .alert-approve {
            background-color: #fc4203 !important;
            color: #fff;
            border: none;
        }
        .form-select:focus, .form-control:focus {
            border-color: #fc4203;
            box-shadow: 0 0 0 0.2rem rgba(252,66,3,.25);
        }
        .card {
            border: 2px solid #fc4203;
        }
    </style>
</head>
<body>

   <!-- start include the header.php -->
   <?php include(__DIR__.'/../layouts/header.php');?>
    <!-- end include the header.php -->
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-approve text-white text-center shadow">
            <h2><i class="fas fa-check-circle me-2"></i>Approve Test Drive Requests</h2>
        </div>

        <div class="card-body p-4 bg-light">
            <!-- Success / Error messages -->
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-approve alert-dismissible fade show" role="alert">
                    <?= $successMessage ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $errorMessage ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($cars)): ?>
                <div class="mb-4">
                    <div class="alert alert-approve d-flex align-items-center shadow-sm">
                        <i class="fas fa-info-circle me-2"></i>
                        Review and approve or reject pending test drive requests below.
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered shadow table-approve">
                        <thead class="text-center">
                            <tr>
                                <th>Car ID</th>
                                <th>Username</th>
                                <th>Preferred Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?= htmlspecialchars($car['car_id']) ?></td>
                                    <td><?= htmlspecialchars($car['username']) ?></td>
                                    <td><?= htmlspecialchars($car['preferred_date']) ?></td>
                                    <td>
                                        <?php if ($car['status'] === 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php elseif ($car['status'] === 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($car['status'] === 'rejected'): ?>
                                            <span class="badge bg-danger">Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($car['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($car['status'] === 'pending'): ?>
                                            <form method="POST" action="/car-dealership-fullstack/App/Controller/updateSchedule.php" class="d-inline">
                                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['car_id']) ?>">
                                                <button type="submit" name="approve" class="btn btn-approve btn-sm me-1">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="/car-dealership-fullstack/App/Controller/approveTestDrive.php" class="d-inline">
                                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['car_id']) ?>">
                                                <button type="submit" name="reject" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">No action</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-approve text-center">
                    <i class="fas fa-car-slash me-2"></i>No test drive requests found.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>