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

/** Cleans the data. */
function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['confirm-fitness-class-booking'])) {
        if(isset($_POST['scheduledOn']) && isset($_POST['instructorID']) && isset($_POST['fitnessClassID'])){
            $scheduledOn = cleanData($_POST['scheduledOn']);
            $instructorIdForPost = cleanData($_POST['instructorID']);
            $fitnessClassID = cleanData($_POST['fitnessClassID']);
            $fitnessClassScheduleID = $fitnessClassModel->getFitnessClassScheduleIdByClassInfo($scheduledOn, $instructorIdForPost, $fitnessClassID);

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentDateTime = new DateTime(); // Get current date and time in Malaysia
            $scheduledDateTime = new DateTime($scheduledOn);

            $status = ($scheduledDateTime < $currentDateTime) ? "Completed" : "Pending";

            $price = $fitnessClassModel->getFitnessClassPriceByFitnessClassID($fitnessClassID);
            $price = $price['price'];

            $_SESSION['fitnessClassScheduleID'] = $fitnessClassScheduleID;
            $_SESSION['status'] = $status;

            header("Location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/user-payment.php?order=Fitness Class Booking&price=$price");
            exit();
        }
    }
}

$fitnessClassView->renderView();
unset($_SESSION['fitnessClassScheduleID']);
unset($_SESSION['status']);