<?php
class AdminProfileModel {
    private $databaseConn;

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAdminById($adminID) {
        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, ru.username, ru.email, 
                         ru.gender, ru.dateOfBirth AS dob, ru.phoneNo AS phone, a.salary 
                  FROM ADMIN a
                  JOIN REGISTERED_USER ru ON a.adminID = ru.registeredUserID
                  WHERE a.adminID = ?";

        $stmt = $this->databaseConn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->databaseConn->error);
        }

        $stmt->bind_param("i", $adminID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function updateRegisteredUser($adminID, $firstName, $lastName, $gender, $dob, $phone) {
        $query = "UPDATE REGISTERED_USER 
                  SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, phoneNo = ? 
                  WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $dob, $phone, $adminID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update registered user: " . $stmt->error);
        }
    }

    public function updateAdminSalary($adminID, $salary) {
        $query = "UPDATE ADMIN 
                  SET salary = ? 
                  WHERE adminID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("di", $salary, $adminID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update admin salary: " . $stmt->error);
        }
    }
}