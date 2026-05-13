<?php
/**
 * Works API
 * Endpoints:
 * - GET /api/works.php          : Fetch all active works
 * - GET /api/works.php?id=X     : Fetch single work by id
 * - POST /api/works.php         : Create work (Admin only)
 * - PUT /api/works.php?id=X     : Update work (Admin only)
 * - DELETE /api/works.php?id=X  : Soft delete work (Admin only)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once('../include/auth.php');
require_once('../include/db.php');

$method = $_SERVER['REQUEST_METHOD'];
$response = ['success' => false, 'message' => 'Unknown error'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT w.*, s.name as service_name 
                                       FROM portfolio_works w 
                                       LEFT JOIN services s ON w.service_id = s.id 
                                       WHERE w.id = ?");
                $stmt->execute([$_GET['id']]);
                $data = $stmt->fetch();
                if ($data) {
                    $data['additional_images'] = json_decode($data['additional_images'] ?? '[]');
                    $data['testimonials_json'] = json_decode($data['testimonials_json'] ?? '[]');
                    $data['service_data_json'] = json_decode($data['service_data_json'] ?? '{}');
                    $data['status'] = $data['status'] ?? 'published';
                    $data['sort_order'] = (int)($data['sort_order'] ?? 0);
                    $response = ['success' => true, 'data' => $data];
                } else {
                    http_response_code(404);
                    $response['message'] = 'Work not found';
                }
            } else {
                $showAll = checkAuth() && isset($_GET['all']) && $_GET['all'] == '1';
                if ($showAll) {
                    $stmt = $pdo->query("SELECT w.*, s.name as service_name 
                                         FROM portfolio_works w 
                                         LEFT JOIN services s ON w.service_id = s.id 
                                         ORDER BY (w.sort_order = 0), w.sort_order ASC, w.id ASC");
                } else {
                    $stmt = $pdo->query("SELECT w.*, s.name as service_name 
                                         FROM portfolio_works w 
                                         LEFT JOIN services s ON w.service_id = s.id 
                                         WHERE w.status = 'published' 
                                         ORDER BY (w.sort_order = 0), w.sort_order ASC, w.id ASC");
                }
                
                $data = $stmt->fetchAll();
                foreach($data as &$item) {
                    $item['additional_images'] = json_decode($item['additional_images'] ?? '[]');
                    $item['testimonials_json'] = json_decode($item['testimonials_json'] ?? '[]');
                    $item['service_data_json'] = json_decode($item['service_data_json'] ?? '{}');
                    $item['status'] = $item['status'] ?? 'published';
                    $item['sort_order'] = (int)($item['sort_order'] ?? 0);
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
                $input = $_POST;
            }

            if (empty($input['title'])) {
                $response['message'] = 'Title is required';
                break;
            }


            $sql = "INSERT INTO portfolio_works (title, description, project_overview, project_challenge, project_result, challenge_points, client_logo_light, client_logo_dark, image, additional_images, comparison_image, year, industry, project_direction, categories, service_id, pricing_id, service_data_json, status, sort_order, testimonial_text, testimonial_author, testimonial_role, testimonial_image, testimonials_json, meta_title, meta_description, meta_keywords, meta_og_image, meta_twitter_image, meta_og_type, live_url) 
                    VALUES (:title, :description, :project_overview, :project_challenge, :project_result, :challenge_points, :client_logo_light, :client_logo_dark, :image, :additional_images, :comparison_image, :year, :industry, :project_direction, :categories, :service_id, :pricing_id, :service_data_json, :status, :sort_order, :testimonial_text, :testimonial_author, :testimonial_role, :testimonial_image, :testimonials_json, :meta_title, :meta_description, :meta_keywords, :meta_og_image, :meta_twitter_image, :meta_og_type, :live_url)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title' => $input['title'],
                ':description' => $input['description'] ?? '',
                ':project_overview' => $input['project_overview'] ?? '',
                ':project_challenge' => $input['project_challenge'] ?? '',
                ':project_result' => $input['project_result'] ?? '',
                ':challenge_points' => $input['challenge_points'] ?? '',
                ':client_logo_light' => $input['client_logo_light'] ?? '',
                ':client_logo_dark' => $input['client_logo_dark'] ?? '',
                ':image' => $input['image'] ?? '',
                ':additional_images' => $input['additional_images'] ?? '',
                ':comparison_image' => $input['comparison_image'] ?? '',
                ':year' => $input['year'] ?? '',
                ':industry' => $input['industry'] ?? '',
                ':project_direction' => $input['project_direction'] ?? '',
                ':categories' => $input['categories'] ?? '',
                ':service_id' => !empty($input['service_id']) ? $input['service_id'] : null,
                ':pricing_id' => !empty($input['pricing_id']) ? $input['pricing_id'] : null,
                ':service_data_json' => $input['service_data_json'] ?? null,
                ':status' => $input['status'] ?? 'published',
                ':sort_order' => $input['sort_order'] ?? 0,
                ':testimonial_text' => $input['testimonial_text'] ?? '',
                ':testimonial_author' => $input['testimonial_author'] ?? '',
                ':testimonial_role' => $input['testimonial_role'] ?? '',
                ':testimonial_image' => $input['testimonial_image'] ?? '',
                ':meta_title' => $input['meta_title'] ?? '',
                ':meta_description' => $input['meta_description'] ?? '',
                ':meta_keywords' => $input['meta_keywords'] ?? '',
                ':testimonials_json' => $input['testimonials_json'] ?? '[]',
                ':meta_og_image' => $input['meta_og_image'] ?? '',
                ':meta_twitter_image' => $input['meta_twitter_image'] ?? '',
                ':meta_og_type' => $input['meta_og_type'] ?? 'website',
                ':live_url' => $input['live_url'] ?? ''
            ]);

            $response = ['success' => true, 'message' => 'Work created successfully', 'id' => $pdo->lastInsertId()];
            break;

        case 'PUT':
            if (!checkAuth()) {
                http_response_code(403);
                $response['message'] = 'Unauthorized access';
                break;
            }

            $id = $_GET['id'] ?? null;
            if (!$id) {
                $response['message'] = 'ID required for update';
                break;
            }

            $check = $pdo->prepare("SELECT id FROM portfolio_works WHERE id = ?");
            $check->execute([$id]);
            if (!$check->fetch()) {
                http_response_code(404);
                $response = ['success' => false, 'message' => 'Work not found'];
                break;
            }


            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                $input = $_POST;
            }

            // Conflict Resolution: If sort_order is manually set and different from 0, shift others
            $new_sort_order = isset($input['sort_order']) ? (int)$input['sort_order'] : null;
            if ($new_sort_order !== null && $new_sort_order > 0) {
                $current = $pdo->prepare("SELECT sort_order FROM portfolio_works WHERE id = ?");
                $current->execute([$id]);
                $old_order = $current->fetchColumn();
                
                if ($old_order != $new_sort_order) {
                    // Shift existing items up to make room
                    $shift = $pdo->prepare("UPDATE portfolio_works SET sort_order = sort_order + 1 WHERE sort_order >= ? AND id != ?");
                    $shift->execute([$new_sort_order, $id]);
                }
            }

            $sql = "UPDATE portfolio_works SET 
                    title = COALESCE(:title, title), 
                    description = COALESCE(:description, description), 
                    project_overview = COALESCE(:project_overview, project_overview),
                    project_challenge = COALESCE(:project_challenge, project_challenge),
                    project_result = COALESCE(:project_result, project_result),
                    challenge_points = COALESCE(:challenge_points, challenge_points),
                    client_logo_light = COALESCE(:client_logo_light, client_logo_light), 
                    client_logo_dark = COALESCE(:client_logo_dark, client_logo_dark), 
                    image = COALESCE(:image, image), 
                    additional_images = COALESCE(:additional_images, additional_images),
                    comparison_image = COALESCE(:comparison_image, comparison_image),
                    year = COALESCE(:year, year), 
                    industry = COALESCE(:industry, industry),
                    project_direction = COALESCE(:project_direction, project_direction),
                    categories = COALESCE(:categories, categories), 
                    service_id = COALESCE(:service_id, service_id), 
                    pricing_id = COALESCE(:pricing_id, pricing_id), 
                    service_data_json = COALESCE(:service_data_json, service_data_json),
                    status = COALESCE(:status, status),
                    sort_order = COALESCE(:sort_order, sort_order),
                    testimonial_text = COALESCE(:testimonial_text, testimonial_text),
                    testimonial_author = COALESCE(:testimonial_author, testimonial_author),
                    testimonial_role = COALESCE(:testimonial_role, testimonial_role),
                    testimonial_image = COALESCE(:testimonial_image, testimonial_image),
                    meta_title = COALESCE(:meta_title, meta_title),
                    meta_description = COALESCE(:meta_description, meta_description),
                    meta_keywords = COALESCE(:meta_keywords, meta_keywords),
                    testimonials_json = COALESCE(:testimonials_json, testimonials_json),
                    meta_og_image = COALESCE(:meta_og_image, meta_og_image),
                    meta_twitter_image = COALESCE(:meta_twitter_image, meta_twitter_image),
                    meta_og_type = COALESCE(:meta_og_type, meta_og_type),
                    live_url = COALESCE(:live_url, live_url)
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':title' => $input['title'] ?? null,
                ':description' => $input['description'] ?? null,
                ':project_overview' => $input['project_overview'] ?? null,
                ':project_challenge' => $input['project_challenge'] ?? null,
                ':project_result' => $input['project_result'] ?? null,
                ':challenge_points' => $input['challenge_points'] ?? null,
                ':client_logo_light' => $input['client_logo_light'] ?? null,
                ':client_logo_dark' => $input['client_logo_dark'] ?? null,
                ':image' => $input['image'] ?? null,
                ':additional_images' => $input['additional_images'] ?? null,
                ':comparison_image' => $input['comparison_image'] ?? null,
                ':year' => $input['year'] ?? null,
                ':industry' => $input['industry'] ?? null,
                ':project_direction' => $input['project_direction'] ?? null,
                ':categories' => $input['categories'] ?? null,
                ':service_id' => isset($input['service_id']) ? ($input['service_id'] === '' ? null : $input['service_id']) : null,
                ':pricing_id' => isset($input['pricing_id']) ? ($input['pricing_id'] === '' ? null : $input['pricing_id']) : null,
                ':service_data_json' => $input['service_data_json'] ?? null,
                ':status' => $input['status'] ?? null,
                ':sort_order' => $new_sort_order,
                ':testimonial_text' => $input['testimonial_text'] ?? null,
                ':testimonial_author' => $input['testimonial_author'] ?? null,
                ':testimonial_role' => $input['testimonial_role'] ?? null,
                ':testimonial_image' => $input['testimonial_image'] ?? null,
                ':meta_title' => $input['meta_title'] ?? null,
                ':meta_description' => $input['meta_description'] ?? null,
                ':meta_keywords' => $input['meta_keywords'] ?? null,
                ':testimonials_json' => $input['testimonials_json'] ?? null,
                ':meta_og_image' => $input['meta_og_image'] ?? null,
                ':meta_twitter_image' => $input['meta_twitter_image'] ?? null,
                ':meta_og_type' => $input['meta_og_type'] ?? null,
                ':live_url' => $input['live_url'] ?? null
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

            // Fetch work to get file paths for deletion
            $stmt = $pdo->prepare("SELECT image, comparison_image, additional_images, client_logo_light, client_logo_dark, testimonial_image, service_data_json FROM portfolio_works WHERE id = ?");
            $stmt->execute([$id]);
            $work = $stmt->fetch();

            if ($work) {
                // Hard delete the record
                $stmt = $pdo->prepare("DELETE FROM portfolio_works WHERE id = ?");
                $stmt->execute([$id]);

                // Delete associated files to save space
                $filesToDelete = [
                    $work['image'],
                    $work['comparison_image'],
                    $work['client_logo_light'],
                    $work['client_logo_dark'],
                    $work['testimonial_image']
                ];

                // Add additional images if any
                if (!empty($work['additional_images'])) {
                    $additional = json_decode($work['additional_images'], true);
                    if (is_array($additional)) {
                        foreach ($additional as $img) {
                            if (is_string($img)) {
                                $filesToDelete[] = $img;
                            } elseif (is_array($img) && !empty($img['path'])) {
                                $filesToDelete[] = $img['path'];
                            }
                        }
                    } else {
                        // Fallback for old comma-separated format
                        $oldFormat = explode(',', $work['additional_images']);
                        foreach ($oldFormat as $img) {
                            $filesToDelete[] = trim($img);
                        }
                    }
                }

                // Scan service_data_json for any other media paths
                if (!empty($work['service_data_json'])) {
                    $specData = json_decode($work['service_data_json'], true);
                    if (is_array($specData)) {
                        array_walk_recursive($specData, function($val) use (&$filesToDelete) {
                            // If the value looks like a path (starts with assets/ or uploads/), add it
                            if (is_string($val) && (strpos($val, 'assets/') === 0 || strpos($val, 'uploads/') === 0)) {
                                $filesToDelete[] = $val;
                            }
                        });
                    }
                }

                // Extract images from testimonials_json
                if (!empty($work['testimonials_json'])) {
                    $testimonials = json_decode($work['testimonials_json'], true);
                    if (is_array($testimonials)) {
                        foreach ($testimonials as $t) {
                            if (!empty($t['image'])) {
                                $filesToDelete[] = $t['image'];
                            }
                        }
                    }
                }

                $deletedCount = 0;
                $uniqueFiles = array_unique(array_filter($filesToDelete));
                foreach ($uniqueFiles as $file) {
                    if (!empty($file)) {
                        $filePath = '../' . $file;
                        if (file_exists($filePath) && is_file($filePath)) {
                            unlink($filePath);
                            $deletedCount++;
                        }
                    }
                }


                $response = ['success' => true, 'message' => "Work permanently deleted. $deletedCount media assets removed from storage."];
            } else {
                http_response_code(404);
                $response['message'] = 'Work not found';
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
