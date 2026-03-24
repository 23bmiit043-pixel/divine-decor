<?php
session_start();
$name = "";
$email = "";
$phone = "";
$password = "";
$cpassword = "";
$host = 'localhost:3306';
$dbname = 'customer';
$user = 'root';
$db_password = '';
$connection = mysqli_connect($host, $user, $db_password);
$db_select = mysqli_select_db($connection, $dbname);
if ($db_select === false) {
    echo 'Database selection failed!';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $name = mysqli_real_escape_string($connection, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($connection, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($connection, $_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $r = mysqli_query($connection, "SELECT * FROM customer WHERE Email='$email' LIMIT 1");
    $u = mysqli_fetch_assoc($r);
    if ($u) {
        $errors[] = "Email already exists";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    if (!preg_match("#[0-9]+#", $password)) {
        $errors[] = "Password must include at least one number";
    }
    if (!preg_match("#[A-Z]+#", $password)) {
        $errors[] = "Password must include at least one uppercase letter";
    }
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Invalid phone number format";
    }
    if ($password != $cpassword) {
        $errors[] = "Passwords do not match";
    }
    if (empty($errors)) {
        $q = "INSERT INTO customer (C_name,Email,Contact_no,Password) VALUES ('$name','$email','$phone','$password')";
        $res = mysqli_query($connection, $q);
        if ($res) {
            $cid = mysqli_insert_id($connection);
            $_SESSION["loggedin"] = true;
            $_SESSION["cid"] = $cid;
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $name;
            header('location: index.php');
            exit();
        } else {
            $errors[] = "Registration failed: " . mysqli_error($connection);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | The Divine Decor</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #3b5d50;
            --green-dark: #2a4438;
            --green-light: #4e7a69;
            --gold: #c9a84c;
            --cream: #f9f5ef;
            --text: #1a2820;
            --muted: #7a8f88;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Jost', sans-serif;
            display: flex;
            background: var(--cream);
        }

        /* ── LEFT PANEL ── */
        .panel-image {
            flex: 0.9;
            position: relative;
            overflow: hidden;
        }

        .panel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.04);
            animation: slowZoom 18s ease-in-out infinite alternate;
        }

        @keyframes slowZoom {
            from {
                transform: scale(1.04);
            }

            to {
                transform: scale(1.12);
            }
        }

        .panel-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(42, 68, 56, 0.72) 0%,
                    rgba(42, 68, 56, 0.3) 60%,
                    rgba(0, 0, 0, 0.1) 100%);
        }

        .panel-brand {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo .logo-mark {
            width: 42px;
            height: 42px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .brand-logo .logo-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: #fff;
            letter-spacing: 1px;
        }

        .brand-tagline {
            color: rgba(255, 255, 255, 0.95);
        }

        .brand-tagline h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.2rem;
            font-weight: 300;
            line-height: 1.15;
            margin-bottom: 16px;
        }

        .brand-tagline h1 em {
            font-style: italic;
            color: #e8d5a3;
        }

        .brand-tagline p {
            font-size: 0.9rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.75);
            letter-spacing: 0.5px;
        }

        /* Perks */
        .perks-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .perk {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 14px 12px;
            backdrop-filter: blur(6px);
        }

        .perk-ico {
            width: 30px;
            height: 30px;
            background: rgba(201, 168, 76, 0.2);
            border: 1px solid rgba(201, 168, 76, 0.35);
            border-radius: 8px;
            display: grid;
            place-items: center;
            color: var(--gold);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .perk-title {
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 3px;
        }

        .perk-desc {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.4;
        }

        .corner-deco {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 160px;
            height: 160px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0 80px 0 0;
            z-index: 1;
        }

        /* ── RIGHT PANEL ── */
        .panel-form {
            flex: 1;
            background: var(--cream);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            position: relative;
            overflow: hidden;
        }

        .panel-form::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 93, 80, 0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .panel-form::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 168, 76, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Badge */
        .account-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(59, 93, 80, 0.1);
            color: var(--green);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid rgba(59, 93, 80, 0.2);
            margin-bottom: 20px;
            width: fit-content;
            animation: fadeUp 0.6s ease both;
        }

        .form-heading {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.6rem;
            font-weight: 400;
            color: var(--text);
            line-height: 1.15;
            margin-bottom: 6px;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .form-heading span {
            color: var(--green);
            font-style: italic;
        }

        .form-sub {
            font-size: 0.875rem;
            color: var(--muted);
            font-weight: 300;
            /* margin-bottom: 24px; */
            margin-bottom: 10px;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        /* Error */
        .error-box {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-left: 3px solid #ef4444;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 0.82rem;
            color: #b91c1c;
            animation: shake 0.4s ease;
        }

        .error-line {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-line+.error-line {
            margin-top: 4px;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(6px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }

        /* Fields */
        .fields-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-group {
            margin-bottom: 8px;
            /* margin-bottom: 16px; */
            animation: fadeUp 0.6s ease both;
        }

        .field-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap i.field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.85rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-wrap input {
            width: 100%;
            background: #fff;
            border: 1.5px solid #e2e8e5;
            border-radius: 10px;
            padding: 7px 44px;
            /* padding: 13px 44px; */
            font-family: 'Jost', sans-serif;
            font-size: 0.88rem;
            font-weight: 400;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field-wrap input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(59, 93, 80, 0.1);
        }

        .field-wrap input::placeholder {
            color: #bbb;
        }

        .field-wrap input.valid {
            border-color: #27ae60;
        }

        .field-wrap input.invalid {
            border-color: #ef4444;
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            cursor: pointer;
            font-size: 0.88rem;
            background: none;
            border: none;
            padding: 4px;
            transition: color 0.2s;
        }

        .toggle-pw:hover {
            color: var(--green);
        }

        /* Password strength */
        .pw-strength {
            margin-top: 6px;
        }

        .pw-bars {
            display: flex;
            gap: 3px;
            margin-bottom: 3px;
        }

        .pw-bar {
            height: 3px;
            flex: 1;
            border-radius: 2px;
            background: #e2e8e5;
            transition: background 0.3s;
        }

        .pw-bar.s1 {
            background: #ef4444;
        }

        .pw-bar.s2 {
            background: #f59e0b;
        }

        .pw-bar.s3 {
            background: #3b82f6;
        }

        .pw-bar.s4 {
            background: #27ae60;
        }

        .pw-label {
            font-size: 0.72rem;
            color: var(--muted);
        }

        /* Terms */
        .terms-wrap {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(59, 93, 80, 0.04);
            border: 1px solid #e2e8e5;
            border-radius: 10px;
            padding: 7px 14px;
            /* padding: 12px 14px; */
            margin-bottom: 16px;
            cursor: pointer;
        }

        .terms-wrap input[type=checkbox] {
            margin-top: 2px;
            accent-color: var(--green);
            flex-shrink: 0;
        }

        .terms-wrap label {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.5;
            cursor: pointer;
        }

        .terms-wrap label a {
            color: var(--green);
            font-weight: 500;
            text-decoration: none;
        }

        .terms-wrap label a:hover {
            color: var(--gold);
        }

        /* Policy Links */
        .policy-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
            animation: fadeUp 0.6s 0.37s ease both;
        }

        .policy-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(59, 93, 80, 0.06);
            border: 1px solid rgba(59, 93, 80, 0.15);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--green);
            font-size: 0.78rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .policy-link i {
            font-size: 0.75rem;
        }

        .policy-link:hover {
            background: rgba(59, 93, 80, 0.12);
            border-color: rgba(59, 93, 80, 0.3);
            color: var(--green-dark);
            box-shadow: 0 2px 6px rgba(59, 93, 80, 0.1);
        }

        /* Button */
        .btn-register {
            width: 100%;
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 10px;
            /* padding: 14px; */
            padding: 11px;
            font-family: 'Jost', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background 0.25s, transform 0.15s, box-shadow 0.25s;
            animation: fadeUp 0.6s 0.4s ease both;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 40%, rgba(255, 255, 255, 0.1));
            pointer-events: none;
        }

        .btn-register:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(59, 93, 80, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 0;
            animation: fadeUp 0.6s 0.5s ease both;
        }

        .form-divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid #e2e8e5;
        }

        .form-divider span {
            font-size: 0.78rem;
            color: var(--muted);
            letter-spacing: 0.5px;
        }

        .signin-link {
            text-align: center;
            margin-top: 14px;
            font-size: 0.875rem;
            color: var(--muted);
            animation: fadeUp 0.6s 0.52s ease both;
        }

        .signin-link a {
            color: var(--green);
            font-weight: 500;
            text-decoration: none;
        }

        .signin-link a:hover {
            color: var(--gold);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: var(--muted);
            font-size: 0.84rem;
            text-decoration: none;
            margin-top: 10px;
            transition: color 0.2s;
            animation: fadeUp 0.6s 0.55s ease both;
        }

        .back-link:hover {
            color: var(--green);
        }

        #clientMsg {
            min-height: 0;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            body {
                overflow: auto;
                flex-direction: column;
            }

            .panel-image {
                flex: none;
                height: 240px;
            }

            html,
            body {
                height: auto;
            }

            .panel-form {
                padding: 36px 28px;
            }

            .fields-grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

    <!-- LEFT: image panel -->
    <div class="panel-image">
        <img src="/The-Divine-Decor/the-divine-door-main/02User-side/images/img-grid-1.jpg" alt="The Divine Decor">
        <div class="corner-deco"></div>
        <div class="panel-brand">
            <div class="brand-logo">
                <div class="logo-mark"><i class="fas fa-leaf"></i></div>
                <div class="logo-name">The Divine Decor</div>
            </div>
            <div style="display:flex; flex-direction:column; gap:28px;">
                <div class="brand-tagline">
                    <h1>Design Your<br><em>Dream</em><br>Home</h1>
                    <p>Join thousands of happy customers</p>
                </div>
                <div class="perks-grid">
                    <div class="perk">
                        <div class="perk-ico"><i class="fas fa-tag"></i></div>
                        <div class="perk-title">Member Deals</div>
                        <div class="perk-desc">Up to 30% off collections</div>
                    </div>
                    <div class="perk">
                        <div class="perk-ico"><i class="fas fa-truck-fast"></i></div>
                        <div class="perk-title">Free Shipping</div>
                        <div class="perk-desc">Orders above &#8377;999</div>
                    </div>
                    <div class="perk">
                        <div class="perk-ico"><i class="fas fa-heart"></i></div>
                        <div class="perk-title">Wishlist</div>
                        <div class="perk-desc">Save your favourites</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: form panel -->
    <div class="panel-form">

        <div class="account-badge">
            <i class="fas fa-user-plus" style="font-size:0.65rem;"></i>
            New Account
        </div>

        <h2 class="form-heading">Create<br><span>account.</span></h2>
        <p class="form-sub">Start shopping in seconds. It is free.</p>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="error-box">
                <?php foreach ($errors as $err): ?>
                    <div class="error-line"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($err); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="regForm" novalidate>

            <!-- Row 1: Name + Phone -->
            <div class="fields-grid-2">
                <div class="field-group">
                    <label class="field-label" for="fname">Full Name</label>
                    <div class="field-wrap">
                        <input type="text" id="fname" name="name" placeholder="Riya Patel" required
                            value="<?php echo htmlspecialchars($name); ?>">
                        <i class="fas fa-user field-icon"></i>
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label" for="phone">Phone</label>
                    <div class="field-wrap">
                        <input type="tel" id="phone" name="phone" placeholder="10-digit number" maxlength="10" required
                            value="<?php echo htmlspecialchars($phone); ?>">
                        <i class="fas fa-phone field-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="field-group">
                <label class="field-label" for="email">Email Address</label>
                <div class="field-wrap">
                    <input type="email" id="email" name="email" placeholder="you@example.com" required
                        value="<?php echo htmlspecialchars($email); ?>">
                    <i class="fas fa-envelope field-icon"></i>
                </div>
            </div>

            <!-- Row 2: Password + Confirm -->
            <div class="fields-grid-2">
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrap">
                        <input type="password" id="password" name="password" placeholder="Min 8 chars" required>
                        <i class="fas fa-lock field-icon"></i>
                        <button type="button" class="toggle-pw" onclick="togglePw('password',this)">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="pw-strength" id="pwStr" style="display:none">
                        <div class="pw-bars">
                            <div class="pw-bar" id="pb1"></div>
                            <div class="pw-bar" id="pb2"></div>
                            <div class="pw-bar" id="pb3"></div>
                            <div class="pw-bar" id="pb4"></div>
                        </div>
                        <span class="pw-label" id="pwLbl"></span>
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label" for="cpassword">Confirm</label>
                    <div class="field-wrap">
                        <input type="password" id="cpassword" name="cpassword" placeholder="Repeat password" required>
                        <i class="fas fa-shield-halved field-icon"></i>
                        <button type="button" class="toggle-pw" onclick="togglePw('cpassword',this)">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="terms-wrap">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms">I agree to the <a href="Terms.php">Terms of Service</a> and <a href="privacy-policy.php">Privacy Policy</a> of
                    The Divine Decor</label>
            </div>

            <!-- Policy Links -->
            <div class="policy-links">
                <a href="privacy-policy.php" class="policy-link"><i class="fas fa-lock-open"></i> Privacy Policy</a>
                <a href="Terms.php" class="policy-link"><i class="fas fa-file-contract"></i> Terms of Service</a>
            </div>

            <button type="submit" name="sign_up" class="btn-register">
                <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px;"></i>
                Create My Account
            </button>
            <div id="clientMsg"></div>

        </form>

        <div class="form-divider">
            <hr><span>or</span>
            <hr>
        </div>

        <p class="signin-link">Already a member? <a href="login.php">Sign in</a></p>

        <a href="index.php" class="back-link">
            <i class="fas fa-arrow-left" style="font-size:0.75rem;"></i>
            Back to store
        </a>

    </div>

    <script>
        function togglePw(id, btn) {
            const inp = document.getElementById(id);
            const ic = btn.querySelector('i');
            if (inp.type === 'password') { inp.type = 'text'; ic.classList.replace('fa-eye-slash', 'fa-eye'); }
            else { inp.type = 'password'; ic.classList.replace('fa-eye', 'fa-eye-slash'); }
        }

        document.getElementById('phone').addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            this.className = this.value.length === 10 ? 'valid' : (this.value.length > 0 ? 'invalid' : '');
        });

        document.getElementById('email').addEventListener('input', function () {
            const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            this.className = this.value ? (ok ? 'valid' : 'invalid') : '';
        });

        document.getElementById('fname').addEventListener('input', function () {
            this.className = this.value.trim().length >= 2 ? 'valid' : (this.value ? 'invalid' : '');
        });

        const pwInp = document.getElementById('password');
        const pwStr = document.getElementById('pwStr');
        const pwLbl = document.getElementById('pwLbl');
        const bars = [1, 2, 3, 4].map(n => document.getElementById('pb' + n));
        const lvls = ['Weak', 'Fair', 'Good', 'Strong'];
        const cols = ['#ef4444', '#f59e0b', '#3b82f6', '#27ae60'];

        pwInp.addEventListener('input', function () {
            const v = this.value;
            if (!v) { pwStr.style.display = 'none'; return; }
            pwStr.style.display = 'block';
            let s = 0;
            if (v.length >= 8) s++; if (/[A-Z]/.test(v)) s++; if (/[0-9]/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v)) s++;
            bars.forEach((b, i) => { b.className = 'pw-bar' + (i < s ? ' s' + s : ''); });
            const lv = Math.max(0, s - 1);
            pwLbl.textContent = lvls[lv]; pwLbl.style.color = cols[lv];
        });

        document.getElementById('cpassword').addEventListener('input', function () {
            this.className = this.value ? (this.value === pwInp.value ? 'valid' : 'invalid') : '';
        });

        document.getElementById('regForm').addEventListener('submit', function (e) {
            const ph = document.getElementById('phone').value;
            const pw = document.getElementById('password').value;
            const cpw = document.getElementById('cpassword').value;
            const chk = document.getElementById('terms').checked;
            const msg = document.getElementById('clientMsg');
            function showErr(t) {
                msg.innerHTML = `<div style="display:flex;align-items:center;gap:8px;color:#b91c1c;font-size:0.82rem;margin-top:10px;padding:10px 14px;background:#fff5f5;border-radius:8px;border-left:3px solid #ef4444"><i class="fas fa-exclamation-circle"></i>${t}</div>`;
                e.preventDefault();
            }
            msg.innerHTML = '';
            if (ph.length !== 10) return showErr('Phone must be exactly 10 digits.');
            if (pw.length < 8) return showErr('Password must be at least 8 characters.');
            if (!/[A-Z]/.test(pw)) return showErr('Password needs at least one uppercase letter.');
            if (!/[0-9]/.test(pw)) return showErr('Password needs at least one number.');
            if (pw !== cpw) return showErr('Passwords do not match.');
            if (!chk) return showErr('Please accept the Terms of Service to continue.');
        });
    </script>
</body>

</html>
