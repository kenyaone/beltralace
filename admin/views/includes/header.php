<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?php echo SITETITLE; ?>">

	<link rel="preconnect" href="https://fonts.gstatic.com">

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title><?php echo SITETITLE; ?> | Dashboard</title>

	<link href="<?php echo ASSETS_PATH;?>/admin/css/light.css" rel="stylesheet">
	<link href="<?php echo ASSETS_PATH;?>/admin/css/style.css" rel="stylesheet">
	<link href="<?php echo ASSETS_PATH;?>/admin/css/choices.min.css"  rel="stylesheet">

	<link href="<?php echo ASSETS_PATH;?>/admin/css/dropzone.min.css"  rel="stylesheet">
	<link href="<?php echo ASSETS_PATH;?>/admin/css/doka.min.css"  rel="stylesheet">
	
	<link href="<?php echo ASSETS_PATH;?>/node_modules/toastr/build/toastr.min.css" rel="stylesheet">
	<style>
		.ck-editor__editable { min-height: 250px; font-family: 'Inter', sans-serif; font-size: 14px; }
	</style>

	<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/magnific.popup.css">

	<script src="<?php echo ASSETS_PATH; ?>/admin/js/jquery.min.js"></script>
	<script src="<?php echo ASSETS_PATH; ?>/admin/js/ckeditor.classic.js"></script>
	
	<script type="text/javascript" src="<?php echo ASSETS_PATH; ?>/js/magnific.popup.js"></script>
	
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
</head>
<body>
<div id="overlay" class="d-none">
	<img src="<?php echo ASSETS_PATH;?>/img/icons/loader.gif" class="loader"/>
</div>
<?php
// $user = Auth::current_user();
$user = $_SESSION['user'];
?>
<div class="wrapper">
    <?php include_once 'sidebar-nav.php'; ?>

    <div class="main">
        <?php include_once 'topbar-nav.php'; ?>