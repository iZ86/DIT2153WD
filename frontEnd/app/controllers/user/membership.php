<?php
require '../../views/user/pages/userMembershipView.php';
require '../../models/user/userMembershipModel.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$userMembershipModel = new UserMembershipModel(require '../../config/db_connection.php');
$activeMembershipSubscriptionData = $userMembershipModel->getActiveMembershipSubscriptionData($_SESSION['userID']);
// If the data is empty, there is no active membership subscription.
if (sizeof($activeMembershipSubscriptionData) > 0) {
    $sumPriceOfFitnessClassSubscription = $userMembershipModel->getSumPriceOfFitnessClassSubscriptionToPaymentID($activeMembershipSubscriptionData['paymentID']);
    $totalPrice = $activeMembershipSubscriptionData['price'];
    $totalPrice += sizeof($sumPriceOfFitnessClassSubscription) > 0 ? $sumPriceOfFitnessClassSubscription['sumPriceOfFitnessClassSubscriptionToPaymentID'] : 0;

    $userMembershipView = new UserMembershipView($activeMembershipSubscriptionData, $totalPrice);
    $userMembershipView->renderView();
} else {
    $userMembershipView = new UserMembershipView($activeMembershipSubscriptionData, 0);
    $userMembershipView->renderView();

}

