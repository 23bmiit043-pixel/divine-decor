<?php
session_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate customer login
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to place order']);
        exit;
    }

    // Check if cart is empty
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode(['status' => 'error', 'message' => 'Your cart is empty']);
        exit;
    }

    $cid = $_SESSION['cid'];
    $contact = mysqli_real_escape_string($con, $_POST['c_phone']);
    $address = mysqli_real_escape_string($con, $_POST['c_address']);

    try {
        mysqli_begin_transaction($con);
        $current_date = date('Y-m-d');

        // Calculate totals
        $total_quantity = 0;
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_quantity += $item['quantity'];
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total_amount = $subtotal;

        // Create single order_details record
        $insert_details = "INSERT INTO order_details (
            p_price,
            quantity,
            order_date
        ) VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($con, $insert_details);
        mysqli_stmt_bind_param($stmt, "dis",
            $total_amount,          
            $total_quantity,
            $current_date         
        );
        mysqli_stmt_execute($stmt);
        $order_details_id = mysqli_insert_id($con);

        // Create orders with reference to order_details
        $orders = [];
        foreach ($_SESSION['cart'] as $item) {
            $insert_order = "INSERT INTO `order` (
                pid, cid, quantity, order_date, order_amount, 
                order_status, Contact_no, address, order_details_id
            ) VALUES (?, ?, ?, ?, ?, 'Pending', ?, ?, ?)";
            
            $item_total = $item['price'] * $item['quantity'];
            
            $stmt = mysqli_prepare($con, $insert_order);
            mysqli_stmt_bind_param($stmt, "iiisdssi", 
                $item['pid'], $cid, $item['quantity'],
                $current_date, $item_total, $contact,
                $address, $order_details_id
            );
            mysqli_stmt_execute($stmt);
            $order_id = mysqli_insert_id($con);
            
            // Create payment record with the correct order_id reference
            $transaction_id = isset($_POST['razorpay_payment_id']) ? mysqli_real_escape_string($con, $_POST['razorpay_payment_id']) : ('TXN' . time() . rand(1000, 9999));
            $payment_status = (isset($_POST['razorpay_payment_id']) && !empty($_POST['razorpay_payment_id'])) ? 'Completed' : 'Pending';
            $transaction_mode = isset($_POST['payment_method']) ? mysqli_real_escape_string($con, $_POST['payment_method']) : 'cod';
            
            $insert_payment = "INSERT INTO payment (
                order_id,
                transaction_id,
                payment_date,
                payment_status,
                transaction_mode
            ) VALUES (?, ?, ?, ?, ?)";
            
            $stmt_payment = mysqli_prepare($con, $insert_payment);
            mysqli_stmt_bind_param($stmt_payment, "issss", 
                $order_id,
                $transaction_id,
                $current_date,
                $payment_status,
                $transaction_mode
            );
            mysqli_stmt_execute($stmt_payment);

            $orders[] = [
                'order_id' => $order_id,
                'pid' => $item['pid'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
        }

        // Store order details in session
        $_SESSION['last_order'] = [
            'order_details_id' => $order_details_id,
            'order_date' => $current_date,
            'contact' => $contact,
            'address' => $address,
            'total_amount' => $total_amount,
            'subtotal' => $subtotal,
            'items' => $_SESSION['cart']
        ];

        // Clear cart after successful order
        unset($_SESSION['cart']);
        
        mysqli_commit($con);
        
        echo json_encode([
            'status' => 'success', 
            'message' => 'Order placed successfully',
            'order_id' => $orders[0]['order_id']
        ]);

    } catch (Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['status' => 'error', 'message' => 'Error placing order: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
