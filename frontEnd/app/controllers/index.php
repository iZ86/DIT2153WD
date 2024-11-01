<?php
require "../views/guest/pages/guestIndexView.php";
session_start();

if (isset($_POST['submit']) && $_POST['submit'] === "Join Us Today!") {
    die(header("location: ../controllers/signup.php"));
}

$guestIndexView = new GuestIndexView();
$guestIndexView->renderView();