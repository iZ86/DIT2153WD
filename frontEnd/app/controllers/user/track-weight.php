<?php
require('../../views/user/pages/userTrackWeightView.php');
require('../../models/user/userTrackWeightModel.php');
session_start();
define("KILOGRAMSTOGRAMSCONVERSIONRATE", 1000);
define("KILOGRAMSTOPOUNDSCONVERSIONRATE", 2.20462);
$userTrackWeightModel = new UserTrackWeightModel(require "../../config/db_connection.php");

// Regex to validate date format.
$regexDateFormat = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Regex to validate weight format.
$regexWeightFormat = "/^[\d]*(.[\d]{1,2}$|$)/";

// Regex to validate ID.
$regexIDFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate unit.
$regexUnitFormat = "/^(Kg|g|lb)$/";

/** Converts Kilograms to whatever unit is inputted.
 * Return -1, if unit not supported.
 */
function convertKilogramsToWeightInputted($kilograms, $unit) {
    if ($unit === "Kg") {
        return $kilograms;
    } else if ($unit === "g") {
        return $kilograms * KILOGRAMSTOGRAMSCONVERSIONRATE;
    } else if ($unit === "lb") {
        return $kilograms * KILOGRAMSTOPOUNDSCONVERSIONRATE;
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
    if (isset($_POST['unit']) && isset($_POST['weight']) && isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostData($unit, $weight, $time, $regexUnitFormat, $regexWeightFormat, $regexTimeFormat) {
    
    if ((($unit !== null) && preg_match($regexUnitFormat, $unit)) &&
    (($weight !== null) && (preg_match($regexWeightFormat, $weight))) &&
    (($time !==null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    
    return false;
}

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitWeightDataButton'])) {
        if ($_POST['submitWeightDataButton'] === "Add") {
            
            if (checkIsBasicPostVariablesSet()) {
                
                $unit = cleanData($_POST['unit']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($unit, $weight, $time, $regexUnitFormat, $regexWeightFormat, $regexTimeFormat)) {
                    
                    
                    
                    $weight = (float) $weight;
                    $weight = convertKilogramsToWeightInputted($weight, $unit);
                    $dateTime = $date . " " . $time;
    
                    $addStatus = $userTrackWeightModel->addWeightData($_SESSION['userID'], $weight, $dateTime);
                    if ($addStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=' . $date));
                    }
                }
            }
        } else if ($_POST['submitWeightDataButton'] === "Save") {
            
            if (checkIsBasicPostVariablesSet() && isset($_POST['weightID'])) {
                $weightID = cleanData($_POST['weightID']);
                $unit = cleanData($_POST['unit']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                
                if (validateBasicPostData($unit, $weight, $time, $regexUnitFormat, $regexWeightFormat, $regexTimeFormat) &&
                (($weightID !== null) &&
                preg_match($regexIDFormat, $weightID))) {
                    
                    $weightID = (int) $weightID;
                    $weight = (float) $weight;
                    $weight = convertKilogramsToWeightInputted($weight, $unit);
                    $dateTime = $date . " " . $time;
                    $updateStatus = $userTrackWeightModel->updateWeightData($weightID, $weight, $dateTime, $_SESSION['userID']);
                    if ($updateStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=' . $date));
                    }
                }
            }
        }
    } else if (isset($_POST['submitDeleteWeightDataButton'])) {
        
        if ($_POST['submitDeleteWeightDataButton'] === "Delete") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['weightID'])) {
                $weightID = cleanData($_POST['weightID']);
                $unit = cleanData($_POST['unit']);
                $weight = cleanData($_POST['weight']);
                $time = cleanData($_POST['time']);
                if (validateBasicPostData($unit, $weight, $time, $regexUnitFormat, $regexWeightFormat, $regexTimeFormat) &&
                (($weight !== null) &&
                preg_match($regexIDFormat, $weightID))) {
                    $weightID = (int) $weightID;

                    

                    $deleteStatus = $userTrackWeightModel->deleteWeightData($weightID, $_SESSION['userID']);
                    
                    
                    if ($deleteStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=' . $date));
                    }
                }
            }
        }

    }
}


if (isset($_POST['unit'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['unit'] === "Kg" || $_POST['unit'] === "g" || $_POST['unit'] === "lb") {
        $_SESSION['unit'] = $_POST['unit'];
    }
}

$userTrackWeightView = new UserTrackWeightView($userTrackWeightModel->getWeightDataFromDate($_SESSION['userID'], $date));
$userTrackWeightView->renderView();

