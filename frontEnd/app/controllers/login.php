<?php
require "../views/guest/pages/guestLogInView.php";
require "../models/guest/guestLogInModel.php";
session_start();
$guestLogInModel = new GuestLogInModel(require "../config/db_connection.php");
$guestLogInView = new GuestLogInView();
$guestLogInView->renderView();
unset($_SESSION['invalidLogin']);


if (isset($_POST['loginButton']) && $_POST['loginButton'] === "Log In") {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['invalidLogin'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    } else {
        if ($guestLogInModel->verifyLogInCredentials($_POST['username'], $_POST['password'])) {
            // If it's not a user account, its an admin account.
            // No need to do extra checks, until future more usertypes.
            if ($guestLogInModel->isUserAccount($_POST['username'])) {
                die(header("location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/"));
            } else {
                // TODO: head to admin controller
            }
        }
    }
    
}


