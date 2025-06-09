<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G3 car dealership website</title>
    <link rel="shortcut icon" href="/car-dealership-fullstack/public/assets/Images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/car-dealership-fullstack/public/assets/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" >
</head>

<body>
    <!-- start include the header.php -->
    <?php  include(__DIR__ . '/../layouts/header.php'); ?>
    <!-- end include the header.php -->

    <!-- start include the banner.php -->
    <?php include(__DIR__ . '/../layouts/_banner.php') ?>
    <!-- end include the banner.php -->

    <!-- start include the model.php -->
    <?php 


    require_once(__DIR__ . '/../../service/CarApiService.php');
    if (class_exists('\App\Service\CarApiService')) { 
        $get = new \App\Service\CarApiService();
        $cars = $get->getAll();
    } else {
        echo 'CarApiService class not found. Please check the file path, class name, and namespace.';
        $cars = [];
    }

        require_once(__DIR__ . '/../layouts/CarDisplay.php');
        $display = new \App\views\layouts\CarDisplay();
        $display->displayCarsByFuelType($cars,3);
    if ($cars && is_array($cars)) {
        // echo '<pre>';
        // print_r($cars);
        // echo '</pre>';
    } else {
        echo 'No cars found or an error occurred.';
    }

    
    ?>
    <!-- end include the model.php -->

    <!-- start include the sell.php -->
    <?php include(__DIR__ . '/../layouts/_sell.php') ?>
    <!-- end include the sell.php -->

    <!-- start include the testimonials.php -->
    <?php include(__DIR__ . '/../layouts/_testimonials.php') ?>
    <!-- end include the testimonials.php -->

    <!-- start include the partner.php -->
    <?php include(__DIR__ . '/../layouts/_partner.php') ?>
    <!-- end include the partner.php -->

    <!-- start include the gallery.php -->
    <?php include(__DIR__ . '/../layouts/_gallery.php') ?>
    <!-- end include the gallery.php -->

    <!-- start include the discuss.php -->
    <?php include(__DIR__ . '/../layouts/_discuss.php') ?>
    <!-- end include the discuss.php -->
    
    <!-- start include the footer.php -->
    <?php include(__DIR__ . '/../layouts/footer.php')   ?>
    <!-- end include the footer.php -->

    <script src="./JS/script.js"></script>
</body>
</html>