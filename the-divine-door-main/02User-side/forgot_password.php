<?php
session_start();
include 'connect.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$email = '';
$email_err = '';
$success_msg = '';
$setup_err = '';

if (!file_exists('vendor/autoload.php')) {
    $setup_err = 'Password recovery email is not configured yet. Please contact the store administrator.';
} else {
    require 'vendor/autoload.php';
}

if (empty($setup_err) && !file_exists('config/email_config.php')) {
    $setup_err = 'Email configuration is missing. Please contact the store administrator.';
} elseif (empty($setup_err)) {
    require 'config/email_config.php';
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($setup_err)) {
    if (empty(trim($_POST["email"] ?? ''))) {
        $email_err = "Please enter your email address.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);

        $sql = "SELECT Cid FROM customer WHERE Email = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $temp_password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

                    $update_sql = "UPDATE customer SET Password = ? WHERE Email = ?";
                    if ($update_stmt = $con->prepare($update_sql)) {
                        $update_stmt->bind_param("ss", $temp_password, $email);

                        if ($update_stmt->execute()) {
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host = SMTP_HOST;
                                $mail->SMTPAuth = true;
                                $mail->Username = SMTP_USERNAME;
                                $mail->Password = SMTP_PASSWORD;
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port = SMTP_PORT;

                                $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
                                $mail->addAddress($email);
                                $mail->isHTML(true);
                                $mail->Subject = 'Temporary Password | The Divine Decor';
                                $mail->Body = "Your temporary password is: <strong>" . htmlspecialchars($temp_password, ENT_QUOTES, 'UTF-8') . "</strong><br><br>Please sign in and update your password from your profile.";

                                $mail->send();
                                $success_msg = "A temporary password has been sent to your email address.";
                            } catch (Exception $e) {
                                $email_err = "We could not send the recovery email right now. Please try again later.";
                            }
                        } else {
                            $email_err = "We could not update your password. Please try again.";
                        }

                        $update_stmt->close();
                    }
                } else {
                    $email_err = "No account was found with that email address.";
                }
            } else {
                $email_err = "We could not verify that email right now. Please try again.";
            }

            $stmt->close();
        } else {
            $email_err = "Password recovery is temporarily unavailable.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | The Divine Decor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/The-Divine-Decor/the-divine-door-main/02User-side/css/login.css">
</head>
<body class="customer-auth-body">
    <div class="customer-auth-layout">
        <section class="customer-auth-visual">
            <img src="/The-Divine-Decor/the-divine-door-main/02User-side/images/img-grid-2.jpg" alt="The Divine Decor password recovery">
            <div class="customer-auth-copy">
                <div class="customer-auth-brand">
                    <span class="customer-auth-brand-mark">DD</span>
                    <span class="customer-auth-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Account recovery</span>
                    </span>
                </div>

                <div class="customer-auth-headline">
                    <span class="customer-auth-eyebrow">Password help</span>
                    <h1>Recover access without the clutter.</h1>
                    <p>Enter the email linked to your account and we will send a temporary password so you can sign back in and update it from your profile.</p>
                </div>
            </div>
        </section>

        <section class="customer-auth-panel">
            <div class="customer-auth-card">
                <span class="customer-auth-badge"><i class="fas fa-key"></i> Password recovery</span>
                <h2>Forgot password?</h2>
                <p>We will send a temporary password to the email registered on your customer account.</p>

                <?php if (!empty($setup_err)): ?>
                    <div class="customer-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($setup_err) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_msg)): ?>
                    <div class="customer-auth-alert is-success">
                        <i class="fas fa-circle-check"></i>
                        <span><?= htmlspecialchars($success_msg) ?></span>
                    </div>
                <?php elseif (!empty($email_err)): ?>
                    <div class="customer-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($email_err) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="customer-auth-form">
                    <div class="customer-auth-field">
                        <label for="email">Email address</label>
                        <div class="customer-auth-input">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required value="<?= htmlspecialchars($email) ?>" <?= !empty($setup_err) ? 'disabled' : '' ?>>
                        </div>
                    </div>

                    <button type="submit" class="customer-auth-submit" <?= !empty($setup_err) ? 'disabled' : '' ?>>
                        <i class="fas fa-paper-plane"></i>
                        Send Temporary Password
                    </button>
                </form>

                <p class="customer-auth-helper">
                    <strong>Note:</strong> Once you sign in with the temporary password, update it from your profile security section.
                </p>

                <div class="customer-auth-links">
                    <a href="login.php">Back to sign in</a>
                    <a href="Reg.php">Create account</a>
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
</body>
</html>
