<?php
require "../views/guest/pages/guestChangePasswordView.php";
require "../models/guest/guestChangePasswordModel.php";
session_start();
$guestChangePasswordModel = new GuestChangePasswordModel(require "../config/db_connection.php");

// Only render the page if token is corrent
if (isset($_GET['token'])) {
    // get token from url
    $token = $_GET['token'];
    $_SESSION['changePasswordToken'] = $token;

    // Error Checking: Verify the token, redirect to forgot password if token is fake
    $email = $guestChangePasswordModel->verifyToken($token);
    if (!$email) {
        $_SESSION["changePasswordError"] = 1;
        die(header("location: ../controllers/forgotPassword.php"));
    }

    // If user click change password button, update the password in the database
    if (isset($_POST['changePassword']) && $_POST['changePassword'] === "Change Password") {

        // Error Checking: Check for empty fields
        if (empty($_POST['newPassword']) || empty($_POST['newPasswordRepeat'])) {
            $_SESSION['changePasswordError'] = 2;
            die(header("location: ". $_SERVER['PHP_SELF'] . "?token=" . $token));
        }

        // Error Checking: Check if passwords match
        if ($_POST['newPassword'] !== $_POST['newPasswordRepeat']) {
            $_SESSION['changePasswordError'] = 3;
            die(header("location: ". $_SERVER['PHP_SELF'] . "?token=" . $token));
        }

        $guestChangePasswordModel->changePassword($email, $_POST["newPassword"]);
        $_SESSION['changePasswordSuccess'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF'] . "?token=" . $token));

    }

    $guestChangePasswordView = new GuestChangePasswordView();
    $guestChangePasswordView->renderView();
    /** Unsets all the session variables that is used by this controller only. */
    unset($_SESSION['changePasswordToken']);
    unset($_SESSION['changePasswordError']);
    unset($_SESSION['changePasswordSuccess']);
} else {
    // redirect to forgot password if there is no token in url
    die(header("location: ../controllers/forgotPassword.php"));
}

