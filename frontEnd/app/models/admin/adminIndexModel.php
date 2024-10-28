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
}
