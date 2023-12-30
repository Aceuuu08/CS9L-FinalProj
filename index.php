<?php
include_once("db_conn.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make sure no output is here or in the included files
session_start();
$db = new Database();
$connection = $db->getConnection();

if (isset($_SESSION['user_id'])) {
    header("Location: profile_view.php");
    exit();
}


# LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM employees.users WHERE username = :username AND password = :password";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        header("Location: profile_view.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

# SIGNUP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = $_POST['signup_username'];
    $password = $_POST['signup_password']; 
    $employeeId = $_POST['employee_id'];

    $query = "INSERT INTO employees.users (id, employee_id, username, password) 
          VALUES (:id, :employee_id, :username, :password)";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":employee_id", $employeeId);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);


    if ($stmt->execute()) {
        $signupSuccess = "Successful.";
    } else {
        $signupError = "Try Again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">


<script>
        function showLoginForm() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
        }

        function showSignupForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
        }
    </script>

</head>
<body>
    <?php include('includes/navbar.html'); ?>

    <div class="container mt-5">
        <div class="centered-form">
            <!-- # Login Form -->
            <div id="loginForm" class="form-container">
                <h3>Login</h3>
                <form method="post" action="">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required>

                    <input type="submit" name="login" value="Login">
                </form>

                <?php if (isset($loginError)) { ?>
                    <p><?php echo $loginError; ?></p>
                <?php } ?>
            </div>

            <!-- # SIGNUP -->
            <div id="signupForm" class="form-container" style="display: none;">
                <h3>Signup</h3>
                <form method="post" action="">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" name="employee_id" required>

                    <label for="signup_username">Username:</label>
                    <input type="text" name="signup_username" required>

                    <label for="signup_password">Password:</label>
                    <input type="password" name="signup_password" required>

                    <input type="submit" name="signup" value="Sign Up">
                </form>

                <?php
                if (isset($signupSuccess)) {
                    echo "<p>$signupSuccess</p>";
                }

                if (isset($signupError)) {
                    echo "<p>$signupError</p>";
                }
                ?>
            </div>

            <div class="toggle-buttons mt-3">
                <button onclick="showLoginForm()" class="btn btn-primary">Login</button>
                <button onclick="showSignupForm()" class="btn btn-secondary">Sign Up</button>
            </div>
        </div>
    </div>

</body>
</html>





