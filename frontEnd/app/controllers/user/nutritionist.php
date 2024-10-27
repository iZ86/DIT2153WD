<?php
require '../../models/nutritionistModel.php';
require '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');

/** Retrieve booking information from view by using $_POST.
 * Use ?? to provide a default null value, if the $_POST doesn't retrieve it.
 */
function getBookingInformation() {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['desc'])) {
        $nutritionist = $_POST['nutritionist'] ?? null;
        $date = $_POST['date'] ?? null;
        $time = $_POST['time'] ?? null;
        $description = $_POST['desc'] ?? null;
        $makeReservation = isset($_POST['make-reservation']);

        // Test if it can retreive the data.
        echo $nutritionist . $date . $time . $description . $makeReservation;
        /** Ensure required fields are not empty. */
        if ($nutritionist && $date && $time) {
            global $nutritionistModel;
            if($nutritionistModel->nutritionistsBookingHandler(
                $nutritionist,
                date('Y-m-d', strtotime($date)),
                $time,
                $description,
                $makeReservation
            )) {
                echo "<script>alert('Succesfully Made a Reservation!!');</script>";
            }
        }
    }
}

/** Fetch nutritionists for display in the view. */
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist());
$nutritionistsView->renderView();
getBookingInformation();