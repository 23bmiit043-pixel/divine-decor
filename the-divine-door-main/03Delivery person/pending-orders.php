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

$delivery_id = (int) $_SESSION['delivery_id'];
$today = date('Y-m-d');
$flashMessage = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$count_query = "
    SELECT
        COUNT(DISTINCT CASE WHEN o.order_status = 'Pending' THEN od.order_details_id END) AS pending_count,
        COUNT(DISTINCT CASE WHEN o.order_status = 'Pending' AND DATE(o.order_date) = '$today' THEN od.order_details_id END) AS today_pending
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    WHERE od.delivery_person_id = '$delivery_id'
";
$count_result = mysqli_query($con, $count_query);
$count_data = $count_result ? mysqli_fetch_assoc($count_result) : [];
$pendingCount = (int) ($count_data['pending_count'] ?? 0);
$todayPending = (int) ($count_data['today_pending'] ?? 0);

$orders_query = "
    SELECT DISTINCT
        od.order_details_id,
        o.order_date,
        c.C_name,
        c.Address,
        od.quantity,
        od.p_price AS order_amount,
        o.order_status
    FROM order_details od
    JOIN `order` o ON o.order_details_id = od.order_details_id
    JOIN customer c ON o.cid = c.Cid
    WHERE od.delivery_person_id = '$delivery_id'
    AND o.order_status = 'Pending'
    GROUP BY od.order_details_id
    ORDER BY o.order_date DESC
";
$orders_result = mysqli_query($con, $orders_query);

$page_title = 'Pending Orders';
$page_label = 'Pending Orders';
include('includes/header.php');
?>

<section class="delivery-hero">
    <div>
        <span class="delivery-eyebrow">Open delivery queue</span>
        <h1>Pending orders</h1>
        <p>Review the remaining handoffs assigned to you, confirm addresses at a glance, and mark each fulfilled order without leaving the delivery workspace.</p>
    </div>

    <div class="delivery-hero-actions">
        <span class="delivery-meta-pill"><i class="fa-solid fa-hourglass-half"></i><?= $pendingCount ?> pending</span>
        <span class="delivery-meta-pill"><i class="fa-solid fa-calendar-day"></i><?= $todayPending ?> from today</span>
        <a href="completed-orders.php" class="btn btn-outline-light">View completed</a>
    </div>
</section>

<div class="row g-4 mt-1">
    <div class="col-12">
        <section class="delivery-section-card">
            <div class="section-card-header">
                <div>
                    <span class="delivery-section-chip"><i class="fa-solid fa-route"></i>Assigned queue</span>
                    <h2 class="delivery-section-heading">Orders waiting for completion</h2>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($orders_result)): ?>
                                    <tr>
                                        <td>
                                            <span class="delivery-table-title">#<?= (int) $row['order_details_id'] ?></span>
                                            <span class="delivery-table-subtitle">Pending confirmation</span>
                                        </td>
                                        <td><?= htmlspecialchars($row['C_name']) ?></td>
                                        <td><?= htmlspecialchars($row['Address']) ?></td>
                                        <td>&#8377;<?= number_format((float) $row['order_amount'], 2) ?></td>
                                        <td><?= (int) $row['quantity'] ?></td>
                                        <td><?= date('d M Y', strtotime($row['order_date'])) ?></td>
                                        <td>
                                            <form action="update_order.php" method="POST" class="delivery-inline-form">
                                                <input type="hidden" name="order_details_id" value="<?= (int) $row['order_details_id'] ?>">
                                                <button type="submit" name="mark_completed" class="btn btn-primary btn-sm">
                                                    Mark as completed
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="delivery-empty-state">
                        <i class="fa-solid fa-circle-check mb-3 fs-3"></i>
                        <p class="mb-0">No pending orders are assigned to you right now. Fresh assignments will appear here automatically.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php include('includes/footer.php'); ?>
