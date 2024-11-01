<?php
require '../../views/admin/pages/AdminProfileView.php';
require '../../models/admin/AdminProfileModel.php';

session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$adminModel = new AdminProfileModel(require '../../config/db_connection.php');

// Retrieve admin ID from session and fetch admin details
$adminID = $_SESSION['adminID'];
$adminDetails = $adminModel->getAdminById($adminID);

// Check if admin details were not found
if (!$adminDetails) {
    echo "Admin not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $salary = isset($_POST['salary']) ? trim($_POST['salary']) : '';
    $profileImagePath = '';

    if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($phone) && !empty($salary)) {
        try {
            $adminModel->updateRegisteredUser($adminID, $firstName, $lastName, $gender, $dob, $phone);
            $adminModel->updateAdminSalary($adminID, $salary);
            if ($profileImagePath) {
                $adminModel->updateProfileImagePath($adminID, $profileImagePath);
            }
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            echo "Error updating profile: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Please fill in all required fields.";
    }

    if (!empty($_FILES['profilePhoto']['name'])) {
        $targetDir = "../../public/images/userAvatar/";

        $username = $adminDetails['username'];
        $fileType = pathinfo($_FILES['profilePhoto']['name'], PATHINFO_EXTENSION);

        $newFileName = $username . '.' . $fileType;
        $targetFilePath = $targetDir . $newFileName;

        $check = getimagesize($_FILES['profilePhoto']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        if (move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $targetFilePath)) {
            $profileImagePath = $targetFilePath;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        // Update profile image path in the database
        $adminModel->updateProfileImagePath($adminID, $profileImagePath);

        // Redirect to the same page to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$adminProfileView = new AdminProfileView($adminDetails);
$adminProfileView->renderView();