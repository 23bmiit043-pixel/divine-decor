<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_code = trim($_POST['coupon_code']);
    $subtotal = floatval($_POST['subtotal']);
    
    if (empty($coupon_code)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a coupon code'
        ]);
        exit;
    }
    
    // Query to check if coupon exists and is valid
    $query = "SELECT * FROM offer WHERE coupone_code = ? AND start_date <= CURDATE() AND end_date >= CURDATE()";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $coupon_code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Skip invalid coupons
        if ($row['coupone_code'] === '0') {
            $response = [
                'status' => 'error',
                'message' => 'Invalid coupon code.'
            ];
        }
        // Check minimum amount requirement against order total
        else if ($subtotal + 50 >= $row['min_ant']) { // Add delivery charge to subtotal
            $response = [
                'status' => 'success',
                'message' => 'Coupon applied successfully!',
                'offer_description' => $row['Offer_discription'],
                'discount_amount' => floatval($row['discount_amt']),
                'min_amount' => floatval($row['min_ant']),
                'end_date' => date('d M Y', strtotime($row['end_date'])) // Format end date
            ];
            
            // Store coupon data in session
            $_SESSION['applied_coupon'] = [
                'code' => $coupon_code,
                'discount' => $row['discount_amt'],
                'description' => $row['Offer_discription']
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Minimum order amount of ₹' . number_format($row['min_ant'], 2) . ' required for this coupon.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid or expired coupon code.'
        ];
    }
    
    echo json_encode($response);
    exit;
}
?>
