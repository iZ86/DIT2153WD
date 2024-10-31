<?php
require('../../views/user/pages/userTrackExerciseRoutineDetailView.php');
require('../../models/user/userTrackExerciseRoutineDetailModel.php');
session_start();
define("GRAMSTOKILOGRAMSCONVERSIONRATE", 1000);
define("POUNDSTOKILOGRAMSCONVERSIONRATE", 2.20462);

$userTrackExerciseRoutineDetailModel = new userTrackExerciseRoutineDetailModel(require "../../config/db_connection.php");

// Regex to validate date format.
$regexDateFormat = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";

// Regex to validate weight format.
$regexWeightFormat = "/^[\d]*(.[\d]{1,2}$|$)/";

// Regex to validate ID.
$regexIDAndRepFormat = "/^(0|[1-9][\d]*)$/";

// Regex to validate time.
$regexTimeFormat = "/(^[0-3]|^)[\d]:[0-5][\d]$/";

// Regex to validate weight unit.
$regexWeightUnitFormat = "/^(Kg|g|lb)$/";

/** Converts value of any unit for weight measurement to kilograms.
 * Return -1, if unit is not supported.
 */
function convertValueOfUnitToKilograms($value, $unit) {
    if ($unit === "Kg") {
        return $value;
    } else if ($unit === "g") {
        return floor($value * 10000 * GRAMSTOKILOGRAMSCONVERSIONRATE) / 10000;
    } else if ($unit === "lb") {
        return floor($value * 10000 * POUNDSTOKILOGRAMSCONVERSIONRATE) / 10000;
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

/** Returns true if the basic exercise routine details $_POST variables are set.
 * Otherwise, return false.
 */
function checkIsBasicPostExerciseRoutineDetailVariablesSet() {
    if (isset($_POST['exerciseIDForExerciseRoutineDetail']) && isset($_POST['weight']) && isset($_POST['weightUnit']) && isset($_POST['rep']) && 
    isset($_POST['time'])) {
        return true;
    }
    return false;
}

/** Returns true if the basic exercise $_POST variables are set.
 * Otherwise, return false.
 */
function checkIsBasicPostExerciseVariablesSet() {
    return isset($_POST['exerciseName']);
}


/** Vaidates the basic $_POST data accordingly.
 * Returns true if valid.
 * Otherwise, return false.
 */
function validateBasicPostExerciseRoutineDetailData($exerciseIDForExerciseRoutineDetail, $weight, $weightUnit, $rep, 
$time, $regexIDAndRepFormat,
$regexWeightFormat, $regexWeightUnitFormat, $regexTimeFormat) {
    
    if ((($exerciseIDForExerciseRoutineDetail !== null) && preg_match($regexIDAndRepFormat, $exerciseIDForExerciseRoutineDetail)) &&
    (($weight !== null) && (preg_match($regexWeightFormat, $weight))) &&
    (($weightUnit !== null) && (preg_match($regexWeightUnitFormat, $weightUnit))) &&
    (($rep != null) && (preg_match($regexIDAndRepFormat, $rep))) &&
    (($time !== null) && (preg_match($regexTimeFormat, $time)))) {
        return true;
    }
    return false;
}

// Ensures that there is a valid $_GET request.
if (!(isset($_GET['date'])) || !preg_match($regexDateFormat, $_GET['date']) || (date($_GET['date']) > date("Y-m-d"))) {
    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . date("Y-m-d")));
}

