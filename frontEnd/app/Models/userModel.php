<?php
class UserModel {
    // Database connection
    private $databaseConn;
    // registered_user table name
    private $table = "registered_user";
    // user table name
    private $table = "user";

    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    public function getById(int $id) {
        $sql = "SELECT * FROM REGISTERED_USER WHERE registereduserid=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        return false;
        
    }
}