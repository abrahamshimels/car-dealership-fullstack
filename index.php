<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G3 car dealership website</title>
    <link rel="shortcut icon" href="./Resource/Images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" >
</head>

<body>

    <!-- start include the header.php -->
    <?php  include('header.php') ?>
    <!-- end include the header.php -->

    <!-- start include the banner.php -->
    <?php include('Template/_banner.php') ?>
    <!-- end include the banner.php -->

    <!-- start include the search.php -->
    <?php include('Template/_search.php') ?>
    <!-- end include the search.php -->

    <!-- start include the model.php -->
    <?php 

    // Creating an instance of CarList and displaying cars by fuel type
    include('database/CarList.php');
    $cl = new CarList();
    $cl->displayCarsByFuelType($conn, 3);

    
    ?>
    <!-- end include the model.php -->

    <!-- start include the sell.php -->
    <?php include('Template/_sell.php') ?>
    <!-- end include the sell.php -->

    <!-- start include the testimonials.php -->
    <?php include('Template/_testimonials.php') ?>
    <!-- end include the testimonials.php -->

    <!-- start include the partner.php -->
    <?php include('Template/_partner.php') ?>
    <!-- end include the partner.php -->

    <!-- start include the gallery.php -->
    <?php include('Template/_gallery.php') ?>
    <!-- end include the gallery.php -->

    <!-- start include the discuss.php -->
    <?php include('Template/_discuss.php') ?>
    <!-- end include the discuss.php -->
    
    <!-- start include the footer.php -->
    <?php include('footer.php')  ?>
    <!-- end include the footer.php -->

    <script src="./JS/script.js"></script>
</body>
</html>