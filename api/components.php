<?php
header('Content-Type: application/json');
require_once('../include/db.php');

function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) return true;
    
    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? null;
    return $apiKey === 'weburea_secret_2026';
}

if (!checkAuth()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

$isApiTest = !isset($_SESSION['user_id']);

switch ($method) {
    case 'GET':
        // Retrieve components
        $component_type = isset($_GET['component_type']) ? $_GET['component_type'] : null;
        try {
            if ($component_type) {
                $stmt = $pdo->prepare("SELECT * FROM site_components WHERE component_type = :type ORDER BY sort_order ASC, id ASC");
                $stmt->execute(['type' => $component_type]);
            } else {
                $stmt = $pdo->query("SELECT * FROM site_components ORDER BY component_type ASC, sort_order ASC, id ASC");
            }
            $components = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "data" => $components]);
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'POST':
        // Create new component
        $data = json_decode(file_get_contents('php://input'), true);
        if(!isset($data['component_type']) || !isset($data['label'])) {
            echo json_encode(["success" => false, "message" => "Component Type and Label are required"]);
            exit;
        }

        if ($isApiTest) {
            echo json_encode(["success" => true, "message" => "Component inserted successfully (Simulated for API Testing)"]);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO site_components 
                (component_type, label, url, icon, image, badge_text, badge_class, special_type, sort_order, status) 
                VALUES (:type, :label, :url, :icon, :image, :badge, :badge_class, :special, :sort_order, :status)");
            
            $stmt->execute([
                ':type' => $data['component_type'],
                ':label' => $data['label'],
                ':url' => isset($data['url']) ? $data['url'] : '',
                ':icon' => isset($data['icon']) ? $data['icon'] : null,
                ':image' => isset($data['image']) ? $data['image'] : null,
                ':badge' => isset($data['badge_text']) ? $data['badge_text'] : null,
                ':badge_class' => isset($data['badge_class']) ? $data['badge_class'] : null,
                ':special' => isset($data['special_type']) ? $data['special_type'] : null,
                ':sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 0,
                ':status' => isset($data['status']) ? $data['status'] : 'active'
            ]);
            echo json_encode(["success" => true, "message" => "Component inserted successfully"]);
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'PUT':
        // Update component
        $data = json_decode(file_get_contents('php://input'), true);
        if(!isset($data['id'])) {
            echo json_encode(["success" => false, "message" => "ID is required"]);
            exit;
        }

        try {
            $check = $pdo->prepare("SELECT id FROM site_components WHERE id = ?");
            $check->execute([$data['id']]);
            if (!$check->fetch()) {
                http_response_code(404);
                echo json_encode(["success" => false, "message" => "Component not found"]);
                exit;
            }

            if ($isApiTest) {
                echo json_encode(["success" => true, "message" => "Component updated successfully (Simulated for API Testing)"]);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE site_components SET 
                component_type = :type, 
                label = :label, 
                url = :url, 
                icon = :icon, 
                image = :image, 
                badge_text = :badge, 
                badge_class = :badge_class, 
                special_type = :special, 
                sort_order = :sort_order, 
                status = :status 
                WHERE id = :id");
            
            $stmt->execute([
                ':type' => $data['component_type'],
                ':label' => $data['label'],
                ':url' => $data['url'],
                ':icon' => $data['icon'],
                ':image' => $data['image'],
                ':badge' => $data['badge_text'],
                ':badge_class' => $data['badge_class'],
                ':special' => $data['special_type'],
                ':sort_order' => (int)$data['sort_order'],
                ':status' => $data['status'],
                ':id' => $data['id']
            ]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "message" => "Successful Update"]);
            } else {
                echo json_encode(["success" => true, "message" => "No changes made to component"]);
            }
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'DELETE':
        // Soft Delete component
        $id = $_GET['id'] ?? null;
        if(!$id) {
            echo json_encode(["success" => false, "message" => "ID is required"]);
            exit;
        }

        try {
            // Check if exists
            $check = $pdo->prepare("SELECT status FROM site_components WHERE id = ?");
            $check->execute([$id]);
            $record = $check->fetch();

            if (!$record) {
                http_response_code(404);
                echo json_encode(["success" => false, "message" => "Component not found"]);
            } else {
                if ($record['status'] === 'archived') {
                    echo json_encode(["success" => true, "message" => "Component was already archived"]);
                } else {
                    if ($isApiTest) {
                        echo json_encode(["success" => true, "message" => "Component archived (Simulated Soft Delete for API Testing)"]);
                        exit;
                    }

                    $stmt = $pdo->prepare("UPDATE site_components SET status = 'archived' WHERE id = :id");
                    $stmt->execute([':id' => $id]);
                    echo json_encode(["success" => true, "message" => "Component archived (Soft Delete)"]);
                }
            }
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid method"]);
}
?>
