<?php
/**
 * Sign In Page
 * Modernized with robust logic and premium UI
 */
require_once('../include/auth.php');
require_once('../include/alerts.php');

// Handle logout
if (isset($_GET['logout'])) {
    logoutUser();
    set_alert('You have been signed out successfully.', 'info');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        set_alert('Please fill in all fields', 'danger');
    } else {
        $loginResult = loginUser($email, $password);
        if ($loginResult['success']) {
            header("Location: index.php");
            exit();
        } else {
            set_alert($loginResult['message'], 'danger');
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
	<title>Weburea - Admin Sign In</title>
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
            <h2 class="text-white mb-2">Welcome Back</h2>
            <p class="text-secondary mb-4">Please enter your details to sign in.</p>
        </div>

        <?php echo render_alerts(); ?>

        <form action="signin.php" method="POST">
            <div class="mb-3">
                <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label text-secondary small text-uppercase fw-bold m-0">Password</label>
                    <a href="forgot-password.php" class="small text-primary">Forgot?</a>
                </div>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label text-secondary small" for="rememberMe">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
        </form>

        <div class="auth-footer small">
            Don't have an account? <a href="signup.php">Create one</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
