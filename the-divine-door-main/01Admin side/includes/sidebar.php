<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$adminName = 'Administrator';

if (!empty($_SESSION['admin_name'])) {
    $adminName = $_SESSION['admin_name'];
} elseif (!empty($_SESSION['admin_username'])) {
    $adminName = $_SESSION['admin_username'];
}

$catalogPages = ['category.php', 'categoryedit.php', 'subcategory.php', 'subcategoryedit.php'];
$operationsPages = ['order.php', 'order_details.php', 'payment.php', 'feedback.php', 'report.php', 'report-orders.php', 'report-sales.php', 'report-products.php'];
$settingsPages = ['admin.php', 'adminedit.php', 'registerd.php', 'deliveryperson.php', 'deliverypersonedit.php', 'profile.php'];
?>

<aside class="main-sidebar elevation-4">
  <div class="sidebar">
    <a href="index.php" class="brand-block">
      <span class="brand-mark">DD</span>
      <span class="brand-copy">
        <strong>Divine Decor</strong>
        <span>Admin console</span>
      </span>
    </a>

    <div class="sidebar-user-card">
      <span>Signed in as</span>
      <strong><?= htmlspecialchars($adminName) ?></strong>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Overview</li>
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-chart-line"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">Catalog</li>
        <li class="nav-item <?= in_array($currentPage, $catalogPages, true) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= in_array($currentPage, $catalogPages, true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-layer-group"></i>
            <p>
              Categories
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="category.php" class="nav-link <?= in_array($currentPage, ['category.php', 'categoryedit.php'], true) ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Main Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="subcategory.php" class="nav-link <?= in_array($currentPage, ['subcategory.php', 'subcategoryedit.php'], true) ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub-categories</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="product.php" class="nav-link <?= in_array($currentPage, ['product.php', 'productedit.php', 'productoffer.php'], true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-box-open"></i>
            <p>Products</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="gallery.php" class="nav-link <?= $currentPage === 'gallery.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-images"></i>
            <p>Gallery</p>
          </a>
        </li>

        <li class="nav-header">Operations</li>
        <li class="nav-item">
          <a href="order.php" class="nav-link <?= in_array($currentPage, ['order.php', 'order_details.php', 'edit_order.php'], true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-bag-shopping"></i>
            <p>Orders</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="payment.php" class="nav-link <?= $currentPage === 'payment.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-credit-card"></i>
            <p>Payments</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="feedback.php" class="nav-link <?= $currentPage === 'feedback.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-comments"></i>
            <p>Feedback</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="report.php" class="nav-link <?= in_array($currentPage, ['report.php', 'report-orders.php', 'report-sales.php', 'report-products.php'], true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-chart-column"></i>
            <p>Reports</p>
          </a>
        </li>

        <li class="nav-header">Settings</li>
        <li class="nav-item">
          <a href="profile.php" class="nav-link <?= $currentPage === 'profile.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-user-shield"></i>
            <p>Profile</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="admin.php" class="nav-link <?= in_array($currentPage, ['admin.php', 'adminedit.php'], true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-user-gear"></i>
            <p>Admins</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="registerd.php" class="nav-link <?= $currentPage === 'registerd.php' ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-users"></i>
            <p>Customers</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="deliveryperson.php" class="nav-link <?= in_array($currentPage, ['deliveryperson.php', 'deliverypersonedit.php'], true) ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-truck-fast"></i>
            <p>Delivery Team</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
