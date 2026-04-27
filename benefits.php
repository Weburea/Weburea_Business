<?php
require_once('include/db.php');

// Fetch all benefit sections
$stmt = $pdo->query("SELECT section_key, section_content FROM benefits_sections WHERE status = 'active'");
$raw_sections = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Decode sections with fallbacks
$ben_hero = json_decode($raw_sections['ben_hero'] ?? '{}', true);
$ben_stats = json_decode($raw_sections['ben_stats'] ?? '{}', true);
$ben_solutions = json_decode($raw_sections['ben_solutions'] ?? '{}', true);
$ben_tabs = json_decode($raw_sections['ben_tabs'] ?? '{}', true);
$ben_testimonials = json_decode($raw_sections['ben_testimonials'] ?? '{}', true);

// Fetch services and their pricing plans for the dynamic pricing section
$servicesStmt = $pdo->query("SELECT id, name, slug, icon_3d FROM services WHERE status = 'active' ORDER BY id ASC");
$services = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);

$allPricingData = [];
foreach ($services as $service) {
    $plansStmt = $pdo->prepare("SELECT * FROM pricing_plans WHERE service_id = ? AND status = 'active' ORDER BY id ASC");
    $plansStmt->execute([$service['id']]);
    $plans = $plansStmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($plans as &$plan) {
        $plan['features_json'] = json_decode($plan['features_json'] ?? '[]', true);
    }
    
    $allPricingData[$service['id']] = [
        'service' => $service,
        'plans' => $plans
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Primary SEO -->
    <title>Weburea Agency — Benefits</title>

    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta Description -->
    <meta name="description"
        content="Weburea Agency is a creative digital studio offering UI/UX design, branding, motion graphics, software testing (QA), and web development in Lagos. Creativity in Motion.">

    <!-- Keywords -->
    <meta name="keywords"
        content="UI UX Design Lagos, Weburea Agency, Motion Graphics Lagos, Software Testing Nigeria, QA Testing Lagos, Web Development Lagos, Branding Agency Lagos, Creative Agency Nigeria, Digital Agency Africa">

    <!-- Author -->
    <meta name="author" content="Weburea Agency">

    <!-- Dark mode -->
    <?php include('include/dark_mode.php'); ?>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <style>
        .disabled-tab {
            filter: grayscale(1) opacity(0.5);
            pointer-events: none;
            cursor: not-allowed;
        }
        .nav-link.active .nav-bg-primary-grad {
            opacity: 1 !important;
        }
        @media (max-width: 576px) {
            .coming-soon-badge-green {
                font-size: 0.55rem !important;
                padding: 2px 4px !important;
                margin-left: -2.5rem !important;
            }
        }

        /* Premium Dropdown Styles */
        .premium-dropdown {
            position: relative;
            width: 440px; /* Longer as requested */
            z-index: 1000;
        }
        .premium-dropdown-trigger {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 10px 16px; /* Balanced padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            min-height: 50px; /* Reduced height as requested */
        }
        .premium-dropdown-trigger:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #F48C06;
        }
        #selectedService {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #selectedServiceIcon {
            width: 32px; /* Smaller icon in trigger */
            height: 32px;
            object-fit: contain;
        }
        .premium-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            background: #111322;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            overflow: hidden;
            z-index: 1001;
        }
        .premium-dropdown.active .premium-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .premium-dropdown-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: rgba(255,255,255,0.7);
        }
        .premium-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }
        .premium-dropdown-item.active {
            background: rgba(244, 140, 6, 0.1);
            color: #F48C06;
        }
        .premium-dropdown-item img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
        
        /* Pricing Cards Visibility */
        .nav-link.p-4.rounded-4 {
            border: 1px solid rgba(255, 255, 255, 0.15) !important; /* Visible border in dark */
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
        }
        .nav-link.p-4.rounded-4.active {
            background: rgba(244, 140, 6, 0.05) !important;
            border: 1px solid #F48C06 !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        [data-bs-theme='light'] .nav-link.p-4.rounded-4 {
            border: 1px solid rgba(0, 0, 0, 0.12) !important; /* Visible border in light */
            background: #fff;
            color: #1e293b;
        }
        [data-bs-theme='light'] .nav-link.p-4.rounded-4 .heading-color {
            color: #1e293b !important;
        }
        [data-bs-theme='light'] .premium-dropdown-trigger {
            background: #fff;
            border-color: rgba(0, 0, 0, 0.15);
            color: #1e293b;
        }
        [data-bs-theme='light'] .premium-dropdown-menu {
            background: #fff;
            border-color: rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme='light'] .premium-dropdown-item {
            color: #475569;
        }
        [data-bs-theme='light'] .premium-dropdown-item:hover {
            background: #f1f5f9;
            color: #F48C06;
        }

        .plan-price-wrapper {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        .plan-price-currency {
            font-size: 1.2rem;
            font-weight: 700;
            color: #F48C06;
        }

        /* Features Card Theme Handling */
        .features-card {
            background: #111322 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        [data-bs-theme='light'] .features-card {
            background: #f8fafc !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        [data-bs-theme='light'] .features-card h5 {
            color: #1e293b !important;
        }
        [data-bs-theme='light'] .features-card .link-white {
            color: #1e293b !important;
        }

        /* Light Mode Pricing Toggle Fix */
        [data-bs-theme='light'] .price-wrap .text-white-50 {
            color: rgba(30, 41, 59, 0.6) !important;
        }
        [data-bs-theme='light'] .price-wrap .text-white {
            color: #1e293b !important;
        }
        [data-bs-theme='light'] .price-toggle {
            background-color: rgba(0, 0, 0, 0.1);
            border-color: rgba(0, 0, 0, 0.2);
        }
        [data-bs-theme='light'] .price-toggle:checked {
            background-color: #F48C06;
            border-color: #F48C06;
        }
        [data-bs-theme='light'] .nav-link.p-4.rounded-4.active {
            box-shadow: 0 8px 20px rgba(0,0,0,0.06) !important; /* Reduced shadow as requested */
            background: #fff !important;
        }
    </style>
</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <section class="position-relative overflow-hidden pt-lg-7 pb-0">
            <div class="bg-secondary-grad position-relative py-6 py-lg-8 mb-5 mt-sm-2">
                <!-- Bg pattern -->
                <div class="position-absolute top-0 start-0">
                    <img src="assets/images/elements/bg-pattern.svg" style="opacity: 0.05;" alt="bg pattern">
                </div>

                <!-- Main content -->
                <div class="container position-relative">
                    <!-- Avatar decoration START -->
                    <!-- Avatar item -->
                    <div
                        class="avatar avatar-xl flex-shrink-0 position-absolute top-0 start-0 mt-6 ms-n3 d-none d-lg-block">
                        <img class="avatar-img rounded-circle position-relative"
                            src="<?= $ben_hero['avatars'][0] ?? 'assets/images/avatar/10.jpg' ?>" alt="avatar">
                    </div>
                    <!-- Avatar item -->
                    <div
                        class="avatar flex-shrink-0 position-absolute top-0 start-50 translate-middle-x ms-n9 mt-n6 d-none d-lg-block">
                        <img class="avatar-img rounded-circle position-relative"
                            src="<?= $ben_hero['avatars'][1] ?? 'assets/images/avatar/02.jpg' ?>" alt="avatar">
                    </div>
                    <!-- Avatar item -->
                    <div
                        class="avatar avatar-lg flex-shrink-0 position-absolute top-0 end-0 me-7 mt-n4 d-none d-lg-block">
                        <img class="avatar-img rounded-circle position-relative"
                            src="<?= $ben_hero['avatars'][2] ?? 'assets/images/avatar/06.jpg' ?>" alt="avatar">
                    </div>
                    <!-- Avatar item -->
                    <div
                        class="avatar avatar-xxl flex-shrink-0 position-absolute bottom-50 end-0 mb-n9 me-n3 d-none d-lg-block">
                        <img class="avatar-img rounded-circle position-relative"
                            src="<?= $ben_hero['avatars'][3] ?? 'assets/images/avatar/09.jpg' ?>" alt="avatar">
                    </div>
                    <!-- Avatar item -->
                    <div class="avatar flex-shrink-0 position-absolute bottom-0 start-0 ms-8 mb-n3 d-none d-lg-block">
                        <img class="avatar-img rounded-circle position-relative"
                            src="<?= $ben_hero['avatars'][4] ?? 'assets/images/avatar/01.jpg' ?>" alt="avatar">
                    </div>
                    <!-- Avatar decoration END -->

                    <!-- Main title and search START -->
                    <div class="inner-container text-center position-relative z-index-2 mx-auto">
                        <!-- Title -->
                        <h1 class="fw-semibold mb-4 lh-base">
                            <?= $ben_hero['title'] ?? 'Grow Your Career & Enjoy the <span class="text-primary">Benefits</span>' ?>
                        </h1>

                        <!-- Desc -->
                        <p class="mb-5">
                            <?= $ben_hero['description'] ?? 'Join a team where creativity meets innovation. Explore our competitive employee benefits, exciting career opportunities, and comfortable work culture at Weburea.' ?>
                        </p>

                    </div>
                    <!-- Main title and search END -->
                </div>

            </div>

            <!-- Blur bg -->
            <div class="bg-body h-200px blur-6 position-absolute bottom-0 start-50 translate-middle-x mb-n8"
                style="width: 3000px"></div>
        </section>
        <!-- =======================
Hero END -->


        <!-- =======================
Benefits sets START -->
        <section class="pt-0 border-0">
            <div class="container">
                <div class="border-top border-bottom border-primary mx-xl-6 py-4 py-xl-6 px-xl-4"
                    style="--bs-border-opacity: .20;">
                    <div class="row g-4">
                        <?php foreach (($ben_stats['stats'] ?? []) as $index => $stat): ?>
                            <div class="col-sm-4">
                                <div class="d-flex justify-content-between">
                                    <div class="d-md-flex align-items-center">
                                        <h4 class="h2 mb-0"><?= $stat['value'] ?><span
                                                class="ms-1 text-primary"><?= $stat['suffix'] ?></span></h4>
                                        <div class="ms-md-3">
                                            <?php if (!empty($stat['show_stars'])): ?>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0"><i
                                                            class="bi bi-star-fill text-warning"></i></li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="bi bi-star-fill text-warning"></i></li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="bi bi-star-fill text-warning"></i></li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="bi bi-star-fill text-warning"></i></li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="bi bi-star-fill text-warning"></i></li>
                                                </ul>
                                            <?php endif; ?>
                                            <p class="mb-0"><?= $stat['label'] ?></p>
                                        </div>
                                    </div>
                                    <?php if ($index < 2): ?>
                                        <div class="vr bg-primary mx-2 opacity-2 d-none d-sm-block"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Benefits sets END -->


        <!-- =======================
Our Solutions START -->
        <section class="pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h2 class="mb-3 mb-lg-4">
                            <?= $ben_solutions['title'] ?? 'Stop juggling freelancers. Build with <span class="text-primary">One Body.</span>' ?>
                        </h2>
                        <p class="mb-4">
                            <?= $ben_solutions['description'] ?? 'Many businesses have good ideas but no clear digital structure. They design with one person, build with another, and advertise with a third. The result? Confusion and wasted money.' ?>
                        </p>

                        <a href="<?= $ben_solutions['btn_link'] ?? 'about.php' ?>"
                            class="btn btn-primary mb-0"><?= $ben_solutions['btn_text'] ?? 'See how we work' ?></a>

                        <hr class="my-4 my-lg-5 border-primary opacity-2">
                        <div class="row g-4">
                            <?php foreach (($ben_solutions['features'] ?? []) as $feat): ?>
                                <div class="col-md-6">
                                    <div class="card card-body bg-transparent p-0">
                                        <img src="<?= $feat['icon'] ?>" class="w-40px mb-4" alt="feature icon">
                                        <h6><?= $feat['title'] ?></h6>
                                        <p><?= $feat['content'] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="bg-body shadow-primary rounded d-inline-block py-3 px-md-4 mt-4">
                            <p class="heading-color mb-0 px-3 px-sm-5 px-md-0"><i
                                    class="bi bi-whatsapp text-success me-2"></i><?= $ben_solutions['whatsapp_text'] ?? 'Start your project today' ?>
                                <a href="<?= $ben_solutions['whatsapp_link'] ?? 'https://wa.me/2348053964571' ?>"
                                    target="_blank"
                                    class="fw-semibold icon-link icon-link-hover hover-underline-animation">Let’s chat
                                    <i class="bi bi-arrow-right"></i></a>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-5 position-relative ms-auto">
                        <div class="bg-secondary rounded-4 position-relative p-5">
                            <img src="<?= $ben_solutions['media_decor'] ?? 'assets/images/elements/saas-decoration/05.png' ?>"
                                alt="Saas image">
                            <img src="<?= $ben_solutions['media_main'] ?? 'assets/images/about/19.png' ?>"
                                class="rounded-4" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Our Solutions END -->


        <section class="bg-secondary position-relative overflow-hidden">
            <!-- Decoration START -->
            <!-- skewed divider	 -->
            <span class="position-absolute top-0 start-0">
                <svg class="fill-body" width="1920" height="128" viewBox="0 0 1920 128" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1920 0H0V55.5C706.347 186.7 1574.31 110.167 1920 55.5V0Z"></path>
                </svg>
            </span>
            <!-- Rocket image -->
            <div class="position-absolute end-0 mt-8 me-6 d-none d-lg-block">
                <img src="assets/images/elements/rocket-03.png" class="h-200px" alt="rocket image">
            </div>
            <!-- hand finger image -->
            <div class="position-absolute start-0 bottom-0">
                <img src="assets/images/elements/hand-finger.png" alt="hand image">
            </div>
            <!-- Decoration END -->

            <div class="container pt-8 mt-5">
                <!-- Title -->
                <div class="inner-container-small text-center mb-4 mb-lg-5">
                    <h2 class="mb-0"><?= $ben_tabs['title'] ?? 'Discover the power of our platform' ?></h2>
                </div>

                <!-- Tabs item START -->
                <div class="inner-container mx-auto mb-5">
                    <div class="nav nav-pills nav-pills-primary-grad nav-responsive gap-4 mx-auto mb-3 pt-3"
                        id="pills-tab" role="tablist">
                        <?php 
                        $tabs_list = $ben_tabs['tabs'] ?? [];
                        $has_active = false;
                        foreach($tabs_list as $t) if(!empty($t['is_active'])) $has_active = true;
                        
                        foreach ($tabs_list as $idx => $tab): 
                            $is_first = ($idx === 0);
                            $is_active = !empty($tab['is_active']) || (!$has_active && $is_first);
                        ?>
                            <!-- Tab item -->
                            <div class="col">
                                <div class="nav-item position-relative" role="presentation">
                                    <?php if (!empty($tab['coming_soon'])): ?>
                                        <span class="badge text-bg-success position-absolute top-0 start-100 translate-middle mt-n1 ms-n6 rotate-13 z-index-9 small coming-soon-badge-green">Coming soon</span>
                                    <?php endif; ?>
                                    
                                    <a href="<?= !empty($tab['is_disabled']) ? '#!' : 'javascript:void(0);' ?>" 
                                       class="nav-link rounded-4 d-flex flex-column align-items-center justify-content-center p-3 <?= $is_active ? 'active' : '' ?> <?= !empty($tab['is_disabled']) ? 'disabled-tab' : '' ?>" 
                                       id="<?= $tab['id'] ?>-tab" 
                                       <?php if (empty($tab['is_disabled'])): ?>
                                       data-bs-toggle="pill" 
                                       data-bs-target="#<?= $tab['id'] ?>" 
                                       <?php endif; ?>
                                       role="tab" 
                                       aria-controls="<?= $tab['id'] ?>" 
                                       aria-selected="<?= $is_active ? 'true' : 'false' ?>" 
                                       style="min-width: 9rem; min-height: 120px; position: relative;" 
                                       <?= !empty($tab['is_disabled']) ? 'tabindex="-1"' : '' ?>>
                                        <span class="nav-bg-primary-grad"></span>
                                        
                                        <!-- Icon -->
                                        <?php if (!empty($tab['icon_image'])): ?>
                                            <img src="<?= $tab['icon_image'] ?>" class="nav-link-content" style="width: 36px; height: 35px; object-fit: contain;" alt="<?= $tab['label'] ?>">
                                        <?php elseif (!empty($tab['icon_svg'])): ?>
                                            <svg class="nav-link-content" width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <?= $tab['icon_svg'] ?>
                                            </svg>
                                        <?php endif; ?>
                                        
                                        <!-- Text -->
                                        <span class="nav-link-content mt-2 fw-semibold"><?= $tab['label'] ?></span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Tabs item END -->

                <!-- Tab content START -->
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <div class="tab-content" id="pills-tabContent">
                            <?php foreach (($ben_tabs['tabs'] ?? []) as $idx => $tab): 
                                $is_first_content = ($idx === 0);
                                $is_active_content = !empty($tab['is_active']) || (!$has_active && $is_first_content);
                                ?>
                                <!-- Tab content item -->
                                <div class="tab-pane card rounded-4 fade <?= $is_active_content ? 'show active' : '' ?> p-4" 
                                     id="<?= $tab['id'] ?>" role="tabpanel" aria-labelledby="<?= $tab['id'] ?>-tab" tabindex="0">
                                        <div class="row align-items-center g-4">
                                            <?php if ($tab['id'] === 'pills-analytics'): // Example positioning check ?>
                                                <!-- Content Left Layout -->
                                                <div class="col-md-5 ps-md-4">
                                                    <h6 class="mb-3"><?= $tab['card']['title'] ?></h6>
                                                    <!-- List -->
                                                    <ul class="list-group list-group-borderless mb-4">
                                                        <?php foreach (($tab['card']['list'] ?? []) as $item): ?>
                                                            <li class="list-group-item d-flex pb-0"><i class="bi bi-check-circle text-primary me-2"></i><?= $item ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <?php if (!empty($tab['card']['btn_text'])): ?>
                                                        <a href="<?= $tab['card']['btn_link'] ?? '#' ?>" class="btn btn-primary mb-0"><?= $tab['card']['btn_text'] ?></a>
                                                    <?php endif; ?>

                                                    <?php if (!empty($tab['card']['metric_val'])): ?>
                                                        <div class="d-flex align-items-center mt-4">
                                                            <h4 class="h2 mb-0"><?= $tab['card']['metric_val'] ?><span class="ms-1 text-primary">%</span></h4>
                                                            <p class="mb-0 ms-3"><?= $tab['card']['metric_label'] ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- Image Right -->
                                                <div class="col-md-6 ms-auto">
                                                    <div class="bg-secondary-grad p-3 rounded-4">
                                                        <img src="<?= $tab['card']['image'] ?>" alt="tab image">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <!-- Image Left Layout (Default) -->
                                                <div class="col-md-6">
                                                    <div class="bg-secondary-grad p-3 rounded-4">
                                                        <img src="<?= $tab['card']['image'] ?>" alt="tab image">
                                                    </div>
                                                </div>
                                                <!-- Content Right -->
                                                <div class="col-md-5 pe-4 ms-auto">
                                                    <h6 class="mb-3"><?= $tab['card']['title'] ?></h6>
                                                    <!-- List -->
                                                    <ul class="list-group list-group-borderless mb-4">
                                                        <?php foreach (($tab['card']['list'] ?? []) as $item): ?>
                                                            <li class="list-group-item d-flex pb-0"><i class="bi bi-check-circle text-primary me-2"></i><?= $item ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <?php if (!empty($tab['card']['metric_val'])): ?>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="h2 mb-0"><?= $tab['card']['metric_val'] ?><span class="ms-1 text-primary">%</span></h4>
                                                            <p class="mb-0 ms-3"><?= $tab['card']['metric_label'] ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Tab content END -->
            </div>
        </section>
        <br><br>


        <!-- Pricing  -->
        <section class="price-wrap overflow-hidden pt-0 mx-5" id="dynamic-pricing-section">
            <div class="container">
                <div class="row">
                    <!-- Contents and tabs -->
                    <div class="col-xl-8 position-relative">

                        <!-- hand decoration -->
                        <div class="position-absolute end-0 top-0 me-xl-n4 z-index-2 d-none d-sm-block">
                            <img src="assets/images/elements/money-hand.png" alt="decoration" style="max-height: 200px;">
                        </div>

                        <!-- Title and content -->
                        <div class="inner-container-small ms-0 mb-4 mb-lg-6">
                            <h2 class="mb-sm-4">Affordable solutions for every budget</h2>
                            <p>Need guidance? <a href="#" class="link-purple hover-underline-animation fw-bold">Reserve a
                                    20-minute call</a></p>
                        </div>

                        <!-- Service Selector Dropdown -->
                        <div class="mb-4">
                            <label class="small text-uppercase fw-bold text-muted mb-2" style="letter-spacing: 1px;">Select Service</label>
                            <div class="premium-dropdown" id="serviceDropdown">
                                <div class="premium-dropdown-trigger">
                                    <span id="selectedService">
                                        <img src="" id="selectedServiceIcon" class="me-2" style="display:none;">
                                        <span id="selectedServiceName">Choose a service</span>
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                <div class="premium-dropdown-menu">
                                    <?php foreach ($services as $service): ?>
                                    <div class="premium-dropdown-item" data-id="<?= $service['id'] ?>" data-name="<?= htmlspecialchars($service['name']) ?>" data-slug="<?= $service['slug'] ?>" data-icon="<?= htmlspecialchars($service['icon_3d']) ?>">
                                        <img src="<?= htmlspecialchars($service['icon_3d']) ?>" alt="<?= htmlspecialchars($service['name']) ?>">
                                        <?= htmlspecialchars($service['name']) ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Price change switch -->
                        <form class="d-flex align-items-center mb-4">
                            <!-- Label -->
                            <span class="fw-semibold text-white-50">Monthly</span>
                            <!-- Switch -->
                            <div class="form-check form-switch form-check-lg mx-3 mb-0">
                                <input class="form-check-input mt-0 price-toggle" type="checkbox" id="annualToggle">
                            </div>
                            <!-- Label -->
                            <div class="position-relative d-flex align-items-center">
                                <span class="fw-semibold text-white me-2">Yearly</span>
                                <span class="badge bg-success-soft text-success rounded-pill px-2 py-1 small" style="font-size: 0.7rem;">20% SAVE</span>
                            </div>
                        </form>

                        <!-- Tabs START -->
                        <ul class="nav nav-pills-secondary nav-responsive gap-3 gap-xxl-4" id="pricingTabs" role="tablist">
                            <!-- Populated via JS -->
                        </ul>
                        <!-- Tabs END -->
                    </div>

                    <!-- Tabs Content START -->
                    <div class="col-xl-4 mt-5 mt-xl-0">
                        <div class="tab-content" id="pricingTabContent">
                            <!-- Populated via JS -->
                        </div>
                    </div>
                    <!-- Tab content END -->
                </div> <!-- Row END -->
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pricingData = <?php echo json_encode($allPricingData); ?>;
                const dropdown = document.getElementById('serviceDropdown');
                const trigger = dropdown.querySelector('.premium-dropdown-trigger');
                const items = dropdown.querySelectorAll('.premium-dropdown-item');
                const tabsList = document.getElementById('pricingTabs');
                const tabsContent = document.getElementById('pricingTabContent');
                const annualToggle = document.getElementById('annualToggle');
                
                let currentServiceId = null;

                // Dropdown Toggle
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });

                document.addEventListener('click', () => dropdown.classList.remove('active'));

                // Service Selection
                items.forEach(item => {
                    item.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const name = this.dataset.name;
                        const icon = this.dataset.icon;
                        
                        // Update UI
                        document.getElementById('selectedServiceName').innerText = name;
                        const iconImg = document.getElementById('selectedServiceIcon');
                        if (icon) {
                            iconImg.src = icon;
                            iconImg.style.display = 'inline-block';
                        } else {
                            iconImg.style.display = 'none';
                        }
                        
                        items.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                        
                        currentServiceId = id;
                        renderPlans(id);
                        dropdown.classList.remove('active');
                    });
                });

                // Render Plans
                function renderPlans(serviceId) {
                    const data = pricingData[serviceId];
                    if (!data) return;

                    const plans = data.plans;
                    const service = data.service;
                    const isAnnual = annualToggle.checked;

                    tabsList.innerHTML = '';
                    tabsContent.innerHTML = '';

                    plans.forEach((plan, index) => {
                        const isActive = index === 0;
                        const planId = `plan-${plan.id}`;
                        const price = isAnnual ? plan.annual_price : plan.price;
                        const priceDisplay = (price && price !== '0') ? price : 'Custom';
                        
                        // Icon mapping or default
                        let icon = 'assets/images/elements/rocket.png';
                        if (plan.name.toLowerCase().includes('starter')) icon = 'assets/images/elements/rocket.png';
                        else if (plan.name.toLowerCase().includes('professional')) icon = 'assets/images/elements/thunder.png';
                        else if (plan.name.toLowerCase().includes('enterprise')) icon = 'assets/images/elements/fire.png';

                        // Add Tab
                        const li = document.createElement('li');
                        li.className = 'nav-item col';
                        li.role = 'presentation';
                        li.style.minWidth = '14rem';
                        li.innerHTML = `
                            <a href="#!" class="nav-link p-4 rounded-4 ${isActive ? 'active' : ''}" 
                               id="${planId}-tab" data-bs-toggle="tab" data-bs-target="#${planId}-pane" 
                               role="tab" aria-controls="${planId}-pane" aria-selected="${isActive}">
                                <div class="icon-lg bg-body shadow-primary rounded-circle mb-3">
                                    <img src="${icon}" class="h-40px" alt="${plan.name}">
                                </div>
                                <p class="heading-color fw-semibold mb-3">${plan.name}</p>
                                <div class="plan-price-wrapper">
                                    <span class="plan-price-currency">${priceDisplay}</span>
                                    ${priceDisplay !== 'Custom' ? '<span class="small text-muted">/month</span>' : ''}
                                </div>
                            </a>
                        `;
                        tabsList.appendChild(li);

                        // Add Content
                        const featuresHtml = plan.features_json.map(f => `
                            <li class="list-group-item d-flex heading-color mb-0">
                                <i class="bi bi-check-lg text-success me-2"></i>${f}
                            </li>
                        `).join('');

                        const pane = document.createElement('div');
                        pane.className = `tab-pane fade ${isActive ? 'show active' : ''}`;
                        pane.id = `${planId}-pane`;
                        pane.role = 'tabpanel';
                        pane.ariaLabelledby = `${planId}-tab`;
                        pane.innerHTML = `
                            <div class="card features-card p-4 p-sm-5 rounded-4 shadow-lg">
                                <div class="card-body p-0">
                                    <h5 class="mb-4 text-white">Included features</h5>
                                    <ul class="list-group list-group-borderless mb-4">
                                        ${featuresHtml}
                                    </ul>
                                </div>
                                <div class="card-footer bg-transparent text-center mt-4 p-0">
                                    <a href="contact.php" class="btn btn-primary w-100 mb-3 py-3 rounded-pill fw-bold">Get started</a>
                                    <a href="main-pricing.php?service=${service.slug}" class="link-white hover-underline-animation small fw-semibold">View comparison table</a>
                                </div>
                            </div>
                        `;
                        tabsContent.appendChild(pane);
                    });
                }

                // Toggle Update
                annualToggle.addEventListener('change', () => {
                    if (currentServiceId) renderPlans(currentServiceId);
                });

                // Initial Load (Select first service)
                if (items.length > 0) {
                    items[0].click();
                }
            });
        </script>
        <!-- Pricing END -->



    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <!-- =======================
    Footer START -->
    <?php include('include/front_footer.php') ?>
    <!-- =======================
    Footer END -->

    <!-- Back to top -->
    <div class="back-top"></div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!--Vendors-->
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>