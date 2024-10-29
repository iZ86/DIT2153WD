<?php
class GuestChangePasswordModel {
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** Password Reset table. */
    private $passwordResetsTable = "PASSWORD_RESETS";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function verifyToken($token) {
        // get email for token
        $verifyTokenSQL = "SELECT email FROM " . $this->passwordResetsTable . " WHERE token = ?";
        $verifyTokenSTMT = $this->databaseConn->prepare($verifyTokenSQL);
        $verifyTokenSTMT->bind_param("s", $token);
        $verifyTokenSTMT->execute();
        $verifyTokenResult = $verifyTokenSTMT->get_result();
        if ($verifyTokenResult->num_rows > 0) {
            $verifyTokenRow = $verifyTokenResult->fetch_assoc();
            return $verifyTokenRow['email'];
        } else {
            return false;
        }
    }

    public function changePassword($email, $password) {
        $changePasswordSQL = "UPDATE " . $this->registeredUserTable . " SET password = ? WHERE email = ?";
        $changePasswordSTMT = $this->databaseConn->prepare($changePasswordSQL);
        $changePasswordSTMT->bind_param("ss", $password, $email);
        $changePasswordSTMT->execute();
    }
}