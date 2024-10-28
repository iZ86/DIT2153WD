<?php
class ClassesModel {
    /** Fitness Class Table */
    private $fitnessClassTable = 'fitness_class';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting the fitness class information by using ID */
    public function getClasses() {
        $sql = "SELECT * FROM " . $this->fitnessClassTable;
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}