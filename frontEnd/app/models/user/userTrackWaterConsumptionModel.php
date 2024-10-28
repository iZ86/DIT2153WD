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
}

