<?php 
namespace App\views\layouts;

class CarDisplay {

        

    // Array of car types
    public function getFuelTypes() {
        return array('electric', 'petrol', 'hybrid');
    }

    // Display cars by fuel type
    public function displayCarsByFuelType( $data,$limit) {
        $fuelTypes = $this->getFuelTypes();
        foreach ($fuelTypes as $type) {
            echo "<div class=\"model-header\"><h2 class=\"car_type\">$type</h2></div>";
            echo "<div class=\"models model-page-model\">";
            $cart="Add To Cart";
            $this->displayCar($this->getCarsByFuelType( $data,$type, $limit),$cart);
            echo "</div>";
        }
    }

    // Function to fetch cars by fuel type
    private function getCarsByFuelType($data,$fuelType, $limit) {
        $carsArray = $data;
    
        $filteredCars = array_filter($carsArray, function($car) use ($fuelType) {
            return strtolower($car['fuelType']) === strtolower($fuelType);
        });
    
        return array_slice(array_values($filteredCars), 0, $limit);
    }

    // Function to display cars
    public function displayCar($result,$cart) {
        if (!empty($result) && is_array($result)) {
            foreach ($result as $row) { ?>
                <div class="car-list model-page-car-list">
                    <img src="/car-dealership-fullstack/<?= htmlspecialchars($row['imageUrl']) ?>" alt="<?= htmlspecialchars($row['name']); ?>">
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
                                $url = '/car-dealership-fullstack/App/views/pages/cart.php?id=' . urlencode($id) . '&cartStatus=' . urlencode($cartStatus);
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

    // $display = new CarDisplay();
    // $display->displayCarsByFuelType($data,10);

?>
