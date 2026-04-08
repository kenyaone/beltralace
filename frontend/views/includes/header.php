<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    // Route-based fallback titles and meta descriptions when no database entry exists
    $route_titles = [
        ''               => 'Online Language Courses with Native-Speaking Trainers | BETRALACE',
        'about-us'       => 'About Us | Language School Nairobi | BETRALACE',
        'pricing'        => 'Language Course Pricing | Private & Group Lessons | BETRALACE',
        'blog'           => 'Language Learning Blog | Tips & Resources | BETRALACE',
        'blogs'          => 'Language Learning Blog | Tips & Resources | BETRALACE',
        'faqs'           => 'Frequently Asked Questions | Language Courses | BETRALACE',
        'contact-us'     => 'Contact Us | Book a Free Consultation | BETRALACE',
        'teaching-jobs'  => 'Language Teaching Jobs in Nairobi & Online | BETRALACE',
        'privacy-policy' => 'Privacy Policy | BETRALACE',
    ];
    $route_descriptions = [
        ''               => 'BETRALACE offers online and in-person language courses — Swahili, English, French, Spanish, German and more — with native-speaking trainers in Nairobi, Kenya. Book a free consultation today.',
        'about-us'       => 'Meet the BETRALACE team — qualified professional linguists and native-speaking trainers based in Nairobi, Kenya, delivering language courses worldwide.',
        'pricing'        => 'Transparent pricing for private, semi-private, group, and crash course language lessons at BETRALACE. Virtual and face-to-face options available worldwide.',
        'blog'           => 'Language learning tips, guides, and resources from the BETRALACE team — covering Swahili, French, Spanish, German, English and more.',
        'blogs'          => 'Language learning tips, guides, and resources from the BETRALACE team — covering Swahili, French, Spanish, German, English and more.',
        'faqs'           => 'Answers to frequently asked questions about BETRALACE language courses, pricing, online lessons, and enrollment.',
        'contact-us'     => 'Get in touch with BETRALACE to book a free consultation, enquire about a language course, or reach our team in Nairobi, Kenya.',
        'teaching-jobs'  => 'Join the BETRALACE team as a language trainer. We hire native-speaking teachers for Swahili, French, Spanish, German, English and more — remote and Nairobi-based roles.',
        'privacy-policy' => 'BETRALACE privacy policy — how we collect, use, and protect your personal data in line with GDPR.',
    ];
    // Language page fallbacks
    if ($parent === 'languages' && $child) {
        $lang = ucfirst($child);
        $route_titles['languages'] = "Learn $lang Online | $lang Lessons with Native Speakers | BETRALACE";
        $route_descriptions['languages'] = "Learn $lang with BETRALACE — native-speaking trainers, flexible online and in-person lessons, tailored to your level and goals. Based in Nairobi, Kenya. Enroll today.";
    }
    $resolved_title = $page->title
        ? $page->title . ' | ' . SITE_TITLE
        : ($route_titles[$parent] ?? SITE_TITLE);
    $resolved_description = $page->meta_description
        ? $page->meta_description
        : ($route_descriptions[$parent] ?? SITE_DESCRIPTION);
    ?>
    <title><?php echo htmlspecialchars($resolved_title); ?></title>
    
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>">
	<meta name="description" content="<?php echo htmlspecialchars($resolved_description); ?>">
	<meta property="og:url" content="<?php echo SITE_URL .  "/" . $page->slug; ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo htmlspecialchars($resolved_title); ?>">
	<meta property="og:description" content="<?php echo htmlspecialchars($resolved_description); ?>">
	<meta property="og:image" content="<?php echo UPLOAD_SERVER . "/" . $page->cover_image; ?>">
	<meta property="og:site_name" content="BETRALACE">
	<meta name="twitter:card" content="summary">
	<!-- <meta name="twitter:site" content="@tonisoft_web"> -->
	<meta name="twitter:title" content="<?php echo htmlspecialchars($resolved_title); ?>">
	<meta name="twitter:description" content="<?php echo htmlspecialchars($resolved_description); ?>">
	<meta name="twitter:image" content="<?php echo UPLOAD_SERVER . "/" . $page->cover_image; ?>">
	<meta name="twitter:image:alt" content="<?php echo htmlspecialchars($resolved_title); ?>">
	<link rel="shortcut icon" href="<?php echo ASSETS; ?>/images/favicon/favicon.ico" type="image/x-icon">
	<link rel="canonical" href="<?php echo SITE_URL .  "/" . $page->slug; ?>">
	<!-- Title -->

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

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/toastr.min.css?">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HEHWG8NTHE"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'G-HEHWG8NTHE');
	</script>

	<!-- JSON-LD Structured Data -->
	<?php if (!$parent): ?>
	<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "LanguageSchool",
	  "name": "BELTRALACE",
	  "url": "<?php echo SITE_URL; ?>",
	  "description": "<?php echo SITE_DESCRIPTION; ?>",
	  "address": {
	    "@type": "PostalAddress",
	    "addressLocality": "Nairobi",
	    "addressCountry": "KE"
	  },
	  "telephone": "+254724736255",
	  "email": "info@beltralace.com",
	  "sameAs": [
	    "https://web.facebook.com/BelxinTranslatorsAndLanguageCentreBeltralace",
	    "https://www.linkedin.com/in/belxin-translators-language-centre-5075b65a/"
	  ]
	}
	</script>
	<?php elseif ($parent === 'languages' && $child): ?>
	<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "Course",
	  "name": "<?php echo ucfirst(htmlspecialchars($child)); ?> Language Course",
	  "description": "Learn <?php echo ucfirst(htmlspecialchars($child)); ?> online or in-person with native-speaking trainers at BELTRALACE, Nairobi, Kenya.",
	  "provider": {
	    "@type": "LanguageSchool",
	    "name": "BELTRALACE",
	    "url": "<?php echo SITE_URL; ?>"
	  },
	  "url": "<?php echo SITE_URL; ?>/languages/<?php echo htmlspecialchars($child); ?>"
	}
	</script>
	<?php endif; ?>

</head>
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
                                <a href="/pricing" class="nav-link js-scroll-trigger">
                                    Pricing
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="/blog" class="nav-link js-scroll-trigger">
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

                        <a href="#" class="btn btn-main btn-small" data-toggle="modal" data-target="#modal-form"><i class="fa fa-sign-in-alt mr-2"></i>Get started</a>

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