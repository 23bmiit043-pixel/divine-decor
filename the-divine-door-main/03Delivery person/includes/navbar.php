<?php
$deliveryDisplayName = trim((string) ($_SESSION['auth_user']['name'] ?? ''));
if ($deliveryDisplayName === '') {
    $deliveryDisplayName = 'Delivery Partner';
}
?>
<nav class="delivery-topbar">
    <div class="delivery-topbar-left">
        <button class="delivery-topbar-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="delivery-topbar-copy">
            <span>Delivery workspace</span>
            <strong><?= htmlspecialchars($page_label) ?></strong>
        </div>
    </div>

    <div class="delivery-topbar-right">
        <span class="delivery-topbar-user">
            <i class="fas fa-truck-fast"></i>
            <?= htmlspecialchars($deliveryDisplayName) ?>
        </span>
        <span class="delivery-topbar-date"><?= date('d M Y') ?></span>
        <a class="delivery-logout-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
            <i class="fas fa-right-from-bracket"></i>
            Sign out
        </a>
    </div>
</nav>
