<?php
require('../../views/user/pages/userMembershipSubscriptionDetailView.php');
require('../../models/user/userMembershipSubscriptionDetailModel.php');
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$regexIDFormat = "/^(0|[1-9][\d]*)$/";

// Invalid membership ID in Get request.
if (isset($_GET['membershipID']) && preg_match($regexIDFormat, $_GET['membershipID'])) {

    $userMembershipSubscriptionDetailModel = new UserMembershipSubscriptionDetailModel(require "../../config/db_connection.php");
    $membershipID = $_GET['membershipID'];
    $membershipData = $userMembershipSubscriptionDetailModel->getMembershipData($membershipID);
    if (sizeof($membershipData) > 0) {

        $fitnessClassDataset = $userMembershipSubscriptionDetailModel->getFitnessClassDataset();
        $userMembershipSubscriptionDetailView = new UserMembershipSubscriptionDetailView($fitnessClassDataset, $membershipData);
        $userMembershipSubscriptionDetailView->renderView();




    } else {
        die(header('location: error.php'));
    }

} else {
    die(header('location: error.php'));
}


