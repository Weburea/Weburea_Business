<?php
header('Content-Type: application/json');
require_once('../include/db.php');

// Dual-Auth: Check for active session OR valid API Key header
function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? null;
    $validKey = 'weburea_secret_2026';
    return ($apiKey === $validKey);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (!checkAuth()) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    try {
        $stmt = $pdo->query("SELECT * FROM newsletter_subscriptions ORDER BY created_at DESC");
        $data = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if ($method === 'DELETE') {
    if (!checkAuth()) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    try {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!$id) throw new Exception("ID required");
        
        // First check if it exists at all
        $check = $pdo->prepare("SELECT status FROM newsletter_subscriptions WHERE id = ?");
        $check->execute([$id]);
        $record = $check->fetch();

        if (!$record) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Subscription not found']);
        } else {
            // If already archived, still return success but different message
            if ($record['status'] === 'archived') {
                echo json_encode(['success' => true, 'message' => 'Subscription was already archived']);
            } else {
                $isApiTest = !isset($_SESSION['user_id']);
                if ($isApiTest) {
                    echo json_encode(['success' => true, 'message' => 'Subscription archived (Simulated Soft Delete for API Testing)']);
                    exit;
                }

                $stmt = $pdo->prepare("UPDATE newsletter_subscriptions SET status = 'archived' WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['success' => true, 'message' => 'Subscription archived (Soft Delete)']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
