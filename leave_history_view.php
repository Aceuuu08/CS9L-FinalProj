<?php
include_once("db_conn.php");
include_once("profile.php");

$db = new Database();
$connection = $db->getConnection();
$profile = new Profile($db);

session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: index.php");
    exit();
}

$userID = $_SESSION['user_id'];

$requestDetails = $profile->view_request($userID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <?php include('includes/navbar.html'); ?>
    <?php include('includes/sidebar.html'); ?>

    <div class="content">
        <h2>LEAVE STATUS</h2>
        <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Application Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($requestDetails) { ?>
                    <?php foreach ($requestDetails as $row) { ?>
                        <tr>
                            <td><?php echo $row['Request ID']; ?></td>
                            <td><?php echo $row['Employee ID']; ?></td>
                            <td><?php echo $row['Employee Name']; ?></td>
                            <td><?php echo $row['Leave Type']; ?></td>
                            <td><?php echo $row['Start Date']; ?></td>
                            <td><?php echo $row['End Date']; ?></td>
                            <td><?php echo $row['Application Date']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7">No request details found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        </div>
    </div>

</body>
</html>
