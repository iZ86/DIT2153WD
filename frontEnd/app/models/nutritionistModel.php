<?php
//require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class NutritionistModel {
    /** Nutritionist Table */
    private $nutritionistTable = 'nutritionist'; 
    /** Database connection */
    private $databaseConn;

    /** Constructor */  
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    // Create a new nutritionist
   /* public function create() {
        $sql = "INSERT INTO " . $this->table . " (firstName, lastName, gender, email, phoneNo, description, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sssssss", $this->firstName, $this->lastName, $this->gender, $this->email, $this->phoneNo, $this->description, $this->type);

        // Execute the statement
        return $stmt->execute(); // Return true if successful, false otherwise
    } */

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
}