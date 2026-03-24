<?php
$host = "localhost:3306";
$username = "root";
$password = "";
$database = "customer";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
