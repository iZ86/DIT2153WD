<?php
//require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class NutritionistModel {
    /** Nutritionist Table */
    private $nutritionistTable = 'nutritionist'; 
    /** Nutritionist Booking Table */
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
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
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
            $nutritionistsInfo = $result->fetch_all(MYSQLI_ASSOC); 
            return $nutritionistsInfo;
        } else {
            return false;
        }
    }

    /** Function of creating a booking for user's reservation */
    public function createNutritionistBooking($nutritionist, $description, $bookingDate, $bookingTime) {
        $sql = "INSERT INTO " . $this->nutritionistBookingTable . " (description, bookingDate, bookingTime) VALUES (?, ?, ?)";
        $stmt = $this->databaseConn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sss", $description , $bookingDate, $bookingTime);

        // Execute the statement
        return $stmt->execute(); // Return true if successful, false otherwise
    }

    public function nutritionistsBookingHandler($nutritionist, $bookingDate, $bookingTime, $description, $makeReservationButton) {
        if(isset($makeReservationButton) && !empty($nutritionist) && !empty($bookingDate) && !empty($bookingTime)) {
            
            return true;  
        }
        return false;
    }
}