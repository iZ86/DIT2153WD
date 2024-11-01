<?php
require '../../views/admin/pages/AdminPaymentsView.php';
require '../../models/admin/AdminPaymentsModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminPaymentsModel = new AdminPaymentsModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editPaymentButton'])) {
        $paymentID = intval($_POST['paymentID']);
        $type = trim($_POST['type']);
        $status = trim($_POST['status']);
        $createdOn = trim($_POST['createdOn']);
        $userID = intval($_POST['userID']);

        // Check if all required fields are filled
        if (!empty($paymentID) && !empty($type) && !empty($status) && !empty($createdOn) && !empty($userID)) {
            $adminPaymentsModel->editPayment($paymentID, $type, $status, $createdOn, $userID);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$limit = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

// Filter payments based on selected filter type and keywords
$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

if (!empty($filterType) && !empty($keywords)) {
    $payments = $adminPaymentsModel->getFilteredPayments($limit, $offset, $filterType, $keywords);
} else {
    $payments = $adminPaymentsModel->getAllPayments($limit, $offset);
}

$noPaymentsFound = $payments->num_rows === 0;

$totalPagesPayments = ceil($payments->num_rows / $limit);

$users = $adminPaymentsModel->getAllUsers();
$adminPaymentsView = new AdminPaymentsView($payments, $adminPaymentsModel, $users, $totalPagesPayments, $currentPage);
$adminPaymentsView->renderView();