<?php
class AdminNutritionistsModel {
    private $databaseConn;
    private $nutritionistsTable = "NUTRITIONIST";
    private $scheduleTable = "NUTRITIONIST_SCHEDULE";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getTotalNutritionists() {
        $query = "SELECT COUNT(*) as total FROM " . $this->nutritionistsTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function getNutritionists($limit, $offset) {
        $query = "SELECT nutritionistID, firstName, lastName, gender, phoneNo, email, type 
              FROM " . $this->nutritionistsTable . " 
              LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalSchedules() {
        $query = "SELECT COUNT(*) as total FROM " . $this->scheduleTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function getSchedules($limit, $offset) {
        $query = "SELECT ns.nutritionistScheduleID, 
                     n.nutritionistID, 
                     CONCAT(n.firstName, ' ', n.lastName) AS nutritionistName, 
                     ns.scheduleDateTime, 
                     ns.price 
              FROM " . $this->scheduleTable . " AS ns
              JOIN " . $this->nutritionistsTable . " AS n ON ns.nutritionistID = n.nutritionistID
              ORDER BY ns.nutritionistScheduleID ASC
              LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addNutritionist($firstName, $lastName, $gender, $phoneNo, $email, $type) {
        $query = "INSERT INTO " . $this->nutritionistsTable . " (firstName, lastName, gender, phoneNo, email, type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $phoneNo, $email, $type);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add nutritionist: " . $stmt->error);
        }
    }

    public function editNutritionist($nutritionistID, $firstName, $lastName, $gender, $phoneNo, $email, $type) {
        $query = "UPDATE " . $this->nutritionistsTable . " SET firstName = ?, lastName = ?, gender = ?, phoneNo = ?, email = ?, type = ? WHERE nutritionistID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ssssssi", $firstName, $lastName, $gender, $phoneNo, $email, $type, $nutritionistID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update nutritionist: " . $stmt->error);
        }
    }

    public function deleteNutritionist($nutritionistID) {
        $query = "DELETE FROM " . $this->nutritionistsTable . " WHERE nutritionistID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $nutritionistID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete nutritionist: " . $stmt->error);
        }
    }

    public function addSchedule($nutritionistID, $scheduleDateTime, $price) {
        $query = "INSERT INTO " . $this->scheduleTable . " (nutritionistID, createdOn, scheduleDateTime, price) VALUES (?, NOW(), ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("isd", $nutritionistID, $scheduleDateTime, $price);

        if (!$stmt->execute()) {
            error_log("Failed to add schedule: " . $stmt->error);
            throw new Exception("Failed to add schedule: " . $stmt->error);
        }
    }

    public function editSchedule($nutritionistScheduleID, $nutritionistID, $scheduleDateTime, $price) {
        $query = "UPDATE " . $this->scheduleTable . " SET nutritionistID = ?, scheduleDateTime = ?, price = ? WHERE nutritionistScheduleID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("isdi", $nutritionistID, $scheduleDateTime, $price, $nutritionistScheduleID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update schedule: " . $stmt->error);
        }
    }

    public function deleteSchedule($nutritionistScheduleID) {
        $query = "DELETE FROM " . $this->scheduleTable . " WHERE nutritionistScheduleID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $nutritionistScheduleID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete schedule: " . $stmt->error);
        }
    }
}