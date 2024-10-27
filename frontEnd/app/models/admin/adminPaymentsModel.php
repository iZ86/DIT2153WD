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

    public function getAllPayments() {
        $query = "SELECT paymentID, type, status, createdOn, userID FROM " . $this->paymentsTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*TODO: Sum all the amount of records(price) to one paymentID*/
    public function getTotalAmountByPaymentID($paymentID) {

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