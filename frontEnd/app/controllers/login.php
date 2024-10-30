<?php
require "../views/guest/pages/guestLogInView.php";
require "../models/guest/guestLogInModel.php";
session_start();
$guestLogInModel = new GuestLogInModel(require "../config/db_connection.php");


if (isset($_POST['loginButton']) && $_POST['loginButton'] === "Log In") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['usernameInput'] = $username;
        $_SESSION['passwordInput'] = $password;
        $_SESSION['keepMeLoggedInInput'] = isset($_POST['keepMeLoggedInCheckBox']) ? $_POST['keepMeLoggedInCheckBox'] : "off";
        $_SESSION['invalidLogin'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    } else {
        if ($guestLogInModel->verifyLogInCredentials($username, $password)) {

            // If it's not a user account, its an admin account.
            // No need to do extra checks, until future more usertypes.
            if ($guestLogInModel->isUserAccount($username)) {

                // userID is the same as registeredUserID.
                $_SESSION['username'] = $username;
                $_SESSION['userID'] = $guestLogInModel->getRegisteredUserID($username);
                die(header("location: ../controllers/user/"));
            } else {
                // adminID is the same as registeredUserID.
                $_SESSION['username'] = $username;
                $_SESSION['adminID'] = $guestLogInModel->getRegisteredUserID($username);
                die(header("location: ../controllers/admin/"));
            }
        } else {
            $_SESSION['usernameInput'] = $username;
            $_SESSION['passwordInput'] = $password;
            $_SESSION['keepMeLoggedInInput'] = isset($_POST['keepMeLoggedInCheckBox']) ? $_POST['keepMeLoggedInCheckBox'] : "off";
            $_SESSION['invalidLogin'] = 1;
            die(header("location: ". $_SERVER['PHP_SELF']));
        }
    }

}

$guestLogInView = new GuestLogInView();
$guestLogInView->renderView();
unset($_SESSION['invalidLogin']);
unset($_SESSION['usernameInput']);
unset($_SESSION['passwordInput']);
unset($_SESSION['keepMeLoggedInInput']);


