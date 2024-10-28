<?php
class AdminInstructorsModel {
    private $databaseConn;
    private $instructorsTable = "INSTRUCTOR";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllInstructors() {
        $query = "SELECT instructorID, firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth FROM " . $this->instructorsTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addInstructor($firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth) {
        $query = "INSERT INTO " . $this->instructorsTable . " (firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ssssssssss", $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add instructor: " . $stmt->error);
        }
    }

    public function editInstructor($instructorID, $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth) {
        $query = "UPDATE " . $this->instructorsTable . " SET firstName = ?, lastName = ?, gender = ?, phoneNo = ?, email = ?, weight = ?, height = ?, description = ?, certification = ?, dateOfBirth = ? WHERE instructorID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ssssssssssi", $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $instructorID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update instructor: " . $stmt->error);
        }
    }

    public function deleteInstructor($instructorID) {
        $query = "DELETE FROM " . $this->instructorsTable . " WHERE instructorID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $instructorID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete instructor: " . $stmt->error);
        }
    }

    public function getInstructorById($instructorID) {
        $query = "SELECT instructorID, firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth FROM INSTRUCTOR WHERE instructorID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $instructorID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}