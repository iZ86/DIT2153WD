<?php
class UserPaymentModel {
    /** PAYMENT Table. */
    private $paymentTable = 'PAYMENT';
    /** NUTRITIONIST_BOOKING Table. */
    private $nutritionistBookingTable = 'NUTRITIONIST_BOOKING';
    /** NUTRTIONIST_SCHEDULE Table */
    private $nutritionistScheduleTable ='NUTRITIONIST_SCHEDULE';
    /** NUTRTITIONIST Table. */
    private $nutritionistTable = 'NUTRITIONIST';
    /** FITNESS_CLASS Table. */
    private $fitnessClassTable = 'FITNESS_CLASS';
    /** FITNESS_CLASS_SUBSCRIPTION Table. */
    private $fitnessClassSubscriptionTable = 'FITNESS_CLASS_SUBSCRIPTION';
    /** MEMBERSHIP Table. */
    private $membershipTable = 'MEMBERSHIP';
    /** MEMBERSHIP_SUBSCRIPTION Table. */
    private $membershipSubscriptionTable = 'MEMBERSHIP_SUBSCRIPTION';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Returns an associate array where the array is data in the MEMBERSHIP Table,
     * where the membershipID attribute is $membershipID.
     * Otherwise, returns empty array, if no data.
     */
    public function getMembershipData($membershipID) {
        $selectMembershipDataSQL = "SELECT * FROM " . $this->membershipTable . " WHERE membershipID = ?";

        $selectMembershipDataSTMT = $this->databaseConn->prepare($selectMembershipDataSQL);
        $selectMembershipDataSTMT->bind_param("s", $membershipID);
        $selectMembershipDataSTMT->execute();
        $selectMembershipDataResult = $selectMembershipDataSTMT->get_result();
        if ($selectMembershipDataResult->num_rows > 0) {
            return $selectMembershipDataResult->fetch_assoc();
        }
        return array();
    }

    /** Returns an associate array where the array is data in the FITNESS_CLASS Table,
     * where the name attribute is $fitnessClassName.
     * Otherwise, returns empty array, if no data.
     */
    public function getFitnessClassDataFromName($fitnessClassName) {
        $selectFitnessClassDataFromNameSQL = "SELECT * FROM " . $this->fitnessClassTable . " WHERE name = ?";

        $selectFitnessClassDataFromNameSTMT = $this->databaseConn->prepare($selectFitnessClassDataFromNameSQL);
        $selectFitnessClassDataFromNameSTMT->bind_param("s", $fitnessClassName);
        $selectFitnessClassDataFromNameSTMT->execute();
        $selectFitnessClassDataFromNameResult = $selectFitnessClassDataFromNameSTMT->get_result();
        if ($selectFitnessClassDataFromNameResult->num_rows > 0) {
            return $selectFitnessClassDataFromNameResult->fetch_assoc();
        }
        return array();
    }


    /** Returns true if the membership data does exist in the MEMBERSHIP table.
     * Where membershipID attribute is $membershipID.
     * Otherwise return false.
     */
    public function isMembershipDataExist($membershipID) {
        $membershipData = $this->getMembershipData($membershipID);
        if (sizeof($membershipData) > 0) {
            return true;
        }
        return false;
    }

    /** Creates a new payment data in the PAYMENT table where all the attributes are the function's parameters,
     * and returns the paymentID.
     * If fail, returns 0.
     */
    public function createPaymentAndReturnID($type, $status, $createdOn, $userID) {
        $createPaymentSQL = "INSERT INTO " . $this->paymentTable . " (type,status,createdOn,userID) VALUES (?, ?, ?, ?)";

        $createPaymentSTMT = $this->databaseConn->prepare($createPaymentSQL);

        $createPaymentSTMT->bind_param("ssss", $type, $status, $createdOn, $userID);

        $createPaymentSTMT->execute();

        return $createPaymentSTMT->insert_id;
    }

    /** Creates a new membership subscription data in the MEMBERSHIP_SUBSCRIPTION table,
     * where all the attributes are the function's parameters,
     * and returns the membershipSubscriptionID.
     * If fail, returns 0.
     */
    public function createMembershipSubscriptionDataAndReturnID($startOn, $endOn, $paymentID, $membershipID) {
        $createMembershipSubscriptionDataSQL = "INSERT INTO " . $this->membershipSubscriptionTable . " (startOn, endOn, paymentID, membershipID) VALUES (?, ?, ?, ?)";

        $createMembershipSubscriptionDataSTMT = $this->databaseConn->prepare($createMembershipSubscriptionDataSQL);

        $createMembershipSubscriptionDataSTMT->bind_param("ssss", $startOn, $endOn, $paymentID, $membershipID);

        $createMembershipSubscriptionDataSTMT->execute();

        return $createMembershipSubscriptionDataSTMT->insert_id;
    }

