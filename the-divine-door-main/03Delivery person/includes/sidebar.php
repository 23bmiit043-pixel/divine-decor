<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="delivery-nav">
    <span class="delivery-nav-heading">Overview</span>
    <a class="delivery-nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <span class="delivery-nav-heading">Orders</span>
    <a class="delivery-nav-link <?= $currentPage === 'pending-orders.php' ? 'active' : '' ?>" href="pending-orders.php">
        <i class="fas fa-clock"></i>
        <span>Pending Orders</span>
    </a>
    <a class="delivery-nav-link <?= $currentPage === 'completed-orders.php' ? 'active' : '' ?>" href="completed-orders.php">
        <i class="fas fa-circle-check"></i>
        <span>Completed Orders</span>
    </a>

    <span class="delivery-nav-heading">Account</span>
    <a class="delivery-nav-link <?= $currentPage === 'profile.php' ? 'active' : '' ?>" href="profile.php">
        <i class="fas fa-user-gear"></i>
        <span>Profile</span>
    </a>

    <div class="delivery-sidebar-note">
        <span>Today</span>
        <strong>Keep deliveries moving smoothly and update statuses in real time.</strong>
    </div>
</nav>
