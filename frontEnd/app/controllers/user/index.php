<?php
require '../../views/user/pages/userIndexView.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$userIndexView = new UserIndexView($_SESSION['username']);
$userIndexView->renderView();