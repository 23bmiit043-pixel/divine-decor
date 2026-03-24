<?php
session_start();
include 'connect.php';
include 'functions/myfunctions.php';

$categories = [];
$categoryQuery = getAll('category');

if ($categoryQuery) {
    while ($row = mysqli_fetch_assoc($categoryQuery)) {
        // Exclude specific categories from display
        if (!in_array($row['category_id'], [16, 17])) {
            $categories[] = $row;
        }
    }
}

$productCountResult = getAllActive('product');
$productCount = $productCountResult ? mysqli_num_rows($productCountResult) : 0;
$popularProductsResult = getMostPurchasedProducts();
$popularProducts = [];

if ($popularProductsResult) {
    while ($row = mysqli_fetch_assoc($popularProductsResult)) {
        $popularProducts[] = $row;
    }
}

$featuredCategories = array_slice($categories, 0, 3);
$primaryCategory = $featuredCategories[0] ?? null;
$secondaryCategory = $featuredCategories[1] ?? null;
$tertiaryCategory = $featuredCategories[2] ?? null;
$quaternaryCategory = $categories[3] ?? null;
$heroProduct = null;

foreach ($popularProducts as $candidateProduct) {
    if ((int) ($candidateProduct['quantity'] ?? 0) > 0) {
        $heroProduct = $candidateProduct;
        break;
    }
}

if ($heroProduct === null && !empty($popularProducts)) {
    $heroProduct = $popularProducts[0];
}

$categoryImages = [
    'images/img-grid-1.jpg',
    'images/img-grid-2.jpg',
    'images/img-grid-3.jpg',
    'images/why-choose-us-img.jpg',
];

$marqueeItems = [
    'Premium interiors',
    'Curated decor',
    'Modern living',
    'Artful accents',
    'Signature collections',
];

$assetBase = '/The-Divine-Decor/the-divine-door-main/02User-side';
$assetVersion = 'site-refresh-20260317-20';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Premium home decor and curated lifestyle pieces from The Divine Decor.">
  <link rel="shortcut icon" href="<?= $assetBase ?>/favicon.png">
  <link href="<?= $assetBase ?>/css/bootstrap.min.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/tiny-slider.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/style.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/premium.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <title>The Divine Decor</title>
