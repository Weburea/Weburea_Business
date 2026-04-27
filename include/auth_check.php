<?php
/**
 * Auth Guard
 * Performs a session check and redirects to signin if not authorized
 */
require_once('auth.php');

if (!isLoggedIn()) {
    require_once('alerts.php');
    set_alert('Please sign in to access the dashboard.', 'warning');
    header("Location: signin.php");
    exit();
}
?>
