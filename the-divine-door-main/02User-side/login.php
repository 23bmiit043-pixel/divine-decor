<?php
session_start();

$customerLoginAssetVersion = 'login-refresh-20260317-2';

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "customer";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = "";
$pass = "";
$email_err = "";
$pass_err = "";
$success_msg = "";

if (isset($_GET['password_reset']) && $_GET['password_reset'] === 'success') {
    $success_msg = "Your password has been updated. Please sign in with your new password.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email address.";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $pass_err = "Please enter your password.";
    } else {
        $pass = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($pass_err)) {
        $sql = "SELECT Cid, Email, Password FROM customer WHERE Email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($id, $email, $passwordHash);

                    if ($stmt->fetch()) {
                        if ($pass === $passwordHash) {
                            $name_sql = "SELECT C_name FROM customer WHERE Cid = ?";

                            if ($name_stmt = $conn->prepare($name_sql)) {
                                $name_stmt->bind_param("i", $id);
                                $name_stmt->execute();
                                $name_result = $name_stmt->get_result();
                                $customer = $name_result->fetch_assoc();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["cid"] = $id;
                                $_SESSION["email"] = $email;
                                $_SESSION["name"] = $customer['C_name'];

                                header("location: index.php");
                                exit();
                            }
                        } else {
                            $pass_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | The Divine Decor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/The-Divine-Decor/the-divine-door-main/02User-side/css/login.css?v=<?= $customerLoginAssetVersion ?>">
</head>
<body class="customer-auth-body">
    <div class="customer-auth-layout">
        <section class="customer-auth-visual">
            <img src="/The-Divine-Decor/the-divine-door-main/02User-side/images/img-grid-1.jpg" alt="The Divine Decor">
            <div class="customer-auth-copy">
                <div class="customer-auth-brand">
                    <span class="customer-auth-brand-mark">DD</span>
                    <span class="customer-auth-brand-copy">
                        <strong>Divine Decor</strong>
                        <span>Premium living</span>
                    </span>
                </div>

                <div class="customer-auth-headline">
                    <span class="customer-auth-eyebrow">Welcome back</span>
                    <h1>Refined shopping starts here.</h1>
                    <p>Sign in to view orders, manage your account, and continue shopping through the refreshed premium storefront experience.</p>

                    <div class="customer-auth-story-pills">
                        <span><i class="fas fa-bag-shopping"></i> Faster checkout flow</span>
                        <span><i class="fas fa-heart"></i> Saved favorites</span>
                        <span><i class="fas fa-box-open"></i> Order tracking</span>
                    </div>
                </div>

                <div class="customer-auth-visual-card">
                    <div class="customer-auth-visual-item">
                        <span>Inside your account</span>
                        <strong>Track purchases, update details, and continue your premium shopping flow.</strong>
                    </div>
                    <div class="customer-auth-visual-divider"></div>
                    <div class="customer-auth-visual-item">
                        <span>Shopping focus</span>
                        <strong>Cleaner orders, smoother returns, and a more dependable account experience.</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="customer-auth-panel">
            <div class="customer-auth-card">
                <span class="customer-auth-badge"><i class="fas fa-user-check"></i> Customer sign in</span>
                <h2>Welcome <em>back.</em></h2>
                <p>Access your profile, order history, and saved shopping flow.</p>

                <div class="customer-auth-notes">
                    <span><i class="fas fa-clock-rotate-left"></i> Order history ready</span>
                    <span><i class="fas fa-user-gear"></i> Account settings in one place</span>
                </div>

                <?php if (!empty($success_msg)): ?>
                    <div class="customer-auth-alert is-success">
                        <i class="fas fa-circle-check"></i>
                        <span><?= htmlspecialchars($success_msg) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($email_err) || !empty($pass_err)): ?>
                    <div class="customer-auth-alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars(trim($email_err . ' ' . $pass_err)) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="customer-auth-form">
                    <div class="customer-auth-field">
                        <label for="email">Email address</label>
                        <div class="customer-auth-input">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required value="<?= htmlspecialchars($email) ?>">
                        </div>
                    </div>

                    <div class="customer-auth-field">
                        <label for="password">Password</label>
                        <div class="customer-auth-input">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="customer-auth-toggle" id="togglePassword" aria-label="Show password">
                                <i class="fas fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="customer-auth-submit">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In
                    </button>
                </form>

                <div class="customer-auth-links">
                    <a href="forgot_password.php">Forgot password?</a>
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

    <script>
        const loginToggleButton = document.getElementById('togglePassword');
        const loginPasswordInput = document.getElementById('password');
        const loginToggleIcon = document.getElementById('toggleIcon');

        if (loginToggleButton && loginPasswordInput && loginToggleIcon) {
            loginToggleButton.addEventListener('click', function () {
                const isPassword = loginPasswordInput.type === 'password';
                loginPasswordInput.type = isPassword ? 'text' : 'password';
                loginToggleIcon.classList.toggle('fa-eye-slash', !isPassword);
                loginToggleIcon.classList.toggle('fa-eye', isPassword);
            });
        }
    </script>
</body>
</html>
