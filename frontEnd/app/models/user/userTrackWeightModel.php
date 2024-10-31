<?php
class UserTrackWeightModel {
    /** Database connection. */
    private $databaseConn;
    /** Weight table */
    private $weightTable = "WEIGHT";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    /** Returns an array of arrays containing weight consumption data in a day.
     * Otherwise, return an empty array.
    */
    public function getWeightDataFromDate($userID, $recordedOn) {

        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($recordedOn);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $weightSQL = "SELECT * FROM " .
        $this->weightTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $weightSTMT = $this->databaseConn->prepare($weightSQL);
        $weightSTMT->bind_param("sss", $userID, $recordedOn, $endDate);
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

    /** Adds weight into the database.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addWeightData($userID, $weightInKilograms, $recordedOn) {

        $insertWeightDataSQL = "INSERT INTO " . $this->weightTable . "(weight, recordedOn, userID) VALUES (?, ?, ?)";
        $insertWeightDataSTMT = $this->databaseConn->prepare($insertWeightDataSQL);
        $insertWeightDataSTMT->bind_param("sss", $weightInKilograms, $recordedOn, $userID);
        return $insertWeightDataSTMT->execute();

    }

    /** Updates the weight data in WEIGHT table.
     * Returns true if success.
     * Otherwise, returns false.
    */
    public function updateWeightData($weightID, $weight, $recordedOn, $userID) {
        
        
        if ($this->verifyWeightDataIDToUserID($weightID, $userID)) {
            $updateWeightDataSQL = "UPDATE " . $this->weightTable .
            " SET weight = ?, recordedOn = ? WHERE weightID = ? AND userID = ?";

            $updateWeightDataSTMT = $this->databaseConn->prepare($updateWeightDataSQL);
            $updateWeightDataSTMT->bind_param("ssss", $weight, $recordedOn, $weightID, $userID);
            $updateWeightDataSTMT->execute();
            
            // Checks if there was any error running the sql statemnt, error number 0 is no errors.
            if ($updateWeightDataSTMT->errno === 0) {
                return true;
            }
        }

        return false;
    }

    /** Deletes the weight data in WEIGHT table.
     * return true if success.
     * Otherwise, returns false.
     */
    public function deleteWeightData($weightID, $userID) {

        if ($this->verifyWeightDataIDToUserID($weightID, $userID)) {
            
            
            $deleteWeightDataSQL = "DELETE FROM " . $this->weightTable .
            " WHERE WEIGHTID = ? AND userID = ?";

            $deleteWeightDataSTMT = $this->databaseConn->prepare($deleteWeightDataSQL);
            $deleteWeightDataSTMT->bind_param("ss", $weightID, $userID);
            $deleteWeightDataSTMT->execute();

            // Checks if there was any error running the sql statemnt, error number 0 is no errors.
            if ($deleteWeightDataSTMT->errno === 0) {
                return true;
            }
        }
        return false;
    }

    /** Returns true if there is a record that belongs to the $weightID and $userID.
     * Otherwise, returns false.
     * This function is used to prove that the $weightID sent by the $_POST in the controller
     * actually belongs to the userID, and allows the userID to perform write actions on it.
    */
    private function verifyWeightDataIDToUserID($weightID, $userID) {
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

