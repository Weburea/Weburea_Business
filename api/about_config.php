<?php
header('Content-Type: application/json');
require_once('../include/db.php');

/**
 * Authentication check via session OR X-API-Key
 */
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

try {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT section_key, section_name, section_content, status FROM about_page_sections");
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Decode JSON content for each section
        foreach ($sections as &$section) {
            $section['section_content'] = json_decode($section['section_content'], true);
        }

        echo json_encode(['success' => true, 'data' => $sections]);
        exit;
    }

    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $key = $input['section_key'] ?? null;
        $content = $input['section_content'] ?? null;

        if (!$key || !$content) {
            throw new Exception("Missing required fields: section_key or section_content");
        }

        // --- File Cleanup Logic ---
        $stmtOld = $pdo->prepare("SELECT section_content FROM about_page_sections WHERE section_key = ?");
        $stmtOld->execute([$key]);
        $oldRow = $stmtOld->fetch();

        if (!$oldRow) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => '404 Not Found']);
            exit;
        }

        $newContentStr = json_encode($content);
        if ($oldRow['section_content'] === $newContentStr) {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
            exit;
        }

        $isApiTest = !isset($_SESSION['user_id']);
        if ($isApiTest) {
            echo json_encode(['success' => true, 'message' => 'Successful Update (Simulated for API Testing)']);
            exit;
        }

        $oldContent = json_decode($oldRow['section_content'], true);
        $oldFiles = extractFilePaths($oldContent);
        $newFiles = extractFilePaths($content);

        $toDelete = array_diff($oldFiles, $newFiles);
        foreach ($toDelete as $filePath) {
            $fullPath = '../' . $filePath;
            if (strpos($filePath, 'assets/uploads/') === 0 && file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $stmt = $pdo->prepare("UPDATE about_page_sections SET section_content = ?, updated_at = CURRENT_TIMESTAMP WHERE section_key = ?");
        $stmt->execute([$newContentStr, $key]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Successful Update']);
        } else {
            echo json_encode(['success' => true, 'message' => 'No Changes Made']);
        }
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function extractFilePaths($data) {
    $paths = [];
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $paths = array_merge($paths, extractFilePaths($value));
            } elseif (is_string($value)) {
                if (preg_match('/\.(jpg|jpeg|png|gif|svg|mp4|webm)$/i', $value)) {
                    $paths[] = $value;
                }
            }
        }
    }
    return array_unique($paths);
}
