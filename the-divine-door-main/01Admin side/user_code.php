<?php
session_start();
include("connect.php");

if(isset($_POST['DeleteUserBtn']))
{
    $user_id = $_POST['delete_id'];
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Delete related feedback records first
        $query1 = "DELETE FROM feedback WHERE cid='$user_id'";
        mysqli_query($conn, $query1);
        
        // Delete related payment records through orders
        $query2 = "DELETE payment FROM payment 
                   INNER JOIN `order` ON payment.order_id = `order`.order_id 
                   WHERE `order`.cid='$user_id'";
        mysqli_query($conn, $query2);
        
        // Delete related order records
        $query3 = "DELETE FROM `order` WHERE cid='$user_id'";
        mysqli_query($conn, $query3);
        
        // Finally delete the customer
        $query4 = "DELETE FROM customer WHERE Cid='$user_id'";
        mysqli_query($conn, $query4);
        
        // If we get here, commit the changes
        mysqli_commit($conn);
        $_SESSION['status'] = "User and all related records deleted successfully";
        header("Location: registerd.php");
        exit();
        
    } catch (Exception $e) {
        // An error occurred, rollback changes
        mysqli_rollback($conn);
        $_SESSION['status'] = "User deletion failed: " . $e->getMessage();
        header("Location: registerd.php");
        exit();
    }
}
?>