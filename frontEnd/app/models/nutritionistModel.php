<?php
class NutritionistModel {
    /** Nutritionist Table */
    private $nutritionistTable = 'nutritionist';
    private $nutritionitsScheduleTable = 'nutritionist_schedule';
    private $nutritionistBookingTable = 'nutritionist_booking';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting the nutritionist information by using ID */
    public function getById(int $id): mixed {
        $sql = "SELECT * FROM " . $this->nutritionistTable . " WHERE nutritionistID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : array();
    }

    /** Function of getting all the nutritionists information by returning an associative array */
    public function getAllNutritionist() {
        $sql = "SELECT * FROM " . $this->nutritionistTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : array();
    }

    public function getNutritionistScheduleIdByNutritionistIdAndScheduleDateTime($nutritionistID, $scheduleDateTime) {
        $sql = "SELECT * FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistID=? AND scheduleDateTime=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("is", $nutritionistID, $scheduleDateTime);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : array();
    }
    public function nutritionistsBookingHandler($nutritionist, $bookingDate, $bookingTime, $description, $makeReservationButton) {
        if(isset($makeReservationButton) && !empty($nutritionist) && !empty($bookingDate) && !empty($bookingTime)) {

            return true;
        }
        return false;
    }

    public function getAllNutritionistScheduleInformation() {
        $sql = "SELECT * FROM " . $this->nutritionitsScheduleTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : array();
    }

    public function getAllNutritionistAvailableDateTimeById($id) {
    $sql = "SELECT * FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistID=?";
    $stmt = $this->databaseConn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : array();
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

    public function getNutritionistSchedulePriceByNutritionistScheduleID($nutritionistScheduleID) {
        $sql = "SELECT price FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistScheduleID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $nutritionistScheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }
}