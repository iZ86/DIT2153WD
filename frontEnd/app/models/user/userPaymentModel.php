<?php
class UserPaymentModel {
    /** Registered User Table */
    private $userPaymentTable = 'payment';
    /** Nutritionist Booking Table */
    private $nutritionistBookingTable = 'nutritionist_booking';
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
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }

    public function createUserPayment($type, $status, $createdOn, $userID) {
        $sql = "INSERT INTO " . $this->userPaymentTable . " (type,status,createdOn,userID) VALUES(?,?,?,?)";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("sssi", $type, $status, $createdOn, $userID);
        return $stmt->execute();
    }

    public function getPaymentIDByTypeCreatedOnAndUserID($type, $createdOn, $userID) {
        $sql = "SELECT paymentID FROM " . $this->userPaymentTable . " WHERE type=? AND createdOn=? AND userID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("ssi", $type, $createdOn, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }

    /** Function of creating a booking for user's reservation */
    public function createNutritionistBooking($description, $nutritionistScheduleID, $userID, $paymentID) {
        $sql = "INSERT INTO " . $this->nutritionistBookingTable . " (description,nutritionistScheduleID,userID,paymentID) VALUES (?,?,?,?)";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("siii", $description, $nutritionistScheduleID, $userID, $paymentID);
        return $stmt->execute();
    }

    public function isScheduleIDBooked($nutritionistScheduleID) {
        $sql = "SELECT COUNT(*) as count FROM " . $this->nutritionistBookingTable . " WHERE nutritionistScheduleID = ?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $nutritionistScheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0; // Returns true if the schedule ID is already booked
    }

}