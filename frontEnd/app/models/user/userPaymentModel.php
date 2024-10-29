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

    public function createUserPayment($type, $status, $createdOn, $userID) {
        $sql = "INSERT INTO " . $this->userPaymentTable . " (type,status,createdOn,userID) VALUES(?,?,?,?)";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("sssi", $type, $status, $createdOn, $userID);
        return $stmt->execute();
    }
}