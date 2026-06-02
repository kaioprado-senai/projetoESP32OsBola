<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'esp32banco';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>