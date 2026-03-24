<?php
session_start();
include 'connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    
    // Update query including gender
    $sql = "UPDATE customer SET 
            C_name = ?, 
            Email = ?, 
            Contact_no = ?, 
            Gender = ?,
            Address = ? 
            WHERE Cid = ?";
            
    if($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $phone, $gender, $address, $_SESSION["cid"]);
        
        if(mysqli_stmt_execute($stmt)) {
            header("location: profile.php?success=1");
        } else {
            header("location: profile.php?error=1");
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);
}
?>
