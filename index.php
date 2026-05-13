<?php
    require_once 'include/db.php';
    require_once 'include/alerts.php';
    // Fetch Homepage Configuration
    $stmt = $pdo->query("SELECT section_key, section_content FROM homepage_sections WHERE status = 'active'");
    $home_config = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $home_config[$row['section_key']] = json_decode($row['section_content'], true);
    }

    // Fetch dynamic CTAs
    try {
        $newsletterCTA = $pdo->query("SELECT * FROM site_newsletter_cta WHERE status = 'active' LIMIT 1")->fetch();
        $careerCTA = $pdo->query("SELECT * FROM site_career_cta WHERE status = 'active' LIMIT 1")->fetch();
        $jobsCount = $pdo->query("SELECT COUNT(*) FROM job_listings WHERE status = 'active'")->fetchColumn();
    } catch (Exception $e) {
        $newsletterCTA = null;
        $careerCTA = null;
        $jobsCount = 0;
    }
    
    $activeCount = ($newsletterCTA ? 1 : 0) + ($careerCTA ? 1 : 0);
    $ctaColClass = ($activeCount === 1) ? 'col-12 mb-4' : 'col-xl-6 mb-4 mb-xl-0';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Primary SEO -->
    <title>Weburea Agency — UI/UX Design, Branding, Motion Graphics, QA & Web Development in Lagos</title>

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

    <!-- Canonical URL -->
    <link rel="canonical" href="https://weburea.com/">

    <!-- Open Graph -->
    <meta property="og:title" content="Weburea Agency — Creativity in Motion">
    <meta property="og:description"
        content="UI/UX, branding, motion graphics, QA testing, and web development for brands and startups across Lagos and Africa.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://weburea.com/">
    <meta property="og:site_name" content="Weburea Agency">
    <meta property="og:image" content="assets/images/og-banner-1200x630.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="340">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Weburea Agency — Creativity in Motion">
    <meta name="twitter:description"
        content="Digital-first creative agency providing UI/UX, motion graphics, QA testing, and web development. We create meaningful user-centered experiences.">
    <meta name="twitter:image" content="assets/images/twitter-card-1200x630.jpg">
    <meta name="twitter:site" content="@weburea">

    <!-- Theme Color -->
    <meta name="theme-color" content="#EA3E3A">

    <!-- Dark mode -->
    <?php include('include/dark_mode.php') ?>



    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">





    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": ["Organization", "LocalBusiness"],
            "name": "Weburea Agency",
            "alternateName": "Weburea",
            "url": "https://weburea.com/",
            "logo": "https://weburea.com/assets/images/logo.png",
            "description": "Weburea Agency is a creative digital studio offering UI/UX design, branding, motion graphics, QA testing, and web development services in Lagos, Nigeria.",
            "image": "https://weburea.com/assets/images/og-banner-1200x630.jpg",
            "email": "info@weburea.com",
            "telephone": "+234-XXXXXXXXXX",
            "address": {
                "addressLocality": "Lagos",
                "addressRegion": "Lagos",
                "postalCode": "100001",
                "addressCountry": "NG"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "6.5244",
                "longitude": "3.3792"
            },
            "openingHoursSpecification": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                "Monday","Tuesday","Wednesday","Thursday","Friday"
                ],
                "opens": "09:00",
                "closes": "22:00"
            },
            "sameAs": [
                "https://www.instagram.com/webureaagency",
                "https://www.linkedin.com/in/weburea-agency-3a61a5395",
                "https://x.com/weburea_design",
                "https://web.facebook.com/profile.php?id=61583069182660"
            ],
            
            "makesOffer": [
                {
                "@type": "Offer",
                "name": "UI/UX Design Services",
                "url": "https://weburea.com/ui-ux-design"
                },
                {
                "@type": "Offer",
                "name": "Branding & Creative Design",
                "url": "https://weburea.com/branding"
                },
                {
                "@type": "Offer",
                "name": "Motion Graphics & Video Editing",
                "url": "https://weburea.com/motion"
                },
                {
                "@type": "Offer",
                "name": "Software Testing (QA)",
                "url": "https://weburea.com/software-testing"
                },
                {
                "@type": "Offer",
                "name": "Web Design & Development",
                "url": "https://weburea.com/web-development"
                },
                {
                "@type": "Offer",
                "name": "Social Media & Ad Campaigns",
                "url": "https://weburea.com/social-media"
                }
            ]
        }
</script>


</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <section class="py-0">
            <!-- Title and content -->
            <div class="bg-secondary bg-opacity-50 position-relative overflow-hidden pb-7 pt-8">
                <!-- Grad blur -->
                <div class="position-absolute start-0 top-0">
                    <img src="assets/images/elements/grad-shape/blur-decoration-2.svg"
                        class="opacity-2 blur-9 h-300px rotate-335" alt="Grad shape">
                </div>
                <!-- Decoration -->
                <div class="position-absolute top-0 end-0 z-index-2 mt-6 me-n6 d-none d-lg-block">
                    <img src="assets/images/elements/grad-shape/05.png" class="h-250px" alt="">
                </div>
                <!-- Decoration -->
                <div class="position-absolute top-50 start-0 mt-n6 d-none d-lg-block">
                    <img src="assets/images/elements/clay-decoration.png" class="h-300px" alt="Clay-decoration">
                </div>

                <!-- Title and content -->
                <div class="container position-relative">
                    <div class="row">
                        <div class="col-xxl-8 text-center mx-auto">
                            <h1 class="small fw-medium bg-secondary-grad rounded px-2 px-sm-3 py-2 mb-3 d-inline-flex">
                                <?= htmlspecialchars($home_config['hero']['pre_title'] ?? 'Creativity in Motion') ?>
                            </h1>

                            <h2 class="mb-3 lh-base">
                                <?= htmlspecialchars($home_config['hero']['main_title_prefix'] ?? 'We build meaningful experiences with') ?>
                                <?php
                                if (!isset($services)) {
                                    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
                                    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                }
                                $serviceNames = array_column($services, 'name');
                                $typedText = !empty($serviceNames) ? implode('&&', $serviceNames) : 'Digital Excellence';
                                ?>
                                <span class="h1 fw-bold text-primary-grad ityped-cursor-opacity mb-0 d-block">
                                    <span class="typed" data-type-text="<?= htmlspecialchars($typedText) ?>"
                                        data-speed="100" data-start-delay="500" data-back-delay="1500"
                                        data-loop="true"></span>
                                </span>
                            </h2>

                            <p class="mb-4 lead">
                                <?= htmlspecialchars($home_config['hero']['lead_text'] ?? 'Weburea combines creativity, strategy, and technology.') ?>
                            </p>

                            <div class="d-flex justify-content-center flex-wrap gap-3">
                                <a href="<?= htmlspecialchars($home_config['hero']['btn1_link'] ?? 'services.php') ?>"
                                    class="btn btn-white-shadow mb-0"><?= htmlspecialchars($home_config['hero']['btn1_text'] ?? 'Explore Services') ?></a>
                                <a href="<?= htmlspecialchars($home_config['hero']['btn2_link'] ?? 'contact.php') ?>"
                                    class="btn btn-dark icon-link icon-link-hover mb-0">
                                    <?= htmlspecialchars($home_config['hero']['btn2_text'] ?? 'Get a Quote') ?> <i
                                        class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery START -->
            <div class="position-relative overflow-hidden">
                <!-- Bg -->
                <div class="h-300px w-100 bg-secondary bg-opacity-50 position-absolute top-0 start-0"></div>

                <?php
                $galleryImages = $home_config['gallery']['images'] ?? [];
                $halfCount = ceil(count($galleryImages) / 2);
                $firstRow = array_slice($galleryImages, 0, $halfCount);
                $secondRow = array_slice($galleryImages, $halfCount);
                ?>

                <!-- Row 1 -->
                <div class="swiper swiper-outside-n5 px-4 px-sm-5" data-swiper-options='{
            "spaceBetween": 50,
            "loop": true,
            "speed": 7000,
            "autoplay":{
                "delay": 0, 
                "disableOnInteraction": false
            },
            "breakpoints": { 
                "576": {"slidesPerView": 2},
                "768": {"slidesPerView": 3},
                "992": {"slidesPerView": 3},
                "1200": {"slidesPerView": 4},
                "1300": {"slidesPerView": 5}
            }}'>
                    <div class="swiper-wrapper ticker pb-5">
                        <?php foreach ($firstRow as $img): ?>
                            <div class="swiper-slide">
                                <img src="<?= htmlspecialchars($img) ?>" class="rounded-2 shadow-lg" alt="portfolio-img">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="swiper swiper-outside-n5 px-4 px-sm-5" dir="rtl" data-swiper-options='{
            "spaceBetween": 50,
            "loop": true,
            "speed": 7000,
            "autoplay":{
                "delay": 0, 
                "disableOnInteraction": false
            },
            "breakpoints": { 
                "576": {"slidesPerView": 2},
                "768": {"slidesPerView": 3},
                "992": {"slidesPerView": 3},
                "1200": {"slidesPerView": 4},
                "1300": {"slidesPerView": 5}
            }}'>
                    <div class="swiper-wrapper ticker pb-5">
                        <?php foreach ($secondRow as $img): ?>
                            <div class="swiper-slide">
                                <img src="<?= htmlspecialchars($img) ?>" class="rounded-2 shadow-lg" alt="portfolio-img">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Gallery END -->

        </section>
        <!-- =======================
