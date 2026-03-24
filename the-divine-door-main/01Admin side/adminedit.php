<?php
include('config.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($_SESSION['status'])) {
      echo "<h4>" . $_SESSION['status'] . "</h4>";
      unset($_SESSION['status']);
  }
  ?>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit Admin</h3>
              <a href="admin.php" class="btn btn-danger">Back</a>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-8 col-lg-10">
                  <form action="code.php" method="POST" enctype="multipart/form-data">
                    <?php
                    if (isset($_GET['aid'])) {
                        $admin_id = $_GET['aid'];
                        $query = "SELECT * FROM admin WHERE aid='$admin_id' LIMIT 1";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                                $profileImage = trim((string) ($row['adminProfile'] ?? ''));
                                $profileImageUrl = '';
                                if ($profileImage !== '') {
                                    $profileImageUrl = '/The-Divine-Decor/the-divine-door-main/01Admin%20side/images/admin/' . rawurlencode($profileImage);
                                }
                                ?>
                                <input type="hidden" name="admin_id" value="<?php echo $row['aid']; ?>">

                                <div class="form-group">
                                  <label for="email">Email</label>
                                  <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <label for="firstname">First Name</label>
                                  <input type="text" id="firstname" name="firstname" value="<?php echo $row['FirstName']; ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <label for="lastname">Last Name</label>
                                  <input type="text" id="lastname" name="lastname" value="<?php echo $row['LastName']; ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <label for="gender">Gender</label>
                                  <select id="gender" name="gender" class="form-control" required>
                                    <option value="Male" <?php echo ($row['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($row['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo ($row['Gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label for="address">Address</label>
                                  <textarea id="address" name="address" class="form-control" required><?php echo $row['Address']; ?></textarea>
                                </div>

                                <div class="form-group">
                                  <label for="state">State</label>
                                  <input type="text" id="state" name="state" value="<?php echo $row['State']; ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <label for="cellno">Cell Number</label>
                                  <input type="text" id="cellno" name="cellno" value="<?php echo $row['Cellno']; ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <label for="adminProfile">Profile Image</label>
                                  <?php if ($profileImageUrl !== ''): ?>
                                    <div class="mb-3">
                                      <img src="<?php echo $profileImageUrl; ?>" alt="Current Profile" style="width: 96px; height: 96px; object-fit: cover; border-radius: 20px;">
                                    </div>
                                  <?php endif; ?>
                                  <input type="file" id="adminProfile" name="adminProfile" class="form-control" accept="image/*">
                                  <input type="hidden" name="old_image" value="<?php echo $profileImage; ?>">
                                  <small class="text-muted">Allowed file types: jpg, jpeg, png, gif</small>
                                </div>

                                <div class="form-group">
                                  <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="changePassword" name="change_password">
                                    <label class="custom-control-label" for="changePassword">Change Password</label>
                                  </div>
                                </div>

                                <div id="passwordFields" style="display: none;">
                                  <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" id="currentPassword">
                                  </div>

                                  <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="newPassword">
                                    <small class="text-muted">Password must be at least 8 characters long</small>
                                  </div>

                                  <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
                                  </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<h4>No Record Found.</h4>";
                        }
                    }
                    ?>

                    <div class="mt-4">
                      <button type="submit" name="updateadmin" class="btn btn-info">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const changePassword = document.getElementById('changePassword');
  const passwordFields = document.getElementById('passwordFields');

  if (!changePassword || !passwordFields) {
    return;
  }

  changePassword.addEventListener('change', function () {
    passwordFields.style.display = this.checked ? 'block' : 'none';
    const passwordInputs = passwordFields.querySelectorAll('input');
    passwordInputs.forEach(function (input) {
      input.required = changePassword.checked;
    });
  });
});
</script>

<?php include('script.php'); ?>
<?php include('includes/footer.php'); ?>
