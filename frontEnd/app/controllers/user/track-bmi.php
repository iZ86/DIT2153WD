<?php
require('../../views/user/pages/userTrackBMIView.php');
require('../../models/user/userTrackBMIModel.php');
session_start();
define("CENTIMETERTOMETERCONVERSIONRATE", 100);
define("FOOTTOMETERCONVERSIONRATE", 3.28084);
define("GRAMTOKILOGRAMCONVERSIONRATE", 1000);
define("POUNDTOKILOGRAMCONVERSIONRATE", 2.20462);

$userTrackBMIModel = new UserTrackBMIModel(require "../../config/db_connection.php");

// Regex to validate date format.
$regexDateFormat = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Regex to validate weight, height format.
$regexWeightAndHeightFormat = "/^[\d]*(.[\d]{1,2}$|$)/";

// Regex to validate ID.
$regexIDAndAgeFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate weight unit.
$regexWeightUnitFormat = "/^(Kg|g|lb)$/";

// Regex to validate height unit.
$regexHeightUnitFormat = "/^(m|cm|ft)$/";

// Regex to validate gender.
$regexGenderFormat = "/^male|female$/";

/** Converts value of any unit for weight measurement to kilogram.
 * Return -1, if unit is not supported.
 */
function convertValueOfUnitToKilogram($value, $unit) {
    if ($unit === "Kg") {
        return $value;
    } else if ($unit === "g") {
        return floor(($value / GRAMTOKILOGRAMCONVERSIONRATE) * 10000) / 10000;
    } else if ($unit === "lb") {
        return floor(($value / POUNDTOKILOGRAMCONVERSIONRATE) * 10000) / 10000;
    }
    return -1;
}

/** Converts value of any unit for height measurement to meters.
 * Return -1, if unit is not supported.
 */
