<?php
include('connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email) {
    $mail = new PHPMailer(true);
    try {
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enables verbose debug output
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'ishsood112@gmail.com';                     
        $mail->Password   = 'ntpe edbi umiu tbhd';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;                           

        // Recipients
        $mail->setFrom('ishsood112@gmail.com' , $name);
        $mail->addAddress($email);  

        // Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Email Verification';
        $mail->Body    = "
        <h2>Thank you for registering with Attendance Management System!</h2>
        <p>Dear $name ,</p>
        <p>We are excited to have you on board! Your registration has been successful.</p>
        <p>If you have any questions or concerns, please don't hesitate to reach out to us.</p>
        <p>Best regards,</p>
        <p>Attendance Management System Team</p>
    ";
    

        $mail->send();
        echo "Verification email sent.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

try {
    if (isset($_POST['signup'])) {
        $error_msg = array();

        if (empty($_POST['email'])) {
            $error_msg[] = "Email can't be empty.";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error_msg[] = "Invalid email format.";
        }

        if (empty($_POST['uname'])) {
            $error_msg[] = "Username can't be empty.";
        } elseif (strlen($_POST['uname']) < 3) {
            $error_msg[] = "Username must be at least 3 characters long.";
        }

        if (empty($_POST['pass'])) {
            $error_msg[] = "Password can't be empty.";
        } elseif (strlen($_POST['pass']) < 6) {
            $error_msg[] = "Password must be at least 6 characters long.";
        }

        if (empty($_POST['fname'])) {
            $error_msg[] = "Full name can't be empty.";
        }

        if (empty($_POST['phone'])) {
            $error_msg[] = "Phone number can't be empty.";
        } elseif (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
            $error_msg[] = "Invalid phone number format.";
        }

        if (empty($_POST['type'])) {
            $error_msg[] = "User type can't be empty.";
        }

        if (count($error_msg) == 0) {
            $conn = new mysqli('localhost', 'root', '', 'attmgsystem');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $uname = $_POST['uname'];
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            $fname = $_POST['fname'];
            $phone = $_POST['phone'];
            $type = $_POST['type'];

            // Prepare statement
            $stmt = $conn->prepare("INSERT INTO admininfo (username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");

            // Check if prepare() failed
            if ($stmt === false) {
                throw new Exception("Failed to prepare the SQL statement: " . $conn->error);
            }

            // Bind the parameters correctly
            $stmt->bind_param("ssssss", $uname, $pass, $email, $fname, $phone, $type);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success_msg = "Signup Successful! Please verify your email.";

                // Send verification email
                sendemail_verify($uname, $email);
            } else {
                $error_msg[] = "Signup failed. Please try again.";
            }

            $stmt->close();
        }
    }
} catch (Exception $e) {
    $error_msg[] = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <link rel="stylesheet" href="styles.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<header>

  <h1>Attendance Management System</h1>

</header>
<center>
<h1>Signup</h1>
<div class="content">

  <div class="row">
    <?php
    if(isset($success_msg)) {
        echo '<span style="color: green;">' . $success_msg . '</span>';
    } elseif(isset($error_msg)) {
        if(is_array($error_msg)) {
            foreach ($error_msg as $msg) {
                echo '<span style="color: red;">' . $msg . '</span><br>';
            }
        } else {
            echo '<span style="color: red;">' . $error_msg . '</span>';
        }
    }
     ?>
    <form method="post" class="form-horizontal col-md-6 col-md-offset-3">

<div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Full Name</label>
      <div class="col-sm-7">
        <input type="text" name="fname"  class="form-control" id="input1" placeholder="Fullname" required/>
        <?php
        if (isset($error_msg) && is_array($error_msg) && in_array("Full name can't be empty", $error_msg)) {
            echo '<span style="color: red;">Full name can\'t be empty.</span>';
        }
        ?>
      </div>
  </div>

  <div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Username</label>
      <div class="col-sm-7">
        <input type="text" name="uname"  class="form-control" id="input1" placeholder="Choose Username" required/>
        <?php
        if (isset($error_msg) && is_array($error_msg) && in_array("Username can't be empty", $error_msg)) {
            echo '<span style="color: red;">Username can\'t be empty.</span>';
        }
        ?>
      </div>
  </div>

  <div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Phone Number</label>
      <div class="col-sm-7">
        <input type="text" name="phone"  class="form-control" id="input1" placeholder="Phone Number" required/>
        <?php
        if (isset($error_msg) && is_array($error_msg) && in_array("Phone number can't be empty", $error_msg)) {
            echo '<span style="color: red;">Phone number can\'t be empty.</span>';
        }
        ?>
      </div>
  </div>

  <div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Email</label>
      <div class="col-sm-7">
        <input type="email" name="email"  class="form-control" id="input1" placeholder="Your Email" required/>
        <?php
        if (isset($error_msg) && is_array($error_msg) && in_array("Email can't be empty", $error_msg)) {
            echo '<span style="color: red;">Email can\'t be empty.</span>';
        }
        ?>
      </div>
  </div>

  <div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Password</label>
      <div class="col-sm-7">
        <input type="password" name="pass"  class="form-control" id="input1" placeholder="Enter Password" required/>
        <?php
        if (isset($error_msg) && is_array($error_msg) && in_array("Password can't be empty", $error_msg)) {
            echo '<span style="color: red;">Password can\'t be empty.</span>';
        }
        ?>
      </div>
  </div>

  <div class="form-group" class="radio">
  <label for="input1" class="col-sm-3 control-label">User Role:</label>
  <div class="col-sm-7">
    <label>
      <input type="radio" name="type" id="optionsRadios1" value="student" checked> Student
    </label>
        <label>
      <input type="radio" name="type" id="optionsRadios1" value="teacher"> Teacher
    </label>
    <label>
      <input type="radio" name="type" id="optionsRadios1" value="admin"> Admin
    </label>
    <?php if (isset($error_msg) && in_array("User type can't be empty", $error_msg)) { ?>
    <span style="color: red;">User type can't be empty.</span>
<?php } ?>
  </div>
  </div>

  <?php if (isset($success_msg)) { ?>
    <span style="color: green;"><?php echo $success_msg; ?></span>
<?php } elseif (isset($error_msg)) { ?>
    <?php foreach ($error_msg as $msg) { ?>
        <span style="color: red;"><?php echo $msg; ?></span><br>
    <?php } ?>
<?php } ?>

  <input type="submit" style="border-radius:0%" class="btn btn-primary col-md-2 col-md-offset-8" value="Signup" name="signup" />
</form>
</div>
<br>
<p><strong>Already have an account? <a href="index.php">Login</a> here.</strong></p>

</div>

</center>

</body>
</html>
