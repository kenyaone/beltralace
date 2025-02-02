<?php


$viewPath = VIEWS.'/administration/users.php';

if ($action == 'view' && is_numeric($index)) {
    $viewPath = VIEWS.'/administration/user_details.php';
}
else if(($action == 'new' || $action == 'edit')){
    $viewPath = VIEWS.'/administration/user_form.php';
}


include_once $viewPath;