<?php
class GuestLogInModel {
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** User table. */
    private $userTable = "USER";
    /** Admin table. */
    private $adminTable = "ADMIN";
    /** Verify Signup table. */
    private $verifySignupTable = "VERIFY_SIGNUP";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    // Returns the results of rows of registered_user table from SQL statement with username constraint.
    private function getRegisteredUserSQLResult($username) {
        $registeredUserSQL = "SELECT * FROM " . $this->registeredUserTable . " WHERE username = ?";
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->bind_param("s", $username);
        $registeredUserSTMT->execute();
        return $registeredUserSTMT->get_result();
    }

    // Verify login credentials. Returns 1, if the login is valid. Otherwise, returns 0.
    public function verifyLogInCredentials($username, $password) {
        $registeredUserResult = $this->getRegisteredUserSQLResult($username);
        if ($registeredUserResult->num_rows > 0) {
            $registeredUserRow = $registeredUserResult->fetch_assoc();
            if (password_verify($password, $registeredUserRow['password'])) {
                return 1;
            }
        }
        return 0;
    }

    // Returns 1 if the username belongs to a user account. Otherwise, returns 0.
    public function isUserAccount($username) {
        $registeredUserResult = $this->getRegisteredUserSQLResult($username);
        if ($registeredUserResult->num_rows > 0) {
            $registeredUserRow = $registeredUserResult->fetch_assoc();
            $userSQL = "SELECT * FROM " . $this->userTable . " WHERE userId = ?";
            $userSTMT = $this->databaseConn->prepare($userSQL);
            $userSTMT->bind_param("s", $registeredUserRow['registeredUserID']);
            $userSTMT->execute();
            $userResult = $userSTMT->get_result();
            if ($userResult->num_rows > 0) {
                return 1;
            }
            return 0;
        }
    }

    // Returns registered_User ID in the table.
    public function getIDFromUsername($username) {
        $registeredUserResult = $this->getRegisteredUserSQLResult($username);
        if ($registeredUserResult->num_rows > 0) {
            $registeredUserRow = $registeredUserResult->fetch_assoc();
            return $registeredUserRow['registeredUserID'];
        }
    }

    // Returns 1 if email is verified, 0 if it's not.
    public function checkVerifiedEmail($username) {
        $registeredUserResult = $this->getRegisteredUserSQLResult($username);
        if ($registeredUserResult->num_rows > 0) {
            $registeredUserRow = $registeredUserResult->fetch_assoc();
            $userSQL = "SELECT verified FROM " . $this->userTable . " WHERE userId = ?";
            $userSTMT = $this->databaseConn->prepare($userSQL);
            $userSTMT->bind_param("s", $registeredUserRow['registeredUserID']);
            $userSTMT->execute();
            $userResult = $userSTMT->get_result();
            if ($userResult->num_rows > 0) {
                $userResultRow = $userResult->fetch_assoc();
                $verified = $userResultRow['verified'];
                if($verified) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
    }

    // Returns email if token exists, returns 0 if does not.
    public function verifyToken($token) {
        $verifyTokenSQL = "SELECT email FROM " . $this->verifySignupTable . " WHERE token = ?";
        $verifyTokenSTMT = $this->databaseConn->prepare($verifyTokenSQL);
        $verifyTokenSTMT->bind_param("s", $token);
        $verifyTokenSTMT->execute();
        $verifyTokenResult = $verifyTokenSTMT->get_result();
        if ($verifyTokenResult->num_rows > 0) {
            $verifyTokenRow = $verifyTokenResult->fetch_assoc();
            return $verifyTokenRow['email'];
        } else {
            return 0;
        }
    }

    // Updates account verification to 1
    public function updateAccountVerification($email) {
        $userID = $this->getIDFromEmail($email);
        $userSQL = "UPDATE " . $this->userTable . " SET verified = 1 WHERE userId = ?";
        $userSTMT = $this->databaseConn->prepare($userSQL);
        $userSTMT->bind_param("s", $userID);
        $userSTMT->execute();
    }

    // Returns ID if success, 0 if unsuccessful.
    public function getIDFromEmail($email) {
        $getIDFromEmailSQL = "SELECT registeredUserID FROM " . $this->registeredUserTable . " WHERE email = ?";
        $getIDFromEmailSTMT = $this->databaseConn->prepare($getIDFromEmailSQL);
        $getIDFromEmailSTMT->bind_param("s", $email);
        $getIDFromEmailSTMT->execute();
        $getIDFromEmailResult = $getIDFromEmailSTMT->get_result();
        if ($getIDFromEmailResult->num_rows > 0) {
            $getIDFromEmailRow = $getIDFromEmailResult->fetch_assoc();
            return $getIDFromEmailRow['registeredUserID'];
        } else {
            return 0;
        }
    }

}