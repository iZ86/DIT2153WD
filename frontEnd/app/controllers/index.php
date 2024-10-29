<?php
require "../views/guest/pages/guestIndexView.php";
session_start();

$guestIndexView = new GuestIndexView();
$guestIndexView->renderView();
?>