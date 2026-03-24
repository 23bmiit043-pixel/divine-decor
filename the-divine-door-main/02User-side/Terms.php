<?php
session_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions | The Divine Decor</title>
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css" rel="stylesheet">
    <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
</head>
<body>
<?php include 'includes/nav.php'; ?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero-shell">
            <div>
                <span class="section-kicker">Legal</span>
                <h1>Terms and Conditions</h1>
                <p>The terms that govern browsing, ordering, account usage, and general use of The Divine Decor website.</p>
            </div>
            <div class="page-hero-meta">
                <span>Updated <?= date('F d, Y') ?></span>
                <a href="index.php" class="btn btn-white-outline">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<section class="section-shell compact-top">
    <div class="container">
        <div class="legal-shell">
            <div class="legal-intro-card">
                <div class="section-head">
                    <div>
                        <span class="section-kicker">Overview</span>
                        <h2 class="section-title">Clear terms for shopping with confidence.</h2>
                    </div>
                    <p class="section-text">These terms apply to visitors, registered customers, and anyone placing orders through the website. Using the store means you agree to the conditions below.</p>
                </div>
            </div>

            <div class="legal-accordion-shell legal-accordion-shell-terms" data-legal-accordion>
                <article class="legal-accordion-item legal-accordion-item-terms" id="acceptance-of-terms">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-1">
                        <span class="legal-accordion-icon"><i class="fas fa-circle-question"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Acceptance of Terms</span>
                            <span class="legal-accordion-subtitle">When using the store means you agree to the rules below.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-1" data-legal-panel hidden>
                        <p>By browsing the website, creating an account, or placing an order, you agree to these Terms and Conditions as well as any related store policies shown on the site.</p>
                        <p>We may update these terms from time to time. Continued use of the website after updates means you accept the revised version.</p>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="user-accounts">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-2">
                        <span class="legal-accordion-icon"><i class="fas fa-user"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">User Accounts</span>
                            <span class="legal-accordion-subtitle">Responsibilities attached to account details and passwords.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-2" data-legal-panel hidden>
                        <ul class="legal-detail-list">
                            <li>You are responsible for the accuracy of the information you provide.</li>
                            <li>You are responsible for keeping your account credentials private.</li>
                            <li>Activity performed through your account is treated as your responsibility.</li>
                            <li>Accounts may be restricted or removed if they are used improperly or fraudulently.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="orders-and-payments">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-3">
                        <span class="legal-accordion-icon"><i class="fas fa-credit-card"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Orders and Payments</span>
                            <span class="legal-accordion-subtitle">How pricing, availability, and payment approval are handled.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-3" data-legal-panel hidden>
                        <p>All orders are subject to acceptance and product availability.</p>
                        <ul class="legal-detail-list">
                            <li>Prices are displayed in Indian Rupees.</li>
                            <li>Payment methods shown at checkout are the methods currently supported by the website.</li>
                            <li>Orders may be cancelled if stock is unavailable, details are incorrect, or suspicious activity is detected.</li>
                            <li>Order confirmation does not override stock or operational limitations discovered after submission.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="shipping-and-delivery">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-4">
                        <span class="legal-accordion-icon"><i class="fas fa-truck-fast"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Shipping and Delivery</span>
                            <span class="legal-accordion-subtitle">What affects dispatch timing and estimated arrival windows.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-4" data-legal-panel hidden>
                        <ul class="legal-detail-list">
                            <li>Delivery timelines depend on destination, courier availability, and operational conditions.</li>
                            <li>Estimated delivery windows are indicative and may change.</li>
                            <li>Customers should provide a valid delivery address and contact details for successful fulfillment.</li>
                            <li>Delays caused by events outside normal control may affect dispatch or delivery timing.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="returns-and-refunds">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-5">
                        <span class="legal-accordion-icon"><i class="fas fa-rotate-left"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Returns and Refunds</span>
                            <span class="legal-accordion-subtitle">How damaged, incorrect, and return-review requests are processed.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-5" data-legal-panel hidden>
                        <p>Return or replacement handling depends on the condition of the item, the issue reported, and the store policy in effect at the time of purchase.</p>
                        <ul class="legal-detail-list">
                            <li>Customers should report damaged or incorrect items promptly after delivery.</li>
                            <li>Items may need to be unused and in original condition to qualify for return review.</li>
                            <li>Approval, replacement, or refund timing may depend on inspection and order details.</li>
                        </ul>
                        <div class="legal-note">
                            <strong>Tip:</strong> Keep your order ID and photos ready when contacting support about an issue.
                        </div>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="product-information">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-6">
                        <span class="legal-accordion-icon"><i class="fas fa-box-open"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Product Information</span>
                            <span class="legal-accordion-subtitle">Why images, finishes, and dimensions may still vary slightly.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-6" data-legal-panel hidden>
                        <p>We aim to present products as accurately as possible, but some variation can still occur.</p>
                        <ul class="legal-detail-list">
                            <li>Colors may vary depending on screen and device settings.</li>
                            <li>Measurements and finishes may include minor variation.</li>
                            <li>Product details, pricing, and availability may change without prior notice.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="acceptable-use">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-7">
                        <span class="legal-accordion-icon"><i class="fas fa-scale-balanced"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Acceptable Use</span>
                            <span class="legal-accordion-subtitle">What visitors and customers should not do on the website.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-7" data-legal-panel hidden>
                        <p>Users may not misuse the website or attempt to interfere with normal operation.</p>
                        <ul class="legal-detail-list">
                            <li>Do not provide false information or impersonate another person.</li>
                            <li>Do not attempt unauthorized access to customer, admin, or server systems.</li>
                            <li>Do not scrape, automate, or abuse the site in a way that disrupts service.</li>
                            <li>Do not submit unlawful, abusive, or harmful content.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="intellectual-property">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-8">
                        <span class="legal-accordion-icon"><i class="fas fa-copyright"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Intellectual Property</span>
                            <span class="legal-accordion-subtitle">Ownership of branding, images, writing, and design assets.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-8" data-legal-panel hidden>
                        <p>Website branding, product presentation, text, images, and design assets remain the property of The Divine Decor or the relevant rights holder. They may not be reproduced or reused without permission.</p>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="limitation-of-liability">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-9">
                        <span class="legal-accordion-icon"><i class="fas fa-shield"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Limitation of Liability</span>
                            <span class="legal-accordion-subtitle">The boundaries of responsibility tied to orders and website use.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-9" data-legal-panel hidden>
                        <p>To the extent permitted by law, The Divine Decor is not liable for indirect or consequential losses arising from website use, delivery delays, or product use beyond the value of the relevant order.</p>
                    </div>
                </article>

                <article class="legal-accordion-item legal-accordion-item-terms" id="terms-contact">
                    <button class="legal-accordion-trigger legal-accordion-trigger-terms" type="button" data-legal-trigger aria-expanded="false" aria-controls="terms-panel-10">
                        <span class="legal-accordion-icon"><i class="fas fa-envelope"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Contact Us</span>
                            <span class="legal-accordion-subtitle">Where to reach us if you need help with these terms.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="terms-panel-10" data-legal-panel hidden>
                        <p>Questions about these terms can be directed to our team using the contact details below.</p>
                        <ul class="legal-detail-list">
                            <li>Email: hello@divinedecor.in</li>
                            <li>Phone: +91 98765 43210</li>
                            <li>Location: Surat, Gujarat, India</li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
</body>
</html>
