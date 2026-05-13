<?php
/**
 * Sign Up Page
 * Modernized with registration logic and premium UI
 */
require_once('../include/auth.php');
require_once('../include/alerts.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($name) || empty($email) || empty($password)) {
        set_alert('Please fill in all fields', 'danger');
    } elseif ($password !== $confirm_password) {
        set_alert('Passwords do not match', 'danger');
    } else {
        $registerResult = registerUser($name, $email, $password);
        if ($registerResult['success']) {
            set_alert('Account created successfully! You can now <a href="signin.php">sign in</a>.', 'success');
        } else {
            set_alert($registerResult['message'], 'danger');
        }
    }
}

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Weburea - Create Account</title>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Weburea">

	<!-- Dark mode -->
	<script>
		const storedTheme = localStorage.getItem('theme')
		const getPreferredTheme = () => {
			if (storedTheme) return storedTheme
			return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
		}
		const setTheme = function (theme) {
			if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				document.documentElement.setAttribute('data-bs-theme', 'dark')
			} else {
				document.documentElement.setAttribute('data-bs-theme', theme)
			}
		}
		setTheme(getPreferredTheme())
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/auth.css?v=<?= time() ?>">


</head>

<body class="auth-page">

<div class="container d-flex justify-content-center">
    <div class="auth-card">
        <div class="text-center">
            <img src="assets/images/logo-light.svg" class="auth-logo" alt="Weburea Logo">
            <h2 class="text-white mb-2">Create Account</h2>
            <p class="text-secondary mb-4">Join our agency network today.</p>
        </div>

        <?php echo render_alerts(); ?>

        <form action="signup.php" method="POST">
            <div class="mb-3">
                <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-secondary small text-uppercase fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary small text-uppercase fw-bold">Confirm</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Create Account</button>
        </form>

        <div class="auth-footer small">
            Already have an account? <a href="signin.php">Sign in instead</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
