<?php
session_start();
ob_start();
require '../../models/nutritionistModel.php';
require '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');
$nutritionistAvailableDateTime = [];

/** Cleans the data. */
function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkIsBasicPostVariablesSet() {
    if (isset($_POST['nutritionist']) && isset($_POST['date-time']) && isset($_POST['desc'])) {
        return true;
    }
    return false;
}

// Check if only 'nutritionistID' is set for fetching dates
if (isset($_POST['nutritionistID'])) {
    $nutritionistID = $_POST['nutritionistID'];

    // Fetch available date and time slots for the nutritionist
    $nutritionistAvailableDateTime = $nutritionistModel->getAllNutritionistAvailableDateTimeById($nutritionistID);

    $availableDateTimes = [];

    if ($nutritionistAvailableDateTime) {
        foreach ($nutritionistAvailableDateTime as $dateTime) {
            // Check if the slot is already booked using the schedule ID
            if (!$nutritionistModel->isScheduleIDBooked($dateTime['nutritionistScheduleID'])) {
                // Add the date and time to available slots if not booked
                $availableDateTimes[] = $dateTime['scheduleDateTime'];
            }
        }
    }

    // Return available datetime slots as JSON
    echo json_encode(['success' => true, 'data' => $availableDateTimes]);
    exit;
}


/** Retrieve booking information from view by using $_POST.
 * Use ?? to provide a default null value, if the $_POST doesn't retrieve it.
 */
function getBookingInformation() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if($_POST['confirm-booking-nutritionist']) {
            if($_POST['confirm-booking-nutritionist'] === "Confirm") {
                if(checkIsBasicPostVariablesSet()) {
                    $nutritionistID = cleanData($_POST['nutritionist']) ?? null;
                    $nutritionistSchedule = cleanData($_POST['date-time']) ?? null;
                    $description = cleanData($_POST['desc']) ?? null;
                    $username = $_SESSION['userID'];
                    if (!empty($nutritionistID) && !empty($nutritionistSchedule) && !empty($username)) {
                        global $nutritionistModel;
                        echo $nutritionistID . $nutritionistSchedule . $description . $username;
                        $nutritionistScheduleData = $nutritionistModel->getNutritionistScheduleIdByNutritionistIdAndScheduleDateTime($nutritionistID, $nutritionistSchedule);

                        if ($nutritionistScheduleData) {
                            $nutritionistScheduleID = $nutritionistScheduleData ? $nutritionistScheduleData['nutritionistScheduleID'] : null;
                            $_SESSION['description'] = $description;
                            $_SESSION['nutritionistScheduleID'] = $nutritionistScheduleID;
                            $price = $nutritionistModel->getNutritionistSchedulePriceByNutritionistScheduleID($nutritionistScheduleID);
                            $price = $price['price'];
                            header("Location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/user-payment.php?order=Nutritionist Booking&price=$price");
                            exit();
                        } else {
                            echo "<script>alert('Failed to Make a Reservation. Please try again.');</script>";
                        }
                    } else {
                        echo "<script>alert('Please fill in all required fields.');</script>";
                    }
                }
            }
        }
    }
}

/** Fetch nutritionists for display in the view. */
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist(), $nutritionistAvailableDateTime);
$nutritionistsView->renderView();
getBookingInformation();
ob_end_flush();
unset($_SESSION['description']);
unset($_SESSION['nutritionistScheduleID']);