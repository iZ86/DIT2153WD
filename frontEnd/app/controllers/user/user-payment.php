<?php
session_start();
require '../../models/user/userPaymentModel.php';
require '../../views/user/pages/paymentView.php';

/** Set the timezone for Malaysia. */
date_default_timezone_set('Asia/Kuala_Lumpur');
$userPaymentModel = new UserPaymentModel(require '../../config/db_connection.php');

// Fetch classes data.
$userPaymentData = $userPaymentModel->getAllUserPaymentInformation();

/** Cleans the data. */
function cleanData($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkIsBasicPostVariablesSet() {
    if (isset($_POST['email']) && isset($_POST['firstName']) && isset($_POST['lastName'])
    && isset($_POST['adrress']) && isset($_POST['country']) && isset($_POST['zipCode'])
    && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['phoneNumber'])) {
        return true;
    }
    return false;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['subscribe'])) {
        if($_POST['subscribe'] === "Subscribe") {
            $email = cleanData($_POST['email']);
            $firstName = cleanData($_POST['firstName']);
            $lastName = cleanData($_POST['lastName']);
            $address = cleanData($_POST['address']);
            $country = cleanData($_POST['country']);
            $zipCode = cleanData($_POST['zipCode']);
            $country = cleanData($_POST['city']);
            $state = cleanData($_POST['state']);
            $phoneNumber = cleanData($_POST['phoneNumber']);
            $type = isset($_GET['order']) ? cleanData($_GET['order']) : null;
            $status = "Completed";
            $createdOn = date('Y-m-d H:i:s');
            $nutritionistBookingDescription = isset($_SESSION['description']) ? cleanData($_SESSION['description']) : null;
            $nutritionistScheduleID = isset($_SESSION['nutritionistScheduleID']) ? cleanData($_SESSION['nutritionistScheduleID']) : null;

            $userPaymentModel->createUserPayment($type, $status, $createdOn, $_SESSION['userID']);
            $paymentID = $userPaymentModel->getPaymentIDByTypeCreatedOnAndUserID($type, $createdOn, htmlspecialchars($_SESSION['userID']));

            if ($paymentID) {
                // Check if the schedule is already booked
                if ($userPaymentModel->isScheduleIDBooked($nutritionistScheduleID)) {
                    echo "<script>alert('This schedule is already booked.Please select a different schedule.'); window.location.href='http://localhost/DIT2153WD/frontEnd/app/controllers/user/nutritionist.php';</script>";
                } else {
                    $bookingResult = $userPaymentModel->createNutritionistBooking($nutritionistBookingDescription, $nutritionistScheduleID, $_SESSION['userID'], $paymentID['paymentID']);
                    if ($bookingResult === true) {
                        echo "<script>alert('Succesfully booked the Nutritionist. Please make sure be on time!'); window.location.href='http://localhost/DIT2153WD/frontEnd/app/controllers/user/nutritionist.php';</script>";
                    } else {
                        echo "<script>alert('Error: " . htmlspecialchars($bookingResult) . "');</script>";
                    }
                }
            }
        }
    }
}
// Pass the data to the view
$paymentView = new PaymentView($userPaymentData);
$paymentView->renderView();