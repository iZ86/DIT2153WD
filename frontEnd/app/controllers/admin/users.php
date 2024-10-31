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
        $adminUsersModel->editUser($registeredUserID, $_POST['firstName'], $_POST['lastName'], $_POST['phoneNo'], $_POST['gender'], $_POST['dateOfBirth']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_GET['registeredUserID'])) {
    $registeredUserID = $_GET['registeredUserID'];
    $userDetails = $adminUsersModel->getUserDetails($registeredUserID);
}

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

if (!empty($filterType) && $filterType !== 'all') {
    $users = $adminUsersModel->getFilteredUsers($limit, $offset, $filterType, $keywords);
} else {
    $users = $adminUsersModel->getAllUsers($limit, $offset);
}

$noUsersFound = $users->num_rows === 0;

$totalUsers = $adminUsersModel->getTotalUsers();
$totalPages = ceil($totalUsers / $limit);
$adminUsersView = new AdminUsersView($users, $totalPages, $page, $noUsersFound);
$adminUsersView->renderView();