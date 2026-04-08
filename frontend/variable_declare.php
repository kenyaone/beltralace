<?php

$parent = isset($_GET['parent']) ? $_GET['parent'] : null;
$child = isset($_GET['child']) ? $_GET['child'] : null;
$grand_child = isset($_GET['grand_child']) ? $_GET['grand_child'] : null;
$great_grand_child = isset($_GET['great_grand_child']) ? $_GET['great_grand_child'] : null;

// echo "Array is " . json_encode($_GET) . "<br>";
// echo "Parent is $parent, child is $child, grand_child is $grand_child and great_grand_child is $great_grand_child<br>";

$url = implode("/", $_GET);
$response = null;

try{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    
    $post_data = array(
        'object' => 'Page',
        'action' => 'get_by_url',
        'url' => $url
    );
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    $response = curl_exec($ch);
    
    // echo $url;
    // echo $response;
    // exit;
}
catch(Throwable $th){
    error_log($th->getMessage());
}

$page = $response ? json_decode($response) : null;
