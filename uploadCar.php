<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Car</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <?php include("header.php") ?>
    <h2>Upload New Car</h2>
    <div class="sign-up-container upload-form-wrapper">
    <form action="uploadCar.php" method="POST" enctype="multipart/form-data" class="sign-up-form upload-form">
        <label for="name">Car Name:</label><br>
        <input type="text" id="name" name="name" required placeholder="Car name"><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required placeholder="Enter price"><br><br>

        <label for="discount">Discount:</label><br>
        <input type="number" id="discount" name="discount" step="0.01" placeHolder="enter in Percent"><br><br>

        <label for="previousPrice">Previous Price:</label><br>
        <input type="number" id="previousPrice" name="previousPrice" step="0.01" placeholder="Enter previous price"><br><br>

        <label for="rate">Rate (1 to 5):</label><br>
        <input type="number" id="rate" name="rate" step="0.01" min="1" max="5"  required placeholder="Rate"><br><br>

        <label for="imageUrl">Car Image :</label><br>
        <input type="file" id="imageUrl" name="imageUrl" required><br><br>

        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model" placeholder="Enter Model"><br><br>

        <label for="descriptions">Description:</label><br>
        <textarea id="descriptions" name="descriptions" rows="4" placeholder="Description ..."></textarea><br><br>

        <label for="fuelType">Fuel Type:</label><br>
        <select id="fuelType" name="fuelType" required>
            <option value="engine">Petrol</option>
            <option value="electric">Electric</option>
            <option value="hybrid" selected>Hybrid</option>
        </select><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="sold">Sold</option>
            <option value="reserved">Reserved</option>
        </select><br><br>

        <label for="seller_id">Seller ID:</label><br>
        <input type="number" id="seller_id" name="seller_id" value=1 required><br><br>

        <input type="submit" value="Upload Car">
    </form>
    </div>
    
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    // Collect form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $previousPrice = $_POST['previousPrice'];
    $rate = $_POST['rate'];
    $model = $_POST['model'];
    $descriptions = $_POST['descriptions'];
    $fuelType = $_POST['fuelType'];
    $status = $_POST['status'];
    $seller_id = $_POST['seller_id'];

    // Image upload processing
    if (isset($_FILES['imageUrl'])) {
        // Define upload directory
        $uploadDir = "uploadFile/";

        // Get file details
        $fileName = $_FILES['imageUrl']['name'];
        $fileSize = $_FILES['imageUrl']['size'];
        $tempName = $_FILES['imageUrl']['tmp_name'];
        $fileError = $_FILES['imageUrl']['error'];

        // Extract file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedExts = ["jpg", "jpeg", "png", "gif", "webp"];

        // Max file size (2MB)
        $maxFileSize = 2 * 1024 * 1024; 

        // Unique file name with user IP
        $userIP = $_SERVER['REMOTE_ADDR'];
        if ($userIP == "::1") {
            $userIP = "127.0.0.1";
        }

        // Replace colons (":") in IPv6 addresses with underscores
        $userIP = str_replace(":", "_", $userIP);
        $newFileName = uniqid("img_", true).$userIP;
        // $targetFile = $uploadDir . $newFileName;
        $targetFile = $uploadDir . basename($name) .$newFileName. '.' . $fileExt;


        // Error handling & validation
        if ($fileError !== UPLOAD_ERR_OK) {
            echo "File upload error: " . $fileError;
        } elseif (!in_array($fileExt, $allowedExts)) {
            echo "Invalid file type! Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
        } elseif ($fileSize > $maxFileSize) {
            echo " Maximum file size exceeded! (2MB limit)";
        } elseif (file_exists($targetFile)) {
            echo "The file already exists. Please try again.";
        } elseif (move_uploaded_file($tempName, $targetFile)) {
            echo "File uploaded successfully! <br>";
            echo "<b>File Name:</b> $newFileName <br>";
            echo "<b>File Size:</b> " . round($fileSize / 1024, 2) . " KB<br>";
            echo "<b>File Type:</b> $fileExt <br>";
            echo "<b>Stored Path:</b> <a href='$targetFile' target='_blank'>$targetFile</a>";
        } else {
            echo " Failed to upload file.";
        }
    } else {
        echo " No file uploaded.";
    }

    // Store image URL in the database
    $imageUrl = isset($targetFile) ? $targetFile : '';

    // Database insertion (using prepared statements)
    try {
        include('database/Cars.php');
        $stmt = $conn->prepare("INSERT INTO cars (name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddddsssssi", $name, $price, $discount, $previousPrice, $rate, $imageUrl, $model, $descriptions, $fuelType, $status, $seller_id);
        $stmt->execute();
        echo " Data entered successfully!";
    } catch (mysqli_sql_exception $e) {
        echo " Failed to insert data: " . $e->getMessage();
    }
}
?>
