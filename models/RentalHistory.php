<?php
include_once 'core/Database.php';

class RentalHistory {
    public static function addOrUpdateRental($carId, $userId) {
        $conn = Database::getConnection();

        // Check if user has an active rental for the same car
        $stmt = $conn->prepare("SELECT * FROM rental_history WHERE car_id = :carId AND user_id = :userId");
        $stmt->execute(['carId' => $carId, 'userId' => $userId]);
        $existingRental = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($existingRental) {
            // Update existing rental's rental date to the current timestamp
            $stmt = $conn->prepare("UPDATE rental_history SET rental_date = NOW() WHERE car_id = :carId AND user_id = :userId");
            $stmt->execute(['carId' => $carId, 'userId' => $userId]);
        } else {
            // Add new rental
            $stmt = $conn->prepare("INSERT INTO rental_history (car_id, user_id, rental_date) VALUES (:carId, :userId, NOW())");
            $stmt->execute(['carId' => $carId, 'userId' => $userId]);
        }

        return true;
    }

    public static function updateReturnDate($carId, $userId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE rental_history SET return_date = NOW() WHERE car_id = :carId AND user_id = :userId AND return_date IS NULL");
        $stmt->execute(['carId' => $carId, 'userId' => $userId]);
        return $stmt->rowCount() > 0;
    }

    public static function getRentalHistoryByUserId($userId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT rental_history.*, 
                                       cars.brand, 
                                       cars.model, 
                                       cars.registration_plate,
                                       cars.manufacturer,
                                       cars.type,
                                       cars.fuel_type,
                                       cars.transmission,
                                       cars.mileage,
                                       cars.description,
                                       cars.photo
                                FROM rental_history
                                JOIN cars ON rental_history.car_id = cars.id
                                WHERE rental_history.user_id = :userId
                                ORDER BY rental_history.rental_date DESC");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRentalHistory() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT rental_history.*, cars.brand, cars.model, cars.registration_plate
                               FROM rental_history
                               JOIN cars ON rental_history.car_id = cars.id
                               WHERE rental_history.car_id = cars.id
                               ORDER BY rental_history.rental_date DESC");
        $stmt->execute(['carId' => $carId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public static function getRentalHistoryByCarId($carId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT rental_history.*, cars.brand, cars.model, cars.registration_plate
                               FROM rental_history
                               JOIN cars ON rental_history.car_id = cars.id
                               WHERE rental_history.car_id = :carId
                               ORDER BY rental_history.rental_date DESC");
        $stmt->execute(['carId' => $carId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateReturnDateByCarAndUser($carId, $userId) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE rental_history SET return_date = NOW()
                               WHERE car_id = :carId AND user_id = :userId AND return_date IS NULL");
        $stmt->execute(['carId' => $carId, 'userId' => $userId]);
        return $stmt->rowCount() > 0;
    }
}
?>
