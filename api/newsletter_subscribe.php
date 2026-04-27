<?php
header('Content-Type: application/json');
require_once('../include/db.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? null;

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please provide a valid email address.");
        }

        // Check if already exists
        $stmtCheck = $pdo->prepare("SELECT id FROM newsletter_subscriptions WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->fetch()) {
            throw new Exception("You are already subscribed!");
        }

        $stmt = $pdo->prepare("INSERT INTO newsletter_subscriptions (email) VALUES (?)");
        $stmt->execute([$email]);

        echo json_encode(['success' => true, 'message' => 'Subscription successful']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
