<?php 
  
  include('connect.php');

  if(isset($_POST['reset'])){
    try{
      $email = $_POST['email'];
      $query = $conn->prepare("SELECT * FROM admininfo WHERE email = ?");
      $query->bind_param("s", $email);
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();

      if(empty($row)){
        echo '<div class="content"><p>Email is not associated with any account. Contact OAMS 1.0</p></div>';
      } else {
        $token = bin2hex(random_bytes(32));
        $query = $conn->prepare("UPDATE admininfo SET password_reset_token = ? WHERE email = ?");
        $query->bind_param("ss", $token, $email);
        $query->execute();

        // Send the password reset token to the user's email
        $subject = 'Password Reset Token';
        $message = 'Hi there!<br>You requested for a password recovery. Your password reset token is: <mark>' . $token . '</mark><br>Regards,<br>Attendance Management System';
        $headers = 'From: your_email@example.com' . "\r\n" .
          'Reply-To: your_email@example.com' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);

        echo '<div class="content"><p>Password reset token sent to your email.</p></div>';
      }
    } catch(Exception $e){
      echo '<div class="content"><p>Error: ' . $e->getMessage() . '</p></div>';
    }
  }

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/main.css">
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
  <div class="navbar">
  <a href="index.php">Login</a>

</div>

</header>

<center>

<div class="content">
    <div class="row">

    <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
    <h3>Recover your password</h3>

      <div class="form-group">

          <label for="input1" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email"  class="form-control" id="input1" placeholder="your email" />
          </div>
      </div>

      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Go" name="reset" />
    </form>

  </div>

</div>

</center>

</body>
</html>