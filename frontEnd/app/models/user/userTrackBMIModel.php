<?php
class UserTrackBMIModel {
    /** Database connection. */
    private $databaseConn;
    /** BMI table. */
    private $bmiTable = "BMI";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
    
    /** Returns an array of arrays containing BMI data in a day.
     * Selecting from the BMI table.
     * Otherwise, return an empty array.
    */
    public function getBMIDataFromDate($userID, $recordedOn) {

        // To be used in SQL BETWEEN statement, BETWEEN does not include the end date
        // So increment by one.
        $endDate = date_create($recordedOn);
        date_modify($endDate, "+1 days");
        $endDate = $endDate->format('Y-m-d');

        $selectBMIDataSQL = "SELECT * FROM " .
        $this->bmiTable .
        " WHERE userID = ? AND recordedOn BETWEEN ? AND ? ORDER BY recordedOn DESC";
        
        $selectBMIDataSTMT = $this->databaseConn->prepare($selectBMIDataSQL);
        $selectBMIDataSTMT->bind_param("sss", $userID, $recordedOn, $endDate);
        $selectBMIDataSTMT->execute();
        $selectBMIDataResult = $selectBMIDataSTMT->get_result();
        $selectBMIDataResultDataArray = array();
        for ($i = 0; $i < $selectBMIDataResult->num_rows; $i++) {
            $selectBMIDataResultData = $selectBMIDataResult->fetch_assoc();
            $selectBMIDataResultDataRecordOnAttribute = date_create($selectBMIDataResultData['recordedOn']);
            $selectBMIDataResultData['recordedOnTime'] = $selectBMIDataResultDataRecordOnAttribute->format('H:i');
            $selectBMIDataResultData['recordedOnDate'] = $selectBMIDataResultDataRecordOnAttribute->format('Y-m-d');
            unset($selectBMIDataResultData['recordedOn']);
            $selectBMIDataResultDataArray[$selectBMIDataResultData['bmiID']] = $selectBMIDataResultData;
        }
        return $selectBMIDataResultDataArray;
    }

    /** Adds BMI record into the BMI table.
     * Returns true, if succeesful.
     * Otherwise, returns false.
     */
    public function addBMIData($age, $gender, $height, $weight, $recordedOn, $userID) {

        $insertBMIDataSQL = "INSERT INTO " . $this->bmiTable . "(age, gender, height, weight, recordedOn, userID) VALUES (?, ?, ?, ?, ?, ?)";
        $insertBMIDataSTMT = $this->databaseConn->prepare($insertBMIDataSQL);
        $insertBMIDataSTMT->bind_param("ssssss", $age, $gender, $height, $weight, $recordedOn, $userID);
        return $insertBMIDataSTMT->execute();

    }

    /** Updates the BMI data in BMI table.
     * Returns true if success.
     * Otherwise, returns false.
    */
    public function updateBMIData($bmiID, $age, $gender, $height, $weight, $recordedOn, $userID) {
        
        
        if ($this->verifyBMIDataIDToUserID($bmiID, $userID)) {
            $updateBMIDataSQL = "UPDATE " . $this->bmiTable .
            " SET age = ?, gender = ?, height = ?, weight = ?, recordedOn = ? WHERE bmiID = ? AND userID = ?";

            $updateBMIDataSTMT = $this->databaseConn->prepare($updateBMIDataSQL);
            $updateBMIDataSTMT->bind_param("sssssss", $age, $gender, $height, $weight, $recordedOn, $bmiID, $userID);
            $updateBMIDataSTMT->execute();
            
            // Checks if there was any error running the sql statemnt, error number 0 is no errors.
            if ($updateBMIDataSTMT->errno === 0) {
                return true;
            }
        }

        return false;
    }

    /** Deletes the BMI data in BMI table.
     * return true if success.
     * Otherwise, returns false.
     */
    public function deleteBMIData($bmiID, $userID) {

        if ($this->verifyBMIDataIDToUserID($bmiID, $userID)) {
            
            
            $deleteBMIDataSQL = "DELETE FROM " . $this->bmiTable .
            " WHERE bmiID = ? AND userID = ?";

            $deleteBMIDataSTMT = $this->databaseConn->prepare($deleteBMIDataSQL);
            $deleteBMIDataSTMT->bind_param("ss", $bmiID, $userID);
            $deleteBMIDataSTMT->execute();

            // Checks if there was any error running the sql statemnt, error number 0 is no errors.
            if ($deleteBMIDataSTMT->errno === 0) {
                return true;
            }
        }
        return false;
    }

    /** Returns true if there is a record in the BMI table with the id $bmiID that is linked to $userID.
     * Otherwise, returns false.
     * This function is used to prove that the $bmiID sent by the $_POST in the controller
     * actually belongs to the userID, and allows the userID to perform write actions on it.
    */
    private function verifyBMIDataIDToUserID($bmiID, $userID) {
        $selectBMIDataSQL = "SELECT 1 FROM " . $this->bmiTable . " WHERE bmiID = ? AND userID = ?";
        $selectBMIDataSTMT= $this->databaseConn->prepare($selectBMIDataSQL);
        $selectBMIDataSTMT->bind_param("ss", $bmiID, $userID);
        $selectBMIDataSTMT->execute();
        $selecBMIDataResult = $selectBMIDataSTMT->get_result();
        if ($selecBMIDataResult->num_rows === 1) {
            return true;
        }
        return false;
    }
}

