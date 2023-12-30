<?php
include_once("db_conn.php");
include_once("profile.php");

$db = new Database();
$connection = $db->getConnection();
$profile = new Profile($db);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userID = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $userID = $_SESSION['user_id'];
    $employeeName = $_POST['employeeName'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $emailAddress = $_POST['emailAddress'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $permSpecAddress = $_POST['specAddress'] ?? '';
    $permStreetAddress = $_POST['streetAddress'] ?? '';
    $permVillAddress = $_POST['villAddress'] ?? '';
    $permBarangayAddress = $_POST['brgyAddress'] ?? '';
    $permCity = $_POST['city'] ?? '';

    // Perform update operation using a method in your Profile class
    $updateResult = $profile->update($userID, $fname, $mname, $lname, $sex, $emailAddress, $phoneNumber, $permSpecAddress, $permStreetAddress, $permVillAddress, $permBarangayAddress, $permCity);

    if ($updateResult) {
        // Redirect to the view page or display a success message
        header("Location: profile_view.php");
        exit();
    } else {
        // Handle the case where update fails
        echo "Failed to update employee details.";
    }
}

// Fetch the employee details based on the ID only if the form is not submitted
if (!isset($_POST['submit'])) {
    $employeeDetails = $profile->view($userID);

    if ($employeeDetails) {
        $employeeId = $employeeDetails['Employee ID'] ?? '';
        $fname = $employeeDetails['First Name'] ?? '';
        $mname = $employeeDetails['Middle Name'] ?? '';
        $lname = $employeeDetails['Last Name'] ?? '';
        $sex = $employeeDetails['Sex'] ?? '';
        $emailAddress = $employeeDetails['Email Address'] ?? '';
        $phoneNumber = $employeeDetails['Phone Number'] ?? '';
        $specAddress = $employeeDetails['perm_spec_address'] ?? '';
        $streetAddress = $employeeDetails['perm_street_address'] ?? '';
        $villAddress = $employeeDetails['perm_vill_address'] ?? '';
        $brgyAddress = $employeeDetails['perm_barangay_address'] ?? '';
        $city = $employeeDetails['perm_city'] ?? '';
    } else {
        echo "Employee details not found.";
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php include('includes/navbar.html'); ?>
<?php
function isPageActive($pageName)
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage === $pageName) {
        return 'active';
    }
    return '';
}
?>
<?php include('includes/sidebar.html'); ?>

    <div class="content">
        <h2>EDIT PROFILE</h2>
        <form method="post" action="">
            <div class="table-container">
            <table class="data-table">
                <tbody>
                    <tr>
                        <td><strong>Employee ID: </strong></td>
                        <td><?php echo $employeeId; ?></td>
                    </tr>
                    <tr>
                        <td><strong>First Name: </strong></td>
                        <td><input type="text" name="fname" value="<?php echo $fname; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Middle Name: </strong></td>
                        <td><input type="text" name="mname" value="<?php echo $mname; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Last Name: </strong></td>
                        <td><input type="text" name="lname" value="<?php echo $lname; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Sex: </strong></td>
                        <td><input type="text" name="sex" value="<?php echo $sex; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Email Address: </strong></td>
                        <td><input type="email" name="emailAddress" value="<?php echo $emailAddress; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number: </strong></td>
                        <td><input type="text" name="phoneNumber" value="<?php echo $phoneNumber; ?>"></td>
                    </tr>
                    <tr>
                        <tr>
                        <td><strong>Specific Address: </strong></td>
                        <td><input type="text" name="specAddress" value="<?php echo $specAddress; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Street Address: </strong></td>
                        <td><input type="text" name="streetAddress" value="<?php echo $streetAddress; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Village Address: </strong></td>
                        <td><input type="text" name="villAddress" value="<?php echo $villAddress; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Barangay Address: </strong></td>
                        <td><input type="text" name="brgyAddress" value="<?php echo $brgyAddress; ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>City: </strong></td>
                        <td><input type="text" name="city" value="<?php echo $city; ?>"></td>
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
