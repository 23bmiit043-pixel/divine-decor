<?php
session_start();
require 'connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT Password FROM customer WHERE Cid = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["cid"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($old_password === $user['Password']) {
        if ($new_password === $confirm_password) {
            $update_sql = "UPDATE customer SET Password = ? WHERE Cid = ?";
            $update_stmt = mysqli_prepare($con, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "si", $new_password, $_SESSION["cid"]);

            if (mysqli_stmt_execute($update_stmt)) {
                $message = "Password updated successfully.";
            } else {
                $error = "Error updating password.";
            }
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password | The Divine Decor</title>
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/bootstrap.min.css?v=site-refresh-20260317-3" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/style.css?v=site-refresh-20260317-3" rel="stylesheet">
  <link href="/The-Divine-Decor/the-divine-door-main/02User-side/css/premium.css?v=site-refresh-20260317-3" rel="stylesheet">
</head>
<body class="page-account">
    <?php include 'includes/nav.php'; ?>

    <section class="page-hero">
        <div class="container">
            <div class="page-hero-shell">
                <div>
                    <span class="section-kicker">Security</span>
                    <h1>Update Password</h1>
                    <p>Keep your account secure with a cleaner password update flow that matches the rest of the refreshed customer experience.</p>
                </div>
                <div class="page-hero-meta">
                    <span><?= htmlspecialchars($_SESSION['email']) ?></span>
                    <a href="profile.php" class="btn btn-white-outline">Back to Profile</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell compact-top">
        <div class="container">
            <div class="account-shell">
                <aside class="account-card">
                    <div class="account-avatar">
                        <i class="fas fa-key"></i>
                    </div>
                    <span class="account-meta-label">Security center</span>
                    <span class="account-meta-value">Password & access</span>
                    <p class="mt-3 mb-0">Use a password that is easy for you to remember but difficult for others to guess.</p>

                    <div class="account-nav">
                        <a href="profile.php"><i class="fas fa-id-card"></i> My Profile</a>
                        <a href="orders.php"><i class="fas fa-box"></i> My Orders</a>
                        <a href="update_pass.php" class="active"><i class="fas fa-key"></i> Update Password</a>
                    </div>
                </aside>

                <div class="account-card">
                    <div class="section-head">
                        <div>
                            <span class="section-kicker">Password update</span>
                            <h2 class="section-title">Change your password</h2>
                        </div>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-success mb-4"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger mb-4"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" class="account-form-grid">
                        <div class="account-field-full">
                            <label class="form-label mb-2 fw-bold">Current Password</label>
                            <div class="position-relative">
                                <input type="password" name="old_password" class="form-control pe-5" required>
                                <button type="button" class="position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent text-muted toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="form-label mb-2 fw-bold">New Password</label>
                            <div class="position-relative">
                                <input type="password" name="new_password" class="form-control pe-5" required>
                                <button type="button" class="position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent text-muted toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="form-label mb-2 fw-bold">Confirm New Password</label>
                            <div class="position-relative">
                                <input type="password" name="confirm_password" class="form-control pe-5" required>
                                <button type="button" class="position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent text-muted toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="account-field-full d-flex flex-wrap gap-3">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                            <a href="profile.php" class="btn btn-outline-dark">Return to Profile</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = button.previousElementSibling;
                const icon = button.querySelector('i');
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });
    </script>
</body>
</html>
