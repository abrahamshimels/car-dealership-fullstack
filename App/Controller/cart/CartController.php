<?php
class CartController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = []; //show cart can be array
        }
    }

    public function cartCounter() {
        $cartNo = count($_SESSION['cart']);
        return $cartNo;
    }
}
?>
