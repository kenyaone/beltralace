<?php

session_start();

unset($_SESSION['user']);
session_destroy();


http_response_code(200);
echo json_encode(array(
    'status' => 1,
    'message' => 'Logged out successfully'
));