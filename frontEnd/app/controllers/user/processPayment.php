<?php
global $database_connection;
session_start();

include "../../config/db_connection.php";

// Retrieve form data
$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$addressLine1 = $_POST['addressLine1'];
$addressLine2 = $_POST['addressLine2'];
$country = $_POST['country'];
$zipCode = $_POST['zipCode'];
$city = $_POST['city'];
$state = $_POST['state'];
$phoneNumber = $_POST['phoneNumber'];
$grandTotal = $_POST['grandTotal'];
$cardNumber = $_POST['cardNumber'];
$nameOnCard = $_POST['nameOnCard'];
$expirationMonth = $_POST['expirationMonth'];
$expirationYear = $_POST['expirationYear'];
$securityCode = $_POST['securityCode'];

// Validation
if(empty($email) || empty($firstName) || empty($lastName) || empty($addressLine1) || empty($addressLine2) ||
    empty($country) || empty($zipCode) || empty($city) || empty($state) ||
    empty($phoneNumber) || empty($grandTotal) || empty($cardNumber) || empty($nameOnCard) || empty($expirationMonth) ||
    empty($expirationYear) || empty($securityCode)){
    die("Please fill in all the required fields.");
}

// Process payment using a payment gateway

// Save data to database
$query = "INSERT INTO payment ($email, $firstName, $lastName, $addressLine1, $addressLine2,$country, $zipCode, $city, $state, $phoneNumber, $cardNumber, $nameOnCard, $expirationMonth, $expirationYear, $securityCode) VALUES ()";
$stmt = $database_connection->prepare($query);
$stmt->bind_param("s",$email,$firstName,$lastName, $addressLine1, $addressLine2,$country, $zipCode, $city, $state, $phoneNumber, $cardNumber, $nameOnCard, $expirationMonth, $expirationYear, $securityCode);

if($stmt->execute()){
    echo "Payment successful! Thank you for your subscription.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$database_connection->close();

// Form submission
