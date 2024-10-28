<?php
require('../../views/user/pages/userTrackWaterConsumptionView.php');
require('../../models/user/userTrackWaterConsumptionModel.php');
session_start();
define("MILLILITERSTOLITERSCONVERSIONRATE", 1000);
define("MILLILITERSTOOUNCECONVERSIONRATE", 29.5735);
$userTrackWaterConsumptionModel = new UserTrackWaterConsumptionModel(require "../../config/db_connection.php");

// Regex to validate date format.
$regexDateFormat = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Regex to validate amount drank format.
$regexAmountDrankFormat = "/^[1-9][\d]*([.\d]{3}$|$)/";

// Regex to validate ID.
$regexIDFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate unit.
$regexUnitFormat = "/^(mL|L|oz)$/";


// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitWaterConsumptionDataButton'])) {
        if ($_POST['submitWaterConsumptionDataButton'] === "Add") {
            if (checkIsBasicPostVariablesSet()) {
                $unit = cleanData($_POST['unit']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($unit, $amountDrank, $time, $regexUnitFormat, $regexAmountDrankFormat, $regexTimeFormat)) {
                    
                    $amountDrank = (float) $amountDrank;
                    $amountDrank = convertMillilitersToUnitInputted($amountDrank, $unit);
                    $dateTime = $date . " " . $time;
    
                    $addStatus = $userTrackWaterConsumptionModel->addWaterConsumptionData($_SESSION['userID'], $amountDrank, $dateTime);
                    echo "<script>console.log(" . 1 . ");</script>";
                    if ($addStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));
                    }
                }
            }
        } else if ($_POST['submitWaterConsumptionDataButton'] === "Save") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['waterConsumptionID'])) {
                $waterConsumptionID = cleanData($_POST['waterConsumptionID']);
                $unit = cleanData($_POST['unit']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($unit, $amountDrank, $time, $regexUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) &&
                (($waterConsumptionID !== null) &&
                preg_match($regexIDFormat, $waterConsumptionID))) {
                    $waterConsumptionID = (int) $waterConsumptionID;
                    $amountDrank = (float) $amountDrank;
                    $amountDrank = convertMillilitersToUnitInputted($amountDrank, $unit);
                    $dateTime = $date . " " . $time;
                    $updateStatus = $userTrackWaterConsumptionModel->updateWaterConsumptionData($waterConsumptionID, $amountDrank, $dateTime, $_SESSION['userID']);
                    if ($updateStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));
                    }
                }
            }
        }
    } else if (isset($_POST['deleteWaterConsumptionDataButton'])) {
        
        echo "<script>console.log(" . 1 . ");</script>";
        if ($_POST['deleteWaterConsumptionDataButton'] === "Delete") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['waterConsumptionID'])) {
                $waterConsumptionID = cleanData($_POST['waterConsumptionID']);
                $unit = cleanData($_POST['unit']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($unit, $amountDrank, $time, $regexUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) &&
                (($waterConsumptionID !== null) &&
                preg_match($regexIDFormat, $waterConsumptionID))) {

                    $waterConsumptionID = (int) $waterConsumptionID;



                    $deleteStatus = $userTrackWaterConsumptionModel->deleteWaterConsumptionData($waterConsumptionID, $_SESSION['userID']);
                    if ($deleteStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));
                    }
                }
            }
        }

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

/** Cleans the data. */
function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/** Returns true if the basic $_POST variables are set.
 * Otherwisem return false.
 */
function checkIsBasicPostVariablesSet() {
    if (isset($_POST['unit']) && isset($_POST['amountDrank']) && isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostData($unit, $amountDrank, $time, $regexUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) {
    echo "<script>console.log(" . $time . preg_match($regexTimeFormat, $time). ");</script>";
    if ((($unit !== null) && preg_match($regexUnitFormat, $unit)) &&
    (($amountDrank !== null) && (preg_match($regexAmountDrankFormat, $amountDrank))) &&
    (($time !==null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    
    return false;
}

$userTrackWaterConsumptionView = new UserTrackWaterConsumptionView($userTrackWaterConsumptionModel->getWaterConsumptionDataFromDate($_SESSION['userID'], $date));
$userTrackWaterConsumptionView->renderView();

