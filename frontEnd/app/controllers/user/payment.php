<?php
session_start();
require '../../models/user/userPaymentModel.php';
require '../../views/user/pages/userPaymentView.php';

/** Set the timezone for Malaysia. */
date_default_timezone_set('Asia/Kuala_Lumpur');
$userPaymentModel = new UserPaymentModel(require '../../config/db_connection.php');

/** Regex for ID validation. */
$regexIDFormat = "/^(0|[1-9][\d]*)$/";

/** Regex for fitness class name format. */
$regexFitnessClassNameFormat = "/^[a-zA-z]+$/";

/** Regex for fitness class value validation. */
$regexFitnessClassValueFormat = "/^1$/";

/** Regex for email address. */
$regexForEmailAddress = "/^[a-zA-Z0-9-_+%.]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/";

/** Cleans the data. */
function cleanData($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

/** Validate DATA format.
 * Ensures that all the data is integer, and is not empty.
*/
function validateData($data, $regex) {
    return ($data !== null && preg_match($regex, $data));
}

/** Checks for format of the GET request.
 * Returns true, under these scenarios.
 * If there is membershipID, and/or fitnessClasses.
 * If there is nutritionistScheduleID ONLY.
 * Otherwise, returns false.
 * The fitnessClasses and the ID's will be later on verified in the database.
 */
function isGetRequestFormatValid() {
    if (isset($_GET['membershipID']) && isset($_GET['nutritionistScheduleID'])) {
        return false;
    } else if (isset($_GET['nutritionistScheduleID']) && sizeof($_GET) > 1) {
        return false;
    }
    return true;
}


function checkIsBasicPostVariablesSet() {
    if (isset($_POST['email']) && isset($_POST['firstName']) && isset($_POST['lastName'])
    && isset($_POST['address']) && isset($_POST['country']) && isset($_POST['zipCode'])
    && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['phoneNumber'])) {
        return true;
    }
    return false;
}

function checkIsPostVariableNotEmpty() {
    return ($_POST['email'] !== null && $_POST['firstName'] !== null && $_POST['lastName'] !== null && $_POST['address'] !== null &&
    $_POST['country'] !== null && $_POST['zipCode'] !== null && $_POST['city'] !== null && $_POST['state'] !== null && $_POST['phoneNumber']);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    if (isset($_POST['submitPayNow']) && $_POST['submitPayNow'] === "Pay Now") {
        
        if (checkIsBasicPostVariablesSet() && checkIsPostVariableNotEmpty()) {
            if (isGetRequestFormatValid()) {
                
                if (isset($_GET['membershipID'])) {
                    $membershipID = cleanData($_GET['membershipID']);
            
                    if (validateData($membershipID, $regexIDFormat)) {


                        unset($_GET['membershipID']);
                        $fitnessClassNames = array();
                        
                        // Validates the other GET request parameter and values.
                        // Ensures that they are valid fitness classes.
                        // Otherwise, redirect user to error.php.
                        foreach ($_GET as $key => $value) {
                            $key = cleanData($key);
                            $value = cleanData($value);
            
                            if ((validateData($key, $regexFitnessClassNameFormat) &&
                            validateData($value, $regexFitnessClassValueFormat))) {
                                $fitnessClassNames[] = $key;
                            } else {
                                die(header('location: error.php'));
                            }
                        }

                        
                        $paymentStatus = $userPaymentModel->userMakeMembershipSubscriptionPurchase($membershipID, $fitnessClassNames, $_SESSION['userID'], "card");
                        
                        if ($paymentStatus) {

                            // Redirect nicely.
                            die(header('location: index.php'));

                        } else {
                            die(header('location: error.php'));
                        }
                    }     
            
                } else if (isset($_GET['nutritionistScheduleID'])) {
                    $nutritionistScheduleID = cleanData($nutritionistScheduleID);
                    if (validateData($nutritionistScheduleID, $regexIDFormat)) {

                        $paymentStatus = $userPaymentModel->userMakeNutritionistSchedulePurchase($nutritionistScheduleID);
                        
                        if ($paymentStatus) {
                            die(header('location: index.php'));
                        } else {
                            die(header("location: error.php"));
                        }
                    }
                }
            }
        }
    }
}



if (isGetRequestFormatValid()) {
    if (isset($_GET['membershipID'])) {
        $membershipID = cleanData($_GET['membershipID']);

        if (validateData($membershipID, $regexIDFormat)) {

            // To go through the other parameters in the GET request, will be set back.
            unset($_GET['membershipID']);

            $fitnessClassNames = array();
            
            // Validates the other GET request parameter and values.
            // Ensures that they are valid fitness classes.
            // Otherwise, redirect user to error.php.
            foreach ($_GET as $key => $value) {
                $key = cleanData($key);
                $value = cleanData($value);

                if ((validateData($key, $regexFitnessClassNameFormat) &&
                validateData($value, $regexFitnessClassValueFormat))) {
                    $fitnessClassNames[] = $key;
                }
            }

            $memberSubscriptionData = $userPaymentModel->getMembershipSubscriptionData($membershipID, $fitnessClassNames);
            if (sizeof($memberSubscriptionData) > 0) {

                // To be used for POST request later.
                $_GET['membershipID'] = $membershipID;

                $paymentView = new UserPaymentView($memberSubscriptionData);
                $paymentView->renderView();
            } else {
                die(header("location: error.php"));
            }
        }
        
    } else if (isset($_GET['nutritionistScheduleID'])) {
        $nutritionistScheduleID = cleanData($nutritionistScheduleID);
        if (validateData($nutritionistScheduleID, $regexIDFormat)) {

            $nutritionistSchedulePurchaseData = $userPaymentModel->GetNutritionistSchedulePurchaseData($nutritionistScheduleID);
            
            if (sizeof($nutritionistSchedulePurchaseData) > 0) {
                $paymentView = new UserPaymentView($nutritionistSchedulePurchaseData);
                $paymentView->renderView();
            } else {
                die(header("location: error.php"));
            }
        }

    }
}





