<?php
class UserTrackExerciseRoutineDetailModel {
    /** Database connection. */
    private $databaseConn;
    /** EXERCISE_ROUTINE table. */
    private $exerciseRoutineTable = "EXERCISE_ROUTINE";
    /** EXERCISE table. */
    private $exerciseTable = "EXERCISE";
    /** EXERCISE_ROUTINE_DETAIL table. */
    private $exerciseRoutineDetailTable = "EXERCISE_ROUTINE_DETAIL";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    /** Returns an associate array of arrays where key is exerciseRoutineDetailID attribute,
     * and every value is an associate array representing a record in the EXERCISE_ROUTINE_DETAIL table,
     * where recordedOnDate attribute is $recordedOnDate,
     * and userID attribute is $userID.
     * Otherwise, return an empty array.
    */
    public function getExerciseRoutineDetailDatasetFromDate($recordedOnDate, $userID) {
        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($recordedOnDate);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $exerciseRoutineDetailDatasetSQL = "SELECT erd.exerciseRoutineDetailID, e.exerciseName, erd.weightInGram, erd.rep, erd.note, erd.recordedOnTime, e.exerciseID FROM " .
        $this->exerciseRoutineDetailTable . " erd, " . $this->exerciseTable . " e, " . $this->exerciseRoutineTable .
        " er WHERE erd.exerciseID = e.exerciseID AND erd.exerciseRoutineID = er.exerciseRoutineID AND
        er.recordedOnDate BETWEEN ? AND ? AND er.userID = ?
        ORDER BY erd.recordedonTime DESC;";
        
        $exerciseRoutineDetailDatasetSTMT = $this->databaseConn->prepare($exerciseRoutineDetailDatasetSQL);
        $exerciseRoutineDetailDatasetSTMT->bind_param("sss", $recordedOnDate, $endDate, $userID);
        $exerciseRoutineDetailDatasetSTMT->execute();
        $exerciseRoutineDetailDatasetResult = $exerciseRoutineDetailDatasetSTMT->get_result();
        $exerciseRoutineDetailDataset = array();
        for ($i = 0; $i < $exerciseRoutineDetailDatasetResult->num_rows; $i++) {
            $exerciseRoutineDetailDataResult = $exerciseRoutineDetailDatasetResult->fetch_assoc();
            $recordedOnTime = date_create($exerciseRoutineDetailDataResult["recordedOnTime"]);
            $exerciseRoutineDetailDataResult["recordedOnTime"] = $recordedOnTime->format("H:i");
            $exerciseRoutineDetailDataset[$exerciseRoutineDetailDataResult['exerciseRoutineDetailID']] = $exerciseRoutineDetailDataResult;
        }
        return $exerciseRoutineDetailDataset;
    }

    /** Returns an associate array of associate arrays where key is exerciseID,
     * and each value is an assoc array representing a record in the EXERCISE table,
     * and each userID attribute in the record is $userID,
     * Otherwise, return an empty array.
    */
    public function getExerciseDatasetFromUserID($userID) {

        $exerciseDatasetSQL = "SELECT * FROM " . $this->exerciseTable . " WHERE userID = ?";
        
        $exerciseDatasetSTMT = $this->databaseConn->prepare($exerciseDatasetSQL);
        $exerciseDatasetSTMT->bind_param("s", $userID);
        $exerciseDatasetSTMT->execute();
        $exerciseDatasetResult = $exerciseDatasetSTMT->get_result();
        $exerciseDataset = array();
        for ($i = 0; $i < $exerciseDatasetResult->num_rows; $i++) {
            $exerciseDataResult = $exerciseDatasetResult->fetch_assoc();
            $exerciseDataset[$exerciseDataResult['exerciseID']] = $exerciseDataResult;
        }
        return $exerciseDataset;
    }

    /** Returns one associate array of exerciseRoutine data from EXERCISE_ROUTINE table,
     * where recordedOnDate attribute is $recordedOnDate and userID attribute is $userID.
     * Otherwise, return an empty array, but this shouldnt happen due to incorrect $recordedOnDate and $userID.
     */
    public function getExerciseRoutineDataFromDate($recordedOnDate, $userID) {
        
        $selectExerciseRoutineDataSQL = "SELECT * FROM " . $this->exerciseRoutineTable . " WHERE recordedOnDate = ? AND userID = ?";

        $selectExerciseRoutineDataSTMT = $this->databaseConn->prepare($selectExerciseRoutineDataSQL);
        $selectExerciseRoutineDataSTMT->bind_param("ss", $recordedOnDate, $userID);
        $selectExerciseRoutineDataSTMT->execute();
        $selectExerciseRoutineDataResult = $selectExerciseRoutineDataSTMT->get_result();
        if ($selectExerciseRoutineDataResult->num_rows > 0) {
            return $selectExerciseRoutineDataResult->fetch_assoc();
        }
        return array();
    }

