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
    try{
      
    if(isset($_POST['att'])){

      $course = $_POST['whichcourse'];

      if(isset($_POST['st_status']) && isset($_POST['stat_id'])) {
        foreach ($_POST['st_status'] as $i => $st_status) {
        
          $stat_id = $_POST['stat_id'][$i];
          $dp = date('Y-m-d');
          $course = $_POST['whichcourse'];
          
          $stat = mysqli_query($mysqli, "insert into attendance(stat_id,course,st_status,stat_date) values('$stat_id','$course','$st_status','$dp')");
          
          $att_msg = "Attendance Recorded.";

        }
      } else {
        $error_msg = "Please select the attendance status for all students.";
      }
    }
  }
  catch(Exception $e){
    $error_msg = $e->getMessage();
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


<style type="text/css">
  .status{
    font-size: 10px;
  }

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
    <h3>Attendance of <?php echo date('Y-m-d'); ?></h3>
    <br>

    <center><p><?php if(isset($att_msg)) echo $att_msg; if(isset($error_msg)) echo $error_msg; ?></p></center> 
    
    <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">

     <div class="form-group">

               <!-- <label>Select Batch</label>
                
                <select name="whichbatch" id="input1">
                      <option name="eight" value="38">38</option>
                      <option name="seven" value="37">37</option>
                </select>-->


                <label>Enter Batch</label>
                <input type="text" name="whichbatch" id="input2" placeholder="Only 2020">
              </div>
               
     <input type="submit" class="btn btn-danger col-md-2 col-md-offset-5" style="border-radius:0%" value="Search" name="batch" />

    </form>
    <div class="content"></div>
    <form action="" method="post">

      <div class="form-group">

        <label >Select Subject</label>
              <select name="whichcourse" id="input1">
              <option  value="algo">Analysis of Algorithms</option>
         <option  value="algolab">Analysis of Algorithms Lab</option>
        <option  value="dbms">Database Management System</option>
        <option  value="dbmslab">Database Management System Lab</option>
        <option  value="weblab">Web Programming Lab</option>
        <option  value="os">Operating System</option>
        <option  value="oslab">Operating System Lab</option>
        <option  value="obm">Object Based Modeling</option>
        <option  value="softcomp">Soft Computing</option>
              </select>

      </div>

    <table

      <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Reg. No.</th>
      <th scope="col">Name</th>
      <th scope="col">Department</th>
      <th scope="col">Batch</th>
      <th scope="col">Semester</th>
      <th scope="col">Email</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <?php

  if (isset($_POST['batch'])) {

    $i = 0;
    $radio = 0;
    $batch = $_POST['whichbatch'];

    // Validate batch input
    if (empty($batch) || !is_numeric($batch)) {
      $error_msg = "Invalid batch number.";
    } else {
      $all_query = $mysqli->query("SELECT * FROM students WHERE students.st_batch = '$batch' ORDER BY st_id ASC");

      if ($all_query->num_rows > 0) {
        while ($data = mysqli_fetch_array($all_query)) {
          $i++;
          $radio++;
          ?>
          <tr>
            <td><?php echo $data['st_id']; ?> <input type="hidden" name="stat_id[]" value="<?php echo $data['st_id']; ?>"> </td>
            <td><?php echo $data['st_name']; ?></td>
            <td><?php echo $data['st_dept']; ?></td>
            <td><?php echo $data['st_batch']; ?></td>
            <td><?php echo $data['st_sem']; ?></td>
            <td><?php echo $data['st_email']; ?></td>
            <td>
              <label>Present</label>
              <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Present">
              <label>Absent </label>
              <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Absent" checked>
            </td>
          </tr>
          <?php
        }
      } else {
        $error_msg = "No students found for the given batch.";
      }
    }
  }
  ?>
</table>

<center><br>
  <?php if (isset($error_msg)) echo $error_msg; ?>
  <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save!" name="att" />
</center>

</form>
</div>

</div>

</center>

</body>
</html>