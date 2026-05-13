<?php
require_once('include/db.php');
$stmt = $pdo->query("SELECT id, service_id, name FROM pricing_plans");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
