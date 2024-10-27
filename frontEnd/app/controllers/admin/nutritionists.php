<?php
require '../../views/admin/pages/AdminNutritionistsView.php';
require '../../models/admin/AdminNutritionistsModel.php';
session_start();

$adminNutritionistsModel = new AdminNutritionistsModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addNutritionistButton']) && $_POST['addNutritionistButton'] === "Add Nutritionist") {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $gender = trim($_POST['gender']);
        $phoneNo = trim($_POST['phoneNo']);
        $email = trim($_POST['email']);
        $type = trim($_POST['type']);

        if (!empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($type)) {
            $adminNutritionistsModel->addNutritionist($firstName, $lastName, $gender, $phoneNo, $email, $type);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
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

        if (!empty($nutritionistID) && !empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($type)) {
            $adminNutritionistsModel->editNutritionist($nutritionistID, $firstName, $lastName, $gender, $phoneNo, $email, $type);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
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
        $bookingDate = $_POST['bookingDate'];
        $bookingTime = $_POST['bookingTime'];

        if (!empty($nutritionistID) && !empty($bookingDate) && !empty($bookingTime)) {
            try {
                $adminNutritionistsModel->addSchedule($nutritionistID, $bookingDate, $bookingTime);
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
        $bookingDate = $_POST['bookingDate'];
        $bookingTime = $_POST['bookingTime'];

        if (!empty($nutritionistScheduleID) && !empty($nutritionistID) && !empty($bookingDate) && !empty($bookingTime)) {
            $adminNutritionistsModel->editSchedule($nutritionistScheduleID, $nutritionistID, $bookingDate, $bookingTime);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['deleteScheduleButton'])) {
        $nutritionistScheduleID = $_POST['nutritionistScheduleID'];
        $adminNutritionistsModel->deleteSchedule($nutritionistScheduleID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$nutritionists = $adminNutritionistsModel->getAllNutritionists();
$schedules = $adminNutritionistsModel->getAllSchedules();

$adminNutritionistsView = new AdminNutritionistsView($nutritionists, $schedules);
$adminNutritionistsView->renderView();