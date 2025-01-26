<!doctype html>
<html class="no-js" lang="zxx">

<head>
	<title><?php echo  $page->title ? $page->title . " | " . SITE_TITLE : SITE_TITLE; ?></title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>">
	<meta name="description" content="<?php echo $page->meta_description ? $page->meta_description : SITE_DESCRIPTION; ?>">
	<meta property="og:url" content="<?php echo SITE_URL .  "/" . $page->slug; ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo  $page->title ? $page->title . " | " . SITE_TITLE : SITE_TITLE; ?>">
	<meta property="og:description" content="<?php echo $page->meta_description ? $page->meta_description : SITE_DESCRIPTION; ?>">
	<meta property="og:image" content="<?php echo UPLOAD_SERVER . "/" . $page->cover_image; ?>">
	<meta property="og:site_name" content="<?php echo  $page->title ? $page->title . " | " . SITE_TITLE : SITE_TITLE; ?>">
	<meta name="twitter:card" content="summary">
	<!-- <meta name="twitter:site" content="@tonisoft_web"> -->
	<meta name="twitter:title" content="<?php echo  $page->title ? $page->title . " | " . SITE_TITLE : SITE_TITLE; ?>">
	<meta name="twitter:description" content="<?php echo $page->meta_description ? $page->meta_description : SITE_DESCRIPTION; ?>">
	<meta name="twitter:image" content="<?php echo UPLOAD_SERVER . "/" . $page->cover_image; ?>">
	<meta name="twitter:image:alt" content="<?php echo  $page->title ? $page->title . " | " . SITE_TITLE : SITE_TITLE; ?>">
	<link rel="shortcut icon" href="<?php echo ASSETS; ?>/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="canonical" href="<?php echo SITE_URL .  "/" . $page->slug; ?>">
	<!-- Title -->


	<!-- Favicon -->
	<link rel="icon" href="<?php echo ASSETS; ?>/img/favicon/favicon.ico">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/bootstrap.min.css">
	<!-- Nice Select CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/nice-select.css">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/font-awesome.min.css">
	<!-- icofont CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/icofont.css">
	<!-- Slicknav -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/slicknav.min.css">
	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl-carousel.css">
	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/datepicker.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/animate.min.css">
	<!-- Magnific Popup CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/magnific-popup.css">

	<!-- Medipro CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/normalize.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/responsive.css?v=<?php echo time(); ?>">

	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo ASSETS; ?>/css/color1.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="#" id="colors">

	<link rel="stylesheet" href="<?php echo ASSETS; ?>/node_modules/aos/dist/aos.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HEHWG8NTHE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HEHWG8NTHE');
</script>
<body>

	<!-- Preloader -->
	<div class="preloader">
		<div class="loader">
			<div class="loader-outter"></div>
			<div class="loader-inner"></div>

			<div class="indicator">
				<!-- <svg width="16px" height="12px">
          <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
          <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
        </svg> -->
			</div>
		</div>
	</div>
	<!-- End Preloader -->

	<!-- Header Area -->
	<header class="header">
		<!-- Topbar -->
		<div class="topbar d-none d-md-block d-lg-block">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-5 col-12">
						<!-- Contact -->
						<ul class="top-link">
							<li><a href="#">About</a></li>
							<li><a href="#">Contact</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
						<!-- End Contact -->
					</div>
					<div class="col-lg-6 col-md-7 col-12">
						<!-- Top Contact -->
						<ul class="top-contact">
							<li><i class="fa fa-phone"></i>+254 727 758 360</li>
							<!-- <li><i class="fa fa-envelope"></i><a href="/cdn-cgi/l/email-protection#cbb8bebbbba4b9bf8bb2a4beb9a6aaa2a7e5a8a4a6"><span class="__cf_email__" data-cfemail="41323431312e333501382e34332c20282d6f222e2c">[email&#160;protected]</span></a></li> -->
							<li><i class="fa fa-envelope"></i> info@hpew.org</li>

						</ul>
						<!-- End Top Contact -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-12">
							<!-- Start Logo -->
							<div class="logo">
								<a href="/"><img src="<?php echo ASSETS; ?>/img/logo.png" alt="#"></a>
							</div>
							<!-- End Logo -->
							<!-- Mobile Nav -->
							<div class="mobile-nav"></div>
							<!-- End Mobile Nav -->
						</div>
						<div class="col-lg-9 col-md-9 col-12">
							<!-- Main Menu -->
							<div class="main-menu">
								<nav class="navigation">
									<ul class="nav menu float-right">
										<li class="<?php echo $parent == '' ? 'active' : ''; ?>"><a href="/">Home</a></li>
										<li class="<?php echo $parent == 'about-us' ? 'active' : ''; ?>"><a href="/about-us">About Us</a></li>
										<li class="<?php echo $parent == 'services' ? 'active' : ''; ?>"><a href="/services">Services</a></li>
										<li class="<?php echo $parent == 'blogs' ? 'active' : ''; ?>"><a href="/blogs">Blogs</a></li>
										<li class="<?php echo $parent == 'contact-us' ? 'active' : ''; ?>"><a href="/contact-us">Contact Us</a></li>
									</ul>
								</nav>
							</div>
							<!--/ End Main Menu -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Header Inner -->
	</header>
	<!-- End Header Area -->