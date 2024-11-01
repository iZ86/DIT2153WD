<?php
class AdminIndexModel {
    private $databaseConn;

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    // Count the total number of users
    public function countUsers() {
        $query = "SELECT COUNT(*) as count FROM USER";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    // Count the total number of classes
    public function countClasses() {
        $query = "SELECT COUNT(*) as count FROM FITNESS_CLASS";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    // Count the total number of nutritionists
    public function countNutritionists() {
        $query = "SELECT COUNT(*) as count FROM NUTRITIONIST";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    // Count the total number of instructors
    public function countInstructors() {
        $query = "SELECT COUNT(*) as count FROM INSTRUCTOR";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    // Get upcoming class schedules
    public function getUpcomingClassSchedules($limit = 2) {
        $query = "SELECT fcs.fitnessClassScheduleID, fc.name AS className, fcs.pax, fcs.scheduledOn, i.firstName AS instructorFirstName, i.lastName AS instructorLastName, i.instructorID
            FROM FITNESS_CLASS_SCHEDULE fcs
            JOIN FITNESS_CLASS fc ON fcs.fitnessClassID = fc.fitnessClassID
            JOIN INSTRUCTOR i ON fcs.instructorID = i.instructorID
            WHERE fcs.scheduledOn > NOW() 
            ORDER BY fcs.scheduledOn 
            LIMIT ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get upcoming nutritionist schedules
    public function getUpcomingNutritionistSchedules($limit = 2) {
        $query = "SELECT ns.nutritionistScheduleID, ns.scheduleDateTime, 
                   n.firstName AS nutritionistFirstName, n.lastName AS nutritionistLastName, 
                   n.nutritionistID, ns.price
            FROM NUTRITIONIST_SCHEDULE ns
            JOIN NUTRITIONIST n ON ns.nutritionistID = n.nutritionistID
            WHERE ns.scheduleDateTime > NOW()
            ORDER BY ns.scheduleDateTime
            LIMIT ?";

        $stmt = $this->databaseConn->prepare($query);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->databaseConn->error);
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get latest transactions
    public function getLatestTransactions($limit = 5) {
        $query = "SELECT * FROM PAYMENT ORDER BY createdOn DESC LIMIT ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}