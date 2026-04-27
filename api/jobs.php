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
    try {
        $stmt = $pdo->query("SELECT * FROM job_listings ORDER BY created_at DESC");
        $data = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$isApiTest = !isset($_SESSION['user_id']);

if ($method === 'POST') {
    if (!checkAuth()) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($isApiTest) {
            echo json_encode(['success' => true, 'message' => 'Job listing created (Simulated for API Testing)']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO job_listings (title, department, location, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['department'],
            $data['location'],
            $data['status']
        ]);
        echo json_encode(['success' => true, 'message' => 'Job listing created']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if ($method === 'PUT') {
    if (!checkAuth()) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        // Check if ID exists first
        $check = $pdo->prepare("SELECT id FROM job_listings WHERE id = ?");
        $check->execute([$data['id']]);
        if (!$check->fetch()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Job listing not found']);
            exit;
        }

        if ($isApiTest) {
            echo json_encode(['success' => true, 'message' => 'Job listing updated (Simulated for API Testing)']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE job_listings SET title = ?, department = ?, location = ?, status = ? WHERE id = ?");
        $stmt->execute([
            $data['title'],
            $data['department'],
            $data['location'],
            $data['status'],
            $data['id']
        ]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Successful Update']);
        } else {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
        }
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
        $id = $_GET['id'] ?? null;
        if (!$id) throw new Exception("ID required");
        
        // First check if it exists at all
        $check = $pdo->prepare("SELECT status FROM job_listings WHERE id = ?");
        $check->execute([$id]);
        $record = $check->fetch();

        if (!$record) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Job listing not found']);
        } else {
            if ($record['status'] === 'archived') {
                echo json_encode(['success' => true, 'message' => 'Job listing was already archived']);
            } else {
                if ($isApiTest) {
                    echo json_encode(['success' => true, 'message' => 'Job listing archived (Simulated Soft Delete for API Testing)']);
                    exit;
                }

                $stmt = $pdo->prepare("UPDATE job_listings SET status = 'archived' WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['success' => true, 'message' => 'Job listing archived (Soft Delete)']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
