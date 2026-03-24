<?php
session_start();

if (!isset($_SESSION['last_order'])) {
    header('Location: shop.php');
    exit();
}

$lastOrder = $_SESSION['last_order'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Order confirmation from The Divine Decor.">
  <link rel="shortcut icon" href="/The-Divine-Decor/the-divine-door-main/02User-side/favicon.png">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/tiny-slider.css" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
  <title>Thank You | The Divine Decor</title>
</head>
<body>
  <?php include 'includes/nav.php'; ?>

  <section class="page-hero">
    <div class="container">
      <div class="page-hero-shell">
        <div>
          <span class="section-kicker">Order confirmed</span>
          <h1>Thank you for your order.</h1>
          <p>Your purchase was placed successfully. We have saved a summary below so you can review what was ordered and where it will be delivered.</p>
        </div>
        <div class="page-hero-meta">
          <span>Order #<?= isset($lastOrder['order_details_id']) ? (int) $lastOrder['order_details_id'] : 0 ?></span>
          <a href="shop.php" class="btn btn-white-outline">Back to Shop</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="account-shell">
        <aside class="account-card">
          <div class="account-avatar">
            <i class="fas fa-check"></i>
          </div>
          <span class="account-meta-label">Order placed</span>
          <span class="account-meta-value">
            <?php
              if (isset($lastOrder['order_date'])) {
                  echo date('d M Y', strtotime($lastOrder['order_date']));
              } else {
                  echo 'N/A';
              }
            ?>
          </span>
          <p class="mt-3 mb-3">We will use the contact details below to keep you updated as your order moves through fulfillment.</p>

          <div class="summary-stack">
            <div class="summary-row">
              <span>Contact</span>
              <strong><?= !empty($lastOrder['contact']) ? htmlspecialchars($lastOrder['contact']) : 'N/A' ?></strong>
            </div>
            <div class="summary-row">
              <span>Delivery address</span>
              <strong><?= !empty($lastOrder['address']) ? htmlspecialchars($lastOrder['address']) : 'N/A' ?></strong>
            </div>
            <div class="summary-row total">
              <span>Total</span>
              <strong>&#8377;<?= number_format((float) ($lastOrder['total_amount'] ?? 0), 2) ?></strong>
            </div>
          </div>
        </aside>

        <div class="account-card">
          <div class="section-head">
            <div>
              <span class="section-kicker">Order summary</span>
              <h2 class="section-title">Items ordered</h2>
            </div>
          </div>

          <div class="premium-table-shell p-0 shadow-none border-0 bg-transparent">
            <table class="table cart-table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($lastOrder['items'] as $item): ?>
                  <tr>
                    <td data-label="Item"><?= htmlspecialchars($item['name']) ?></td>
                    <td data-label="Quantity"><?= (int) $item['quantity'] ?></td>
                    <td data-label="Price">&#8377;<?= number_format((float) $item['price'], 2) ?></td>
                    <td data-label="Total">&#8377;<?= number_format((float) $item['price'] * (int) $item['quantity'], 2) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
            <a href="orders.php" class="btn btn-outline-dark">View My Orders</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  unset($_SESSION['last_order']);
  include 'includes/footer.php';
  ?>

  <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
  <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/tiny-slider.js"></script>
  <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
</body>
</html>
