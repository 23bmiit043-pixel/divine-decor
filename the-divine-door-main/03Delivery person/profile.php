<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header('Location: login.php');
    exit();
}

include('../config/dbcon.php');

function deliveryAlertClass($message)
{
    $message = strtolower((string) $message);

    if (strpos($message, 'wrong') !== false || strpos($message, 'incorrect') !== false || strpos($message, 'failed') !== false) {
        return 'is-error';
    }

    return 'is-success';
}

$delivery_id = (int) $_SESSION['delivery_id'];
$delivery_query = "SELECT * FROM delivery_person WHERE delivery_person_id = '$delivery_id' LIMIT 1";
$delivery_result = mysqli_query($con, $delivery_query);
$delivery_data = $delivery_result ? mysqli_fetch_assoc($delivery_result) : [];
$flashMessage = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$delivery_name = trim((string) ($delivery_data['Name'] ?? 'Delivery Partner'));
$delivery_email = trim((string) ($delivery_data['Email'] ?? ''));
$delivery_phone = trim((string) ($delivery_data['Contact_no'] ?? ''));

$page_title = 'Delivery Profile';
$page_label = 'Profile';
include('includes/header.php');
?>

<section class="delivery-hero">
    <div>
        <span class="delivery-eyebrow">Account settings</span>
        <h1>Your delivery profile</h1>
        <p>Keep your personal details current and update your password from the same premium control surface used across the refreshed delivery panel.</p>
    </div>

    <div class="delivery-hero-actions">
        <?php if ($delivery_email !== ''): ?>
            <span class="delivery-meta-pill"><i class="fa-solid fa-envelope"></i><?= htmlspecialchars($delivery_email) ?></span>
        <?php endif; ?>
        <?php if ($delivery_phone !== ''): ?>
            <span class="delivery-meta-pill"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($delivery_phone) ?></span>
        <?php endif; ?>
    </div>
</section>

<div class="row mt-4">
    <div class="col-12">
        <?php if ($flashMessage !== ''): ?>
            <div class="delivery-alert <?= deliveryAlertClass($flashMessage) ?>">
                <i class="fa-solid fa-circle-info"></i>
                <span><?= htmlspecialchars($flashMessage) ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="delivery-form-grid mt-1">
    <section class="delivery-section-card">
        <div class="section-card-header">
            <div>
                <span class="delivery-section-chip"><i class="fa-solid fa-id-card"></i>Personal details</span>
                <h2 class="delivery-section-heading">Profile information</h2>
            </div>
        </div>

        <div class="section-card-body">
            <p class="delivery-muted-copy mb-4">Update the details that appear across your delivery account so assignments and communication stay accurate.</p>

            <form action="code.php" method="POST">
                <div class="mb-3">
                    <label class="form-label" for="delivery-name">Name</label>
                    <input type="text" id="delivery-name" name="name" value="<?= htmlspecialchars($delivery_name) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="delivery-email">Email</label>
                    <input type="email" id="delivery-email" name="email" value="<?= htmlspecialchars($delivery_email) ?>" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="delivery-phone">Phone</label>
                    <input type="text" id="delivery-phone" name="phone" value="<?= htmlspecialchars($delivery_phone) ?>" class="form-control" required>
                </div>

                <button type="submit" name="update_profile" class="btn btn-primary">Save profile</button>
            </form>
        </div>
    </section>

    <section class="delivery-section-card">
        <div class="section-card-header">
            <div>
                <span class="delivery-section-chip"><i class="fa-solid fa-lock"></i>Security</span>
                <h2 class="delivery-section-heading">Update password</h2>
            </div>
        </div>

        <div class="section-card-body">
            <p class="delivery-muted-copy mb-4">Refresh your password here whenever you want a more secure sign-in for the delivery console.</p>

            <form action="code.php" method="POST">
                <div class="mb-3">
                    <label class="form-label" for="current-password">Current password</label>
                    <input type="password" id="current-password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="new-password">New password</label>
                    <input type="password" id="new-password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="confirm-password">Confirm password</label>
                    <input type="password" id="confirm-password" name="confirm_password" class="form-control" required>
                </div>

                <button type="submit" name="update_password" class="btn btn-primary">Update password</button>
            </form>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
