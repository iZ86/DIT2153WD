<?php
class AdminUsersModel {
    private $databaseConn;
    private $registeredUserTable = "REGISTERED_USER";
    private $userTable = "USER";
    private $memberSubscriptionTable = "MEMBER_SUBSCRIPTION";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllUsers($limit, $offset, $searchQuery = '') {
        $searchCondition = '';
        if ($searchQuery) {
            $searchCondition = " AND (CONCAT(ru.firstName, ' ', ru.lastName) LIKE ? OR ru.username LIKE ? OR ru.email LIKE ?)";
        }

        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, CONCAT(ru.firstName, ' ', ru.lastName) AS fullName, 
                 ru.phoneNo, ru.username, ru.email, ru.gender, ru.dateOfBirth,
                 ms.startOn, ms.endOn, 
                 IF(ms.endOn IS NULL OR ms.endOn < NOW(), 'Inactive', 'Active') AS membershipStatus 
          FROM " . $this->registeredUserTable . " AS ru
          JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
          LEFT JOIN " . $this->memberSubscriptionTable . " AS ms ON ms.membershipID = u.userID
          WHERE u.userID IS NOT NULL" . $searchCondition . "
          LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        if ($searchQuery) {
            $likeQuery = '%' . $searchQuery . '%';
            $stmt->bind_param("ssssi", $likeQuery, $likeQuery, $likeQuery, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserDetails($registeredUserID) {
        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, ru.username, ru.email, 
                 ru.phoneNo, ru.gender, ru.dateOfBirth,
                 ms.startOn, ms.endOn
          FROM " . $this->registeredUserTable . " AS ru
          JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
          LEFT JOIN " . $this->memberSubscriptionTable . " AS ms ON ms.membershipID = u.userID
          WHERE ru.registeredUserID = ?";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $registeredUserID);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserCount($searchQuery = '') {
        $searchCondition = '';
        if ($searchQuery) {
            $searchCondition = " AND (CONCAT(ru.firstName, ' ', ru.lastName) LIKE ? OR ru.username LIKE ? OR ru.email LIKE ?)";
        }

        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->registeredUserTable . " AS ru
                  JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
                  WHERE u.userID IS NOT NULL" . $searchCondition;

        $stmt = $this->databaseConn->prepare($query);
        if ($searchQuery) {
            $likeQuery = '%' . $searchQuery . '%';
            $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function editUser($registeredUserID, $firstName, $lastName, $username, $email, $phoneNo, $gender, $dateOfBirth) {
        $updateQuery = "UPDATE " . $this->registeredUserTable . " 
                        SET firstName = ?, lastName = ?, username = ?, email = ?, phoneNo = ?, gender = ?, dateOfBirth = ?
                        WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($updateQuery);
        $stmt->bind_param("sssssssi", $firstName, $lastName, $username, $email, $phoneNo, $gender, $dateOfBirth, $registeredUserID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user: " . $stmt->error);
        }
    }
}
