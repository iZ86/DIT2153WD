<?php
session_start();
require '../../models/user/userFitnessClassModel.php';
require '../../views/user/pages/classScheduleView.php';

$instructorIdForOffSet = isset($_GET['instructor']) ? intval($_GET['instructor']) : null;

$fitnessClassModel = new UserFitnessClass(require '../../config/db_connection.php');
$scheduledOn = null;
$instructorIdForPost = null;
$fitnessClassID = null;
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

// Fetch instructor name and class data
$instructorName = $fitnessClassModel->getInstructorNameById($instructorIdForOffSet);
$classData = $fitnessClassModel->getClassesByInstructorById($instructorIdForOffSet);

// Pass the data to the view
$fitnessClassView = new FitnessClassView($classData, $instructorName);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['confirm-fitness-class-booking'])) {
        if(isset($_POST['scheduledOn']) && isset($_POST['instructorID']) && isset($_POST['fitnessClassID'])){
            $scheduledOn = $_POST['scheduledOn'];
            $instructorIdForPost = $_POST['instructorID'];
            $fitnessClassID = $_POST['fitnessClassID'];
            $fitnessClassScheduleID = $fitnessClassModel->getFitnessClassScheduleIdByClassInfo($scheduledOn, $instructorIdForPost, $fitnessClassID);
            $fitnessClassModel->createUserFitnessClassBooking($fitnessClassScheduleID, $userID);
        }
    }
}

$fitnessClassView->renderView();