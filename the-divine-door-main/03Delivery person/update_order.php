<?php
session_start();
include('../config/dbcon.php');

if(isset($_POST['mark_completed']) && isset($_POST['order_details_id'])) {
    $order_details_id = $_POST['order_details_id'];
    
    // Update order status to Completed
    $update_query = "UPDATE `order` SET order_status='Completed' 
                    WHERE order_details_id='$order_details_id'";
    
    if(mysqli_query($con, $update_query)) {
        $_SESSION['message'] = "Order marked as completed successfully";
    } else {
        $_SESSION['message'] = "Error updating order status";
    }
}

header('Location: pending-orders.php');
exit();
