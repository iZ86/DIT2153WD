<?php
class GuestSignUpModel { 
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** User table. */
    private $userTable = "USER";
    /** Verify_SignUp table. */
    private $verifySignUpTable = "VERIFY_SIGNUP";
    
    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function checkExistingUsername($username) {
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

    public function checkExistingEmail($email) {
        $registeredUserSQL = "SELECT * FROM " . $this->registeredUserTable . " WHERE email = ?";
        $registeredUserSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSTMT->bind_param("s", $email);
        $registeredUserSTMT->execute();
        $registeredUserResult = $registeredUserSTMT->get_result();
        if ($registeredUserResult->num_rows > 0) {
          return true;
        } else {
          return false;
        }
    }
    
    public function createUser($firstName, $lastName, $username, $password, $email, $phoneNo, $gender, $dateOfBirth, $profileImageFilePath, $joinedDate) {
        $registeredUserSQL = "INSERT INTO " . $this->registeredUserTable . "(firstName, lastName, username, password, email, phoneNo, gender, dateOfBirth, profileImageFilePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $registeredUserSQLSTMT = $this->databaseConn->prepare($registeredUserSQL);
        $registeredUserSQLSTMT->bind_param("sssssssss", $firstName, $lastName, $username, $password, $email, $phoneNo, $gender, $dateOfBirth, $profileImageFilePath);
        $insertRegisteredUserStatus = $registeredUserSQLSTMT->execute();

        // If added Registered_User record completed, add User record
        $insertUserStatus = NULL;
        $verified = 0;
        if ($insertRegisteredUserStatus) {
            $userId = $this->databaseConn->insert_id;
            $userSQL = "INSERT INTO " . $this->userTable . " VALUES (?, ?, ?)";
            $userSQLSTMT = $this->databaseConn->prepare($userSQL);
            $userSQLSTMT->bind_param("ssi", $userId, $joinedDate, $verified);
            $insertUserStatus = $userSQLSTMT->execute();
        }

        // Return error or successful
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

    public function generateToken($email) {
        // generate token
        $token = bin2hex(random_bytes(50));

        // get timestamp created
        $createdOn = date("Y-m-d H:i:s");

        // insert generate email 
        $insertTokenSQL = "INSERT INTO " . $this->verifySignUpTable . " (email, token, createdOn) VALUES (?, ?, ?)";
        $insertTokenSTMT = $this->databaseConn->prepare($insertTokenSQL);
        $insertTokenSTMT->bind_param("sss", $email, $token, $createdOn);
        $insertTokenSTMT->execute();

        return $token;
    }

    public function sendEmail($email, $token) {
        $verifyEmailLink = "http://localhost/DIT2153WD/frontEnd/app/controllers/login.php?token=" . $token;

        if (mail($email, "Verify Email Link", "Good day to our fellow member of HuanFitnessCenter!\n\nHere is the link to verify your email. Please click the link to continue with your login:\n" . $verifyEmailLink)) {
            return true;
        } else {
            return false;
        }
    }
}
