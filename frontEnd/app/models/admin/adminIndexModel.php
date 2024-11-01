<?php
class AdminIndexModel {
    private $databaseConn;

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function countUsers() {
        $query = "SELECT COUNT(*) as count FROM USER";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    public function countClasses() {
        $query = "SELECT COUNT(*) as count FROM FITNESS_CLASS";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    public function countNutritionists() {
        $query = "SELECT COUNT(*) as count FROM NUTRITIONIST";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    public function countInstructors() {
        $query = "SELECT COUNT(*) as count FROM INSTRUCTOR";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    // In models/admin/adminIndexModel.php

    public function getUpcomingClassSchedules($limit = 2) {
        $query = "SELECT * FROM FITNESS_CLASS_SCHEDULE WHERE scheduledOn > NOW() ORDER BY scheduledOn LIMIT ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUpcomingNutritionistSchedules($limit = 2) {
        $query = "SELECT * FROM NUTRITIONIST_SCHEDULE WHERE scheduleDateTime > NOW() ORDER BY scheduleDateTime LIMIT ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestTransactions($limit = 5) {
        $query = "SELECT * FROM PAYMENT ORDER BY createdOn DESC LIMIT ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}