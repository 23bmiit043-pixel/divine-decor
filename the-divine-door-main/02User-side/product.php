<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connect.php';
include 'functions/myfunctions.php';

$assetBase = '/The-Divine-Decor/the-divine-door-main/02User-side';
$galleryBase = '/The-Divine-Decor/the-divine-door-main/gallery';
$assetVersion = 'site-refresh-20260317-6';

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sub_category_id = isset($_GET['subcategory']) ? (int) $_GET['subcategory'] : 0;

if ($product_id <= 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Invalid product request.</div></div>";
    exit();
}

if ($sub_category_id > 0) {
    $subCategoryProducts = getProductsBySubCategory($sub_category_id);
    if (!$subCategoryProducts || mysqli_num_rows($subCategoryProducts) === 0) {
        echo "<div class='container mt-5'><div class='alert alert-warning'>No products are available in this sub-category.</div></div>";
        exit();
    }
}

$product = getProductById($product_id);

if (!$product || mysqli_num_rows($product) === 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Product not found.</div></div>";
    exit();
}

$item = mysqli_fetch_assoc($product);

if ((int) $item['quantity'] <= 0) {
    header('Location: out_of_stock.php?id=' . (int) $item['pid']);
    exit();
}

if ($sub_category_id > 0 && (int) $item['sub_category_id'] !== $sub_category_id) {
    header('Location: shop.php');
    exit();
}

$relatedProducts = $sub_category_id > 0
    ? getProductsBySubCategory($sub_category_id, $item['pid'])
    : getRelatedProducts($item['pid'], $item['sub_category_id']);

$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$currentUrlEncoded = urlencode($currentUrl);
$shareText = urlencode('Check out ' . $item['p_name'] . ' on The Divine Decor');
$imageUrl = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/gallery/' . $item['p_image']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?= htmlspecialchars($item['p_name']) ?> at The Divine Decor.">
  <link rel="shortcut icon" href="<?= $assetBase ?>/favicon.png">
  <link href="<?= $assetBase ?>/css/bootstrap.min.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/tiny-slider.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/style.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/premium.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <title><?= htmlspecialchars($item['p_name']) ?> | The Divine Decor</title>
