<?php
require('../../views/user/pages/userPaymentSuccessView.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitReturnToIndexButton'])) {
        if ($_POST['submitReturnToIndexButton'] === "Return to home page") {
            if (isset($_SESSION['userID']) && $_SESSION['userID'] !== null) {
                die(header("location: ../user/"));
            }
        }
    }
}
$userPaymentSuccessView = new UserPaymentSuccessView();
$userPaymentSuccessView->renderView();