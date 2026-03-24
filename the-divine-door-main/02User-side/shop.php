<?php
include 'connect.php';
include 'functions/myfunctions.php';

$assetBase = '/The-Divine-Decor/the-divine-door-main/02User-side';
$galleryBase = '/The-Divine-Decor/the-divine-door-main/gallery';
$assetVersion = 'site-refresh-20260317-18';

$selectedCategoryId = isset($_GET['category']) ? (int) $_GET['category'] : 0;
$selectedSubcategoryId = isset($_GET['subcategory']) ? (int) $_GET['subcategory'] : 0;
$searchTerm = isset($_GET['search']) ? trim((string) $_GET['search']) : '';

$categories = [];
$selectedCategoryName = '';
$selectedSubcategoryName = '';
$selectedSubcategoryParentId = 0;

$categoryResult = getAll('category');
if ($categoryResult) {
    while ($category = mysqli_fetch_assoc($categoryResult)) {
        $subcategories = [];
        $subCategoryResult = getSubCategories($category['category_id']);

        if ($subCategoryResult) {
            while ($subCategory = mysqli_fetch_assoc($subCategoryResult)) {
                $subcategories[] = $subCategory;

                if ($selectedSubcategoryId === (int) $subCategory['sub_category_id']) {
                    $selectedSubcategoryName = $subCategory['sub_category_name'];
                    $selectedSubcategoryParentId = (int) $category['category_id'];
                }
            }
        }

        if ($selectedCategoryId === (int) $category['category_id']) {
            $selectedCategoryName = $category['category_name'];
        }

        $category['subcategories'] = $subcategories;
        $categories[] = $category;
    }
}

if ($selectedCategoryId > 0 && $selectedSubcategoryId > 0 && $selectedSubcategoryParentId > 0 && $selectedCategoryId !== $selectedSubcategoryParentId) {
    $redirectParams = [
        'category' => $selectedSubcategoryParentId,
        'subcategory' => $selectedSubcategoryId,
    ];

    if ($searchTerm !== '') {
        $redirectParams['search'] = $searchTerm;
    }

    header('Location: shop.php?' . http_build_query($redirectParams));
    exit();
}

$products = getCatalogProducts($selectedCategoryId, $selectedSubcategoryId, $searchTerm);

$productCount = $products ? mysqli_num_rows($products) : 0;

if ($searchTerm !== '' && $selectedSubcategoryName !== '') {
    $filterTitle = $selectedSubcategoryName;
    $filterDescription = 'Showing products with titles that match "' . $searchTerm . '" within this sub-category.';
} elseif ($searchTerm !== '' && $selectedCategoryName !== '') {
    $filterTitle = $selectedCategoryName;
    $filterDescription = 'Showing products with titles that match "' . $searchTerm . '" within this category.';
} elseif ($searchTerm !== '') {
    $filterTitle = 'Search Results';
    $filterDescription = 'Showing products with titles that match "' . $searchTerm . '" across the full catalog.';
} elseif ($selectedSubcategoryName !== '') {
    $filterTitle = $selectedSubcategoryName;
    $filterDescription = 'Focused picks from this sub-category with premium details, cleaner layouts, and smoother add-to-cart behavior.';
} elseif ($selectedCategoryName !== '') {
    $filterTitle = $selectedCategoryName;
    $filterDescription = 'A curated category view with clearer navigation, improved spacing, and a more premium browsing experience.';
} else {
    $filterTitle = 'All Products';
    $filterDescription = 'Browse the full collection with cleaner filters, refined cards, and a shopping flow designed to feel modern and dependable.';
}

$pageTitle = $searchTerm !== '' ? 'Search Results for "' . $searchTerm . '"' : $filterTitle;

function excerptText($value, $limit = 110)
{
    $text = trim(strip_tags((string) $value));

    if (strlen($text) <= $limit) {
        return $text;
    }

    return rtrim(substr($text, 0, $limit - 3)) . '...';
}

