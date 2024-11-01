<?php
require "../views/guest/pages/guestForgotPasswordView.php";
require "../models/guest/guestForgotPasswordModel.php";
session_start();

if (isset($_SESSION['userID'])) {
    header("Location: user/");
    exit;
} else if (isset($_SESSION['adminID'])) {
    header("Location: admin/");
    exit;
}

$guestForgotPasswordModel = new GuestForgotPasswordModel(require "../config/db_connection.php");

if (isset($_POST['request']) && $_POST['request'] === "Request") {
    $email = $_POST['email'];

    // Error Checking: Check if email is empty
    if (empty($email)) {
        $_SESSION['forgotPasswordError'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));
    } 

    // Error Checking: Check if email exist with account
    if (!$guestForgotPasswordModel->verifyUserExist($email)) {
        $_SESSION['forgotPasswordError'] = 2;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // generate token in database
    $token = $guestForgotPasswordModel->generateToken($email);

    // send email and redirect to change password
    if ($guestForgotPasswordModel->sendEmail($email, $token)) {
        $_SESSION['forgotPasswordSuccess'] = 0;
        die(header("location: " . $_SERVER['PHP_SELF']));
    } else {
        $_SESSION['forgotPasswordError'] = 3;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }
}

$guestForgotPasswordView = new GuestForgotPasswordView();
$guestForgotPasswordView->renderView();
unset($_SESSION['forgotPasswordError']);
unset($_SESSION['forgotPasswordSuccess']);