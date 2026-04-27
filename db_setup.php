<?php
require_once('include/db.php');

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    $pdo->exec($sql);
    echo "Users table created successfully.\n";

    // Create default admin if not exists
    $email = 'admin@weburea.com';
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute(['Weburea Admin', $email, $password]);
        echo "Default admin user created: admin@weburea.com / admin123\n";
    } else {
        echo "Admin user already exists.\n";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
