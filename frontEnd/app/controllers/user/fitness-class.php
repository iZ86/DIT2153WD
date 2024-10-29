<?php
session_start();
require '../../models/user/userFitnessClassModel.php';
require '../../views/user/pages/classScheduleView.php';

$instructorId = isset($_GET['instructor']) ? intval($_GET['instructor']) : null;
$weekOffset = isset($_GET['week']) ? intval($_GET['week']) : 0;
$fitnessClassID = isset($_GET['fitnessClassID']) ? intval($_GET['fitnessClassID']) : null;

$fitnessClassModel = new UserFitnessClass(require '../../config/db_connection.php');
$scheduledOn = null;
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

if(isset($_POST['confirm-fitness-class-booking'])) {
    if(isset($_POST['scheduledOn'])){
        $scheduledOn = $_POST['scheduledOn'];
    }
}

$fitnessClassScheduleID = $fitnessClassModel->getFitnessClassScheduleIdByClassInfo($scheduledOn, $instructorId, $fitnessClassID);
$fitnessClassModel->createUserFitnessClassBooking($fitnessClassScheduleID, $userID);
// TODO: Fix instructorID null bug.
// Fetch instructor name and class data
$instructorName = $fitnessClassModel->getInstructorNameById($instructorId);
$classData = $fitnessClassModel->getClassesByInstructorById($instructorId);

// Pass the data to the view
$fitnessClassView = new FitnessClassView($classData, $instructorName);
$fitnessClassView->renderView();
