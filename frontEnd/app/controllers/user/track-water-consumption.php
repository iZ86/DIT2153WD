<?php
require('../../views/user/pages/userTrackWaterConsumptionView.php');
require('../../models/user/userTrackWaterConsumptionModel.php');
session_start();
$userTrackWaterConsumptionModel = new UserTrackWaterConsumptionModel(require "../../config/db_connection.php");

// Regex to verify date format.
$regex = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regex, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addWaterConsumptionDataButton']) && $_POST['addWaterConsumptionDataButton'] === "Add") {
        $amountDrank = $_POST['amountDrank'];
        $unit = $_POST['unit'];
        $time = $_POST['time'];
        $dateTime = $date . " " . $time;
        $userTrackWaterConsumptionModel->addWaterConsumptionData($_SESSION['userID'], $amountDrank, $dateTime);
        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));

    }
}

$userTrackWaterConsumptionView = new UserTrackWaterConsumptionView($userTrackWaterConsumptionModel->getWaterConsumptionDataFromDate($_SESSION['userID'], $date));
$userTrackWaterConsumptionView->renderView();

