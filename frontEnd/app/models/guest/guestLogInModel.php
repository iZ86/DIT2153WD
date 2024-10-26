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

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Returns the results of rows of registered_user table from SQL statement with username constraint. */
    private function getRegisteredUserSQLResult($username) {
        $registeredUserSQL = "SELECT * FROM " . $this->registeredUserTable . " WHERE username = ?";
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->bind_param("s", $username);
        $registeredUserSTMT->execute();
        return $registeredUserSTMT->get_result();
    
    }

    /** Verify login credentials.
     * Returns 1, if the login is valid.
     * Otherwise, returns 0.
     */
    public function verifyLogInCredentials($username, $password) {

        $registeredUserResult = $this->getRegisteredUserSQLResult($username);

        if ($registeredUserResult->num_rows > 0) {
            
            $registeredUserRow = $registeredUserResult->fetch_assoc();

            // TODO: Modify password verification to include hashing.

            if ($registeredUserRow['password'] === $password) {
                return 1;
            }
        }
        
        return 0;
    }

    /** Returns 1 if the username belongs to a user account.
     * Otherwise, returns 0.
     */
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

    /** Returns registered_User ID in the table. */
    public function getRegisteredUserID($username) {
        $registeredUserResult = $this->getRegisteredUserSQLResult($username);

        if ($registeredUserResult->num_rows > 0) {
            $registeredUserRow = $registeredUserResult->fetch_assoc();

            return $registeredUserRow['registeredUserID'];
        }
    }

}