</head>
<body class="page-product">
  <?php include 'includes/nav.php'; ?>

  <section class="page-hero">
    <div class="container">
      <div class="page-hero-shell">
        <div>
          <span class="section-kicker"><?= htmlspecialchars($item['category_name'] ?: 'Signature collection') ?></span>
          <h1><?= htmlspecialchars($item['p_name']) ?></h1>
          <p>Clean product storytelling, stronger mobile layout, and smoother add-to-cart behavior now shape the entire detail page experience.</p>
        </div>
        <div class="page-hero-meta">
          <span><?= (int) $item['quantity'] ?> in stock</span>
          <a href="shop.php" class="btn btn-white-outline">Back to shop</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="breadcrumb-shell">
        <a href="index.php">Home</a>
        <span>/</span>
        <a href="shop.php">Shop</a>
        <?php if (!empty($item['category_name'])): ?>
          <span>/</span>
          <a href="shop.php?category=<?= (int) $item['category_id'] ?>"><?= htmlspecialchars($item['category_name']) ?></a>
        <?php endif; ?>
        <?php if (!empty($item['sub_category_name'])): ?>
          <span>/</span>
          <a href="shop.php?category=<?= (int) $item['category_id'] ?>&subcategory=<?= (int) $item['sub_category_id'] ?>"><?= htmlspecialchars($item['sub_category_name']) ?></a>
        <?php endif; ?>
      </div>

      <div class="product-detail-shell">
        <div class="product-gallery-panel">
          <div class="product-image-stage">
            <img src="<?= $galleryBase ?>/<?= htmlspecialchars($item['p_image']) ?>" alt="<?= htmlspecialchars($item['p_name']) ?>">
          </div>
          <div class="product-assurance-strip">
            <span class="trust-pill">Premium finish</span>
            <span class="trust-pill">Secure checkout</span>
            <span class="trust-pill">Carefully curated</span>
          </div>
        </div>

        <div class="product-summary">
          <span class="section-kicker"><?= htmlspecialchars($item['sub_category_name'] ?: 'Curated decor') ?></span>
          <h1><?= htmlspecialchars($item['p_name']) ?></h1>
          <div class="product-price">&#8377;<?= number_format((float) $item['p_price'], 2) ?></div>
          <p class="product-summary-copy"><?= nl2br(htmlspecialchars($item['p_description'])) ?></p>

          <form id="addToCartForm" class="product-form">
            <div class="quantity-field">
              <label for="productQuantity" class="mb-2 fw-bold">Quantity</label>
              <input id="productQuantity" class="form-control text-center" type="number" name="quantity" value="1" min="1" max="<?= (int) $item['quantity'] ?>">
            </div>
            <input type="hidden" name="pid" value="<?= (int) $item['pid'] ?>">
            <div class="product-form-actions">
              <button class="btn btn-primary" type="submit">Add to Cart</button>
              <a href="cart.php" class="btn btn-outline-dark">View Cart</a>
            </div>
          </form>

          <div id="alertMessage" class="form-feedback" style="display:none;"></div>

          <div class="product-meta-grid">
            <div class="product-meta-card">
              <span>Availability</span>
              <strong><?= (int) $item['quantity'] > 5 ? 'Ready to ship' : 'Limited stock' ?></strong>
            </div>
            <div class="product-meta-card">
              <span>Category</span>
              <strong><?= htmlspecialchars($item['category_name'] ?: 'Decor') ?></strong>
            </div>
            <div class="product-meta-card">
              <span>Sub-category</span>
              <strong><?= htmlspecialchars($item['sub_category_name'] ?: 'Signature edit') ?></strong>
            </div>
          </div>

          <div class="share-links">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $currentUrlEncoded ?>" target="_blank" rel="noreferrer" aria-label="Share on Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?= $shareText ?>&url=<?= $currentUrlEncoded ?>" target="_blank" rel="noreferrer" aria-label="Share on Twitter">
              <i class="fab fa-x-twitter"></i>
            </a>
            <a href="https://pinterest.com/pin/create/button/?url=<?= $currentUrlEncoded ?>&media=<?= $imageUrl ?>&description=<?= $shareText ?>" target="_blank" rel="noreferrer" aria-label="Share on Pinterest">
              <i class="fab fa-pinterest-p"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text=<?= $shareText ?>%20<?= $currentUrlEncoded ?>" target="_blank" rel="noreferrer" aria-label="Share on WhatsApp">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell soft">
    <div class="container">
      <div class="section-head">
        <div>
          <span class="section-kicker">Recommended next</span>
          <h2 class="section-title">Related products</h2>
        </div>
        <a href="shop.php" class="btn btn-outline-dark">Continue shopping</a>
      </div>

      <div class="row g-4">
        <?php if ($relatedProducts && mysqli_num_rows($relatedProducts) > 0): ?>
          <?php while ($relatedItem = mysqli_fetch_assoc($relatedProducts)): ?>
            <div class="col-12 col-sm-6 col-lg-3">
              <article class="store-card">
                <a class="store-card-media" href="product.php?id=<?= (int) $relatedItem['pid'] ?>">
                  <img src="<?= $galleryBase ?>/<?= htmlspecialchars($relatedItem['p_image']) ?>" alt="<?= htmlspecialchars($relatedItem['p_name']) ?>">
                </a>
                <div class="store-card-body">
                  <div class="store-card-topline">
                    <span class="store-card-chip"><?= htmlspecialchars($relatedItem['sub_category_name'] ?? 'Related pick') ?></span>
                  </div>
                  <a class="store-card-title" href="product.php?id=<?= (int) $relatedItem['pid'] ?>"><?= htmlspecialchars($relatedItem['p_name']) ?></a>
                  <p class="store-card-copy">A polished companion piece selected from the same design family.</p>
                  <div class="store-card-footer">
                    <div>
                      <span class="store-card-price">&#8377;<?= number_format((float) $relatedItem['p_price'], 2) ?></span>
                      <span class="store-card-caption">Complete the look</span>
                    </div>
                  </div>
                  <div class="store-card-actions">
                    <a class="btn btn-primary" href="product.php?id=<?= (int) $relatedItem['pid'] ?>">View details</a>
                  </div>
                </div>
              </article>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="empty-state-card">
              <h3 class="mb-3">No related products yet</h3>
              <p class="mb-0">As the catalog grows, complementary recommendations will appear here.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php include 'feedback.php'; ?>
  <?php include 'includes/footer.php'; ?>

  <script src="<?= $assetBase ?>/js/bootstrap.bundle.min.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/tiny-slider.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/custom.js?v=<?= $assetVersion ?>"></script>
  <script>
    document.getElementById('addToCartForm').addEventListener('submit', function (event) {
      event.preventDefault();

      var formData = new FormData(this);
      var quantityInput = document.getElementById('productQuantity');
      var requestedQuantity = parseInt(quantityInput.value, 10);
      var maxQuantity = parseInt(quantityInput.getAttribute('max'), 10);
      var alertMessage = document.getElementById('alertMessage');

      if (requestedQuantity > maxQuantity) {
        alertMessage.style.display = 'block';
        alertMessage.className = 'form-feedback is-error';
        alertMessage.textContent = 'Selected quantity exceeds available stock.';
        return;
      }

      fetch('functions/handlecart.php', {
        method: 'POST',
        body: formData
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        alertMessage.style.display = 'block';
        alertMessage.className = 'form-feedback ' + (data.status === 'success' ? 'is-success' : 'is-error');
        alertMessage.textContent = data.message;

        if (data.status === 'success') {
          window.updateCartBadge(data.cartCount);
          setTimeout(function () {
            window.location.href = 'cart.php';
          }, 1000);
        }
      })
      .catch(function (error) {
        console.error('Error:', error);
        alertMessage.style.display = 'block';
        alertMessage.className = 'form-feedback is-error';
        alertMessage.textContent = 'Something went wrong while adding this product to your cart.';
      });
    });
  </script>
</body>
</html>