    /** Creates a new fitness class subscription data in the FITNESS_CLASS_SUBSCRIPTION table,
     * where all the attributes are the function's parameters,
     * and returns the fitnessClassSubscriptionID.
     * If fail, returns 0.
     */
    public function createFitnessClassSubscriptionDataAndReturnID($startOn, $endOn, $paymentID, $fitnessClassID) {
        $createFitnessClassSubscriptionDataSQL = "INSERT INTO " . $this->fitnessClassSubscriptionTable . " (startOn, endOn, paymentID, fitnessClassID) VALUES (?, ?, ?, ?)";

        $createFitnessClassSubscriptionDataSTMT = $this->databaseConn->prepare($createFitnessClassSubscriptionDataSQL);

        $createFitnessClassSubscriptionDataSTMT->bind_param("ssss", $startOn, $endOn, $paymentID, $membershipID);

        $createFitnessClassSubscriptionDataSTMT->execute();

        return $createFitnessClassSubscriptionDataSTMT->insert_id;
    }

    /** Creates a new nutritionist booking data in the NUTRITIONIST_BOOKING table,
     * where all the attributes are the function's parameters,
     * and returns the nutritionistBookingID.
     * If fail, returns 0.
     */
    public function createNutritionistBookingDataAndReturnID($nutritionistScheduleID, $userID, $paymentID) {
        $createNutritionistBookingDataSQL = "INSERT INTO " . $this->nutritionistBookingTable . " (nutritionistScheduleID, userID, paymentID) VALUES (?, ?, ?)";

        $createNutritionistBookingDataSTMT = $this->databaseConn->prepare($createNutritionistBookingDataSQL);

        $createNutritionistBookingDataSTMT->bind_param("sss", $nutritionistScheduleID, $userID, $paymentID);

        $createNutritionistBookingDataSTMT->execute();

        return $createNutritionistBookingDataSTMT->insert_id;
    }

    
    
    /** Returns an associate array where the array is data in the NUTRITIONIST_SCHEDULE Table,
     * where the name attribute is $nutritionistScheduleID.
     * Otherwise, returns empty array, if no data.
     */
    public function getNutritionistScheduleData($nutritionistScheduleID) {
        $selectNutritionistScheduleDataSQL = "SELECT * FROM " . $this->nutritionistScheduleTable . " WHERE nutritionistScheduleID = ?";

        $selectNutritionistScheduleDataSTMT = $this->databaseConn->prepare($selectNutritionistScheduleDataSQL);
        $selectNutritionistScheduleDataSTMT->bind_param("s", $nutritionistScheduleID);
        $selectNutritionistScheduleDataSTMT->execute();
        $selectNutritionistScheduleDataResult = $selectNutritionistScheduleDataSTMT->get_result();
        if ($selectNutritionistScheduleDataResult->num_rows > 0) {
            return $selectNutritionistScheduleDataResult->fetch_assoc();
        }
        return array();
    }

    /** Returns an associate array where the array is data in the NUTRITIONIST Table,
     * where the name attribute is $nutritionistID.
     * Otherwise, returns empty array, if no data.
     */
    public function getNutritionistData($nutritionistID) {
        $selectNutritionistDataSQL = "SELECT * FROM " . $this->nutritionistTable . " WHERE nutritionistID = ?";

        $selectNutritionistDataSTMT = $this->databaseConn->prepare($selectNutritionistDataSQL);
        $selectNutritionistDataSTMT->bind_param("s", $nutritionistID);
        $selectNutritionistDataSTMT->execute();
        $selectNutritionistDataResult = $selectNutritionistDataSTMT->get_result();
        if ($selectNutritionistDataResult->num_rows > 0) {
            return $selectNutritionistDataResult->fetch_assoc();
        }
        return array();
    }

