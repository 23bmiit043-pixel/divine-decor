<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header('Location: login.php');
    exit();
}

include('../config/dbcon.php');

function deliveryScalar($con, $sql, $field = 'count')
{
    $result = mysqli_query($con, $sql);
    if (!$result) {
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    return (int) ($row[$field] ?? 0);
}

function deliveryStatusClass($status)
{
    $normalized = strtolower(trim((string) $status));

    if ($normalized === 'completed') {
        return 'is-completed';
    }

    if ($normalized === 'processing') {
        return 'is-processing';
    }

    if ($normalized === 'pending') {
        return 'is-pending';
    }

    return 'is-neutral';
}

$delivery_id = (int) $_SESSION['delivery_id'];
$delivery_query = "SELECT * FROM delivery_person WHERE delivery_person_id = '$delivery_id' LIMIT 1";
$delivery_result = mysqli_query($con, $delivery_query);
$delivery_data = $delivery_result ? mysqli_fetch_assoc($delivery_result) : null;
$delivery_name = trim((string) ($delivery_data['Name'] ?? 'Delivery Partner'));
$today = date('Y-m-d');
$recentFilter = strtolower(trim((string) ($_GET['recent'] ?? 'completed')));

if (!in_array($recentFilter, ['pending', 'completed'], true)) {
    $recentFilter = 'completed';
}

$todayCount = deliveryScalar(
    $con,
    "SELECT COUNT(DISTINCT od.order_details_id) AS count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND DATE(o.order_date) = '$today'"
);

$pendingCount = deliveryScalar(
    $con,
    "SELECT COUNT(DISTINCT od.order_details_id) AS count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND o.order_status = 'Pending'"
);

$completedCount = deliveryScalar(
    $con,
    "SELECT COUNT(DISTINCT od.order_details_id) AS count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND o.order_status = 'Completed'"
);

$totalCount = deliveryScalar(
    $con,
    "SELECT COUNT(DISTINCT od.order_details_id) AS count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'"
);

$recentWeekCount = deliveryScalar(
    $con,
    "SELECT COUNT(DISTINCT od.order_details_id) AS count
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'
    AND DATE(o.order_date) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"
);

$recentFilterCondition = $recentFilter === 'pending'
    ? "o.order_status IN ('Pending', 'Processing')"
    : "o.order_status = 'Completed'";

$recentOrdersTitle = $recentFilter === 'pending' ? 'Open orders' : 'Completed orders';
$recentOrdersEmpty = $recentFilter === 'pending'
    ? 'No pending or processing orders are assigned right now. Fresh active tasks will appear here automatically.'
    : 'No completed orders are available yet. Finished deliveries will appear here once they are marked complete.';

$recent_orders_query = "
    SELECT DISTINCT
        od.order_details_id,
        o.order_date,
        c.C_name,
        od.quantity,
        od.p_price AS order_amount,
        o.order_status
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    JOIN customer c ON o.cid = c.Cid
    WHERE od.delivery_person_id = '$delivery_id'
    AND $recentFilterCondition
    GROUP BY od.order_details_id
    ORDER BY o.order_date DESC
    LIMIT 5
";
$recent_orders_result = mysqli_query($con, $recent_orders_query);
$completionRate = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

$page_title = 'Delivery Dashboard';
$page_label = 'Dashboard';
include('includes/header.php');
?>

<section class="delivery-hero">
    <div>
        <span class="delivery-eyebrow">Delivery operations</span>
        <h1>Welcome back, <?= htmlspecialchars($delivery_name) ?></h1>
        <p>Track assigned handoffs, update order outcomes quickly, and keep each customer delivery moving with the same polished feel as the admin panel.</p>
    </div>

    <div class="delivery-hero-actions">
        <span class="delivery-meta-pill"><i class="fa-solid fa-truck-fast"></i><?= $totalCount ?> total assignments</span>
        <span class="delivery-meta-pill"><i class="fa-solid fa-calendar-day"></i><?= date('d M Y') ?></span>
        <a href="pending-orders.php" class="btn btn-light">Review pending orders</a>
    </div>
</section>

<div class="row g-4 delivery-stat-grid">
    <div class="col-md-6 col-xl-3">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Today's deliveries</span>
                    <strong class="metric-value"><?= $todayCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-sun"></i></span>
            </div>
            <div class="metric-trend">Assignments dated for <?= date('d M') ?></div>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Pending orders</span>
                    <strong class="metric-value"><?= $pendingCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-hourglass-half"></i></span>
            </div>
            <div class="metric-trend warning">Needs confirmation and final delivery updates</div>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Completed orders</span>
                    <strong class="metric-value"><?= $completedCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-circle-check"></i></span>
            </div>
            <div class="metric-trend positive"><?= $completionRate ?>% completion across assigned orders</div>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="delivery-metric-card">
            <div class="metric-meta">
                <div>
                    <span class="metric-label">Recent 7-day flow</span>
                    <strong class="metric-value"><?= $recentWeekCount ?></strong>
                </div>
                <span class="metric-icon"><i class="fa-solid fa-chart-line"></i></span>
            </div>
            <div class="metric-trend">Fresh activity from the last seven days</div>
        </article>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-xl-8">
        <section class="delivery-section-card h-100">
            <div class="section-card-header">
                <div>
                    <span class="delivery-section-chip"><i class="fa-solid fa-box-open"></i>Latest assignments</span>
                    <h2 class="delivery-section-heading"><?= htmlspecialchars($recentOrdersTitle) ?></h2>
                </div>
                <div class="delivery-card-actions">
                    <a href="index.php?recent=pending" class="btn <?= $recentFilter === 'pending' ? 'btn-primary' : 'btn-outline-secondary' ?>">Pending</a>
                    <a href="index.php?recent=completed" class="btn <?= $recentFilter === 'completed' ? 'btn-primary' : 'btn-outline-secondary' ?>">Completed</a>
                </div>
            </div>

            <div class="section-card-body">
                <?php if ($recent_orders_result && mysqli_num_rows($recent_orders_result) > 0): ?>
                    <div class="delivery-table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($recent_orders_result)): ?>
                                    <tr>
                                        <td>
                                            <span class="delivery-table-title">#<?= (int) $row['order_details_id'] ?></span>
                                            <span class="delivery-table-subtitle">Assigned order record</span>
                                        </td>
                                        <td><?= htmlspecialchars($row['C_name']) ?></td>
                                        <td>&#8377;<?= number_format((float) $row['order_amount'], 2) ?></td>
                                        <td><?= (int) $row['quantity'] ?></td>
                                        <td>
                                            <span class="delivery-status-badge <?= deliveryStatusClass($row['order_status']) ?>">
                                                <?= htmlspecialchars($row['order_status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($row['order_date'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="delivery-empty-state">
                        <i class="fa-solid fa-box-open mb-3 fs-3"></i>
                        <p class="mb-0"><?= htmlspecialchars($recentOrdersEmpty) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="col-xl-4">
        <section class="delivery-section-card h-100">
            <div class="section-card-header">
                <div>
                    <span class="delivery-section-chip"><i class="fa-solid fa-star"></i>Quick summary</span>
                    <h2 class="delivery-section-heading">Daily pulse</h2>
                </div>
            </div>

            <div class="section-card-body">
                <div class="delivery-kpi-list">
                    <div class="delivery-kpi-row">
                        <span>Assigned partner</span>
                        <strong><?= htmlspecialchars($delivery_name) ?></strong>
                    </div>
                    <div class="delivery-kpi-row">
                        <span>Total deliveries</span>
                        <strong><?= $totalCount ?></strong>
                    </div>
                    <div class="delivery-kpi-row">
                        <span>Pending handoffs</span>
                        <strong><?= $pendingCount ?></strong>
                    </div>
                    <div class="delivery-kpi-row">
                        <span>Completed handoffs</span>
                        <strong><?= $completedCount ?></strong>
                    </div>
                    <div class="delivery-kpi-row">
                        <span>Completion rate</span>
                        <strong><?= $completionRate ?>%</strong>
                    </div>
                </div>

                <p class="delivery-muted-copy mt-4 mb-0">This premium delivery dashboard now mirrors the admin panel more closely, with cleaner cards, softer surfaces, and clearer order state visibility across every screen.</p>
            </div>
        </section>
    </div>
</div>

<?php include('includes/footer.php'); ?>
