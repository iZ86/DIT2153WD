<?php
class AdminInstructorsModel {
    private $databaseConn;
    private $instructorsTable = "INSTRUCTOR";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllInstructors($limit = null, $offset = null) {
        $query = "SELECT instructorID, firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth, instructorImageFilePath FROM " . $this->instructorsTable;

        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT ? OFFSET ?";
        }

        $stmt = $this->databaseConn->prepare($query);

        if ($limit !== null && $offset !== null) {
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    // Get total count of instructors
    public function getTotalInstructors() {
        $query = "SELECT COUNT(*) as total FROM " . $this->instructorsTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function addInstructor($firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath=null) {
        $query = "INSERT INTO " . $this->instructorsTable . " (firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth, instructorImageFilePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sssssssssss", $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add instructor: " . $stmt->error);
        }
    }

    public function editInstructor($instructorID, $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath=null) {
        $query = "UPDATE " . $this->instructorsTable . " SET firstName = ?, lastName = ?, gender = ?, phoneNo = ?, email = ?, weight = ?, height = ?, description = ?, certification = ?, dateOfBirth = ?";

        if ($imagePath) {
            $query .= ", instructorImageFilePath = ?";
        }

        $query .= " WHERE instructorID = ?";
        $stmt = $this->databaseConn->prepare($query);

        if($imagePath) {
            $stmt->bind_param("sssssssssssi", $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $imagePath, $instructorID);
        } else {
            $stmt->bind_param("ssssssssssi", $firstName, $lastName, $gender, $phoneNo, $email, $weight, $height, $description, $certification, $dateOfBirth, $instructorID);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to update instructor: " . $stmt->error);
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

    public function getFilteredInstructors($filterType, $keywords, $limit, $offset) {
        $query = "SELECT instructorID, firstName, lastName, gender, phoneNo, email, weight, height, description, certification, dateOfBirth, instructorImageFilePath FROM " . $this->instructorsTable . " WHERE 1=1";

        switch ($filterType) {
            case 'instructorID':
                $query .= " AND instructorID = ?";
                break;
            case 'name':
                $query .= " AND (firstName LIKE ? OR lastName LIKE ?)";
                $keywords = '%' . $keywords . '%';
                break;
            case 'phone':
                $query .= " AND phoneNo LIKE ?";
                $keywords = '%' . $keywords . '%';
                break;
            case 'email':
                $query .= " AND email LIKE ?";
                $keywords = '%' . $keywords . '%';
                break;
            case 'gender':
                $query .= " AND gender = ?";
                break;
        }

        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT ? OFFSET ?";
        }

        $stmt = $this->databaseConn->prepare($query);

        if ($filterType === 'name') {
            $stmt->bind_param("ssii", $keywords, $keywords, $limit, $offset);
        } elseif ($filterType === 'phone' || $filterType === 'email') {
            $stmt->bind_param("ssi", $keywords, $limit, $offset);
        } elseif ($filterType === 'gender') {
            $stmt->bind_param("ssi", $keywords, $limit, $offset);
        } elseif ($filterType === 'instructorID') {
            $stmt->bind_param("iii", $keywords, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}