Hero END -->

        <!-- =======================
Services START -->
        <section class="position-relative pt-6 pt-xxl-0">
            <div class="container">
                <h2 class="text-center mb-4 mt-3 pt-2 mb-lg-5">Our Expertise</h2>
                <div class="row g-4 g-lg-5">
                    <?php
                    require_once 'include/db.php';
                    if (!isset($services)) {
                        $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
                        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }

                    foreach ($services as $srv):
                        $expertiseList = json_decode($srv['home_list_expert'] ?? '[]', true);
                        if (!is_array($expertiseList))
                            $expertiseList = [];
                        ?>
                        <div class="col-md-6 col-xl-4">
                            <div
                                class="card card-bg-grad-hover card-content-hover bg-secondary bg-opacity-75 h-100 p-4 p-sm-5">
                                <div class="card-header bg-transparent p-0 pb-5">
                                    <img src="<?= htmlspecialchars($srv['icon_3d']) ?>" class="h-70px"
                                        alt="<?= htmlspecialchars($srv['name']) ?> icon"
                                        onerror="this.src='assets/images/logo.svg'">
                                </div>

                                <div class="card-footer bg-transparent mt-auto p-0">
                                    <h6 class="mb-3"><?= htmlspecialchars($srv['name']) ?></h6>
                                    <ul class="ps-3 mb-0">
                                        <?php foreach ($expertiseList as $expert): ?>
                                            <li class="mb-2"><?= htmlspecialchars($expert) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div
                                    class="hover-content d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
                                    <a class="btn btn-white icon-link icon-link-hover mb-0 stretched-link"
                                        href="single_services.php?slug=<?= htmlspecialchars($srv['slug']) ?>">View details<i
                                            class="bi bi-arrow-right"></i> </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <!-- CTA Start -->
                <div class="inner-container-small bg-primary-grad rounded-3 text-center py-3 mt-5">
                    <p class="text-white mb-0 px-2 px-sm-5 px-md-0">✌️ Ready to elevate your digital presence?
                        <a href="contact-us-v1.html" class="fw-semibold hover-underline-animation text-white">Hire us
                            now</a>
                    </p>
                </div>
                <!-- CTA END -->
            </div>
        </section>
        <!-- =======================
Services END -->




        <!-- =======================
        How it work and counter START -->
        <section class="bg-dark position-relative overflow-hidden pt-0 pt-sm-5">
            <div class="position-absolute bottom-0 end-0 mb-n8">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9"
                    alt="Grad shape">
            </div>

            <span class="position-absolute top-0 start-0">
                <svg class="text-secondary rtl-flip" width="1920" height="197" viewBox="0 0 1920 197" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H1920V5.5L0 197V0Z" fill="currentColor" />
                </svg>
            </span>
            <div class="container position-relative pt-lg-8 pt-xl-0" data-bs-theme="dark">

                <div class="row align-items-end align-items-xxl-center">
                    <div class="col-md-9 col-lg-6 mx-auto pe-xl-7">
                        <img src="assets/images/about/18.png" class="rounded-4" alt="process image">
                    </div>

                    <div class="col-lg-6 mt-5 mt-xl-7">
                        <span class="text-primary lead">The Workflow</span>
                        <h2 class="mt-3 mb-4">Streamline your path to success</h2>

                        <div class="accordion accordion-step-border" id="accordionFaq">
                            <div class="accordion-item">
                                <div class="accordion-header font-base" id="heading-1">
                                    <button class="accordion-button fs-6" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                        <span class="accordion-step-number">01</span> Subscribe & Request
                                    </button>
                                </div>
                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    aria-labelledby="heading-1" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Select your plan that fits your needs, get access to your Trello board within 24
                                        hours, and start listing your requests immediately.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header font-base" id="heading-2">
                                    <button class="accordion-button fs-6 collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false"
                                        aria-controls="collapse-2">
                                        <span class="accordion-step-number">02</span> Receive Deliverables
                                    </button>
                                </div>
                                <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Start receiving your designs within 2-3 business days, or even sooner for
                                        smaller tasks. Yes, it can be that fast.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header font-base" id="heading-3">
                                    <button class="accordion-button fs-6 collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false"
                                        aria-controls="collapse-3">
                                        <span class="accordion-step-number">03</span> Revise & Continue
                                    </button>
                                </div>
                                <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Approve designs or request revisions; we're not done until you're thrilled. Your
                                        satisfaction is our commitment.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-5 mt-sm-6 mt-md-8">
                    <?php
                    $statsConfig = $home_config['stats']['counters'] ?? [];
                    foreach ($statsConfig as $index => $stat):
                        $isLast = ($index === count($statsConfig) - 1);
                        ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="d-flex h-100 pe-xl-4">
                                <div>
                                    <div class="d-flex mb-2 mb-sm-6">
                                        <h4 class="purecounter h1 mb-0" data-purecounter-start="0"
                                            data-purecounter-end="<?= htmlspecialchars($stat['value']) ?>"
                                            data-purecounter-delay="300">0</h4>
                                        <span
                                            class="h1 text-<?= htmlspecialchars($stat['color']) ?> mb-0"><?= htmlspecialchars($stat['suffix']) ?></span>
                                    </div>
                                    <p class="lead"><?= htmlspecialchars($stat['label']) ?></p>
                                </div>
                                <?php if (!$isLast): ?>
                                    <div class="vr bg-white bg-opacity-25 ms-auto d-none d-sm-block"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- =======================
