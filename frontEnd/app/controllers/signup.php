<?php
require "../views/guest/pages/guestSignUpView.php";
require "../models/guest/guestSignUpModel.php";
session_start();

if (isset($_SESSION['userID'])) {
    header("Location: user/");
    exit;
} else if (isset($_SESSION['adminID'])) {
    header("Location: admin/");
    exit;
}

$guestSignUpModel = new GuestSignUpModel(require "../config/db_connection.php");

if (isset($_POST['signUp']) && $_POST['signUp'] === "Sign Up") {
    // Save user input to persist data even after error
    $_SESSION['signUpEmail'] = $_POST['email'];
    $_SESSION['signUpPassword'] = $_POST['password'];
    $_SESSION['signUpUsername'] = $_POST['username'];
    $_SESSION['signUpPhoneNo'] = $_POST['phoneNo'];
    $_SESSION['signUpFirstName'] = $_POST['firstName'];
    $_SESSION['signUpLastName'] = $_POST['lastName'];
    $_SESSION['signUpDateOfBirth'] = $_POST['dateOfBirth'];
    $_SESSION['signUpGender'] = $_POST['gender'];
    $_SESSION['signUpTermsAndConditions'] = $_POST['termsAndConditions'];
    $_SESSION['signUpJoinedDate'] = date("Y-m-d");

    // Error Checking: check if any input is empty or not set
    $keys = array('signUpEmail', 'signUpPassword', 'signUpUsername', 'signUpPhoneNo', 'signUpFirstName', 'signUpLastName', 'signUpDateOfBirth', 'signUpGender', 'signUpTermsAndConditions');
    foreach ($keys as $k) {
        if (empty($_SESSION[$k]) || !isset($_SESSION[$k])) {
            $_SESSION['signUpError'] = 1;
            die(header("location: " . $_SERVER['PHP_SELF']));         
        }
    }

    // Error Checking: check if date of birth is invalid date
    if ($_SESSION['signUpDateOfBirth'] == "0000-00-00") {
        $_SESSION['signUpError'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));         
    }

    // Error Checking: check if username already exist
    if ($guestSignUpModel->checkExistingUsername($_SESSION['signUpUsername'])) {
        $_SESSION['signUpError'] = 2;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // Error Checking: check if username already exist
    if ($guestSignUpModel->checkExistingEmail($_SESSION['signUpEmail'])) {
        $_SESSION['signUpError'] = 3;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    $token = $guestSignUpModel->generateToken($_SESSION['signUpEmail']);
    if (!$guestSignUpModel->sendEmail($_SESSION['signUpEmail'], $token)) {
        $_SESSION['signUpError'] = 4;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

    // Create User
    $signUp = $guestSignUpModel->createUser($_SESSION['signUpFirstName'], $_SESSION['signUpLastName'], $_SESSION['signUpUsername'], $_SESSION['signUpPassword'], $_SESSION['signUpEmail'], $_SESSION['signUpPhoneNo'], $_SESSION['signUpGender'], $_SESSION['signUpDateOfBirth'], "", $_SESSION['signUpJoinedDate']);
    if ($signUp != 1) {
        $_SESSION['signUpError'] = 5;
        die(header("location: " . $_SERVER['PHP_SELF']));
    } else {
        $_SESSION['signUpSuccess'] = 1;
        die(header("location: " . $_SERVER['PHP_SELF']));
    }

}

$guestSignUpView = new GuestSignUpView();
$guestSignUpView->renderView();
unset($_SESSION['signUpEmail']);
unset($_SESSION['signUpPassword']);
unset($_SESSION['signUpUsername']);
unset($_SESSION['signUpPhoneNo']);
unset($_SESSION['signUpFirstName']);
unset($_SESSION['signUpLastName']);
unset($_SESSION['signUpDateOfBirth']);
unset($_SESSION['signUpGender']);
unset($_SESSION['signUpTermsAndConditions']);
unset($_SESSION['signUpJoinedDate']);
unset($_SESSION['signUpError']);
unset($_SESSION['signUpSuccess']);
