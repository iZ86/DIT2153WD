<?php

class UserBillingModel {

    /** Database connection. */
    private $databaseConn;
    /** MEMBERSHIP_SUBSCRIPTION Table. */
    private $memberSubscriptionTable = "MEMBERSHIP_SUBSCRIPTION";
    /** MEMBERSHIP Table. */
    private $membershipTable = "MEMBERSHIP";
    /** PAYMENT Table */
    private $paymentTable = "PAYMENT";
    /** FITNESS_CLASS_SUBSCRIPTION Table. */
    private $fitnessClassSubscriptionTable = "FITNESS_CLASS_SUBSCRIPTION";
    /** FITNESS_CLASAS Table. */
    private $fitnessClassTable = "FITNESS_CLASS";
    /** NUTRITIONIST_BOOKING Table. */
    private $nutritionistBookingTable = "NUTRITIONIST_BOOKING";
    /** NUTRITIONIST_SCHEDULE Table. */
    private $nutritionistScheduleTable = "NUTRITIONIST_SCHEDULE";
    /** NUTRITIONIST Table. */
    private $nutritionistTable = "NUTRITIONIST";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    
    /** Returns an array of transaction history made by the user. */
    public function getTransactionHistoryDataset($userID, $limit, $offset) {
        $selectPaymentDataset = $this->getPaymentDatasetFromUserID($userID, $limit, $offset);

        if (sizeof($selectPaymentDataset) > 0) {

            $transactionHistoryDataset = array();

            for ($i = 0; $i < sizeof($selectPaymentDataset); $i++) {
                $paymentID = $selectPaymentDataset[$i]["paymentID"];
                $transactionHistoryData["payment"] = $selectPaymentDataset[$i];
                $items = array();
                $totalAmount = 0;

                $memberSubscriptionTransactionData = $this->getMemberSubscriptionTransactionData($paymentID);

                if (sizeof($memberSubscriptionTransactionData) > 0) {
                    $item = $memberSubscriptionTransactionData["type"] . " " . $memberSubscriptionTransactionData["name"] . " (RM" . $memberSubscriptionTransactionData["price"] . ")";
                    $items[] = $item;
                    $totalAmount += $memberSubscriptionTransactionData["price"];
                }

                $fitnessClassSubscriptionTransactionDataset = $this->getFitnessClassSubscriptionTransactionDataset($paymentID);

                if (sizeof($fitnessClassSubscriptionTransactionDataset) > 0) {
                    for ($j = 0; $j < sizeof($fitnessClassSubscriptionTransactionDataset); $j++) {
                        $item = $fitnessClassSubscriptionTransactionDataset[$j]["name"] . " (RM" . $fitnessClassSubscriptionTransactionDataset[$j]["price"] . ")";
                        $items[] = $item;
                        $totalAmount += $fitnessClassSubscriptionTransactionDataset[$j]["price"];
                    }
                }

                $nutrionistBookingTransactionData = $this->getNutrionistBookingTransactionData($paymentID);
                if (sizeof($nutrionistBookingTransactionData) > 0) {
                    $item = "Nutritionist Booking with " . $nutrionistBookingTransactionData["firstName"] .
                    " " .
                    $nutrionistBookingTransactionData["lastName"] .
                    " scheduled on " .
                    $nutrionistBookingTransactionData["scheduleDateTime"] . " (RM" . $nutrionistBookingTransactionData["price"] . ")";

                    $itemp[] = $item;
                    $totalAmount += $nutrionistBookingTransactionData["price"];

                }

                $transactionHistoryData["items"] = $items;
                $transactionHistoryData["totalAmount"] = $totalAmount;
                $transactionHistoryDataset[] = $transactionHistoryData;
            }
            return $transactionHistoryDataset;
        }

        return array();

    }

    /** Returns an array containing array which represents payment data from PAYMENT table. 
     * Where the amount of payment data there are, is based on $limit, and is offsetted by $offset.
     * If no paymentData, return empty array.
    */
    public function getPaymentDatasetFromUserID($userID, $limit, $offset) {
        $selectPaymentDataSQL = "SELECT * FROM " . $this->paymentTable . " WHERE userID = ? ORDER BY createdOn DESC LIMIT ? OFFSET ?";

        $selectPaymentDataSTMT = $this->databaseConn->prepare($selectPaymentDataSQL);
        $selectPaymentDataSTMT->bind_param("sss", $userID, $limit, $offset);
        $selectPaymentDataSTMT->execute();
        
        $selectPaymentDataResult = $selectPaymentDataSTMT->get_result();

        $selectPaymentDataset = array();
        for ($i = 0; $i < $selectPaymentDataResult->num_rows; $i++) {
            $selectPaymentDataset[] = $selectPaymentDataResult->fetch_assoc();
        }

        return $selectPaymentDataset;

    }

