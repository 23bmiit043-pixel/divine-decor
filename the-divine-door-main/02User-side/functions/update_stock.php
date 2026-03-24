<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'success', 'message' => ''];
    
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit;
    }

    mysqli_begin_transaction($con);
    try {
        foreach ($_SESSION['cart'] as $pid => $item) {
            // Verify current stock
            $query = "SELECT quantity FROM product WHERE pid = ? FOR UPDATE";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "i", $pid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);

            if ($product['quantity'] < $item['quantity']) {
                throw new Exception("Not enough stock for one or more products");
            }

            // Update stock
            $query = "UPDATE product SET quantity = quantity - ? WHERE pid = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ii", $item['quantity'], $pid);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error updating stock");
            }
        }

        // Store updated quantities in session for potential restoration
        $_SESSION['pending_stock_updates'] = $_SESSION['cart'];
        
        mysqli_commit($con);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
