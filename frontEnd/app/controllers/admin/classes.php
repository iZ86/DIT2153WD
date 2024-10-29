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

        if (!empty($name) && !empty($description)) {
            $adminClassesModel->addClass($name, $description);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editClassButton']) && $_POST['editClassButton'] === "Edit Class") {
        $fitnessClassID = $_POST['fitnessClassID'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);

        if (!empty($fitnessClassID) && !empty($name) && !empty($description)) {
            $adminClassesModel->editClass($fitnessClassID, $name, $description);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['deleteClassButton'])) {
        $fitnessClassID = $_POST['fitnessClassID'];
        $adminClassesModel->deleteClass($fitnessClassID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
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

    if (isset($_POST['deleteScheduleButton'])) {
        $fitnessClassScheduleID = $_POST['fitnessClassScheduleID'];
        $adminClassesModel->deleteSchedule($fitnessClassScheduleID);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$limit = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$classes = $adminClassesModel->getClasses($limit, $offset);
$schedules = $adminClassesModel->getSchedules($limit, $offset);
$instructors = $adminClassesModel->getAllInstructors();

$totalClasses = $adminClassesModel->getTotalClasses();
$totalSchedules = $adminClassesModel->getTotalSchedules();
$totalPagesClasses = ceil($totalClasses / $limit);
$totalPagesSchedules = ceil($totalSchedules / $limit);

$adminClassesView = new AdminClassesView($classes, $schedules, $instructors, $totalPagesClasses, $totalPagesSchedules, $currentPage);
$adminClassesView->renderView();