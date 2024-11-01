<?php
class AdminClassesModel {
    private $databaseConn;
    private $classesTable = "FITNESS_CLASS";
    private $scheduleTable = "FITNESS_CLASS_SCHEDULE";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function addClass($name, $description, $imagePath = null) {
        $query = "INSERT INTO " . $this->classesTable . " (name, description, fitnessClassImageFilePath) VALUES (?, ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sss", $name, $description, $imagePath);

        if (!$stmt->execute()) {
            throw new Exception("Failed to add class: " . $stmt->error);
        }
    }

    public function editClass($fitnessClassID, $name, $description, $imagePath = null) {
        $query = "UPDATE " . $this->classesTable . " SET name = ?, description = ?";

        if ($imagePath) {
            $query .= ", fitnessClassImageFilePath = ?";
        }

        $query .= " WHERE fitnessClassID = ?";
        $stmt = $this->databaseConn->prepare($query);

        if ($imagePath) {
            $stmt->bind_param("sssi", $name, $description, $imagePath, $fitnessClassID);
        } else {
            $stmt->bind_param("ssi", $name, $description, $fitnessClassID);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to update class: " . $stmt->error);
        }
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

    public function getClasses($limit, $offset) {
        $query = "SELECT fitnessClassID, name, description, fitnessClassImageFilePath FROM " . $this->classesTable . " LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getSchedules($limit, $offset) {
        $query = "SELECT fcs.fitnessClassScheduleID, 
                     fcs.fitnessClassID,
                     fcs.instructorID,
                     fc.name AS className, 
                     CONCAT(i.firstName, ' ', i.lastName) AS instructor, 
                     fcs.scheduledOn, 
                     fcs.createdOn, 
                     fcs.pax,
                     CASE 
                         WHEN fcs.scheduledOn > NOW() THEN 'Upcoming'
                         WHEN fcs.scheduledOn <= NOW() AND fcs.scheduledOn > NOW() - INTERVAL 2 HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END as status
              FROM " . $this->scheduleTable . " AS fcs
              JOIN " . $this->classesTable . " AS fc ON fcs.fitnessClassID = fc.fitnessClassID
              JOIN INSTRUCTOR AS i ON fcs.instructorID = i.instructorID
              ORDER BY fcs.fitnessClassScheduleID ASC
              LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalClasses() {
        $query = "SELECT COUNT(*) as total FROM " . $this->classesTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function getTotalSchedules() {
        $query = "SELECT COUNT(*) as total FROM " . $this->scheduleTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function getFilteredClassesByName($name, $limit, $offset) {
        $query = "SELECT fitnessClassID, name, description, fitnessClassImageFilePath FROM " . $this->classesTable . " WHERE name LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $searchTerm = '%' . $name . '%';
        $stmt->bind_param("sii", $searchTerm, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFilteredClassesByDescription($description, $limit, $offset) {
        $query = "SELECT fitnessClassID, name, description, fitnessClassImageFilePath FROM " . $this->classesTable . " WHERE description LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $searchTerm = '%' . $description . '%';
        $stmt->bind_param("sii", $searchTerm, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFilteredSchedules($limit, $offset, $filterType, $keywords) {
        $query = "SELECT fcs.fitnessClassScheduleID, 
                     fcs.fitnessClassID,
                     fcs.instructorID,
                     fc.name AS className, 
                     CONCAT(i.firstName, ' ', i.lastName) AS instructor, 
                     fcs.scheduledOn, 
                     fcs.pax,
                     CASE 
                         WHEN fcs.scheduledOn > NOW() THEN 'Upcoming'
                         WHEN fcs.scheduledOn <= NOW() AND fcs.scheduledOn > NOW() - INTERVAL 2 HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END as status
              FROM " . $this->scheduleTable . " AS fcs
              JOIN " . $this->classesTable . " AS fc ON fcs.fitnessClassID = fc.fitnessClassID
              JOIN INSTRUCTOR AS i ON fcs.instructorID = i.instructorID
              WHERE 1=1";

        if ($filterType === 'className') {
            $query .= " AND fc.name LIKE ?";
        } elseif ($filterType === 'instructor') {
            $query .= " AND i.instructorID = (SELECT instructorID FROM INSTRUCTOR WHERE CONCAT(firstName, ' ', lastName) LIKE ?)";
        } elseif ($filterType === 'pax') {
            $query .= " AND fcs.pax = ?";
        } elseif ($filterType === 'status') {
            $query .= " AND CASE 
                         WHEN fcs.scheduledOn > NOW() THEN 'Upcoming'
                         WHEN fcs.scheduledOn <= NOW() AND fcs.scheduledOn > NOW() - INTERVAL 2 HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END = ?";
        } elseif ($filterType === 'scheduledOn') {
            $query .= " AND DATE(fcs.scheduledOn) = ?";
        }

        $query .= " ORDER BY fcs.fitnessClassScheduleID ASC LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $params = [];

        if ($filterType === 'className' || $filterType === 'instructor') {
            $params[] = '%' . $keywords . '%';
        } elseif ($filterType === 'pax') {
            $params[] = (int)$keywords;
        } elseif ($filterType === 'status') {
            $params[] = $keywords;
        } elseif ($filterType === 'scheduledOn') {
            $params[] = $keywords;
        }

        $params[] = $limit;
        $params[] = $offset;

        $stmt->bind_param(str_repeat('s', count($params) - 2) . 'ii', ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
}