<?php


$viewPath = VIEWS.'/cms/pages.php';

if ($action == 'view' && is_numeric($index)) {
    $viewPath = VIEWS.'/cms/page_details.php';
}
else if(($action == 'new' || $action == 'edit')){
    $viewPath = VIEWS.'/cms/page_form.php';
}


include_once $viewPath;