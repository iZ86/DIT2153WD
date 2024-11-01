<?php
require '../../views/user/pages/userBillingView.php';
require '../../models/user/userBillingModel.php';
session_start();

$regexPageFormat = "/^(0|[1-9][\d]*)$/";

if (!isset($_GET['page']) || !preg_match($regexPageFormat, $_GET['page'])) {
    die(header('location: billing.php?page=1'));
}

$page = $_GET['page'];
$limit = 10;
$offset = ($page - 1) * $limit;

$userBillingModel = new UserBillingModel(require '../../config/db_connection.php');
$userBillingView = new UserBillingView($userBillingModel->getTransactionHistoryDataset($_SESSION['userID'], $limit, $offset));
$userBillingView->renderView();