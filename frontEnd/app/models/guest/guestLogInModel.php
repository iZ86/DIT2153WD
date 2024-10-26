<?php
class GuestLogInModel {
    /** Database connection. */
    private $databaseConn;
    /** Registered_User table */
    private $registeredUserTable = "REGISTERED_USER";
    /** User table. */
    private $userTable = "USER";
    /** Admin table. */
    private $adminTable = "ADMIN";

    /** Constructor for model. */
    public function __construct($databaseConn) {
        $this->$databaseConn;
    }

    

}