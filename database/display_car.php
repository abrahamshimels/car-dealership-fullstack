<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET" action="">
    <label for="fuelType">Fuel Type:</label>
    <select name="fuelType" id="fuelType">
        <option value="">All</option>
        <option value="petrol">Petrol</option>
        <option value="diesel">Diesel</option>
        <option value="electric">Electric</option>
        <option value="hybrid">Hybrid</option>
    </select>

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">All</option>
        <option value="available">Available</option>
        <option value="sold">Sold</option>
        <option value="reserved">Reserved</option>
    </select>

    <label for="model">Model:</label>
    <input type="text" name="model" id="model" placeholder="Enter model name">

    <button type="submit">Filter</button>
</form>
<!-- php -->
<?php

include_once('DBController.php');// Database connection
$db=new DBController();
$conn = $db->getConnection();
// Retrieve filter inputs
$fuelType = isset($_GET['fuelType']) ? $_GET['fuelType'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';

// Construct SQL query with filters
$query = "SELECT * FROM cars WHERE 1";

if ($fuelType !== '') {
    $query .= " AND fuelType = '$fuelType'";
}
if ($status !== '') {
    $query .= " AND status = '$status'";
}
if ($model !== '') {
    $query .= " AND model LIKE '%$model%'";
}

$result = $conn->query($query);
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Previous Price</th>
        <th>Discount</th>
        <th>Fuel Type</th>
        <th>Status</th>
        <th>Model</th>
        <th>Seller ID</th>
        <th>Register Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><img src="<?= $row['imageUrl']; ?>" width="100"></td>
            <td><?= $row['name']; ?></td>
            <td>$<?= $row['price']; ?></td>
            <td>$<?= $row['previousPrice'] ? $row['previousPrice'] : 'N/A'; ?></td>
            <td><?= $row['discount']; ?>%</td>
            <td><?= ucfirst($row['fuelType']); ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td><?= $row['model']; ?></td>
            <td><?= $row['seller_id'] ? $row['seller_id'] : 'Unknown'; ?></td>
            <td><?= $row['registerDate']; ?></td>
        </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
