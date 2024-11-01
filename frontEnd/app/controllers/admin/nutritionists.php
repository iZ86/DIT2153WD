<?php
require '../../views/admin/pages/AdminNutritionistsView.php';
require '../../models/admin/AdminNutritionistsModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminNutritionistsModel = new AdminNutritionistsModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addNutritionistButton']) && $_POST['addNutritionistButton'] === "Add Nutritionist") {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $gender = trim($_POST['gender']);
        $phoneNo = trim($_POST['phoneNo']);
        $email = trim($_POST['email']);
        $type = trim($_POST['type']);
        $imagePath = '';

        if (!empty($_FILES['nutritionistsImages']['name'])) {
            $targetDir = "../../public/images/nutritionistsImages/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['nutritionistsImages']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['nutritionistsImages']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            if (move_uploaded_file($_FILES['nutritionistsImages']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($type)) {
            $adminNutritionistsModel->addNutritionist($firstName, $lastName, $gender, $phoneNo, $email, $type, $imagePath);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Please fill in all required fields.";
        }
    }

    if (isset($_POST['editNutritionistButton'])) {
        $nutritionistID = $_POST['nutritionistID'];
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $gender = trim($_POST['gender']);
        $phoneNo = trim($_POST['phoneNo']);
        $email = trim($_POST['email']);
        $type = trim($_POST['type']);
        $imagePath = '';

        if (!empty($_FILES['nutritionistsImages']['name'])) {
            $targetDir = "../../public/images/nutritionistsImages/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['nutritionistsImages']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['nutritionistsImages']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            if (move_uploaded_file($_FILES['nutritionistsImages']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($type)) {
            $adminNutritionistsModel->editNutritionist($nutritionistID, $firstName, $lastName, $gender, $phoneNo, $email, $type, $imagePath);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Please fill in all required fields.";
        }
    }

    if (isset($_POST['deleteNutritionistButton'])) {
        $nutritionistID = $_POST['nutritionistID'];
        $adminNutritionistsModel->deleteNutritionist($nutritionistID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['addScheduleButton']) && $_POST['addScheduleButton'] === "Add Schedule") {
        $nutritionistID = $_POST['nutritionistID'];
        $scheduleDateTime = $_POST['scheduleDateTime'];
        $price = $_POST['price'];

        if (!empty($nutritionistID) && !empty($scheduleDateTime) && !empty($price)) {
            try {
                $adminNutritionistsModel->addSchedule($nutritionistID, $scheduleDateTime, $price);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } catch (Exception $e) {
                error_log("Error adding schedule: " . $e->getMessage());
            }
        } else {
            error_log("Missing data for adding schedule.");
        }
    }

    if (isset($_POST['editScheduleButton'])) {
        $nutritionistScheduleID = $_POST['nutritionistScheduleID'];
        $nutritionistID = $_POST['nutritionistID'];
        $scheduleDateTime = $_POST['scheduleDateTime'];
        $price = $_POST['price'];

        if (!empty($nutritionistScheduleID) && !empty($nutritionistID) && !empty($scheduleDateTime) && !empty($price)) {
            $adminNutritionistsModel->editSchedule($nutritionistScheduleID, $nutritionistID, $scheduleDateTime, $price);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['addBookingButton']) && $_POST['addBookingButton'] === "Add Booking") {
        $description = trim($_POST['description']);
        $nutritionistScheduleID = $_POST['nutritionistScheduleID'];
        $userID = $_SESSION['userID'];
        $paymentID = $_POST['paymentID'];

        if (!empty($description) && !empty($nutritionistScheduleID) && !empty($userID) && !empty($paymentID)) {
            $adminNutritionistsModel->addBooking($description, $nutritionistScheduleID, $userID, $paymentID);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$limit = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$nutritionistFilterType = isset($_GET['nutritionistFilterType']) ? $_GET['nutritionistFilterType'] : '';
$nutritionistKeywords = isset($_GET['nutritionistKeywords']) ? $_GET['nutritionistKeywords'] : '';

if (!empty($nutritionistFilterType) && !empty($nutritionistKeywords)) {
    $nutritionists = $adminNutritionistsModel->getFilteredNutritionists($limit, $offset, $nutritionistFilterType, $nutritionistKeywords);
} else {
    $nutritionists = $adminNutritionistsModel->getNutritionists($limit, $offset);
}

$noNutritionistsFound = $nutritionists->num_rows === 0;

$scheduleFilterType = isset($_GET['scheduleFilterType']) ? $_GET['scheduleFilterType'] : '';
$scheduleKeywords = isset($_GET['scheduleKeywords']) ? $_GET['scheduleKeywords'] : '';

if (!empty($scheduleFilterType) && !empty($scheduleKeywords)) {
    $schedules = $adminNutritionistsModel->getFilteredSchedules($limit, $offset, $scheduleFilterType, $scheduleKeywords);
} else {
    $schedules = $adminNutritionistsModel->getSchedules($limit, $offset);
}

$bookingFilterType = isset($_GET['bookingFilterType']) ? $_GET['bookingFilterType'] : '';
$bookingKeywords = isset($_GET['bookingKeywords']) ? $_GET['bookingKeywords'] : '';

if (!empty($bookingFilterType) && !empty($bookingKeywords)) {
    $bookings = $adminNutritionistsModel->getFilteredBookings($limit, $offset, $bookingFilterType, $bookingKeywords);
} else {
    $bookings = $adminNutritionistsModel->getBookingsWithDetails($limit, $offset);
}

$noNutritionistsFound = $nutritionists->num_rows === 0;
$noSchedulesFound = $schedules->num_rows === 0;
$noBookingsFound = $bookings->num_rows === 0;

$totalNutritionists = $adminNutritionistsModel->getTotalNutritionists();
$totalSchedules = $adminNutritionistsModel->getTotalSchedules();
$totalBookings = $adminNutritionistsModel->getTotalBookings();

$totalPagesNutritionists = ceil($totalNutritionists / $limit);
$totalPagesSchedules = ceil($totalSchedules / $limit);
$totalPagesBooking = ceil($totalBookings / $limit);

$adminNutritionistsView = new AdminNutritionistsView($nutritionists, $schedules, $bookings, $totalPagesNutritionists, $totalPagesSchedules, $totalPagesBooking, $currentPage, $noNutritionistsFound, $noSchedulesFound, $noBookingsFound);
$adminNutritionistsView->renderView();