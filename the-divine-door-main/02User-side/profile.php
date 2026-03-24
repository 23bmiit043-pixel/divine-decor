<?php
session_start();
include 'connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$sql = "SELECT * FROM customer WHERE Cid = ?";
if ($stmt = mysqli_prepare($con, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["cid"]);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Error executing query. Please try again.";
        exit;
    }
} else {
    echo "Database error. Please try again.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | The Divine Decor</title>
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
                    <span class="section-kicker">Account center</span>
                    <h1>My Profile</h1>
                    <p>Manage your personal details, keep your account information up to date, and move through your orders with the same premium experience as the storefront.</p>
                </div>
                <div class="page-hero-meta">
                    <span><?= htmlspecialchars($user['Email']) ?></span>
                    <a href="orders.php" class="btn btn-white-outline">View Orders</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell compact-top">
        <div class="container">
            <div class="account-shell">
                <aside class="account-card">
                    <div class="account-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="account-meta-label">Signed in as</span>
                    <span class="account-meta-value"><?= htmlspecialchars($user['C_name']) ?></span>
                    <p class="mt-3 mb-0">Use the account area to manage profile details, track orders, and update your password securely.</p>

                    <div class="account-nav">
                        <a href="profile.php" class="active"><i class="fas fa-id-card"></i> My Profile</a>
                        <a href="orders.php"><i class="fas fa-box"></i> My Orders</a>
                        <a href="update_pass.php"><i class="fas fa-key"></i> Update Password</a>
                    </div>
                </aside>

                <div class="account-card">
                    <div class="section-head">
                        <div>
                            <span class="section-kicker">Profile details</span>
                            <h2 class="section-title">Update your information</h2>
                        </div>
                    </div>

                    <form method="post" action="update_profile.php" class="account-form-grid">
                        <div>
                            <label class="form-label mb-2 fw-bold">Name</label>
                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['C_name']) ?>">
                        </div>
                        <div>
                            <label class="form-label mb-2 fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['Email']) ?>">
                        </div>
                        <div>
                            <label class="form-label mb-2 fw-bold">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['Contact_no']) ?>">
                        </div>
                        <div>
                            <label class="form-label mb-2 fw-bold">Gender</label>
                            <select class="form-select form-control" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" <?= $user['Gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $user['Gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= $user['Gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="account-field-full">
                            <label class="form-label mb-2 fw-bold">Address</label>
                            <textarea class="form-control" name="address" rows="4"><?= htmlspecialchars($user['Address']) ?></textarea>
                        </div>
                        <div class="account-field-full d-flex flex-wrap gap-3">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <a href="orders.php" class="btn btn-outline-dark">Go to Orders</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/bootstrap.bundle.min.js?v=site-refresh-20260317-3"></script>
    <script src="/The-Divine-Decor/the-divine-door-main/02User-side/js/custom.js?v=site-refresh-20260317-3"></script>
</body>
</html>