How it work and counter END -->

        <!-- =======================
        Benefits START -->
        <section>
            <div class="container position-relative">
                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-8">
                    <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9"
                        alt="Grad shape">
                </div>

                <div class="row position-relative z-index-2">
                    <div class="col-md-8 mx-auto text-center">
                        <h2 class="mb-4">
                            <?= $home_config['benefits']['title'] ?? 'Streamline operations and experience the <span class="text-primary">benefits of Weburea</span>' ?>
                        </h2>
                        <p class="mb-4">
                            <?= htmlspecialchars($home_config['benefits']['description'] ?? 'Eliminate the hassle and hidden costs of managing multiple vendors. By consolidating your creative, development, and testing needs with us, you get a unified workflow, consistent quality, and significant cost savings.') ?>
                        </p>
                        <a href="<?= htmlspecialchars($home_config['benefits']['btn_link'] ?? '#') ?>"
                            class="btn btn-primary-grad icon-link icon-link-hover">
                            <?= htmlspecialchars($home_config['benefits']['btn_text'] ?? 'Explore all benefits') ?><i
                                class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div
                    class="row row-cols-5 row-cols-lg-9 g-2 g-sm-4 justify-content-center justify-content-lg-between benefits-icon-grid position-relative z-index-2 mt-6 mt-sm-4">
                    <?php
                    $floatingIcons = $home_config['benefits']['floating_icons'] ?? [];
                    foreach ($floatingIcons as $idx => $icon):
                        $colClass = "col d-flex justify-content-center";
                        $iconClass = "icon-lg";
                        $imgHeight = "h-30px";
                        $extraClasses = "";

                        if ($idx == 0) {
                            $colClass = "col d-none d-lg-flex justify-content-start mb-lg-v8";
                            $iconClass = "icon-md";
                            $imgHeight = "h-20px";
                        } elseif ($idx == 1) {
                            $colClass = "col d-none d-sm-flex justify-content-start mb-lg-v6";
                            $iconClass = "icon-lg";
                            $imgHeight = "h-30px";
                        } elseif ($idx == 2) {
                            $colClass = "col d-flex justify-content-start mb-lg-v4";
                            $iconClass = "icon-lg";
                            $imgHeight = "h-30px";
                        } elseif ($idx == 3) {
                            $colClass = "col d-flex justify-content-start mb-lg-v2";
                            $iconClass = "icon-xl";
                            $imgHeight = "h-40px";
                        } elseif ($idx == 4) {
                            $colClass = "col d-flex justify-content-center mb-lg-v0";
                            $iconClass = "icon-xxl";
                            $imgHeight = "h-50px";
                            $extraClasses = "ripple-anim";
                        } elseif ($idx == 5) {
                            $colClass = "col d-flex justify-content-end mb-lg-v2";
                            $iconClass = "icon-xl";
                            $imgHeight = "h-40px";
                        } elseif ($idx == 6) {
                            $colClass = "col d-flex justify-content-end mb-lg-v4";
                            $iconClass = "icon-lg";
                            $imgHeight = "h-30px";
                        } elseif ($idx == 7) {
                            $colClass = "col d-none d-sm-flex justify-content-end mb-lg-v6";
                            $iconClass = "icon-lg";
                            $imgHeight = "h-30px";
                        } elseif ($idx == 8) {
                            $colClass = "col d-none d-lg-flex justify-content-end mb-lg-v8";
                            $iconClass = "icon-md";
                            $imgHeight = "h-20px";
                        }
                        ?>
                        <div class="<?= $colClass ?>">
                            <div class="<?= $iconClass ?> card rounded-circle shadow-primary justify-content-center <?= $extraClasses ?>"
                                data-bs-toggle="tooltip" data-bs-title="<?= htmlspecialchars($icon['name']) ?>">
                                <img src="<?= htmlspecialchars($icon['img']) ?>" class="<?= $imgHeight ?>"
                                    alt="<?= htmlspecialchars($icon['name']) ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div
                    class="bg-secondary rounded-4 d-xl-flex align-items-center text-center position-relative z-index-2 p-4 mt-7">
                    <ul class="avatar-group align-items-center justify-content-center mb-2 mb-xl-0">
                        <?php
                        $avatars = $home_config['advantages']['avatars'] ?? [];
                        foreach ($avatars as $avatar):
                            ?>
                            <li class="avatar">
                                <img class="avatar-img rounded-circle" src="<?= htmlspecialchars($avatar) ?>" alt="avatar">
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="heading-color lead mb-0 ms-xl-3">
                        <?= htmlspecialchars($home_config['advantages']['text'] ?? 'Join over 15M+ users transforming ideas') ?>
                        <a href="<?= htmlspecialchars($home_config['advantages']['link_url'] ?? 'benefits.php') ?>"
                            class="hover-underline-animation">
                            <?= htmlspecialchars($home_config['advantages']['link_text'] ?? 'Create an account') ?>
                        </a>
                        and see why we are different.
                    </p>
                </div>
            </div>
        </section>
        <!-- =======================
        Benefits END -->




        <!-- =======================
