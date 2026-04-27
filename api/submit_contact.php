<?php
require_once('../include/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$mobile = trim($input['mobile'] ?? '');
$subject = trim($input['subject'] ?? '');
$message = trim($input['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

try {
    // Save to database
    $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, mobile, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $mobile, $subject, $message]);

    // Fetch admin email from config
    $stmt = $pdo->query("SELECT section_content FROM contact_page_sections WHERE section_key = 'contact_form'");
    $config = $stmt->fetch();
    $admin_email = 'hello@weburea.com';
    if ($config) {
        $content = json_decode($config['section_content'], true);
        if (!empty($content['admin_email'])) {
            $admin_email = $content['admin_email'];
        }
    }

    // Send Email
    $to = $admin_email;
    $mail_subject = "New Contact Submission: " . ($subject ?: 'No Subject');
    
    $mail_body = "You have received a new contact message via Weburea Agency.\n\n";
    $mail_body .= "Name: $name\n";
    $mail_body .= "Email: $email\n";
    $mail_body .= "Mobile: $mobile\n";
    $mail_body .= "Subject: $subject\n\n";
    $mail_body .= "Message:\n$message\n";
    
    $headers = "From: noreply@weburea.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    @mail($to, $mail_subject, $mail_body, $headers);

    // Fetch modal configurations for the contact page
    $modalStmt = $pdo->prepare("SELECT modal_type, title, message, button_text, image_path, animation_type FROM modal_configurations WHERE context_key = 'contact'");
    $modalStmt->execute();
    $modals = $modalStmt->fetchAll(PDO::FETCH_ASSOC);
    
    $modalConfig = [];
    foreach ($modals as $m) {
        $modalConfig[$m['modal_type']] = $m;
    }

    echo json_encode([
        'success' => true, 
        'message' => 'Your message has been sent successfully!',
        'modal' => $modalConfig['success'] ?? null
    ]);

} catch (Exception $e) {
    // Attempt to fetch error modal config
    $errorModal = null;
    try {
        $modalStmt = $pdo->prepare("SELECT modal_type, title, message, button_text, image_path, animation_type FROM modal_configurations WHERE context_key = 'contact' AND modal_type = 'warning'");
        $modalStmt->execute();
        $errorModal = $modalStmt->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $ex) {}

    echo json_encode([
        'success' => false, 
        'message' => 'Failed to send message. Please try again.',
        'modal' => $errorModal ?: null
    ]);
}
