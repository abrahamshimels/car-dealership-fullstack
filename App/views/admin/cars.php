<?php
    require_once(__DIR__ . '/../../service/CarApiService.php');
    if (class_exists('\App\Service\CarApiService')) { 
        $get = new \App\Service\CarApiService();
        $cars = $get->getAll();
        // print_r($cars);
    } else {
        echo 'CarApiService class not found. Please check the file path, class name, and namespace.';
        $cars = [];
    }

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['car_id']))
{
    function deleteCar($carId) {
        $url = "http://localhost/car-dealership-fullstack/public/api/cars/" . urlencode($carId);
        
        $headers = [
            'Content-Type: application/json'
        ];
    
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_TIMEOUT => 10
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
    
        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }
    
        $responseData = json_decode($response, true);
        
        // Handle response based on status code
        switch ($httpCode) {
            case 200:
            case 204:
                return [
                    'success' => true,
                    'message' => 'Car deleted successfully',
                    'data' => $responseData
                ];
            case 401:
                throw new Exception("Unauthorized - Check your API");
            case 404:
                throw new Exception("Car not found");
            default:
                throw new Exception("Unexpected response: HTTP $httpCode - " . ($responseData['message'] ?? ''));
        }
    }
    
    try {
        $carIdToDelete = $_POST['car_id'];
        $result = deleteCar($carIdToDelete);
        echo "<div class='alert alert-success'>Success: " . htmlspecialchars($result['message']) . "</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .car-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .car-table thead {
            background: #2c3e50;
            color: white;
        }
        
        .car-table th {
            font-weight: 600;
            padding: 1.2rem;
        }
        
        .car-table td {
            vertical-align: middle;
            padding: 1.2rem;
        }
        
        .car-image {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .price-badge {
            background: #27ae60;
            padding: 5px 12px;
            border-radius: 20px;
            color: white;
            font-weight: 500;
        }
        
        .discount-badge {
            background: #e74c3c;
            color: white;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 0.85em;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9em;
        }
        
        .available { background: #2ecc71; color: white; }
        .reserved { background: #f39c12; color: white; }
        .sold { background: #95a5a6; color: white; }
        
        .action-btn {
            transition: all 0.3s ease;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>


<div class="container my-4">
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <form action="./cars.php" method="POST" class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <input type="text" name="car_id" class="form-control" placeholder="Enter Car ID to Delete" required>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Delete Car
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="/car-dealership-fullstack/App/views/layouts/uploadCar.php" class="btn btn-success btn-lg text-decoration-none">
                <i class="fas fa-plus-circle me-2"></i> Add  Car
            </a>
        </div>
    </div>
</div>
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Car Name</th>
                        <th>Model</th>
                        <th>Fuel Type</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                    <tr>
                    <td>
                            <?= ucfirst(htmlspecialchars($car['id'])) ?>
                        </td>                       
                        <td>
                            
                            <img src="/car-dealership-fullstack/<?= htmlspecialchars($car['imageUrl']) ?>" 
                                 alt="<?= htmlspecialchars($car['name']) ?>" 
                                 class="car-image">
                        </td>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($car['name']) ?></div>
                            <div class="text-muted small"><?= substr(htmlspecialchars($car['descriptions']), 0, 40) ?>...</div>
                        </td>
                        <td><?= htmlspecialchars($car['model'] ?? 'N/A') ?></td>
                        <td>
                            <?= ucfirst(htmlspecialchars($car['fuelType'])) ?>
                        </td>
                        <td>
                            <div class="price-badge">
                                $<?= number_format($car['price'], 2) ?>
                            </div>
                            <?php if ($car['previousPrice'] > 0): ?>
                            <div class="text-muted text-decoration-line-through small mt-1">
                                $<?= number_format($car['previousPrice'], 2) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($car['discount'] != 0): ?>
                            <div class="discount-badge">
                                <?= number_format(abs($car['discount']), 0) ?>%
                                <?= $car['discount'] > 0 ? 'OFF' : 'MARKUP' ?>
                            </div>
                            <?php else: ?>
                            <span class="badge bg-secondary">No Discount</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge <?= htmlspecialchars($car['status']) ?>">
                                <?= ucfirst(htmlspecialchars($car['status'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- hi develop  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>