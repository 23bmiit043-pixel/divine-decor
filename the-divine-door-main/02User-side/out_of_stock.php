<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';
include('functions/myfunctions.php');

// Get product details even if out of stock, to show product info
$item = null;
if (isset($_GET['id'])) {
    $product = getProductById($_GET['id']);
    if ($product && mysqli_num_rows($product) > 0) {
        $item = mysqli_fetch_assoc($product);
    }
}

// Get related in-stock products
$related = [];
if ($item) {
    $rel = getRelatedProducts($item['pid'], $item['sub_category_id']);
    if ($rel && mysqli_num_rows($rel) > 0) {
        while ($r = mysqli_fetch_assoc($rel)) {
            if ($r['quantity'] > 0)
                $related[] = $r;
            if (count($related) >= 4)
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Out of Stock – The Divine Decor</title>
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css?v=site-refresh-20260317-3" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/tiny-slider.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
 
    <style>
        /* Navbar fixes */
        .custom-navbar {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }

        .custom-navbar .nav-link {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .custom-navbar .navbar-brand {
            padding: 0 !important;
        }

        .custom-navbar img {
            width: 20px;
            height: auto;
        }

        /* OOS Hero */
        .oos-hero {
            min-height: 480px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d3a35 50%, #3b5d50 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .oos-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .oos-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 40px 20px;
        }

        .oos-icon-wrap {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse-ring 2.5s ease-in-out infinite;
        }

        @keyframes pulse-ring {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.15);
            }

            50% {
                box-shadow: 0 0 0 20px rgba(255, 255, 255, 0);
            }
        }

        .oos-icon-wrap i {
            font-size: 44px;
            color: rgba(255, 255, 255, 0.7);
        }

        .oos-hero-content h1 {
            font-family: 'Inter', serif;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 2px;
            margin-bottom: 16px;
        }

        .oos-hero-content p {
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
            max-width: 500px;
            margin: 0 auto 32px;
            line-height: 1.8;
        }

        .oos-badge {
            display: inline-block;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.4);
            color: #ff6b7a;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 6px 20px;
            border-radius: 30px;
            margin-bottom: 24px;
        }

        /* Product snapshot card (if product found) */
        .product-snapshot {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            max-width: 700px;
            margin: -60px auto 0;
            position: relative;
            z-index: 10;
            display: flex;
            align-items: stretch;
        }

        .product-snapshot .snap-img {
            width: 220px;
            min-height: 200px;
            object-fit: cover;
            filter: grayscale(60%);
            flex-shrink: 0;
        }

        .product-snapshot .snap-info {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .snap-info .product-name {
            font-family: 'Inter', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .snap-info .product-price {
            font-family: 'Inter', sans-serif;
            font-size: 1.2rem;
            color: #3b5d50;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .snap-info .oos-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff5f5;
            border: 1px solid #ffd0d0;
            color: #c0392b;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 20px;
            width: fit-content;
        }

        .snap-info .btn-notify {
            background: #3b5d50;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: fit-content;
        }

        .snap-info .btn-notify:hover {
            background: #2d4a3e;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 93, 80, 0.3);
        }

        /* Action buttons */
        .oos-actions {
            text-align: center;
            padding: 50px 20px 20px;
        }

        .btn-back-shop {
            background: #3b5d50;
            color: white;
            border: none;
            padding: 14px 36px;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            margin: 8px;
        }

        .btn-back-shop:hover {
            background: #2d4a3e;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(59, 93, 80, 0.35);
        }

        .btn-back-home {
            background: transparent;
            color: #3b5d50;
            border: 2px solid #3b5d50;
            padding: 12px 36px;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            margin: 8px;
        }

        .btn-back-home:hover {
            background: #3b5d50;
            color: white;
            transform: translateY(-3px);
        }

        /* Related products */
        .related-section {
            padding: 60px 0 40px;
            background: #f9f7f4;
        }

        .related-section h2 {
            font-family: 'Inter', serif;
            font-size: 2rem;
            font-weight: 600;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 8px;
        }

        .related-section .subtitle {
            text-align: center;
            font-family: 'Inter', sans-serif;
            color: #888;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        .related-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
            transition: all 0.35s ease;
            text-decoration: none;
            display: block;
        }

        .related-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.14);
            text-decoration: none;
        }

        .related-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .related-card:hover img {
            transform: scale(1.05);
        }

        .related-card .card-body {
            padding: 16px 18px 20px;
        }

        .related-card h5 {
            font-family: 'Inter', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .related-card .price {
            font-family: 'Inter', sans-serif;
            color: #3b5d50;
            font-weight: 500;
            font-size: 1rem;
        }

        .related-card .view-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 7px 18px;
            background: #3b5d50;
            color: white;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            transition: background 0.3s;
        }

        .related-card:hover .view-btn {
            background: #2d4a3e;
        }

        /* Divider */
        .fancy-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            max-width: 300px;
            margin: 0 auto 40px;
        }

        .fancy-divider span {
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        .fancy-divider i {
            color: #3b5d50;
            font-size: 14px;
        }

        @media(max-width: 576px) {
            .product-snapshot {
                flex-direction: column;
            }

            .product-snapshot .snap-img {
                width: 100%;
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <!-- Hero -->
    <div class="oos-hero">
        <div class="oos-hero-content">
            <div class="oos-badge">
                <i class="fas fa-exclamation-circle me-1"></i> Out of Stock
            </div>
            <div class="oos-icon-wrap">
                <i class="fas fa-box-open"></i>
            </div>
            <h1>
                <?php if ($item): ?>
                    <?= htmlspecialchars($item['p_name']) ?>
                <?php else: ?>
                    Product Unavailable
                <?php endif; ?>
            </h1>
            <p>This item has flown off our shelves! We're working hard to restock. Explore similar pieces below or
                browse our full collection.</p>
        </div>
    </div>

    <?php if ($item): ?>
        <!-- Product Snapshot -->
        <div class="container">
            <div class="product-snapshot">
                <img src="/The-Divine-Decor/the-divine-door-main/gallery/<?= htmlspecialchars($item['p_image']) ?>"
                    alt="<?= htmlspecialchars($item['p_name']) ?>" class="snap-img">
                <div class="snap-info">
                    <div class="oos-tag">
                        <i class="fas fa-times-circle"></i> Currently Out of Stock
                    </div>
                    <div class="product-name"><?= htmlspecialchars($item['p_name']) ?></div>
                    <div class="product-price">₹<?= number_format($item['p_price'], 2) ?></div>
                    <p
                        style="font-family:'Jost',sans-serif; font-size:0.88rem; color:#888; margin-bottom:18px; line-height:1.7;">
                        <?= htmlspecialchars(substr($item['p_description'] ?? '', 0, 100)) ?>...
                    </p>
                    <button class="btn-notify" onclick="showNotifyMsg()">
                        <i class="fas fa-bell me-2"></i> Notify When Available
                    </button>
                    <div id="notifyMsg"
                        style="display:none; margin-top:12px; font-family:'Jost',sans-serif; font-size:0.85rem; color:#3b5d50;">
                        <i class="fas fa-check-circle me-1"></i> We'll let you know when it's back!
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="oos-actions">
        <a href="shop.php" class="btn-back-shop">
            <i class="fas fa-store"></i> Browse All Products
        </a>
        <a href="index.php" class="btn-back-home">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </div>

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
        <div class="related-section">
            <div class="container">
                <p class="subtitle">You might also like</p>
                <h2>Similar Products</h2>
                <div class="fancy-divider">
                    <span></span><i class="fas fa-leaf"></i><span></span>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($related as $r): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="product.php?id=<?= $r['pid'] ?>" class="related-card">
                                <img src="/The-Divine-Decor/the-divine-door-main/gallery/<?= htmlspecialchars($r['p_image']) ?>"
                                    alt="<?= htmlspecialchars($r['p_name']) ?>">
                                <div class="card-body">
                                    <h5><?= htmlspecialchars($r['p_name']) ?></h5>
                                    <div class="price">₹<?= number_format($r['p_price'], 2) ?></div>
                                    <span class="view-btn">View Details →</span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- No related — show shop CTA -->
        <div style="text-align:center; padding: 40px 20px 60px;">
            <p style="font-family:'Jost',sans-serif; color:#888; margin-bottom:20px;">
                Discover our full range of home decor
            </p>
            <a href="shop.php" class="btn-back-shop">
                <i class="fas fa-th-large"></i> Explore All Collections
            </a>
        </div>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>

    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/tiny-slider.js"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
    <script>
        function showNotifyMsg() {
            document.getElementById('notifyMsg').style.display = 'block';
            event.target.disabled = true;
            event.target.style.opacity = '0.6';
        }
    </script>
</body>

</html>
