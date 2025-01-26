<?php

switch ($page) {
    case 'pages':
        include_once 'route/route-pages.php';
        break;

    case 'widgets':
        include_once 'route/route-widgets.php';
        break;

    case 'blog-articles':
        include_once 'route/route-blogs.php';
        break;
    
    case 'users':
        include_once 'route/route-users.php';
        break;

    case 'profile':
        include_once 'route/route-profile.php';
        break;

    case 'login':
        include_once 'views/auth/login.php';
        break;

    case 'logout':
        include_once 'logout.php';
        break;
    
    default:
        include_once 'views/dashboard.php';
        break;
}