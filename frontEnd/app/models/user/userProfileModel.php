<?php
class UserProfileModel {
    /** Registered User Table */
    private $registeredUserTable = 'registered_user';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getUserById($registeredUserID) {
        $query = "SELECT registeredUserID, firstName, lastName, username, email, gender, dateOfBirth AS dob, phoneNo AS phone, profileImageFilePath FROM "
         . $this->registeredUserTable . " WHERE registeredUserID=?";
        $stmt = $this->databaseConn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->databaseConn->error);
        }

        $stmt->bind_param("i", $registeredUserID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function updateRegisteredUser($registeredUserID, $firstName, $lastName, $gender, $dob, $phone) {
        $query = "UPDATE REGISTERED_USER
                  SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, phoneNo = ?
                  WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $dob, $phone, $registeredUserID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update registered user: " . $stmt->error);
        }
    }

    public function updateProfileImagePath($adminID, $profileImagePath) {
        $query = "UPDATE REGISTERED_USER
                  SET profileImageFilePath = ?
                  WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("si", $profileImagePath, $adminID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update profile image path: " . $stmt->error);
        }
    }
}