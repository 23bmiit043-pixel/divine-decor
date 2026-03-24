<?php

$host="localhost";
$user="root";
$pass="Preet@2005";
$db="pixel";

//database connection
$conn=new mysqli($host,$user,$pass,$db);

//check connection
if(!$conn){
    header("Location: ../errors/db.php");
    die();
}
