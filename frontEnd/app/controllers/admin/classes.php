<?php
require '../../views/admin/pages/adminClassesView.php';
require '../../models/admin/adminClassesModel.php';
session_start();

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
        $scheduledOn = $_POST['scheduledOn'];
        $pax = $_POST['pax'];
        $instructorID = $_POST['instructorID'];

        if (!empty($fitnessClassID) && !empty($scheduledOn) && !empty($pax) && !empty($instructorID)) {
            $adminClassesModel->addSchedule($fitnessClassID, $scheduledOn, $pax, $instructorID);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editScheduleButton']) && $_POST['editScheduleButton'] === "Edit Schedule") {
        $fitnessClassScheduleID = $_POST['fitnessClassScheduleID'];
        $adminClassesModel->editSchedule($fitnessClassScheduleID, $_POST['fitnessClassID'], $_POST['scheduledOn'], $_POST['pax'], $_POST['instructorID']);
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

$classes = $adminClassesModel->getAllClasses();
$schedules = $adminClassesModel->getAllSchedules();
$adminClassesView = new AdminClassesView($classes, $schedules);
$adminClassesView->renderView();
