<?php
class AdminUsersModel {
    private $databaseConn;
    private $registeredUserTable = "REGISTERED_USER";
    private $userTable = "USER";
    private $memberSubscriptionTable = "MEMBERSHIP_SUBSCRIPTION";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllUsers($limit, $offset) {
        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, CONCAT(ru.firstName, ' ', ru.lastName) AS fullName, 
                 ru.phoneNo, ru.username, ru.email, ru.gender, ru.dateOfBirth,
                 ms.startOn, ms.endOn, 
                 IF(ms.endOn IS NULL OR ms.endOn < NOW(), 'Inactive', 'Active') AS membershipStatus 
              FROM " . $this->registeredUserTable . " AS ru
              JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
              LEFT JOIN " . $this->memberSubscriptionTable . " AS ms ON ms.membershipID = u.userID
              WHERE u.userID IS NOT NULL
              LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
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
        $userDetails = $stmt->get_result()->fetch_assoc();

        $activeMembership = $this->getActiveMembershipSubscriptionRecord($registeredUserID);
        $userDetails['membershipStart'] = $activeMembership['startOn'] ?? null;
        $userDetails['membershipEnd'] = $activeMembership['endOn'] ?? null;

        return $userDetails;
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM " . $this->userTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function editUser($registeredUserID, $firstName, $lastName, $phoneNo, $gender, $dateOfBirth) {
        $updateQuery = "UPDATE " . $this->registeredUserTable . " 
                        SET firstName = ?, lastName = ?, phoneNo = ?, gender = ?, dateOfBirth = ?
                        WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($updateQuery);
        $stmt->bind_param("sssssi", $firstName, $lastName, $phoneNo, $gender, $dateOfBirth, $registeredUserID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user: " . $stmt->error);
        }
    }

    public function getFilteredUsers($limit, $offset, $filterType, $keywords) {
        $query = "SELECT ru.registeredUserID, ru.firstName, ru.lastName, CONCAT(ru.firstName, ' ', ru.lastName) AS fullName,
                     ru.phoneNo, ru.username, ru.email, ru.gender, ru.dateOfBirth,
                     ms.startOn, ms.endOn, 
                     IF(ms.endOn IS NULL OR ms.endOn < NOW(), 'Inactive', 'Active') AS membershipStatus 
              FROM " . $this->registeredUserTable . " AS ru
              JOIN " . $this->userTable . " AS u ON ru.registeredUserID = u.userID
              LEFT JOIN " . $this->memberSubscriptionTable . " AS ms ON ms.membershipID = u.userID
              WHERE u.userID IS NOT NULL";

        if ($filterType === 'userID') {
            $query .= " AND ru.registeredUserID = ?";
        } elseif ($filterType === 'username') {
            $query .= " AND ru.username LIKE ?";
        } elseif ($filterType === 'fullName') {
            $query .= " AND CONCAT(ru.firstName, ' ', ru.lastName) LIKE ?";
        } elseif ($filterType === 'phone') {
            $query .= " AND ru.phoneNo LIKE ?";
        } elseif ($filterType === 'email') {
            $query .= " AND ru.email LIKE ?";
        } elseif ($filterType === 'gender') {
            $query .= " AND ru.gender LIKE ?";
        } elseif ($filterType === 'membership') {
            $query .= " AND IF(ms.endOn IS NULL OR ms.endOn > NOW(), 'Active', 'Inactive') = ?";
        }

        $query .= " LIMIT ? OFFSET ?";

        $stmt = $this->databaseConn->prepare($query);
        $params = [];

        // Prepare parameters based on filter type
        if ($filterType === 'userID') {
            $params[] = (int)$keywords;
        } elseif ($filterType === 'membership') {
            // Direct match for membership status
            $params[] = $keywords;
        } else {
            // Use LIKE for other filters
            $params[] = '%' . $keywords . '%';
        }

        $params[] = $limit;
        $params[] = $offset;

        $stmt->bind_param(str_repeat('s', count($params) - 2) . 'ii', ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
}