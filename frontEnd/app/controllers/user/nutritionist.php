<?php
require '../../models/nutritionistModel.php';
require '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');
$nutritionistAvailableDateTime = [];
// Check if only 'nutritionistID' is set for fetching dates
if (isset($_POST['nutritionistID'])) {
    $nutritionistID = $_POST['nutritionistID'];

    // Fetch available date and time
    $nutritionistAvailableDateTime = $nutritionistModel->getAllNutritionistAvailableDateTimeById($nutritionistID);

    $availableDateTimes = [];
    if ($nutritionistAvailableDateTime) {
        foreach ($nutritionistAvailableDateTime as $dateTime) {
            $availableDateTimes[] = $dateTime['scheduleDateTime']; // Store datetime values
        }
    }

    // Return available datetime slots
    echo json_encode(['success' => true, 'data' => $availableDateTimes]);
    exit;
}

/** Retrieve booking information from view by using $_POST.
 * Use ?? to provide a default null value, if the $_POST doesn't retrieve it.
 */
function getBookingInformation() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nutritionist = $_POST['nutritionist'] ?? null;
        $nutritionistScheduleID = $_POST['date-time'] ?? null;
        $description = $_POST['desc'] ?? null;
        $username = $_SESSION['userID'];
        if (!empty($nutritionist) && !empty($nutritionistScheduleID) && !empty($username)) {
            global $nutritionistModel;
            echo $nutritionistScheduleID . $description . $username;

            if ($nutritionistModel->createNutritionistBooking(
                $nutritionistScheduleID,
                $description,
                            $username,
                            1
            )) {

                echo "<script>alert('Successfully Made a Reservation!!');</script>";
            } else {
                echo "<script>alert('Failed to Make a Reservation. Please try again.');</script>";
            }

        } else {
            echo "<script>alert('Please fill in all required fields.');</script>";
        }
    }
}


/** Fetch nutritionists for display in the view. */
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist(), $nutritionistAvailableDateTime);
$nutritionistsView->renderView();
getBookingInformation();