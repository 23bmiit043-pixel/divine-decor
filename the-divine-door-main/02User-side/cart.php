<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connect.php';

$assetBase = '/The-Divine-Decor/the-divine-door-main/02User-side';
$galleryBase = '/The-Divine-Decor/the-divine-door-main/gallery';
$assetVersion = 'site-refresh-20260317-6';

$cartItems = [];
$total = 0;
$totalUnits = 0;
$hasStockIssues = false;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $pid => $item) {
        $query = "SELECT quantity FROM product WHERE pid = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $pid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        $availableStock = $product ? (int) $product['quantity'] : 0;
        $subtotal = (float) $item['price'] * (int) $item['quantity'];
        $total += $subtotal;
        $totalUnits += (int) $item['quantity'];

        if ($availableStock < (int) $item['quantity']) {
            $hasStockIssues = true;
        }

        $cartItems[] = [
            'pid' => (int) $pid,
            'name' => $item['name'],
            'price' => (float) $item['price'],
            'image' => $item['image'],
            'quantity' => (int) $item['quantity'],
            'subtotal' => $subtotal,
            'availableStock' => $availableStock,
        ];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Review your cart and prepare for checkout at The Divine Decor.">
  <link rel="shortcut icon" href="<?= $assetBase ?>/favicon.png">
  <link href="<?= $assetBase ?>/css/bootstrap.min.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/tiny-slider.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/style.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/premium.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <title>Cart | The Divine Decor</title>
</head>
<body class="page-cart">
  <?php include 'includes/nav.php'; ?>

  <section class="page-hero">
    <div class="container">
      <div class="page-hero-shell">
        <div>
          <span class="section-kicker">Your selection</span>
          <h1>Cart</h1>
          <p>A cleaner cart experience with better stock feedback, easier quantity updates, and more consistent checkout guidance.</p>
        </div>
        <div class="page-hero-meta">
          <span><?= count($cartItems) ?> item<?= count($cartItems) === 1 ? '' : 's' ?></span>
          <a href="shop.php" class="btn btn-white-outline">Continue shopping</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <?php if ($hasStockIssues): ?>
        <div class="alert alert-warning mb-4">
          Some items in your cart exceed current stock availability. Please adjust the quantity before proceeding to checkout.
        </div>
      <?php endif; ?>

      <?php if (!empty($cartItems)): ?>
        <div class="cart-page-grid">
          <div class="premium-table-shell">
            <table class="table cart-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cartItems as $item): ?>
                  <?php
                  $atMax = $item['availableStock'] <= 0 || $item['quantity'] >= $item['availableStock'];
                  $stockNote = $item['availableStock'] <= 0
                      ? 'Currently unavailable'
                      : ($item['availableStock'] < $item['quantity'] ? 'Only ' . $item['availableStock'] . ' available' : $item['availableStock'] . ' available');
                  ?>
                  <tr data-cart-row="<?= $item['pid'] ?>">
                    <td data-label="Product">
                      <div class="cart-product">
                        <div class="cart-product-media">
                          <img src="<?= $galleryBase ?>/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div>
                          <div class="cart-product-title"><?= htmlspecialchars($item['name']) ?></div>
                          <span class="cart-stock-note"><?= htmlspecialchars($stockNote) ?></span>
                        </div>
                      </div>
                    </td>
                    <td data-label="Price">&#8377;<span class="product-unit-price"><?= number_format($item['price'], 2) ?></span></td>
                    <td data-label="Quantity">
                      <div class="quantity-pill quantity-container">
                        <button class="decrease" type="button" data-cart-control data-pid="<?= $item['pid'] ?>">&minus;</button>
                        <input type="text" class="quantity-amount" value="<?= $item['quantity'] ?>" data-max="<?= $item['availableStock'] ?>" readonly>
                        <button class="increase" type="button" data-cart-control data-pid="<?= $item['pid'] ?>" <?= $atMax ? 'disabled' : '' ?>>&plus;</button>
                      </div>
                    </td>
                    <td data-label="Total">&#8377;<span class="product-subtotal"><?= number_format($item['subtotal'], 2) ?></span></td>
                    <td data-label="Remove">
                      <a href="#" class="remove-link remove-item" data-pid="<?= $item['pid'] ?>">Remove</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <aside class="cart-summary-card">
            <h2 class="summary-title">Order summary</h2>
            <div class="summary-stack">
              <div class="summary-row">
                <span>Distinct items</span>
                <strong><?= count($cartItems) ?></strong>
              </div>
              <div class="summary-row">
                <span>Total quantity</span>
                <strong><?= $totalUnits ?></strong>
              </div>
              <div class="summary-row total">
                <span>Total</span>
                <strong class="cart-total">&#8377;<?= number_format($total, 2) ?></strong>
              </div>
            </div>

            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button class="btn btn-primary mt-4 w-100" onclick="window.location='checkout.php'" <?= $hasStockIssues ? 'disabled' : '' ?>>Proceed to Checkout</button>
            <?php else: ?>
              <div class="alert alert-warning mt-4">Please <a href="login.php" class="alert-link">log in</a> to complete your order.</div>
              <button class="btn btn-primary w-100" onclick="window.location='login.php'">Login to Checkout</button>
            <?php endif; ?>

            <a href="shop.php" class="btn btn-outline-dark mt-3 w-100">Continue Shopping</a>
            <p class="summary-note">The cart now reflects live stock checks more clearly, helping prevent surprises during checkout.</p>
          </aside>
        </div>
      <?php else: ?>
        <div class="premium-table-shell">
          <div class="cart-empty">
            <i class="fas fa-shopping-bag"></i>
            <h2 class="summary-title">Your cart is empty</h2>
            <p class="mb-4">Start exploring the latest decor pieces and add your favorites here.</p>
            <a href="shop.php" class="btn btn-primary">Browse Products</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="<?= $assetBase ?>/js/bootstrap.bundle.min.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/tiny-slider.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/custom.js?v=<?= $assetVersion ?>"></script>
  <script>
    function updateCart(pid, action) {
      fetch('functions/updatecart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'pid=' + encodeURIComponent(pid) + '&action=' + encodeURIComponent(action)
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.status !== 'success') {
          alert(data.message);
          return;
        }

        window.updateCartBadge(data.cartCount);

        if (action === 'remove') {
          window.location.reload();
          return;
        }

        var row = document.querySelector('[data-cart-row="' + pid + '"]');
        if (!row) {
          window.location.reload();
          return;
        }

        var quantityInput = row.querySelector('.quantity-amount');
        var increaseButton = row.querySelector('.increase');
        var subtotalElement = row.querySelector('.product-subtotal');
        var totalElement = document.querySelector('.cart-total');

        quantityInput.value = data.newQuantity;
        increaseButton.disabled = data.newQuantity >= data.maxQuantity || data.maxQuantity <= 0;
        subtotalElement.textContent = data.newSubtotal;
        totalElement.textContent = '\u20B9' + data.newTotal;
      })
      .catch(function (error) {
        console.error('Error:', error);
      });
    }

    document.querySelectorAll('.increase, .decrease').forEach(function (button) {
      button.addEventListener('click', function () {
        var action = button.classList.contains('increase') ? 'increase' : 'decrease';
        updateCart(button.dataset.pid, action);
      });
    });

    document.querySelectorAll('.remove-item').forEach(function (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        updateCart(button.dataset.pid, 'remove');
      });
    });
  </script>
</body>
</html>
