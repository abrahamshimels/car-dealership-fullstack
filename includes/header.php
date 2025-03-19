    <!-- header -->

    <header>
            <nav class="header-nav">
                <div class="logo-wrapper">
                    <img src="./Resource/Images/logo.png" alt="logo" width="50">G3
                </div>
                <a class=" active " href="./index.php" >Home</a>
                <a class=" active" href="./public/model.php" class="small-hidden">Models</a>

                <a class=" active" href="./public/service.php" class="small-hidden">Services</a>
                <a class=" active" href="./public/aboutUs.php" class="small-hidden">About Us</a>
                <a class=" active" href="./public/news.php" class="small-hidden">News</a>
                <a class=" active" href="./public/contact.php" class="small-hidden">Contact</a>
                <a class=" active" href="./public/cart.php"><i class="fas fa-shopping-cart"></i>cart
                    
                        <?php 
                        include('../Template/CartItem.php');
                        $ci=new CartItem();
                        $cartNumber=$ci->cartCounter();
                        echo '<div class="cart-number">'.$cartNumber.'</div>';
                        ?>
                </a>
                <?php if(isset($_SESSION['username'])){
                    echo '<a class=" active" href="./logout.php" class="small-hidden"><i class="fas fa-sign-out-alt"></i> Logout</a>';
                }else{
                    echo '<a class=" active" href="./login.php" class="small-hidden">Log in <i class="fas fa-sign-in-alt"></i></a>';
                }
                ?>
                <?php 
                //database connection
                require('../database/DBController.php');
                $db = new DBController();
                ?>
                <div class="dropdown small-block">
                    <i class="fas fa-bars menu-icon"></i>
                    <div class="dropdown-content">
                        <a class=" active" href="./public/model.php">Models</a>
                        <a class=" active" href="./public/service.php">Services</a>
                        <a class=" active" href="./public/aboutUs.php">About Us</a>
                        <a class=" active" href="./public/news.php">News</a>
                        <a class=" active" href="./public/contact.php">Contact</a>
                    </div>
            </nav>

        </div>

    </header>
