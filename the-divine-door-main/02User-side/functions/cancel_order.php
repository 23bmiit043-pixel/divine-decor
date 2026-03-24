<?php
session_start();
include('../connect.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to cancel order']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $customer_id = $_SESSION['cid'];
    
    // Verify the order belongs to the logged-in customer and is in Pending status
    $query = "SELECT * FROM `order` WHERE order_id = ? AND cid = ? AND order_status = 'Pending'";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Order not found or cannot be cancelled']);
        exit;
    }
    
    // Update order status to Cancelled
    $update_query = "UPDATE `order` SET order_status = 'Cancelled' WHERE order_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Order cancelled successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to cancel order']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