    /** Returns one associate array of member subscription data joined with membership data,
     * from MEMBERSHIP_SUBSCRIPTION table and MEMBERSHIP table,
     * where paymentID attribute is $paymentID.
     * Otherwise, return an empty array, but this shouldnt happen,
     * as functions that calls this function verifies its arguements.
     */
    public function getMemberSubscriptionTransactionData($paymentID) {
        
        $selectMemberSubscriptionTransactionDataSQL = "SELECT * FROM " . $this->memberSubscriptionTable . " ms, " .
        $this->membershipTable . " m WHERE ms.membershipID = m.membershipID AND paymentID = ?";

        $selectMemberSubscriptionTransactionDataSTMT = $this->databaseConn->prepare($selectMemberSubscriptionTransactionDataSQL);
        $selectMemberSubscriptionTransactionDataSTMT->bind_param("s", $paymentID);
        $selectMemberSubscriptionTransactionDataSTMT->execute();
        $selectMemberSubscriptionTransactionDataResult = $selectMemberSubscriptionTransactionDataSTMT->get_result();
        if ($selectMemberSubscriptionTransactionDataResult->num_rows > 0) {
            return $selectMemberSubscriptionTransactionDataResult->fetch_assoc();
        }
        return array();
    }

    /** Returns an array of associate array of fitness class subscription data joined with fitness class data,
     * from FITNESS_CLASS_SUBSCRIPTION table and FITNESS_CLASS table,
     * where paymentID attribute is $paymentID.
     * Otherwise, return an empty array, but this shouldnt happen,
     * as functions that calls this function verifies its arguements.
     */
    public function getFitnessClassSubscriptionTransactionDataset($paymentID) {
        
        $selectFitnessClassSubscriptionTransactionDatasetSQL = "SELECT * FROM " . $this->fitnessClassSubscriptionTable . " fcs, " .
        $this->fitnessClassTable . " fc WHERE fcs.fitnessClassID = fc.fitnessClassID AND paymentID = ?";

        $selectFitnessClassSubscriptionTransactionDatasetSTMT = $this->databaseConn->prepare($selectFitnessClassSubscriptionTransactionDatasetSQL);
        $selectFitnessClassSubscriptionTransactionDatasetSTMT->bind_param("s", $paymentID);
        $selectFitnessClassSubscriptionTransactionDatasetSTMT->execute();
        $selectFitnessClassSubscriptionTransactionDatasetResult = $selectFitnessClassSubscriptionTransactionDatasetSTMT->get_result();

        $fitnessClassSubscriptionTransactionDataset = array();
        for ($i = 0; $i < $selectFitnessClassSubscriptionTransactionDatasetResult->num_rows; $i++) {
            $fitnessClassSubscriptionTransactionDataset[] = $selectFitnessClassSubscriptionTransactionDatasetResult->fetch_assoc();
        }

        return $fitnessClassSubscriptionTransactionDataset;
    }

    /** Returns one associate array of nutritionist booking data joined with nutritionist scheduling data,
     * joined with nutritionist data,
     * from NUTRITIONIST_BOOKING, NUTRITIONIST_SCHEDULE and NUTRITIONIST table,
     * where paymentID attribute is $paymentID.
     * Otherwise, return an empty array, but this shouldnt happen,
     * as functions that calls this function verifies its arguements.
     */
    public function getNutrionistBookingTransactionData($paymentID) {
        
        $selectNutrionistBookingTransactionDataSQL = "SELECT * FROM " . $this->nutritionistBookingTable . " nb, " .
        $this->nutritionistScheduleTable . " ns, " . $this->nutritionistTable . " n WHERE nb.nutritionistScheduleID = ns.nutritionistScheduleID AND ns.nutritionistID = n.nutritionistID
        AND nb.paymentID = ?";

        $selectNutrionistBookingTransactionDataSTMT = $this->databaseConn->prepare($selectNutrionistBookingTransactionDataSQL);
        $selectNutrionistBookingTransactionDataSTMT->bind_param("s", $paymentID);
        $selectNutrionistBookingTransactionDataSTMT->execute();
        $selectNutrionistBookingTransactionDataResult = $selectNutrionistBookingTransactionDataSTMT->get_result();
        if ($selectNutrionistBookingTransactionDataResult->num_rows > 0) {
            return $selectNutrionistBookingTransactionDataResult->fetch_assoc();
        }
        return array();
    }

}