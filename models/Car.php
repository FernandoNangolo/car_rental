<?php
include_once 'core/Database.php';

class Car {

    public static function getAllCars() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cars");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllAvailable() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cars WHERE status = 'available'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRentedByUser($userId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cars WHERE rented_by = :userId AND status = 'rented'");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPastRentedByUser($userId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cars WHERE rented_by = :userId AND status = 'available'");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllRented() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT cars.*, users.username FROM cars JOIN users ON cars.rented_by = users.id WHERE status = 'rented'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateCar($carId, $brand = null, $model = null, $status = null, $rentedBy = null) {
        $conn = Database::getConnection();
        $query = "UPDATE cars SET ";
        $params = [];
        if ($brand !== null) {
            $query .= "brand = :brand, ";
            $params['brand'] = $brand;
        }
        if ($model !== null) {
            $query .= "model = :model, ";
            $params['model'] = $model;
        }
        if ($status !== null) {
            $query .= "status = :status, ";
            $params['status'] = $status;
        }
        if ($rentedBy !== null) {
            $query .= "rented_by = :rentedBy, ";
            $params['rentedBy'] = $rentedBy;
        }
        $query = rtrim($query, ', ') . " WHERE id = :carId";
        $params['carId'] = $carId;
        
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public static function deleteCar($carId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM cars WHERE id = :carId");
        $stmt->execute(['carId' => $carId]);
        
        return $stmt->rowCount();
    }
    
    public static function createCar($manufacturer, $brand, $model, $registrationPlate, $type, $fuelType, $transmission, $mileage, $description, $photo) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO cars (manufacturer, brand, model, registration_plate, type, fuel_type, transmission, mileage, description, photo, status) 
            VALUES (:manufacturer, :brand, :model, :registrationPlate, :type, :fuelType, :transmission, :mileage, :description, :photo, 'available')
        ");
        
        $stmt->execute([
            'manufacturer' => $manufacturer,
            'brand' => $brand,
            'model' => $model,
            'registrationPlate' => $registrationPlate,
            'type' => $type,
            'fuelType' => $fuelType,
            'transmission' => $transmission,
            'mileage' => $mileage,
            'description' => $description,
            'photo' => $photo
        ]);
        
        return $stmt->rowCount();
    }


    
}
?>