    /** Adds exercise routine data into the EXERCISE table.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addExerciseRoutineData($recordedOnDate, $userID) {
        if ($this->verifyExerciseRoutineDataExist($recordedOnDate, $userID)) {
            return true;
        }
        
        $insertExerciseRoutineDataSQL = "INSERT INTO " . $this->exerciseRoutineTable . " (recordedOnDate, userID) VALUES (?, ?)";
        $insertExerciseRoutineDataSTMT = $this->databaseConn->prepare($insertExerciseRoutineDataSQL);
        $insertExerciseRoutineDataSTMT->bind_param("ss", $recordedOnDate, $userID);
        return $insertExerciseRoutineDataSTMT->execute();
        
    }

    /** Adds exercise data into the EXERCISE table.
     * Returns true, if successful.
     * Otherwise, returns fasle.
     */
    public function addExerciseData($exerciseName, $userID) {
        $insertExerciseDataSQL = "INSERT INTO " . $this->exerciseTable . " (exerciseName, userID) VALUES (?, ?)";
        $insertExercseDataSTMT = $this->databaseConn->prepare($insertExerciseDataSQL);
        $insertExercseDataSTMT->bind_param("ss", $exerciseName, $userID);
        return $insertExercseDataSTMT->execute();
    }

    /** Adds exercise routine detail data into EXERCISE_ROUTINE_DETAIL table.
     * Returns true, if successful.
     * Otherwise, returns false.
     */
    public function addExerciseRoutineDetailData($weightInGram, $rep, $note, $recordedOnTime, $exerciseID, $exerciseRoutineID, $userID) {
        
        if (($this->verifyExerciseIDToUserID($exerciseID, $userID)) && ($this->verifyExerciseRoutineIDToUserID($exerciseRoutineID, $userID))) {
            $insertExerciseRoutineDetailDataSQL = "INSERT INTO " . $this->exerciseRoutineDetailTable .
            " (weightInGram, rep, note, recordedOnTime, exerciseID, exerciseRoutineID) VALUES (?, ?, ?, ?, ?, ?)";
            
            
            $insertExerciseRoutineDetailDataSTMT = $this->databaseConn->prepare($insertExerciseRoutineDetailDataSQL);
            $insertExerciseRoutineDetailDataSTMT->bind_param("ssssss", $weightInGram, $rep, $note, $recordedOnTime, $exerciseID, $exerciseRoutineID);
            return $insertExerciseRoutineDetailDataSTMT->execute();
        }
    }

    /** Updates exercise data in the EXERCISE table.
     * Returns true, if success.
     * Otherewise, returns false
     */
    public function updateExerciseData($exerciseID, $exerciseName, $userID) {
        if (($this->verifyExerciseIDToUserID($exerciseID, $userID))) {
            $updateExerciseDataSQL = "UPDATE " . $this->exerciseTable . " SET exerciseName = ? WHERE exerciseID = ? AND userID = ?";

            $updateExerciseDataSTMT = $this->databaseConn->prepare($updateExerciseDataSQL);
            $updateExerciseDataSTMT->bind_param("sss", $exerciseName, $exerciseID, $userID);
            return $updateExerciseDataSTMT->execute();
        }
        return false;
    }

