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

    /** Returns an array of water consumption data from $startDateTime to $endDateTime. */
    public function getWaterConsumptionDataInDays($userID, $startDateTime, $endDateTime) {
        $waterConsumptionSQL = "SELECT * FROM " .
        $this->waterConsumptionTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $waterConsumptionSTMT = $this->databaseConn->prepare($waterConsumptionSQL);
        $waterConsumptionSTMT->bind_param("sss", $userID, $startDateTime, $endDateTime);
        $waterConsumptionSTMT->execute();
        $waterConsumptionResult = $waterConsumptionSTMT->get_result();
        $waterConsumptionResultArray = array();
        for ($i = 0; $i < $waterConsumptionResult->num_rows; $i++) {
            $waterConsumptionResultArray[] = $waterConsumptionResult->fetch_assoc();
        }
        return $waterConsumptionResultArray;
    }
}