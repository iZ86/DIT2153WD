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
    
    
    /** Returns an associate array of arrays where key is bmiID attribute,
     * and every value is an associate array representing a record in the BMI table,
     * where recordedOn attribute is $recordedOn,
     * and userID attribute is $userID.
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

    /** Adds BMI data into the BMI table.
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
            return $updateBMIDataSTMT->execute();
            
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
            return $deleteBMIDataSTMT->execute();

            
        }
        return false;
    }

    /** Returns true if there is a data in the BMI table in BMI table,
     * where bmiID attribute is $bmiID,
     * and userID attribute is $userID.
     * Otherwise, returns false.
     * This function is used to verify that the data does exist, 
     * and that the user has the permissions to manipulate the data,
     * where bmiID attribute is $bmiID in the BMI table.
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

