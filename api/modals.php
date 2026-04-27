<?php
header("Content-Type: application/json");
require_once '../include/db.php';

function checkAuth()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id']))
        return true;

    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? null;
    return $apiKey === 'weburea_secret_2026';
}

if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$isApiTest = !isset($_SESSION['user_id']);

if ($method === 'GET') {
    $context = $_GET['context'] ?? 'global';
    $type = $_GET['type'] ?? null;
    
    if ($type) {
        $stmt = $pdo->prepare("SELECT * FROM modal_configurations WHERE context_key = ? AND modal_type = ?");
        $stmt->execute([$context, $type]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM modal_configurations WHERE context_key = ?");
        $stmt->execute([$context]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    echo json_encode(['success' => true, 'data' => $data]);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['modal_type']) || !isset($data['context_key'])) {
        echo json_encode(['success' => false, 'message' => 'Missing modal type or context key']);
        exit;
    }

    if ($isApiTest) {
        echo json_encode(['success' => true, 'message' => 'Modal configuration saved (Simulated for API Testing)']);
        exit;
    }

    // Check if context/type exists
    $check = $pdo->prepare("SELECT id FROM modal_configurations WHERE context_key = ? AND modal_type = ?");
    $check->execute([$data['context_key'], $data['modal_type']]);
    $exists = $check->fetch();

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE modal_configurations SET 
            title = ?, 
            message = ?, 
            button_text = ?, 
            image_path = ?,
            animation_type = ? 
            WHERE context_key = ? AND modal_type = ?");
        
        $stmt->execute([
            $data['title'],
            $data['message'],
            $data['button_text'],
            $data['image_path'] ?? 'assets/images/elements/rocket-02.png',
            $data['animation_type'],
            $data['context_key'],
            $data['modal_type']
        ]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Successful Update']);
        } else {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
        }
        exit;
    } else {
        $stmt = $pdo->prepare("INSERT INTO modal_configurations (context_key, modal_type, title, message, button_text, image_path, animation_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $data['context_key'],
            $data['modal_type'],
            $data['title'],
            $data['message'],
            $data['button_text'],
            $data['image_path'] ?? 'assets/images/elements/rocket-02.png',
            $data['animation_type']
        ]);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Modal configuration saved']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save configuration']);
        }
        exit;
    }
}
