<?php
session_start();
require '../../models/classesModel.php';
require '../../views/user/pages/classView.php';

$classesModel = new ClassesModel(require '../../config/db_connection.php');

// Fetch classes data.
$classesData = $classesModel->getClasses();

// Pass the data to the view
$classesView = new ClassView($classesData);
$classesView->renderView();
