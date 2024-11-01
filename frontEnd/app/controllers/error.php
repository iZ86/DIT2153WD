<?php
require('../views/guest/pages/guestErrorRequestView.php');
session_start();

if (isset($_SESSION['userID'])) {
    header("Location: user/");
    exit;
} else if (isset($_SESSION['adminID'])) {
    header("Location: admin/");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitReturnToIndexButton'])) {
        if ($_POST['submitReturnToIndexButton'] === "Return to home page") {
            if ((!isset($_SESSION['userID']) || $_SESSION['userID'] === null) &&
            (!isset($_SESSION['adminID']) || $_SESSION['adminID'] === null)) {
                die(header("location: ../controllers/"));
            } 
        }
    }
}
$guestErrorRequestView = new GuestErrorRequestView();
$guestErrorRequestView->renderView();