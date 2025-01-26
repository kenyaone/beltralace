<?php

$page = isset($_GET['page']) ? $_GET['page'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$value = isset($_GET['value']) ? $_GET['value'] : null;
$section = isset($_GET['section']) ? $_GET['section'] : null;

$index = isset($value) ? decrypt_data($value) : null;

