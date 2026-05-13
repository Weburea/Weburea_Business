<?php
require_once('../include/auth_check.php');

if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

function getDirStats($dir)
{
    $stats = [
        'files' => 0,
        'imgs' => 0,
        'vids' => 0,
        'docs' => 0,
        'folders' => 0,
        'size' => 0
    ];

    if (!is_dir($dir))
        return $stats;

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        if ($item->isDir()) {
            $stats['folders']++;
        } else {
            $stats['files']++;
            $stats['size'] += $item->getSize();

            $ext = strtolower($item->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                $stats['imgs']++;
            } elseif (in_array($ext, ['mp4', 'mov', 'webm', 'ogg'])) {
                $stats['vids']++;
            } elseif (in_array($ext, ['pdf', 'doc', 'docx', 'txt', 'zip'])) {
                $stats['docs']++;
            }
        }
    }
    return $stats;
}

$uploadStats = getDirStats('../assets/uploads');
$usedMB = round($uploadStats['size'] / (1024 * 1024), 2);
$capacityMB = 5000; // 5GB limit for portfolio assets
$storagePercent = min(100, round(($usedMB / $capacityMB) * 100, 1));

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'data' => [
        'used_mb' => $usedMB,
        'capacity_mb' => $capacityMB,
        'percent' => $storagePercent,
        'image_count' => $uploadStats['imgs']
    ]
]);
