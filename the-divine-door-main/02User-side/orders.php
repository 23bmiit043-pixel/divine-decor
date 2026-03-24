<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include 'connect.php';
include 'functions/myfunctions.php';

$customer_id = $_SESSION['cid'];

$table_check = $con->query("SHOW TABLES LIKE 'order'");
if ($table_check->num_rows == 0) {
    die("Error: Orders table does not exist. Please contact administrator.");
}

$query = "SELECT DISTINCT od.order_details_id, od.p_price as total_amount, o.quantity, o.order_date,
          o.order_id, o.order_status
          FROM `order` o 
          JOIN order_details od ON o.order_details_id = od.order_details_id 
          WHERE o.cid = ? 
          GROUP BY od.order_details_id
          ORDER BY o.order_date DESC";
$stmt = $con->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Query failed: " . $con->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders | The Divine Decor</title>
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css?v=site-refresh-20260317-3" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
</head>
<body class="page-account">
    <?php include 'includes/nav.php'; ?>

    <section class="page-hero">
        <div class="container">
            <div class="page-hero-shell">
                <div>
                    <span class="section-kicker">Order center</span>
                    <h1>My Orders</h1>
                    <p>Track every purchase, review order status, and move into details or invoices from a cleaner account experience.</p>
                </div>
                <div class="page-hero-meta">
                    <span><?= htmlspecialchars($_SESSION['email']) ?></span>
                    <a href="shop.php" class="btn btn-white-outline">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell compact-top">
        <div class="container">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info mb-4"><?= htmlspecialchars($_SESSION['message']); ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="account-shell">
                <aside class="account-card">
                    <div class="account-avatar">
                        <i class="fas fa-box"></i>
                    </div>
                    <span class="account-meta-label">Account</span>
                    <span class="account-meta-value"><?= htmlspecialchars($_SESSION['name']) ?></span>
                    <p class="mt-3 mb-0">Stay on top of every order, from newly placed purchases to completed deliveries and invoices.</p>

                    <div class="account-nav">
                        <a href="profile.php"><i class="fas fa-id-card"></i> My Profile</a>
                        <a href="orders.php" class="active"><i class="fas fa-box"></i> My Orders</a>
                        <a href="update_pass.php"><i class="fas fa-key"></i> Update Password</a>
                    </div>
                </aside>

                <div class="premium-table-shell">
                    <div class="section-head">
                        <div>
                            <span class="section-kicker">Purchases</span>
                            <h2 class="section-title">Order history</h2>
                        </div>
                    </div>

                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <?php
                                    $statusClass = $row['order_status'] === 'Completed'
                                        ? 'is-success'
                                        : ($row['order_status'] === 'Pending' ? 'is-warning' : 'is-muted');
                                    ?>
                                    <tr>
                                        <td data-label="Order">#<?= (int) $row['order_details_id'] ?></td>
                                        <td data-label="Quantity"><?= (int) $row['quantity'] ?></td>
                                        <td data-label="Date"><?= date("d M Y", strtotime($row['order_date'])) ?></td>
                                        <td data-label="Total">&#8377;<?= number_format((float) $row['total_amount'], 2) ?></td>
                                        <td data-label="Status">
                                            <span class="trust-pill <?= $statusClass ?>"><?= htmlspecialchars($row['order_status']) ?></span>
                                        </td>
                                        <td data-label="Action">
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="order_details.php?order_id=<?= (int) $row['order_id'] ?>" class="btn btn-primary btn-sm">View Details</a>
                                                <?php if ($row['order_status'] === 'Pending'): ?>
                                                    <button class="btn btn-outline-dark btn-sm cancel-order" data-order-id="<?= (int) $row['order_id'] ?>">Cancel</button>
                                                <?php endif; ?>
                                                <?php if ($row['order_status'] === 'Completed'): ?>
                                                    <a href="generate_invoice.php?order_id=<?= (int) $row['order_id'] ?>" class="btn btn-secondary btn-sm">Invoice</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">No orders found yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
    <script>
        document.querySelectorAll('.cancel-order').forEach(function (button) {
            button.addEventListener('click', function () {
                if (!confirm('Are you sure you want to cancel this order?')) {
                    return;
                }

                fetch('functions/cancel_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'order_id=' + encodeURIComponent(button.dataset.orderId)
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    alert('An error occurred while cancelling the order');
                });
            });
        });
    </script>
</body>
</html>
