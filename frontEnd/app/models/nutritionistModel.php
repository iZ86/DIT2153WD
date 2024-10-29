<?php
//require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class NutritionistModel {
    /** Nutritionist Table */
    private $nutritionistTable = 'nutritionist';
    /** Nutritionist Booking Table */
    private $nutritionistBookingTable = 'nutritionist_booking';
    private $nutritionitsScheduleTable = 'nutritionist_schedule';
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
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    /** Function of getting all the nutritionists information by returning an associative array */
    public function getAllNutritionist() {
        $sql = "SELECT * FROM " . $this->nutritionistTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    /** Function of creating a booking for user's reservation */
    public function createNutritionistBooking($nutritionistScheduleID, $description, $userID, $paymentID) {
        // Check if the nutritionistScheduleID exists
        $checkSql = "SELECT COUNT(*) FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistScheduleID=?";
        $checkStmt = $this->databaseConn->prepare($checkSql);
        $checkStmt->bind_param("i", $nutritionistScheduleID);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $exists = $checkResult->fetch_row()[0];

        if ($exists > 0) {
            // Proceed to insert if the schedule exists
            $sql = "INSERT INTO " . $this->nutritionistBookingTable . " (description, nutritionistScheduleID, userID, paymentID) VALUES (?, ?, ?, ?)";
            $stmt = $this->databaseConn->prepare($sql);
            $stmt->bind_param("ssis", $description, $nutritionistScheduleID, $userID, $paymentID);
            return $stmt->execute(); // Return true if successful, false otherwise
        } else {
            error_log("Error: nutritionistScheduleID " . $nutritionistScheduleID . " does not exist.");
            return false; // Schedule does not exist
        }
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
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getAllNutritionistAvailableDateTimeById($id) {
    $sql = "SELECT * FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistID=?";
    $stmt = $this->databaseConn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : false;
}

}