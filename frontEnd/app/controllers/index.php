<?php
require "../views/guest/pages/guestIndexView.php";
session_start();


if (isset($_SESSION['userID'])) {
    header("Location: user/");
    exit;
} else if (isset($_SESSION['adminID'])) {
    header("Location: admin/");
    exit;
}

if (isset($_POST['submit']) && $_POST['submit'] === "Join Us Today!") {
    die(header("location: ../controllers/signup.php"));
}

$guestIndexView = new GuestIndexView();
$guestIndexView->renderView();