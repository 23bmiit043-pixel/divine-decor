<?php
session_start();

if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'connect.php';

function fetchScalar($conn, $sql)
{
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_row()) {
        return $row[0];
    }

    return 0;
}

$page_title = 'Admin Dashboard';
$totalOrders = (int) fetchScalar($conn, "SELECT COUNT(order_id) FROM `order`");
$totalProducts = (int) fetchScalar($conn, "SELECT COUNT(pid) FROM product");
$totalCustomers = (int) fetchScalar($conn, "SELECT COUNT(Cid) FROM customer");
$totalFeedback = (int) fetchScalar($conn, "SELECT COUNT(feedback_id) FROM feedback");
$pendingOrders = (int) fetchScalar($conn, "SELECT COUNT(order_id) FROM `order` WHERE order_status = 'Pending'");
$lowStockProducts = (int) fetchScalar($conn, "SELECT COUNT(pid) FROM product WHERE quantity <= 5");
$totalRevenue = (float) fetchScalar($conn, "SELECT COALESCE(SUM(order_amount), 0) FROM `order` WHERE order_status != 'Cancelled'");
$averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

$monthlyOrdersResult = $conn->query("
    SELECT DATE_FORMAT(order_date, '%b %Y') AS month_label,
           COUNT(*) AS order_count,
           SUM(order_amount) AS revenue_total
    FROM `order`
    WHERE order_date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
    GROUP BY YEAR(order_date), MONTH(order_date)
    ORDER BY MIN(order_date) ASC
");

$monthLabels = [];
$orderCounts = [];
$monthlyRevenue = [];

if ($monthlyOrdersResult) {
    while ($row = $monthlyOrdersResult->fetch_assoc()) {
        $monthLabels[] = $row['month_label'];
        $orderCounts[] = (int) $row['order_count'];
        $monthlyRevenue[] = round((float) $row['revenue_total'], 2);
    }
}

$topProductsResult = $conn->query("
    SELECT p.p_name,
           COUNT(o.pid) AS order_count,
           p.quantity AS stock_level
    FROM `order` o
    JOIN product p ON o.pid = p.pid
    WHERE o.order_date >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
    GROUP BY o.pid, p.p_name, p.quantity
    ORDER BY order_count DESC
    LIMIT 5
");

$topProductLabels = [];
$topProductOrders = [];
$topProductStock = [];

if ($topProductsResult) {
    while ($row = $topProductsResult->fetch_assoc()) {
        $topProductLabels[] = $row['p_name'];
        $topProductOrders[] = (int) $row['order_count'];
        $topProductStock[] = (int) $row['stock_level'];
    }
}

$weeklyRevenueResult = $conn->query("
    SELECT DATE_FORMAT(order_date, '%d %b') AS day_label,
           SUM(order_amount) AS revenue_total,
           AVG(order_amount) AS average_order_value
    FROM `order`
    WHERE order_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
    GROUP BY DATE(order_date)
    ORDER BY MIN(order_date) ASC
");

$weekLabels = [];
$revenueSeries = [];
$averageOrderSeries = [];

if ($weeklyRevenueResult) {
    while ($row = $weeklyRevenueResult->fetch_assoc()) {
        $weekLabels[] = $row['day_label'];
        $revenueSeries[] = round((float) $row['revenue_total'], 2);
        $averageOrderSeries[] = round((float) $row['average_order_value'], 2);
    }
}

$engagementMonths = [];
$engagementMap = [];

$activeCustomerResult = $conn->query("
    SELECT DATE_FORMAT(order_date, '%b %Y') AS month_label,
           COUNT(DISTINCT cid) AS active_customers
    FROM `order`
    WHERE order_date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
    GROUP BY YEAR(order_date), MONTH(order_date)
    ORDER BY MIN(order_date) ASC
");

if ($activeCustomerResult) {
    while ($row = $activeCustomerResult->fetch_assoc()) {
        $engagementMap[$row['month_label']] = [
            'active_customers' => (int) $row['active_customers'],
            'feedback_count' => 0,
        ];
    }
}

$feedbackResult = $conn->query("
    SELECT DATE_FORMAT(feedback_date, '%b %Y') AS month_label,
           COUNT(feedback_id) AS feedback_count
    FROM feedback
    WHERE feedback_date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
    GROUP BY YEAR(feedback_date), MONTH(feedback_date)
    ORDER BY MIN(feedback_date) ASC
");

if ($feedbackResult) {
    while ($row = $feedbackResult->fetch_assoc()) {
        if (!isset($engagementMap[$row['month_label']])) {
            $engagementMap[$row['month_label']] = [
                'active_customers' => 0,
                'feedback_count' => 0,
            ];
        }

        $engagementMap[$row['month_label']]['feedback_count'] = (int) $row['feedback_count'];
    }
}

foreach ($engagementMap as $month => $values) {
    $engagementMonths[] = $month;
}

$activeCustomerSeries = array_map(function ($month) use ($engagementMap) {
    return $engagementMap[$month]['active_customers'];
}, $engagementMonths);

$feedbackSeries = array_map(function ($month) use ($engagementMap) {
    return $engagementMap[$month]['feedback_count'];
}, $engagementMonths);

include 'includes/header.php';
include 'includes/topbar.php';
include 'includes/sidebar.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid dashboard-shell">
      <div class="dashboard-hero">
        <div>
          <span class="admin-eyebrow">Commerce overview</span>
          <h1>Operations dashboard</h1>
          <p>Track revenue, orders, inventory, and customer activity from one cleaner workspace designed to feel more premium and easier to scan.</p>
        </div>
        <div class="dashboard-actions">
          <a href="product.php" class="btn btn-light">Manage Products</a>
          <a href="report.php" class="btn btn-outline-light">View Reports</a>
        </div>
      </div>

      <div class="row metric-grid">
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Orders</span>
                <strong class="metric-value"><?= number_format($totalOrders) ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-bag-shopping"></i></span>
            </div>
            <div class="metric-trend positive"><?= number_format($pendingOrders) ?> pending for action</div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Revenue</span>
                <strong class="metric-value">&#8377;<?= number_format($totalRevenue, 2) ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-wallet"></i></span>
            </div>
            <div class="metric-trend positive">Avg. order value &#8377;<?= number_format($averageOrderValue, 2) ?></div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Products</span>
                <strong class="metric-value"><?= number_format($totalProducts) ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
            </div>
            <div class="metric-trend warning"><?= number_format($lowStockProducts) ?> low-stock products</div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Customers</span>
                <strong class="metric-value"><?= number_format($totalCustomers) ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-users"></i></span>
            </div>
            <div class="metric-trend">Customer base overview</div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Feedback</span>
                <strong class="metric-value"><?= number_format($totalFeedback) ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-comment-dots"></i></span>
            </div>
            <div class="metric-trend">Signals from customer reviews</div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="admin-metric-card">
            <div class="metric-meta">
              <div>
                <span class="metric-label">Store health</span>
                <strong class="metric-value"><?= $lowStockProducts === 0 ? 'Stable' : 'Watch' ?></strong>
              </div>
              <span class="metric-icon"><i class="fa-solid fa-gauge-high"></i></span>
            </div>
            <div class="metric-trend"><?= $pendingOrders > 0 ? 'Orders and stock need attention' : 'No urgent issues right now' ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid dashboard-shell">
      <div class="row">
        <div class="col-lg-8 mb-4">
          <div class="card admin-chart-card">
            <div class="card-header">
              <h3 class="card-title">Monthly orders</h3>
            </div>
            <div class="card-body">
              <canvas id="orderChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-4">
          <div class="card admin-panel-card">
            <div class="card-header">
              <h3 class="card-title">Store health</h3>
            </div>
            <div class="card-body">
              <div class="admin-status-list">
                <div class="admin-status-row">
                  <span>Pending orders</span>
                  <strong><?= number_format($pendingOrders) ?></strong>
                </div>
                <div class="admin-status-row">
                  <span>Low-stock products</span>
                  <strong><?= number_format($lowStockProducts) ?></strong>
                </div>
                <div class="admin-status-row">
                  <span>Total customers</span>
                  <strong><?= number_format($totalCustomers) ?></strong>
                </div>
                <div class="admin-status-row">
                  <span>Feedback received</span>
                  <strong><?= number_format($totalFeedback) ?></strong>
                </div>
                <div class="admin-status-row">
                  <span>Average order value</span>
                  <strong>&#8377;<?= number_format($averageOrderValue, 2) ?></strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card admin-chart-card">
            <div class="card-header">
              <h3 class="card-title">Top products</h3>
            </div>
            <div class="card-body">
              <canvas id="productChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-4">
          <div class="card admin-chart-card">
            <div class="card-header">
              <h3 class="card-title">Revenue overview</h3>
            </div>
            <div class="card-body">
              <canvas id="revenueChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card admin-chart-card">
            <div class="card-header">
              <h3 class="card-title">Customer engagement</h3>
            </div>
            <div class="card-body">
              <canvas id="customerChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-4">
          <div class="card admin-panel-card">
            <div class="card-header">
              <h3 class="card-title">Quick actions</h3>
            </div>
            <div class="card-body">
              <a href="product.php" class="admin-shortcut">Add or update products</a>
              <a href="order.php" class="admin-shortcut">Review current orders</a>
              <a href="payment.php" class="admin-shortcut">Verify payment activity</a>
              <a href="registerd.php" class="admin-shortcut">Review customer accounts</a>
              <a href="deliveryperson.php" class="admin-shortcut">Manage delivery team</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'script.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const currencyFormatter = new Intl.NumberFormat('en-IN', {
  minimumFractionDigits: 0,
  maximumFractionDigits: 0
});

const orderChartEl = document.getElementById('orderChart');
if (orderChartEl) {
  new Chart(orderChartEl, {
    type: 'line',
    data: {
      labels: <?= json_encode($monthLabels) ?>,
      datasets: [
        {
          label: 'Orders',
          data: <?= json_encode($orderCounts) ?>,
          borderColor: '#24483d',
          backgroundColor: 'rgba(36, 72, 61, 0.12)',
          fill: true,
          tension: 0.35
        },
        {
          label: 'Revenue',
          data: <?= json_encode($monthlyRevenue) ?>,
          borderColor: '#b48a59',
          backgroundColor: 'rgba(180, 138, 89, 0.12)',
          fill: false,
          tension: 0.35,
          yAxisID: 'y1'
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        },
        y1: {
          beginAtZero: true,
          position: 'right',
          grid: {
            drawOnChartArea: false
          }
        }
      }
    }
  });
}

const productChartEl = document.getElementById('productChart');
if (productChartEl) {
  new Chart(productChartEl, {
    type: 'bar',
    data: {
      labels: <?= json_encode($topProductLabels) ?>,
      datasets: [
        {
          label: 'Orders',
          data: <?= json_encode($topProductOrders) ?>,
          backgroundColor: 'rgba(36, 72, 61, 0.78)',
          borderRadius: 10
        },
        {
          label: 'Stock',
          data: <?= json_encode($topProductStock) ?>,
          type: 'line',
          borderColor: '#ad5848',
          backgroundColor: 'rgba(173, 88, 72, 0.18)',
          tension: 0.35
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
}

const revenueChartEl = document.getElementById('revenueChart');
if (revenueChartEl) {
  new Chart(revenueChartEl, {
    type: 'line',
    data: {
      labels: <?= json_encode($weekLabels) ?>,
      datasets: [
        {
          label: 'Revenue',
          data: <?= json_encode($revenueSeries) ?>,
          borderColor: '#24483d',
          backgroundColor: 'rgba(36, 72, 61, 0.12)',
          fill: true,
          tension: 0.35
        },
        {
          label: 'Average Order Value',
          data: <?= json_encode($averageOrderSeries) ?>,
          borderColor: '#b48a59',
          backgroundColor: 'rgba(180, 138, 89, 0.12)',
          fill: false,
          borderDash: [6, 6],
          tension: 0.35
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              return context.dataset.label + ': Rs ' + currencyFormatter.format(context.parsed.y);
            }
          }
        }
      }
    }
  });
}

const customerChartEl = document.getElementById('customerChart');
if (customerChartEl) {
  new Chart(customerChartEl, {
    type: 'bar',
    data: {
      labels: <?= json_encode($engagementMonths) ?>,
      datasets: [
        {
          label: 'Active Customers',
          data: <?= json_encode($activeCustomerSeries) ?>,
          backgroundColor: 'rgba(180, 138, 89, 0.74)',
          borderRadius: 10
        },
        {
          label: 'Feedback Volume',
          data: <?= json_encode($feedbackSeries) ?>,
          backgroundColor: 'rgba(36, 72, 61, 0.72)',
          borderRadius: 10
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
}
</script>

<?php include 'includes/footer.php'; ?>
