<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$pageLabel = $currentPage === 'index.php'
    ? 'Dashboard'
    : ucwords(str_replace(['.php', '-'], ['', ' '], $currentPage));
$adminDisplayName = trim((string) ($_SESSION['admin_name'] ?? ''));

if ($adminDisplayName === '') {
    $adminDisplayName = 'Administrator';
}
?>

<nav class="main-header navbar navbar-expand admin-topbar">
  <ul class="navbar-nav align-items-center">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-md-flex align-items-center">
      <div class="admin-topbar-copy">
        <span>Control panel</span>
        <strong><?= htmlspecialchars($pageLabel) ?></strong>
      </div>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center">
    <li class="nav-item d-none d-md-block">
      <span class="admin-topbar-user">
        <i class="fas fa-user-shield"></i>
        <?= htmlspecialchars($adminDisplayName) ?>
      </span>
    </li>
    <li class="nav-item d-none d-md-block">
      <span class="admin-topbar-date"><?= date('d M Y') ?></span>
    </li>
    <li class="nav-item ml-2">
      <a class="nav-link admin-logout-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
        <i class="fas fa-right-from-bracket"></i> Sign out
      </a>
    </li>
  </ul>
</nav>
