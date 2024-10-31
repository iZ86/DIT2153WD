<?php
class UserFitnessClass {
    private $fitnessClassTable = 'fitness_class';
    /** Fitness Class Schedule Table */
    private $fitnessClassScheduleTable = 'fitness_class_schedule';
    private $fitnessClassBookingTable = 'fitness_class_booking';
    private $instructorTable = 'instructor';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting the fitness class information by using ID */
    public function getClassesByInstructorById($instructorId) {
        $sql = "SELECT * FROM " . $this->fitnessClassScheduleTable . " WHERE instructorID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $instructorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /** Function of getting the instructor name by using ID */
    public function getInstructorNameById($instructorId) {
        $sql = "SELECT firstName, lastName FROM " . $this->instructorTable . " WHERE instructorID=?";
        $stmt = $this->databaseConn->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $this->databaseConn->error);
        }

        $stmt->bind_param("i", $instructorId);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $instructor = $result->fetch_assoc();

            return $instructor['firstName'] . ' ' . $instructor['lastName'];
        }

        return null;
    }

    public function getFitnessClassScheduleIdByClassInfo($scheduledOn, $instructorID, $fitnessClassID) {
        $sql = "SELECT fitnessClassScheduleID FROM " . $this->fitnessClassScheduleTable . " WHERE scheduledOn=? AND instructorID=? AND fitnessClassID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("sii", $scheduledOn, $instructorID, $fitnessClassID);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['fitnessClassScheduleID'];
        }

        return null; // Return null if no record found
    }

    public function getFitnessClassPriceByFitnessClassID($fitnessClassID) {
        $sql = "SELECT price FROM " . $this->fitnessClassTable . " WHERE fitnessClassID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $fitnessClassID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }
}