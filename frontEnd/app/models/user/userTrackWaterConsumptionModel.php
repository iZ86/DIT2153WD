<?php
class UserTrackWaterConsumptionModel {
    /** Database connection. */
    private $databaseConn;
    /** WATER_CONSUMPTION table */
    private $waterConsumptionTable = "WATER_CONSUMPTION";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    
    /** Returns an associate array of arrays where key is waterConsumptionID attribute,
     * and every value is an associate array representing a record in the WATER_CONSUMPTION table,
     * where recordedOn attribute is $recordedOn,
     * and userID attribute is $userID.
     * Otherwise, return an empty array.
    */
    public function getWaterConsumptionDataFromDate($userID, $recordedOn) {

        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($recordedOn);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $waterConsumptionSQL = "SELECT * FROM " .
        $this->waterConsumptionTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $waterConsumptionSTMT = $this->databaseConn->prepare($waterConsumptionSQL);
        $waterConsumptionSTMT->bind_param("sss", $userID, $recordedOn, $endDate);
        $waterConsumptionSTMT->execute();
        $waterConsumptionResult = $waterConsumptionSTMT->get_result();
        $waterConsumptionResultDataArray = array();
        for ($i = 0; $i < $waterConsumptionResult->num_rows; $i++) {
            $waterConsumptionResultData = $waterConsumptionResult->fetch_assoc();
            $waterConsumptionResultDataRecordOnAttribute = date_create($waterConsumptionResultData['recordedOn']);
            $waterConsumptionResultData['recordedOnTime'] = $waterConsumptionResultDataRecordOnAttribute->format('H:i');
            $waterConsumptionResultData['recordedOnDate'] = $waterConsumptionResultDataRecordOnAttribute->format('Y-m-d');
            $waterConsumptionResultDataArray[$waterConsumptionResultData['waterConsumptionID']] = $waterConsumptionResultData;
        }
        return $waterConsumptionResultDataArray;
    }

    /** Adds water consumption data into the database.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addWaterConsumptionData($userID, $amountDrankInMilliliters, $recordedOn) {

        $insertWaterConsumptionDataSQL = "INSERT INTO " . $this->waterConsumptionTable . "(milliliters, recordedOn, userID) VALUES (?, ?, ?)";
        $insertWaterConsumptionDataSTMT = $this->databaseConn->prepare($insertWaterConsumptionDataSQL);
        $insertWaterConsumptionDataSTMT->bind_param("sss", $amountDrankInMilliliters, $recordedOn, $userID);
        return $insertWaterConsumptionDataSTMT->execute();

    }

    /** Updates the water consumption data in WATER_CONSUMPTION table.
     * Returns true if success.
     * Otherwise, returns false.
    */
    public function updateWaterConsumptionData($waterConsumptionID, $amountDrankInMilliliters, $recordedOn, $userID) {
        
        
        if ($this->verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID)) {
            $updateWaterConsumptionDataSQL = "UPDATE " . $this->waterConsumptionTable .
            " SET milliliters = ?, recordedOn = ? WHERE waterConsumptionID = ? AND userID = ?";

            $updateWaterConsumptionDataSTMT = $this->databaseConn->prepare($updateWaterConsumptionDataSQL);
            $updateWaterConsumptionDataSTMT->bind_param("ssss", $amountDrankInMilliliters, $recordedOn, $waterConsumptionID, $userID);
            return $updateWaterConsumptionDataSTMT->execute();
            
        }

        return false;
    }

    /** Deletes the water consumption data in WATER_CONSUMPTION table.
     * returns true if success.
     * Otherwise, returns false.
     */
    public function deleteWaterConsumptionData($waterConsumptionID, $userID) {

        if ($this->verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID)) {
            
            
            $deleteWaterConsumptionDataSQL = "DELETE FROM " . $this->waterConsumptionTable .
            " WHERE waterConsumptionID = ? AND userID = ?";

            $deleteWaterConsumptionDataSTMT = $this->databaseConn->prepare($deleteWaterConsumptionDataSQL);
            $deleteWaterConsumptionDataSTMT->bind_param("ss", $waterConsumptionID, $userID);
            return $deleteWaterConsumptionDataSTMT->execute();
        }
        return false;
    }

    /** Returns true if there is a data in the WATER_CONSUMPTION table,
     * where waterConsumptionID attribute is $waterConsumptionID,
     * and userID attribute is $userID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist, 
     * and that the user has the permissions to manipulate the data,
     * where waterConsumptionID attribute is $waterConsumptionID in the WATER_CONSUMPTION table.
    */
    private function verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID) {
        $selectWaterConsumptionDataSQL = "SELECT 1 FROM " . $this->waterConsumptionTable . " WHERE waterConsumptionID = ? AND userID = ?";
        $selectWaterConsumptionDataSTMT= $this->databaseConn->prepare($selectWaterConsumptionDataSQL);
        $selectWaterConsumptionDataSTMT->bind_param("ss", $waterConsumptionID, $userID);
        $selectWaterConsumptionDataSTMT->execute();
        $selectWaterConsumptionDataResult = $selectWaterConsumptionDataSTMT->get_result();
        if ($selectWaterConsumptionDataResult->num_rows === 1) {
            return true;
        }
        return false;
    }
}

