<?php
require '../../views/user/pages/userIndexView.php';
session_start();

$userIndexView = new UserIndexView($_SESSION['username']);
$userIndexView->renderView();