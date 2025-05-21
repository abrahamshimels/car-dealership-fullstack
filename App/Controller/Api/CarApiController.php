<?php

// include_once __DIR__.'/../Core/Database.php';
// use App\Core\Database;

namespace App\Controller\Api;

include_once __DIR__.'/../../Models/Car.php';
use App\Models\Car;

class CarApiController
{
    protected $carModel;

    public function __construct()
    {
        // Assuming Car model handles DB connection and queries
        $this->carModel = new Car();
    }

    // GET /api/cars - list all cars
    public function index()
    {
        $cars = $this->carModel->getAllCars();
        $this->respondJson($cars);
    }

    // GET /api/cars/{id} - get one car by id
    public function show($id)
    {
        $car = $this->carModel->getCarById($id);
        if (!$car) {
            $this->respondJson(['error' => 'Car not found'], 404);
            return;
        }
        $this->respondJson($car);
    }

    // POST /api/cars - create new car
    public function store()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input['make']) || empty($input['model'])) {
            $this->respondJson(['error' => 'Invalid input'], 400);
            return;
        }

        $created = $this->carModel->createCar($input);
        if ($created) {
            $this->respondJson(['message' => 'Car created successfully'], 201);
        } else {
            $this->respondJson(['error' => 'Failed to create car'], 500);
        }
    }

    // PUT /api/cars/{id} - update car
    public function update($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            $this->respondJson(['error' => 'Invalid input'], 400);
            return;
        }

        $updated = $this->carModel->updateCar($id, $input);
        if ($updated) {
            $this->respondJson(['message' => 'Car updated successfully']);
        } else {
            $this->respondJson(['error' => 'Failed to update car'], 500);
        }
    }

    // DELETE /api/cars/{id} - delete car
    public function delete($id)
    {
        $deleted = $this->carModel->deleteCar($id);
        if ($deleted) {
            $this->respondJson(['message' => 'Car deleted successfully']);
        } else {
            $this->respondJson(['error' => 'Failed to delete car'], 500);
        }
    }

    // Helper to send JSON response with status code
    private function respondJson($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }



}

// $nw = new CarApiController();
// $nw->index();


?>