<?php
if (!isset($base_path)) {
    require_once 'includes/config.php';
}

if (!isset($page_title)) {
    $page_title = 'Home';
}

$current_page = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo htmlspecialchars($settings['company_name']); ?></title>
    <meta name="description"
        content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : 'Experience the best Mount Kenya hiking tours with Colleen Adventures. Professional guides, breathtaking routes including Chogoria, Sirimon, and Naro Moru.'; ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Open+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <style>
    /* CSS VARIABLES */
    :root {
        --primary-color: <?php echo $settings['primary_color'];
        ?>;
        --secondary-color: <?php echo $settings['secondary_color'];
        ?>;
        --accent-color: <?php echo $settings['accent_color'];
        ?>;
        --text-dark: #1E1E1E;
        --text-light: #666666;
        --background-light: #F9F9F9;
        --white: #FFFFFF;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s ease;
    }

    /* RESET & BASE */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
        overflow-x: hidden;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        line-height: 1.3;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* NAVBAR */
    .navbar {
        background: var(--white);
        box-shadow: var(--shadow);
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
    }

    .navbar .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 80px;
    }

    .logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
        gap: 10px;
    }

    .logo img {
        height: 50px;
        width: auto;
    }

    .logo-text {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: -0.5px;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        align-items: center;
        gap: 30px;
    }

    .nav-menu li {
        position: relative;
    }

    .nav-menu a {
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        padding: 8px 0;
    }

    .nav-menu a:hover,
    .nav-menu a.active {
        color: var(--primary-color);
    }

    .nav-menu a.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary-color);
    }

    .btn-nav {
        background: var(--primary-color);
        color: var(--white) !important;
        padding: 10px 25px !important;
        border-radius: 50px;
        transition: var(--transition) !important;
    }

    .btn-nav:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    /* DROPDOWN */
    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: var(--white);
        box-shadow: var(--shadow);
        min-width: 220px;
        border-radius: 10px;
        padding: 15px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: var(--transition);
        z-index: 100;
    }

    .dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-menu li {
        margin: 0;
        width: 100%;
    }

    .dropdown-menu a {
        display: block;
        padding: 10px 25px !important;
        font-size: 0.95rem;
    }

    .dropdown-menu a:hover {
        background: var(--background-light);
        color: var(--primary-color);
    }

    .dropdown-menu a.active::after {
        display: none;
    }

    /* HAMBURGER */
    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        gap: 6px;
    }

    .hamburger span {
        width: 30px;
        height: 3px;
        background: var(--primary-color);
        transition: var(--transition);
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(8px, 8px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    /* WHATSAPP FLOAT */
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #25D366;
        color: var(--white);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        z-index: 999;
        transition: var(--transition);
        text-decoration: none;
    }

    .whatsapp-float:hover {
        transform: scale(1.1);
        background: #128C7E;
        color: var(--white);
    }

    /* BUTTONS */
    .btn {
        display: inline-block;
        padding: 12px 35px;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .btn-primary {
        background: var(--primary-color);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 92, 62, 0.4);
    }

    .btn-secondary {
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .btn-secondary:hover {
        background: var(--white);
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
    }

    .btn-large {
        padding: 15px 45px;
        font-size: 1.1rem;
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    /* PAGE HEADER */
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $base_path; ?>/assets/images/page-header-bg.jpg');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        text-align: center;
        color: var(--white);
    }

    .page-header h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .breadcrumb {
        font-size: 1.1rem;
    }

    .breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb a:hover {
        color: var(--white);
    }

    /* SECTION TITLES */
    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: var(--text-dark);
        position: relative;
        padding-bottom: 20px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--primary-color);
    }

    .section-subtitle {
        text-align: center;
        font-size: 1.2rem;
        color: var(--text-light);
        margin-bottom: 50px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* HERO SECTION */
    .hero {
        height: 90vh;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo $base_path; ?>/assets/images/hero-bg.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        text-align: center;
        color: var(--white);
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .hero h1 {
        font-size: 4rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .hero h1 span {
        color: var(--primary-color);
        display: block;
        font-size: 2.5rem;
        text-transform: none;
        letter-spacing: normal;
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    /* FEATURES SECTION */
    .features {
        padding: 100px 0;
        background: var(--background-light);
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: var(--white);
        padding: 40px 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .feature-card i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .feature-card h3 {
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .feature-card p {
        color: var(--text-light);
        line-height: 1.6;
    }

    /* TOURS SECTION */
    .popular-tours {
        padding: 100px 0;
    }

    .tour-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .tour-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .tour-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .tour-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .tour-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .tour-card:hover .tour-image img {
        transform: scale(1.1);
    }

    .badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 8px 20px;
        border-radius: 30px;
        color: var(--white);
        font-size: 0.9rem;
        font-weight: 600;
        z-index: 1;
    }

    .badge.best-seller {
        background: #FFD700;
        color: var(--text-dark);
    }

    .badge.beginner {
        background: var(--secondary-color);
    }

    .tour-content {
        padding: 25px;
    }

    .tour-content h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    .difficulty {
        color: var(--text-light);
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .highlights {
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .tour-price {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .price-usd {
        background: var(--primary-color);
        color: var(--white);
        padding: 5px 15px;
        border-radius: 30px;
        font-weight: 600;
    }

    .price-ksh {
        background: var(--secondary-color);
        color: var(--white);
        padding: 5px 15px;
        border-radius: 30px;
        font-weight: 600;
    }

    .group-discount {
        color: var(--secondary-color);
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    /* DAY TRIPS */
    .day-trips {
        padding: 100px 0;
        background: var(--background-light);
    }

    .day-trip-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .day-trip-card {
        background: var(--white);
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .day-trip-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .trip-image-container {
        padding: 30px 30px 0 30px;
    }

    .trip-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .trip-icon {
        margin-top: 20px;
    }

    .trip-icon i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .day-trip-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: var(--text-dark);
        padding: 0 20px;
        font-weight: 700;
    }

    .day-trip-card p {
        color: var(--text-light);
        margin-bottom: 15px;
        line-height: 1.6;
        padding: 0 25px;
        font-size: 0.95rem;
    }

    .trip-duration {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
        padding: 0 20px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .trip-duration i {
        font-size: 1rem;
        color: var(--primary-color);
    }

    .day-trip-card .btn {
        margin: 0 30px 30px 30px;
        display: inline-block;
    }

    /* Location text styling */
    .trip-location {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 10px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .trip-location i {
        color: var(--primary-color);
        font-size: 0.8rem;
    }

    /* Features tags */
    .trip-features {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        padding: 0 20px;
        margin-bottom: 15px;
    }

    .feature-tag {
        background: var(--background-light);
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.85rem;
        color: var(--text-dark);
        border: 1px solid rgba(139, 69, 19, 0.2);
    }

    .feature-tag i {
        color: var(--primary-color);
        margin-right: 5px;
        font-size: 0.8rem;
    }

    /* ABOUT PREVIEW */
    .about-preview {
        padding: 100px 0;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-content h2 {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .about-content h3 {
        font-size: 1.8rem;
        margin-bottom: 25px;
        color: var(--text-dark);
    }

    .about-content p {
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.8;
    }

    .stats {
        display: flex;
        gap: 40px;
        margin: 40px 0;
    }

    .stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.95rem;
        color: var(--text-light);
    }

    .about-image img {
        width: 100%;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    /* TESTIMONIALS */
    .testimonials {
        padding: 100px 0;
        background: var(--background-light);
    }

    .testimonial-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minfill(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .testimonial-card {
        background: var(--white);
        padding: 30px;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .testimonial-rating {
        margin-bottom: 20px;
    }

    .testimonial-rating i {
        color: #FFD700;
        margin-right: 3px;
    }

    .testimonial-rating i.active {
        color: #FFD700;
    }

    .testimonial-text {
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.8;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .testimonial-author strong {
        display: block;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .testimonial-author span {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .tour-route {
        display: inline-block;
        margin-top: 5px;
        padding: 3px 10px;
        background: var(--background-light);
        border-radius: 20px;
        font-size: 0.85rem;
    }

    /* WHY CHOOSE US */
    .why-choose {
        padding: 100px 0;
    }

    .why-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .why-card {
        text-align: center;
        padding: 40px 30px;
        background: var(--white);
        border-radius: 15px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .why-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .why-card i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .why-card h3 {
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .why-card p {
        color: var(--text-light);
        line-height: 1.6;
    }

    /* CTA SECTION */
    .cta {
        padding: 100px 0;
        background: linear-gradient(rgba(139, 69, 19, 0.9), rgba(46, 92, 62, 0.9)), url('<?php echo $base_path; ?>/assets/images/cta-bg.jpg');
        background-size: cover;
        background-attachment: fixed;
        text-align: center;
        color: var(--white);
    }

    .cta h2 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .cta p {
        font-size: 1.3rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    .cta .btn {
        margin: 0 10px;
    }

    /* FOOTER */
    .footer {
        background: #1A1A1A;
        color: var(--white);
        padding: 80px 0 30px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 50px;
    }

    .footer-section h3 {
        color: var(--primary-color);
        margin-bottom: 25px;
        font-size: 1.3rem;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-section h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--primary-color);
    }

    .footer-section p {
        color: #B0B0B0;
        margin-bottom: 15px;
        line-height: 1.8;
    }

    .footer-section a {
        color: #B0B0B0;
        text-decoration: none;
        transition: var(--transition);
    }

    .footer-section a:hover {
        color: var(--primary-color);
        padding-left: 5px;
    }

    .footer-section ul {
        list-style: none;
    }

    .footer-section ul li {
        margin-bottom: 12px;
    }

    .footer-section i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.2rem;
        transition: var(--transition);
    }

    .social-links a:hover {
        background: var(--primary-color);
        transform: translateY(-3px);
        padding-left: 0;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #B0B0B0;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .hero h1 {
            font-size: 3rem;
        }

        .hero h1 span {
            font-size: 2rem;
        }

        .about-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .hamburger {
            display: flex;
        }

        .nav-menu {
            position: fixed;
            top: 80px;
            left: -100%;
            width: 100%;
            height: calc(100vh - 80px);
            background: var(--white);
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 40px;
            transition: 0.3s;
            gap: 0;
        }

        .nav-menu.active {
            left: 0;
        }

        .nav-menu li {
            margin: 0;
            width: 100%;
            text-align: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .dropdown-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero-buttons {
            flex-direction: column;
            gap: 15px;
        }

        .section-title {
            font-size: 2rem;
        }

        .stats {
            flex-direction: column;
            gap: 20px;
        }

        .cta h2 {
            font-size: 2rem;
        }

        .whatsapp-float {
            width: 50px;
            height: 50px;
            font-size: 25px;
            bottom: 20px;
            right: 20px;
        }
    }

    /* ABOUT PAGE SPECIFIC STYLES */

    /* Our Story Section */
    .our-story {
        padding: 80px 0;
    }

    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .story-content h2 {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .story-content p {
        margin-bottom: 20px;
        line-height: 1.8;
        color: var(--text-light);
    }

    .story-image {
        text-align: center;
    }

    .story-image img {
        width: 90%;
        max-width: 450px;
        height: auto;
        border-radius: 15px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .story-image img:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-hover);
    }

    /* Mission & Vision */
    .mission-vision {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 30px;
    }

    .mission,
    .vision {
        background: var(--background-light);
        padding: 25px;
        border-radius: 10px;
        transition: var(--transition);
    }

    .mission:hover,
    .vision:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .mission h3,
    .vision h3 {
        color: var(--primary-color);
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .mission h3 i,
    .vision h3 i {
        margin-right: 10px;
        color: var(--secondary-color);
    }

    /* Meet Guide Section */
    .meet-guide-detailed {
        padding: 80px 0;
        background: var(--background-light);
    }

    .guide-profile-detailed {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 40px;
        background: var(--white);
        padding: 40px;
        border-radius: 15px;
        box-shadow: var(--shadow);
        max-width: 1000px;
        margin: 0 auto;
    }

    .guide-image {
        text-align: center;
    }

    .guide-image img {
        width: 100%;
        max-width: 250px;
        height: auto;
        border-radius: 50%;
        border: 5px solid var(--primary-color);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .guide-image img:hover {
        transform: scale(1.05);
        border-color: var(--secondary-color);
    }

    .guide-info h3 {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .guide-role {
        color: var(--secondary-color);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--background-light);
    }

    .guide-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: var(--background-light);
        border-radius: 10px;
    }

    .guide-details p {
        margin: 0;
        font-size: 0.95rem;
    }

    .guide-details strong {
        color: var(--primary-color);
        display: block;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .guide-bio {
        margin-bottom: 20px;
        line-height: 1.8;
        color: var(--text-light);
        padding: 0 5px;
    }

    .guide-social {
        display: flex;
        gap: 15px;
    }

    .guide-social a {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .guide-social a:hover {
        background: var(--secondary-color);
        transform: translateY(-3px);
    }

    /* Team Section */
    .our-team {
        padding: 80px 0;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .team-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-align: center;
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .team-image {
        height: 200px;
        overflow: hidden;
    }

    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .team-card:hover .team-image img {
        transform: scale(1.1);
    }

    .team-info {
        padding: 20px;
    }

    .team-info h3 {
        color: var(--primary-color);
        margin-bottom: 5px;
        font-size: 1.2rem;
    }

    .team-role {
        color: var(--secondary-color);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .team-experience,
    .team-languages {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    /* Certifications Section */
    .certifications {
        padding: 80px 0;
        background: var(--background-light);
    }

    .cert-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }

    .cert-card {
        background: var(--white);
        padding: 30px 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .cert-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .cert-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .cert-card h3 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    .cert-card p {
        color: var(--text-light);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Values Section */
    .values {
        padding: 80px 0;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .value-card {
        text-align: center;
        padding: 35px 25px;
        background: var(--white);
        border-radius: 15px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .value-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.8rem;
        transition: var(--transition);
    }

    .value-card:hover .value-icon {
        background: var(--secondary-color);
        transform: rotate(360deg);
    }

    .value-card h3 {
        margin-bottom: 15px;
        color: var(--text-dark);
        font-size: 1.3rem;
    }

    .value-card p {
        color: var(--text-light);
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .story-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .story-image {
            order: -1;
        }

        .guide-profile-detailed {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .guide-image img {
            max-width: 220px;
        }
    }

    @media (max-width: 768px) {
        .mission-vision {
            grid-template-columns: 1fr;
        }

        .guide-details {
            grid-template-columns: 1fr;
        }

        .guide-social {
            justify-content: center;
        }

        .story-content h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .guide-profile-detailed {
            padding: 20px;
        }

        .guide-info h3 {
            font-size: 1.5rem;
        }

        .cert-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <main></main>