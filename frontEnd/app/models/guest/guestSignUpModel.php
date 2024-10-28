<?php
class GuestSignUpModel { 
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** User table. */
    private $userTable = "USER";
    /** Admin table. */
    private $adminTable = "ADMIN";
    
    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function checkExistingUser($username) {
        $registeredUserSQL = "SELECT * FROM " . $this->registeredUserTable . " WHERE username = ?";
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->bind_param("s", $username);
        $registeredUserSTMT->execute();
        $registeredUserResult = $registeredUserSTMT->get_result();
        if ($registeredUserResult->num_rows > 0) {
          return true;
        } else {
          return false;
        }
    }
    
    public function createUser($firstName, $lastName, $username, $password, $email, $phoneNo, $gender, $dateOfBirth, $profileImageFilePath, $joinedDate) {

        // Add Registered_User record.
        $registeredUserSQL = "INSERT INTO " . $this->registeredUserTable . "(firstName, lastName, username, password, email, phoneNo, gender, dateOfBirth, profileImageFilePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $registeredUserSQLSTMT = $this->databaseConn->prepare($registeredUserSQL);

        // Bind parameters.
        $registeredUserSQLSTMT->bind_param("sssssssss", $firstName, $lastName, $username, $password, $email, $phoneNo, $gender, $dateOfBirth, $profileImageFilePath);

        // Execute the statement.
        $insertRegisteredUserStatus = $registeredUserSQLSTMT->execute();


        // If added Registered_User record completed.
        // Add User record.

        $insertUserStatus = NULL;

        if ($insertRegisteredUserStatus) {
            $userId = $this->databaseConn->insert_id;
            $userSQL = "INSERT INTO " . $this->userTable . " VALUES (?, ?)";
            $userSQLSTMT = $this->databaseConn->prepare($userSQL);

            // Bind parameters.
            $userSQLSTMT->bind_param("ss", $userId, $joinedDate);

            // Execute the statement.
            $insertUserStatus = $userSQLSTMT->execute();
        }

        if ($insertRegisteredUserStatus && $insertUserStatus) {
            return 1; // Both registered_user and user data has been added.
        } else if ($insertRegisteredUserStatus && !$insertUserStatus) {
            return 2; // Only registered_user data has been added.
        } else if (!$insertRegisteredUserStatus && $insertUserStatus) {
            return 3; // Only user data has been added.
        } else {
            return 0; // Both data has failed to been added.
        }

    }

    
}
