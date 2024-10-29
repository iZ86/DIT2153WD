<?php
session_start();

$_SESSION = [];

session_destroy();

header("Location: ../controllers/login.php");
exit;