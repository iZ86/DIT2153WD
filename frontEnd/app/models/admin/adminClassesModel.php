<?php
class AdminClassesModel {
    private $databaseConn;
    private $classesTable = "FITNESS_CLASS";
    private $scheduleTable = "FITNESS_CLASS_SCHEDULE";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllClasses() {
        $query = "SELECT fitnessClassID, name, description FROM " . $this->classesTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addClass($name, $description) {
        $query = "INSERT INTO " . $this->classesTable . " (name, description) VALUES (?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ss", $name, $description);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add class: " . $stmt->error);
        }
    }

    public function editClass($fitnessClassID, $name, $description) {
        $query = "UPDATE " . $this->classesTable . " SET name = ?, description = ? WHERE fitnessClassID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ssi", $name, $description, $fitnessClassID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update class: " . $stmt->error);
        }
    }

    public function getAllSchedules() {
        $query = "SELECT fcs.fitnessClassScheduleID, 
                  fcs.fitnessClassID,
                  fcs.instructorID,
                  fc.name AS className, 
                  CONCAT(i.firstName, ' ', i.lastName) AS instructor, 
                  fcs.scheduledOn, 
                  fcs.createdOn, 
                  fcs.pax 
           FROM " . $this->scheduleTable . " AS fcs
           JOIN " . $this->classesTable . " AS fc ON fcs.fitnessClassID = fc.fitnessClassID
           JOIN INSTRUCTOR AS i ON fcs.instructorID = i.instructorID
           ORDER BY fcs.fitnessClassScheduleID ASC";
        $stmt = $this->databaseConn->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->databaseConn->error));
        }
        $stmt->execute();
        return $stmt->get_result();
    }


    public function getAllInstructors() {
        $query = "SELECT instructorID, CONCAT(firstName, ' ', lastName) AS fullName FROM INSTRUCTOR";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }


    public function addSchedule($fitnessClassID, $scheduledOn, $pax, $instructorID) {
        $query = "INSERT INTO " . $this->scheduleTable . " (fitnessClassID, scheduledOn, createdOn, pax, instructorID) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("isii", $fitnessClassID, $scheduledOn, $pax, $instructorID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add schedule: " . $stmt->error);
        }
    }

    public function editSchedule($fitnessClassScheduleID, $fitnessClassID, $scheduledOn, $pax, $instructorID) {
        $query = "UPDATE " . $this->scheduleTable . " SET fitnessClassID = ?, scheduledOn = ?, pax = ?, instructorID = ? WHERE fitnessClassScheduleID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("isiii", $fitnessClassID, $scheduledOn, $pax, $instructorID, $fitnessClassScheduleID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update schedule: " . $stmt->error);
        }
    }
}
