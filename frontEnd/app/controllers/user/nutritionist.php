<?php
require '../../models/nutritionistModel.php';
require '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');

/** Retrieve booking information from view by using $_POST.
 * Use ?? to provide a default null value, if the $_POST doesn't retrieve it.
 */
function getBookingInformation() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nutritionist = $_POST['nutritionist'] ?? null;
        $date = $_POST['date'] ?? null;
        $time = $_POST['time'] ?? null;
        $description = $_POST['desc'] ?? null;

        if (!empty($nutritionist) && !empty($date) && !empty($time)) {
            global $nutritionistModel;

            // Create the booking
            if ($nutritionistModel->createNutritionistBooking(
                $nutritionist,
                $description,
                date('Y-m-d', strtotime($date)),
                $time
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
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist(), $nutritionistModel->getAllNutritionistScheduleInformation());
$nutritionistsView->renderView();
getBookingInformation();