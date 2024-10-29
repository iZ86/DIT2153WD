<?php
require '../../models/user/userPaymentModel.php';
require '../../views/user/pages/payment.php';

$userPaymentModel = new UserPaymentModel(require '../../config/db_connection.php');

// Fetch classes data.
$userPaymentData = $userPaymentModel->getAllUserPaymentInformation();

// Pass the data to the view
$paymentView = new PaymentView($userPaymentData);
$paymentView->renderView();
