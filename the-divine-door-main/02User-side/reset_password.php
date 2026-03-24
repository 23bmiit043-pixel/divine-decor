<?php
session_start();
include 'connect.php';

$new_password = '';
$confirm_password = '';
$new_password_err = '';
$confirm_password_err = '';
$token_err = '';
$success_msg = '';
$token = $_GET['token'] ?? '';
$token_hash = '';

if ($token === '') {
    header("location: forgot_password.php");
    exit;
}

$token_hash = hash('sha256', $token);

$sql = "SELECT Cid, Email FROM customer WHERE reset_token = ? AND reset_token_expiry > NOW()";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $token_hash);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows !== 1) {
            $token_err = "This reset link is invalid or has expired.";
        }
    } else {
        $token_err = "Password reset is temporarily unavailable.";
    }

    $stmt->close();
} else {
    $token_err = "Password reset is not available for this installation.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($token_err)) {
    if (empty(trim($_POST["new_password"] ?? ''))) {
        $new_password_err = "Please enter a new password.";
    } else {
        $new_password = trim($_POST["new_password"]);
        if (strlen($new_password) < 8) {
            $new_password_err = "Password must have at least 8 characters.";
        }
    }

    if (empty(trim($_POST["confirm_password"] ?? ''))) {
        $confirm_password_err = "Please confirm your new password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && $new_password !== $confirm_password) {
            $confirm_password_err = "Passwords do not match.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $update_sql = "UPDATE customer SET Password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
        if ($update_stmt = $con->prepare($update_sql)) {
            $update_stmt->bind_param("ss", $new_password, $token_hash);

            if ($update_stmt->execute()) {
                header("location: login.php?password_reset=success");
                exit;
            }

            $token_err = "We could not reset your password right now.";
            $update_stmt->close();
        } else {
            $token_err = "Password reset is not available for this installation.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | The Divine Decor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/The-Divine-Decor/the-divine-door-main/02User-side/css/login.css">
</head>
<body class="customer-auth-body">
    <div class="customer-auth-layout">
        <section class="customer-auth-visual">
            <img src="/The-Divine-Decor/the-divine-door-main/02User-side/images/img-grid-1.jpg" alt="The Divine Decor password reset">
            <div class="customer-auth-copy">
                <div class="customer-auth-brand">
                    <span class="customer-auth-brand-mark">DD</span>
                    <span class="customer-auth-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Secure access</span>
                    </span>
                </div>

                <div class="customer-auth-headline">
                    <span class="customer-auth-eyebrow">New password</span>
                    <h1>Set a fresh password and continue.</h1>
                    <p>This screen updates your account password using the reset link you received. Choose something memorable and secure.</p>
                </div>
            </div>
        </section>

        <section class="customer-auth-panel">
            <div class="customer-auth-card">
                <span class="customer-auth-badge"><i class="fas fa-shield-halved"></i> Reset password</span>
                <h2>Create a new password</h2>
                <p>Use at least 8 characters so your account stays easier to protect.</p>

                <?php if (!empty($token_err)): ?>
                    <div class="customer-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($token_err) ?></span>
                    </div>
                <?php elseif (!empty($success_msg)): ?>
                    <div class="customer-auth-alert is-success">
                        <i class="fas fa-circle-check"></i>
                        <span><?= htmlspecialchars($success_msg) ?></span>
                    </div>
                <?php elseif (!empty($new_password_err) || !empty($confirm_password_err)): ?>
                    <div class="customer-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars(trim($new_password_err . ' ' . $confirm_password_err)) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (empty($token_err)): ?>
                    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?token=' . urlencode($token) ?>" class="customer-auth-form">
                        <div class="customer-auth-field">
                            <label for="new_password">New password</label>
                            <div class="customer-auth-input">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" id="new_password" name="new_password" placeholder="Minimum 8 characters" required>
                                <button type="button" class="customer-auth-toggle" data-password-toggle="new_password" aria-label="Show new password">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="customer-auth-field">
                            <label for="confirm_password">Confirm password</label>
                            <div class="customer-auth-input">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your new password" required>
                                <button type="button" class="customer-auth-toggle" data-password-toggle="confirm_password" aria-label="Show confirm password">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="customer-auth-submit">
                            <i class="fas fa-key"></i>
                            Update Password
                        </button>
                    </form>
                <?php endif; ?>

                <div class="customer-auth-links">
                    <a href="forgot_password.php">Request another link</a>
                    <a href="login.php">Back to sign in</a>
                </div>

                <div class="customer-auth-divider">
                    <hr>
                    <span>or</span>
                    <hr>
                </div>

                <a href="index.php" class="customer-auth-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to storefront
                </a>
            </div>
        </section>
    </div>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.getAttribute('data-password-toggle'));
                const icon = button.querySelector('i');

                if (!input || !icon) {
                    return;
                }

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye-slash', !isPassword);
                icon.classList.toggle('fa-eye', isPassword);
            });
        });
    </script>
</body>
</html>
