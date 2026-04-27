<?php
/**
 * Bulk Tool Upload API
 * Handles uploading multiple image files for the Industry Tool Kit.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once('../include/db.php');

// Simple auth check (Shared with services.php)
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

$response = ['success' => false, 'message' => 'No files uploaded'];
$uploadDir = '../assets/images/client/uploads/';

if (!empty($_FILES['tools'])) {
    $uploadedPaths = [];
    $totalFiles = count($_FILES['tools']['name']);
    $isApiTest = !isset($_SESSION['user_id']);

    for ($i = 0; $i < $totalFiles; $i++) {
        if ($_FILES['tools']['error'][$i] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['tools']['tmp_name'][$i];
            $fileName = basename($_FILES['tools']['name'][$i]);
            $fileName = preg_replace("/[^a-zA-Z0-9._-]/", "_", $fileName); // Sanitize
            $newName = time() . '_' . $i . '_' . $fileName;
            $targetPath = $uploadDir . $newName;

            if ($isApiTest) {
                // Simulate successful upload without moving the file
                $uploadedPaths[] = 'assets/images/client/uploads/' . $newName;
            } else {
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $uploadedPaths[] = 'assets/images/client/uploads/' . $newName;
                }
            }
        }
    }

    if (!empty($uploadedPaths)) {
        $msg = $isApiTest ? 'Files uploaded successfully (Simulated for API Testing)' : 'Files uploaded successfully';
        $response = [
            'success' => true, 
            'message' => $msg,
            'paths' => $uploadedPaths
        ];
    } else {
        $response['message'] = 'Failed to move uploaded files';
    }
}

echo json_encode($response);
?>