    /** Update exercise routine detail data in the EXERCISE_ROUTINE_DETAIL table.
     * Returns true, if success.
     * Otherwise, returns false.
     */
    public function updateExerciseRoutineDetailData($exerciseRoutineDetailID, $weightInGram, $rep, $note, $recordedOnTime, $exerciseID, $exerciseRoutineID, $userID) {
        
        if (($this->verifyExerciseIDToUserID($exerciseID, $userID)) && ($this->verifyExerciseRoutineIDToUserID($exerciseRoutineID, $userID)) &&
        $this->verifyExerciseRoutineDetailIDToExerciseRoutineID($exerciseRoutineDetailID, $exerciseRoutineID)) {
            
            $updateExerciseRoutineDetailDataSQL = "UPDATE " . $this->exerciseRoutineDetailTable .
            " SET weightInGram = ?, rep = ?, note = ?, recordedOnTime = ?, exerciseID = ?, exerciseRoutineID = ? WHERE exerciseRoutineDetailID = ?";
            
            $updateExerciseRoutineDataSTMT = $this->databaseConn->prepare($updateExerciseRoutineDetailDataSQL);
            $updateExerciseRoutineDataSTMT->bind_param("sssssss", $weightInGram, $rep, $note, $recordedOnTime, $exerciseID, $exerciseRoutineID, $exerciseRoutineDetailID);
            return $updateExerciseRoutineDataSTMT->execute();
        }
        return false;
    }

    /** Deletes exercise data in the EXERCISE table.
     * Returns true, if success.
     * Otherwise, returns false.
     */
    public function deleteExerciseData($exerciseID, $userID) {
        if ($this->verifyExerciseIDToUserID($exerciseID, $userID)) {
            if ($this->deleteExerciseRoutineDetailDataToExerciseID($exerciseID, $userID)) {
                $deleteExerciseDataSQL = "DELETE FROM " . $this->exerciseTable .
                " WHERE exerciseID = ? AND userID = ?";
    
                $deleteExerciseDataSTMT = $this->databaseConn->prepare($deleteExerciseDataSQL);
                $deleteExerciseDataSTMT->bind_param("ss", $exerciseID, $userID);
                return $deleteExerciseDataSTMT->execute();
            }
        }
        return false;
    }

    /** Deletes all the exercise routine detail data in the EXERCISE_ROUTINE_DETAIL table.
     * Where exerciseID attribute is $exerciseID.
     * This is called when the user wishes to delete an exercise, all exercise routine detail data shall be deleted with it,
     * and it is called by deleteExerciseData($exerciseID, $userID) function.
     * NOTE: There wil be no checks, as this will be called after the checks in the deleteExerciseData($exerciseID, $userID) function.
     * Returns true, if success.
     * Otherwise, returns false.
     */
    public function deleteExerciseRoutineDetailDataToExerciseID($exerciseID) {
        $deleteExerciseRoutineDetailDataSQl = "DELETE FROM " . $this->exerciseRoutineDetailTable . " WHERE exerciseID = ?";
        $deleteExerciseRoutineDetailDataSTMT = $this->databaseConn->prepare($deleteExerciseRoutineDetailDataSQl);
        $deleteExerciseRoutineDetailDataSTMT->bind_param("s", $exerciseID);
        return $deleteExerciseRoutineDetailDataSTMT->execute();
    }

    /** Delete exercise routine detail data in the EXERCISE_ROUTINE_DETAIL table.
     * Returns true, if success.
     * Otherwise, returns false.
     */
    public function deleteExerciseRoutineDetailData($exerciseRoutineDetailID, $exerciseID, $exerciseRoutineID, $userID) {
        if (($this->verifyExerciseIDToUserID($exerciseID, $userID)) && ($this->verifyExerciseRoutineIDToUserID($exerciseRoutineID, $userID)) &&
        $this->verifyExerciseRoutineDetailIDToExerciseRoutineID($exerciseRoutineDetailID, $exerciseRoutineID)) {
            
            $deleteExerciseRoutineDetailDataSQL = "DELETE FROM " . $this->exerciseRoutineDetailTable .
            " WHERE exerciseRoutineDetailID = ?";

            $deleteExerciseRoutineDetailDataSTMT = $this->databaseConn->prepare($deleteExerciseRoutineDetailDataSQL);
            $deleteExerciseRoutineDetailDataSTMT->bind_param("s", $exerciseRoutineDetailID);
            return $deleteExerciseRoutineDetailDataSTMT->execute();
        }
        return false;
    }

