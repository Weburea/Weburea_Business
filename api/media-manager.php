<?php
/**
 * Media Manager API
 * Endpoints:
 * - GET /api/media-manager.php?type=benefit_icons : List all benefit icons
 * - POST /api/media-manager.php                  : Handle file upload and renaming
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once('../include/db.php');

function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) return true;
    
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
$response = ['success' => false, 'message' => 'Unknown error'];

try {
    switch ($method) {
        case 'GET':
            $action = $_GET['action'] ?? '';
            $type = $_GET['type'] ?? '';

            if ($action === 'report') {
                $uploadDir = '../assets/uploads/';
                $totalSize = 0;
                $fileCount = 0;

                if (is_dir($uploadDir)) {
                    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadDir));
                    foreach ($iterator as $file) {
                        if ($file->isFile()) {
                            $totalSize += $file->getSize();
                            $fileCount++;
                        }
                    }
                }

                $response = [
                    'success' => true,
                    'count' => $fileCount,
                    'size' => $totalSize,
                    'usage_formatted' => round($totalSize / (1024 * 1024), 2) . ' MB',
                    'quota_bytes' => 500 * 1024 * 1024,
                    'quota_formatted' => '500 MB'
                ];
            } elseif ($type === 'benefit_icons') {
                $stmt = $pdo->query("SELECT * FROM benefit_icons ORDER BY label ASC");
                $response = ['success' => true, 'data' => $stmt->fetchAll()];
            } else {
                $response['message'] = 'Invalid request parameters';
            }
            break;

        case 'POST':
            if (empty($_FILES['file'])) {
                $response['message'] = 'No file provided';
                break;
            }

            $file = $_FILES['file'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                switch ($file['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $response['message'] = 'File exceeds maximum limit (50MB)';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $response['message'] = 'File was only partially uploaded';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $response['message'] = 'Missing temporary folder on server';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $response['message'] = 'Failed to write file to disk';
                        break;
                    default:
                        $response['message'] = 'Unknown PHP upload error (Code: ' . $file['error'] . ')';
                }
                break;
            }

            $mediaType = $_POST['media_type'] ?? 'images'; // icons, videos, images
            $prefix = $_POST['prefix'] ?? 'asset';
            
            $uploadBase = '../assets/uploads/';
            $targetDir = $uploadBase . $mediaType . '/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = $prefix . '-' . time() . '.' . $ext;
            $targetPath = $targetDir . $newName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $publicPath = 'assets/uploads/' . $mediaType . '/' . $newName;
                
                if (isset($_POST['save_as_benefit']) && $_POST['save_as_benefit'] === 'true') {
                    $label = $_POST['label'] ?? $prefix;
                    $stmt = $pdo->prepare("INSERT INTO benefit_icons (label, icon_path) VALUES (?, ?)");
                    $stmt->execute([$label, $publicPath]);
                }

                $response = [
                    'success' => true, 
                    'message' => 'Media uploaded and organized',
                    'path' => $publicPath
                ];
            } else {
                $response['message'] = 'Server failed to move uploaded file. Check directory permissions.';
            }
            break;

        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                $response['message'] = 'ID required';
                break;
            }
            
            // First check if it exists
            $stmtCheck = $pdo->prepare("SELECT status FROM benefit_icons WHERE id = ?");
            $stmtCheck->execute([$id]);
            $record = $stmtCheck->fetch();

            if (!$record) {
                http_response_code(404);
                $response['message'] = 'Icon not found';
            } else {
                if ($record['status'] === 'archived') {
                    $response = ['success' => true, 'message' => 'Icon was already archived'];
                } else {
                    $stmt = $pdo->prepare("UPDATE benefit_icons SET status = 'archived' WHERE id = ?");
                    $stmt->execute([$id]);
                    $response = ['success' => true, 'message' => 'Icon archived (Soft Delete)'];
                }
            }
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
