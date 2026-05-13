<?php
require_once('include/db.php');

$stmt = $pdo->query('SELECT id, name, slug FROM services');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $pdo->query("SELECT w.id, w.title, s.slug as service_slug FROM portfolio_works w LEFT JOIN services s ON w.service_id = s.id ORDER BY w.created_at DESC LIMIT 5");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
