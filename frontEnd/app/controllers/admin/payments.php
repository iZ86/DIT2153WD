<?php
require '../../views/admin/pages/AdminPaymentsView.php';
require '../../models/admin/AdminPaymentsModel.php';
session_start();

$adminPaymentsModel = new AdminPaymentsModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editPaymentButton'])) {
        $paymentID = intval($_POST['paymentID']);
        $type = trim($_POST['type']);
        $status = trim($_POST['status']);
        $createdOn = trim($_POST['createdOn']);
        $userID = intval($_POST['userID']);

        if (!empty($paymentID) && !empty($type) && !empty($status) && !empty($createdOn) && !empty($userID)) {
            $adminPaymentsModel->editPayment($paymentID, $type, $status, $createdOn, $userID);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$payments = $adminPaymentsModel->getAllPayments();
if ($payments->num_rows === 0) {
    echo "No payments found.";
    exit;
}

$users = $adminPaymentsModel->getAllUsers();
$payments = $adminPaymentsModel->getAllPayments();
$adminPaymentsView = new AdminPaymentsView($payments, $adminPaymentsModel, $users);
$adminPaymentsView->renderView();