    /** Returns an associate array that represents the membership subscription data.
     * The data returned by this function is used to allow users..
     */
    public function getMembershipSubscriptionData($membershipID, $fitnessClassNames) {
        $memberSubscriptionData = array();
        $totalPrice = 0;
        $fitnessClassDataset = array();

        $membershipData = $this->getMembershipData($membershipID);

        if (sizeof($membershipData) > 0) {
            
            $memberSubscriptionData["membershipData"] = $membershipData;
            $totalPrice += $membershipData["price"];
            
            for ($i = 0; $i < sizeof($fitnessClassNames); $i++) {
                $fitnessClassData = $this->getFitnessClassDataFromName($fitnessClassNames[$i]);

                if (sizeof($fitnessClassData) > 0) {
                    $totalPrice += $fitnessClassData["price"];
                    $fitnessClassDataset[] = $fitnessClassData;
                } else {
                    return array();
                }
            }

            $memberSubscriptionData["fitnessClassDataset"] = $fitnessClassDataset;
            $memberSubscriptionData["totalPrice"] = $totalPrice;
        }
        return $memberSubscriptionData;

    }

    /** Returns data */
    public function getNutritionistSchedulePurchaseData($nutritionistScheduleID) {
        $nutritionistSchedulePurchaseData = array();

        $nutritionistScheduleData = $this->getNutritionistScheduleData($nutritionistScheduleID);
        
        if (sizeof($nutritionistScheduleData) > 0) {
            $nutritionistData = $this->getNutritionistData($nutritionistScheduleData['nutritionistID']);
            
            if (sizeof($nutritionistData) > 0) {
                
                $nutritionistSchedulePurchaseData['nutritionistScheduleData'] = $nutritionistScheduleData;
                $nutritionistSchedulePurchaseData['nutritionistData'] = $nutritionistData;
                return $nutritionistSchedulePurchaseData;
            } else {
                return array();
            }
        }
        return array();
    }

    public function userMakeMembershipSubscriptionPurchase($membershipID, $fitnessClassNames, $userID, $type) {
        

        $membershipSubscriptionData = $this->getMembershipSubscriptionData($membershipID, $fitnessClassNames);
        
        if (sizeof($membershipSubscriptionData) > 0) {
            $currentDateTime = date('Y-m-d H:i:s');
            
        
            $paymentID = $this->createPaymentAndReturnID($type, "confirmed", $currentDateTime, $userID);

            if ($paymentID !== 0) {

                $subscriptionEndOnDate = date_create($currentDateTime);
                date_modify($subscriptionEndOnDate, "+30 days");
                $subscriptionEndOnDate = $subscriptionEndOnDate->format('Y-m-d H:i:s');
                        
                $membershipSubscriptionID = $this->createMembershipSubscriptionDataAndReturnID($currentDateTime, $subscriptionEndOnDate, $paymentID, $membershipID);
            
                if ($membershipSubscriptionID !== 0) {
                    $fitnessClassBeingPurchasedDataset = $membershipSubscriptionData['fitnessClassDataset'];

                    for ($i = 0; $i < sizeof($fitnessClassBeingPurchasedDataset); $i++) {

                        $fitnessClassSubscriptionID = $this->createFitnessClassSubscriptionDataAndReturnID($currentDateTime, $subscriptionEndOnDate, $fitnessClassBeingPurchasedDataset[$i]['fitnessClassID'], $paymentID);
            
                        if ($fitnessClassSubscriptionID === 0) {
                            return false;
                        }
                    }
                    return true;
                }
            }

        }
        return false;
    }

    public function userMakeNutritionistSchedulePurchase($nutritionistScheduleID, $userID, $type) {
        
        echo $nutritionistScheduleID;
        $nutritionistSchedulePurchaseData = $this->getNutritionistSchedulePurchaseData($nutritionistScheduleID);
        if (sizeof($nutritionistSchedulePurchaseData) > 0) {
            
            
            $currentDateTime = date('Y-m-d H:i:s');
            
        
            $paymentID = $this->createPaymentAndReturnID($type, "confirmed", $currentDateTime, $userID);

            if ($paymentID !== 0) {
                $nutritionistBookingID = $this->createNutritionistBookingDataAndReturnID($nutritionistScheduleID, $userID, $paymentID);

                if ($nutritionistBookingID !== 0) {
                    return true;
                }
                
            }

        }
        return false;
    }




    /** Function of creating a booking for user's reservation */
    public function createNutritionistBooking($description, $nutritionistScheduleID, $userID, $paymentID) {
        $sql = "INSERT INTO " . $this->nutritionistBookingTable . " (description,nutritionistScheduleID,userID,paymentID) VALUES (?,?,?,?)";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("siii", $description, $nutritionistScheduleID, $userID, $paymentID);
        return $stmt->execute();
    }

    public function isScheduleIDBooked($nutritionistScheduleID) {
        $sql = "SELECT COUNT(*) as count FROM " . $this->nutritionistBookingTable . " WHERE nutritionistScheduleID = ?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $nutritionistScheduleID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0; // Returns true if the schedule ID is already booked
    }

}