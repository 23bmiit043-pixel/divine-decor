<?php
session_start();

if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'connect.php';

$adminId = (int) $_SESSION['admin_id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE aid = ?");
mysqli_stmt_bind_param($stmt, "i", $adminId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = $result ? mysqli_fetch_assoc($result) : null;

if (!$admin) {
    $_SESSION['error'] = 'Unable to load the admin profile right now.';
    header('Location: index.php');
    exit();
}

$page_title = 'Admin Profile';
$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

$adminName = trim((string) ($admin['FirstName'] ?? '') . ' ' . (string) ($admin['LastName'] ?? ''));
if ($adminName === '') {
    $adminName = 'Administrator';
}

$profileDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'admin';
$profileFilename = trim((string) ($admin['adminProfile'] ?? ''));
$profileUrl = '';

if ($profileFilename !== '' && is_file($profileDirectory . DIRECTORY_SEPARATOR . $profileFilename)) {
    $profileUrl = '/The-Divine-Decor/the-divine-door-main/01Admin%20side/images/admin/' . rawurlencode($profileFilename);
}

include 'includes/header.php';
include 'includes/topbar.php';
include 'includes/sidebar.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid dashboard-shell">
      <div class="dashboard-hero admin-page-hero">
        <div>
          <span class="admin-eyebrow">Account center</span>
          <h1>Admin profile</h1>
          <p>Manage your administrator details, keep profile information current, and maintain a cleaner account experience inside the premium dashboard.</p>
        </div>
        <div class="dashboard-actions">
          <a href="index.php" class="btn btn-light">Back to Dashboard</a>
          <a href="changepassword.php" class="btn btn-outline-light">Change Password</a>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid dashboard-shell">
      <?php if ($successMessage !== ''): ?>
        <div class="admin-flash admin-flash-success">
          <i class="fas fa-circle-check"></i>
          <span><?= htmlspecialchars($successMessage) ?></span>
        </div>
      <?php endif; ?>

      <?php if ($errorMessage !== ''): ?>
        <div class="admin-flash admin-flash-error">
          <i class="fas fa-circle-exclamation"></i>
          <span><?= htmlspecialchars($errorMessage) ?></span>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-xl-4 col-lg-5 mb-4">
          <div class="card admin-panel-card profile-overview-card">
            <div class="card-body">
              <div class="profile-avatar-shell">
                <?php if ($profileUrl !== ''): ?>
                  <img src="<?= htmlspecialchars($profileUrl) ?>" class="profile-avatar-image" alt="<?= htmlspecialchars($adminName) ?>">
                <?php else: ?>
                  <div class="profile-avatar-placeholder">
                    <i class="fas fa-user-shield"></i>
                  </div>
                <?php endif; ?>
              </div>

              <h2 class="profile-name"><?= htmlspecialchars($adminName) ?></h2>
              <p class="profile-role">Administrator</p>

              <div class="profile-meta-list">
                <div class="profile-meta-item">
                  <span>Email</span>
                  <strong><?= htmlspecialchars((string) ($admin['Email'] ?? 'Not available')) ?></strong>
                </div>
                <div class="profile-meta-item">
                  <span>Contact</span>
                  <strong><?= htmlspecialchars((string) ($admin['Cellno'] ?? 'Not available')) ?></strong>
                </div>
                <div class="profile-meta-item">
                  <span>State</span>
                  <strong><?= htmlspecialchars((string) ($admin['State'] ?? 'Not available')) ?></strong>
                </div>
              </div>

              <form action="update_profile_picture.php" method="POST" enctype="multipart/form-data" class="profile-upload-form">
                <div class="form-group text-left">
                  <label for="profile_picture">Profile Picture</label>
                  <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Profile Picture</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-xl-8 col-lg-7 mb-4">
          <div class="card admin-panel-card">
            <div class="card-header">
              <h3 class="card-title">Personal information</h3>
            </div>
            <div class="card-body">
              <table class="table table-borderless admin-detail-table">
                <tbody>
                  <tr>
                    <th>Admin ID</th>
                    <td><?= htmlspecialchars((string) ($admin['aid'] ?? $adminId)) ?></td>
                  </tr>
                  <tr>
                    <th>First Name</th>
                    <td><?= htmlspecialchars((string) ($admin['FirstName'] ?? '')) ?></td>
                  </tr>
                  <tr>
                    <th>Last Name</th>
                    <td><?= htmlspecialchars((string) ($admin['LastName'] ?? '')) ?></td>
                  </tr>
                  <tr>
                    <th>Email Address</th>
                    <td><?= htmlspecialchars((string) ($admin['Email'] ?? '')) ?></td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td><?= htmlspecialchars((string) ($admin['Gender'] ?? 'Not specified')) ?></td>
                  </tr>
                  <tr>
                    <th>Contact Number</th>
                    <td><?= htmlspecialchars((string) ($admin['Cellno'] ?? '')) ?></td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td><?= htmlspecialchars((string) ($admin['Address'] ?? '')) ?></td>
                  </tr>
                  <tr>
                    <th>State</th>
                    <td><?= htmlspecialchars((string) ($admin['State'] ?? '')) ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-12 mb-4">
          <div class="card admin-panel-card">
            <div class="card-header">
              <h3 class="card-title">Account snapshot</h3>
            </div>
            <div class="card-body">
              <div class="admin-summary-grid">
                <div class="admin-summary-card">
                  <span class="admin-summary-label">Profile file</span>
                  <strong class="admin-summary-value"><?= htmlspecialchars($profileFilename !== '' ? $profileFilename : 'No image uploaded') ?></strong>
                </div>
                <div class="admin-summary-card">
                  <span class="admin-summary-label">Access level</span>
                  <strong class="admin-summary-value">Full admin access</strong>
                </div>
                <div class="admin-summary-card">
                  <span class="admin-summary-label">Session status</span>
                  <strong class="admin-summary-value">Signed in</strong>
                </div>
                <div class="admin-summary-card">
                  <span class="admin-summary-label">Dashboard focus</span>
                  <strong class="admin-summary-value">Catalog, orders, and reports</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'script.php'; ?>
<?php include 'includes/footer.php'; ?>
