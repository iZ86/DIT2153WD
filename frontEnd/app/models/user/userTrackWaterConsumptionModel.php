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

    /** Returns the start of the week from $dateTime. */
    public function getStartDateOfWeekFromDateTime($dateTime) {
        $nthDay = date("w", strtotime($dateTime));
        $date = date_create($dateTime);
        date_modify($date, "-" . $nthDay ." days");
        return $date->format('Y-m-d');
    }

    /** Returns an array of water consumption data in a week from $dateTime to the start of the week. 
     * E.g. if the $startDate was monday, it would return an array of data that is from monday and sunday.
     * Another e.g. if the $startDate was last saturday, it would return an array of data that is from last saturday to last sunday.
     * If no data, return empty array.
    */
    public function getWaterConsumptionDataFromWeek($userID, $dateTime) {

        $startDate = $this->getStartDateOfWeekFromDateTime($dateTime);
        $endDate = date_create($dateTime);
        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $waterConsumptionSQL = "SELECT * FROM " .
        $this->waterConsumptionTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $waterConsumptionSTMT = $this->databaseConn->prepare($waterConsumptionSQL);
        $waterConsumptionSTMT->bind_param("sss", $userID, $startDate, $endDate);
        $waterConsumptionSTMT->execute();
        $waterConsumptionResult = $waterConsumptionSTMT->get_result();
        $waterConsumptionResultArray = array();
        for ($i = 0; $i < $waterConsumptionResult->num_rows; $i++) {
            $waterConsumptionResultArray[] = $waterConsumptionResult->fetch_assoc();
        }
        return $waterConsumptionResultArray;
    }
}

