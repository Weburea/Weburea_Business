<?php
require_once('include/db.php');

$tables = ['portfolio_works', 'services', 'pricing_plans', 'homepage_sections', 'users'];

echo "Database: $db\n";
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "Table $table: $count rows\n";
    } catch (Exception $e) {
        echo "Table $table: ERROR - " . $e->getMessage() . "\n";
    }
}
?>
