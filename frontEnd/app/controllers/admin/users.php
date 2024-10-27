<?php
require '../../views/admin/pages/adminUsersView.php';
require '../../models/admin/adminUsersModel.php';
session_start();

$adminUsersModel = new AdminUsersModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if (isset($_POST['addUserButton']) && $_POST['addUserButton'] === "Add User") {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phoneNo = trim($_POST['phoneNo']);
        $gender = trim($_POST['gender']);
        $dateOfBirth = trim($_POST['dateOfBirth']);

        if (empty($errors)) {
            $adminUsersModel->addUser($firstName, $lastName, $username, $email, $phoneNo, $gender, $dateOfBirth);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_POST['editUserButton']) && $_POST['editUserButton'] === "Edit User") {
        $registeredUserID = $_POST['registeredUserID'];
        $adminUsersModel->editUser($registeredUserID, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNo'], $_POST['gender'], $_POST['dateOfBirth']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$users = $adminUsersModel->getAllUsers();
$adminUsersView = new AdminUsersView($users);
$adminUsersView->renderView();
