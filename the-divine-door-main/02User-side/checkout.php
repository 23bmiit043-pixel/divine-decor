<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connect.php';

$assetBase = '/The-Divine-Decor/the-divine-door-main/02User-side';
$assetVersion = 'site-refresh-20260317-6';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$customerDetails = [];
$cid = (int) $_SESSION['cid'];
$query = "SELECT * FROM customer WHERE Cid = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $cid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $customerDetails = $row;
}

$firstName = '';
$lastName = '';

if (!empty($customerDetails['C_name'])) {
    $nameParts = explode(' ', $customerDetails['C_name'], 2);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
}

$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += (float) $item['price'] * (int) $item['quantity'];
}

$estimatedDate = new DateTime();
$estimatedDate->modify('+5 days');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Secure checkout at The Divine Decor.">
  <link rel="shortcut icon" href="<?= $assetBase ?>/favicon.png">
  <link href="<?= $assetBase ?>/css/bootstrap.min.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/tiny-slider.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/style.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/premium.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <title>Checkout | The Divine Decor</title>
</head>
<body class="page-checkout">
  <?php include 'includes/nav.php'; ?>

  <section class="page-hero">
    <div class="container">
      <div class="page-hero-shell">
        <div>
          <span class="section-kicker">Secure purchase</span>
          <h1>Checkout</h1>
          <p>A clearer, more premium checkout with stronger validation, cleaner payment selection, and better order visibility across devices.</p>
        </div>
        <div class="page-hero-meta">
          <span><?= count($_SESSION['cart']) ?> line item<?= count($_SESSION['cart']) === 1 ? '' : 's' ?></span>
          <span>Total &#8377;<?= number_format($subtotal, 2) ?></span>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="checkout-page-grid">
        <div class="checkout-card">
          <div class="section-head">
            <div>
              <span class="section-kicker">Billing details</span>
              <h2 class="section-title">Delivery information</h2>
            </div>
          </div>
          <p class="checkout-subtitle">We prefilled what we could to make checkout faster, while keeping your existing PHP order flow untouched.</p>

          <div id="checkoutError" class="checkout-error" style="display:none;"></div>

          <form id="checkoutForm" class="row g-4" method="POST">
            <div class="col-md-6">
              <label for="c_fname" class="mb-2 fw-bold">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_fname" name="c_fname" value="<?= htmlspecialchars($firstName) ?>">
            </div>

            <div class="col-md-6">
              <label for="c_lname" class="mb-2 fw-bold">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_lname" name="c_lname" value="<?= htmlspecialchars($lastName) ?>">
            </div>

            <div class="col-12">
              <label for="c_companyname" class="mb-2 fw-bold">Company Name</label>
              <input type="text" class="form-control" id="c_companyname" name="c_companyname" placeholder="Optional">
            </div>

            <div class="col-12">
              <label for="c_address" class="mb-2 fw-bold">Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_address" name="c_address" value="<?= isset($customerDetails['Address']) ? htmlspecialchars($customerDetails['Address']) : '' ?>" placeholder="Street address">
            </div>

            <div class="col-md-6">
              <label for="c_state_country" class="mb-2 fw-bold">City <span class="text-danger">*</span></label>
              <select class="form-select form-control" id="c_state_country" name="c_state_country" required>
                <option value="">Select City</option>
                <option value="Ahmedabad">Ahmedabad</option>
                <option value="Gandhinagar">Gandhinagar</option>
                <option value="Vadodara">Vadodara</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="c_postal_zip" class="mb-2 fw-bold">Pincode <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" value="<?= isset($customerDetails['Area_id']) ? htmlspecialchars($customerDetails['Area_id']) : '' ?>">
            </div>

            <div class="col-md-6">
              <label for="c_email_address" class="mb-2 fw-bold">Email Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_email_address" name="c_email_address" value="<?= isset($customerDetails['Email']) ? htmlspecialchars($customerDetails['Email']) : '' ?>">
            </div>

            <div class="col-md-6">
              <label for="c_phone" class="mb-2 fw-bold">Phone <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="c_phone" name="c_phone" value="<?= isset($customerDetails['Contact_no']) ? htmlspecialchars($customerDetails['Contact_no']) : '' ?>">
            </div>
          </form>
        </div>

        <aside class="checkout-summary-card">
          <h2 class="summary-title">Your order</h2>

          <div class="summary-stack">
            <?php foreach ($_SESSION['cart'] as $item): ?>
              <div class="order-line">
                <span><?= htmlspecialchars($item['name']) ?> x <?= (int) $item['quantity'] ?></span>
                <strong>&#8377;<?= number_format((float) $item['price'] * (int) $item['quantity'], 2) ?></strong>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="summary-row total mt-4">
            <span>Order total</span>
            <strong id="orderTotalAmount">&#8377;<?= number_format($subtotal, 2) ?></strong>
          </div>

          <div class="delivery-estimate">
            <strong>Estimated delivery</strong>
            <div id="estimatedDelivery"><?= $estimatedDate->format('l, F j, Y') ?></div>
            <small>Typically 5-7 business days from order placement.</small>
          </div>

          <div class="payment-stack">
            <label class="payment-method-option available" for="razorpay">
              <input type="radio" name="payment_method" id="razorpay" value="razorpay">
              <div class="payment-content">
                <i class="fas fa-shield-alt payment-icon"></i>
                <div class="payment-method-title">Razorpay</div>
                <small>UPI, cards, wallets, and secure online payments.</small>
              </div>
            </label>

            <label class="payment-method-option available" for="cod">
              <input type="radio" name="payment_method" id="cod" value="cod" checked>
              <div class="payment-content">
                <i class="fas fa-money-bill-wave payment-icon"></i>
                <div class="payment-method-title">Cash on Delivery</div>
                <small>Pay when the order reaches your doorstep.</small>
              </div>
            </label>
          </div>

          <button type="button" id="place_order" class="btn btn-primary w-100">Place Order</button>
          <a href="cart.php" class="btn btn-outline-dark w-100 mt-3">Back to Cart</a>
          <p class="summary-note">The checkout remains compatible with the existing database and PHP order placement flow.</p>
        </aside>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="<?= $assetBase ?>/js/bootstrap.bundle.min.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/tiny-slider.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/custom.js?v=<?= $assetVersion ?>"></script>
  <script>
    const RAZORPAY_KEY_ID = 'rzp_live_SQirh5HBrAk46P';
    const placeOrderButton = document.getElementById('place_order');
    const checkoutError = document.getElementById('checkoutError');

    function showCheckoutMessage(message, type) {
      checkoutError.style.display = 'block';
      checkoutError.className = 'alert alert-' + type;
      checkoutError.textContent = message;
    }

    function clearCheckoutMessage() {
      checkoutError.style.display = 'none';
      checkoutError.textContent = '';
    }

    function getOrderTotal() {
      const totalElement = document.getElementById('orderTotalAmount');
      if (!totalElement) {
        return 0;
      }

      const totalText = totalElement.textContent || '';
      const totalAmount = parseFloat(totalText.replace(/[^\d.]/g, '').trim());
      return Number.isNaN(totalAmount) ? 0 : totalAmount;
    }

    function setButtonState(isLoading) {
      placeOrderButton.disabled = isLoading;
      placeOrderButton.textContent = isLoading ? 'Processing...' : 'Place Order';
    }

    function handleOrderSuccess() {
      window.updateCartBadge(0);
      window.location.href = 'thankyou.php';
    }

    function placeOrderRequest(formData) {
      return fetch('functions/update_stock.php', {
        method: 'POST',
        body: formData
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.status !== 'success') {
          throw new Error(data.message || 'Stock update failed');
        }

        return fetch('functions/place_order.php', {
          method: 'POST',
          body: formData
        });
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.status !== 'success') {
          throw new Error(data.message || 'Failed to place order');
        }

        handleOrderSuccess();
      });
    }

    function processRazorpayPayment(formData, totalAmount) {
      const options = {
        key: RAZORPAY_KEY_ID,
        amount: Math.round(totalAmount * 100),
        currency: 'INR',
        name: 'The Divine Decor',
        description: 'Order Payment',
        prefill: {
          name: (formData.get('c_fname') || '') + ' ' + (formData.get('c_lname') || ''),
          email: formData.get('c_email_address') || '',
          contact: formData.get('c_phone') || ''
        },
        handler: function (response) {
          formData.append('razorpay_payment_id', response.razorpay_payment_id || '');
          formData.append('razorpay_order_id', response.razorpay_order_id || '');
          formData.append('razorpay_signature', response.razorpay_signature || '');

          placeOrderRequest(formData).catch(function (error) {
            showCheckoutMessage(error.message, 'danger');
            setButtonState(false);
          });
        },
        modal: {
          ondismiss: function () {
            showCheckoutMessage('Payment was cancelled before completion.', 'warning');
            setButtonState(false);
          }
        },
        theme: {
          color: '#28473e'
        }
      };

      const razorpay = new Razorpay(options);
      razorpay.open();
    }

    placeOrderButton.addEventListener('click', function () {
      clearCheckoutMessage();
      setButtonState(true);

      const form = document.getElementById('checkoutForm');
      const formData = new FormData(form);
      const requiredFields = {
        c_fname: 'First Name',
        c_lname: 'Last Name',
        c_address: 'Address',
        c_state_country: 'City',
        c_postal_zip: 'Pincode',
        c_email_address: 'Email Address',
        c_phone: 'Phone'
      };

      let isValid = true;
      let errorMessages = [];

      Object.keys(requiredFields).forEach(function (fieldId) {
        const field = document.getElementById(fieldId);
        field.classList.remove('is-invalid');

        if (!field.value.trim()) {
          field.classList.add('is-invalid');
          errorMessages.push(requiredFields[fieldId] + ' is required.');
          isValid = false;
        }
      });

      const emailField = document.getElementById('c_email_address');
      if (emailField.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
        emailField.classList.add('is-invalid');
        errorMessages.push('Please enter a valid email address.');
        isValid = false;
      }

      const phoneField = document.getElementById('c_phone');
      if (phoneField.value && !/^\d{10}$/.test(phoneField.value)) {
        phoneField.classList.add('is-invalid');
        errorMessages.push('Please enter a valid 10-digit phone number.');
        isValid = false;
      }

      const pincodeField = document.getElementById('c_postal_zip');
      if (pincodeField.value && !/^\d{6}$/.test(pincodeField.value)) {
        pincodeField.classList.add('is-invalid');
        errorMessages.push('Please enter a valid 6-digit pincode.');
        isValid = false;
      }

      if (!isValid) {
        showCheckoutMessage(errorMessages.join(' '), 'danger');
        setButtonState(false);
        return;
      }

      const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
      if (!selectedPayment) {
        showCheckoutMessage('Please select a payment method.', 'danger');
        setButtonState(false);
        return;
      }

      formData.append('payment_method', selectedPayment.value);

      if (selectedPayment.value === 'razorpay') {
        const totalAmount = getOrderTotal();

        if (totalAmount <= 0) {
          showCheckoutMessage('Invalid order total. Please review your cart and try again.', 'danger');
          setButtonState(false);
          return;
        }

        processRazorpayPayment(formData, totalAmount);
        return;
      }

      placeOrderRequest(formData)
        .catch(function (error) {
          showCheckoutMessage(error.message, 'danger');
          setButtonState(false);
        });
    });

    document.querySelectorAll('#checkoutForm input, #checkoutForm select').forEach(function (element) {
      element.addEventListener('input', function () {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
        }
      });
    });
  </script>
</body>
</html>
