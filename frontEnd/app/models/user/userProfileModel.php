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

    /** Function of getting all the USER information by returning an associative array */
    public function getAllUserInformation() {
        $sql = "SELECT * FROM " . $this->registeredUserTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }
}