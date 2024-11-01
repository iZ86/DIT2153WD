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
        $imagePath = '';

        if (!empty($_FILES['instructorsImages']['name'])) {
            $targetDir = "../../public/images/instructorsImages/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['instructorsImages']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['instructorsImages']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            if (move_uploaded_file($_FILES['instructorsImages']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($dateOfBirth)) {
            $adminInstructorsModel->addInstructor($firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath);
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
        $imagePath = '';

        if (!empty($_FILES['instructorsImages']['name'])) {
            $targetDir = "../../public/images/instructorsImages/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['instructorsImages']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['instructorsImages']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            if (move_uploaded_file($_FILES['instructorsImages']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($instructorID) && !empty($firstName) && !empty($lastName) && !empty($phoneNo) && !empty($email) && !empty($dateOfBirth)) {
            $adminInstructorsModel->editInstructor($instructorID, $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath);
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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'filterInstructors') {
    $filterType = $_GET['instructorFilterType'] ?? null;
    $keywords = $_GET['instructorKeywords'] ?? '';

    $instructors = $adminInstructorsModel->getFilteredInstructors($filterType, $keywords, $limit, $offset);
} else {
    $instructors = $adminInstructorsModel->getAllInstructors($limit, $offset);
}

$noInstructorsFound = $instructors->num_rows === 0;

$totalInstructors = $adminInstructorsModel->getTotalInstructors();
$totalPagesInstructors = ceil($totalInstructors / $limit);

$adminInstructorsView = new AdminInstructorsView($instructors, $totalPagesInstructors, $currentPage, $noInstructorsFound);
$adminInstructorsView->renderView();