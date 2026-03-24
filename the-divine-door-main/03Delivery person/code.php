<?php
session_start();
include('../config/dbcon.php');

if(isset($_POST['update_profile'])) {
    $delivery_id = $_SESSION['delivery_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    $update_query = "UPDATE delivery_person SET 
                    Name='$name', 
                    Email='$email', 
                    Contact_no='$phone' 
                    WHERE delivery_person_id='$delivery_id'";
    
    $update_result = mysqli_query($con, $update_query);

    if($update_result) {
        $_SESSION['auth_user']['name'] = $name;
        $_SESSION['auth_user']['email'] = $email;
        $_SESSION['message'] = "Profile Updated Successfully";
        header('Location: profile.php');
    } else {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: profile.php');
    }

    exit();
}

if(isset($_POST['update_password'])) {
    $delivery_id = $_SESSION['delivery_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check current password
    $check_query = "SELECT password FROM delivery_person WHERE delivery_person_id='$delivery_id'";
    $check_result = mysqli_query($con, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if($check_data['password'] == $current_password) {
        if($new_password == $confirm_password) {
            $update_query = "UPDATE delivery_person SET password='$new_password' 
                           WHERE delivery_person_id='$delivery_id'";
            $update_result = mysqli_query($con, $update_query);

            if($update_result) {
                $_SESSION['message'] = "Password Updated Successfully";
            } else {
                $_SESSION['message'] = "Failed to Update Password";
            }
        } else {
            $_SESSION['message'] = "New Passwords Don't Match";
        }
    } else {
        $_SESSION['message'] = "Current Password is Incorrect";
    }
    
    header('Location: profile.php');
    exit();
}
?>
