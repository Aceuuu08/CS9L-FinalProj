<?php
include_once("db_conn.php");
include_once("profile.php");

$db = new Database();
$connection = $db->getConnection();
$profile = new Profile($db);

session_start(); // Start the session to access session variables
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: index.php");
    exit();
}

$userID = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $employeeId = $_POST['employee_id'];
    $employeeName = $_POST['employeeName'];
    $leaveType = $_POST['leaveType'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $insertResult = $profile->create_request($employeeId, $employeeName, $leaveType, $startDate, $endDate);

    if ($insertResult) {
        header("Location: leave_history_view.php");
        exit();
    } else {
        echo "Failed to insert leave request.";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE REQUEST</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php include('includes/navbar.html'); ?>
<?php include('includes/sidebar.html'); ?>

    <div class="content">
        <h2>CREATE LEAVE REQUEST</h2>
        <form method="post" action="">
            <div class="table-container">
                <table class="data-table">
                    <tbody>
                        <tr>
                            <td><strong>Employee ID: </strong></td>
                            <td><input type="text" name="employee_id"></td>
                        </tr>
                        <tr>
                            <td><strong>Employee Name: </strong></td>
                            <td><input type="text" name="employeeName"></td>
                        </tr>
                        <tr>
                            <td><strong>Leave Type: </strong></td>
                            <td><input type="text" name="leaveType"></td>
                        </tr>
                        <tr>
                            <td><strong>Start Date: </strong></td>
                            <td><input type="date" name="startDate"></td>
                        </tr>
                        <tr>
                            <td><strong>End Date: </strong></td>
                            <td><input type="date" name="endDate"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</body>
</html>
