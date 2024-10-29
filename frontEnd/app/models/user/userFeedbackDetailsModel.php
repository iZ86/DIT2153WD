<?php

class userFeedbackDetailsModel {
    private $databaseConn;
    private $registeredUserTable = "REGISTERED_USER";
    private $userTable = "USER";
    private $commentTable = "COMMENT";
    private $feedbackTable = "FEEDBACK";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }
}

?>