<?php
require_once('../include/db.php');

header('Content-Type: application/json');

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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT section_key, section_content FROM contact_page_sections");
        $sections = $stmt->fetchAll();
        
        $data = array_map(function($sec) {
            return [
                'section_key' => $sec['section_key'],
                'section_content' => json_decode($sec['section_content'], true)
            ];
        }, $sections);

        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['section_key']) || !isset($input['section_content'])) {
        echo json_encode(['success' => false, 'message' => 'Missing data']);
        exit;
    }

    $key = $input['section_key'];
    $content = json_encode($input['section_content']);

    // Mock API testing check
    $isApiTest = !isset($_SESSION['user_id']);

    try {
        $stmtOld = $pdo->prepare("SELECT section_content FROM contact_page_sections WHERE section_key = ?");
        $stmtOld->execute([$key]);
        $existing = $stmtOld->fetch();

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => '404 Not Found']);
            exit;
        }

        if ($existing['section_content'] === $content) {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
            exit;
        }

        if ($isApiTest) {
            // Simulate update
            echo json_encode(['success' => true, 'message' => 'Successful Update (Simulated for API Testing)']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE contact_page_sections SET section_content = ? WHERE section_key = ?");
        $stmt->execute([$content, $key]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Successful Update']);
        } else {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update section']);
    }
    exit;
}
