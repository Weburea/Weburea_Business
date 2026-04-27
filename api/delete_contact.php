<?php
header('Content-Type: application/json');
require_once('../include/db.php');
require_once('../include/auth_check.php');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID is required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Submission deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Submission not found or already deleted.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