function convertValueOfUnitToMeter($value, $unit) {
    if ($unit === "m") {
        return $value;
    } else if ($unit === "cm") {
        return floor(($value / CENTIMETERTOMETERCONVERSIONRATE) * 10000) / 10000;
    } else if ($unit === "ft") {
        return floor(($value / FOOTTOMETERCONVERSIONRATE) * 10000) / 10000;
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
    if (isset($_POST['age']) && isset($_POST['gender']) && isset($_POST['height']) && isset($_POST['heightUnitInBMIDataModalInUserTrackBMIView']) && 
    isset($_POST['weight']) && isset($_POST['weightUnitInBMIDataModalInUserTrackBMIView']) && isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostData($age, $gender, $height, $heightUnit, 
$weight, $weightUnit, $time, $regexIDAndAgeFormat,
$regexGenderFormat, $regexWeightAndHeightFormat, $regexWeightUnitFormat, $regexHeightUnitFormat,
$regexTimeFormat) {
    if ((($age !== null) && preg_match($regexIDAndAgeFormat, $age)) &&
    (($gender !== null) && (preg_match($regexGenderFormat, $gender))) &&
    (($height !== null) && (preg_match($regexWeightAndHeightFormat, $height))) &&
    (($heightUnit != null) && (preg_match($regexHeightUnitFormat, $heightUnit))) &&
    (($weight !== null) && (preg_match($regexWeightAndHeightFormat, $weight))) &&
    (($weightUnit !== null) && (preg_match($regexWeightUnitFormat, $weightUnit))) &&
    (($time !== null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    return false;
}

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitBMIDataButton'])) {
        
        if ($_POST['submitBMIDataButton'] === "Add") {
            if (checkIsBasicPostVariablesSet()) {
                

                $age = cleanData($_POST['age']);
                $gender = cleanData($_POST['gender']);
                $height = cleanData($_POST['height']);
                $heightUnit = cleanData($_POST['heightUnitInBMIDataModalInUserTrackBMIView']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnitInBMIDataModalInUserTrackBMIView']);
                $time = cleanData($_POST['time']);

                if (validateBasicPostData($age, $gender, $height, $heightUnit,
                $weight, $weightUnit, $time, $regexIDAndAgeFormat, 
                $regexGenderFormat, $regexWeightAndHeightFormat, $regexWeightUnitFormat, $regexHeightUnitFormat, 
                $regexTimeFormat)) {
                    
                    
                    $height = (float) $height;
                    $weight = (float) $weight;

                
                    $height = convertValueOfUnitToMeter($height, $heightUnit);
                    $weight = convertValueOfUnitToKilogram($weight, $weightUnit);
                    

                    $dateTime = $date . " " . $time;
    
                    $addStatus = $userTrackBMIModel->addBMIData($age, $gender, $height, $weight, $dateTime, $_SESSION['userID']);
                    if ($addStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=' . $date));
                    }
                }
            }

        } else if ($_POST['submitBMIDataButton'] === "Save") {
            if (checkIsBasicPostVariablesSet() && isset($_POST['bmiID'])) {
                $bmiID = cleanData($_POST['bmiID']);
                $age = cleanData($_POST['age']);
                $gender = cleanData($_POST['gender']);
                $height = cleanData($_POST['height']);
                $heightUnit = cleanData($_POST['heightUnitInBMIDataModalInUserTrackBMIView']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnitInBMIDataModalInUserTrackBMIView']);
                $time = cleanData($_POST['time']);


                if ((validateBasicPostData($age, $gender, $height, $heightUnit, 
                $weight, $weightUnit, $time, $regexIDAndAgeFormat,
                $regexGenderFormat, $regexWeightAndHeightFormat, $regexWeightUnitFormat, $regexHeightUnitFormat,
                $regexTimeFormat)) && 
                ($bmiID !== null) &&
                (preg_match($regexIDAndAgeFormat, $bmiID))) {

                    $bmiID = (int) $bmiID;
                    $height = (float) $height;
                    $weight = (float) $weight;

                    
                    $height = convertValueOfUnitToMeter($height, $heightUnit);
                    $weight = convertValueOfUnitToKilogram($weight, $weightUnit);

                    $dateTime = $date . " " . $time;
                    $updateStatus = $userTrackBMIModel->updateBMIData($bmiID, $age, $gender, $height, $weight, $dateTime, $_SESSION['userID']);
                    if ($updateStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=' . $date));
                    }
                }
            }
        }
    } else if (isset($_POST['submitDeleteBMIDataButton'])) {
        
        if ($_POST['submitDeleteBMIDataButton'] === "Delete") {
            
            if (checkIsBasicPostVariablesSet() && isset($_POST['bmiID'])) {

                $bmiID = cleanData($_POST['bmiID']);
                $age = cleanData($_POST['age']);
                $gender = cleanData($_POST['gender']);
                $height = cleanData($_POST['height']);
                $heightUnit = cleanData($_POST['heightUnitInBMIDataModalInUserTrackBMIView']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnitInBMIDataModalInUserTrackBMIView']);
                $time = cleanData($_POST['time']);

                if ((validateBasicPostData($age, $gender, $height, $heightUnit, 
                $weight, $weightUnit, $time, $regexIDAndAgeFormat,
                $regexGenderFormat, $regexWeightAndHeightFormat, $regexWeightUnitFormat, $regexHeightUnitFormat,
                $regexTimeFormat)) && 
                ($bmiID !== null) &&
                (preg_match($regexIDAndAgeFormat, $bmiID))) {

                    $bmiID = (int) $bmiID;

                    $dateTime = $date . " " . $time;
                    $deleteStatus = $userTrackBMIModel->deleteBMIData($bmiID, $_SESSION['userID']);
                    if ($deleteStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=' . $date));
                    }
                }
            }
        }

    }
}


// Used to persist the height units chosen.
if (isset($_POST['heightUnitInBMIDataModalInUserTrackBMIView'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['heightUnitInBMIDataModalInUserTrackBMIView'] === "m" ||
    $_POST['heightUnitInBMIDataModalInUserTrackBMIView'] === "cm" ||
    $_POST['heightUnitInBMIDataModalInUserTrackBMIView'] === "ft") {
        $_SESSION['heightUnitInBMIDataModalInUserTrackBMIView'] = $_POST['heightUnitInBMIDataModalInUserTrackBMIView'];
    }
}

// Used to persist the weight units chosen.
if (isset($_POST['weightUnitInBMIDataModalInUserTrackBMIView'])) {
    // Ensure that the value is the correct values, so that it won't crash the server.
    if ($_POST['weightUnitInBMIDataModalInUserTrackBMIView'] === "Kg" ||
    $_POST['weightUnitInBMIDataModalInUserTrackBMIView'] === "g" ||
    $_POST['weightUnitInBMIDataModalInUserTrackBMIView'] === "lb") {
        $_SESSION['weightUnitInBMIDataModalInUserTrackBMIView'] = $_POST['weightUnitInBMIDataModalInUserTrackBMIView'];
    }
}

$userTrackBMIView = new UserTrackBMIView($userTrackBMIModel->getBMIDatasetFromDate($date, $_SESSION['userID']));
$userTrackBMIView->renderView();