    /** Returns true if there is data in the EXERCISE_ROUTINE_DETAIL table,
     * where exerciseRoutineDetailID attribute is $exerciseRoutineDetailID,
     * and exerciseRoutineID attribute is $exerciseRoutineID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist, 
     * and the user has the permissions to manipulate the data,
     * where the exerciseRoutineDetailID attribute is $exerciseRoutineDetailID,
     * through the exerciseRoutineID attribute in the EXERCISE_ROUTINE_DETAIL table.
     */
    private function verifyExerciseRoutineDetailIDToExerciseRoutineID($exerciseRoutineDetailID, $exerciseRoutineID) {
        $selectExerciseRoutineDetailSQL = "SELECT * FROM " . $this->exerciseRoutineDetailTable . " WHERE exerciseRoutineID = ? AND exerciseRoutineDetailID = ?";
        $selectExerciseRoutineDetailSTMT = $this->databaseConn->prepare($selectExerciseRoutineDetailSQL);
        $selectExerciseRoutineDetailSTMT->bind_param("ss", $exerciseRoutineID, $exerciseRoutineDetailID);
        $selectExerciseRoutineDetailSTMT->execute();
        $selectExerciseRoutineDataResult = $selectExerciseRoutineDetailSTMT->get_result();
        if ($selectExerciseRoutineDataResult->num_rows >= 1) {
            return true;
        }
        return false;
    }

    /** Returns true if there is data in the EXERCISE table,
     * where exerciseID attribute is $exerciseID,
     * and userID attribute is $userID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist, 
     * and the user has the permissions to manipulate the data,
     * where exerciseID attribute is $exerciseID in the EXERCISE table.
     */
    public function verifyExerciseIDToUserID($exerciseID, $userID) {
        $selectExercseDataSQL = "SELECT * FROM " . $this->exerciseTable . " WHERE exerciseID = ? AND userID = ?";
        $selectExerciseDataSTMT = $this->databaseConn->prepare($selectExercseDataSQL);
        $selectExerciseDataSTMT->bind_param("ss", $exerciseID, $userID);
        $selectExerciseDataSTMT->execute();
        $selectExerciseDataResult = $selectExerciseDataSTMT->get_result();
        
        if ($selectExerciseDataResult->num_rows >= 1) {
            
            return true;
        }
        return false;
    }

    /** Returns true if there is data in the EXERCISE_ROUTINE table,
     * where exerciseRoutineID attribute is $exerciseRoutineID,
     * AND userID attribute is $userID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist,
     * and that the user has the permissions to manipulate the data,
     * where exerciseRoutineID attribute is $exerciseRoutineID in the EXERCISE_ROUTINE table.
     */
    private function verifyExerciseRoutineIDToUserID($exerciseRoutineID, $userID) {
        $selectExercseRoutineDataSQL = "SELECT * FROM " . $this->exerciseRoutineTable . " WHERE exerciseRoutineID = ? AND userID = ?";
        $selectExercseRoutineDataSTMT = $this->databaseConn->prepare($selectExercseRoutineDataSQL);
        $selectExercseRoutineDataSTMT->bind_param("ss", $exerciseRoutineID, $userID);
        $selectExercseRoutineDataSTMT->execute();
        $selectExercseRoutineDataResult = $selectExercseRoutineDataSTMT->get_result();
       
        if ($selectExercseRoutineDataResult->num_rows >= 1) {
            
            return true;
        }
        return false;
    }

    /** Returns true if there is a data in the EXERCISE_ROUTINE table,
     * where date attribute is $recordedOnDate,
     * and userID attribute is $userID.
     * Otherwise, returns false.
     * Data in the EXERCISE_ROUTINE is ONE date per data, and since the data in EXERCISE_ROUTINE_DETAIL is being track by date,
     * and contains a exerciseRoutineID from the EXERCISE_ROUTINE table.
     * It is needed to add data of the date to the EXERCISE_ROUTINE table before adding data into the EXERCISE_ROUTINE_DETAIL table
     * If user wants to add a new EXERCISE_ROUTINE_DETAIL on the same date twice.
     * It is needed to check if there is already an exisitng data in the EXERCISE_ROUTINE table, and if it exist, no need to add it again.
     */
    private function verifyExerciseRoutineDataExist($recordedOnDate, $userID) {
        $selectExercseRoutineDataSQL = "SELECT * FROM " . $this->exerciseRoutineTable . " WHERE recordedOnDate = ? AND userID = ?";
        $selectExercseRoutineDataSTMT = $this->databaseConn->prepare($selectExercseRoutineDataSQL);
        $selectExercseRoutineDataSTMT->bind_param("ss", $recordedOnDate, $userID);
        $selectExercseRoutineDataSTMT->execute();
        $selectExercseRoutineDataResult = $selectExercseRoutineDataSTMT->get_result();
        if ($selectExercseRoutineDataResult->num_rows >= 1) {
            return true;
        }
        return false;
    }
}

