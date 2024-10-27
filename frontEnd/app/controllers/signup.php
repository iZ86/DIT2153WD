<?php
require "../views/guest/pages/guestSignUpView.php";
require "../models/guest/guestSignUpModel.php";
session_start();
$guestSignUpModel = new GuestSignUpModel(require "../config/db_connection.php");

if (isset($_POST['signupButton']) && $_POST['signupButton'] === "Sign Up") {
    // save user input
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['phoneNo'] = $_POST['phoneNo'];
    $_SESSION['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['dateOfBirth'] = $_POST['dateOfBirth'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['termsAndConditions'] = $_POST['termsAndConditions'];
    $_SESSION['joinedDate'] = date("Y-m-d");
    $keys = array('email', 'password', 'username', 'phoneNo', 'firstName', 'lastName', 'dateOfBirth', 'gender', 'termsAndConditions');

    // check if username already exist
    if (!$guestSignUpModel->checkExistingUser($_SESSION['username'])) {
        $_SESSION['invalidSignUp'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // check if any input is empty or not set
    foreach ($keys as $k) {
        if (empty($_SESSION[$k]) || !isset($_SESSION[$k])) {
            $_SESSION['invalidSignUp'] = 1;
            die(header("location: " . $_SERVER['PHP_SELF']));         
        }
    }

    // check if date of birth is invalid date
    if ($_SESSION['dateOfBirth'] == "0000-00-00") {
        $_SESSION['invalidSignUp'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));         
    }

    $signUp = $guestSignUpModel->createUser($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['username'], $_SESSION['password'], $_SESSION['email'], $_SESSION['phoneNo'], $_SESSION['gender'], $_SESSION['dateOfBirth'], "", $_SESSION['joinedDate']);

    // check if successful registration
    if ($signUp == 1) {
        $_SESSION['invalidSignUp'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }
}

$guestSignUpView = new GuestSignUpView();
$guestSignUpView->renderView();
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['username']);
unset($_SESSION['phoneNo']);
unset($_SESSION['firstName']);
unset($_SESSION['lastName']);
unset($_SESSION['dateOfBirth']);
unset($_SESSION['gender']);
unset($_SESSION['termsAndConditions']);
unset($_SESSION['joinedDate']);
unset($_SESSION['invalidSignUp']);
