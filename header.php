    <!-- header -->

    <header>
            <nav class="header-nav">
                <div class="logo-wrapper">
                    <img src="./Resource/Images/logo.png" alt="logo" width="50">G3
                </div>
                <a class=" active " href="./index.php" >Home</a>
                <a class=" active" href="./model.php" class="small-hidden">Models</a>

                <a class=" active" href="./service.php" class="small-hidden">Services</a>
                <a class=" active" href="./aboutUs.php" class="small-hidden">About Us</a>
                <a class=" active" href="./news.php" class="small-hidden">News</a>
                <a class=" active" href="./contact.php" class="small-hidden">Contact</a>
                <a class=" active" href="./cart.php"><i class="fas fa-shopping-cart"></i>cart
                    
                        <?php 
                        include('Template/CartItem.php');
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
                //require functions.php file
                require('functions.php');
                ?>
                <div class="dropdown small-block">
                    <i class="fas fa-bars menu-icon"></i>
                    <div class="dropdown-content">
                        <a class=" active" href="./model.php">Models</a>
                        <a class=" active" href="./service.php">Services</a>
                        <a class=" active" href="./aboutUs.php">About Us</a>
                        <a class=" active" href="./news.php">News</a>
                        <a class=" active" href="./contact.php">Contact</a>
                    </div>
            </nav>

        </div>

    </header>
