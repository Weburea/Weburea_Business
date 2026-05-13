<?php
/**
 * Generic Upload API
 * Handles single file uploads for the portfolio dashboard.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once('../include/auth.php');
require_once('../include/db.php');

// Ensure user is authenticated
if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized access. Please log in.']);
    exit;
}

$response = ['success' => false, 'error' => 'No file uploaded'];

if (!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    $folder = $_POST['folder'] ?? 'portfolio';
    
    // Validate PHP upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
        ];
        $response['error'] = $error_messages[$file['error']] ?? 'Unknown upload error (Code: ' . $file['error'] . ')';
        echo json_encode($response);
        exit;
    }

    // Set target directory
    $targetDir = '../assets/uploads/' . $folder . '/';
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            $response['error'] = 'Failed to create upload directory. Check permissions for assets/uploads/';
            echo json_encode($response);
            exit;
        }
    }

    // Validate file type
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'mp4', 'webm', 'pdf', 'zip'];
    
    if (!in_array($ext, $allowed)) {
        $response['error'] = 'File type ".' . $ext . '" is not allowed. Supported: ' . implode(', ', $allowed);
        echo json_encode($response);
        exit;
    }

    // Generate unique, context-aware name
    $workPrefix = '';
    if (!empty($_POST['work_title'])) {
        // Sanitize title for filename
        $workPrefix = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($_POST['work_title'])) . '_';
        // Limit prefix length
        $workPrefix = substr($workPrefix, 0, 30);
    }
    
    $newName = 'weburea_' . $workPrefix . time() . '_' . bin2hex(random_bytes(2)) . '.' . $ext;
    $targetPath = $targetDir . $newName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $publicPath = 'assets/uploads/' . $folder . '/' . $newName;
        $response = [
            'success' => true,
            'message' => 'File uploaded successfully',
            'path' => $publicPath,
            'filename' => $newName
        ];
    } else {
        $response['error'] = 'Server failed to move uploaded file. Check directory permissions.';
    }
}

echo json_encode($response);
?>
