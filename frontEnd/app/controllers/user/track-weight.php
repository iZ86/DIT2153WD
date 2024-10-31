<?php
require('../../views/user/pages/userTrackWeightView.php');
require('../../models/user/userTrackWeightModel.php');
session_start();
define("KILOGRAMTOGRAMCONVERSIONRATE", 1000);
define("POUNDTOGRAMCONVERSIONRATE", 453.6);
$userTrackWeightModel = new UserTrackWeightModel(require "../../config/db_connection.php");

// Regex to validate date format.
$regexDateFormat = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Regex to validate weight format.
$regexWeightFormat = "/^[\d]*(.[\d]{1,4}$|$)/";

// Regex to validate ID.
$regexIDFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate weight unit.
$regexWeightUnitFormat = "/^(Kg|g|lb)$/";

/** Converts any value of any weight unit to gram.
 * Return -1, if unit is not supported.
 */
function convertValueOfWeightUnitToGram($value, $weightUnit) {
    if ($weightUnit === "g") {
        return $value;
    } else if ($weightUnit === "Kg") {
        return bcmul(KILOGRAMTOGRAMCONVERSIONRATE, $value, 4);
    } else if ($weightUnit === "lb") {
        return bcmul(POUNDTOGRAMCONVERSIONRATE, $value, 4);
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
    if (isset($_POST['weightUnitInWeightDataModalInUserTrackWeightView']) && isset($_POST['weight']) && isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostData($weightUnit, $weight, $time, $regexWeightUnitFormat, $regexWeightFormat, $regexTimeFormat) {
    
    if ((($weightUnit !== null) && preg_match($regexWeightUnitFormat, $weightUnit)) &&
    (($weight !== null) && (preg_match($regexWeightFormat, $weight))) &&
    (($time !==null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    
    return false;
}

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: track-weight.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitWeightDataButton'])) {
        if ($_POST['submitWeightDataButton'] === "Add") {
            
            if (checkIsBasicPostVariablesSet()) {
                
                $weightUnit = cleanData($_POST['weightUnitInWeightDataModalInUserTrackWeightView']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($weightUnit, $weight, $time, $regexWeightUnitFormat, $regexWeightFormat, $regexTimeFormat)) {
                    
                    
                    
                    $weight = (float) $weight;
                    $weight = convertValueOfWeightUnitToGram($weight, $weightUnit);
                    $dateTime = $date . " " . $time;
    
                    $addStatus = $userTrackWeightModel->addWeightData($_SESSION['userID'], $weight, $dateTime);
                    if ($addStatus) {
                        die(header('location: track-weight.php?date=' . $date));
                    }
                }
            }
        } else if ($_POST['submitWeightDataButton'] === "Save") {
            
            if (checkIsBasicPostVariablesSet() && isset($_POST['weightID'])) {
                $weightID = cleanData($_POST['weightID']);
                $weightUnit = cleanData($_POST['weightUnitInWeightDataModalInUserTrackWeightView']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                
                if (validateBasicPostData($weightUnit, $weight, $time, $regexWeightUnitFormat, $regexWeightFormat, $regexTimeFormat) &&
                (($weightID !== null) &&
                preg_match($regexIDFormat, $weightID))) {
                    
                    $weightID = (int) $weightID;
                    $weight = (float) $weight;
                    $weight = convertValueOfWeightUnitToGram($weight, $weightUnit);
                    $dateTime = $date . " " . $time;
                    $updateStatus = $userTrackWeightModel->updateWeightData($weightID, $weight, $dateTime, $_SESSION['userID']);
                    if ($updateStatus) {
                        die(header('location: track-weight.php?date=' . $date));
                    }
                }
            }
        }
    } else if (isset($_POST['submitDeleteWeightDataButton'])) {
        
        if ($_POST['submitDeleteWeightDataButton'] === "Delete") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['weightID'])) {
                $weightID = cleanData($_POST['weightID']);
                $weightUnit = cleanData($_POST['weightUnitInWeightDataModalInUserTrackWeightView']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($weightUnit, $weight, $time, $regexWeightUnitFormat, $regexWeightFormat, $regexTimeFormat) &&
                (($weight !== null) &&
                preg_match($regexIDFormat, $weightID))) {
                    $weightID = (int) $weightID;

                    

                    $deleteStatus = $userTrackWeightModel->deleteWeightData($weightID, $_SESSION['userID']);
                    
                    
                    if ($deleteStatus) {
                        die(header('location: track-weight.php?date=' . $date));
                    }
                }
            }
        }

    }
}

// Used to persist the weight units chosen by user.
if (isset($_POST['weightUnitInUserTrackWeightView'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['weightUnitInUserTrackWeightView'] !== null && preg_match($regexWeightUnitFormat, $_POST['weightUnitInUserTrackWeightView'])) {
        $_SESSION['weightUnitInUserTrackWeightView'] = $_POST['weightUnitInUserTrackWeightView'];
    }
}

$userTrackWeightView = new UserTrackWeightView($userTrackWeightModel->getWeightDatasetFromDate($date, $_SESSION['userID']));
$userTrackWeightView->renderView();

