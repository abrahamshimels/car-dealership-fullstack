<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="./CSS/style.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body
    style="
      background-image: url(./Resource/Images/logIn.png);
      background-repeat: no-repeat;
      height: 600px;
      background-position: center;
      background-size: cover;
    "
  >
    <!-- start include the header.php -->
    <?php include('header.php'); ?>
    <!-- end include the header.php -->
    <header class="page-header other-page-header">
      <h1>Your Cart</h1>
    </header>
    <main>
      <p>Your selected items appear here.</p>
      <div class="cart-items">
        <?php
        include("database/CarList.php");
        // Start session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
        //check login
        if(!isset($_SESSION['username'])){
          header("Location: login.php?redirect=cart.php");
          exit();
        }
        // Initialize the cart session if it's not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = []; // Cart can be an array of item IDs
        }

        // Check if the 'id' and 'cartStatus' parameters are passed via GET
        if (isset($_GET['id']) && isset($_GET['cartStatus'])) {
            $id = $_GET['id'];
            $cartStatus = $_GET['cartStatus'];
            echo "id:".$id."<br>";
            echo "status:".$cartStatus."<br>";

            if ($cartStatus == "Add To Cart") {
              echo "cart is added";
              print_r($_SESSION);
                // Add item to the cart if not already in the cart
                if (!in_array($id, $_SESSION['cart'])) {
                    $_SESSION['cart'][] = $id;
                    echo "cart is added"."<br>";                    
                }
            } elseif ($cartStatus == "Remove From Cart") {
                    echo "cart is removed"."<br>";                    
                // Remove item from the cart if it exists
                if (($key = array_search($id, $_SESSION['cart'])) !== false) {
                    unset($_SESSION['cart'][$key]); // Remove the item
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
                }
            }

            // Redirect to avoid re-adding/removing the item on refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            
        }

        // Display cart items
        echo "<div class=\"model-header\"><h2 class=\"car_type\"></h2></div>";
        echo "<div class=\"models model-page-model\">";
        
        // Loop through each item in the cart and display the product details
        foreach ($_SESSION['cart'] as $cartId) {
            $stmt = $conn->prepare("SELECT id, name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id FROM cars WHERE id = ?");
            $stmt->bind_param("i", $cartId);
            $stmt->execute();
            $cartResult = $stmt->get_result();
            
            // Instantiate the CarList object and display the car information
            $carlist = new CarList();
            $carlist->displayCar($cartResult, "Remove From Cart");
        }
        
        echo "</div>";
        // session_destroy();
        ?>
      </div>
    </main>
    <script src="./JS/script.js"></script>
  </body>
</html>
