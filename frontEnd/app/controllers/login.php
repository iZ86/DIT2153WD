<?php
require "../views/guest/pages/guestLogInView.php";

session_start();
$guestLogInView = new GuestLogInView();
$guestLogInView->renderView();
unset($_SESSION['invalidLogin']);


if (isset($_POST['loginButton']) && $_POST['loginButton'] === "Log In") {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['invalidLogin'] = 1;
        die(header("location: ". $_SERVER['PHP_SELF']));
    } else {

    }
    
} else {
    // Go to index.php of user.
}


