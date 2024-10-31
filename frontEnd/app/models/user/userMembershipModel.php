<?php
class UserMembershipModel {
    /** Database connection */
    private $databaseConn;
    /** MEMBER_SUBSCRIPTION Table. */
    private $memberSubscriptionTable = "MEMBER_SUBSCRIPTION";
    /** MEMBERSHIP Table. */
    private $membershipTable = "MEMBERSHIP";
    /** PAYMENT Table */
    private $paymentTable = "PAYMENT";
    /** FITNESS_CLASS_SUBSCRIPTION Table. */
    private $fitnessClassSubscriptionTable = "FITNESS_CLASS_SUBSCRIPTION";
    /** FITNESS_CLASAS table. */
    private $fitnessClassTable = "FITNESS_CLASS";

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Returns one associate array that contains the active membership subscription data that belongs to $userID.
     * If there is no active membership subscription data, return an empty array.
     */
    public function getActiveMembershipSubscriptionData($userID) {
        $activeMembershipSubscriptionSQL = "SELECT * FROM " . $this->paymentTable . " p, " . $this->memberSubscriptionTable .
        " ms, " . $this->membershipTable . " m WHERE p.paymentID = ms.paymentID AND 
        ms.membershipID = m.membershipID AND p.userID = ? AND ms.endOn > NOW()";

        $activeMembershipSubscriptionSTMT = $this->databaseConn->prepare($activeMembershipSubscriptionSQL);
        $activeMembershipSubscriptionSTMT->bind_param("s", $userID);
        $activeMembershipSubscriptionSTMT->execute();
        $activeMembershipSubscriptionResult = $activeMembershipSubscriptionSTMT->get_result();
        if ($activeMembershipSubscriptionResult->num_rows > 0) {
            $activeMembershipSubscriptionData = $activeMembershipSubscriptionResult->fetch_assoc();
            $date = date_create($activeMembershipSubscriptionData["endOn"]);
            $activeMembershipSubscriptionData["endOn"] = $date->format('Y-m-d');
            return $activeMembershipSubscriptionData;
        }
        return array();
    }

    /** Returns the sum of the FITNESS_CLASS_SUBSCRIPTION record, where paymentID attribute is $paymentID.
     * No checks inside the function, as this method won't be accessed by the client.
    */
    public function getSumPriceOfFitnessClassSubscriptionToPaymentID($paymentID) {
        $sumPriceOfFitnessClassSubscriptionToPaymentIDSQL = "SELECT SUM(fc.price) as sumPriceOfFitnessClassSubscriptionToPaymentID FROM "  .
        $this->fitnessClassSubscriptionTable . " fcs, " . $this->fitnessClassTable .
        " fc WHERE fcs.fitnessClassID = fc.fitnessClassID AND fcs.paymentID = ?";
        
        $sumPriceOfFitnessClassSubscriptionToPaymentIDSTMT = $this->databaseConn->prepare($sumPriceOfFitnessClassSubscriptionToPaymentIDSQL);
        $sumPriceOfFitnessClassSubscriptionToPaymentIDSTMT->bind_param("s", $paymentID);
        $sumPriceOfFitnessClassSubscriptionToPaymentIDSTMT->execute();
        $sumPriceOfFitnessClassSubscriptionToPaymentIDResult = $sumPriceOfFitnessClassSubscriptionToPaymentIDSTMT->get_result();
        if ($sumPriceOfFitnessClassSubscriptionToPaymentIDResult->num_rows > 0) {
            return $sumPriceOfFitnessClassSubscriptionToPaymentIDResult->fetch_assoc();
        }
        return array();
    }

}