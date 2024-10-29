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

    if (isset($_POST['deleteScheduleButton'])) {
        $nutritionistScheduleID = $_POST['nutritionistScheduleID'];
        $adminNutritionistsModel->deleteSchedule($nutritionistScheduleID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$limit = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$totalNutritionists = $adminNutritionistsModel->getTotalNutritionists();
$totalSchedules = $adminNutritionistsModel->getTotalSchedules();
$totalPagesNutritionists = ceil($totalNutritionists / $limit);
$totalPagesSchedules = ceil($totalSchedules / $limit);

$nutritionists = $adminNutritionistsModel->getNutritionists($limit, $offset);
$schedules = $adminNutritionistsModel->getSchedules($limit, $offset);

$adminNutritionistsView = new AdminNutritionistsView($nutritionists, $schedules, $totalPagesNutritionists, $totalPagesSchedules, $currentPage);
$adminNutritionistsView->renderView();