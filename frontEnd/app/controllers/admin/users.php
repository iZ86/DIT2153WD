<?php
require '../../views/admin/pages/adminUsersView.php';
require '../../models/admin/adminUsersModel.php';
session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminUsersModel = new AdminUsersModel(require '../../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editUserButton']) && $_POST['editUserButton'] === "Edit User") {
        $registeredUserID = $_POST['registeredUserID'];
        $adminUsersModel->editUser($registeredUserID, $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['phoneNo'], $_POST['gender'], $_POST['dateOfBirth']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalUsers = $adminUsersModel->getUserCount($searchQuery);
$users = $adminUsersModel->getAllUsers($limit, $offset, $searchQuery);
$totalPages = ceil($totalUsers / $limit);
$adminUsersView = new AdminUsersView($users, $totalPages, $page);
$adminUsersView->renderView();