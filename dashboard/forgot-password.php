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

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #172554 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .auth-logo {
            width: 150px;
            margin-bottom: 30px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 15px;
            border-radius: 12px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #3b82f6;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background: #3b82f6;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .auth-footer {
            margin-top: 25px;
            text-align: center;
            color: #94a3b8;
        }
        .auth-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #93c5fd;
            border-radius: 12px;
        }
    </style>
</head>

<body>

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
