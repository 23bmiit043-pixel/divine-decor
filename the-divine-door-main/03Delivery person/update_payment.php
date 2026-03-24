<?php
session_start();
include('../config/dbcon.php');

if(isset($_POST['mark_paid']) && isset($_POST['order_details_id'])) {
    $order_details_id = $_POST['order_details_id'];
    
    // Update payment status to Paid
    $update_query = "UPDATE payment p 
                    JOIN `order` o ON p.order_id = o.order_id
                    SET p.payment_status = 'Paid', 
                        p.payment_date = CURRENT_DATE()
                    WHERE o.order_details_id = '$order_details_id'";
    
    if(mysqli_query($con, $update_query)) {
        $_SESSION['message'] = "Payment status updated successfully";
    } else {
        $_SESSION['message'] = "Error updating payment status";
    }
}

header('Location: completed-orders.php');
exit();
