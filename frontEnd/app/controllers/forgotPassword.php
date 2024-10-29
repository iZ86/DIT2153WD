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
        unsetSessionVariablesForSelf();
        die(header("location: " . $_SERVER['PHP_SELF']));
    } 

    // check if email exist with account
    if (!$guestForgotPasswordModel->verifyUserExist($email)) {
        $_SESSION['invalidForgotPassword'] = 2;
        unsetSessionVariablesForSelf();
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // generate token in database
    $token = $guestForgotPasswordModel->generateToken($email);

    // send email and redirect to change password
    if ($guestForgotPasswordModel->sendEmail($email, $token)) {
        $_SESSION['forgotPasswordEmail'] = $email;
        unsetSessionVariablesForSelf();
    }
}

// Unsets all the session variables that is used by this controller only.
function unsetSessionVariablesForSelf() {
    unset($_SESSION['forgotPasswordEmail']);
}

$guestForgotPasswordView = new GuestForgotPasswordView();
$guestForgotPasswordView->renderView();
unsetSessionVariablesForSelf();