<?php 
include('Cars.php');

class CarList {

    // Array of car types
    public function getFuelTypes() {
        return array('electric', 'petrol', 'hybrid');
    }

    // Display cars by fuel type
    public function displayCarsByFuelType($conn, $limit) {
        $fuelTypes = $this->getFuelTypes();
        foreach ($fuelTypes as $type) {
            echo "<div class=\"model-header\"><h2 class=\"car_type\">$type</h2></div>";
            echo "<div class=\"models model-page-model\">";
            $cart="Add To Cart";
            $this->displayCar($this->getCarsByFuelType($conn, $type, $limit),$cart);
            echo "</div>";
        }
    }

    // Function to fetch cars by fuel type
    private function getCarsByFuelType($conn, $fuelType, $limit) {
        
        $stmt = $conn->prepare("SELECT id, name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id FROM cars WHERE fuelType = ? LIMIT ?");
        
        // Bind the parameters to the query
        $stmt->bind_param("si", $fuelType, $limit);
        $stmt->execute();
        
        return $stmt->get_result();
    }

    // Function to display cars
    public function displayCar($result,$cart) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <div class="car-list model-page-car-list">
                    <img src="<?= $row['imageUrl']; ?>" alt="<?= $row['name']; ?>">
                    <div class="pentagon"><p><?= $row['discount']; ?>%</p></div>
                    <div class="car-description">
                        <p class="model-price"><s>$<?= $row['previousPrice']; ?></s> $<?= $row['price']; ?></p>
                        <p class="rating">
                            <?= str_repeat("<span>★</span>", (int)$row['rate']); ?>
                        </p>
                    </div>
                    <div class="car-list-hover">
                        <div class="car-list-hover-cart" >
                            <?php 
                                $id = $row['id'];
                                $cartStatus = $cart;
                                $url = './cart.php?id=' . urlencode($id) . '&cartStatus=' . urlencode($cartStatus);
                                echo '<a href="' . $url . '"><i class="fa-solid fa-shopping-cart car-list-cart cart-icon">' . $cartStatus . '</i></a>';
                            ?>

                        </div>
                        <div class="car-list-hover-cart">
                            <a href="./contact.php"><i class="fa-solid fas fa-headset car-list-contact"> Contact Seller</i></a>
                        </div>
                        <div class="car-list-details">
                            <a href="https://www.instagram.com/accounts/login/"><i class="fa-brands fa-instagram social-icon instagram-icon"></i></a>
                            <a href="https://web.facebook.com/?_rdc=1&_rdr"><i class="fa-brands fa-facebook social-icon facebook"></i></a>
                            <a href="https://x.com/" target="_blank"><i class="fa-brands fa-twitter social-icon x"></i></a>
                        </div>
                    </div>
                    <div class="car-item" data-id="<?= $row['id']; ?>" data-name="<?= $row['name']; ?>" data-price="<?= $row['price']; ?>">
                        <h3><?= $row['name']; ?></h3>
                    </div>
                </div>
            <?php }
        } else {
            echo "<p>No cars found in this category.</p>";
        }
    }
}
?>
