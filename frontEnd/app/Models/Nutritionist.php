<?php
require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class NutritionistModel {
    // Database connection
    private $conn; 
    // Table name
    private $table = 'nutrionist'; 

    // User properties
    public $id;
    public $firstName;
    public $lastName;
    public $gender;
    public $email;
    public $phoneNo;
    public $description;
    public $type;

    // Constructor 
    public function __construct($database_connection) {
        $this->conn = $database_connection;
    }
    // Create a new nutritionist
    public function create() {
        $sql = "INSERT INTO " . $this->table . " (firstName, lastName, gender, email, phoneNo, description, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sssssss", $this->firstName, $this->lastName, $this->gender, $this->email, $this->phoneNo, $this->description, $this->type);

        // Execute the statement
        return $stmt->execute(); // Return true if successful, false otherwise
    }

    // Read all nutritionists
    public function read() {
        $sql = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($sql);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $data = []; // Initialize an array to hold all rows
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row; // Append each row to the data array
            }
            return $data; // Return the array of results
        } else {
            return []; // Return an empty array if no results
        }
    }
    
}