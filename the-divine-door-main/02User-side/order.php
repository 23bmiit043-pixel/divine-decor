<?php // Start session if not already started
include 'connect.php';
include('functions/myfunctions.php');

// Check if user is logged in

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$customer_id = $_SESSION['cid']; // Get logged-in customer ID

// Updated query to match database structure
$query = "SELECT o.order_id, o.order_date, o.order_amount, o.order_status, o.Contact_no,
          p.pid, p.p_name, p.p_image, p.p_price, o.quantity 
          FROM `order` o 
          LEFT JOIN product p ON o.pid = p.pid 
          WHERE o.cid = ? 
          ORDER BY o.order_date DESC";

$stmt = $con->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $customer_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        die("Execute failed: " . $stmt->error);
    }
} else {
    die("Prepare failed: " . $con->error);
}

// Add error logging
if ($result === false) {
    error_log("Query failed: " . $con->error);
    die("An error occurred while fetching orders.");
}

// Add this function after the database query section
function cancelOrder($orderId, $con) {
    // Update order status
    $updateOrderQuery = "UPDATE `order` SET order_status = 'Cancelled' WHERE order_id = ?";
    $stmt = $con->prepare($updateOrderQuery);
    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            return false;
        }
    }
    return true;
}

// Add this code before displaying orders
if (isset($_POST['cancel_order'])) {
    $orderId = $_POST['order_id'];
    if (cancelOrder($orderId, $con)) {
        $_SESSION['message'] = "Order cancelled successfully";
    } else {
        $_SESSION['message'] = "Failed to cancel order";
    }
    header("Location: order.php");
    exit();
}
?>
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders - The Divine Decor</title>
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css?v=site-refresh-20260317-3" rel="stylesheet">
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container my-5">
        <h2 class="text-center mb-4">My Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        $current_order = null;
                        $order_products = array();
                        
                        // Group products by order
                        while ($row = $result->fetch_assoc()) {
                            $order_id = $row['order_id'];
                            if (!isset($order_products[$order_id])) {
                                $order_products[$order_id] = array(
                                    'order_date' => $row['order_date'],
                                    'order_amount' => $row['order_amount'],
                                    'order_status' => $row['order_status'],
                                    'products' => array()
                                );
                            }
                            if ($row['pid']) {
                                $order_products[$order_id]['products'][] = $row;
                            }
                        }

                        // Display orders
                        foreach ($order_products as $order_id => $order) { ?>
                            <tr>
                                <td>#<?= $order_id ?></td>
                                <td><?= date("d M Y", strtotime($order['order_date'])) ?></td>
                                <td class="product-list">
                                    <?php foreach ($order['products'] as $product): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="uploads/<?= htmlspecialchars($product['p_image']) ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;"
                                                 alt="<?= htmlspecialchars($product['p_name']) ?>">
                                            <div class="ms-2">
                                                <div><?= htmlspecialchars($product['p_name']) ?></div>
                                                <small>Qty: <?= $product['quantity'] ?> × ₹<?= number_format($product['p_price'], 2) ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <td>₹<?= number_format($order['order_amount'], 2) ?></td>
                                <td>
                                    <span class="badge <?= ($order['order_status'] == 'Completed') ? 'bg-success' : 'bg-warning'; ?>">
                                        <?= htmlspecialchars($order['order_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="order_details.php?order_id=<?= $order_id ?>" 
                                           class="btn btn-outline-primary btn-sm">View Details</a>
                                        <?php if ($order['order_status'] == 'Completed'): ?>
                                            <a href="feedback.php?order_id=<?= $order_id ?>" 
                                               class="btn btn-outline-success btn-sm ms-2">Give Feedback</a>
                                        <?php elseif ($order['order_status'] != 'Cancelled'): ?>
                                            <form method="POST" class="d-inline ms-2">
                                                <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                                <button type="submit" name="cancel_order" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    Cancel Order
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
</body>
</html>
