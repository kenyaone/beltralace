<?php


$viewPath = VIEWS.'/cms/widgets.php';

if ($action == 'view' && is_numeric($index)) {
    $viewPath = VIEWS.'/cms/widget_details.php';
}
else if(($action == 'new' || $action == 'edit')){
    $viewPath = VIEWS.'/cms/widget_form.php';
}


include_once $viewPath;