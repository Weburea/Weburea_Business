<?php
require 'include/db.php';

$resultsMetrics = [
    ["label" => "Conversion Rate Increase", "value" => "45", "suffix" => "%"],
    ["label" => "Active Users", "value" => "1.2", "suffix" => "M"],
    ["label" => "Client Satisfaction", "value" => "4.9", "suffix" => "/5"]
];

$updates = [
    1 => ['web_tech_stack' => ["React Native", "Node.js", "MongoDB", "AWS"], 'web_architecture' => "Serverless Architecture", 'web_repo_url' => "https://github.com/weburea/mobile-app", 'results_metrics' => $resultsMetrics],
    2 => ['ui_figma_url' => "https://figma.com/file/123", 'ui_prototype_url' => "https://figma.com/proto/123", 'ui_typography' => "Inter, Roboto", 'ui_colors' => ["#1a1a1a", "#ff5722", "#ffffff"], 'results_metrics' => $resultsMetrics],
    3 => ['ui_figma_url' => "https://figma.com/file/456", 'ui_prototype_url' => "https://figma.com/proto/456", 'ui_typography' => "Outfit, Sans-Serif", 'ui_colors' => ["#000000", "#ff0000"], 'results_metrics' => $resultsMetrics],
    4 => ['web_tech_stack' => ["Cypress", "Selenium", "Jest", "Jenkins"], 'web_architecture' => "Microservices", 'web_repo_url' => "https://github.com/weburea/digital-marketing", 'results_metrics' => $resultsMetrics],
    13 => ['video_duration' => "02:15", 'video_resolution' => "4K", 'video_software' => ["Premiere Pro", "After Effects", "Cinema 4D"], 'results_metrics' => $resultsMetrics],
    14 => ['video_duration' => "01:30", 'video_resolution' => "1080p", 'video_software' => ["After Effects", "DaVinci Resolve"], 'results_metrics' => $resultsMetrics]
];

foreach ($updates as $id => $data) {
    $json = json_encode($data);
    $stmt = $pdo->prepare("UPDATE portfolio_works SET service_data_json = ? WHERE id = ?");
    $stmt->execute([$json, $id]);
    echo "Updated ID $id\n";
}

// Ensure additional_images is populated with some defaults for testing gallery
$images = [
    "assets/images/portfolio/3by4/09.jpg",
    "assets/images/portfolio/3by4/06.jpg",
    "assets/images/portfolio/3by4/01.jpg",
    "assets/images/portfolio/04.jpg"
];
$imagesJson = json_encode($images);
$pdo->query("UPDATE portfolio_works SET additional_images = '$imagesJson' WHERE additional_images IS NULL OR additional_images = '[]' OR additional_images = ''");
echo "Updated additional_images for all empty works.\n";
?>
