<?php
require '../../views/admin/pages/adminClassesView.php';
require '../../models/admin/adminClassesModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminClassesModel = new AdminClassesModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addClassButton']) && $_POST['addClassButton'] === "Add Class") {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $imagePath = '';

        if (!empty($_FILES['classImage']['name'])) {
            $targetDir = "../../public/images/classImages/";

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['classImage']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['classImage']['tmp_name']);
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

            if (move_uploaded_file($_FILES['classImage']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($name) && !empty($description)) {
            $adminClassesModel->addClass($name, $description, $imagePath);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editClassButton']) && $_POST['editClassButton'] === "Edit Class") {
        $fitnessClassID = $_POST['fitnessClassID'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $imagePath = '';

        if (!empty($_FILES['classImage']['name'])) {
            $targetDir = "../../public/images/classImages/";

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $originalFileName = basename($_FILES['classImage']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            $check = getimagesize($_FILES['classImage']['tmp_name']);
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

            if (move_uploaded_file($_FILES['classImage']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        if (!empty($fitnessClassID) && !empty($name) && !empty($description)) {
            $adminClassesModel->editClass($fitnessClassID, $name, $description, $imagePath);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['addScheduleButton']) && $_POST['addScheduleButton'] === "Add Schedule") {
        $fitnessClassID = $_POST['fitnessClassID'];
        $scheduledOnDate = $_POST['scheduledOnDate'];
        $scheduledOnTime = $_POST['scheduledOnTime'];
        $pax = $_POST['pax'];
        $instructorID = $_POST['instructorID'];

        $scheduledOn = $scheduledOnDate . ' ' . $scheduledOnTime;

        if (!empty($fitnessClassID) && !empty($scheduledOn) && !empty($pax) && !empty($instructorID)) {
            $adminClassesModel->addSchedule($fitnessClassID, $scheduledOn, $pax, $instructorID);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editScheduleButton'])) {
        $fitnessClassScheduleID = $_POST['fitnessClassScheduleID'];
        $fitnessClassID = $_POST['fitnessClassID'];
        $instructorID = $_POST['instructorID'];
        $pax = $_POST['pax'];
        $scheduledOnDate = $_POST['scheduledOnDate'];
        $scheduledOnTime = $_POST['scheduledOnTime'];

        $scheduledOn = $scheduledOnDate . ' ' . $scheduledOnTime;

        $adminClassesModel->editSchedule($fitnessClassScheduleID, $fitnessClassID, $scheduledOn, $pax, $instructorID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$limit = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

if (!empty($filterType)) {
    if ($filterType === 'name') {
        $classes = $adminClassesModel->getFilteredClassesByName($keywords, $limit, $offset);
    } elseif ($filterType === 'description') {
        $classes = $adminClassesModel->getFilteredClassesByDescription($keywords, $limit, $offset);
    }
} else {
    $classes = $adminClassesModel->getClasses($limit, $offset);
}

$scheduleFilterType = isset($_GET['scheduleFilterType']) ? $_GET['scheduleFilterType'] : '';
$scheduleKeywords = isset($_GET['scheduleKeywords']) ? $_GET['scheduleKeywords'] : '';

if (!empty($scheduleFilterType)) {
    $schedules = $adminClassesModel->getFilteredSchedules($limit, $offset, $scheduleFilterType, $scheduleKeywords);
} else {
    $schedules = $adminClassesModel->getSchedules($limit, $offset);
}

$noClassesFound = $classes->num_rows === 0;
$noSchedulesFound = $schedules->num_rows === 0;

$instructors = $adminClassesModel->getAllInstructors();

$totalClasses = $adminClassesModel->getTotalClasses();
$totalSchedules = $adminClassesModel->getTotalSchedules();
$totalPagesClasses = ceil($totalClasses / $limit);
$totalPagesSchedules = ceil($totalSchedules / $limit);

$adminClassesView = new AdminClassesView($classes, $schedules, $instructors, $totalPagesClasses, $totalPagesSchedules, $currentPage, $noClassesFound, $noSchedulesFound);
$adminClassesView->renderView();