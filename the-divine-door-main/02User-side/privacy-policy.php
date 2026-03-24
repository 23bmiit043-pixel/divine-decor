<?php
session_start();
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | The Divine Decor</title>
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
                <h1>Privacy Policy</h1>
                <p>How The Divine Decor collects, uses, stores, and protects customer information across the website and order process.</p>
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
                        <h2 class="section-title">Your privacy matters here.</h2>
                    </div>
                    <p class="section-text">We only use the information needed to deliver orders, support your account, and improve the shopping experience. This page outlines the practical details in plain language.</p>
                </div>
            </div>

            <div class="legal-accordion-shell" data-legal-accordion>
                <article class="legal-accordion-item" id="information-we-collect">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-1">
                        <span class="legal-accordion-icon"><i class="fas fa-database"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Information We Collect</span>
                            <span class="legal-accordion-subtitle">The account, checkout, and browsing details we store.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-1" data-legal-panel hidden>
                        <p>When you browse, register, or place an order, we may collect information required to support your account and fulfill purchases.</p>
                        <ul class="legal-detail-list">
                            <li>Name, email address, contact number, and delivery address.</li>
                            <li>Account details such as login credentials and basic profile information.</li>
                            <li>Order history, billing details, cart activity, and product selections.</li>
                            <li>Device and usage information such as browser type, IP address, and pages visited.</li>
                            <li>Messages, feedback, and support requests you send through the site.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item" id="how-we-use-information">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-2">
                        <span class="legal-accordion-icon"><i class="fas fa-gear"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">How We Use Information</span>
                            <span class="legal-accordion-subtitle">Why customer details are used inside the store workflow.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-2" data-legal-panel hidden>
                        <p>We use customer information to run the website effectively and to provide the services expected from an e-commerce experience.</p>
                        <ul class="legal-detail-list">
                            <li>Process orders, confirm purchases, and coordinate delivery.</li>
                            <li>Respond to support requests and account-related questions.</li>
                            <li>Maintain account access and essential website functionality.</li>
                            <li>Improve product discovery, storefront performance, and customer support quality.</li>
                            <li>Prevent fraud, misuse, and unauthorized activity.</li>
                        </ul>
                        <div class="legal-note">
                            <strong>Important:</strong> We do not sell or rent customer information to third parties for their own marketing use.
                        </div>
                    </div>
                </article>

                <article class="legal-accordion-item" id="sharing-and-disclosure">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-3">
                        <span class="legal-accordion-icon"><i class="fas fa-share-nodes"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Sharing and Disclosure</span>
                            <span class="legal-accordion-subtitle">When information may be passed to delivery or service partners.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-3" data-legal-panel hidden>
                        <p>Information is shared only when needed to complete a legitimate business function or comply with legal requirements.</p>
                        <ul class="legal-detail-list">
                            <li>Delivery partners may receive shipping details required to fulfill an order.</li>
                            <li>Service providers may assist with technical operations such as email or hosting.</li>
                            <li>Information may be disclosed if required by law or to protect the website, business, or users.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item" id="cookies-and-site-data">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-4">
                        <span class="legal-accordion-icon"><i class="fas fa-cookie-bite"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Cookies and Site Data</span>
                            <span class="legal-accordion-subtitle">How sessions, cart memory, and preferences are maintained.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-4" data-legal-panel hidden>
                        <p>Cookies and session data help the website remember your login, cart contents, and browsing preferences.</p>
                        <ul class="legal-detail-list">
                            <li>Keep users signed in during a session.</li>
                            <li>Preserve cart details and improve continuity between pages.</li>
                            <li>Support analytics and usability improvements.</li>
                        </ul>
                        <p>You can disable cookies in your browser, but some parts of the store may not work as expected.</p>
                    </div>
                </article>

                <article class="legal-accordion-item" id="data-security">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-5">
                        <span class="legal-accordion-icon"><i class="fas fa-shield-halved"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Data Security</span>
                            <span class="legal-accordion-subtitle">The steps taken to protect accounts and operational records.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-5" data-legal-panel hidden>
                        <p>We take reasonable measures to protect customer data and reduce the risk of misuse, unauthorized access, or accidental exposure.</p>
                        <ul class="legal-detail-list">
                            <li>Access to account data is limited to required administrative workflows.</li>
                            <li>The site uses standard website security practices and controlled database access.</li>
                            <li>Operational reviews and updates may be performed to improve site safety and reliability.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item" id="your-rights">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-6">
                        <span class="legal-accordion-icon"><i class="fas fa-user-shield"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Your Rights</span>
                            <span class="legal-accordion-subtitle">What you can request about your personal information and account.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-6" data-legal-panel hidden>
                        <p>You may contact us to review or update your account details and to request help with account-related privacy concerns.</p>
                        <ul class="legal-detail-list">
                            <li>Request correction of inaccurate account information.</li>
                            <li>Ask questions about how your information is used for orders and support.</li>
                            <li>Request help closing your account where operationally appropriate.</li>
                            <li>Opt out of optional promotional communication if offered.</li>
                        </ul>
                    </div>
                </article>

                <article class="legal-accordion-item" id="order-records">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-7">
                        <span class="legal-accordion-icon"><i class="fas fa-box"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Order Records</span>
                            <span class="legal-accordion-subtitle">How long purchase history may be retained for business operations.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-7" data-legal-panel hidden>
                        <p>Order records may be retained for business operations, support history, and accounting needs. Retention periods can vary depending on operational or legal requirements.</p>
                    </div>
                </article>

                <article class="legal-accordion-item" id="contact-us">
                    <button class="legal-accordion-trigger" type="button" data-legal-trigger aria-expanded="false" aria-controls="privacy-panel-8">
                        <span class="legal-accordion-icon"><i class="fas fa-envelope"></i></span>
                        <span class="legal-accordion-copy">
                            <span class="legal-accordion-title">Contact Us</span>
                            <span class="legal-accordion-subtitle">How to reach The Divine Decor for privacy-related questions.</span>
                        </span>
                        <span class="legal-accordion-toggle"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="legal-accordion-panel" id="privacy-panel-8" data-legal-panel hidden>
                        <p>If you have questions about this Privacy Policy, please contact The Divine Decor using the details below.</p>
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
