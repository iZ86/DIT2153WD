<?php
require '../../views/admin/pages/adminIndexView.php';
require '../../models/admin/adminIndexModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminIndexModel = new AdminIndexModel(require '../../config/db_connection.php');

$usersCount = $adminIndexModel->countUsers();
$classesCount = $adminIndexModel->countClasses();
$nutritionistsCount = $adminIndexModel->countNutritionists();
$instructorsCount = $adminIndexModel->countInstructors();


$adminIndexView = new AdminIndexView($usersCount, $classesCount, $nutritionistsCount, $instructorsCount);
$adminIndexView->renderView();