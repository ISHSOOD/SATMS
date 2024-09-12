<?php
include ('connect.php');

session_start();
if(isset($_POST['verify_otp']))
{
    try{
        if(empty($_POST['otp'])){
            throw new Exception("OTP is required!");
        }
        
        $entered_otp = $_POST['otp'];
        $hashed_otp = $_SESSION['otp'];
        
        if(hash('sha256', $entered_otp) === $hashed_otp){
            // OTP is valid, redirect to dashboard
            header('Location: index.php'); // Replace index.php with your actual dashboard page
            exit;
        } else{
            throw new Exception("Invalid OTP, try again!");
        }
    }
    catch(Exception $e){
        $error_msg=$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

	<title>Attendance Management System</title>
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
	<center>

<header>

  <h1>Attendance Management System</h1>

</header>

<h3>Verify OTP</h3>

<?php
//printing error message
if(isset($error_msg))
{
	echo $error_msg;
}
?>

<div class="content">
	<div class="row">

		<form method="post" class="form-horizontal col-md-6 col-md-offset-3">
			<div class="form-group">
			    <label for="input1" class="col-sm-3 control-label">OTP</label>
			    <div class="col-sm-7">
			      <input type="text" name="otp"  class="form-control" id="input1" placeholder="Enter OTP" />
			    </div>
			</div>

			<input type="submit" class="btn btn-success col-md-3 col-md-offset-7" style="border-radius:0%" value="Verify OTP" name="verify_otp" />
		</form>
	</div>
</div>

</center>
</body>
</html>