Project START -->
        <section class="position-relative overflow-hidden">
            <div class="container card-grid">
                <!-- Title and button -->
                <div
                    class="d-md-flex justify-content-between align-items-center text-center text-sm-start mb-4 mb-md-5">
                    <h2 class="mb-3 mb-md-0">Our latest projects</h2>
                    <a href="portfolio-list.html" class="btn btn-primary-grad mb-0">Explore portfolio</a>
                </div>

                <div class="row g-4">
                    <!-- Project item -->
                    <div class="col-md-7">
                        <div class="card card-img-scale card-content-hover overflow-hidden rounded-4 h-100">
                            <div class="card-img-scale-wrapper h-100">
                                <!-- Hover content -->
                                <div class="hover-content bg-blur bg-white bg-opacity-10">
                                    <!-- Hover content -->
                                    <div class="z-index-2 mt-auto">
                                        <span class="text-white">Technology</span>
                                        <h6 class="mb-0 mt-2"><a href="portfolio-case-study-v1.html"
                                                class="text-white stretched-link">Brand Identity Development</a></h6>
                                    </div>
                                </div>
                                <!-- Image -->
                                <a href="portfolio-case-study-v1.html" class="stretched-link d-block h-100"><img
                                        src="assets/images/portfolio/01.jpg"
                                        class="img-scale img-blur img-fluid portfolio-img-cover"
                                        alt="portfolio-img"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Project item -->
                    <div class="col-md-5">
                        <div class="card card-img-scale card-content-hover overflow-hidden rounded-4 h-100">
                            <div class="card-img-scale-wrapper h-100">
                                <!-- Hover content -->
                                <div class="hover-content bg-blur bg-white bg-opacity-10">
                                    <!-- Hover content -->
                                    <div class="z-index-2 mt-auto">
                                        <span class="text-white">Technology</span>
                                        <h6 class="mb-0 mt-2"><a href="portfolio-case-study-v2.html"
                                                class="text-white stretched-link">E-commerce platform launch</a></h6>
                                    </div>
                                </div>
                                <!-- Image -->
                                <a href="portfolio-case-study-v2.html" class="stretched-link d-block h-100">
                                    <video src="assets/images/portfolio/02.mp4"
                                        class="img-scale img-blur img-fluid portfolio-img-cover" autoplay loop muted
                                        playsinline></video>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Project item -->
                    <div class="col-md-5">
                        <div class="card card-img-scale card-content-hover overflow-hidden rounded-4 h-100">
                            <div class="card-img-scale-wrapper h-100">
                                <!-- Hover content -->
                                <div class="hover-content bg-blur bg-white bg-opacity-10">
                                    <!-- Hover content -->
                                    <div class="z-index-2 mt-auto">
                                        <span class="text-white">Technology</span>
                                        <h6 class="mb-0 mt-2"><a href="portfolio-case-study-v1.html"
                                                class="text-white stretched-link">Mobile app development</a></h6>
                                    </div>
                                </div>
                                <!-- Image -->
                                <a href="portfolio-case-study-v1.html" class="stretched-link d-block h-100"><img
                                        src="assets/images/portfolio/03.jpg"
                                        class="img-scale img-blur img-fluid portfolio-img-cover"
                                        alt="portfolio-img"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Project item -->
                    <div class="col-md-7">
                        <div class="card card-img-scale card-content-hover overflow-hidden rounded-4 h-100">
                            <div class="card-img-scale-wrapper h-100">
                                <!-- Hover content -->
                                <div class="hover-content bg-blur bg-white bg-opacity-10">
                                    <!-- Hover content -->
                                    <div class="z-index-2 mt-auto">
                                        <span class="text-white">Technology</span>
                                        <h6 class="mb-0 mt-2"><a href="portfolio-case-study-v2.html"
                                                class="text-white stretched-link">Digital marketing overhaul</a></h6>
                                    </div>
                                </div>
                                <!-- Image -->
                                <a href="portfolio-case-study-v2.html" class="stretched-link d-block h-100"><img
                                        src="assets/images/portfolio/04.jpg"
                                        class="img-scale img-blur img-fluid portfolio-img-cover"
                                        alt="portfolio-img"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Project item -->
                    <div class="col-md-12">
                        <div class="card card-img-scale card-content-hover overflow-hidden rounded-4 h-100">
                            <div class="card-img-scale-wrapper h-100">
                                <!-- Hover content -->
                                <div class="hover-content bg-blur bg-white bg-opacity-10">
                                    <!-- Hover content -->
                                    <div class="z-index-2 mt-auto">
                                        <span class="text-white">Technology</span>
                                        <h6 class="mb-0 mt-2"><a href="portfolio-case-study-v1.html"
                                                class="text-white stretched-link">SaaS Platform UI/UX Design</a></h6>
                                    </div>
                                </div>
                                <!-- Image -->
                                <a href="portfolio-case-study-v1.html" class="stretched-link d-block h-100"><img
                                        src="assets/images/portfolio/05.jpg"
                                        class="img-scale img-blur img-fluid portfolio-img-cover"
                                        alt="portfolio-img"></a>
                            </div>
                        </div>
                    </div>
                </div> <!-- Row END -->

                <!-- CTA START -->
                <div class="row mt-6">
                    <div class="col-lg-10 col-xl-8 col-xxl-7 mx-auto">
                        <div class="bg-body text-lg-end rounded-3 shadow-primary position-relative px-3 px-sm-6 py-3">
                            <!-- Shape decoration -->
                            <div class="position-absolute top-0 start-0 mt-n5 ms-n4 d-none d-sm-block">
                                <img src="assets/images/elements/grad-shape/03.png" class="zoom-animate" alt="Shape">
                            </div>

                            <p class="heading-color mb-0 ms-sm-6 ms-xl-0">Embark on your project journey! partner with
                                us today
                                <a href="contact.php" class="fw-semibold hover-underline-animation mb-0">Join
                                    today</a>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- CTA END -->
            </div>
        </section>
        <!-- =======================
Project END -->


        <!-- =======================
