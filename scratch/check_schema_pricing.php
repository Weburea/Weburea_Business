<?php
require 'include/db.php';
$stmt = $pdo->query('DESCRIBE pricing_plans');
foreach($stmt->fetchAll() as $row) {
    echo $row['Field'] . ' (' . $row['Type'] . ')\n';
}
