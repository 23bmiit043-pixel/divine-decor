<?php
session_start();
include("connect.php");

$adminAssetBase = '/The-Divine-Decor/the-divine-door-main/01Admin%20side';
$adminLoginAssetVersion = 'admin-refresh-20260317-4';
$storefrontUrl = '/The-Divine-Decor/the-divine-door-main/02User-side/index.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admin WHERE Email='$email' AND Password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['aid'];
        $_SESSION['admin_email'] = $row['Email'];
        $_SESSION['admin_name'] = trim(($row['FirstName'] ?? '') . ' ' . ($row['LastName'] ?? ''));
        $_SESSION['admin_loggedin'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | The Divine Decor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $adminAssetBase ?>/css/admin-login.css?v=<?= $adminLoginAssetVersion ?>">
</head>
<body class="admin-auth-body">
    <div class="admin-auth-layout">
        <section class="auth-visual">
            <img src="<?= $adminAssetBase ?>/Images/img-grid-1.jpg" alt="The Divine Decor">
            <div class="auth-visual-copy">
                <div class="auth-brand">
                    <span class="auth-brand-mark">DD</span>
                    <span class="auth-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Admin portal</span>
                    </span>
                </div>

                <div class="auth-headline">
                    <span class="auth-eyebrow">Premium commerce control</span>
                    <h1>Manage every detail with clarity.</h1>
                    <p>Access products, orders, payments, and reporting from a cleaner admin experience built to feel premium and professional.</p>

                    <div class="auth-story-pills">
                        <span><i class="fas fa-boxes-stacked"></i> Product oversight</span>
                        <span><i class="fas fa-receipt"></i> Order operations</span>
                        <span><i class="fas fa-chart-column"></i> Reporting flow</span>
                    </div>
                </div>

                <div class="auth-visual-card">
                    <div class="auth-visual-item">
                        <span>Inside the dashboard</span>
                        <strong>Review orders, manage listings, and keep operations moving from one premium control surface.</strong>
                    </div>
                    <div class="auth-visual-divider"></div>
                    <div class="auth-visual-item">
                        <span>Admin focus</span>
                        <strong>Better visibility, tighter workflows, and a more polished day-to-day management experience.</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <span class="auth-badge"><i class="fas fa-shield-halved"></i> Secure sign in</span>
                <h2>Welcome <em>back.</em></h2>
                <p>Sign in to continue managing The Divine Decor.</p>

                <div class="auth-notes">
                    <span><i class="fas fa-store"></i> Products and orders</span>
                    <span><i class="fas fa-credit-card"></i> Payments and reporting</span>
                </div>

                <?php if (isset($error)): ?>
                    <div class="auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="auth-form">
                    <div class="auth-field">
                        <label for="email">Email address</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="admin@divinedecor.com"
                                required
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                            >
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="password">Password</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="auth-toggle" id="togglePassword" aria-label="Show password">
                                <i class="fas fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="login" class="auth-submit">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In to Dashboard
                    </button>
                </form>

                <div class="auth-divider">
                    <hr>
                    <span>or</span>
                    <hr>
                </div>

                <a href="<?= $storefrontUrl ?>" class="auth-back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to storefront
                </a>
            </div>
        </section>
    </div>

    <script>
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (toggleButton && passwordInput && toggleIcon) {
            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.classList.toggle('fa-eye-slash', !isPassword);
                toggleIcon.classList.toggle('fa-eye', isPassword);
            });
        }
    </script>
</body>
</html>
