    <!-- header -->

    <header>
            <nav class="header-nav">

                <a class=" active " href="<?php echo '/car-dealership-fullstack/App/views/Home/index.php'; ?>" >                <div class="logo-wrapper">
                    <img src="/car-dealership-fullstack/public/assets/Images/logo.png" alt="logo" width="50">G3
                </div></a>
                <a class="active small-hidden" href="<?php echo '/car-dealership-fullstack/App/views/pages/model.php'; ?>">Models</a>

                <a class=" active small-hidden" href="<?php echo '/car-dealership-fullstack/App/views/pages/service.php'; ?>" >Services</a>
                <a class=" active small-hidden" href="<?php echo '/car-dealership-fullstack/App/views/pages/aboutUs.php'; ?>" >About Us</a>
                <a class=" active small-hidden" href="<?php echo '/car-dealership-fullstack/App/views/pages/news.php'; ?>" >News</a>
                <a class=" active small-hidden"href="<?php echo '/car-dealership-fullstack/App/views/pages/contact.php'; ?>" >Contact</a>
                <a class=" active small-hidden" href="<?php echo '/car-dealership-fullstack/App/views/pages/cart.php'; ?>" ><i class="fas fa-shopping-cart"></i>cart
                    
                        <?php 
                        include(__DIR__ . '/../../Controller/cart/CartController.php');
                        $ci=new CartController();
                        $cartNumber=$ci->cartCounter();
                        echo '<div class="cart-number">'.$cartNumber.'</div>';
                        ?>
                </a>
                <?php if(isset($_SESSION['username'])){
                    echo '<a class="small-hidden active"  href="/car-dealership-fullstack/App/views/auth/logout.php" ><i class="fas fa-sign-out-alt"></i> Logout</a>';
                }else{
                    echo '<a class=" active" href="/car-dealership-fullstack/App/views/auth/login.php" class="small-hidden">Log in <i class="fas fa-sign-in-alt"></i></a>';
                }
                ?>
                <?php 
                if(isset($_SESSION['username'])){
                        $sessionUsername = $_SESSION['username'];
$stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
$stmt->bind_param("s", $sessionUsername);
$stmt->execute();
$stmt->bind_result($userRole);
$stmt->fetch();
$stmt->close();

echo $sessionUsername;
echo $userRole;
if($userRole=='admin'){
    echo '<a class="active" href="/car-dealership-fullstack/App/views/auth/login.php" class="small-hidden">admin <i class="fas fa-user"></i></a>';
}else{
    echo '<a class="active" href="/car-dealership-fullstack/App/views/auth/login.php" class="small-hidden">account <i class="fas fa-user"></i></a>';
}
}else{
                    echo '<a class="active" href="/car-dealership-fullstack/App/views/auth/login.php" class="small-hidden">account <i class="fas fa-user"></i></a>';    }
                ?> 
                <div class="dropdown small-block">
                    <i class="fas fa-bars menu-icon"></i>
                    <div class="dropdown-content">
                        <a class=" active" href="<?php echo '/car-dealership-fullstack/App/views/pages/model.php'; ?>">Models</a>
                        <a class=" active" href="<?php echo '/car-dealership-fullstack/App/views/pages/service.php'; ?>">Services</a>
                        <a class=" active" href="<?php echo '/car-dealership-fullstack/App/views/pages/aboutUs.php'; ?>">About Us</a>
                        <a class=" active" href="<?php echo '/car-dealership-fullstack/App/views/pages/news.php'; ?>">News</a>
                        <a class=" active" href="<?php echo '/car-dealership-fullstack/App/views/pages/contact.php'; ?>">Contact</a>
                    </div>
            </nav>

        </div>

    </header>
