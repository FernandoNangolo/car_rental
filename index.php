<?php
include 'controllers/CarController.php';
include 'controllers/UserController.php';
include 'models/RentalHistory.php'; // Include RentalHistory model
include 'views/header.php';

session_start();

$username = $_SESSION['username'];
$isAdmin = UserController::isAdmin($username);
$userId = UserController::getUserId($username);
$logger = "";

$allCars = CarController::showAllCars();
$rentedCars = CarController::showRentedCars($isAdmin, $userId);

if (!$isAdmin) {
    // Fetch past rented cars using rental history
    $pastRentedCars = RentalHistory::getRentalHistoryByUserId($userId);
    $availableCars = CarController::showAvailableCars();
   
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'logout') {
        session_destroy();
        header('Location: login.php');
        exit();
    }

    // Handle other form submissions
    $currentTime = time();
    $lastFormSubmission = isset($_SESSION['last_form_submission']) ? $_SESSION['last_form_submission'] : 0;
    $submissionInterval = 1; // 5 seconds interval between submissions

    if (($currentTime - $lastFormSubmission) < $submissionInterval) {
        // Prevent form resubmission within 5 seconds
        $logger = "Form submission too soon. Please wait a moment before submitting again.";
    } else {
        $_SESSION['last_form_submission'] = $currentTime; // Update the last form submission time

        if (isset($_POST['rent_car_id'])) {
            $carId = $_POST['rent_car_id'];

            // Update car status to 'rented' and record in rental history
            CarController::updateCar($carId, null, null, 'rented', $userId);

            // Clean up variables
            unset($carId);
        } elseif (isset($_POST['release_car_id'])) {
            $carId = $_POST['release_car_id'];
            
            if ($isAdmin) {
                // If admin, get the original user ID who rented the car
                $rentalHistory = RentalHistory::getRentalHistory();
                if ($rentalHistory) {
                    $originalUserId = $rentalHistory[0]['user_id'];
                    if (CarController::updateCar($carId, null, null, 'available', null)) {
                        if(RentalHistory::addOrUpdateRental($carId, $originalUserId)){
                            unset($carId);
                        }
                    }
                }
            } else {
                // Normal user releasing their own rented car
                if (CarController::updateCar($carId, null, null, 'available', null)) {
                    RentalHistory::addOrUpdateRental($carId, $userId);
                }
            }

            // Clean up variables
            unset($carId, $rentalHistory, $originalUserId);
        } elseif (isset($_POST['delete_car_id'])) {
            $carId = $_POST['delete_car_id'];
            $deletedRows = CarController::deleteCar($carId);
            if ($deletedRows > 0) {
                $logger = "Car deleted successfully.";
                // Redirect or display success message as per your application flow.
            } else {
                $logger = "Failed to delete car.";
                // Handle error, maybe redirect back with an error message.
            }
        } elseif (isset($_POST['add_car'])) {
            // var_dump($_POST['manufacturer']);
            // Handle add new car request
            $manufacturer = $_POST['manufacturer'];
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $registrationPlate = $_POST['registration_plate'];
            $type = $_POST['type'];
            $fuelType = $_POST['fuel_type'];
            $transmission = $_POST['transmission'];
            $mileage = $_POST['mileage'];
            $description = $_POST['description'];
            $photo = $_FILES['photo']['name'];

            // Move uploaded file to the uploads directory
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($photo);
            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);

            
            // // Create the new car
            CarController::createCar($manufacturer, $brand, $model, $registrationPlate, $type, $fuelType, $transmission, $mileage, $description, $photo);
            
            
        }
    }

    // After handling form submission
    // unset($_SERVER['REQUEST_METHOD']);
    // unset($_SERVER['REQUEST_URI']);

    // Redirect to a different page
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}





include 'views/main.php';
include 'views/footer.php';
?>
