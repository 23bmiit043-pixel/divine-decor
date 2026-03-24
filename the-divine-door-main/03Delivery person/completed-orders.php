<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header('Location: login.php');
    exit();
}

include('../config/dbcon.php');

function deliveryAlertClass($message)
{
    $message = strtolower((string) $message);

    if (strpos($message, 'error') !== false || strpos($message, 'wrong') !== false || strpos($message, 'failed') !== false) {
        return 'is-error';
    }

    return 'is-success';
}

function paymentBadgeClass($status)
{
    $status = strtolower(trim((string) $status));

    if ($status === 'paid') {
        return 'is-paid';
    }

    if ($status === 'pending' || $status === '') {
        return 'is-unpaid';
    }

    return 'is-neutral';
}

$delivery_id = (int) $_SESSION['delivery_id'];
$flashMessage = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$count_query = "
    SELECT
        COUNT(DISTINCT od.order_details_id) AS completed_count,
        COUNT(DISTINCT CASE WHEN p.payment_status = 'Paid' THEN od.order_details_id END) AS paid_count,
        COUNT(DISTINCT CASE WHEN p.payment_status = 'Pending' OR p.payment_status IS NULL THEN od.order_details_id END) AS unpaid_count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    LEFT JOIN payment p ON o.order_id = p.order_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND o.order_status = 'Completed'
";
$count_result = mysqli_query($con, $count_query);
$count_data = $count_result ? mysqli_fetch_assoc($count_result) : [];
$completedCount = (int) ($count_data['completed_count'] ?? 0);
$paidCount = (int) ($count_data['paid_count'] ?? 0);
$unpaidCount = (int) ($count_data['unpaid_count'] ?? 0);

$orders_query = "
    SELECT DISTINCT
        od.order_details_id,
        o.order_date,
        c.C_name,
        c.Address,
        od.quantity,
        od.p_price AS order_amount,
        o.order_status,
        p.payment_status
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    JOIN customer c ON o.cid = c.Cid
    LEFT JOIN payment p ON o.order_id = p.order_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND o.order_status = 'Completed'
    GROUP BY od.order_details_id
    ORDER BY o.order_date DESC
";
$orders_result = mysqli_query($con, $orders_query);

$page_title = 'Completed Orders';
$page_label = 'Completed Orders';
include('includes/header.php');
?>

<section class="delivery-hero">
    <div>
        <span class="delivery-eyebrow">Closed handoffs</span>
        <h1>Completed orders</h1>
        <p>Keep finished deliveries polished too. This view tracks fulfilled assignments, payment follow-up, and the orders that still need a final paid confirmation.</p>
    </div>

    <div class="delivery-hero-actions">
        <span class="delivery-meta-pill"><i class="fa-solid fa-circle-check"></i><?= $completedCount ?> completed</span>
        <span class="delivery-meta-pill"><i class="fa-solid fa-wallet"></i><?= $paidCount ?> paid</span>
        <a href="pending-orders.php" class="btn btn-outline-light">Open pending queue</a>
    </div>
</section>

<div class="row g-4 delivery-stat-grid">
    <div class="col-md-6 col-xl-4">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Completed orders</span>
                    <strong class="metric-value"><?= $completedCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-box"></i></span>
            </div>
            <div class="metric-trend positive">Deliveries already closed successfully</div>
        </article>
    </div>

    <div class="col-md-6 col-xl-4">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Paid orders</span>
                    <strong class="metric-value"><?= $paidCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-credit-card"></i></span>
            </div>
            <div class="metric-trend positive">Payments confirmed and settled</div>
        </article>
    </div>

    <div class="col-md-6 col-xl-4">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Awaiting payment</span>
                    <strong class="metric-value"><?= $unpaidCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-receipt"></i></span>
            </div>
            <div class="metric-trend warning">Ready for one-tap payment updates</div>
        </article>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-12">
        <section class="delivery-section-card">
            <div class="section-card-header">
                <div>
                    <span class="delivery-section-chip"><i class="fa-solid fa-check-double"></i>Completed queue</span>
                    <h2 class="delivery-section-heading">Finished deliveries</h2>
                </div>
            </div>

            <div class="section-card-body">
                <?php if ($flashMessage !== ''): ?>
                    <div class="delivery-alert <?= deliveryAlertClass($flashMessage) ?>">
                        <i class="fa-solid fa-circle-info"></i>
                        <span><?= htmlspecialchars($flashMessage) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($orders_result && mysqli_num_rows($orders_result) > 0): ?>
                    <div class="delivery-table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($orders_result)): ?>
                                    <?php $paymentStatus = trim((string) ($row['payment_status'] ?? 'Pending')); ?>
                                    <tr>
                                        <td>
                                            <span class="delivery-table-title">#<?= (int) $row['order_details_id'] ?></span>
                                            <span class="delivery-table-subtitle">Completed handoff</span>
                                        </td>
                                        <td><?= htmlspecialchars($row['C_name']) ?></td>
                                        <td><?= htmlspecialchars($row['Address']) ?></td>
                                        <td>&#8377;<?= number_format((float) $row['order_amount'], 2) ?></td>
                                        <td><?= (int) $row['quantity'] ?></td>
                                        <td><?= date('d M Y', strtotime($row['order_date'])) ?></td>
                                        <td>
                                            <span class="delivery-status-badge <?= paymentBadgeClass($paymentStatus) ?>">
                                                <?= htmlspecialchars($paymentStatus) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (strcasecmp($paymentStatus, 'Pending') === 0): ?>
                                                <form action="update_payment.php" method="POST" class="delivery-inline-form">
                                                    <input type="hidden" name="order_details_id" value="<?= (int) $row['order_details_id'] ?>">
                                                    <button type="submit" name="mark_paid" class="btn btn-primary btn-sm">
                                                        Mark as paid
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="delivery-status-badge is-paid">Settled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="delivery-empty-state">
                        <i class="fa-solid fa-box-open mb-3 fs-3"></i>
                        <p class="mb-0">No completed orders are available yet. When deliveries are marked finished, they will move into this history view.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php include('includes/footer.php'); ?>
