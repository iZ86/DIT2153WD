<?php
require '../../models/user/userPaymentModel.php';
require '../../views/user/pages/payment.php';

$userPaymentModel = new UserPaymentModel(require '../../config/db_connection.php');

// Fetch classes data.
$userPaymentData = $userPaymentModel->getAllUserPaymentInformation();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['subscribe'])) {

    }
}
// Pass the data to the view
$paymentView = new PaymentView($userPaymentData);
$paymentView->renderView();
