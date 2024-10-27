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
        $waterConsumptionResultArray = array();
        for ($i = 0; $i < $waterConsumptionResult->num_rows; $i++) {
            $waterConsumptionResultArray[] = $waterConsumptionResult->fetch_assoc();
            $waterConsumptionResultArrayRecordOnAttribute = date_create($waterConsumptionResultArray[$i]['recordedOn']);
            $waterConsumptionResultArray[$i]['recordedOnTime'] = $waterConsumptionResultArrayRecordOnAttribute->format('H:i');
            $waterConsumptionResultArray[$i]['recordedOnDate'] = $waterConsumptionResultArrayRecordOnAttribute->format('Y-m-d');
        }
        return $waterConsumptionResultArray;
    }

    /** Adds water consumption record into the database.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addWaterConsumptionData($usernameID, $amountDrankInMilliliters, $dateTime) {

        $insertWaterConsumptionDataSQL = "INSERT INTO " . $this->waterConsumptionTable . "(milliliters, recordedOn, userID) VALUES (?, ?, ?)";
        $insertWaterConsumptionDataSTMT = $this->databaseConn->prepare($insertWaterConsumptionDataSQL);
        $insertWaterConsumptionDataSTMT->bind_param("sss", $amountDrankInMilliliters, $dateTime, $usernameID);
        return $insertWaterConsumptionDataSTMT->execute();

    }
}

