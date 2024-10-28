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
    /*public function createNutritionistBooking($nutritionist, $description, $bookingDate, $bookingTime) {
        $sql = "INSERT INTO " . $this->nutritionistBookingTable . " (description, bookingDate, bookingTime) VALUES (?, ?, ?)";
        $stmt = $this->databaseConn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sss", $description , $bookingDate, $bookingTime);

        // Execute the statement
        return $stmt->execute(); // Return true if successful, false otherwise
    }*/

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

    public function getAllNutritionistAvailableDateById($id) {
        $sql = "SELECT DATE(scheduleDateTime) AS date_part FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getAllNutritionistAvailableTimeById($id) {
        $sql = "SELECT TIME(scheduleDateTime) AS time_part FROM " . $this->nutritionitsScheduleTable . " WHERE nutritionistID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }
}