<?php
require('../../views/user/pages/userTrackWaterConsumptionView.php');
require('../../models/user/userTrackWaterConsumptionModel.php');
session_start();
define("MILLILITERSTOLITERSCONVERSIONRATE", 1000);
define("MILLILITERSTOOUNCECONVERSIONRATE", 29.5735);
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
        $amountDrank = (float) $_POST['amountDrank'];
        $unit = $_POST['unit'];
        $time = $_POST['time'];
        $amountDrank = convertMillilitersToUnitInputted($amountDrank, $unit);
        $dateTime = $date . " " . $time;
        $userTrackWaterConsumptionModel->addWaterConsumptionData($_SESSION['userID'], $amountDrank, $dateTime);
        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));

    }

}

if (isset($_POST['unit'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['unit'] === "mL" || $_POST['unit'] === "L" || $_POST['unit'] === "oz") {
        $_SESSION['unit'] = $_POST['unit'];
    }
}

/** Converts Milliliters to whatever unit is inputted. */
function convertMillilitersToUnitInputted($milliliters, $unit) {
    if ($unit === "mL") {
        return $milliliters;
    } else if ($unit === "L") {
        return $milliliters * MILLILITERSTOLITERSCONVERSIONRATE;
    } else if ($unit === "oz") {
        return bcmul(MILLILITERSTOOUNCECONVERSIONRATE, $milliliters, 2);
    }
    return -1;
}

$userTrackWaterConsumptionView = new UserTrackWaterConsumptionView($userTrackWaterConsumptionModel->getWaterConsumptionDataFromDate($_SESSION['userID'], $date));
$userTrackWaterConsumptionView->renderView();

