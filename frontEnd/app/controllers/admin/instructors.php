<?php
require '../../views/admin/pages/AdminInstructorsView.php';
require '../../models/admin/AdminInstructorsModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminInstructorsModel = new AdminInstructorsModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addInstructorButton']) && $_POST['addInstructorButton'] === "Add Instructor") {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $gender = trim($_POST['gender']);
        $phoneNo = trim($_POST['phoneNo']);
        $email = trim($_POST['email']);
        $weight = trim($_POST['weight']);
        $height = trim($_POST['height']);
        $description = trim($_POST['description']);
        $certification = trim($_POST['certification']);
        $dateOfBirth = trim($_POST['dateOfBirth']);

        if (!empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($dateOfBirth)) {
            $adminInstructorsModel->addInstructor($firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editInstructorButton'])) {
        $instructorID = $_POST['instructorID'];
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $gender = trim($_POST['gender']);
        $phoneNo = trim($_POST['phoneNo']);
        $email = trim($_POST['email']);
        $weight = trim($_POST['weight']);
        $height = trim($_POST['height']);
        $description = trim($_POST['description']);
        $certification = trim($_POST['certification']);
        $dateOfBirth = trim($_POST['dateOfBirth']);

        if (!empty($instructorID) && !empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($dateOfBirth)) {
            $adminInstructorsModel->editInstructor($instructorID, $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['deleteInstructorButton'])) {
        $instructorID = $_POST['instructorID'];
        $adminInstructorsModel->deleteInstructor($instructorID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getInstructorDetails') {
    $instructorID = intval($_GET['id']);
    $instructorDetails = $adminInstructorsModel->getInstructorById($instructorID);

    if ($instructorDetails) {
        echo json_encode($instructorDetails);
    } else {
        echo json_encode([]);
    }
    exit;
}

$limit = 6;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$instructors = $adminInstructorsModel->getAllInstructors($limit, $offset);

$totalInstructors = $adminInstructorsModel->getTotalInstructors();
$totalPagesInstructors = ceil($totalInstructors / $limit);

$adminInstructorsView = new AdminInstructorsView($instructors, $totalPagesInstructors, $currentPage);
$adminInstructorsView->renderView();