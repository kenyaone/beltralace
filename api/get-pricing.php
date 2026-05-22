<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$pricingFile = __DIR__ . '/../admin/pricing-data.json';

if (file_exists($pricingFile)) {
    echo file_get_contents($pricingFile);
} else {
    // Return default pricing
    echo json_encode([
        ['hours' => 12, 'individual' => 840, 'group' => 444],
        ['hours' => 16, 'individual' => 960, 'group' => 576],
        ['hours' => 26, 'individual' => 1300, 'group' => 728],
        ['hours' => 40, 'individual' => 1720, 'group' => 1040],
        ['hours' => 60, 'individual' => 2400, 'group' => 1500],
        ['hours' => 80, 'individual' => 3040, 'group' => 1880],
        ['hours' => 100, 'individual' => 3700, 'group' => 2250],
    ], JSON_PRETTY_PRINT);
}
