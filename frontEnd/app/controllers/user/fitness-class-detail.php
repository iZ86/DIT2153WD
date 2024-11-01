<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

require '../../views/user/pages/classDetailsView.php';
require '../../models/instructorModel.php';

$instructorModel = new InstructorModel(require '../../config/db_connection.php');
$fitnessClassID = isset($_GET['fitnessClassID']) ? intval($_GET['fitnessClassID']) : null;
$getInstructorAndFitnessClassInformationById = $instructorModel->getFitnessClassById($fitnessClassID);
$getInstructorsByFitnessClassID = $instructorModel->getInstructorsByFitnessClassID($fitnessClassID);
$classDetailsView = new ClassDetails($getInstructorAndFitnessClassInformationById, $getInstructorsByFitnessClassID);
$classDetailsView->renderView();