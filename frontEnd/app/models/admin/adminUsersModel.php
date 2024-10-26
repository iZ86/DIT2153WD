<?php
class AdminUsersModel {
    private $databaseConn;
    private $registeredUserTable = "REGISTERED_USER";
    private $userTable = "USER";
    private $memberSubscriptionTable = "MEMBER_SUBSCRIPTION";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllUsers() {
        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, CONCAT(ru.firstName, ' ', ru.lastName) AS fullName, 
                     ru.phoneNo, ru.email, ru.gender, ru.dateOfBirth,
                     IF(ms.endOn IS NULL OR ms.endOn < NOW(), 'Inactive', 'Active') AS membershipStatus 
              FROM " . $this->registeredUserTable . " AS ru
              LEFT JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
              LEFT JOIN " . $this->memberSubscriptionTable . " AS ms ON ms.membershipID = u.userID";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addUser($firstName, $lastName, $username, $password, $email, $phoneNo, $gender, $dateOfBirth) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $registerUserQuery = "INSERT INTO " . $this->registeredUserTable . " 
                              (firstName, lastName, username, password, email, phoneNo, gender, dateOfBirth)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->databaseConn->prepare($registerUserQuery);
        $stmt->bind_param("ssssssss", $firstName, $lastName, $username, $hashedPassword, $email, $phoneNo, $gender, $dateOfBirth);
        if (!$stmt->execute()) {
            throw new Exception("Failed to add user: " . $stmt->error);
        }

        $userID = $this->databaseConn->insert_id;
        $addUserQuery = "INSERT INTO " . $this->userTable . " (userID, joinedDate) VALUES (?, NOW())";
        $userStmt = $this->databaseConn->prepare($addUserQuery);
        $userStmt->bind_param("i", $userID);
        if (!$userStmt->execute()) {
            throw new Exception("Failed to add user to USER table: " . $userStmt->error);
        }
    }

    public function editUser($registeredUserID, $firstName, $lastName, $email, $phoneNo, $gender, $dateOfBirth) {
        $updateQuery = "UPDATE " . $this->registeredUserTable . " 
                        SET firstName = ?, lastName = ?, email = ?, phoneNo = ?, gender = ?, dateOfBirth = ?
                        WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($updateQuery);
        $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $phoneNo, $gender, $dateOfBirth, $registeredUserID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user: " . $stmt->error);
        }
    }
}
