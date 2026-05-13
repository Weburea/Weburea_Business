<?php
/**
 * Forgot Password Page
 * Modern UI (Logic placeholder)
 */
require_once('../include/auth.php');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = 'If an account exists for that email, we have sent password reset instructions.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Weburea - Recover Password</title>
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
            <h2 class="text-white mb-2">Recover Password</h2>
            <p class="text-secondary mb-4">Enter your email and we'll send you a link to reset your password.</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-info py-2 px-3 mb-4 text-center">
                <i class="bi bi-info-circle-fill me-2"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="forgot-password.php" method="POST">
            <div class="mb-4">
                <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Send Reset Link</button>
        </form>

        <div class="auth-footer small">
            Remembered your password? <a href="signin.php">Back to login</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
