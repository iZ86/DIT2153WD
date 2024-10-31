<?php
class UserTrackWeightModel {
    /** Database connection. */
    private $databaseConn;
    /** WEIGHT table */
    private $weightTable = "WEIGHT";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    
    /** Returns an associate array of arrays where key is weightID attribute,
     * and every value is an associate array representing a record in the WEIGHT table,
     * where recordedOn attribute is $recordedOn,
     * and userID attribute is $userID.
     * Otherwise, return an empty array.
    */
    public function getWeightDatasetFromDate($date, $userID) {

        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($date);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $weightSQL = "SELECT * FROM " .
        $this->weightTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $weightSTMT = $this->databaseConn->prepare($weightSQL);
        $weightSTMT->bind_param("sss", $userID, $date, $endDate);
        $weightSTMT->execute();
        $weightResult = $weightSTMT->get_result();
        $weightResultDataArray = array();
        for ($i = 0; $i < $weightResult->num_rows; $i++) {
            $weightResultData = $weightResult->fetch_assoc();
            $weightResultDataRecordOnAttribute = date_create($weightResultData['recordedOn']);
            $weightResultData['recordedOnTime'] = $weightResultDataRecordOnAttribute->format('H:i');
            $weightResultData['recordedOnDate'] = $weightResultDataRecordOnAttribute->format('Y-m-d');
            $weightResultDataArray[$weightResultData['weightID']] = $weightResultData;
        }
        return $weightResultDataArray;
    }

    /** Adds weight data into the database.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addWeightData($userID, $weightInGram, $recordedOn) {

        $insertWeightDataSQL = "INSERT INTO " . $this->weightTable . "(weightInGram, recordedOn, userID) VALUES (?, ?, ?)";
        $insertWeightDataSTMT = $this->databaseConn->prepare($insertWeightDataSQL);
        $insertWeightDataSTMT->bind_param("sss", $weightInGram, $recordedOn, $userID);
        return $insertWeightDataSTMT->execute();

    }

    /** Updates the weight data in WEIGHT table.
     * Returns true if success.
     * Otherwise, returns false.
    */
    public function updateWeightData($weightID, $weightInGram, $recordedOn, $userID) {
        
        
        if ($this->verifyWeightIDToUserID($weightID, $userID)) {
            $updateWeightDataSQL = "UPDATE " . $this->weightTable .
            " SET weight = ?, recordedOn = ? WHERE weightID = ? AND userID = ?";

            $updateWeightDataSTMT = $this->databaseConn->prepare($updateWeightDataSQL);
            $updateWeightDataSTMT->bind_param("ssss", $weightInGram, $recordedOn, $weightID, $userID);
            return $updateWeightDataSTMT->execute();
            
            
        }

        return false;
    }

    /** Deletes the weight data in WEIGHT table.
     * returns true if success.
     * Otherwise, returns false.
     */
    public function deleteWeightData($weightID, $userID) {

        if ($this->verifyWeightIDToUserID($weightID, $userID)) {
            
            
            $deleteWeightDataSQL = "DELETE FROM " . $this->weightTable .
            " WHERE WEIGHTID = ? AND userID = ?";

            $deleteWeightDataSTMT = $this->databaseConn->prepare($deleteWeightDataSQL);
            $deleteWeightDataSTMT->bind_param("ss", $weightID, $userID);
            return $deleteWeightDataSTMT->execute();

        }
        return false;
    }

    /** Returns true if there is a data in the WEIGHT table,
     * where weightID attribute is $weightID,
     * and userID attribute is $userID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist, 
     * and that the user has the permissions to manipulate the data,
     * where weightID attribute is $weightID in the WEIGHT table.
    */
    private function verifyWeightIDToUserID($weightID, $userID) {
        $selectWeightDataSQL = "SELECT 1 FROM " . $this->weightTable . " WHERE weightID = ? AND userID = ?";
        $selectWeightDataSTMT= $this->databaseConn->prepare($selectWeightDataSQL);
        $selectWeightDataSTMT->bind_param("ss", $weightID, $userID);
        $selectWeightDataSTMT->execute();
        $selectWeightDataResult = $selectWeightDataSTMT->get_result();
        if ($selectWeightDataResult->num_rows === 1) {
            return true;
        }
        return false;
    }
}

