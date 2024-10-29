<?php
require '../../models/user/userFitnessClassModel.php';
require '../../views/user/pages/classScheduleView.php';

$instructorId = isset($_GET['instructor']) ? intval($_GET['instructor']) : null;
$weekOffset = isset($_GET['week']) ? intval($_GET['week']) : 0;

$fitnessClassModel = new UserFitnessClass(require '../../config/db_connection.php');

// Fetch instructor name and class data
$instructorName = $fitnessClassModel->getInstructorNameById($instructorId);
$classData = $fitnessClassModel->getClassesByInstructorById($instructorId);

// Pass the data to the view
$fitnessClassView = new FitnessClassView($classData, $instructorName);
$fitnessClassView->renderView();