function buildShopUrl($categoryId = 0, $subcategoryId = 0, $searchTerm = '')
{
    $params = [];
    $searchTerm = trim((string) $searchTerm);

    if ((int) $categoryId > 0) {
        $params['category'] = (int) $categoryId;
    }

    if ((int) $subcategoryId > 0) {
        $params['subcategory'] = (int) $subcategoryId;
    }

    if ($searchTerm !== '') {
        $params['search'] = $searchTerm;
    }

    return 'shop.php' . (!empty($params) ? '?' . http_build_query($params) : '');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Browse The Divine Decor collection by category and sub-category.">
  <link rel="shortcut icon" href="<?= $assetBase ?>/favicon.png">
  <link href="<?= $assetBase ?>/css/bootstrap.min.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/tiny-slider.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/style.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <link href="<?= $assetBase ?>/css/premium.css?v=<?= $assetVersion ?>" rel="stylesheet">
  <title><?= htmlspecialchars($pageTitle) ?> | The Divine Decor</title>
</head>
<body class="page-shop">
  <?php include 'includes/nav.php'; ?>

  <section class="page-hero">
    <div class="container">
      <div class="page-hero-shell">
        <div>
          <span class="section-kicker">Curated catalog</span>
          <h1><?= htmlspecialchars($filterTitle) ?></h1>
          <p><?= htmlspecialchars($filterDescription) ?></p>
        </div>
        <div class="page-hero-meta">
          <span><?= $productCount ?> product<?= $productCount === 1 ? '' : 's' ?></span>
          <a href="cart.php" class="btn btn-white-outline">View Cart</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section-shell compact-top">
    <div class="container">
      <div class="shop-filter-bar">
        <div class="shop-filter-scroll">
          <a href="<?= buildShopUrl(0, 0, $searchTerm) ?>" class="filter-chip <?= $selectedCategoryId === 0 && $selectedSubcategoryId === 0 ? 'active' : '' ?>">All Products</a>

          <?php foreach ($categories as $category): ?>
            <?php
            $isCategoryActive = $selectedCategoryId === (int) $category['category_id'];
            $hasSubcategories = !empty($category['subcategories']);
            ?>
            <?php if ($hasSubcategories): ?>
              <div class="category-filter-group <?= $isCategoryActive ? 'is-selected' : '' ?>" data-filter-group>
                <button class="filter-chip dropdown-toggle <?= $isCategoryActive ? 'active' : '' ?>" type="button" id="category<?= (int) $category['category_id'] ?>" data-subcategory-toggle aria-expanded="false" aria-controls="categoryMenu<?= (int) $category['category_id'] ?>">
                  <?= htmlspecialchars($category['category_name']) ?>
                </button>
                <div class="filter-menu-template" id="categoryMenu<?= (int) $category['category_id'] ?>" data-filter-menu-template hidden>
                  <div class="filter-menu-list">
                    <a class="dropdown-item <?= $isCategoryActive && $selectedSubcategoryId === 0 ? 'is-current' : '' ?>" href="<?= buildShopUrl((int) $category['category_id'], 0, $searchTerm) ?>">
                      All <?= htmlspecialchars($category['category_name']) ?>
                    </a>
                    <?php foreach ($category['subcategories'] as $subcategory): ?>
                      <a class="dropdown-item <?= $selectedSubcategoryId === (int) $subcategory['sub_category_id'] ? 'is-current' : '' ?>" href="<?= buildShopUrl((int) $category['category_id'], (int) $subcategory['sub_category_id'], $searchTerm) ?>">
                        <?= htmlspecialchars($subcategory['sub_category_name']) ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <a href="<?= buildShopUrl((int) $category['category_id'], 0, $searchTerm) ?>" class="filter-chip <?= $isCategoryActive ? 'active' : '' ?>">
                <?= htmlspecialchars($category['category_name']) ?>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="shop-subcategory-panel" data-subcategory-panel hidden></div>

      <?php if ($selectedCategoryId > 0 || $selectedSubcategoryId > 0 || $searchTerm !== ''): ?>
        <div class="shop-toolbar">
          <?php if ($searchTerm !== ''): ?>
            <p>Showing results for "<strong><?= htmlspecialchars($searchTerm) ?></strong>"</p>
          <?php endif; ?>
          <a href="shop.php" class="btn btn-outline-dark btn-sm">Reset View</a>
        </div>
      <?php endif; ?>

      <div class="row g-4">
        <?php if ($products && mysqli_num_rows($products) > 0): ?>
          <?php while ($item = mysqli_fetch_assoc($products)): ?>
            <?php
            $isOutOfStock = (int) $item['quantity'] <= 0;
            $productLink = $isOutOfStock ? 'out_of_stock.php?id=' . (int) $item['pid'] : 'product.php?id=' . (int) $item['pid'];
            $stockLabel = $isOutOfStock ? 'Unavailable' : ((int) $item['quantity'] <= 5 ? 'Limited stock' : 'Ready to ship');
            ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
              <article class="store-card <?= $isOutOfStock ? 'is-unavailable' : '' ?>">
                <a class="store-card-media" href="<?= $productLink ?>">
                  <img src="<?= $galleryBase ?>/<?= htmlspecialchars($item['p_image']) ?>" alt="<?= htmlspecialchars($item['p_name']) ?>">
                </a>
                <div class="store-card-body">
                  <div class="store-card-topline">
                    <span class="store-card-chip"><?= htmlspecialchars($item['sub_category_name'] ?? ($selectedCategoryName !== '' ? $selectedCategoryName : 'Curated pick')) ?></span>
                    <?php if ($isOutOfStock): ?>
                      <span class="stock-badge">Out of stock</span>
                    <?php endif; ?>
                  </div>

                  <a class="store-card-title" href="<?= $productLink ?>"><?= htmlspecialchars($item['p_name']) ?></a>
                  <p class="store-card-copy"><?= htmlspecialchars(excerptText($item['p_description'] ?? '')) ?></p>

                  <div class="store-card-footer">
                    <div>
                      <span class="store-card-price">&#8377;<?= number_format((float) $item['p_price'], 2) ?></span>
                      <span class="store-card-caption"><?= htmlspecialchars($stockLabel) ?></span>
                    </div>
                  </div>

                  <div class="store-card-actions">
                    <a href="<?= $productLink ?>" class="btn btn-outline-dark">View Details</a>
                    <?php if ($isOutOfStock): ?>
                      <a href="<?= $productLink ?>" class="btn btn-secondary">Notify Me</a>
                    <?php else: ?>
                      <button type="button" class="btn btn-primary add-to-cart-btn" data-pid="<?= (int) $item['pid'] ?>">Add to Cart</button>
                    <?php endif; ?>
                  </div>
                </div>
              </article>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="empty-state-card">
              <h3 class="mb-3">No products found</h3>
              <p class="mb-4">
                <?= $searchTerm !== ''
                  ? 'Try a different search term or reset the view to explore the full collection.'
                  : 'Try another category or clear your filters to explore the full collection.' ?>
              </p>
              <a href="shop.php" class="btn btn-primary">Browse Everything</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="<?= $assetBase ?>/js/bootstrap.bundle.min.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/tiny-slider.js?v=<?= $assetVersion ?>"></script>
  <script src="<?= $assetBase ?>/js/custom.js?v=<?= $assetVersion ?>"></script>
  <script>
    document.querySelectorAll('.add-to-cart-btn').forEach(function (button) {
      button.addEventListener('click', function () {
        var originalText = button.textContent;

        button.disabled = true;
        button.textContent = 'Adding...';

        fetch('functions/handlecart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'pid=' + encodeURIComponent(button.dataset.pid) + '&quantity=1'
        })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          if (data.status === 'success') {
            window.updateCartBadge(data.cartCount);
            button.textContent = 'Added';
            setTimeout(function () {
              button.textContent = originalText;
              button.disabled = false;
            }, 1200);
          } else {
            alert(data.message);
            button.textContent = originalText;
            button.disabled = false;
          }
        })
        .catch(function (error) {
          console.error('Error:', error);
          button.textContent = originalText;
          button.disabled = false;
        });
      });
    });
  </script>
</body>
</html>
