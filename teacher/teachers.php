<?php

ob_start();
session_start();

// if($_SESSION['name']!='oasis')
// {
//   header('location: login.php');
// }
?>
<?php
  include('connect.php');
  $mysqli = new mysqli('localhost', 'root', '', 'attmgsystem');

  // Check connection
  if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">

  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <link rel="stylesheet" href="styles.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</style>

</head>
<body>

<header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <a href="index.php" style="text-decoration:none;">Home</a>
  <a href="students.php" style="text-decoration:none;">Students</a>
  <a href="teachers.php" style="text-decoration:none;">Faculties</a>
  <a href="attendance.php" style="text-decoration:none;">Attendance</a>
  <a href="report.php" style="text-decoration:none;">Report</a>
  <a href="../logout.php" style="text-decoration:none;">Logout</a>

</div>

</header>

<center>

<div class="row">

  <div class="content">
    <h3>Teacher List</h3>
    
    <table class="table table=stripped">
        <thead>  
          <tr>
            <th scope="col">Teacher ID</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Email</th>
            <th scope="col">Course</th>
          </tr>
        </thead>

      <?php
// query the database
$tcr_query = $mysqli->query("SELECT * FROM teachers ORDER BY tc_id ASC");
$i = 0; // Initialize the variable $i
while($tcr_data = $tcr_query->fetch_assoc()){
    $i++;
    ?>
    <tbody>
        <tr>
            <td><?php echo $tcr_data['tc_id']; ?></td>
            <td><?php echo $tcr_data['tc_name']; ?></td>
            <td><?php echo $tcr_data['tc_dept']; ?></td>
            <td><?php echo $tcr_data['tc_email']; ?></td>
            <td><?php echo $tcr_data['tc_course']; ?></td>
        </tr>
    </tbody>
    <?php } ?>
          
    </table>

  </div>

</div>

</center>

</body>
</html>
