<?php
include_once("db_conn.php");

$db = new Database();
$connection = $db->getConnection();

if(isset($_GET['id'])) {
    $requestID = $_GET['id'];
    $statusID = 3;

    try {
        $sql = "UPDATE `request_for_leave` SET `status` = :statusID WHERE `request_id` = :requestID";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":statusID", $statusID);
        $stmt->bindParam(":requestID", $requestID);
        $stmt->execute();

        header("Location: leave_applications.php"); // Redirect after updating status
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request ID";
}
?>
