<?php
$conn = mysqli_connect('localhost', 'root', '', 'attmgsystem');

if (!$conn) {
    die('Cannot connect to server: ' . mysqli_connect_error());
}
?>