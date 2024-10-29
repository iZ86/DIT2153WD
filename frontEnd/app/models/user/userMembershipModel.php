<?php
class UserMembershipModel {
    /** Member Subscription Table */
    private $memberSubscriptionTable = 'member_subscription';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting all the user membership information by returning an associative array */
    public function getAllMemberInformation() {
        $sql = "SELECT * FROM " . $this->memberSubscriptionTable;
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