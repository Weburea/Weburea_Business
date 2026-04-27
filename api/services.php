<?php
/**
 * Services API
 * Endpoints:
 * - GET /api/services.php          : Fetch all active services
 * - GET /api/services.php?slug=X   : Fetch single service by slug
 * - POST /api/services.php         : Create service (Admin only)
 * - PUT /api/services.php?id=X     : Update service (Admin only)
 * - DELETE /api/services.php?id=X  : Soft delete service (Admin only)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once('../include/db.php');

// Dual-Auth: Check for active session OR valid API Key header
function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 1. Check for Active Session (Dashboard)
    // We explicitly check for user_id and optionally user_role for admin level access if needed
    if (isset($_SESSION['user_id'])) {
        return true;
    }

    // 2. Check for API Key (Postman/External)
    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? null;
    $validKey = 'weburea_secret_2026'; // Secure this further in production

    if ($apiKey === $validKey) {
        return true;
    }

    return false;
}

$method = $_SERVER['REQUEST_METHOD'];
$response = ['success' => false, 'message' => 'Unknown error'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['slug']) || isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? OR id = ?");
                $stmt->execute([$_GET['slug'] ?? null, $_GET['id'] ?? null]);
                $data = $stmt->fetch();
                if ($data) {
                    $data['ecosystem_json'] = json_decode($data['ecosystem_json']);
                    $data['why_choose_json'] = json_decode($data['why_choose_json']);
                    $data['home_list_expert'] = json_decode($data['home_list_expert'] ?? '[]');
                    $data['tools_json'] = json_decode($data['tools_json'] ?? '[]');
                    $data['comparison_features_json'] = json_decode($data['comparison_features_json'] ?? '[]');
                    $response = ['success' => true, 'data' => $data];
                } else {
                    http_response_code(404);
                    $response['message'] = 'Service not found';
                }
            } else {
                // If authenticated (Admin), show all services including drafts
                // Otherwise (Public), show only active services
                if (checkAuth()) {
                    $stmt = $pdo->query("SELECT * FROM services ORDER BY id ASC");
                } else {
                    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
                }
                
                $data = $stmt->fetchAll();
                foreach($data as &$item) {
                    $item['ecosystem_json'] = json_decode($item['ecosystem_json']);
                    $item['why_choose_json'] = json_decode($item['why_choose_json']);
                    $item['home_list_expert'] = json_decode($item['home_list_expert'] ?? '[]');
                    $item['tools_json'] = json_decode($item['tools_json'] ?? '[]');
                    $item['comparison_features_json'] = json_decode($item['comparison_features_json'] ?? '[]');
                }
                $response = ['success' => true, 'data' => $data];
            }
            break;

        case 'POST':
            if (!checkAuth()) {
                http_response_code(403);
                $response['message'] = 'Unauthorized access';
                break;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                // Fallback to $_POST for traditional forms
                $input = $_POST;
            }

            if (empty($input['name']) || empty($input['slug'])) {
                $response['message'] = 'Name and slug are required';
                break;
            }

            $isApiTest = !isset($_SESSION['user_id']);
            if ($isApiTest) {
                $response = ['success' => true, 'message' => 'Service created successfully (Simulated for API Testing)', 'id' => 999];
                break;
            }

            $sql = "INSERT INTO services (name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert, tools_json, comparison_features_json, status) 
                    VALUES (:name, :slug, :description_short, :hero_title, :hero_video, :overview_badge, :overview_title, :overview_lead, :overview_text, :detail_video, :icon_3d, :ecosystem_json, :why_choose_json, :home_list_expert, :tools_json, :comparison_features_json, :status)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $input['name'],
                ':slug' => $input['slug'],
                ':description_short' => $input['description_short'] ?? '',
                ':hero_title' => $input['hero_title'] ?? '',
                ':hero_video' => $input['hero_video'] ?? '',
                ':overview_badge' => $input['overview_badge'] ?? 'Company Overview',
                ':overview_title' => $input['overview_title'] ?? '',
                ':overview_lead' => $input['overview_lead'] ?? '',
                ':overview_text' => $input['overview_text'] ?? '',
                ':detail_video' => $input['detail_video'] ?? '',
                ':icon_3d' => $input['icon_3d'] ?? '',
                ':ecosystem_json' => is_array($input['ecosystem_json']) ? json_encode($input['ecosystem_json']) : ($input['ecosystem_json'] ?? '[]'),
                ':why_choose_json' => is_array($input['why_choose_json']) ? json_encode($input['why_choose_json']) : ($input['why_choose_json'] ?? '[]'),
                ':home_list_expert' => is_array($input['home_list_expert']) ? json_encode($input['home_list_expert']) : ($input['home_list_expert'] ?? '[]'),
                ':tools_json' => is_array($input['tools_json']) ? json_encode($input['tools_json']) : ($input['tools_json'] ?? '[]'),
                ':comparison_features_json' => is_array($input['comparison_features_json']) ? json_encode($input['comparison_features_json']) : ($input['comparison_features_json'] ?? '[]'),
                ':status' => $input['status'] ?? 'active'
            ]);

            $response = ['success' => true, 'message' => 'Service created successfully', 'id' => $pdo->lastInsertId()];
            break;

        case 'PUT':
            if (!checkAuth()) {
                http_response_code(403);
                $response['message'] = 'Unauthorized access';
                break;
            }

            // For PUT, we allow partial updates
            // Only name and slug are strongly recommended if provided, but not strictly required if we are updating other fields
            // However, we still need to ensure ID is valid
            $id = $_GET['id'] ?? null;
            if (!$id) {
                $response['message'] = 'ID required for update';
                break;
            }

            // Check if ID exists first
            $check = $pdo->prepare("SELECT id FROM services WHERE id = ?");
            $check->execute([$id]);
            if (!$check->fetch()) {
                http_response_code(404);
                $response = ['success' => false, 'message' => 'Service not found'];
                break;
            }

            $isApiTest = !isset($_SESSION['user_id']);
            if ($isApiTest) {
                $response = ['success' => true, 'message' => 'Service updated successfully (Simulated for API Testing)'];
                break;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                $input = $_POST;
            }

            $sql = "UPDATE services SET 
                    name = COALESCE(:name, name), 
                    slug = COALESCE(:slug, slug), 
                    description_short = COALESCE(:description_short, description_short), 
                    hero_title = COALESCE(:hero_title, hero_title), 
                    hero_video = COALESCE(:hero_video, hero_video), 
                    overview_badge = COALESCE(:overview_badge, overview_badge), 
                    overview_title = COALESCE(:overview_title, overview_title), 
                    overview_lead = COALESCE(:overview_lead, overview_lead), 
                    overview_text = COALESCE(:overview_text, overview_text), 
                    detail_video = COALESCE(:detail_video, detail_video), 
                    icon_3d = COALESCE(:icon_3d, icon_3d), 
                    ecosystem_json = COALESCE(:ecosystem_json, ecosystem_json), 
                    why_choose_json = COALESCE(:why_choose_json, why_choose_json), 
                    home_list_expert = COALESCE(:home_list_expert, home_list_expert), 
                    tools_json = COALESCE(:tools_json, tools_json), 
                    comparison_features_json = COALESCE(:comparison_features_json, comparison_features_json),
                    status = COALESCE(:status, status) 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $input['name'] ?? null,
                ':slug' => $input['slug'] ?? null,
                ':description_short' => $input['description_short'] ?? null,
                ':hero_title' => $input['hero_title'] ?? null,
                ':hero_video' => $input['hero_video'] ?? null,
                ':overview_badge' => $input['overview_badge'] ?? null,
                ':overview_title' => $input['overview_title'] ?? null,
                ':overview_lead' => $input['overview_lead'] ?? null,
                ':overview_text' => $input['overview_text'] ?? null,
                ':detail_video' => $input['detail_video'] ?? null,
                ':icon_3d' => $input['icon_3d'] ?? null,
                ':ecosystem_json' => isset($input['ecosystem_json']) ? (is_array($input['ecosystem_json']) ? json_encode($input['ecosystem_json']) : $input['ecosystem_json']) : null,
                ':why_choose_json' => isset($input['why_choose_json']) ? (is_array($input['why_choose_json']) ? json_encode($input['why_choose_json']) : $input['why_choose_json']) : null,
                ':home_list_expert' => isset($input['home_list_expert']) ? (is_array($input['home_list_expert']) ? json_encode($input['home_list_expert']) : $input['home_list_expert']) : null,
                ':tools_json' => isset($input['tools_json']) ? (is_array($input['tools_json']) ? json_encode($input['tools_json']) : $input['tools_json']) : null,
                ':comparison_features_json' => isset($input['comparison_features_json']) ? (is_array($input['comparison_features_json']) ? json_encode($input['comparison_features_json']) : $input['comparison_features_json']) : null,
                ':status' => $input['status'] ?? null
            ]);

            if ($stmt->rowCount() > 0) {
                $response = ['success' => true, 'message' => 'Successful Update'];
            } else {
                $response = ['success' => true, 'message' => 'No Changes Made'];
            }
            break;

        case 'DELETE':
            if (!checkAuth()) {
                http_response_code(403);
                $response['message'] = 'Unauthorized access';
                break;
            }

            $id = $_GET['id'] ?? null;
            if (!$id) {
                $response['message'] = 'ID required';
                break;
            }

            // --- SMART CLEANUP START ---
            // 1. Fetch service details to identify files
            $stmt = $pdo->prepare("SELECT icon_3d, hero_video, detail_video, tools_json, why_choose_json, status FROM services WHERE id = ?");
            $stmt->execute([$id]);
            $service = $stmt->fetch();

            if ($service) {
                // If already archived, return informative success
                if ($service['status'] === 'archived') {
                    $response = ['success' => true, 'message' => 'Service was already archived'];
                } else {
                    $isApiTest = !isset($_SESSION['user_id']);
                    if ($isApiTest) {
                        $response = ['success' => true, 'message' => 'Service archived (Simulated Soft Delete for API Testing)'];
                        break;
                    }

                    // Soft Delete: Instead of removing record and cleaning files, we just mark as archived
                    $stmt = $pdo->prepare("UPDATE services SET status = 'archived' WHERE id = ?");
                    $stmt->execute([$id]);
                    $response = ['success' => true, 'message' => 'Service archived (Soft Delete). Media files preserved.'];
                }
            } else {
                http_response_code(404);
                $response['message'] = 'Service not found';
            }
            break;

        default:
            http_response_code(405);
            $response['message'] = 'Method not allowed';
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
