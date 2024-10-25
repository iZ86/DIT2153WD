<?php
require '../../views/user/pages/classDetailsView.php';
require '../../models/instructorModel.php';

$instructorModel = new InstructorModel(require '../../config/db_connection.php');
$classDetailsView = new ClassDetails($instructorModel->getAllInstructor());

$classDetailsView->renderView();

/** Function to return a intructors by their ID. */
function getInstructorById(int $id) { 
    global $instructorModel; 
    return $instructorModel->getById($id);
}   
