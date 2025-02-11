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
	<link rel="shortcut icon" href="<?php echo ASSETS; ?>/images/favicon/favicon.ico" type="image/x-icon">
	<link rel="canonical" href="<?php echo SITE_URL .  "/" . $page->slug; ?>">
	<!-- Title -->

    <!-- Mobile Specific Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/bootstrap.min.css">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/bicon.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/themify-icons.css">
    <!-- animate.css -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/animate.css">
    <!-- WooCOmmerce CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-layouts.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-small-screen.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce.css">
    <!-- Owl Carousel  CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.theme.default.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/custom.css?v=<?php echo time(); ?>">

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
<body id="top-header">
    <header>
        <!-- Main Menu Start -->
        <div class="site-navigation main_menu menu-2 container" id="mainmenu-area">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="<?php echo ASSETS; ?>/images/logo.png" alt="Logo" class="img-fluid" style="height: 80px;">
                        <!-- <span><?php echo SITE_TITLE ; ?></span> -->
                    </a>

                    <!-- Toggler -->

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                    </button>

                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="navbarMenu">

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item ">
                                <a href="/" class="nav-link js-scroll-trigger">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/teaching-jobs" class="nav-link js-scroll-trigger">
                                    Teaching jobs
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/" class="nav-link js-scroll-trigger">
                                    Pricing
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/" class="nav-link js-scroll-trigger">
                                    Blog
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/faqs" class="nav-link js-scroll-trigger">
                                    FAQs
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/contact-us" class="nav-link">
                                    Contact
                                </a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-main btn-small"><i class="fa fa-sign-in-alt mr-2"></i>Get started</a>

                    </div> <!-- / .navbar-collapse -->
                </div> <!-- / .container -->
            </nav>
        </div>
    </header>

    <!--search overlay start-->
    <div class="search-wrap">
        <div class="overlay">
            <form action="" class="search-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-9">
                            <h3>Search Your keyword</h3>
                            <input type="text" class="form-control" placeholder="Search..." />
                        </div>
                        <div class="col-md-2 col-3 text-right">
                            <div class="search_toggle toggle-wrap d-inline-block">
                                <img class="search-close" src="assets/images/close.png" srcset="assets/images/close@2x.png 2x" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>