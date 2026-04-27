<?php
    require_once 'include/db.php';
    require_once 'include/alerts.php';

    // Fetch About Page Sections
    $sections = [];
    try {
        $stmt = $pdo->query("SELECT section_key, section_content FROM about_page_sections");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sections[$row['section_key']] = json_decode($row['section_content'], true);
        }
    } catch (PDOException $e) { }

    // Fetch Homepage Sections for shared components (CTA, Reviews)
    $home_sections = [];
    try {
        $stmt = $pdo->query("SELECT section_key, section_content FROM homepage_sections");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $home_sections[$row['section_key']] = json_decode($row['section_content'], true);
        }
    } catch (PDOException $e) { }

    $hero = $sections['hero'] ?? [];
    $company_info = $sections['company_info'] ?? [];
    $awards = $sections['awards'] ?? [];
    $history = $sections['history'] ?? [];
    $team_preview = $sections['team_preview'] ?? [];
    $mission_vision = $sections['mission_vision'] ?? [];
    $awards_intro = $sections['awards_intro'] ?? [];
    
    $cta = $home_sections['cta'] ?? [];
    $reviews_config = $home_sections['reviews'] ?? [];
    $review_cards = $reviews_config['review_cards'] ?? [];

    // Helper function to render a single review card
    if (!function_exists('renderReviewCard')) {
        function renderReviewCard($card) {
            ?>
            <div class="card border rounded-4 p-3 m-0">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <img class="avatar-img rounded-circle"
                                src="<?= htmlspecialchars($card['avatar'] ?? 'assets/images/avatar/default.jpg') ?>"
                                alt="avatar">
                        </div>
                        <div class="ms-3">
                            <p class="heading-color fw-semibold mb-0"><?= htmlspecialchars($card['name'] ?? 'Customer') ?>
                            </p>
                            <small><?= htmlspecialchars($card['handle'] ?? '@handle') ?></small>
                        </div>
                    </div>
                    <a href="#" class="heading-color fs-5"><i
                            class="<?= htmlspecialchars($card['social_icon'] ?? 'bi bi-twitter-x') ?>"></i></a>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= htmlspecialchars($card['content'] ?? 'Amazing experience!') ?></p>
                </div>
            </div>
            <?php
        }
    }

    // Helper to render columns (duplicating for swiper if needed)
    if (!function_exists('renderColumnContent')) {
        function renderColumnContent($cards, $col_num, $is_swiper = false) {
            $filtered = array_filter($cards, function ($c) use ($col_num) {
                return ($c['column'] ?? 1) == $col_num;
            });

            if (empty($filtered))
                return;

            // Ensure enough cards to fill height for smooth loop
            $to_render = $filtered;
            if ($is_swiper && count($filtered) < 4) {
                $to_render = array_merge($filtered, $filtered, $filtered, $filtered);
            } else if ($is_swiper && count($filtered) < 8) {
                $to_render = array_merge($filtered, $filtered);
            }

            foreach ($to_render as $card) {
                if ($is_swiper)
                    echo '<div class="swiper-slide">';
                renderReviewCard($card);
                if ($is_swiper)
                    echo '</div>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>About Weburea Agency - Creativity in Motion</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea">
    <meta name="description" content="Weburea Agency is a creative digital studio specializing in UI/UX design, motion graphics, software testing, and web applications.">

    <!-- Dark mode -->
    <?php include('include/dark_mode.php') ?>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon/Vector.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body>

    <!-- Header START DYNAMIC -->
    <?php include('include/front_header.php') ?>
    <?php if (false): ?>
    <div class="header-absolute">
        <!-- Top header -->
        <div class="alert fade show bg-primary border-0 rounded-0 text-center overflow-hidden z-index-9 py-2 m-0 d-none d-lg-block"
            role="alert">
            <div class="container d-flex justify-content-between px-2 px-xl-4">
                <!-- Contact info -->
                <ul class="list-inline d-flex flex-wrap gap-3 text-white mb-0">
                    <li class="list-inline-item fw-light"><i class="bi bi-headset me-2"></i>Call us: <a href="#"
                            class="link-white">+123 555 66 </a></li>
                    <li class="list-inline-item fw-light"><i class="bi bi-envelope me-2"></i>Email: <a href="#"
                            class="link-white">example@gmail.com</a></li>
                </ul>

                <!-- Social links -->
                <ul class="list-inline mb-0">
                    <li class="list-inline-item small text-white">Follow us on: </li>
                    <li class="list-inline-item"> <a href="#" class="link-white"><i class="bi bi-facebook"></i></a>
                    </li>
                    <li class="list-inline-item"> <a href="#" class="link-white"><i class="bi bi-instagram"></i></a>
                    </li>
                    <li class="list-inline-item"> <a href="#" class="link-white"><i class="bi bi-twitter-x"></i></a>
                    </li>
                    <li class="list-inline-item"> <a href="#" class="link-white"><i class="bi bi-linkedin"></i></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Header START -->
        <header class="header-sticky bg-transparent">
            <!-- Logo Nav START -->
            <nav class="navbar navbar-expand-xl">
                <div class="container">
                    <!-- Logo START -->
                    <a class="navbar-brand me-0" href="index.html">
                        <img class="light-mode-item navbar-brand-item" src="assets/images/logo.svg" alt="logo">
                        <img class="dark-mode-item navbar-brand-item" src="assets/images/logo-light.svg" alt="logo">
                    </a>
                    <!-- Logo END -->

                    <!-- Main navbar START -->
                    <div class="navbar-collapse collapse" id="navbarCollapse">
                        <ul class="navbar-nav navbar-nav-scroll dropdown-hover mx-auto">

                            <!-- Nav item -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-auto-close="outside"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Demos</a>
                                <div class="dropdown-menu dropdown-menu-size-lg overflow-hidden p-0">
                                    <div class="row px-3 py-4">
                                        <!-- Image and button -->
                                        <div class="col-sm-6">
                                            <ul class="list-unstyled">
                                                <li> <a class="dropdown-item" href="index.html">Classic Default</a>
                                                </li>
                                                <li> <a class="dropdown-item"
                                                        href="index-software-company.html">Software Company</a> </li>
                                                <li> <a class="dropdown-item"
                                                        href="index-finance-consulting.html">Finance Consulting</a>
                                                </li>
                                                <li> <a class="dropdown-item" href="index-ai-agency.html">AI Agency</a>
                                                </li>
                                                <li> <a class="dropdown-item" href="index-product-landing.html">Product
                                                        Landing</a> </li>
                                            </ul>
                                        </div>

                                        <!-- Image and button -->
                                        <div class="col-sm-6">
                                            <ul class="list-unstyled">
                                                <li> <a class="dropdown-item" href="index-saas.html">SaaS</a> </li>
                                                <li> <a class="dropdown-item" href="index-ai-chatbot.html">SaaS AI
                                                        Chatbot</a> </li>
                                                <li> <a class="dropdown-item"
                                                        href="index-application-showcase.html">Application Showcase</a>
                                                </li>
                                                <li> <a class="dropdown-item"
                                                        href="index-personal-portfolio.html">Personal Portfolio</a>
                                                </li>
                                                <li> <a class="dropdown-item" href="index-blog.html">Blog home</a> </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Cta -->
                                    <div class="h-200px position-relative"
                                        style="background:url(assets/images/elements/nav-cta.jpg) no-repeat; background-size:cover; background-position:center;">
                                        <!-- Bg overlay -->
                                        <div class="bg-overlay bg-dark bg-opacity-10"></div>
                                    </div>
                                </div>
                            </li>

                            <!-- Nav item -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    <!-- Dropdown submenu -->
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#">About</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li> <a class="dropdown-item" href="about-v1.html">About v.1</a> </li>
                                            <li> <a class="dropdown-item" href="about-v2.html">About v.2</a> </li>
                                            <li> <a class="dropdown-item" href="services-grid.html">Services Grid</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="services-list.html">Services List</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="service-single.html">Service Single</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="team.html">Team</a></li>
                                            <li> <a class="dropdown-item" href="career.html">Career <span
                                                        class="badge text-bg-success ms-2">2 Job</span></a></li>
                                            <li> <a class="dropdown-item" href="career-single.html">Career Single</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li> <a class="dropdown-item" href="contact-us-v1.html">Contact Us v1</a> </li>
                                    <li> <a class="dropdown-item" href="contact-us-v2.html">Contact Us v2</a> </li>
                                    <li> <a class="dropdown-item" href="pricing-v1.html">Pricing v1</a> </li>
                                    <li> <a class="dropdown-item" href="pricing-v2.html">Pricing v2</a> </li>

                                    <!-- Dropdown submenu -->
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Saas
                                            pages</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li> <a class="dropdown-item" href="feature-single.html">Feature Single</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="integrations.html">Integrations</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="integration-single.html">Integrations
                                                    Single</a> </li>
                                        </ul>
                                    </li>

                                    <!-- Dropdown submenu -->
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#">Portfolio</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li> <a class="dropdown-item" href="portfolio-grid.html">Portfolio Grid</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="portfolio-list.html">Portfolio List</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="portfolio-modern.html">Portfolio
                                                    Modern</a> </li>
                                            <li> <a class="dropdown-item" href="portfolio-case-study-v1.html">Portfolio
                                                    case study v1</a> </li>
                                            <li> <a class="dropdown-item" href="portfolio-case-study-v2.html">Portfolio
                                                    case study v2</a> </li>
                                        </ul>
                                    </li>

                                    <!-- Dropdown submenu -->
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#">Blog</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li> <a class="dropdown-item" href="blog-minimal.html">Blog Minimal</a>
                                            </li>
                                            <li> <a class="dropdown-item" href="blog-single.html">Blog Single</a> </li>
                                        </ul>
                                    </li>

                                    <li> <a class="dropdown-item" href="error-404.html">Error 404</a> </li>
                                    <li> <a class="dropdown-item" href="coming-soon.html">Coming soon</a> </li>

                                    <!-- Dropdown submenu -->
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#">Authentication</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li> <a class="dropdown-item" href="sign-in.html">Sign in</a> </li>
                                            <li> <a class="dropdown-item" href="sign-up.html">Sign up</a> </li>
                                            <li> <a class="dropdown-item" href="forgot-password.html">Forgot
                                                    Password</a> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Nav item -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-auto-close="outside"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Doc</a>
                                <div class="dropdown-menu dropdown-menu-size-xl dropdown-menu-center p-xl-3">
                                    <div class="row row-cols-1 row-cols-md-2 pt-2">
                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-primary bg-opacity-15 text-primary rounded flex-shrink-0">
                                                        <i class="bi bi-file-earmark-text fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">
                                                            Documentation</p>
                                                        <p class="mb-0 text-body small">Using documentation you can
                                                            easily develop projects</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="#" target="_blank"><i class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>

                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-pink bg-opacity-15 text-pink rounded flex-shrink-0">
                                                        <i class="bi bi-stickies fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">Snippets
                                                        </p>
                                                        <p class="mb-0 text-body small">Development guides for building
                                                            projects with Weburea</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="#" target="_blank"><i class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>

                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-success bg-opacity-15 text-success rounded flex-shrink-0">
                                                        <i class="bi bi-bullseye fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">Changelog
                                                        </p>
                                                        <p class="mb-0 text-body small">Recent feature release and
                                                            announcement.</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="#" target="_blank"><i class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>

                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-warning bg-opacity-15 text-warning rounded flex-shrink-0">
                                                        <i class="bi bi-mask fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">Playwright
                                                            tips</p>
                                                        <p class="mb-0 text-body small">Tips and In-depth guide for
                                                            headless browser automation</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="#" target="_blank"><i class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>

                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-info bg-opacity-15 text-info rounded flex-shrink-0">
                                                        <i class="bi bi-grid-fill fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">
                                                            Integrations</p>
                                                        <p class="mb-0 text-body small">Taking advantage of integrations
                                                            with other services.</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="integrations.html" target="_blank"><i
                                                        class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>

                                        <!-- Doc menu -->
                                        <div class="col">
                                            <div
                                                class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                <div class="d-flex">
                                                    <!-- Icon -->
                                                    <div
                                                        class="icon-md bg-purple bg-opacity-15 text-purple rounded flex-shrink-0">
                                                        <i class="bi bi-chat-dots fs-6"></i>
                                                    </div>
                                                    <!-- Content -->
                                                    <div class="mx-3">
                                                        <p class="stretched-link heading-color fw-bold mb-0">Supports
                                                        </p>
                                                        <p class="mb-0 text-body small">Need help? Our customers support
                                                            is there to help you.</p>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                    href="#" target="_blank"><i class="bi bi-chevron-right"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Nav item -->
                            <li class="nav-item"> <a class="nav-link" href="contact-us-v1.html">Contact us</a> </li>
                        </ul>
                    </div>
                    <!-- Main navbar END -->

                    <!-- Buttons -->
                    <ul class="nav align-items-center dropdown-hover ms-sm-2">
                        <!-- Dark mode option START -->
                        <li class="nav-item dropdown dropdown-animation">
                            <button class="btn btn-link mb-0 px-2 lh-1" id="bd-theme" type="button"
                                aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    class="bi bi-circle-half theme-icon-active fill-mode fa-fw" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                                    <use href="#"></use>
                                </svg>
                            </button>

                            <ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
                                <li class="mb-1">
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="light">
                                        <svg width="16" height="16" fill="currentColor"
                                            class="bi bi-brightness-high-fill fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                                            <use href="#"></use>
                                        </svg>Light
                                    </button>
                                </li>
                                <li class="mb-1">
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-moon-stars-fill fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                                            <path
                                                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                                            <use href="#"></use>
                                        </svg>Dark
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-circle-half fa-fw mode-switch me-1"
                                            viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                                            <use href="#"></use>
                                        </svg>Auto
                                    </button>
                                </li>
                            </ul>
                        </li>
                        <!-- Dark mode option END -->

                        <!-- Schedule button -->
                        <li class="nav-item ms-2 d-none d-sm-block">
                            <a href="#" class="btn btn-sm btn-dark mb-0" data-bs-toggle="offcanvas"
                                data-bs-target="#scheduleCall" aria-controls="scheduleCall"><i
                                    class="bi bi-calendar-week me-2"></i>Schedule a call</a>
                        </li>

                        <!-- Responsive navbar toggler -->
                        <li class="nav-item">
                            <button class="navbar-toggler ms-sm-3 p-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-animation">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </button>
                        </li>
                    </ul>

                </div>
            </nav>
            <!-- Logo Nav END -->
        </header>
        <!-- Header END -->
    </div>
    <?php endif; ?>
    <!-- Header END DYNAMIC -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <?php include('include/sections/about/hero.php'); ?>

        <?php include('include/sections/about/clients_rating.php'); ?>

        <?php include('include/sections/about/company_info.php'); ?>

        <?php include('include/sections/about/team.php'); ?>

        <?php include('include/sections/about/awards.php'); ?>

        <?php include('include/sections/about/history.php'); ?>

        <?php include('include/sections/about/reviews.php'); ?>


        <!-- =======================
CTA START -->
        <section class="pt-6 pt-sm-5">
            <div class="container">
                <div class="bg-secondary-grad position-relative rounded-3 overflow-hidden p-4 p-sm-6">

                    <!-- BG pattern -->
                    <div class="position-absolute end-0 top-0 rotate-343 mt-n5 me-7 d-none d-sm-block">
                        <img src="assets/images/elements/geo-grad-pattern.svg" class="h-500px opacity-3"
                            alt="bg pattern">
                    </div>

                    <!-- BG pattern -->
                    <div class="position-absolute start-0 top-0 rotate-343 mt-n5 ms-n8">
                        <img src="assets/images/elements/geo-grad-pattern.svg" class="h-300px opacity-1"
                            alt="bg pattern">
                    </div>

                    <div class="row g-4 align-items-center position-relative">
                        <?php
                        // Using the cta variable fetched at the top of about.php
                        // Fallbacks match the user's provided example
                        $cta_title = $cta['title'] ?? 'Ready to put your design on';
                        $cta_highlight = $cta['title_highlight'] ?? 'auto-pilot?';
                        $cta_list = $cta['list_items'] ?? ['Pause or cancel anytime', 'Flat monthly rate'];
                        $cta_btn_text = $cta['btn_text'] ?? 'View subscription plans';
                        $cta_btn_link = $cta['btn_link'] ?? 'pricing.php';
                        ?>
                        <!-- Title and list -->
                        <div class="col-xl-6">
                            <h3><?= htmlspecialchars($cta_title) ?> <span class="text-primary-grad"><?= htmlspecialchars($cta_highlight) ?></span></h3>
                            <ul class="list-inline d-flex flex-wrap gap-2 mb-0 mt-3">
                                <?php foreach ($cta_list as $item): ?>
                                    <li class="list-inline-item heading-color"> 
                                        <i class="bi bi-check-circle text-success me-1"></i><?= htmlspecialchars($item) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Button -->
                        <div class="col-xl-6 text-xl-end">
                            <a href="<?= htmlspecialchars($cta_btn_link) ?>" class="btn btn-dark mb-0"><?= htmlspecialchars($cta_btn_text) ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
CTA END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <!-- Footer START -->
    <?php include('include/front_footer.php') ?>
    <!-- Footer END -->

    <!-- Schedule call offcanvas content START -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="scheduleCall"
        aria-labelledby="scheduleCallLabel">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title" id="scheduleCallLabel">Schedule a call</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Form START -->
            <form class="row g-3">
                <div class="col-12">
                    <label class="form-label">Your name *</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Full name">
                </div>

                <div class="col-12">
                    <label class="form-label">Email address *</label>
                    <input type="email" class="form-control form-control-sm" id="floatingInput"
                        placeholder="name@example.com">
                </div>

                <div class="col-6">
                    <label class="form-label">Schedule date *</label>
                    <input type="date" class="form-control form-control-sm">
                </div>

                <div class="col-6">
                    <label class="form-label">Schedule date *</label>
                    <input type="time" class="form-control form-control-sm">
                </div>

                <div class="col-12">
                    <label class="form-label">Phone number *</label>
                    <input type="text" class="form-control form-control-sm" placeholder="(xxx) xx xxxx">
                </div>

                <div class="col-12">
                    <label class="form-label">Subject *</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Subject name">
                </div>

                <div class="col-12">
                    <label class="form-label">Message *</label>
                    <textarea class="form-control" placeholder="Write your message here...." id="floatingTextarea2"
                        style="height: 150px"></textarea>
                </div>
                <!-- Button -->
                <button class="btn btn-primary mb-0">Send a message</button>
            </form>
            <!-- Form END -->
        </div>
    </div>
    <!-- Schedule call offcanvas content END -->

    <!-- Back to top -->
    <div class="back-top"></div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!--Vendors-->
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/imagesLoaded/imagesloaded.pkgd.min.js"></script>

    <?php 
        inject_toast_system(); 
        inject_premium_alert_modal();
    ?>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>
    <!-- Swiper Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize all vertical up marquees
            document.querySelectorAll('.swiper-vertical-up').forEach(function (el) {
                new Swiper(el, {
                    direction: 'vertical',
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    loop: true,
                    speed: 5000,
                    allowTouchMove: false,
                    roundLengths: true,
                    autoplay: {
                        delay: 0,
                        disableOnInteraction: false,
                    },
                });
            });
        });
    </script>
</body>

</html>