<?php
class InstructorModel {
    /** Instructor Table */
    private $instructorTable = 'instructor';
    private $fitnessClassTable = 'fitness_class';
    private $fitnessClassScheduleTable = 'fitness_class_schedule';

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

    /** Function of getting the insturctor information by using ID */
    public function getInstructorById(int $id): mixed {
        $sql = "SELECT * FROM " . $this->instructorTable . " WHERE instructorID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : [];
    }

    /** Function of getting all the insturctor information by returning an associative array */
    public function getAllInstructor() {
        $sql = "SELECT * FROM " . $this->instructorTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getFitnessClassById($fitnessClassID) {
        $sql = "SELECT * FROM " . $this->fitnessClassTable . " WHERE fitnessClassID = ?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $fitnessClassID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : [];
    }

    public function getInstructorsByFitnessClassID($fitnessClassID) {
        $sql = "SELECT i.* FROM " . $this->instructorTable . " i
                JOIN " . $this->fitnessClassScheduleTable . " fcs ON i.instructorID = fcs.instructorID
                WHERE fcs.fitnessClassID = ?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $fitnessClassID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


}