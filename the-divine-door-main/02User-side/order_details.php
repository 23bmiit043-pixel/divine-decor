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

if (!isset($_GET['order_id'])) {
    header("location: orders.php");
    exit;
}

$order_id = (int) $_GET['order_id'];
$customer_id = $_SESSION['cid'];

$total_query = "SELECT SUM(p.p_price * o.quantity) as total_amount
                FROM `order` o 
                JOIN product p ON o.pid = p.pid 
                WHERE o.order_details_id = (
                    SELECT order_details_id 
                    FROM `order` 
                    WHERE order_id = ? AND cid = ?
                )";

$total_stmt = $con->prepare($total_query);
$total_stmt->bind_param("ii", $order_id, $customer_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_amount = $total_row['total_amount'];

$query = "SELECT o.*, p.p_name, p.p_price, p.p_image, p.p_description 
          FROM `order` o 
          JOIN product p ON o.pid = p.pid 
          WHERE o.order_details_id = (
              SELECT order_details_id 
              FROM `order` 
              WHERE order_id = ? AND cid = ?
          )";

$stmt = $con->prepare($query);
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("location: orders.php");
    exit;
}

$first_order = $result->fetch_assoc();
$result->data_seek(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details | The Divine Decor</title>
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
                    <span class="section-kicker">Order details</span>
                    <h1>Order #<?= (int) $first_order['order_id'] ?></h1>
                    <p>Review item details, delivery information, and the current status of this order from one cleaner summary page.</p>
                </div>
                <div class="page-hero-meta">
                    <span><?= htmlspecialchars($first_order['order_status']) ?></span>
                    <a href="orders.php" class="btn btn-white-outline">Back to Orders</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell compact-top">
        <div class="container">
            <div class="account-shell">
                <aside class="account-card">
                    <div class="account-avatar">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <span class="account-meta-label">Order date</span>
                    <span class="account-meta-value"><?= date("d M Y", strtotime($first_order['order_date'])) ?></span>
                    <p class="mt-3 mb-3">You can review delivery details here and cancel the order while it is still pending.</p>

                    <div class="summary-stack">
                        <div class="summary-row">
                            <span>Status</span>
                            <strong><?= htmlspecialchars($first_order['order_status']) ?></strong>
                        </div>
                        <div class="summary-row">
                            <span>Contact</span>
                            <strong><?= htmlspecialchars($first_order['Contact_no']) ?></strong>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <strong>&#8377;<?= number_format((float) $total_amount, 2) ?></strong>
                        </div>
                    </div>
                </aside>

                <div class="account-card">
                    <div class="section-head">
                        <div>
                            <span class="section-kicker">Delivery summary</span>
                            <h2 class="section-title">Items in this order</h2>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="mb-2"><strong>Delivery address:</strong></p>
                        <p class="mb-0"><?= htmlspecialchars($first_order['address']) ?></p>
                    </div>

                    <div class="row g-4">
                        <?php while ($product = $result->fetch_assoc()): ?>
                            <?php
                            $image_path = "../gallery/" . $product['p_image'];
                            $img_src = (!empty($product['p_image']) && file_exists($image_path))
                                ? $image_path
                                : "images/product-1.png";
                            ?>
                            <div class="col-12">
                                <article class="store-card">
                                    <div class="store-card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-3">
                                                <div class="store-card-media" style="aspect-ratio:1/1;">
                                                    <img src="<?= htmlspecialchars($img_src) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="store-card-topline mb-2">
                                                    <span class="store-card-chip">Ordered item</span>
                                                    <span class="trust-pill"><?= htmlspecialchars($first_order['order_status']) ?></span>
                                                </div>
                                                <h3 class="store-card-title"><?= htmlspecialchars($product['p_name']) ?></h3>
                                                <p class="store-card-copy"><?= htmlspecialchars($product['p_description']) ?></p>
                                                <div class="summary-stack mt-3">
                                                    <div class="summary-row">
                                                        <span>Price</span>
                                                        <strong>&#8377;<?= number_format((float) $product['p_price'], 2) ?></strong>
                                                    </div>
                                                    <div class="summary-row">
                                                        <span>Quantity</span>
                                                        <strong><?= (int) $product['quantity'] ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($first_order['order_status'] === 'Pending'): ?>
                        <div class="alert alert-info mt-4">
                            Your order is still being processed. You can cancel it while the status remains pending.
                        </div>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="orders.php" class="btn btn-outline-dark">Back to Orders</a>
                        <?php if ($first_order['order_status'] === 'Pending'): ?>
                            <button class="btn btn-primary cancel-order" data-order-id="<?= (int) $first_order['order_id'] ?>">Cancel Order</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
    <script>
        const detailCancelButton = document.querySelector('.cancel-order');
        if (detailCancelButton) {
            detailCancelButton.addEventListener('click', function () {
                if (!confirm('Are you sure you want to cancel this order?')) {
                    return;
                }

                fetch('functions/cancel_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'order_id=' + encodeURIComponent(detailCancelButton.dataset.orderId)
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (data.status === 'success') {
                        window.location.href = 'orders.php';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    alert('An error occurred while cancelling the order');
                });
            });
        }
    </script>
</body>
</html>
