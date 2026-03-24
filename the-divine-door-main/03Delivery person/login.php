<?php
session_start();
include('../config/dbcon.php');

$deliveryAssetBase = '/The-Divine-Decor/the-divine-door-main/03Delivery%20person';
$deliveryAssetVersion = 'delivery-auth-refresh-20260317-1';
$storefrontUrl = '/The-Divine-Decor/the-divine-door-main/02User-side/index.php';
$visualImage = '/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/img-grid-1.jpg';

$email = $pass = '';
$email_err = $pass_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty(trim($_POST['email'] ?? ''))) {
        $email_err = 'Please enter email.';
    } else {
        $email = trim($_POST['email']);
    }

    if (empty(trim($_POST['password'] ?? ''))) {
        $pass_err = 'Please enter your password.';
    } else {
        $pass = trim($_POST['password']);
    }

    if ($email_err === '' && $pass_err === '') {
        $sql = 'SELECT delivery_person_id, Email, Password, Name FROM delivery_person WHERE Email = ?';

        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param('s', $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($id, $email_res, $password, $name);

                    if ($stmt->fetch()) {
                        if ($pass === $password) {
                            $_SESSION['auth'] = true;
                            $_SESSION['delivery_id'] = $id;
                            $_SESSION['auth_user'] = [
                                'name' => $name,
                                'email' => $email_res,
                            ];
                            header('Location: index.php');
                            exit();
                        }

                        $pass_err = 'The password you entered was not valid.';
                    }
                } else {
                    $email_err = 'No account found with that email.';
                }
            } else {
                $pass_err = 'Oops! Something went wrong. Please try again later.';
            }

            $stmt->close();
        }
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Login | The Divine Decor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $deliveryAssetBase ?>/css/delivery-auth.css?v=<?= $deliveryAssetVersion ?>">
</head>
<body class="delivery-auth-body">
    <div class="delivery-auth-layout">
        <section class="delivery-auth-visual">
            <img src="<?= $visualImage ?>" alt="The Divine Decor">

            <div class="delivery-auth-copy">
                <div class="delivery-auth-brand">
                    <span class="delivery-auth-mark">DD</span>
                    <span class="delivery-auth-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Delivery console</span>
                    </span>
                </div>

                <div class="delivery-auth-story">
                    <span class="delivery-auth-eyebrow">Premium route control</span>
                    <h1>Deliver each order with calm precision.</h1>
                    <p>Track assignments, update statuses, and keep every customer handoff feeling polished from dispatch to doorstep.</p>

                    <div class="delivery-story-pills">
                        <span><i class="fas fa-route"></i> Clear route flow</span>
                        <span><i class="fas fa-box-open"></i> Assignment tracking</span>
                        <span><i class="fas fa-circle-check"></i> Real-time status updates</span>
                    </div>
                </div>

                <div class="delivery-visual-card">
                    <div class="delivery-visual-metric">
                        <span>Today</span>
                        <strong>Keep deliveries moving smoothly and visibly.</strong>
                    </div>
                    <div class="delivery-visual-divider"></div>
                    <div class="delivery-visual-metric">
                        <span>Portal focus</span>
                        <strong>Faster updates, cleaner handoffs, better order confidence.</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="delivery-auth-panel">
            <div class="delivery-auth-card">
                <span class="delivery-auth-badge"><i class="fas fa-truck-fast"></i> Delivery portal</span>
                <h2>Welcome <em>back.</em></h2>
                <p>Sign in to manage assigned deliveries, update order statuses, and keep every handoff dependable.</p>

                <div class="delivery-auth-notes">
                    <span><i class="fas fa-clock"></i> Live order visibility</span>
                    <span><i class="fas fa-wallet"></i> Payment follow-up ready</span>
                </div>

                <?php if ($email_err !== '' || $pass_err !== ''): ?>
                    <div class="delivery-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($email_err !== '' ? $email_err : $pass_err) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="delivery-auth-form">
                    <div class="delivery-auth-field">
                        <label for="email">Email address</label>
                        <div class="delivery-auth-input-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="delivery@divinedecor.com"
                                autocomplete="username"
                                required
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            >
                        </div>
                    </div>

                    <div class="delivery-auth-field">
                        <label for="password">Password</label>
                        <div class="delivery-auth-input-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="delivery-auth-toggle" id="togglePassword" aria-label="Show password">
                                <i class="fas fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="delivery-auth-submit">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In to Dashboard
                    </button>
                </form>

                <div class="delivery-auth-divider">
                    <hr>
                    <span>or</span>
                    <hr>
                </div>

                <a href="<?= $storefrontUrl ?>" class="delivery-auth-back-link">
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
