<?php
class UserPaymentModel {
    /** Registered User Table */
    private $userPaymentTable = 'payment';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting all the user payment information by returning an associative array */
    public function getAllUserPaymentInformation() {
        $sql = "SELECT * FROM " . $this->userPaymentTable;
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