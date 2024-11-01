<?php
class AdminNutritionistsModel {
    private $databaseConn;
    private $nutritionistsTable = "NUTRITIONIST";
    private $scheduleTable = "NUTRITIONIST_SCHEDULE";
    private $bookingsTable = 'NUTRITIONIST_BOOKING';

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
        $query = "SELECT nutritionistID, firstName, lastName, gender, dateOfBirth, phoneNo, email, type, description, nutritionistImageFilePath
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
                     ns.price,
                     CASE 
                         WHEN ns.scheduleDateTime > NOW() THEN 'Upcoming'
                         WHEN ns.scheduleDateTime <= NOW() AND ns.scheduleDateTime > NOW() - INTERVAL 2  HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END as status
              FROM " . $this->scheduleTable . " AS ns
              JOIN " . $this->nutritionistsTable . " AS n ON ns.nutritionistID = n.nutritionistID
              ORDER BY ns.nutritionistScheduleID ASC
              LIMIT ? OFFSET ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addNutritionist($firstName, $lastName, $gender, $dateOfBirth, $phoneNo, $email, $type, $description, $imagePath = null) {
        $query = "INSERT INTO " . $this->nutritionistsTable . " (firstName, lastName, gender, dateOfBirth, phoneNo, email, type, description, nutritionistImageFilePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sssssssss", $firstName, $lastName, $gender, $dateOfBirth, $phoneNo, $email, $type, $description, $imagePath);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add nutritionist: " . $stmt->error);
        }
    }

    public function editNutritionist($nutritionistID, $firstName, $lastName, $gender, $dateOfBirth, $phoneNo, $email, $type, $description, $imagePath = null) {
        $query = "UPDATE " . $this->nutritionistsTable . " SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, phoneNo = ?, email = ?, type = ?, description = ?";

        if ($imagePath) {
            $query .= ", nutritionistImageFilePath = ?";
        }

        $query .= " WHERE nutritionistID = ?";
        $stmt = $this->databaseConn->prepare($query);

        if ($imagePath) {
            $stmt->bind_param("ssssssssi", $firstName, $lastName, $gender, $dateOfBirth, $phoneNo, $email, $type, $description, $imagePath, $nutritionistID);
        } else {
            $stmt->bind_param("ssssssssi", $firstName, $lastName, $gender, $dateOfBirth, $phoneNo, $email, $type, $description, $nutritionistID);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to update nutritionist: " . $stmt->error);
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

    public function addBooking($description, $nutritionistScheduleID, $userID, $paymentID) {
        $query = "INSERT INTO NUTRITIONIST_BOOKING (description, nutritionistScheduleID, userID, paymentID) VALUES (?, ?, ?, ?)";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("siis", $description, $nutritionistScheduleID, $userID, $paymentID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add booking: " . $stmt->error);
        }
    }

    public function getTotalBookings() {
        $query = "SELECT COUNT(*) as total FROM NUTRITIONIST_BOOKING";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function getBookingDetails($nutritionistBookingID) {
        $query = "SELECT nutritionistID, nutritionistScheduleID, description FROM NUTRITIONIST_BOOKING WHERE nutritionistBookingID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $nutritionistBookingID);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getBookingsWithDetails($limit, $offset) {
        $query = "SELECT nb.nutritionistBookingID, 
                     nb.description, 
                     ns.scheduleDateTime, 
                     ns.nutritionistScheduleID,
                     CONCAT(n.firstName, ' ', n.lastName) AS nutritionistName, 
                     ru.username
              FROM NUTRITIONIST_BOOKING AS nb
              JOIN NUTRITIONIST_SCHEDULE AS ns ON nb.nutritionistScheduleID = ns.nutritionistScheduleID
              JOIN NUTRITIONIST AS n ON ns.nutritionistID = n.nutritionistID
              JOIN REGISTERED_USER AS ru ON nb.userID = ru.registeredUserID
              LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->databaseConn->error);
        }

        $stmt->bind_param("ii", $limit, $offset);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute statement: " . $stmt->error);
        }

        return $stmt->get_result();
    }

    public function getFilteredNutritionists($limit, $offset, $filterType, $keywords) {
        $query = "SELECT nutritionistID, firstName, lastName, gender, dateOfBirth, phoneNo, email, type, description, nutritionistImageFilePath 
              FROM " . $this->nutritionistsTable . " 
              WHERE 1=1";

        if ($filterType === 'nutritionistID') {
            $query .= " AND nutritionistID = ?";
        } elseif ($filterType === 'name') {
            $query .= " AND (firstName LIKE ? OR lastName LIKE ?)";
        } elseif ($filterType === 'phone') {
            $query .= " AND phoneNo LIKE ?";
        } elseif ($filterType === 'email') {
            $query .= " AND email LIKE ?";
        } elseif ($filterType === 'gender') {
            $query .= " AND gender = ?";
        } elseif ($filterType === 'type') {
            $query .= " AND type LIKE ?";
        }

        $query .= " LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $likeQuery = '%' . $keywords . '%';

        if ($filterType === 'nutritionistID') {
            $stmt->bind_param("iii", $keywords, $limit, $offset);
        } elseif ($filterType === 'name') {
            $stmt->bind_param("ssii", $likeQuery, $likeQuery, $limit, $offset);
        } elseif ($filterType === 'phone' || $filterType === 'email' || $filterType === 'type') {
            $stmt->bind_param("ssi", $likeQuery, $limit, $offset);
        } elseif ($filterType === 'gender') {
            $stmt->bind_param("ssi", $keywords, $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFilteredSchedules($limit, $offset, $filterType, $keywords) {
        $query = "SELECT ns.nutritionistScheduleID, 
                     n.nutritionistID, 
                     CONCAT(n.firstName, ' ', n.lastName) AS nutritionistName, 
                     ns.scheduleDateTime, 
                     ns.price,
                     CASE 
                         WHEN ns.scheduleDateTime > NOW() THEN 'Upcoming'
                         WHEN ns.scheduleDateTime <= NOW() AND ns.scheduleDateTime > NOW() - INTERVAL 2  HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END as status
              FROM " . $this->scheduleTable . " AS ns
              JOIN " . $this->nutritionistsTable . " AS n ON ns.nutritionistID = n.nutritionistID
              WHERE 1=1";

        if ($filterType === 'scheduleID') {
            $query .= " AND ns.nutritionistScheduleID = ?";
        } elseif ($filterType === 'nutritionistName') {
            $query .= " AND CONCAT(n.firstName, ' ', n.lastName) LIKE ?";
        } elseif ($filterType === 'scheduledOn') {
            $query .= " AND ns.scheduleDateTime LIKE ?";
        } elseif ($filterType === 'price') {
            $query .= " AND ns.price = ?";
        } elseif ($filterType === 'status') {
            $query .= " AND CASE 
                         WHEN ns.scheduleDateTime > NOW() THEN 'Upcoming'
                         WHEN ns.scheduleDateTime <= NOW() AND ns.scheduleDateTime > NOW() - INTERVAL 2  HOUR THEN 'In Progress'
                         ELSE 'Completed'
                     END = ?";
        }

        $query .= " LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $likeQuery = '%' . $keywords . '%';
        if ($filterType === 'scheduleID' || $filterType === 'price') {
            $stmt->bind_param("iii", $keywords, $limit, $offset);
        } elseif ($filterType === 'nutritionistName' || $filterType === 'scheduledOn' || $filterType === 'status') {
            $stmt->bind_param("ssi", $likeQuery, $limit, $offset);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFilteredBookings($limit, $offset, $filterType, $keywords) {
        $query = "SELECT nb.nutritionistBookingID, 
                     nb.description, 
                     ns.scheduleDateTime, 
                     ns.nutritionistScheduleID,
                     CONCAT(n.firstName, ' ', n.lastName) AS nutritionistName, 
                     ru.username
              FROM NUTRITIONIST_BOOKING AS nb
              JOIN NUTRITIONIST_SCHEDULE AS ns ON nb.nutritionistScheduleID = ns.nutritionistScheduleID
              JOIN NUTRITIONIST AS n ON ns.nutritionistID = n.nutritionistID
              JOIN REGISTERED_USER AS ru ON nb.userID = ru.registeredUserID
              WHERE 1=1";

        if ($filterType === 'bookingID') {
            $query .= " AND nb.nutritionistBookingID = ?";
        } elseif ($filterType === 'nutritionistName') {
            $query .= " AND CONCAT(n.firstName, ' ', n.lastName) LIKE ?";
        } elseif ($filterType === 'scheduleID') {
            $query .= " AND nb.nutritionistScheduleID = ?";
        } elseif ($filterType === 'username') {
            $query .= " AND ru.username LIKE ?";
        } elseif ($filterType === 'description') {
            $query .= " AND nb.description LIKE ?";
        }

        $query .= " LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $likeQuery = '%' . $keywords . '%';
        if ($filterType === 'bookingID' || $filterType === 'scheduleID') {
            $stmt->bind_param("iii", $keywords, $limit, $offset);
        } elseif ($filterType === 'description' || $filterType === 'nutritionistName' || $filterType === 'username') {
            $stmt->bind_param("ssi", $likeQuery, $limit, $offset);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}