<?php
session_start();
include('../config/dbcon.php');

if(isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = mysqli_real_escape_string($con, $_GET['id']);
    $status = mysqli_real_escape_string($con, $_GET['status']);
    
    $update_query = "UPDATE `order` SET order_status='$status' WHERE order_id='$order_id' AND delivery_person_id='".$_SESSION['delivery_id']."'";
    $update_query_run = mysqli_query($con, $update_query);
    
    if($update_query_run) {
        $_SESSION['message'] = "Order status updated successfully";
    } else {
        $_SESSION['message'] = "Something went wrong";
    }
}

header('Location: pending-orders.php');
