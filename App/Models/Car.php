<?php

namespace App\Models;
include_once __DIR__.'/../../Core/Database.php';
use App\Core\Database;
use mysqli;

class Car
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }



    public function getFuelTypes(): array
    {
        return ['electric', 'petrol', 'hybrid'];
    }

    public function getCarsByFuelType(string $fuelType, int $limit): array
    {
        $stmt = $this->db->prepare(
            "SELECT id, name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id 
             FROM cars 
             WHERE fuelType = ? 
             LIMIT ?"
        );

        $stmt->bind_param("si", $fuelType, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllGroupedByFuelType(int $limitPerType = 5): array
    {
        $grouped = [];
        foreach ($this->getFuelTypes() as $fuelType) {
            $grouped[$fuelType] = $this->getCarsByFuelType($fuelType, $limitPerType);
        }
        return $grouped;
    }


public function getAllCars(): array
{
    $stmt = $this->db->prepare(
        "SELECT id, name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id FROM cars"
    );
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getCarById($id): ?array
{
    $stmt = $this->db->prepare(
        "SELECT id, name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id FROM cars WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    return $car ?: null;
}

public function createCar($data)
{
    $stmt = $this->db->prepare(
        "INSERT INTO cars (name, price, discount, previousPrice, rate, imageUrl, model, descriptions, fuelType, status, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sdddsdsssssi",
        $data['name'],
        $data['price'],
        $data['discount'],
        $data['previousPrice'],
        $data['rate'],
        $data['imageUrl'],
        $data['model'],
        $data['descriptions'],
        $data['fuelType'],
        $data['status'],
        $data['seller_id']
    );
    $stmt->execute();
    return $this->db->insert_id;
}

public function updateCar($id, $data)
{
    $stmt = $this->db->prepare(
        "UPDATE cars SET name=?, price=?, discount=?, previousPrice=?, rate=?, imageUrl=?, model=?, descriptions=?, fuelType=?, status=?, seller_id=? WHERE id=?"
    );
    $stmt->bind_param(
        "sdddsdsssssi",
        $data['name'],
        $data['price'],
        $data['discount'],
        $data['previousPrice'],
        $data['rate'],
        $data['imageUrl'],
        $data['model'],
        $data['descriptions'],
        $data['fuelType'],
        $data['status'],
        $data['seller_id'],
        $id
    );
    return $stmt->execute();
}

public function deleteCar($id)
{
    $stmt = $this->db->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

}



// $car = new Car();
// header("Content-Type: application/json");
// // print_r($car->getAllcar());
// echo json_encode($car->getAllCars());

?>