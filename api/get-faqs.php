<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/config/config.php';

use App\Controllers\FAQController;

try {
    $grouped = FAQController::getPublishedGroupedByCategory();

    $formatted = array();
    foreach ($grouped as $category => $items) {
        $formatted[$category] = array_map(function ($item) {
            return array(
                'id'       => (int) $item->id,
                'question' => $item->question,
                'answer'   => $item->answer,
            );
        }, $items);
    }

    echo json_encode(array(
        'success' => true,
        'faqs'    => $formatted,
    ), JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error fetching FAQs: ' . $e->getMessage(),
    ));
}
