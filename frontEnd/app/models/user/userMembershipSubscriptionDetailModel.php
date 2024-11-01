<?php
class UserMembershipSubscriptionDetailModel {

    /** Database connection. */
    private $databaseConn;
    /** FITNESS_CLASS Table. */
    private $fitnessClassTable = "FITNESS_CLASS";
    /** MEMBERSHIP Table. */
    private $membershipTable = "MEMBERSHIP";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }


    /** Returns an associate array of arrays where key is fitnessClassID attribute,
     * and every value is an associate array representing a record in the FITNESS_CLASS table.
     * If no fitness class, return an empty array.
    */
    public function getFitnessClassDataset() {

        $selectFitnessClassDatasetSQL = "SELECT * FROM " .
        $this->fitnessClassTable;
        
        $selectFitnessClassDatasetSTMT = $this->databaseConn->prepare($selectFitnessClassDatasetSQL);
        $selectFitnessClassDatasetSTMT->execute();
        $selectFitnessClassDatasetResult = $selectFitnessClassDatasetSTMT->get_result();
        $selectFitnessClassDataset = array();
        for ($i = 0; $i < $selectFitnessClassDatasetResult->num_rows; $i++) {
            $selectFitnessClassData = $selectFitnessClassDatasetResult->fetch_assoc();
            $selectFitnessClassDataset[$selectFitnessClassData['fitnessClassID']] = $selectFitnessClassData;
        }
        return $selectFitnessClassDataset;
    }

    /** Returns associate array where the array is data in the MEMBERSHIP Table,
     * where the membershipID attribute is $membershipID.
     * Otherwise, returns empty array, if no data.
     */
    public function getMembershipData($membershipID) {
        $selectMembershipDataSQL = "SELECT * FROM " . $this->membershipTable . " WHERE membershipID = ?";

        $selectMembershipDataSTMT = $this->databaseConn->prepare($selectMembershipDataSQL);
        $selectMembershipDataSTMT->bind_param("s", $membershipID);
        $selectMembershipDataSTMT->execute();
        $selectMembershipDataResult = $selectMembershipDataSTMT->get_result();
        if ($selectMembershipDataResult->num_rows > 0) {
            return $selectMembershipDataResult->fetch_assoc();
        }
        return array();
    }
}


    