$date = $_GET['date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['submitExerciseRoutineDetailDataButton'])) {
        
        if ($_POST['submitExerciseRoutineDetailDataButton'] === "Add") {
            
            
            if (checkIsBasicPostExerciseRoutineDetailVariablesSet()) {
                

                $exerciseIDForExerciseRoutineDetail = cleanData($_POST['exerciseIDForExerciseRoutineDetail']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnit']);
                $rep = cleanData($_POST['rep']);
                // Note is not needed to be checked if its empty because it is just a note that the user inputs, with no real value.
                $note = isset($_POST['note']) ? cleanData($_POST['note']) : "";
                $time = cleanData($_POST['time']);

                if (validateBasicPostExerciseRoutineDetailData($exerciseIDForExerciseRoutineDetail, $weight, $weightUnit, $rep,
                $time, $regexIDAndRepFormat, $regexWeightFormat, $regexWeightUnitFormat, $regexTimeFormat)) {
                    
                    
                    $exerciseIDForExerciseRoutineDetail = (int) $exerciseIDForExerciseRoutineDetail;
                    $weight = (float) $weight;
                    $rep = (int) $rep;

                    $weight = convertValueOfUnitToKilograms($weight, $weightUnit);
                    
                    if ($userTrackExerciseRoutineDetailModel->verifyExerciseIDToUserID($exerciseIDForExerciseRoutineDetail, $_SESSION['userID'])) {
                        
                       
                        if ($userTrackExerciseRoutineDetailModel->addExerciseRoutineData($date, $_SESSION['userID'])) {
                            $exerciseRoutineData = $userTrackExerciseRoutineDetailModel->getExerciseRoutineDataFromDate($date, $_SESSION['userID']);
                            
                            if (sizeof($exerciseRoutineData) > 0) {
                                $addStatus = $userTrackExerciseRoutineDetailModel->addExerciseRoutineDetailData($weight, $rep, $note, $time, $exerciseIDForExerciseRoutineDetail, $exerciseRoutineData["exerciseRoutineID"], $_SESSION['userID']);
                            
                                if ($addStatus) {
                                    
                                    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
                                }
                            }
                            
                        }
                        
                    }
                    
                }
            }

        } else if ($_POST['submitExerciseRoutineDetailDataButton'] === "Save") {
            
            if (checkIsBasicPostExerciseRoutineDetailVariablesSet() && isset($_POST['exerciseRoutineDetailID'])) {
                
                
                $exerciseRoutineDetailID = cleanData($_POST['exerciseRoutineDetailID']);
                $exerciseIDForExerciseRoutineDetail = cleanData($_POST['exerciseIDForExerciseRoutineDetail']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnit']);
                $rep = cleanData($_POST['rep']);
                // Note is not needed to be checked if its empty because it is just a note that the user inputs, with no real value.
                $note = isset($_POST['note']) ? cleanData($_POST['note']) : "";
                $time = cleanData($_POST['time']);


                if ((validateBasicPostExerciseRoutineDetailData($exerciseIDForExerciseRoutineDetail, $weight, $weightUnit, $rep,
                $time, $regexIDAndRepFormat, $regexWeightFormat, $regexWeightUnitFormat, $regexTimeFormat)) &&
                $exerciseRoutineDetailID !== null && preg_match($regexIDAndRepFormat, $exerciseRoutineDetailID)) {
                    
                    
                    $exerciseRoutineDetailID = (int) $exerciseRoutineDetailID;
                    $weight = (float) $weight;
                    $rep = (int) $rep;

                    $weight = convertValueOfUnitToKilograms($weight, $weightUnit);
                    
                    $exerciseRoutineData = $userTrackExerciseRoutineDetailModel->getExerciseRoutineDataFromDate($date, $_SESSION['userID']);
                    if (sizeof($exerciseRoutineData) > 0) {
                        
                        $updateStatus = $userTrackExerciseRoutineDetailModel->updateExerciseRoutineDetailData($exerciseRoutineDetailID, $weight, $rep, $note, $time, $exerciseIDForExerciseRoutineDetail, $exerciseRoutineData["exerciseRoutineID"], $_SESSION['userID']);
                        if ($updateStatus) {
                            
                            die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
                        }
                    }

                    
                }
            }
        }
    } else if (isset($_POST['submitExerciseDataButton'])) {
        
        
        if ($_POST['submitExerciseDataButton'] === "Add") {
            
            if (checkIsBasicPostExerciseVariablesSet()) {
                
                $exerciseName = cleanData($_POST['exerciseName']);
                
                $addStatus = $userTrackExerciseRoutineDetailModel->addExerciseData($exerciseName, $_SESSION['userID']);
                if ($addStatus) {
                    die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
                }
            }

        } else if ($_POST['submitExerciseDataButton'] === "Save") {
            
            if (checkIsBasicPostExerciseVariablesSet() && isset($_POST["exerciseID"])) {

                $exerciseID = cleanData($_POST['exerciseID']);
                $exerciseName = cleanData($_POST['exerciseName']);
                
                if ($exerciseID != null && preg_match($regexIDAndRepFormat, $exerciseID)) {

                    $exerciseID = (int) $exerciseID;
                    $updateStatus = $userTrackExerciseRoutineDetailModel->updateExerciseData($exerciseID, $exerciseName, $_SESSION['userID']);
                    echo "<script>console.log(" . $exerciseID . ");</script>";
                    if ($updateStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
                    }
                }
                
                
            }
        }

    } else if (isset($_POST['submitDeleteExerciseRoutineDetailDataButton'])) {
        
        if ($_POST['submitDeleteExerciseRoutineDetailDataButton'] === "Delete") {
            
            if (checkIsBasicPostExerciseRoutineDetailVariablesSet() && isset($_POST['exerciseRoutineDetailID'])) {
                
                
                $exerciseRoutineDetailID = cleanData($_POST['exerciseRoutineDetailID']);
                $exerciseIDForExerciseRoutineDetail = cleanData($_POST['exerciseIDForExerciseRoutineDetail']);
                $weight = cleanData($_POST['weight']);
                $weightUnit = cleanData($_POST['weightUnit']);
                $rep = cleanData($_POST['rep']);
                // Note is not needed to be checked if its empty because it is just a note that the user inputs, with no real value.
                $note = isset($_POST['note']) ? cleanData($_POST['note']) : "";
                $time = cleanData($_POST['time']);


                if ((validateBasicPostExerciseRoutineDetailData($exerciseIDForExerciseRoutineDetail, $weight, $weightUnit, $rep,
                $time, $regexIDAndRepFormat, $regexWeightFormat, $regexWeightUnitFormat, $regexTimeFormat)) &&
                $exerciseRoutineDetailID !== null && preg_match($regexIDAndRepFormat, $exerciseRoutineDetailID)) {
                    
                    
                    $exerciseRoutineDetailID = (int) $exerciseRoutineDetailID;
                    $weight = (float) $weight;
                    $rep = (int) $rep;

                    $weight = convertValueOfUnitToKilograms($weight, $weightUnit);
                    
                    $exerciseRoutineData = $userTrackExerciseRoutineDetailModel->getExerciseRoutineDataFromDate($date, $_SESSION['userID']);
                    if (sizeof($exerciseRoutineData) > 0) {
                        $deleteStatus = $userTrackExerciseRoutineDetailModel->deleteExerciseRoutineDetailData($exerciseRoutineDetailID, $exerciseIDForExerciseRoutineDetail, $exerciseRoutineData["exerciseRoutineID"], $_SESSION['userID']);
                        if ($deleteStatus) {
                            
                            die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
                        }
                    }

                    
                }
            }

        }

    } else if (isset($_POST['submitDeleteExerciseDataButton'])) {
        if ($_POST['submitDeleteExerciseDataButton'] === "Delete") {
            if (checkIsBasicPostExerciseVariablesSet() && isset($_POST['exerciseID'])) {
                $exerciseID = cleanData($_POST['exerciseID']);

                if ($exerciseID !== null && preg_match($regexIDAndRepFormat, $exerciseID)) {
                    $exerciseID = (int) $exerciseID;

                    $deleteStatus = $userTrackExerciseRoutineDetailModel->deleteExerciseData($exerciseID, $_SESSION['userID']);
                    
                    if ($deleteStatus) {
                        die(header('location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-exercise-routine-detail.php?date=' . $date));
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
$userTrackExerciseRoutineDetailView = new UserTrackExerciseRoutineDetailView($userTrackExerciseRoutineDetailModel->getExerciseDatasetFromUserID($_SESSION['userID']), $userTrackExerciseRoutineDetailModel->getExerciseRoutineDetailDatasetFromDate($date, $_SESSION['userID']));
$userTrackExerciseRoutineDetailView->renderView();

