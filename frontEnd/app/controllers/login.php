<?php
require "../views/guest/pages/guestLogInView.php";
require "../models/guest/guestLogInModel.php";
session_start();
$guestLogInModel = new GuestLogInModel(require "../config/db_connection.php");
$guestLogInView = new GuestLogInView();
$guestLogInView->renderView();
unset($_SESSION['invalidLogin']);


if (isset($_POST['loginButton']) && $_POST['loginButton'] === "Log In") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['invalidLogin'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    } else {
        if ($guestLogInModel->verifyLogInCredentials($username, $password)) {
            // If it's not a user account, its an admin account.
            // No need to do extra checks, until future more usertypes.
            if ($guestLogInModel->isUserAccount($username)) {
                die(header("location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/"));
            } else {
                // TODO: head to admin controller
            }
        }
    }
    
}


