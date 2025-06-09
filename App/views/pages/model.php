<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Models</title>
    <link rel="shortcut icon" href="/car-dealership-fullstack/public/assets/Images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/car-dealership-fullstack/public/assets/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" >
</head>
<body>

    <!-- Include Header -->
    <?php 
    include(__DIR__.'/../layouts/header.php');

    //including car list

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
        $display->displayCarsByFuelType($cars,10);

    //Include Footer
    include(__DIR__.'/../layouts/footer.php'); 
    ?>
</body>
</html>