</head>
<body class="page-home">
  <?php include 'includes/nav.php'; ?>

  <section class="home-hero">
    <div class="container">
      <div class="home-hero-shell">
        <div class="home-hero-copy">
          <span class="section-kicker">Curated luxury for modern homes</span>
          <h1 class="home-hero-title">Elevated interiors that feel timeless.</h1>
          <p class="home-hero-text">
            Discover statement decor, thoughtful furniture accents, and premium essentials designed to give your home the polished calm of a boutique showroom.
          </p>
          <div class="home-hero-pills">
            <span class="trust-pill is-success"><i class="fas fa-circle-check"></i> Curated premium catalog</span>
            <span class="trust-pill"><i class="fas fa-layer-group"></i> <?= count($categories) ?> live collections</span>
            <span class="trust-pill is-warning"><i class="fas fa-sparkles"></i> Smooth modern shopping flow</span>
          </div>
          <div class="home-hero-actions">
            <a href="shop.php" class="btn btn-primary">Shop Collection</a>
            <a href="#home-categories" class="btn btn-white-outline">Browse Categories</a>
          </div>
          <div class="home-hero-stats">
            <div class="home-hero-stat">
              <strong><?= $productCount ?>+</strong>
              <span>Products</span>
            </div>
            <div class="home-hero-stat">
              <strong><?= count($categories) ?>+</strong>
              <span>Collections</span>
            </div>
            <div class="home-hero-stat">
              <strong>24H</strong>
              <span>Fast dispatch</span>
            </div>
          </div>
        </div>

        <div class="home-hero-visual">
          <div class="home-gallery">
            <div class="home-gallery-card is-large">
              <img src="<?= $assetBase ?>/images/img-grid-1.jpg" alt="Curated living room decor">
            </div>
            <div class="home-gallery-card">
              <img src="<?= $assetBase ?>/images/img-grid-2.jpg" alt="Premium accent furniture">
            </div>
            <div class="home-gallery-card">
              <img src="<?= $assetBase ?>/images/img-grid-3.jpg" alt="Refined home styling">
            </div>
          </div>

          <div class="home-floating-card">
            <span>Signature edit</span>
            <strong>Premium accents and design-led essentials</strong>
            <p>Polished textures, soft neutrals, and expressive silhouettes for contemporary homes.</p>
          </div>

          <?php if ($heroProduct): ?>
            <a href="product.php?id=<?= (int) $heroProduct['pid'] ?>" class="home-product-badge">
              <span class="home-product-badge-label">Featured now</span>
              <strong><?= htmlspecialchars($heroProduct['p_name']) ?></strong>
              <p><?= (int) $heroProduct['quantity'] > 0 ? 'Available to order now.' : 'Popular pick currently sold out.' ?></p>
              <div class="home-product-badge-footer">
                <span>&#8377;<?= number_format((float) $heroProduct['p_price'], 2) ?></span>
                <em>View product</em>
              </div>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="home-marquee">
    <div class="container">
      <div class="home-marquee-shell">
        <div class="home-marquee-track">
          <div class="home-marquee-group">
            <?php foreach ($marqueeItems as $marqueeItem): ?>
              <span><?= htmlspecialchars($marqueeItem) ?></span>
            <?php endforeach; ?>
          </div>
          <div class="home-marquee-group" aria-hidden="true">
            <?php foreach ($marqueeItems as $marqueeItem): ?>
              <span><?= htmlspecialchars($marqueeItem) ?></span>
            <?php endforeach; ?>
          </div>
          <div class="home-marquee-group" aria-hidden="true">
            <?php foreach ($marqueeItems as $marqueeItem): ?>
              <span><?= htmlspecialchars($marqueeItem) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="home-editorial-grid">
        <article class="home-spotlight-card home-spotlight-main">
          <span class="section-kicker">Editorial spotlight</span>
          <h2 class="section-title">Spaces that feel collected, layered, and quietly luxurious.</h2>
          <p class="section-text">The refreshed home page now leads with premium atmosphere, faster discovery, and cleaner transitions between inspiration and shopping.</p>
          <div class="home-spotlight-actions">
            <a href="shop.php" class="btn btn-primary">Discover the collection</a>
            <a href="#home-categories" class="btn btn-outline-dark">See category highlights</a>
          </div>
        </article>

        <article class="home-spotlight-card home-spotlight-mood">
          <div class="home-spotlight-copy">
            <span class="home-spotlight-label">Moodboard</span>
            <strong>Balanced textures, warm neutrals, and sculpted silhouettes.</strong>
          </div>
          <div class="home-spotlight-stack">
            <img src="<?= $assetBase ?>/images/img-grid-2.jpg" alt="Warm premium decor">
            <img src="<?= $assetBase ?>/images/img-grid-3.jpg" alt="Layered modern home details">
          </div>
        </article>

        <article class="home-service-card">
          <span class="benefit-icon"><i class="fas fa-box-open"></i></span>
          <strong>Curated drops</strong>
          <p>New arrivals and best sellers are surfaced with clearer storytelling and stronger visual hierarchy.</p>
        </article>

        <article class="home-service-card">
          <span class="benefit-icon"><i class="fas fa-bolt"></i></span>
          <strong>Faster discovery</strong>
          <p>More contrast, better spacing, and cleaner product cues help customers move through the storefront with confidence.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="section-head">
        <div>
          <span class="section-kicker">Best sellers</span>
          <h2 class="section-title">Most purchased picks</h2>
        </div>
        <a href="shop.php" class="btn btn-outline-dark">View all products</a>
      </div>

      <div class="product-slider-shell" data-slider-scope>
        <div class="products-slider" data-products-slider>
          <?php if (!empty($popularProducts)): ?>
            <?php foreach ($popularProducts as $item): ?>
              <div class="slider-item">
                <article class="store-card <?= (int) $item['quantity'] <= 0 ? 'is-unavailable' : '' ?>">
                  <a class="store-card-media" href="product.php?id=<?= (int) $item['pid'] ?>">
                    <img src="/The-Divine-Decor/the-divine-door-main/gallery/<?= htmlspecialchars($item['p_image']) ?>" alt="<?= htmlspecialchars($item['p_name']) ?>">
                  </a>
                  <div class="store-card-body">
                    <div class="store-card-topline">
                      <span class="store-card-chip">Customer favorite</span>
                      <?php if ((int) $item['quantity'] > 0): ?>
                        <span class="trust-pill is-success">In stock</span>
                      <?php else: ?>
                        <span class="stock-badge">Sold out</span>
                      <?php endif; ?>
                    </div>
                    <a class="store-card-title" href="product.php?id=<?= (int) $item['pid'] ?>"><?= htmlspecialchars($item['p_name']) ?></a>
                    <p class="store-card-copy">
                      <?= (int) $item['purchase_count'] > 0
                        ? (int) $item['purchase_count'] . ' completed purchases and counting.'
                        : 'A standout piece ready to lead the next wave of premium interiors.' ?>
                    </p>
                    <div class="store-card-footer">
                      <div>
                        <span class="store-card-price">&#8377;<?= number_format((float) $item['p_price'], 2) ?></span>
                        <span class="store-card-caption">
                          <?= (int) $item['quantity'] > 0 ? 'Ready to elevate your space' : 'Currently unavailable' ?>
                        </span>
                      </div>
                    </div>
                    <div class="store-card-actions">
                      <a href="product.php?id=<?= (int) $item['pid'] ?>" class="btn <?= (int) $item['quantity'] > 0 ? 'btn-primary' : 'btn-outline-dark' ?>">View details</a>
                    </div>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="slider-item">
              <div class="empty-state-card">
                <h3 class="mb-3">No featured products yet</h3>
                <p class="mb-0">Once products are added, this section will spotlight the most purchased pieces.</p>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <button class="slider-nav-btn products-slider-prev" type="button" data-slider-prev aria-label="Previous products">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-nav-btn products-slider-next" type="button" data-slider-next aria-label="Next products">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="home-collection-band premium-surface">
        <div class="home-collection-intro">
          <span class="section-kicker">Signature collections</span>
          <h2 class="section-title">A homepage that feels curated, not crowded.</h2>
          <p class="section-text">We spotlight the most useful collections first so customers can move from inspiration to product discovery faster.</p>
        </div>

        <div class="home-collection-grid">
          <?php if ($primaryCategory): ?>
            <a href="shop.php?category=<?= (int) $primaryCategory['category_id'] ?>" class="home-collection-feature">
              <span class="home-collection-label">Featured collection</span>
              <h3><?= htmlspecialchars($primaryCategory['category_name']) ?></h3>
              <p>Start with one of the most visually flexible collections in the catalog for an easy room refresh.</p>
              <span class="collection-link">Shop now</span>
            </a>
          <?php else: ?>
            <div class="home-collection-feature is-empty">
              <span class="home-collection-label">Featured collection</span>
              <h3>Catalog refresh in progress</h3>
              <p>We are preparing the first set of premium collections for the home page.</p>
            </div>
          <?php endif; ?>

          <div class="home-collection-stack">
            <?php foreach ([$secondaryCategory, $tertiaryCategory] as $stackCategory): ?>
              <?php if ($stackCategory): ?>
                <a href="shop.php?category=<?= (int) $stackCategory['category_id'] ?>" class="home-collection-mini">
                  <span class="home-collection-label">Collection</span>
                  <strong><?= htmlspecialchars($stackCategory['category_name']) ?></strong>
                  <span class="collection-link">Explore</span>
                </a>
              <?php else: ?>
                <div class="home-collection-mini is-empty">
                  <span class="home-collection-label">Collection</span>
                  <strong>More curated drops soon</strong>
                  <span class="collection-link">Stay tuned</span>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell">
    <div class="container">
      <div class="section-head is-center">
        <div>
          <span class="section-kicker">Why Divine Decor</span>
          <h2 class="section-title">A premium shopping experience from first click to final delivery.</h2>
        </div>
        <p class="section-text">We combine curated collections, reliable service, and a clean buying journey so every space upgrade feels effortless and inspiring.</p>
      </div>

      <div class="benefit-grid">
        <article class="benefit-card">
          <span class="benefit-icon"><i class="fas fa-gem"></i></span>
          <h3>Curated quality</h3>
          <p>Every product is selected for finish, form, and day-to-day livability so your space looks polished without feeling overdesigned.</p>
        </article>
        <article class="benefit-card">
          <span class="benefit-icon"><i class="fas fa-truck-fast"></i></span>
          <h3>Reliable fulfillment</h3>
          <p>Clear stock visibility, streamlined checkout, and fast dispatch keep your order journey smooth from browse to doorstep.</p>
        </article>
        <article class="benefit-card">
          <span class="benefit-icon"><i class="fas fa-shield-heart"></i></span>
          <h3>Support that feels human</h3>
          <p>Need help choosing, tracking, or reordering? The platform is built to feel premium and dependable at every touchpoint.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section-shell soft" id="home-categories">
    <div class="container">
      <div class="section-head">
        <div>
          <span class="section-kicker">Collections</span>
          <h2 class="section-title">Explore by category</h2>
        </div>
        <p class="section-text">Browse signature collections shaped around material, mood, and the way each piece elevates a room.</p>
      </div>

      <div class="category-grid">
        <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $index => $category): ?>
            <?php $image = $categoryImages[$index % count($categoryImages)]; ?>
            <a class="collection-card" href="shop.php?category=<?= (int) $category['category_id'] ?>">
              <div class="collection-card-media">
              <img src="<?= $assetBase . '/' . htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($category['category_name']) ?>">
              </div>
              <div class="collection-card-content">
                <span>Collection <?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <h3><?= htmlspecialchars($category['category_name']) ?></h3>
                <p>Refined pieces chosen to bring texture, warmth, and a confident premium finish to your home.</p>
                <span class="collection-link">Explore Collection</span>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="empty-state-card">
            <h3 class="mb-3">Categories are coming soon</h3>
            <p class="mb-0">We are preparing a more curated catalog. Please check back shortly.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="section-shell soft">
    <div class="container">
      <div class="editorial-split">
        <div class="editorial-copy editorial-panel">
          <span class="section-kicker">Design support</span>
          <h2 class="section-title">Crafting beautiful spaces together</h2>
          <p class="section-text">From everyday styling updates to full-room refreshes, our collections are built to help you layer your space with confidence and clarity.</p>
          <ul>
            <li><i class="fas fa-check"></i> Premium materials and polished finishes</li>
            <li><i class="fas fa-check"></i> Styles that balance modern and timeless</li>
            <li><i class="fas fa-check"></i> Reliable inventory and smoother checkout</li>
            <li><i class="fas fa-check"></i> A cleaner, more premium shopping journey</li>
          </ul>
        </div>

        <div class="editorial-visual editorial-panel">
          <div class="editorial-gallery">
            <img src="<?= $assetBase ?>/images/img-grid-1.jpg" alt="Decor inspiration">
            <div class="stack">
              <img src="<?= $assetBase ?>/images/img-grid-2.jpg" alt="Interior styling">
              <img src="<?= $assetBase ?>/images/img-grid-3.jpg" alt="Contemporary decor">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell">
    <div class="container">
      <div class="home-bottom-cta premium-surface">
        <div>
          <span class="section-kicker">Ready to explore</span>
          <h2 class="section-title">Build a polished home, one intentional piece at a time.</h2>
          <p class="section-text">Browse the full shop, review categories, or head straight to your account to continue where you left off.</p>
        </div>
        <div class="home-bottom-actions">
          <a href="shop.php" class="btn btn-primary">Explore the Shop</a>
          <a href="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'profile.php' : 'login.php' ?>" class="btn btn-outline-dark">
            <?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'My Account' : 'Sign In' ?>
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="<?= $assetBase ?>/js/bootstrap.bundle.min.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/tiny-slider.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/custom.js?v=<?= $assetVersion ?>"></script>
</body>
</html>
