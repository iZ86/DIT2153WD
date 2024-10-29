<?php
require '../../models/user/userMembershipModel.php';
require '../../views/user/pages/membership.php';

$userMembershipModel = new UserMembershipModel(require '../../config/db_connection.php');

// Fetch classes data.
$userMembershipData = $userMembershipModel->getAllMemberInformation();

// Pass the data to the view
$membershipView = new MembershipView($userMembershipData);
$membershipView->renderView();
