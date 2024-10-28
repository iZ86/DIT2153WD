<?php
require_once __DIR__ . '/../../models/userModel.php';
require_once __DIR__ . '/../../config/db_connection.php';

class UserProfileManagement {
    private $userModel;

    public function __construct($userModel){
        $this->userModel = new UserModel($userModel);
    }

    // Call the model to fetch user details
    public function getProfile($userId){
        return $this->userModel->getById($userId);
    }

    public function updateProfile($userId,$data){
        $filteredData = [
            "email" => $data['email'],
            "phone_number" => $data['phone_number']
        ];

        return $this->userModel->getById($userId)->update($filteredData);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in the session
    $controller = new UserProfileManagement();

    if ($controller->updateProfile($userId, $_POST)) {
        header('Location: profile.php?success=true'); // Redirect on success
        exit;
    } else {
        echo "Error updating profile. Please try again.";
    }
}
