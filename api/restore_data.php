<?php
/**
 * Database Restoration API
 * Repopulates services, pricing, and portfolio data from SQL source files.
 */

header('Content-Type: application/json');
require_once('../include/db.php');
require_once('../include/auth.php');

// Security check
if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    // Disable foreign key checks for clean truncation
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // 1. Restore Services
    $pdo->exec("TRUNCATE TABLE services");
    $servicesSql = file_get_contents('../sql/services.sql');
    // Remove USE statement if present to avoid issues
    $servicesSql = preg_replace('/USE `?weburea_db`?;/i', '', $servicesSql);
    // Execute as one block (PDO supports multi-query if configured, but let's be safe)
    $pdo->exec($servicesSql);

    // 2. Restore Pricing
    $pdo->exec("TRUNCATE TABLE pricing_plans");
    $pricingSql = file_get_contents('../sql/populate_professional_data.sql');
    $pricingSql = preg_replace('/USE `?weburea_db`?;/i', '', $pricingSql);
    $pdo->exec($pricingSql);

    // 3. Restore Portfolio Works
    $pdo->exec("TRUNCATE TABLE portfolio_works");
    $worksSql = file_get_contents('../sql/portfolio_works.sql');
    $worksSql = preg_replace('/USE `?weburea_db`?;/i', '', $worksSql);
    $pdo->exec($worksSql);

    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Link some works to services for a better demo
    $pdo->exec("UPDATE portfolio_works SET service_id = 1 WHERE id = 1");
    $pdo->exec("UPDATE portfolio_works SET service_id = 2 WHERE id = 2");
    $pdo->exec("UPDATE portfolio_works SET service_id = 5 WHERE id = 3");
    $pdo->exec("UPDATE portfolio_works SET service_id = 7 WHERE id = 4");

    echo json_encode(['success' => true, 'message' => 'Database restored successfully']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Restore failed: ' . $e->getMessage()]);
}
?>
