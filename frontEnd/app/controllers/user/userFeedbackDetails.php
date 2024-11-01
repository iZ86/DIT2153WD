<?php
require '../../views/user/pages/userFeedbackDetailsView.php';
require '../../models/user/userFeedbackDetailsModel.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}
