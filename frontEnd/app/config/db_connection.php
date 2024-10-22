<?php
// Include the config file
require_once 'config.php';

// Create connection
$database_connection = mysqli_connect(SV_NAME, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection 
if (!$database_connection) {
  die("Connection failed: " . mysqli_connect_error());
}

