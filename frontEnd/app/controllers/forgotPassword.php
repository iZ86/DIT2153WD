<?php
require "../views/guest/pages/guestForgotPasswordView.php";
require "../models/guest/guestForgotPasswordModel.php";
session_start();
$guestForgotPasswordModel = new GuestForgotPasswordModel(require "../config/db_connection.php");

if (isset($_POST['request']) && $_POST['request'] === "Request") {
    $email = $_POST['email'];

    // check if email is empty
    if (empty($email)) {
        $_SESSION['invalidForgotPassword'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));
    } 

    // check if email exist with account
    if (!$guestForgotPasswordModel->verifyUserExist($email)) {
        $_SESSION['invalidForgotPassword'] = 2;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // generate token in database
    $token = $guestForgotPasswordModel->generateToken($email);

    // send email and redirect to change password
    if ($guestForgotPasswordModel->sendEmail($email, $token)) {
        die(header("location: " . $_SERVER['PHP_SELF']));
    }
}

$guestForgotPasswordView = new GuestForgotPasswordView();
$guestForgotPasswordView->renderView();