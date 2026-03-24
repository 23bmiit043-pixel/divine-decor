<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['pending_stock_updates'])) {
        mysqli_begin_transaction($con);
        try {
            foreach ($_SESSION['pending_stock_updates'] as $pid => $item) {
                $query = "UPDATE product SET quantity = quantity + ? WHERE pid = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "ii", $item['quantity'], $pid);
                mysqli_stmt_execute($stmt);
            }
            mysqli_commit($con);
            unset($_SESSION['pending_stock_updates']);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            mysqli_rollback($con);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
?>
