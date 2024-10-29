<?php
require "../views/guest/pages/guestChangePasswordView.php";
require "../models/guest/guestChangePasswordModel.php";
session_start();
$guestForgotPasswordModel = new GuestChangePasswordModel(require "../config/db_connection.php");

if (isset($_POST['changePassword']) && $_POST['changePassword'] === "Change Password") {

}

if (isset($_GET[''])) {
    
}

/** Unsets all the session variables that is used by this controller only. */ 
function unsetSessionVariablesForSelf() {
}

$guestChangePasswordView = new GuestChangePasswordView();
$guestChangePasswordView->renderView();
unsetSessionVariablesForSelf();