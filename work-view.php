<?php
require_once('include/db.php');

$workId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$work = null;

if ($workId > 0) {
    // Fetch the work and join with service to get service details
    $stmt = $pdo->prepare("SELECT w.*, s.name as service_name, s.slug as service_slug, s.description_short as service_desc, s.icon_3d 
                           FROM portfolio_works w 
                           LEFT JOIN services s ON w.service_id = s.id 
                           WHERE w.id = ? AND w.status = 'published'");
    $stmt->execute([$workId]);
    $work = $stmt->fetch();
}

if (!$work) {
    // Fallback if no work found, fetch the latest published one
    $stmt = $pdo->prepare("SELECT w.*, s.name as service_name, s.slug as service_slug, s.description_short as service_desc, s.icon_3d 
                           FROM portfolio_works w 
                           LEFT JOIN services s ON w.service_id = s.id 
                           WHERE w.status = 'published' 
                           ORDER BY w.created_at DESC LIMIT 1");
    $stmt->execute();
    $work = $stmt->fetch();
}

// Fetch all services for the dropdown
$servicesStmt = $pdo->query("SELECT id, name, slug, icon_3d FROM services WHERE status = 'active' ORDER BY id ASC");
$services = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all pricing data
$allPricingData = [];
foreach ($services as $service) {
    $plansStmt = $pdo->prepare("SELECT * FROM pricing_plans 
                                 WHERE service_id = ? AND status = 'active' 
                                 ORDER BY is_custom ASC, 
                                 CASE 
                                   WHEN name LIKE '%Basic%' THEN 1 
                                   WHEN name LIKE '%Standard%' THEN 2 
                                   WHEN name LIKE '%Pro%' OR name LIKE '%Premium%' OR name LIKE '%Business%' THEN 3 
                                   WHEN name LIKE '%Enterprise%' THEN 4 
                                   ELSE 5 
                                 END ASC");
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

// Fetch 10 related projects (prioritizing same service)
$relatedWorks = [];
if ($work) {
    $stmt = $pdo->prepare("SELECT id, title, image, categories FROM portfolio_works 
                           WHERE status = 'published' AND id != ?
                           ORDER BY CASE WHEN service_id = ? THEN 0 ELSE 1 END, created_at DESC 
                           LIMIT 10");
    $stmt->execute([$work['id'], $work['service_id']]);
    $relatedWorks = $stmt->fetchAll();
}

// Decode JSON fields
$serviceData = json_decode($work['service_data_json'] ?? '{}', true);
$additionalImages = json_decode($work['additional_images'] ?: '[]', true) ?: [];
$testimonials = json_decode($work['testimonials_json'] ?: '[]', true) ?: [];

// Handle challenge points (support both commas and newlines)
$challengeInput = $work['challenge_points'] ?? '';
if (strpos($challengeInput, ',') !== false) {
    $challengePoints = array_filter(array_map('trim', explode(',', $challengeInput)));
} else {
    $challengePoints = array_filter(array_map('trim', explode("\n", $challengeInput)));
}

// Fallback for legacy testimonial if JSON is empty
if (empty($testimonials) && !empty($work['testimonial_text'])) {
    $testimonials[] = [
        'text' => $work['testimonial_text'],
        'author' => $work['testimonial_author'],
        'role' => $work['testimonial_role'],
        'image' => $work['testimonial_image']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title><?= htmlspecialchars($work['meta_title'] ?: $work['title'] . ' — Weburea Agency') ?></title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea Agency">

    <meta name="description"
        content="<?= htmlspecialchars($work['meta_description'] ?: $work['description']) ?>">

    <meta name="keywords"
        content="<?= htmlspecialchars($work['meta_keywords'] ?: 'Weburea Portfolio, ' . $work['service_name']) ?>">

    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($work['meta_title'] ?: $work['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($work['meta_description'] ?: $work['description']) ?>">
    <meta property="og:image" content="<?= $work['meta_og_image'] ? 'https://weburea.com/' . $work['meta_og_image'] : 'https://weburea.com/' . ($work['image'] ?: 'assets/images/portfolio/list/04.jpg') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://weburea.com/work-view.php?id=<?= $work['id'] ?>">
    <meta property="og:type" content="<?= htmlspecialchars($work['meta_og_type'] ?: 'website') ?>">
    <meta property="og:site_name" content="Weburea Agency">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($work['meta_title'] ?: $work['title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($work['meta_description'] ?: $work['description']) ?>">
    <meta name="twitter:image" content="<?= $work['meta_twitter_image'] ? 'https://weburea.com/' . $work['meta_twitter_image'] : 'https://weburea.com/' . ($work['image'] ?: 'assets/images/portfolio/list/04.jpg') ?>">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CreativeWork",
      "name": "<?= htmlspecialchars($work['title']) ?>",
      "description": "<?= htmlspecialchars($work['meta_description'] ?: $work['description']) ?>",
      "image": "https://weburea.com/<?= $work['image'] ?>",
      "author": {
        "@type": "Organization",
        "name": "Weburea Agency"
      },
      "genre": "<?= htmlspecialchars($work['service_name']) ?>",
      "datePublished": "<?= $work['created_at'] ?>"
    }
    </script>

    <!-- Dark mode -->
    <?php include('include/dark_mode.php') ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/aos/aos.css">
    

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/comparison-slider.css">



</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php'); ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>
    <?php
    $heroMap = [
        'web-development' => 'hero-web-qa.php',
        'software-qa' => 'hero-web-qa.php',
        'ui-ux-design' => 'hero-ui-ux.php',
        'video-editing-production' => 'hero-video-editing.php',
        'video-editing' => 'hero-video-editing.php',
        'video-production' => 'hero-video-editing.php',
        'digital-marketing-ads' => 'hero-digital-marketing.php',
        'digital-marketing' => 'hero-digital-marketing.php'
    ];
    $heroFile = 'include/work_services/' . ($heroMap[$work['service_slug']] ?? 'hero-standard.php');
    if (file_exists($heroFile)) {
        include($heroFile);
    } else {
        include('include/work_services/hero-standard.php');
    }
    ?>
    <!-- ============ Portfolio Body Sections START =========-->
    <?php
    $bodyMap = [
        'web-development' => 'body-web-qa.php',
        'software-qa' => 'body-web-qa.php',
        'ui-ux-design' => 'body-ui-ux.php',
        'motion-animation' => 'body-motion.php',
        'video-editing-production' => 'body-video-editing.php',
        'video-editing' => 'body-video-editing.php',
        'video-production' => 'body-video-editing.php',
        'digital-marketing-ads' => 'body-digital-marketing.php',
        'digital-marketing' => 'body-digital-marketing.php'
    ];
    $bodyFile = 'include/work_services/' . ($bodyMap[$work['service_slug']] ?? 'body-standard.php');
    if (file_exists($bodyFile)) {
        include($bodyFile);
    } else {
        include('include/work_services/body-standard.php');
    }
    ?>
    <!-- ============ Portfolio Body Sections END =========-->

        <!-- =======================
Project Testimonials START -->
        <section class="py-10 mt-10 ">
           
            <div class="container">
                <div class="row align-items-center">
                    <!-- Title and slider button -->
                    <div class="col-lg-4 text-center text-lg-start">
                        <h2 class="mb-3 mb-lg-4">What our clients say about this project</h2>
                        <!-- Rating -->
                        <ul
                            class="avatar-group align-items-center justify-content-center justify-content-lg-start mb-2">
                            <li class="avatar avatar-sm">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-sm">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-sm">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-sm">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-sm">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar">
                            </li>
                        </ul>
                        <p>Rated <span class="badge bg-dark">4.9/5.0</span> by over 100.000+ users</p>
                    </div>

                    <div class="col-lg-8 col-xl-7 ms-auto">
                        <!-- Slider START -->
                        <div class="swiper mt-2 mt-md-4" data-swiper-options='{
                    "spaceBetween": 30,
                    "autoplay":{
                        "delay": 4000, 
                        "disableOnInteraction": false,
                        "pauseOnMouseEnter": true
                    },
                    "navigation":{
                        "nextEl":".swiper-button-next-test",
                        "prevEl":".swiper-button-prev-test"
                    }}'>

                            <div class="swiper-wrapper">
                                <?php if (empty($testimonials)): ?>
                                    <div class="swiper-slide text-center p-5">
                                        <p class="text-muted">No testimonials available for this project yet.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($testimonials as $t): ?>
                                        <!-- Testimonial item -->
                                        <div class="swiper-slide">
                                            <div class="card bg-secondary bg-opacity-50 rounded-4 overflow-hidden border border-white border-opacity-10">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        <!-- Image -->
                                                        <img src="<?= $t['image'] ?: 'assets/images/avatar/01.jpg' ?>" class="rounded-start w-100 object-fit-cover"
                                                            style="aspect-ratio: 1/1;"
                                                            alt="<?= htmlspecialchars($t['author']) ?>">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <!-- Content -->
                                                        <div class="card-body d-flex flex-column h-100 p-xl-4">
                                                            <!-- Rating star -->
                                                            <ul class="list-inline mb-2">
                                                                <li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
                                                                <li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
                                                                <li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
                                                                <li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
                                                                <li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
                                                            </ul>
                                                            <p class="heading-color">"<?= htmlspecialchars($t['text']) ?>"</p>
    
                                                            <!-- Info -->
                                                            <div class="mt-auto">
                                                                <p class="lead heading-color fw-semibold mb-0"><?= htmlspecialchars($t['author']) ?></p>
                                                                <small><?= htmlspecialchars($t['role']) ?></small>
                                                            </div>
    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Slider arrow -->
                            <div
                                class="d-flex justify-content-between position-absolute top-50 start-50 translate-middle w-100 z-index-2">
                                <a href="#"
                                    class="btn btn-dark btn-icon btn-lg rounded-circle mb-0 swiper-button-prev-test rtl-flip ms-2"><i
                                        class="bi bi-arrow-left"></i></a>
                                <a href="#"
                                    class="btn btn-dark btn-icon btn-lg rounded-circle mb-0 swiper-button-next-test rtl-flip me-2"><i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        <!-- Slider END -->
                    </div>
                </div> <!-- Row END -->
            </div>
        </section>
        <!-- =======================
        Testimonials web development END -->


        <!-- Pricing  -->
        <section class="price-wrap overflow-hidden pt-0 mt-4 pb-10" id="dynamic-pricing-section">
            <div class="container">
                <div class="row">
                    <!-- Contents and tabs -->
                    <div class="col-xl-8 position-relative">

                        <!-- hand decoration -->
                        <div class="position-absolute end-0 top-0 me-xl-n4 z-index-2 d-none d-sm-block" style="margin-top: 180px; margin-right: -40px;">
                            <img src="assets/images/elements/money-hand.png" alt="decoration" style="max-height: 200px; transform: rotate(-15deg);">
                        </div>

                        <!-- Title and content -->
                        <div class="inner-container-small ms-0 mb-4 mb-lg-6">
                            <h2 class="mb-sm-4">Affordable solutions for every budget</h2>
                            <p>Need guidance? <a href="#" class="link-purple hover-underline-animation fw-bold">Reserve a
                                    20-minute call</a></p>
                        </div>

                        <!-- Static Service Indicator -->
                        <div class="mb-4">
                            <label class="small text-uppercase fw-bold text-muted mb-2" style="letter-spacing: 1px;">Pick this package</label>
                            <div class="premium-service-indicator">
                                <img src="<?= htmlspecialchars($work['icon_3d'] ?? '') ?>" alt="service icon" class="me-2" style="width: 32px; height: 32px; object-fit: contain;">
                                <span class="fw-bold text-white"><?= htmlspecialchars($work['service_name'] ?? 'General Service') ?></span>
                            </div>
                        </div>

                        <!-- Price change switch -->
                        <form class="d-flex align-items-center mb-5">
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
                    <div class="col-xl-4 mt-5 mt-xl-8">
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
                const tabsList = document.getElementById('pricingTabs');
                const tabsContent = document.getElementById('pricingTabContent');
                const annualToggle = document.getElementById('annualToggle');
                const currentWorkServiceId = <?= json_encode($work['service_id'] ?? null) ?>;
                
                let currentServiceId = currentWorkServiceId;

                // Render Plans
                function renderPlans(serviceId) {
                    if (!serviceId) return;
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
                        
                        // Icon mapping based on standard plan names
                        let icon = 'assets/images/elements/rocket.png';
                        const n = plan.name.toLowerCase();
                        if (n.includes('basic') || n.includes('starter')) icon = 'assets/images/elements/rocket.png';
                        else if (n.includes('standard') || n.includes('pro')) icon = 'assets/images/elements/thunder.png';
                        else if (n.includes('business') || n.includes('premium')) icon = 'assets/images/elements/fire.png';
                        else if (n.includes('enterprise')) icon = 'assets/images/elements/ufo.png';

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

                // Initial Load
                if (currentWorkServiceId) {
                    renderPlans(currentWorkServiceId);
                }
            });
        </script>
        <!-- Pricing END -->


        
<!-- =======================
Related works Start -->
<section class="pb-2 mt-2">
	<div class="container">
		<!-- Title -->
		<h3 class="mb-4">Related works</h3>

		<!-- Slider START -->
		<div class="swiper" data-swiper-options='{ 
				"loop": false,
				"spaceBetween": 40,
				"pagination":{
					"el":".swiper-pagination"
				},
				"breakpoints": {
					"576": {"slidesPerView": 1}, 
					"768": {"slidesPerView": 2},
					"1200": {"slidesPerView": 3}
				}}'>

			<div class="swiper-wrapper">
                        <?php foreach ($relatedWorks as $rw): 
                            $rwImage = $rw['image'] ?: 'assets/images/portfolio/list/04.jpg';
                            $isVid = preg_match('/\.(mp4|webm|mov|ogg)$/i', $rwImage);
                        ?>
                        <!-- Slider item -->
                        <div class="swiper-slide">
                            <div class="card card-img-scale bg-transparent overflow-hidden">
                                <div class="card-img-scale-wrapper rounded-3 overflow-hidden" style="aspect-ratio: 1/1;">
                                    <?php if ($isVid): ?>
                                        <video src="<?= htmlspecialchars($rwImage) ?>" class="img-scale w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($rwImage) ?>" class="img-scale w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($rw['title']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body px-0 pb-0">
                                    <h6 class="mb-0"><a href="work-view.php?id=<?= $rw['id'] ?>" class="heading-color stretched-link"><?= htmlspecialchars($rw['title']) ?></a></h6>
                                    <small><?= htmlspecialchars($rw['categories']) ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
			</div>

			<!-- Slider Pagination -->
			<div class="swiper-pagination swiper-pagination-primary position-relative mt-4"></div>
		</div>
		<!-- Slider END -->
	</div>	
</section>
<!-- =======================
Related works END -->

        <!-- =======================
CTA START -->
        <section class="pt-0 mt-6">
            <div class="container">
                <div class="bg-secondary position-relative rounded-3 overflow-hidden p-4 p-sm-6">
                    <!-- BG pattern -->
                    <div class="position-absolute end-0 top-0 rotate-343 mt-n5 me-n8">
                        <img src="assets/images/elements/grad-shape/05.png" class="h-200px h-sm-300px h-lg-500px"
                            alt="bg pattern">
                    </div>

                    <!-- BG pattern -->
                    <div class="position-absolute start-0 top-0 rotate-343 mt-n5 ms-n6">
                        <img src="assets/images/elements/grad-shape/11.png" class="h-200px blur-2" alt="bg pattern">
                    </div>

                    <div class="row g-4 align-items-center position-relative">
                        <!-- Title and list -->
                        <div class="col-xl-8">
                            <h5 class="fw-light">Have a project in mind?</h5>
                            <h2 class="h1 fw-bold">Let’s get to<span class="text-primary-grad"> work.</span></h2>
                        </div>

                        <!-- Button -->
                        <div class="col-xl-4 text-xl-end">
                            <a href="#" class="btn btn-dark mb-0">Get in touch</a>
                        </div>
                    </div>
                </div>
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
    <script src="assets/vendor/glightbox/js/glightbox.js"></script>
    <script src="assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/comparison-slider.js"></script>

    <!-- Swiper synchronization script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for a small timeout to ensure functions.js has initialized swipers
            setTimeout(function() {
                const imageSwiperEl = document.querySelector('#stepsImageSwiper');
                const contentSwiperEl = document.querySelector('#stepsContentSwiper');
                
                if (imageSwiperEl && contentSwiperEl && imageSwiperEl.swiper && contentSwiperEl.swiper) {
                    const imageSwiper = imageSwiperEl.swiper;
                    const contentSwiper = contentSwiperEl.swiper;
                    
                    // Link them using event listeners for 100% reliable synchronization
                    imageSwiper.on('slideChange', function () {
                        contentSwiper.slideTo(imageSwiper.activeIndex);
                    });
                    contentSwiper.on('slideChange', function () {
                        imageSwiper.slideTo(contentSwiper.activeIndex);
                    });
                    
                    console.log('Swipers synchronized successfully with events');
                }

                // Initialize Product Screens Swiper manually to ensure mobile swipe and pagination
                const productSwiperEl = document.querySelector('.product-screens-swiper');
                if (productSwiperEl && !productSwiperEl.swiper) {
                    const options = JSON.parse(productSwiperEl.getAttribute('data-swiper-options') || '{}');
                    new Swiper(productSwiperEl, options);
                    console.log('Product Screens Swiper initialized manually');
                }
            }, 500);
        });
    </script>

</body>

</html>