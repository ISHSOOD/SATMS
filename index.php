<?php
// Enable error reporting to debug issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session
ob_start(); // Start output buffering
include('connect.php');

if (isset($_POST['login'])) {
    $error_msg = "";

    // Validate inputs
    if (empty($_POST['username'])) {
        $error_msg .= "Username is required!<br>";
    }
    if (empty($_POST['password'])) {
        $error_msg .= "Password is required!<br>";
    }

    // Check if there are no validation errors
    if (empty($error_msg)) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $type = $_POST['type'];

        // Prepare the SQL statement to check username, password, and type
        $stmt = $conn->prepare("SELECT * FROM admininfo WHERE username=? AND password=? AND type=?");
        $stmt->bind_param("sss", $username, $password, $type);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user was found
        if ($result->num_rows > 0) {
            // Set session variables dynamically based on login
            $_SESSION['username'] = $username; // Store the username
            $_SESSION['type'] = $type; // Store the user type (student, teacher, admin)

            // Redirect based on user type
            switch ($type) {
                case 'student':
                    header("Location: student/studentindex.php");
                    break;
                case 'teacher':
                    header("Location: teacher/index.php");
                    break;
                case 'admin':
                    header("Location: admin/index.php");
                    break;
            }
            ob_end_flush(); // Flush output buffer before redirect
            exit(); // Stop script execution after redirect
        } else {
            $error_msg = "Invalid credentials or user type.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <center>
        <header>
            <h1>Attendance Management System</h1>
        </header>

        <h3>Login Panel</h3>

        <?php
        // Display any error messages
        if (!empty($error_msg)) {
            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
        }
        ?>

        <div class="content">
            <div class="row">
                <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-7">
                            <input type="text" name="username" class="form-control" id="input1" placeholder="Your Username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="password" class="form-control" id="input1" placeholder="Your Password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Login As:</label>
                        <div class="col-sm-6">
                            <label>
                                <input type="radio" name="type" value="student" checked> Student
                            </label>
                            <label>
                                <input type="radio" name="type" value="teacher"> Teacher
                            </label>
                            <label>
                                <input type="radio" name="type" value="admin"> Admin
                            </label>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-success col-md-3 col-md-offset-7" style="border-radius:0%" value="Login" name="login">
                </form>
            </div>
        </div>

        <p><strong><a href="reset.php" style="text-decoration:none;">Reset Password</a></strong></p>
        <p><strong><a href="signup.php" style="text-decoration:none;">Create New Account</a></strong></p>
    </center>
</body>
</html>
