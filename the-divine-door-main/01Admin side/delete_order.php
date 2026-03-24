<?php
session_start();
include('connect.php');

if(isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    $query = "DELETE FROM `order` WHERE order_id='$order_id'";
    $query_run = mysqli_query($conn, $query);
    
    if($query_run) {
        $_SESSION['status'] = "Order Deleted Successfully";
        header("Location: order.php");
        exit;
    } else {
        $_SESSION['status'] = "Order Deletion Failed";
        header("Location: order.php");
        exit;
    }
}
?>
