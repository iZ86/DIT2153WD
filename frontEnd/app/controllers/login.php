<?php
require "../views/guest/pages/guestLogInView.php";
require "../models/guest/guestLogInModel.php";
session_start();
$guestLogInModel = new GuestLogInModel(require "../config/db_connection.php");


if (isset($_POST['loginButton']) && $_POST['loginButton'] === "Log In") {
    // Save user input to persist data even after error
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['usernameInput'] = $username;
    $_SESSION['passwordInput'] = $password;
    $accType = 0;

    // Error Checking: Check for empty fields
    if (empty($username) || empty($password)) {
        $_SESSION['loginError'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    }

    // Error Checking: Check if account exists
    if ($guestLogInModel->verifyLogInCredentials($username, $password)) {
        // Check if it's user account. If it's not a user account, its an admin account.
        if ($guestLogInModel->isUserAccount($username)) {
            $accType = 1;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $guestLogInModel->getIDFromUsername($username);

            // Error Checking: Check if email is verified
            if (!$guestLogInModel->checkVerifiedEmail($username)) {
                $_SESSION['loginError'] = 3;
                die(header("location: ". $_SERVER['PHP_SELF']));
            }

        } else {
            $accType = 2;
            $_SESSION['username'] = $username;
            $_SESSION['adminID'] = $guestLogInModel->getIDFromUsername($username);
        }
    } else {
        $_SESSION['loginError'] = 2;
        die(header("location: ". $_SERVER['PHP_SELF']));
    }

    // No errors, redirect to user or admin page
    if ($accType === 1) {
        die(header("location: http://localhost/DIT2153WD/frontEnd/app/controllers/user/"));
    } else if ($accType === 2) {
        die(header("location: http://localhost/DIT2153WD/frontEnd/app/controllers/admin/"));
    }
}

if (isset($_GET['token'])) {
    // get token from url
    $token = $_GET['token'];

    // Error Checking: Verify the token
    $email = $guestLogInModel->verifyToken($token);
    if (!$email) {
        $_SESSION['loginVerificationError'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    }

    // Update account verification, and redirect to login
    $guestLogInModel->updateAccountVerification($email);
    $_SESSION['loginVerificationError'] = 0;
    die(header("location: ". $_SERVER['PHP_SELF']));
}

$guestLogInView = new GuestLogInView();
$guestLogInView->renderView();
unset($_SESSION['loginError']);
unset($_SESSION['loginVerificationError']);
unset($_SESSION['usernameInput']);
unset($_SESSION['passwordInput']);


