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