<?php
require '../../models/user/userProfileModel.php';
require '../../views/user/pages/profile.php';

$userProfileModel = new UserProfileModel(require '../../config/db_connection.php');

// Fetch classes data.
$userData = $userProfileModel->getAllUserInformation();

// Pass the data to the view
$profileView = new ProfileView($userData);
$profileView->renderView();
