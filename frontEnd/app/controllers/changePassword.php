<?php
require "../views/guest/pages/guestChangePasswordView.php";
require "../models/guest/guestChangePasswordModel.php";
session_start();
$guestForgotPasswordModel = new GuestChangePasswordModel(require "../config/db_connection.php");

if (isset($_POST['changePassword']) && $_POST['changePassword'] === "Change Password") {
    if ($_POST['newPassword'] === $_POST['newPasswordRepeat']) {
        $password = $_POST['newPassword'];
        $guestForgotPasswordModel->changePassword($_SESSION["changePasswordEmail"], $password);
        unsetSessionVariablesForSelf();
        die(header("location: http://localhost/DIT2153WD/frontEnd/app/controllers/login.php"));
    } else {
        $_SESSION['invalidChangePassword'] = 1;
    }
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $email = $guestForgotPasswordModel->verifyToken($token);
    if (isset($email)) {
        $_SESSION['changePasswordEmail'] = $email;
        $guestChangePasswordView = new GuestChangePasswordView();
        $guestChangePasswordView->renderView();
        unsetSessionVariablesForSelf();
    }
}

/** Unsets all the session variables that is used by this controller only. */ 
function unsetSessionVariablesForSelf() {
    unset($_SESSION['changePasswordEmail']);
}

