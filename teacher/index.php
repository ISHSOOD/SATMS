<?php
ob_start();
session_start();

// Check if session variable is set correctly
// if (!isset($_SESSION['name']) || $_SESSION['name'] != 'oasis') {
//     header('Location: /teacher/index.php'); // Redirect to login if not authenticated
//     exit; // Stop further execution
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
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
            <img src="../img/att.png" width="400px" />
        </div>
    </div>
</center>

</body>
</html>
