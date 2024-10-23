<?php
//require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class NutritionistModel {
    // Table name
        private $table = 'nutritionist'; 
    private $databaseConn;

    // Constructor 
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


    public function getById(int $id): mixed {
        $sql = "SELECT * FROM " . $this->table . " WHERE nutritionistID=?";
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
    
    // Function to count total nutritionists
    public function countTotal(): int {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->table;
        $result = $this->databaseConn->query($sql); // Using direct query instead of prepared statement for a simple count

        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        }
        
        return 0; // Return 0 if query fails
    }
}