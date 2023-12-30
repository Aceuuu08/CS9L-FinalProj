<?php
include_once("db_conn.php"); 

class Profile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function view($userID) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT 
            employees.idemployees AS 'Employee ID', 
            CONCAT(employees.first_name, ' ', employees.middle_name, ' ', employees.last_name) AS 'Employee Name', employees.sex AS 'Sex', employees.email AS 'Email Address', employees.contactno AS 'Phone Number',
            CONCAT(employees.perm_spec_address, ' ', 
                   employees.perm_street_address, ' ', employees.perm_vill_address, ' ', 
                   employees.perm_barangay_address, ' ', employees.perm_city) AS 'Address'
        FROM employees
        INNER JOIN users ON employees.idemployees = users.employee_id
        WHERE users.id = :userID";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(":userID", $userID);
        
        $stmt->execute();
            // Fetch the student data as an associative array
            $convoData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $convoData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($userID, $fname, $mname, $lname, $sex, $emailAddress, $phoneNumber, $permSpecAddress, $permStreetAddress, $permVillAddress, $permBarangayAddress, $permCity)
{
    try {
        $connection = $this->db->getConnection();

        $sql = "UPDATE employees 
                INNER JOIN users ON employees.idemployees = users.employee_id
                SET 
                employees.first_name = :fname,
                employees.middle_name = :mname,
                employees.last_name = :lname,
                employees.sex = :sex,
                employees.email = :emailAddress,
                employees.contactno = :phoneNumber,
                employees.perm_spec_address = :permSpecAddress, 
                employees.perm_street_address = :permStreetAddress,
                employees.perm_vill_address = :permVillAddress,
                employees.perm_barangay_address = :permBarangayAddress,
                employees.perm_city = :permCity
                WHERE users.id = :userID";

        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":fname", $fname);
        $stmt->bindParam(":mname", $mname);
        $stmt->bindParam(":lname", $lname);
        $stmt->bindParam(":sex", $sex);
        $stmt->bindParam(":emailAddress", $emailAddress);
        $stmt->bindParam(":phoneNumber", $phoneNumber);
        $stmt->bindParam(":permSpecAddress", $permSpecAddress);
        $stmt->bindParam(":permStreetAddress", $permStreetAddress);
        $stmt->bindParam(":permVillAddress", $permVillAddress);
        $stmt->bindParam(":permBarangayAddress", $permBarangayAddress);
        $stmt->bindParam(":permCity", $permCity);
        $stmt->bindParam(":userID", $userID);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

    public function create_request($employeeId, $employeeName, $leaveType, $startDate, $endDate){
        try {
            $connection = $this->db->getConnection();
    
            $sql = "INSERT INTO request_for_leave (employee_id, employee_name, leave_type, start_date, end_date, status) 
        VALUES (:employee_id, :employeeName, :leaveType, :startDate, :endDate, 1)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(":employee_id", $employeeId);
            $stmt->bindParam(":employeeName", $employeeName);
            $stmt->bindParam(":leaveType", $leaveType);
            $stmt->bindParam(":startDate", $startDate);
            $stmt->bindParam(":endDate", $endDate);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; 
            return false; 
        }
    }

    public function view_request($userID){
        try {
            $connection = $this->db->getConnection();
    
            $sql = "SELECT 
                request_for_leave.request_id AS 'Request ID',
                request_for_leave.employee_id AS 'Employee ID', 
                request_for_leave.employee_name AS 'Employee Name', 
                request_for_leave.leave_type AS 'Leave Type',
                request_for_leave.start_date AS 'Start Date',
                request_for_leave.end_date AS 'End Date',
                request_for_leave.application_date AS 'Application Date',
                leave_status.status_name AS 'Status'
            FROM request_for_leave
            INNER JOIN users ON request_for_leave.employee_id = users.employee_id 
            INNER JOIN leave_status ON request_for_leave.status = leave_status.status_id
            WHERE users.id = :userID";
    
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(":userID", $userID);
            
            $stmt->execute();
            
            $convoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $convoData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
}
?>