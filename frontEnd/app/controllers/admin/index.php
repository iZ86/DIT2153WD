<?php
require '../../views/admin/pages/adminIndexView.php';
require '../../models/admin/adminIndexModel.php';

// Start a new session or resume the existing session
session_start();

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

// Instantiate the AdminIndexModel with the database connection
$adminIndexModel = new AdminIndexModel(require '../../config/db_connection.php');

// Retrieve various counts and data for the dashboard
$usersCount = $adminIndexModel->countUsers(); // Get the total number of users
$classesCount = $adminIndexModel->countClasses(); // Get the total number of classes
$nutritionistsCount = $adminIndexModel->countNutritionists(); // Get the total number of nutritionists
$instructorsCount = $adminIndexModel->countInstructors(); // Get the total number of instructors

// Retrieve upcoming schedules for classes and nutritionists
$upcomingClassSchedules = $adminIndexModel->getUpcomingClassSchedules(); // Get upcoming class schedules
$upcomingNutritionistSchedules = $adminIndexModel->getUpcomingNutritionistSchedules(); // Get upcoming nutritionist schedules

// Retrieve the latest transactions
$latestTransactions = $adminIndexModel->getLatestTransactions(); // Get the latest transaction records

// Instantiate the view with the retrieved data and render it
$adminIndexView = new AdminIndexView($usersCount, $classesCount, $nutritionistsCount, $instructorsCount, $upcomingClassSchedules, $upcomingNutritionistSchedules, $latestTransactions);
$adminIndexView->renderView(); // Render the admin index view