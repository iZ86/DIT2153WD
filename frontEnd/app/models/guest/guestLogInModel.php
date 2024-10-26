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

    /** Verify login credentials.
     * Returns 1, if the login is valid.
     * Otherwise, returns 0.
     */
    public function verifyLogInCredentials($username, $password) {
        $registeredUserSQL = "SELECT * FROM " . $this->registeredUserTable . " WHERE username = ?";
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->bind_param("s", $username);
        $registeredUserSTMT->execute();
        $registeredUserResult = $registeredUserSTMT->get_result();
        if ($registeredUserResult->num_rows > 0) {
            
            $registeredUserRow = $registeredUserResult->fetch_assoc();

            // TODO: Modify password verification to include hashing.

            if ($registeredUserRow['password'] === $password) {
                return 1;
            }
        }
        
        return 0;
    }

}