CTA START -->
        <section class="pt-6 pt-sm-5">
            <div class="container">
                <div class="bg-secondary-grad position-relative rounded-3 overflow-hidden p-4 p-sm-6">

                    <div class="position-absolute end-0 top-0 rotate-343 mt-n5 me-7 d-none d-sm-block">
                        <img src="assets/images/elements/geo-grad-pattern.svg" class="h-500px opacity-3"
                            alt="bg pattern">
                    </div>

                    <div class="position-absolute start-0 top-0 rotate-343 mt-n5 ms-n8">
                        <img src="assets/images/elements/geo-grad-pattern.svg" class="h-300px opacity-1"
                            alt="bg pattern">
                    </div>

                    <div class="row g-4 align-items-center position-relative">
                        <?php
                        $cta = $home_config['cta'] ?? [
                            'title' => 'Ready to put your design on',
                            'title_highlight' => 'auto-pilot?',
                            'list_items' => ['Pause or cancel anytime', 'Flat monthly rate'],
                            'btn_text' => 'View subscription plans',
                            'btn_link' => 'pricing.php'
                        ];
                        ?>
                        <div class="col-xl-6">
                            <h3><?= htmlspecialchars($cta['title']) ?> <span
                                    class="text-primary-grad"><?= htmlspecialchars($cta['title_highlight']) ?></span>
                            </h3>
                            <ul class="list-inline d-flex flex-wrap gap-2 mb-0 mt-3">
                                <?php foreach ($cta['list_items'] as $item): ?>
                                    <li class="list-inline-item heading-color"> <i
                                            class="bi bi-check-circle text-success me-1"></i><?= htmlspecialchars($item) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="col-xl-6 text-xl-end">
                            <a href="<?= htmlspecialchars($cta['btn_link']) ?>"
                                class="btn btn-dark mb-0"><?= htmlspecialchars($cta['btn_text']) ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
        CTA END -->

        <!-- =======================
        Review START -->
        <?php
        $reviews_config = $home_config['reviews'] ?? [];
        $review_cards = $reviews_config['review_cards'] ?? [];

        // Helper function to render a single review card
        function renderReviewCard($card)
        {
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

        // Helper to render columns (duplicating for swiper if needed)
        if (!function_exists('renderColumnContent')) {
            function renderColumnContent($cards, $col_num, $is_swiper = false)
            {
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
        <section class="position-relative overflow-hidden py-0">
            <div class="bg-body blur-6 h-300px w-100 position-absolute bottom-0 start-0 z-index-2 mb-n6"></div>

            <div class="container position-relative mb-n5">

                <div class="text-center mb-4 mb-md-5">
                    <h2 class="mb-4"><?= htmlspecialchars($reviews_config['title'] ?? 'Trusted by industry leaders') ?>
                    </h2>
                    <ul class="avatar-group align-items-center justify-content-center mb-2">
                        <?php foreach ($reviews_config['rating_avatars'] ?? [] as $avatar): ?>
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                                    src="<?= htmlspecialchars($avatar) ?>" alt="avatar"></li>
                        <?php endforeach; ?>
                    </ul>
                    <p>Rated <span
                            class="badge bg-primary"><?= htmlspecialchars($reviews_config['rating_badge'] ?? '4.9/5.0') ?></span>
                        <?= htmlspecialchars($reviews_config['rating_text'] ?? 'by over 100,000+ users') ?></p>
                </div>

                <div class="row g-4">
                    <!-- Column 1: Swiper Up -->
                    <div class="col-md-4">
                        <div class="swiper swiper-vertical-marquee swiper-vertical-up vertical-marquee-height">
                            <div class="swiper-wrapper">
                                <?php renderColumnContent($review_cards, 1, true); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Center (Static) -->
                    <div class="col-md-4 mt-5 mt-md-0">
                        <div class="vertical-marquee-height d-flex flex-column gap-4">
                            <?php renderColumnContent($review_cards, 2, false); ?>
                        </div>
                    </div>

                    <!-- Column 3: Swiper Up -->
                    <div class="col-md-4">
                        <div class="swiper swiper-vertical-marquee swiper-vertical-up vertical-marquee-height">
                            <div class="swiper-wrapper">
                                <?php renderColumnContent($review_cards, 3, true); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
        Review END -->


        <!-- pricing START -->
        <?php
        // Fetch all active services
        $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
        $allServices = $stmt->fetchAll();

        // Group plans by service
        $servicesData = [];
        $defaultServiceId = null;

        foreach ($allServices as $index => $svc) {
            if ($index === 0)
                $defaultServiceId = $svc['id'];

            $pStmt = $pdo->prepare("SELECT * FROM pricing_plans 
                                     WHERE service_id = ? AND status = 'active' 
                                     ORDER BY is_custom ASC, 
                                     CASE 
                                       WHEN name LIKE '%Basic%' THEN 1 
                                       WHEN name LIKE '%Standard%' THEN 2 
                                       WHEN name LIKE '%Pro%' OR name LIKE '%Premium%' OR name LIKE '%Business%' THEN 3 
                                       WHEN name LIKE '%Enterprise%' THEN 4 
                                       ELSE 5 
                                     END ASC 
                                     LIMIT 4");
            $pStmt->execute([$svc['id']]);
            $plans = $pStmt->fetchAll();

            $servicesData[$svc['id']] = [
                'service' => $svc,
                'plans' => $plans
            ];
        }

        // Use the first service as default if web-development isn't found
        $defaultServiceSlug = 'web-development';
        $activeServiceId = null;
        foreach ($allServices as $svc) {
            if ($svc['slug'] === $defaultServiceSlug) {
                $activeServiceId = $svc['id'];
                break;
            }
        }
        if (!$activeServiceId)
            $activeServiceId = $defaultServiceId;
        ?>
        <!-- =======================
Hero START -->
        <section class="price-wrap position-relative overflow-hidden pt-xl-8">
            <!-- Grad blur -->
            <div
                class="bg-primary-grad blur-9 h-300px w-100 opacity-2 position-absolute top-0 start-50 translate-middle-x mt-n7">
            </div>
            <!-- Title and switch -->
            <div class="container position-relative z-index-2 pt-4 pb-0 pb-xl-0 text-center">
                <!-- Breadcrumb -->
                <nav class="mb-2 d-flex justify-content-center" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" id="pricing-breadcrumb" aria-current="page">
                            <?php echo htmlspecialchars($servicesData[$activeServiceId]['service']['name']); ?> Pricing
                        </li>
                    </ol>
                </nav>

                <!-- Title -->
                <h3>Pricing Plan For</h3>
                <h1 class="fw-bold mb-4">Every <span class="text-primary-grad"
                        id="pricing-service-title"><?php echo htmlspecialchars($servicesData[$activeServiceId]['service']['name']); ?></span>
                    Needs</h1>

                <!-- Nav tabs (Pills) -->
                <div class="mb-4">
                    <ul class="nav nav-pills nav-pills-primary justify-content-center flex-wrap" id="pills-tab"
                        role="tablist" style="gap: 0.5rem;">
                        <?php foreach ($allServices as $svc): ?>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link <?php echo $svc['id'] == $activeServiceId ? 'active' : ''; ?> service-nav-pill px-4 py-2 border border-primary border-opacity-10"
                                    data-service-id="<?php echo $svc['id']; ?>"
                                    data-service-name="<?php echo htmlspecialchars($svc['name']); ?>"
                                    data-service-slug="<?php echo $svc['slug']; ?>" type="button"
                                    role="tab"><?php echo htmlspecialchars($svc['name']); ?></button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Switch -->
                <form
                    class="bg-body shadow-primary border border-primary d-inline-flex align-items-center rounded-3 p-3 px-sm-4 py-sm-3 mb-6 mb-xl-8"
                    style="--bs-border-opacity: 0.20;">
                    <!-- Label -->
                    <span class="fw-semibold heading-color">Monthly</span>
                    <!-- Switch -->
                    <div class="form-check form-switch form-check-lg mx-2 mb-0">
                        <input class="form-check-input mt-0 price-toggle" type="checkbox" id="flexSwitchCheckDefault">
                    </div>
                    <!-- Label -->
                    <span class="fw-semibold heading-color">Yearly</span>
                    <span class="badge bg-success ms-2">20% save</span>
                </form>
            </div>

            <!-- Pricing box START -->
            <div class="container-fluid">
                <div class="max-width-1550">
                    <div class="pricing-grids-container">
                        <?php foreach ($servicesData as $svcId => $data): ?>
                            <div class="row service-pricing-grid <?php echo $svcId == $activeServiceId ? '' : 'd-none'; ?>"
                                id="service-grid-<?php echo $svcId; ?>">
                                <?php foreach ($data['plans'] as $index => $plan):
                                    $planFeatures = json_decode($plan['features_json'] ?? '[]', true);
                                    $isRecommended = (bool) $plan['is_recommended'];
                                    $isCustom = (bool) $plan['is_custom'];

                                    // Define icons based on tier/custom
                                    $iconClass = 'bi bi-lightning-charge-fill';
                                    if ($index == 1)
                                        $iconClass = 'bi bi-send-fill';
                                    if ($isRecommended || stripos($plan['name'], 'Premium') !== false)
                                        $iconClass = 'bi bi-rocket-takeoff-fill';
                                    if ($isCustom || stripos($plan['name'], 'Business') !== false)
                                        $iconClass = 'bi bi-headset';

                                    // Styles
                                    $cardClass = 'card shadow overflow-hidden p-1';
                                    $headerClass = 'card-header bg-secondary bg-opacity-50 p-4 pb-0';
                                    $footerClass = 'card-footer bg-secondary bg-opacity-50 p-4';
                                    $btnClass = 'btn btn-dark btn-transition w-100 mt-4';

                                    if ($isRecommended) {
                                        $cardClass = 'card shadow p-1';
                                        $headerClass = 'card-header bg-secondary-grad rounded-top p-4 pb-0';
                                        $footerClass = 'card-footer bg-secondary-grad p-4';
                                        $btnClass = 'btn btn-white-shadow w-100 mt-4';
                                    }
                                    ?>
                                    <!-- Pricing item -->
                                    <div class="col-md-6 col-xl-3 mb-5 mb-xl-0 pt-3">
                                        <div class="<?php echo $cardClass; ?> position-relative h-100">
                                            <?php if ($isRecommended): ?>
                                                <!-- Badge -->
                                                <div
                                                    class="bg-primary-grad small text-white rounded position-absolute top-0 start-50 translate-middle px-3 py-1">
                                                    <?php echo htmlspecialchars($plan['label'] ?: 'Recommended'); ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Card header -->
                                            <div
                                                class="<?php echo $headerClass; ?> <?php echo $isCustom ? 'position-relative overflow-hidden' : ''; ?>">
                                                <?php if ($isCustom): ?>
                                                    <!-- Blur decoration -->
                                                    <div class="position-absolute top-0 end-0 mt-n8 me-n5">
                                                        <img src="assets/images/elements/grad-shape/blur-decoration.svg"
                                                            class="blur-7 opacity-2 h-300px" alt="Grad shape">
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Icon -->
                                                <div
                                                    class="icon-lg <?php echo $isRecommended ? 'bg-pink' : 'bg-body shadow-primary'; ?> rounded-circle mb-3">
                                                    <i
                                                        class="<?php echo $iconClass; ?> fa-lg lh-1 <?php echo $isRecommended ? 'text-white' : 'heading-color'; ?>"></i>
                                                </div>
                                                <!-- Title and price -->
                                                <h6 class="mb-3"><?php echo htmlspecialchars($plan['name']); ?></h6>
                                                <?php if ($isCustom): ?>
                                                    <h2>Custom</h2>
                                                <?php else: ?>
                                                    <p class="mb-0">
                                                        <span class="h2 mb-0 plan-price"
                                                            data-monthly-price="<?php echo htmlspecialchars($plan['price']); ?>"
                                                            data-annual-price="<?php echo htmlspecialchars($plan['annual_price'] ?: $plan['price']); ?>">
                                                            <?php echo htmlspecialchars($plan['price']); ?>
                                                        </span> /project
                                                    </p>
                                                <?php endif; ?>
                                                <small><?php echo htmlspecialchars($plan['description']); ?></small>
                                                <!-- Button -->
                                                <a href="main-pricing.php?service=<?php echo $data['service']['slug']; ?>"
                                                    class="<?php echo $btnClass; ?>"><?php echo $isCustom ? 'Request pricing' : 'Get started'; ?></a>
                                            </div>

                                            <!-- Card footer -->
                                            <div class="<?php echo $footerClass; ?> flex-grow-1">
                                                <!-- List -->
                                                <ul class="list-group list-group-borderless mb-0">
                                                    <?php if (!empty($planFeatures)): ?>
                                                        <?php foreach (array_slice($planFeatures, 0, 8) as $feature): ?>
                                                            <li class="list-group-item d-flex heading-color mb-0">
                                                                <i class="bi bi-check-lg text-primary me-1 text-shrink-0"></i>
                                                                <?php echo htmlspecialchars($feature); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- View All Pricing Button -->
                <div class="text-center mt-6">
                    <a id="view-all-pricing-btn"
                        href="main-pricing.php?service=<?php echo $servicesData[$activeServiceId]['service']['slug']; ?>"
                        class="btn btn-primary-grad btn-lg mb-0 icon-link icon-link-hover">
                        More Pricing Details
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Pricing box END -->
        </section>
        <!-- =======================
Hero END -->

        <!-- pricing END -->

        <!-- =======================
Testimonials START -->
        <?php
        $test_config = $home_config['testimonials'] ?? [];
        $platform_ratings = $test_config['platform_ratings'] ?? [];
        $testimonial_items = $test_config['testimonial_items'] ?? [];

        if (!function_exists('renderTestimonialStars')) {
            function renderTestimonialStars($rating)
            {
                $full = floor($rating);
                $half = ($rating - $full) >= 0.5 ? 1 : 0;
                $empty = 5 - ($full + $half);

                $html = '<ul class="list-inline mb-4">';
                for ($i = 0; $i < $full; $i++)
                    $html .= '<li class="list-inline-item fs-6 me-0"><i class="bi bi-star-fill text-warning"></i></li>';
                if ($half)
                    $html .= '<li class="list-inline-item fs-6 me-0"><i class="bi bi-star-half text-warning"></i></li>';
                for ($i = 0; $i < $empty; $i++)
                    $html .= '<li class="list-inline-item fs-6 me-0"><i class="bi bi-star text-warning"></i></li>';
                $html .= '</ul>';
                return $html;
            }
        }
        ?>
        <section class="position-relative pt-0">
            <!-- Hand decoration -->
            <div class="position-absolute top-0 end-0 me-7 d-none d-sm-block" data-0="right:0%;top:50%;"
                data-top="right:0%;top:90%;">
                <img src="assets/images/elements/hand-dec.png" alt="hand decoration">
            </div>

            <!-- Grad shape decoration -->
            <div class="position-absolute start-0 bottom-0 mb-n7 ms-n7">
                <img src="assets/images/elements/grad-shape/05.png" alt="grad shape">
            </div>

            <div class="container-fluid">
                <div
                    class="max-width-1550 bg-secondary bg-opacity-50 bg-blur position-relative rounded-4 overflow-hidden py-6 py-lg-8">
                    <!-- Grad blur decoration -->
                    <div class="position-absolute top-0 end-0 mt-n6 ms-n5">
                        <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-7 opacity-1"
                            alt="Grad shape">
                    </div>

                    <div class="container">
                        <!-- Title -->
                        <div class="inner-container text-center mb-lg-6">
                            <h2><?= $test_config['title'] ?? 'Client Testimonials 😍' ?></h2>
                        </div>

                        <!-- Slider contents START -->
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <!-- Slider START -->
                                <div class="swiper mt-2 mt-md-4" data-swiper-options='{
                            "spaceBetween": 30,
                            "autoplay":{
                                "delay": 4000, 
                                "disableOnInteraction": false,
                                "pauseOnMouseEnter": true
                            },
                            "pagination":{
                                "el":".swiper-pagination",
                                "clickable":"true"
                            }}'>

                                    <div class="swiper-wrapper mb-5">
                                        <?php foreach ($testimonial_items as $item): ?>
                                            <!-- Testimonials item -->
                                            <div class="swiper-slide">
                                                <div class="text-center">
                                                    <!-- Image -->
                                                    <div class="avatar avatar-lg mx-auto flex-shrink-0 mb-4">
                                                        <img class="avatar-img rounded-circle"
                                                            src="<?= htmlspecialchars($item['avatar'] ?? 'assets/images/avatar/default.jpg') ?>"
                                                            alt="avatar">
                                                    </div>
                                                    <!-- Testimonials text -->
                                                    <blockquote class="mb-4">
                                                        <p class="lead heading-color mb-0">
                                                            <?= htmlspecialchars($item['quote'] ?? '') ?>
                                                        </p>
                                                    </blockquote>
                                                    <!-- Rating star -->
                                                    <?= renderTestimonialStars($item['rating'] ?? 5) ?>

                                                    <!-- Testimonials info -->
                                                    <div>
                                                        <h6 class="mb-0"><?= htmlspecialchars($item['name'] ?? 'Client') ?>
                                                        </h6>
                                                        <span><?= htmlspecialchars($item['role'] ?? 'Partner') ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Slider Pagination -->
                                    <div
                                        class="swiper-pagination swiper-pagination-primary position-absolute bottom-0 mb-3">
                                    </div>
                                </div>
                                <!-- Slider END -->
                            </div>
                        </div>
                        <!-- Slider contents END -->

                        <hr class="border-primary border-2 border-opacity-25 my-5"> <!-- Divider -->

                        <!-- Platform rating START -->
                        <div class="row align-items-center px-md-5">
                            <div class="col-lg-4">
                                <h5 class="mb-4 mb-lg-0">
                                    <?= $test_config['clients_text'] ?? 'More than 500+ clients using Weburea platform' ?>
                                </h5>
                            </div>

                            <?php
                            $count = 0;
                            foreach ($platform_ratings as $plat):
                                $is_last = (++$count === count($platform_ratings));
                                ?>
                                <!-- Platform rating -->
                                <div
                                    class="col-sm-6 col-lg-4 col-xl-3 <?= !$is_last ? 'border-end border-primary border-opacity-25 ms-auto mb-4 mb-sm-0' : '' ?>">
                                    <div class="d-flex align-items-center <?= $is_last ? 'ps-2' : '' ?>">
                                        <!-- Icon -->
                                        <img src="<?= htmlspecialchars($plat['icon']) ?>" class="icon-lg" alt="">

                                        <!-- Content -->
                                        <div class="ms-3">
                                            <!-- Rating -->
                                            <ul class="list-inline mb-1">
                                                <?php
                                                $prating = $plat['rating'] ?? 5;
                                                $p_full = floor($prating);
                                                $p_half = ($prating - $p_full) >= 0.5 ? 1 : 0;
                                                $p_empty = 5 - ($p_full + $p_half);
                                                for ($i = 0; $i < $p_full; $i++)
                                                    echo '<li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>';
                                                if ($p_half)
                                                    echo '<li class="list-inline-item me-0"><i class="bi bi-star-half text-warning"></i></li>';
                                                for ($i = 0; $i < $p_empty; $i++)
                                                    echo '<li class="list-inline-item me-0"><i class="bi bi-star text-warning"></i></li>';
                                                ?>
                                            </ul>
                                            <span><?= htmlspecialchars($prating) ?> stars on
                                                <?= htmlspecialchars($plat['platform']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Platform rating END -->

                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Testimonials END -->

        <!-- =======================
Blog START -->
        <section>
            <div class="container">
                <!-- Title -->
                <div class="inner-container-small text-center mb-5">
                    <h2 class="mb-0">Insights on our blog</h2>
                </div>

                <div class="row g-4 g-lg-5">
                    <!-- Blog item -->
                    <div class="col-md-4">
                        <article
                            class="card card-hover-shadow card-hover-transition border border-opacity-25 rounded-4 overflow-hidden h-100 p-0">
                            <!-- Badge -->
                            <div class="badge text-bg-white position-absolute top-0 start-0 m-4">Lifestyle</div>

                            <!-- Card image -->
                            <img src="assets/images/blog/01.jpg" class="card-img-top" alt="Blog-img">

                            <!-- Card Body -->
                            <div class="card-body pb-2">
                                <!-- Title -->
                                <h6 class="card-title mb-2"><a href="#">Techniques to captivate your audience</a></h6>
                            </div>

                            <!-- Card footer -->
                            <div class="card-footer pt-0">
                                <a class="icon-link icon-link-hover stretched-link" href="blog-single.html">Read more<i
                                        class="bi bi-arrow-right"></i> </a>
                            </div>
                        </article>
                    </div>

                    <!-- Blog item -->
                    <div class="col-md-4">
                        <article
                            class="card card-hover-shadow card-hover-transition bg-primary-grad rounded-4 overflow-hidden h-100 p-4">
                            <!-- Card Body -->
                            <div class="card-body p-0 pb-2">
                                <!-- Badge -->
                                <div class="badge text-bg-dark mb-3">Research</div>
                                <!-- Title -->
                                <h6 class="card-title text-white mb-5">Building a strong identity for your business</h6>
                            </div>

                            <!-- Card footer -->
                            <div class="card-footer bg-transparent p-0">
                                <a class="link-white icon-link icon-link-hover stretched-link"
                                    href="blog-single.html">Read more<i class="bi bi-arrow-right"></i> </a>
                            </div>
                        </article>
                    </div>

                    <!-- Blog item -->
                    <div class="col-md-4">
                        <article
                            class="card card-hover-shadow card-hover-transition border border-opacity-25 rounded-4 overflow-hidden h-100 p-0">
                            <!-- Badge -->
                            <div class="badge text-bg-white position-absolute top-0 start-0 m-4">Lifestyle</div>

                            <!-- Card image -->
                            <img src="assets/images/blog/02.jpg" class="card-img-top" alt="Blog-img">

                            <!-- Card Body -->
                            <div class="card-body pb-2">
                                <!-- Title -->
                                <h6 class="card-title mb-2"><a href="#">Tips for improving your website's visibility</a>
                                </h6>
                            </div>

                            <!-- Card footer -->
                            <div class="card-footer pt-0">
                                <a class="icon-link icon-link-hover stretched-link" href="blog-single.html">Read more<i
                                        class="bi bi-arrow-right"></i> </a>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Explore button -->
                <div class="text-center mt-5">
                    <p>Want more insights?</p>
                    <a href="blog-minimal.html" class="btn btn-white-shadow">Explore all resources</a>
                </div>
            </div>
        </section>
        <!-- =======================
Blog END -->

        <!-- =======================
Faq START -->
        <section class="pt-0 position-relative">
            <!-- Grad blur decoration -->
            <div class="position-absolute end-0 bottom-0 d-none d-sm-block">
                <img src="assets/images/elements/grad-shape/12.png" class="blur-2" alt="Decoration shape">
            </div>

            <div class="container position-relative">
                <!-- Title -->
                <div class="inner-container position-relative text-center mb-4 mb-md-5">
                    <h2 class="mb-0">Got questions? (FAQs)</h2>
                </div>

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <!-- Accordion START -->
                        <div class="accordion accordion-bg-body-light" id="accordionFaq">
                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-1">
                                    <button class="accordion-button fw-semibold rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true"
                                        aria-controls="collapse-1">
                                        How do I get started with your service?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    aria-labelledby="heading-1" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0 pt-0">
                                        The first step is to sign up for our service. You can do this by visiting our
                                        website and locating the sign-up or registration button. Click on it and follow
                                        the prompts to create your account.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-2">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false"
                                        aria-controls="collapse-2">
                                        What payment methods do you accept?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        September how men saw tolerably two behavior arranging. She offices for highest
                                        and replied one venture pasture. Applauded no discovery in newspaper allowance
                                        am northward. Frequently partiality possession resolution at or appearance
                                        unaffected me. Engaged its was the evident pleased husband. Ye goodness felicity
                                        do disposal dwelling no. First am plate jokes to began to cause a scale.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-3">
                                    <button class="accordion-button fw-semibold collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false"
                                        aria-controls="collapse-3">
                                        How can I contact your customer support team?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Agencies provide a wide range of services depending on their specialization.
                                        Some common services include advertising campaigns, digital marketing, branding,
                                        creative design, media planning and buying, public relations, talent management,
                                        event planning, and market research.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-4">
                                    <button class="accordion-button fw-semibold collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false"
                                        aria-controls="collapse-4">
                                        Do you offer custom solutions for businesses?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        When selecting an agency, consider your specific requirements, budget, and the
                                        agency's expertise and track record in your industry. Research their portfolio,
                                        client testimonials, and case studies to gauge their capabilities. It's also
                                        important to meet with the agency to assess their communication style and ensure
                                        they align with your goals.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion END -->

                        <!-- CTA text -->
                        <p class="heading-color text-center">Confused? Our team is ready to assist you! Start a chat for
                            quick support. <a href="#" class="hover-underline-animation fw-semibold">Talk to Us</a></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Faq START -->

        <!-- =======================
        CTA START -->
        <section class="overflow-hidden pt-0 pb-5 mb-n5 mb-lg-n8">
            <div class="container z-index-9 position-relative">
                <div class="row g-5">
                    <?php if ($newsletterCTA): ?>
                    <!-- CTA One: Newsletter -->
                    <div class="<?php echo $ctaColClass; ?>">
                        <div class="card bg-primary h-100 border-0 shadow-lg">
                            <!-- Image -->
                            <div class="position-absolute bottom-0 end-0 me-n4 mb-n4 d-none d-md-block" style="z-index: 1;">
                                <img src="<?php echo htmlspecialchars($newsletterCTA['image_path'] ?? 'assets/images/elements/rocket-02.png'); ?>" alt="rocket image" style="max-height: 280px; transform: rotate(-5deg);">
                            </div>

                            <!-- Content -->
                            <div class="row align-items-center h-100 p-4 p-sm-5 position-relative" style="z-index: 2;">
                                <!-- Title and content -->
                                <div class="col-md-8 col-sm-10 d-flex h-100">
                                    <div class="card-body d-flex flex-column text-white p-0">
                                        <h3 class="mb-5 text-white fw-bold"><?php echo htmlspecialchars($newsletterCTA['title'] ?? 'Stay connected with us'); ?></h3>

                                        <div class="mt-auto">
                                            <form id="newsletterForm" class="d-flex mb-3">
                                                <input class="form-control rounded-pill border-0 me-2 py-3 px-4 shadow-sm"
                                                    type="email" name="email" placeholder="Enter your email" required 
                                                    style="<?php echo $careerActive ? 'max-width: 280px;' : 'max-width: 400px;'; ?>">
                                                <button type="submit" class="btn btn-dark p-0 d-flex align-items-center justify-content-center shadow-lg" 
                                                    style="width: 56px; height: 56px; min-width: 56px; border-radius: 50%; background: #000; border: none; transition: all 0.3s ease;">
                                                    <i class="bi bi-send-fill fs-5 text-white" style="transform: translate(-1px, 1px); pointer-events: none;"></i>
                                                </button>
                                            </form>
                                            <p class="small mb-0 fw-bold" style="color: rgba(255,255,255,0.9); letter-spacing: 0.5px;"><?php echo htmlspecialchars($newsletterCTA['subtitle'] ?? '✌️ No Spam — We Promise!'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($careerCTA): ?>
                    <!-- CTA Two: Careers -->
                    <div class="<?php echo $ctaColClass; ?>">
                        <div class="card bg-primary-grad h-100 border-0 shadow-lg">
                            <!-- Image -->
                            <div class="position-absolute bottom-0 end-0 me-n4 mb-n4 d-none d-md-block" style="z-index: 1;">
                                <img src="<?php echo htmlspecialchars($careerCTA['image_path'] ?? 'assets/images/elements/person-laptop.png'); ?>" alt="career image" style="max-height: 320px;">
                            </div>

                            <div class="row align-items-center p-4 p-sm-5 position-relative" style="z-index: 2;">
                                <!-- Title and content -->
                                <div class="col-sm-9">
                                    <div class="card-body text-white p-0">
                                        <p class="text-uppercase small fw-bold text-white-50 mb-2" style="letter-spacing: 1px;"><?php echo htmlspecialchars($careerCTA['subtitle'] ?? 'Apply to work with us'); ?></p>
                                        <h3 class="mb-5 text-white fw-bold"><?php echo htmlspecialchars($careerCTA['title'] ?? 'Explore Career Opportunities'); ?></h3>
                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                            <a class="btn btn-dark rounded-pill px-4 py-2 icon-link icon-link-hover shadow-lg mb-0" href="<?php echo htmlspecialchars($careerCTA['btn_url'] ?? 'career.html'); ?>">
                                                <?php echo htmlspecialchars($careerCTA['btn_text'] ?? 'View open positions'); ?>
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold shadow-sm">
                                                <i class="bi bi-lightning-fill me-1"></i><?php echo $jobsCount; ?> Openings
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div> <!-- Row END -->
            </div>
        </section>
        <!-- =======================
        CTA END -->


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
    <script src="assets/vendor/ityped/index.js"></script>


    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

    <script>
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
    </script>

    <script>
        // Price toggle logic
        const priceToggle = document.querySelector('.price-toggle');
        if (priceToggle) {
            priceToggle.addEventListener('change', function () {
                const isAnnual = this.checked;
                document.querySelectorAll('.plan-price').forEach(function (priceEl) {
                    const monthlyPrice = priceEl.getAttribute('data-monthly-price');
                    const annualPrice = priceEl.getAttribute('data-annual-price');
                    priceEl.innerText = isAnnual ? annualPrice : monthlyPrice;
                });
            });
        }

        // Service switching logic
        document.querySelectorAll('.service-nav-pill').forEach(pill => {
            pill.addEventListener('click', function () {
                const serviceId = this.getAttribute('data-service-id');
                const serviceName = this.getAttribute('data-service-name');
                const serviceSlug = this.getAttribute('data-service-slug');

                // Update active pill
                document.querySelectorAll('.service-nav-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                // Update breadcrumb and title
                const breadcrumb = document.getElementById('pricing-breadcrumb');
                const titleSpan = document.getElementById('pricing-service-title');
                if (breadcrumb) breadcrumb.innerText = serviceName + ' Pricing';
                if (titleSpan) titleSpan.innerText = serviceName;

                // Update button link and text
                const pricingBtn = document.getElementById('view-all-pricing-btn');
                const btnServiceName = document.getElementById('btn-service-name');
                if (pricingBtn) pricingBtn.href = 'main-pricing.php?service=' + serviceSlug;
                if (btnServiceName) btnServiceName.innerText = serviceName;

                // Toggle visibility of pricing grids with a subtle fade effect
                document.querySelectorAll('.service-pricing-grid').forEach(grid => {
                    grid.classList.add('d-none');
                });
                const activeGrid = document.getElementById('service-grid-' + serviceId);
                if (activeGrid) {
                    activeGrid.classList.remove('d-none');
                    // Add animation class if needed
                    activeGrid.style.opacity = 0;
                    setTimeout(() => {
                        activeGrid.style.transition = 'opacity 0.3s ease-in-out';
                        activeGrid.style.opacity = 1;
                    }, 10);
                }
            });
        });
    </script>


    <!-- Newsletter Submission Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const emailInput = this.querySelector('input[type="email"]');
                const email = emailInput.value;
                const btn = this.querySelector('button');
                const originalBtn = btn.innerHTML;

                // Use a spinning asterisk-like icon or standard spinner
                btn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
                btn.disabled = true;

                try {
                    const response = await fetch('api/newsletter_subscribe.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email: email })
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        showPremiumAlert(null, null, 'success', null, 'newsletter');
                        emailInput.value = '';
                    } else {
                        showPremiumAlert(null, result.message, 'warning', null, 'newsletter');
                    }
                } catch (error) {
                    showPremiumAlert('Connection Error', 'Please check your internet connection and try again.', 'danger', 'Close');
                } finally {
                    btn.innerHTML = originalBtn;
                    btn.disabled = false;
                }
            });
        }
    });
    </script>
    
    <?php 
        inject_toast_system(); 
        inject_premium_alert_modal();
    ?>
</body>

</html>