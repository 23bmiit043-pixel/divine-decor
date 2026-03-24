<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$page_title = $page_title ?? 'Delivery Panel';
$page_label = $page_label ?? ($currentPage === 'index.php'
    ? 'Dashboard'
    : ucwords(str_replace(['.php', '-'], ['', ' '], $currentPage)));

$deliveryDisplayName = trim((string) ($_SESSION['auth_user']['name'] ?? ''));
if ($deliveryDisplayName === '') {
    $deliveryDisplayName = 'Delivery Partner';
}

$deliveryAssetBase = '/The-Divine-Decor/the-divine-door-main/03Delivery%20person';
$deliveryAssetVersion = 'delivery-refresh-20260317-4';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Delivery management panel for The Divine Decor">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $deliveryAssetBase ?>/css/styles.css?v=<?= $deliveryAssetVersion ?>">
    <link rel="stylesheet" href="<?= $deliveryAssetBase ?>/assets/css/delivery-modern.css?v=<?= $deliveryAssetVersion ?>">
</head>
<body class="delivery-premium">
    <div class="delivery-shell">
        <aside class="delivery-sidebar">
            <div class="delivery-sidebar-inner">
                <a href="index.php" class="delivery-brand">
                    <span class="delivery-brand-mark">DD</span>
                    <span class="delivery-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Delivery console</span>
                    </span>
                </a>

                <div class="delivery-user-card">
                    <span>Signed in as</span>
                    <strong><?= htmlspecialchars($deliveryDisplayName) ?></strong>
                </div>

                <?php include 'sidebar.php'; ?>
            </div>
        </aside>

        <div class="delivery-main">
            <?php include 'navbar.php'; ?>
            <main class="delivery-content">
                <div class="delivery-page-shell">
