<?php

class AdminPaymentsModel {
    private $databaseConn;
    private $paymentsTable = "PAYMENT";
    private $usersTable = "REGISTERED_USER";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllUsers() {
        $query = "SELECT registeredUserID, username FROM " . $this->usersTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUsernameByUserID($userID) {
        $query = "SELECT username FROM " . $this->usersTable . " WHERE registeredUserID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['username'];
        }

        return null;
    }

    public function getAllPayments($limit = null, $offset = null) {
        $query = "SELECT paymentID, type, status, createdOn, userID FROM " . $this->paymentsTable;

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

    public function getTotalAmountByPaymentID($paymentID) {
        $totalAmount = 0;

        $query = "SELECT SUM(m.price) AS totalAmount
              FROM PAYMENT p
              JOIN MEMBER_SUBSCRIPTION ms ON p.paymentID = ms.paymentID
              JOIN MEMBERSHIP m ON ms.membershipID = m.membershipID
              WHERE p.paymentID = ?";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $paymentID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalAmount += $row['totalAmount'] ? (float)$row['totalAmount'] : 0;
        }

        $query = "SELECT SUM(f.price) AS totalAmount
              FROM PAYMENT p
              JOIN FITNESS_CLASS_SUBSCRIPTION fcs ON p.paymentID = fcs.paymentID
              JOIN FITNESS_CLASS f ON fcs.fitnessClassID = f.fitnessClassID
              WHERE p.paymentID = ?";

        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("i", $paymentID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalAmount += $row['totalAmount'] ? (float)$row['totalAmount'] : 0;
        }

        return $totalAmount;
    }

    public function editPayment($paymentID, $type, $status, $createdOn, $userID) {
        $query = "UPDATE " . $this->paymentsTable . " SET type = ?, status = ?, createdOn = ?, userID = ? WHERE paymentID = ?";
        $stmt = $this->databaseConn->prepare($query);
        $stmt->bind_param("sssii", $type, $status, $createdOn, $userID, $paymentID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update payment: " . $stmt->error);
        }
    }
}