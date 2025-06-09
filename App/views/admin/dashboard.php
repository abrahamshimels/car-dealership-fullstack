<!-- <?php //include '../includes/header.php'; 
// 
// 
session_start() ?> -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="./admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 </head>
 <body>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">CarDealer Admin</div>
        <nav>
            <a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="./cars.php"><i class="fas fa-car"></i> Cars</a>
            <a href="./testDrive.php"><i class="fas fa-calendar-alt"></i> Test Drives</a>
            <!-- <a href="/admin/users"><i class="fas fa-users"></i> Users</a> -->
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="dashboard-header">
            <h1>Dashboard Overview</h1>
            <div class="user-profile">
                <span>
                    <?php
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
                    ?>
                </span>
                <i class="fas fa-user-circle"></i>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="stats-grid row">
            <div class="stat-card bg-primary">
            <i class="fas fa-car"></i>
            <div class="stat-info">
                <span class="stat-number">30</span>
                <p>Total Cars</p>
            </div>
            </div>
            <div class="stat-card bg-success">
            <i class="fas fa-calendar-check"></i>
            <div class="stat-info">
                <span class="stat-number">12</span>
                <p>Test Drives</p>
            </div>
            </div>
            <div class="stat-card bg-warning">
            <i class="fas fa-users"></i>
            <div class="stat-info">
                <span class="stat-number">5</span>
                <p>Admins</p>
            </div>
            </div>
                <!-- User and Seller Cards -->
        <div class="stat-card bg-info">
            <i class="fas fa-user"></i>
            <div class="stat-info">
            <span class="stat-number">20</span>
            <p>Users</p>
            </div>
        </div>
        <div class="stat-card bg-secondary">
            <i class="fas fa-user-tie"></i>
            <div class="stat-info">
            <span class="stat-number">8</span>
            <p>Sellers</p>
            </div>
        </div>
        </div>

  

    </main>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
});
    </script>
</body>
 </html>
<!-- <?php include '../includes/footer.php'; ?> -->