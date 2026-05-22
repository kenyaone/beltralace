<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php
    // Route-based fallback titles and meta descriptions when no database entry exists
    $route_titles = [
        ''               => 'Online Language Courses with Native Speakers | ' . SITE_TITLE,
        'about-us'       => 'About Us | Language School Nairobi | ' . SITE_TITLE,
        'pricing'        => 'Language Course Pricing — Group, Private & Packages | ' . SITE_TITLE,
        'partners'       => 'Our Partners & Collaborations | Language Services | ' . SITE_TITLE,
        'blog'           => 'Language Learning Blog | Tips & Resources | ' . SITE_TITLE,
        'blogs'          => 'Language Learning Blog | Tips & Resources | ' . SITE_TITLE,
        'faqs'           => 'Frequently Asked Questions | Language Courses | ' . SITE_TITLE,
        'contact-us'     => 'Contact Us | Book a Free Consultation | ' . SITE_TITLE,
        'teaching-jobs'  => 'Language Teaching Jobs in Nairobi & Online | ' . SITE_TITLE,
        'privacy-policy' => 'Privacy Policy | ' . SITE_TITLE,
    ];
    $route_descriptions = [
        ''               => SITE_TITLE . ' offers online and in-person language courses — Swahili, English, French, Spanish, German and more — with native-speaking trainers in Nairobi, Kenya. Book a free consultation today.',
        'about-us'       => 'Meet the ' . SITE_TITLE . ' team — qualified professional linguists and native-speaking trainers based in Nairobi, Kenya, delivering language courses worldwide.',
        'partners'       => 'Discover ' . SITE_TITLE . ' partnerships and collaborations with organizations worldwide — delivering translation, interpretation, and language training services across diverse sectors.',
        'pricing'        => 'Transparent pricing for private, semi-private, group, and crash course language lessons at ' . SITE_TITLE . '. Virtual and face-to-face options available worldwide.',
        'blog'           => 'Language learning tips, guides, and resources from the ' . SITE_TITLE . ' team — covering Swahili, French, Spanish, German, English and more.',
        'blogs'          => 'Language learning tips, guides, and resources from the ' . SITE_TITLE . ' team — covering Swahili, French, Spanish, German, English and more.',
        'faqs'           => 'Answers to frequently asked questions about ' . SITE_TITLE . ' language courses, pricing, online lessons, and enrollment.',
        'contact-us'     => 'Get in touch with ' . SITE_TITLE . ' to book a free consultation, enquire about a language course, or reach our team in Nairobi, Kenya.',
        'teaching-jobs'  => 'Join the ' . SITE_TITLE . ' team as a language trainer. We hire native-speaking teachers for Swahili, French, Spanish, German, English and more — remote and Nairobi-based roles.',
        'privacy-policy' => SITE_TITLE . ' privacy policy — how we collect, use, and protect your personal data in line with GDPR.',
    ];
    // Language page fallbacks
    if ($parent === 'languages' && $child) {
        $lang = ucfirst($child);
        $route_titles['languages'] = "Learn $lang Online | $lang Lessons with Native Speakers | " . SITE_TITLE;
        $route_descriptions['languages'] = "Learn $lang with " . SITE_TITLE . " — native-speaking trainers, flexible online and in-person lessons, tailored to your level and goals. Based in Nairobi, Kenya. Enroll today.";
    }
    // For blog posts, $post is fetched server-side in blog-details.php before the header is output.
    $is_blog_post = ($parent === 'blog' || $parent === 'blogs') && !empty($child) && isset($post);
    $resolved_title = $is_blog_post && !empty($post->title)
        ? $post->title . ' | ' . SITE_TITLE
        : ($page->title ? $page->title . ' | ' . SITE_TITLE : ($route_titles[$parent] ?? SITE_TITLE));
    $resolved_description = $is_blog_post && !empty($post->meta_description)
        ? $post->meta_description
        : ($page->meta_description ? $page->meta_description : ($route_descriptions[$parent] ?? SITE_DESCRIPTION));
    $resolved_image = $is_blog_post && !empty($post->cover_image)
        ? rtrim(UPLOAD_SERVER, '/') . '/' . ltrim($post->cover_image, '/')
        : (isset($page->cover_image) ? UPLOAD_SERVER . '/' . $page->cover_image : '');
    $resolved_canonical = $is_blog_post
        ? SITE_URL . '/blog/' . htmlspecialchars($post->slug ?? $child)
        : SITE_URL . '/' . ($page->slug ?? '');
    ?>
    <title><?php echo htmlspecialchars($resolved_title); ?></title>

    <meta charset="UTF-8">
    <meta name="google-site-verification" content="fzGXU8tDKVbfHFWLpOGN9qnnOceVhb8VfLkgcRYsnFg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>">
    <meta name="description" content="<?php echo htmlspecialchars($resolved_description); ?>">

    <!-- Open Graph -->
    <meta property="og:url" content="<?php echo htmlspecialchars($resolved_canonical); ?>">
    <meta property="og:type" content="<?php echo $is_blog_post ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($resolved_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($resolved_description); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($resolved_image); ?>">
    <meta property="og:site_name" content="<?php echo SITE_TITLE; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($resolved_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($resolved_description); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($resolved_image); ?>">
    <meta name="twitter:image:alt" content="<?php echo htmlspecialchars($resolved_title); ?>">

    <!-- Security -->
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains">

    <link rel="shortcut icon" href="<?php echo ASSETS; ?>/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="<?php echo htmlspecialchars($resolved_canonical); ?>">

    <!-- Critical CSS — loaded immediately -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/bicon.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/themify-icons.css">

    <!-- Non-critical CSS — loaded after page render (improves speed) -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/animate.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/animate.css"></noscript>

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-layouts.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-layouts.css"></noscript>

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-small-screen.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce-small-screen.css"></noscript>

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/woocommerce.css"></noscript>

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.carousel.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.carousel.min.css"></noscript>

    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.theme.default.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo ASSETS; ?>/css/owl.theme.default.min.css"></noscript>

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/custom.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/toastr.min.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Google Analytics -->
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
        "https://web.facebook.com/Betralace",
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

    <?php elseif ($parent === 'pricing'): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "name": "Swahili Language Packages — BELTRALACE",
      "itemListElement": [
        {
          "@type": "Course",
          "position": 1,
          "name": "Speak Swahili in 4 Weeks — Beginner's Program",
          "description": "Build core conversational Swahili skills from scratch with native-speaking trainers.",
          "provider": { "@type": "LanguageSchool", "name": "BELTRALACE", "url": "<?php echo SITE_URL; ?>" },
          "offers": { "@type": "Offer", "price": "25000", "priceCurrency": "KES" },
          "url": "<?php echo SITE_URL; ?>/pricing"
        },
        {
          "@type": "Course",
          "position": 2,
          "name": "Become a Confident Swahili Speaker in 6 Weeks",
          "description": "Intermediate boot camp — gain real-world fluency and confidence in Swahili.",
          "provider": { "@type": "LanguageSchool", "name": "BELTRALACE", "url": "<?php echo SITE_URL; ?>" },
          "offers": { "@type": "Offer", "price": "35000", "priceCurrency": "KES" },
          "url": "<?php echo SITE_URL; ?>/pricing"
        },
        {
          "@type": "Course",
          "position": 3,
          "name": "Advance Your Swahili Skills in 10 Weeks",
          "description": "Intensive crash program — master advanced grammar and professional-level Swahili.",
          "provider": { "@type": "LanguageSchool", "name": "BELTRALACE", "url": "<?php echo SITE_URL; ?>" },
          "offers": { "@type": "Offer", "price": "55000", "priceCurrency": "KES" },
          "url": "<?php echo SITE_URL; ?>/pricing"
        }
      ]
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
                        <img src="<?php echo ASSETS; ?>/images/logo.png" alt="BELTRALACE — Online Language School Nairobi" class="img-fluid" style="height: 80px;">
                    </a>

                    <!-- Toggler -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                    </button>

                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="navbarMenu">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="/" class="nav-link js-scroll-trigger">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="/teaching-jobs" class="nav-link js-scroll-trigger">Teaching jobs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/partners" class="nav-link js-scroll-trigger">Partners</a>
                            </li>
                            <li class="nav-item">
                                <a href="/pricing" class="nav-link js-scroll-trigger">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a href="/blog" class="nav-link js-scroll-trigger">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="/faqs" class="nav-link js-scroll-trigger">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/contact-us" class="nav-link">Contact</a>
                            </li>
                        </ul>

                        <a href="https://wa.me/254724736255" target="_blank" rel="noopener noreferrer"
                           style="display:inline-flex;align-items:center;gap:6px;background:#25d366;color:#fff;padding:11px 18px;border-radius:5px;font-weight:700;font-size:14px;text-decoration:none;margin-right:8px;transition:all 0.3s;">
                            <i class="fa fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="btn btn-main btn-small" data-toggle="modal" data-target="#modal-form">
                            <i class="fa fa-paper-plane mr-2"></i>Get Started
                        </a>
                    </div>
                </div>
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
                                <img class="search-close" src="assets/images/close.png" srcset="assets/images/close@2x.png 2x" alt="Close search" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
