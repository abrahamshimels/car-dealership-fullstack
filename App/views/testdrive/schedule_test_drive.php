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
// Fetch cars
$cars_stmt = $conn->prepare("SELECT id, name, model, fuelType, price, status FROM cars");
$cars_stmt->execute();
$result = $cars_stmt->get_result();
$cars = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];


// Initialize variables to avoid undefined variable errors
$successMessage = $successMessage ?? '';
$errorMessage = $errorMessage ?? '';
$usernameErr = $usernameErr ?? '';
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
    <title>Schedule Test Drive</title>
    <link rel="shortcut icon" href="/car-dealership-fullstack/public/assets/Images/logo.jpg" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="/car-dealership-fullstack/public/assets/CSS/style.css">
</head>
<body>

   <!-- start include the header.php -->
   <?php include(__DIR__.'/../layouts/header.php');?>
    <!-- end include the header.php -->

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2>Schedule Your Test Drive</h2>
            <p class="mb-0">Experience the thrill of your next vehicle</p>
        </div>

        <div class="card-body p-4">
            <!-- Success / Error messages -->
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"><?= $successMessage ?></div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST" action="/car-dealership-fullstack/App/Controller/schedule_drive.php">
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" class="form-control <?= $usernameErr ? 'is-invalid' : '' ?>" name="username" required
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    <div class="invalid-feedback"><?= $usernameErr ?></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= $emailErr ? 'is-invalid' : '' ?>" name="email" required
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <div class="invalid-feedback"><?= $emailErr ?></div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control <?= $phoneErr ? 'is-invalid' : '' ?>" name="phone" required
                        pattern="[0-9]{10}" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    <div class="invalid-feedback"><?= $phoneErr ?></div>
                </div>

                <div class="mb-3">
                    <label for="preferred_date" class="form-label">Preferred Date & Time</label>
                    <input type="date" class="form-control <?= $dateErr ? 'is-invalid' : '' ?>" name="preferred_date" required>
                    <div class="invalid-feedback"><?= $dateErr ?></div>
                </div>

                <div class="mb-3">
                    <label for="car_id" class="form-label">Select Vehicle</label>
                    <select class="form-select <?= $carIdErr ? 'is-invalid' : '' ?>" name="car_id" required>
                        <option value="">Choose a vehicle</option>
                        <?php foreach ($cars as $car): 
                            $is_pending = in_array($car['id'], $pending_cars); ?>
                            <option value="<?= $car['id'] ?>"
                                <?= $is_pending ? 'disabled style="color: #999;"' : '' ?>>
                                <?= htmlspecialchars($car['name']) ?> (<?= $is_pending ? 'Booked' : $car['status'] ?>)
                            </option>
                        <?php endforeach; ?>

                        <?php if (count($existing_bookings) > 0): ?>
                            <option disabled style="color: #999;">You already have a pending test drive.</option>
                        <?php endif; ?>
                    </select>
                    <div class="invalid-feedback"><?= $carIdErr ?></div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" name="submit">
                        <i class="fas fa-calendar-check me-2"></i> Schedule Test Drive
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($cars)): ?>
        <div class="mt-5">
            <div class="alert alert-info d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                Pending test drives must be completed before scheduling new ones.
            </div>
            <h4>Available Vehicles</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Vehicle</th>
                            <th>ID</th>
                            <th>Fuel Type</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cars as $car): 
                            $is_pending = in_array($car['id'], $pending_cars); ?>
                            <tr class="<?= $is_pending ? 'table-secondary' : '' ?>">
                                <td><?= htmlspecialchars($car['name']) ?></td>
                                <td><?= htmlspecialchars($car['id']) ?></td>
                                <td><?= htmlspecialchars($car['fuelType']) ?></td>
                                <td>$<?= number_format($car['price'], 2) ?></td>
                                <td>
                                    <span class="badge bg-<?= $is_pending ? 'warning text-dark' : (strtolower($car['status']) === 'available' ? 'success' : 'secondary') ?>">
                                        <?= $is_pending ? 'Booked' : htmlspecialchars($car['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>


</body>
</html>