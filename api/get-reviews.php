<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'Controllers/ReviewController.php';

try {
    $reviews = ReviewController::getPublished();
    
    // Format reviews for frontend
    $formatted_reviews = array_map(function($review) {
        return [
            'id' => $review->id,
            'name' => $review->name,
            'body' => $review->review,
            'rating' => $review->rating ?? 5,
            'image_path' => $review->image_path,
            'created_at' => $review->created_at,
            'role' => 'Verified Student' // You can add a role field to the database later if needed
        ];
    }, $reviews);
    
    echo json_encode([
        'success' => true,
        'reviews' => $formatted_reviews
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching reviews: ' . $e->getMessage()
    ]);
}
