<?php
/**
 * Razorpay Payment Verification Script
 * 
 * This script verifies Razorpay payment signatures and processes successful payments
 */

session_start();
include '../connect.php';
include '../config/razorpay_config.php';

header('Content-Type: application/json');

// Check if required fields are present
if (!isset($_POST['razorpay_payment_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$paymentId = $_POST['razorpay_payment_id'];
$signature = $_POST['razorpay_signature'] ?? '';
$orderId = $_POST['razorpay_order_id'] ?? '';

// Fetch payment details from Razorpay to verify
$paymentDetails = getPaymentDetails($paymentId);

if (isset($paymentDetails['error'])) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to verify payment']);
    exit;
}

// Check if payment was successful
if ($paymentDetails['status'] !== 'captured' && $paymentDetails['status'] !== 'authorized') {
    echo json_encode(['status' => 'error', 'message' => 'Payment not successful']);
    exit;
}

// Verify the signature
if (!empty($signature) && !empty($orderId)) {
    if (!verifyRazorpaySignature($orderId, $paymentId, $signature)) {
        echo json_encode(['status' => 'error', 'message' => 'Signature verification failed']);
        exit;
    }
}

// If we reach here, payment is verified and successful
// Return success status to allow place_order.php to proceed
echo json_encode(['status' => 'success', 'message' => 'Payment verified successfully']);
exit;
?>
