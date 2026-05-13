<?php
/**
 * Authentication Engine
 * Handles login, registration, and session management
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('db.php');

/**
 * Login a user
 */
function loginUser($email, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return ['success' => true, 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'Invalid email or password'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'System error: ' . $e->getMessage()];
    }
}

/**
 * Register a new user
 */
function registerUser($name, $email, $password) {
    global $pdo;
    
    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
        
        return ['success' => true, 'message' => 'Registration successful'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Dual-Auth: Check for active session OR valid API Key header
 */
function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isLoggedIn()) {
        return true;
    }

    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? null;
    $validKey = 'weburea_secret_2026'; 

    if ($apiKey === $validKey) {
        return true;
    }

    return false;
}

/**
 * Logout user
 */
function logoutUser() {
    session_unset();
    session_destroy();
}
?>
