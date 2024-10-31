<?php
require '../../models/user/userProfileModel.php';
require '../../views/user/pages/profileView.php';

session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

$userProfileModel = new UserProfileModel(require '../../config/db_connection.php');

// Fetch classes data.
$registeredUserID = $_SESSION['userID'];
$userDetails = $userProfileModel->getUserById($registeredUserID);

if (!$userDetails) {
    echo "Admin not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $profileImagePath = '';

    if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($phone)) {
        try {
            $userProfileModel->updateRegisteredUser($registeredUserID, $firstName, $lastName, $gender, $dob, $phone);
            if ($profileImagePath) {
                $userProfileModel->updateProfileImagePath($registeredUserID, $profileImagePath);
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

        $userProfileModel->updateProfileImagePath($registeredUserID, $profileImagePath);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Pass the data to the view
$profileView = new ProfileView($userDetails);
$profileView->renderView();
