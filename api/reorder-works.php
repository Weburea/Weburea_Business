<?php
require_once('../include/auth.php');
require_once('../include/db.php');

if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $order = $input['order'] ?? [];

    if (empty($order)) {
        echo json_encode(['success' => false, 'message' => 'Order data missing']);
        exit;
    }

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE portfolio_works SET sort_order = ? WHERE id = ?");
        foreach ($order as $item) {
            $stmt->execute([$item['sort_order'], $item['id']]);
        }
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to update order: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
