<?php

switch ($parent) {
    case '':
        include_once 'views/home.php';
        break;

    case 'about-us':
        include_once 'views/about-us.php';
        break;
    
    case 'teaching-jobs':
        include_once 'views/teaching-jobs.php';
        break;

    case 'blogs':
        if(isset($child)){
            include_once 'views/blog-details.php';
        }
        else{
            include_once 'views/blogs.php';
        }
        break;

    case 'languages':
        if(isset($child)){
            include_once 'views/language.php';
        }
        else{
            include_once 'views/home.php';
        }
        break;

    case 'pricing':
        include_once 'views/pricing.php';
        break;

    case 'contact-us':
        include_once 'views/contact-us.php';
        break;

    case 'faqs':
        include_once 'views/faqs.php';
        break;

    case 'privacy-policy':
        include_once 'views/privacy-policy.php';
        break;
        
    default:
        include_once 'views/under-maintenance.php';
        break;
}