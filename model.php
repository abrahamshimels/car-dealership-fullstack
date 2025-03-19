<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Models</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>

    <!-- Include Header -->
    <?php 
    include('header.php');
    //including car list
    include('database/CarList.php');
    // Creating an instance of CarList and displaying cars by fuel type
    $cl = new CarList();
    $cl->displayCarsByFuelType($conn, 10);
    //Include Footer
    include('footer.php'); 
    ?>
</body>
</html>