<?php
$host = 'localhost';
$user = 'root';
$pass = 'alexcom34';
$db   = 'sesi-3ano';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>