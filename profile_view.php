<?php
include_once("db_conn.php");
include_once("profile.php");

$db = new Database();
$connection = $db->getConnection();
$profile = new Profile($db);

session_start(); // Start the session to access session variables
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: profile_view.php");
    exit();
}
// Assuming $employeeId contains the ID of the employee you want to retrieve details for
$userID = $_SESSION['user_id'];

// Fetch the employee details based on the ID
$employeeDetails = $profile->view($userID); // You might have a method like this in your Profile class

// Check if the employee details are fetched successfully
if ($employeeDetails) {
    $employeeId = $employeeDetails['Employee ID'];
    $employeeName = $employeeDetails['Employee Name'];
    $sex = $employeeDetails['Sex'];
    $emailAddress = $employeeDetails['Email Address'];
    $phoneNumber = $employeeDetails['Phone Number'];
    $homeAddress = $employeeDetails['Address'];
    $fname = $employeeDetails['First Name'] ?? '';
    $mname = $employeeDetails['Middle Name'] ?? '';
    $lname = $employeeDetails['Last Name'] ?? '';
    $specAddress = $employeeDetails['perm_spec_address'] ?? '';
    $streetAddress = $employeeDetails['perm_street_address'] ?? '';
    $villAddress = $employeeDetails['perm_vill_address'] ?? '';
    $brgyAddress = $employeeDetails['perm_barangay_address'] ?? '';
    $city = $employeeDetails['perm_city'] ?? '';
} else {
    // Handle the case where employee details are not found
    // You might want to display an error message or handle it accordingly
    echo "Employee details not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php include('includes/navbar.html'); ?>
<?php include('includes/sidebar.html'); ?>

    <div class="content">
        <div class="table-container">
        <table class="data-table">
            <h2>PROFILE</h2>
            <tbody>
                <tr>
                    <td><strong>Employee ID: </strong></td>
                    <td><?php echo $employeeId; ?></td>
                </tr>
                <tr>
                    <td><strong>Employee Name: </strong></td>
                    <td><?php echo $employeeName; ?></td>
                </tr>
                <tr>
                    <td><strong>Sex: </strong></td>
                    <td><?php echo $sex; ?></td>
                </tr>
                <tr>
                    <td><strong>Email Address: </strong></td>
                    <td><?php echo $emailAddress; ?></td>
                </tr>
                <tr>
                    <td><strong>Phone Number: </strong></td>
                    <td><?php echo $phoneNumber; ?></td>
                </tr>
                <tr>
                    <td><strong>Home Address: </strong></td>
                    <td><?php echo $homeAddress; ?></td>
                </tr>
            </tbody>
        </table>

        </div>
    </div>

</body>
</html>
