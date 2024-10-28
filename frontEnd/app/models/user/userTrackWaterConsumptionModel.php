<?php
class UserTrackWaterConsumptionModel {
    /** Database connection. */
    private $databaseConn;
    /** Water_consumption table */
    private $waterConsumptionTable = "WATER_CONSUMPTION";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    /** Returns an array of arrays containing water consumption data in a day.
     * Otherwise, return an empty array.
    */
    public function getWaterConsumptionDataFromDate($userID, $dateTime) {

        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($dateTime);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $waterConsumptionSQL = "SELECT * FROM " .
        $this->waterConsumptionTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $waterConsumptionSTMT = $this->databaseConn->prepare($waterConsumptionSQL);
        $waterConsumptionSTMT->bind_param("sss", $userID, $dateTime, $endDate);
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

    /** Adds water consumption record into the database.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addWaterConsumptionData($userID, $amountDrankInMilliliters, $dateTime) {

        $insertWaterConsumptionDataSQL = "INSERT INTO " . $this->waterConsumptionTable . "(milliliters, recordedOn, userID) VALUES (?, ?, ?)";
        $insertWaterConsumptionDataSTMT = $this->databaseConn->prepare($insertWaterConsumptionDataSQL);
        $insertWaterConsumptionDataSTMT->bind_param("sss", $amountDrankInMilliliters, $dateTime, $userID);
        return $insertWaterConsumptionDataSTMT->execute();

    }

    /** Updates the water consumption data in WATER_CONSUMPTION table.
     * Returns 1 if success.
     * Otherwise, returns false.
    */
    public function updateWaterConsumptionData($waterConsumptionID, $amountDrankInMilliliters, $dateTime, $userID) {
        
        
        if ($this->verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID) === 1) {
            $updateWaterConsumptionDataSQL = "UPDATE " . $this->waterConsumptionTable .
            " SET milliliters = ?, recordedOn = ? WHERE waterConsumptionID = ? AND userID = ?";

            $updateWaterConsumptionDataSTMT = $this->databaseConn->prepare($updateWaterConsumptionDataSQL);
            $updateWaterConsumptionDataSTMT->bind_param("ssss", $amountDrankInMilliliters, $dateTime, $waterConsumptionID, $userID);
            $updateWaterConsumptionDataSTMT->execute();
            if ($updateWaterConsumptionDataSTMT->errno === 0) {
                return 1;
            }
        }

        return 0;
    }

    /** Deletes the water consumption data in WATER_CONSUMPTION table.
     * return 1 if success.
     * Otherwise, returns false.
     */
    public function deleteWaterConsumptionData($waterConsumptionID, $amountDrankInMilliliters, $dateTime, $userID) {

        if ($this->verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID) === 1) {
            $deleteWaterConsumptionDataSQL = "DELETE FROM " . $this->waterConsumptionTable .
            " WHERE waterConsumptionID = ? AND userID = ?";

            $deleteWaterConsumptionDataSTMT = $this->databaseConn->prepare($deleteWaterConsumptionDataSQL);
            $deleteWaterConsumptionDataSTMT->bind_param("ss", $waterConsumptionID, $amountDrankInMilliliters);
            $deleteWaterConsumptionDataSTMT->execute();
            if ($deleteWaterConsumptionDataSTMT->errno === 0) {
                return 1;
            }
        }
        return 0;
    }

    /** Returns 1 if there is a record that belongs to the $waterConsumptionID and $userID.
     * Otherwise, returns 0.
     * This function is used to prove that the $waterConsumptionID sent by the $_POST in the controller
     * actually belongs to the userID, and allows the userID to perform write actions on it.
    */
    private function verifyWaterConsumptionDataIDToUserID($waterConsumptionID, $userID) {
        $selectWaterConsumptionDataSQL = "SELECT 1 FROM " . $this->waterConsumptionTable . " WHERE waterConsumptionID = ? AND userID = ?";
        $selectWaterConsumptionDataSTMT= $this->databaseConn->prepare($selectWaterConsumptionDataSQL);
        $selectWaterConsumptionDataSTMT->bind_param("ss", $waterConsumptionID, $userID);
        $selectWaterConsumptionDataSTMT->execute();
        $selectWaterConsumptionDataResult = $selectWaterConsumptionDataSTMT->get_result();
        if ($selectWaterConsumptionDataResult->num_rows === 1) {
            return 1;
        }
        return 0;
    }
}

