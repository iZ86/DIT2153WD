<?php
class UserModel {
    // Database connection
    private $databaseConn;
    // registered_user table name
    private $registeredUserTable = "registered_user";
    // user table name
    private $userTable = "user";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getById(int $id) {
        $sql = "SELECT * FROM REGISTERED_USER WHERE registereduserid=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        return false;
    }

    /** Creates user data,
     * returns 1 if true,
     * returns 2 if only registered_user data has been added.
     * returns 3 if only user data has been added.
     * Otherwise, returns 0 if all data failed to be added.
     */
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

        $insertUserStatus;

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
