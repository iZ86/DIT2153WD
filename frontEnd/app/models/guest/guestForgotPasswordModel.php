<?php
class GuestForgotPasswordModel {
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** User table. */
    private $userTable = "USER";
    /** Password Reset table. */
    private $passwordResetsTable = "PASSWORD_RESETS";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function verifyUserExist($email) {
        // verify if email exist in registered_user db
        $registeredUserSQL = "SELECT email FROM " . $this->registeredUserTable;
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->execute();
        $registeredUserResult = $registeredUserSTMT->get_result();
        if ($registeredUserResult->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function generateToken($email) {
        // generate token
        $token = bin2hex(random_bytes(50));

        // get timestamp created
        $createdOn = date("Y-m-d H:i:s");

        // check if email in password reset
        $checkEmailSQL = "SELECT email FROM " . $this->passwordResetsTable;
        $checkEmailSTMT = $this->databaseConn->prepare($checkEmailSQL);
        $checkEmailSTMT->execute();
        $checkEmailResult = $checkEmailSTMT->get_result();

        if ($checkEmailResult->num_rows == 0) {
            // email not in password_reset db, add email row
            $insertTokenSQL = "INSERT INTO " . $this->passwordResetsTable . " (email, token, createdOn) VALUES (?, ?, ?)";
            $insertTokenSTMT = $this->databaseConn->prepare($insertTokenSQL);
            $insertTokenSTMT->bind_param("sss", $email, $token, $createdOn);
            $insertTokenSTMT->execute();
    
        } else {
            // email in password_reset db, update email row
            $updateTokenSQL = "UPDATE " . $this->passwordResetsTable . " SET token = ?, createdOn = ? WHERE email = ?";
            $updateTokenSTMT = $this->databaseConn->prepare($updateTokenSQL);
            $updateTokenSTMT->bind_param("sss", $token, $createdOn, $email);
            $updateTokenSTMT->execute();
        }

        return $token;

    }

    public function sendEmail($email, $token) {
        $resetLink = "http://localhost/DIT2153WD/frontEnd/app/controllers/changePassword.php?token=" . $token;

        if (mail($email, "Password Reset Link", "Good day to our fellow member of HuanFitnessCenter!\n\nHere is the password reset link you have requested. Please click the link to continue with your password reset:\n" . $resetLink)) {
            return true;
        } else {
            return false;
        }
    }


}