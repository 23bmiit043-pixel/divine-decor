<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$cartCount = 0;
$currentSearch = isset($_GET['search']) ? trim((string) $_GET['search']) : '';
$currentCategoryFilter = $currentPage === 'shop.php' && isset($_GET['category']) ? (int) $_GET['category'] : 0;
$currentSubcategoryFilter = $currentPage === 'shop.php' && isset($_GET['subcategory']) ? (int) $_GET['subcategory'] : 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += isset($cartItem['quantity']) ? (int) $cartItem['quantity'] : 0;
    }
}
?>

<nav class="premium-navbar" data-site-nav>
  <div class="container nav-container">
    <a href="index.php" class="brand" aria-label="The Divine Decor home">
      <span class="brand-emblem">DD</span>
      <span class="brand-copy">
        <strong>Divine Decor</strong>
        <span>Premium living</span>
      </span>
    </a>

    <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="navMenu">
      <i class="fas fa-bars"></i>
    </button>

    <div class="nav-menu" id="navMenu" data-nav-menu>
      <ul class="nav-links">
        <li><a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="shop.php" class="<?= in_array($currentPage, ['shop.php', 'product.php', 'out_of_stock.php'], true) ? 'active' : '' ?>">Shop</a></li>
        <li><a href="about.php" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">About</a></li>
        <li><a href="#site-footer">Contact</a></li>
      </ul>

      <div class="nav-actions">
        <a href="shop.php" class="nav-cta">Shop Collection</a>
        <form action="shop.php" method="get" class="nav-search-shell">
          <?php if ($currentCategoryFilter > 0): ?>
            <input type="hidden" name="category" value="<?= $currentCategoryFilter ?>">
          <?php endif; ?>
          <?php if ($currentSubcategoryFilter > 0): ?>
            <input type="hidden" name="subcategory" value="<?= $currentSubcategoryFilter ?>">
          <?php endif; ?>
          <label class="visually-hidden" for="navSearchInput">Search products</label>
          <input
            type="search"
            name="search"
            id="navSearchInput"
            class="nav-search-input"
            placeholder="Search products"
            value="<?= htmlspecialchars($currentSearch) ?>"
          >
          <button type="submit" class="nav-search-submit" title="Search products" aria-label="Search products">
            <i class="fas fa-search"></i>
          </button>
        </form>
        <a href="cart.php" class="nav-icon" title="Cart" aria-label="View cart">
          <i class="fas fa-shopping-bag"></i>
          <span class="cart-count" style="<?= $cartCount > 0 ? '' : 'display:none;' ?>"><?= $cartCount ?></span>
        </a>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
          <a href="profile.php" class="nav-icon" title="My account" aria-label="My account">
            <i class="fas fa-user"></i>
          </a>
        <?php else: ?>
          <a href="login.php" class="nav-icon" title="Login" aria-label="Login">
            <i class="far fa-user"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
