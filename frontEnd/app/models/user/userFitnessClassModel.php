<?php
//require_once __DIR__ . '/../config/db_connection.php'; // Use __DIR__ to ensure the correct path
class UserFitnessClass {
    /** Fitness Class Schedule Table */
    private $fitnessClassScheduleTable = 'fitness_class_schedule';
    private $instructorTable = 'instructor';
    /** Database connection */
    private $databaseConn;

    /** Constructor */
    public function __construct($databaseConn) {
        $this->databaseConn = $databaseConn;
    }

    /** Function of getting the fitness class information by using ID */
    public function getClassesByInstructorById(int $instructorId) {
        $sql = "SELECT * FROM " . $this->fitnessClassScheduleTable . " WHERE instructorID=?";
        $stmt = $this->databaseConn->prepare($sql);
        $stmt->bind_param("i", $instructorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /** Function of getting the instructor name by using ID */
    public function getInstructorNameById(int $instructorId): ?string {
        $sql = "SELECT firstName, lastName FROM " . $this->instructorTable . " WHERE instructorID=?";
        $stmt = $this->databaseConn->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $this->databaseConn->error);
        }

        $stmt->bind_param("i", $instructorId);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $instructor = $result->fetch_assoc();

            return $instructor['firstName'] . ' ' . $instructor['lastName'];
        }

        return null;
    }
}