<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 0, 'message' => 'Method not allowed']);
    exit();
}

require_once __DIR__ . '/config/config.php';
use App\Controllers\ReviewController;
use App\Controllers\EmailQueueController;

try {
    $_POST['is_published'] = 0; // Always unpublished initially
    
    $controller = new ReviewController($_POST);
    $result = $controller->create();
    
    // Send emails if successful
    if ($result->status) {
        $adminEmail = new EmailQueueController([
            'recipient_name' => 'Admin',
            'recipient_email' => ADMIN_EMAIL,
            'subject' => 'New Review From ' . $_POST['name'],
            'content_sections' => $controller->getReviewFormEmailContent()
        ]);
        $adminEmail->enqueue();
        
        if (!empty($_POST['email'])) {
            $ackEmail = new EmailQueueController([
                'recipient_name' => $_POST['name'],
                'recipient_email' => $_POST['email'],
                'subject' => 'Review Received',
                'content_sections' => $controller->getReviewAcknowledgmentEmailContent()
            ]);
            $ackEmail->enqueue();
        }
    }
    
    echo json_encode($result, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 0,
        'message' => DEBUG_MODE ? $e->getMessage() : 'An error occurred. Please try again.'
    ]);
}
