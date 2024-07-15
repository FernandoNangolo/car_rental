<?php
include_once 'models/Car.php';

class CarController {

    public static function showAllCars() {
        return Car::getAllCars();
    } 

    public static function showAvailableCars() {
        return Car::getAllAvailable();
    }

    public static function showRentedCars($isAdmin, $userId = null) {
        if ($isAdmin) {
            return Car::getAllRented();
        } else {
            return Car::getRentedByUser($userId);
        }
    }

    public static function showPastRentedCars($userId) {
        return Car::getPastRentedByUser($userId);
    }

    public static function updateCar($carId, $brand = null, $model = null, $status = null, $rentedBy = null) {
        return Car::updateCar($carId, $brand, $model, $status, $rentedBy);
    }

    public static function deleteCar($carId) {
        return Car::deleteCar($carId);
    }

    public static function createCar($manufacturer, $brand, $model, $registrationPlate, $type, $fuelType, $transmission, $mileage, $description, $photo) {
        return Car::createCar($manufacturer, $brand, $model, $registrationPlate, $type, $fuelType, $transmission, $mileage, $description, $photo);
    }
}
?>
