<?php
class userFeedbackModel {
    private $databaseConn;
    private $registeredUserTable = "REGISTERED_USER";
    private $userTable = "USER";
    private $feedbackTable = "FEEDBACK";
    private $commentTable = "COMMENT";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getAllFeedbacks() {
        $query = "SELECT status, feedbackID, topic, createdOn FROM " . $this->feedbackTable;
        $stmt = $this->databaseConn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>