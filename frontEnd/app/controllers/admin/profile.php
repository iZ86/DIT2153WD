<?php
require '../../views/admin/pages/AdminProfileView.php';
require '../../models/admin/AdminProfileModel.php';

session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminModel = new AdminProfileModel(require '../../config/db_connection.php');

$adminID = $_SESSION['adminID'];
$adminDetails = $adminModel->getAdminById($adminID);

if (!$adminDetails) {
    echo "Admin not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $phone = trim($_POST['phone']);
    $salary = trim($_POST['salary']);

    if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($phone) && !empty($salary)) {
        try {
            $adminModel->updateRegisteredUser($adminID, $firstName, $lastName, $gender, $dob, $phone);
            $adminModel->updateAdminSalary($adminID, $salary);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            echo "Error updating profile: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Please fill in all required fields.";
    }
}

$adminProfileView = new AdminProfileView($adminDetails);
$adminProfileView->renderView();