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
$regexAmountDrankFormat = "/^[\d]*(.[\d]{1,2}$|$)/";

// Regex to validate ID.
$regexIDFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate volume unit.
$regexVolumeUnitFormat = "/^(mL|L|oz)$/";

/** Converts Milliliters to whatever unit is inputted.
 * Return -1, if unit not supported.
 */
function convertMillilitersToVolumeUnitInputted($milliliters, $volumeUnit) {
    if ($volumeUnit === "mL") {
        return $milliliters;
    } else if ($volumeUnit === "L") {
        return $milliliters * MILLILITERSTOLITERSCONVERSIONRATE;
    } else if ($volumeUnit === "oz") {
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
 * Otherwise, return false.
 */
function checkIsBasicPostVariablesSet() {
    if (isset($_POST['volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView']) && isset($_POST['amountDrank']) && isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostData($volumeUnit, $amountDrank, $time, $regexVolumeUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) {
    if ((($volumeUnit !== null) && preg_match($regexVolumeUnitFormat, $volumeUnit)) &&
    (($amountDrank !== null) && (preg_match($regexAmountDrankFormat, $amountDrank))) &&
    (($time !==null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    
    return false;
}

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitWaterConsumptionDataButton'])) {
        if ($_POST['submitWaterConsumptionDataButton'] === "Add") {
            if (checkIsBasicPostVariablesSet()) {
                $volumeUnit = cleanData($_POST['volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($volumeUnit, $amountDrank, $time, $regexVolumeUnitFormat, $regexAmountDrankFormat, $regexTimeFormat)) {
                    
                    $amountDrank = (float) $amountDrank;
                    $amountDrank = convertMillilitersToVolumeUnitInputted($amountDrank, $volumeUnit);
                    $dateTime = $date . " " . $time;
    
                    $addStatus = $userTrackWaterConsumptionModel->addWaterConsumptionData($_SESSION['userID'], $amountDrank, $dateTime);
                    if ($addStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));
                    }
                }
            }
        } else if ($_POST['submitWaterConsumptionDataButton'] === "Save") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['waterConsumptionID'])) {
                $waterConsumptionID = cleanData($_POST['waterConsumptionID']);
                $volumeUnit = cleanData($_POST['volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($volumeUnit, $amountDrank, $time, $regexVolumeUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) &&
                (($waterConsumptionID !== null) &&
                preg_match($regexIDFormat, $waterConsumptionID))) {
                    $waterConsumptionID = (int) $waterConsumptionID;
                    $amountDrank = (float) $amountDrank;
                    $amountDrank = convertMillilitersToVolumeUnitInputted($amountDrank, $volumeUnit);
                    $dateTime = $date . " " . $time;
                    $updateStatus = $userTrackWaterConsumptionModel->updateWaterConsumptionData($waterConsumptionID, $amountDrank, $dateTime, $_SESSION['userID']);
                    if ($updateStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=' . $date));
                    }
                }
            }
        }
    } else if (isset($_POST['submitDeleteWaterConsumptionDataButton'])) {
        
        if ($_POST['submitDeleteWaterConsumptionDataButton'] === "Delete") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['waterConsumptionID'])) {
                $waterConsumptionID = cleanData($_POST['waterConsumptionID']);
                $volumeUnit = cleanData($_POST['volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView']);
                $amountDrank = cleanData($_POST['amountDrank']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($volumeUnit, $amountDrank, $time, $regexVolumeUnitFormat, $regexAmountDrankFormat, $regexTimeFormat) &&
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


if (isset($_POST['volumeUnitInUserTrackWaterConsumptionView'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['volumeUnitInUserTrackWaterConsumptionView'] === "mL" || $_POST['volumeUnitInUserTrackWaterConsumptionView'] === "L" || $_POST['volumeUnitInUserTrackWaterConsumptionView'] === "oz") {
        $_SESSION['volumeUnitInUserTrackWaterConsumptionView'] = $_POST['volumeUnitInUserTrackWaterConsumptionView'];
    }
}

$userTrackWaterConsumptionView = new UserTrackWaterConsumptionView($userTrackWaterConsumptionModel->getWaterConsumptionDatasetFromDate($date, $_SESSION['userID']));
$userTrackWaterConsumptionView->renderView();

