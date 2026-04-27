<!DOCTYPE html>
<html lang="en">

<head>

    <title>Pricing Plans — Weburea Agency | Flexible Design & Tech Packages</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <meta name="description"
        content="View transparent pricing for UI/UX design, branding, web development, and QA testing. Choose flexible full-cycle packages or individual service rates. Scale your business with Weburea.">

    <meta name="keywords"
        content="Weburea Pricing, UI UX Design Cost Lagos, Web Development Packages Nigeria, Branding Agency Rates, Motion Graphics Pricing, Software Testing Rates, QA Service Cost, Digital Agency Retainers, Flexible Design Plans">

    <meta name="author" content="Weburea Agency">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://weburea.com/pricing">
    <meta property="og:title" content="Pricing Plans — Weburea Agency | Flexible Design & Tech Packages">
    <meta property="og:description"
        content="Transparent pricing for creative and tech services. From full product builds to specific design tasks. See our flexible plans.">
    <meta property="og:image" content="https://weburea.com/assets/images/pricing-preview-card.jpg">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://weburea.com/pricing">
    <meta property="twitter:title" content="Pricing Plans — Weburea Agency">
    <meta property="twitter:description"
        content="Transparent pricing for creative and tech services. Scale with Weburea.">
    <meta property="twitter:image" content="https://weburea.com/assets/images/pricing-preview-card.jpg">

    <!-- Dark mode -->

    <?php include('include/dark_mode.php'); ?>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?> <!-- Header END -->

    <?php
    require_once('include/db.php');
    $stmt = $pdo->prepare("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
    $stmt->execute();
    $services = $stmt->fetchAll();

    // Fetch dynamic Enterprise Section
    $entStmt = $pdo->prepare("SELECT section_content FROM homepage_sections WHERE section_key = 'pricing_enterprise' AND status = 'active'");
    $entStmt->execute();
    $entRow = $entStmt->fetch();
    $enterprise = $entRow ? json_decode($entRow['section_content'], true) : null;
    ?>

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================Pricing  START ===========-->
        <section class="bg-secondary position-relative pt-xl-8 pb-0 mb-n4 overflow-hidden">
            <div class="position-absolute end-0 top-0 mt-6 me-n6 z-index-2 d-none d-md-block">
                <img src="assets/images/elements/clay-decoration.png" class="h-400px" alt="Clay-decoration">
            </div>

            <div class="position-absolute top-0 start-50 mt-n9 ms-n9">
                <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-8 opacity-1"
                    alt="Grad shape">
            </div>

            <div class="position-absolute start-0 top-0">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg"
                    class="opacity-1 blur-8 h-300px rotate-335" alt="Grad shape">
            </div>

            <div class="container position-relative z-index-2 pt-4 pt-sm-5">
                <div class="inner-container-small text-center mb-5 mb-sm-7">
                    <nav class="mb-2 d-flex justify-content-center" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                        </ol>
                    </nav>

                    <h1 class="mb-0">Affordable <span class="text-primary">pricing</span></h1>
                    <p class="lead text-muted mt-2">Choose a service category to view detailed packages and individual
                        rates.</p>
                </div>

                <div class="row g-4 g-lg-5 justify-content-center">

                    <?php foreach ($services as $service):
                        // Fetch the lowest numeric price for this service
                        $priceStmt = $pdo->prepare("SELECT price FROM pricing_plans WHERE service_id = ? AND is_custom = 0 AND status = 'active' AND price NOT LIKE '%Custom%' ORDER BY CAST(REPLACE(REPLACE(price, ',', ''), '$', '') AS UNSIGNED) ASC LIMIT 1");
                        $priceStmt->execute([$service['id']]);
                        $priceRow = $priceStmt->fetch();

                        $minPrice = 'Custom';

                        if ($priceRow) {
                            $rawPrice = $priceRow['price'];
                            // Clean comma and check if numeric
                            $cleanPrice = str_replace([',', '$'], '', $rawPrice);
                            if (is_numeric($cleanPrice) && (float)$cleanPrice > 0) {
                                $minPrice = '$' . number_format((float) $cleanPrice, 0, '.', ',');
                            } else {
                                $minPrice = $rawPrice;
                            }
                        }

                        // Parse home_list_expert (Available Sub-Services)
                        $subServices = json_decode($service['home_list_expert'], true) ?: [];

                        // Extract icon and color (mapping logic or just use icon_3d)
                        // For simplicity in this layout, we'll try to map common icons or use a default
                        $iconClass = 'bi-gear-fill';
                        $bgColor = 'bg-primary';
                        $textColor = 'text-primary';

                        // Simple mapping based on slug
                        if (strpos($service['slug'], 'design') !== false) {
                            $iconClass = 'bi-palette-fill';
                            $bgColor = 'bg-primary';
                            $textColor = 'text-primary';
                        } elseif (strpos($service['slug'], 'brand') !== false) {
                            $iconClass = 'bi-bezier2';
                            $bgColor = 'bg-warning';
                            $textColor = 'text-warning';
                        } elseif (strpos($service['slug'], 'motion') !== false) {
                            $iconClass = 'bi-film';
                            $bgColor = 'bg-purple';
                            $textColor = 'text-purple';
                        } elseif (strpos($service['slug'], 'qa') !== false || strpos($service['slug'], 'test') !== false) {
                            $iconClass = 'bi-bug-fill';
                            $bgColor = 'bg-info';
                            $textColor = 'text-info';
                        } elseif (strpos($service['slug'], 'dev') !== false) {
                            $iconClass = 'bi-code-slash';
                            $bgColor = 'bg-success';
                            $textColor = 'text-success';
                        } elseif (strpos($service['slug'], 'marketing') !== false || strpos($service['slug'], 'ad') !== false) {
                            $iconClass = 'bi-graph-up-arrow';
                            $bgColor = 'bg-primary';
                            $textColor = 'text-primary';
                        } elseif (strpos($service['slug'], 'video') !== false) {
                            $iconClass = 'bi-camera-reels-fill';
                            $bgColor = 'bg-danger';
                            $textColor = 'text-danger';
                        }
                        ?>
                        <div class="col-xl-10 mx-auto">
                            <div
                                class="card card-hover-shadow card-hover-transition bg-body bg-opacity-75 rounded-4 p-4 p-sm-5">
                                <div class="row g-4 g-md-0">
                                    <div class="col-md-6">
                                        <div
                                            class="icon-xl <?php echo $bgColor; ?> bg-opacity-10 <?php echo $textColor; ?> rounded-circle mb-4 d-flex align-items-center justify-content-center">
                                            <i class="bi <?php echo $iconClass; ?> fs-3"></i>
                                        </div>
                                        <p class="lead heading-color fw-semibold mb-2">
                                            <?php echo htmlspecialchars($service['name']); ?>
                                        </p>
                                        <p class="mb-2"> <span class="h1 mb-0"><?php echo $minPrice; ?></span>
                                            <?php echo (is_numeric(str_replace(['$', ','], '', $minPrice))) ? '/plan' : ''; ?>
                                        </p>
                                        <p class="mb-0"><?php echo htmlspecialchars($service['description_short']); ?></p>
                                    </div>

                                    <div class="col-md-5 ms-auto">
                                        <div class="card-body d-flex flex-column h-100 p-0">
                                            <span class="fw-semibold opacity-6 mb-1 mb-md-3">Available Sub-Services</span>
                                            <div class="row g-2">
                                                <?php foreach ($subServices as $sub): ?>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex align-items-center heading-color">
                                                            <i
                                                                class="bi bi-check-circle-fill <?php echo $textColor; ?> opacity-50 me-2 fs-6"></i>
                                                            <span
                                                                class="small fw-medium"><?php echo htmlspecialchars($sub); ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <a class="btn btn-dark icon-link icon-link-hover justify-content-center mb-0 mt-4"
                                                href="main-pricing.php?service=<?php echo urlencode($service['slug']); ?>">View
                                                Plans<i class="bi bi-arrow-right"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($enterprise): ?>
                        <div class="col-xl-10 mx-auto">
                            <div class="card card-hover-shadow card-hover-transition bg-primary-grad rounded-4 p-4 p-sm-5"
                                data-bs-theme="dark">
                                <div class="row g-4 g-md-0">
                                    <div class="col-md-6">
                                        <div class="icon-xl bg-dark rounded-circle mb-4">
                                            <img src="<?= htmlspecialchars($enterprise['icon_img'] ?? 'assets/images/elements/thunder.png') ?>" class="h-40px" alt="rocket image">
                                        </div>
                                        <p class="lead heading-color fw-semibold mb-2"><?= htmlspecialchars($enterprise['title'] ?? 'Enterprise plan') ?></p>
                                        <p class="h1 heading-color mb-2"><?= htmlspecialchars($enterprise['price_text'] ?? 'Custom') ?></p>
                                        <p class="mb-0"><?= htmlspecialchars($enterprise['description'] ?? '') ?></p>
                                    </div>

                                    <div class="col-md-5 ms-auto">
                                        <div class="card-body d-flex flex-column h-100 p-0">
                                            <span class="fw-semibold mb-1 mb-md-3"><?= htmlspecialchars($enterprise['features_title'] ?? 'Quick look at all the features') ?></span>
                                            <ul class="list-group list-group-borderless mb-3">
                                                <?php foreach (($enterprise['features'] ?? []) as $feature): ?>
                                                    <li class="list-group-item d-flex heading-color mb-0">
                                                        <i class="bi bi-check-lg text-white me-1"></i><?= htmlspecialchars($feature) ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <a class="btn btn-white icon-link icon-link-hover justify-content-center mb-0"
                                                href="<?= htmlspecialchars($enterprise['btn_link'] ?? '#') ?>"><?= htmlspecialchars($enterprise['btn_text'] ?? 'Contact us') ?><i class="bi bi-arrow-right"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
            </div>

            <span class="position-absolute bottom-0 start-0">
                <svg class="text-dark" width="1920" height="73" viewBox="0 0 1920 73" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0L1920 61.5V73H0V0Z" fill="currentColor"></path>
                </svg>
            </span>
        </section>


        <!-- ======================Pricing END =========== -->

        <!-- =======================
 Benefits START -->
        <section class="bg-dark overflow-hidden position-relative" data-bs-theme="dark">
            <!-- Blur decoration -->
            <div class="position-absolute bottom-0 end-0 mb-n8">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9"
                    alt="Grad shape">
            </div>

            <div class="container position-relative">
                <div class="row g-4">
                    <!-- Key Benefits -->
                    <div class="col-lg-4">
                        <p class="heading-color">Key benefits</p>
                        <!-- List -->
                        <ul class="list-group list-group-borderless mb-4">
                            <li class="list-group-item heading-color lead d-flex"><i
                                    class="bi bi-wallet2 text-primary me-2"></i>No hidden fees</li>
                            <li class="list-group-item heading-color lead d-flex"><i
                                    class="bi bi-headset text-pink me-2"></i>24/7 Customer support</li>
                            <li class="list-group-item heading-color lead d-flex"><i
                                    class="bi bi-rocket-takeoff text-warning me-2"></i>Easy upgrade & downgrade</li>
                            <li class="list-group-item heading-color lead d-flex"><i
                                    class="bi bi-clock-history text-success me-2"></i>You can cancel anytime</li>
                        </ul>
                    </div>

                    <!-- Skill sets and blockquote -->
                    <div class="col-lg-6 ms-auto">
                        <!-- Skill sets -->
                        <div class="row g-4 g-lg-6 mb-5">
                            <div class="col-sm-6">
                                <h3 class="border-start border-primary border-2 ps-4 mb-3">2,000+</h3>
                                <p class="mb-0">Customers have used our awesome templates since 2019</p>
                            </div>

                            <div class="col-sm-6">
                                <h3 class="border-start border-primary border-2 ps-4 mb-3">85+</h3>
                                <p class="mb-0">Client's projects complete all over the world</p>
                            </div>
                        </div>

                        <!-- Blockquote -->
                        <blockquote class="d-flex">
                            <!-- Avatar -->
                            <div class="avatar avatar-lg me-3 flex-shrink-0">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
                            </div>
                            <div>
                                <p class="lead heading-color fw-normal">"We believe that it takes great people
                                    to
                                    deliver a great product"</p>
                                <div class="blockquote-footer mb-0">
                                    By Albert Schweitzer
                                </div>
                            </div>
                        </blockquote>
                    </div>

                </div>
            </div>
        </section>
        <!-- =======================
 Benefits END -->

        <!-- =======================
 Faq START -->
        <section class="position-relative overflow-hidden">
            <!-- Grad shape decoration -->
            <div class="position-absolute start-0 bottom-0 mb-n7 ms-n7 d-none d-md-block">
                <img src="assets/images/elements/grad-shape/05.png" class="h-md-300px h-xl-400px h-xxl-500px"
                    alt="grad shape">
            </div>

            <div class="container position-relative">
                <div class="row g-4">

                    <!-- Title -->
                    <div class="col-md-4">
                        <h2 class="mb-3">Frequently Asked Questions</h2>
                        <p class="mb-0">Our team is ready to assist you! Start a chat for quick support. <a href="#"
                                class="hover-underline-animation fw-semibold">Talk to Us</a></p>
                    </div>

                    <!-- Faqs -->
                    <div class="col-md-7 ms-auto">
                        <!-- Accordion START -->
                        <div class="accordion accordion-icon accordion-border-bottom" id="accordionFaq">
                            <!-- Item -->
                            <div class="accordion-item mb-3">
                                <div class="accordion-header font-base" id="heading-1">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true"
                                        aria-controls="collapse-1">
                                        <span class="lead heading-color">What payment methods do you accept?</span>
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    aria-labelledby="heading-1" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pb-0">
                                        We accept all major credit cards, PayPal, and bank transfers for custom
                                        plans.
                                        Our expert team will turn your concept into a working prototype within 24
                                        hours,
                                        ensuring rapid progress and immediate feedback.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-3">
                                <div class="accordion-header font-base" id="heading-2">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false"
                                        aria-controls="collapse-2">
                                        <span class="lead heading-color">Can I change my plan later?</span>
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pb-0">
                                        Yes, you can upgrade or downgrade your plan at any time from your account
                                        settings. We provide a range of tools, guides, and best practices to help
                                        you
                                        create designs, websites.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-3">
                                <div class="accordion-header font-base" id="heading-3">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false"
                                        aria-controls="collapse-3">
                                        <span class="lead heading-color">Is there a free trial available?</span>
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pb-0">
                                        Yes, we offer a 14-day free trial for our Basic and Standard plans. No
                                        credit
                                        card required.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-3">
                                <div class="accordion-header font-base" id="heading-4">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false"
                                        aria-controls="collapse-4">
                                        <span class="lead heading-color">How does customer support work?</span>
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pb-0">
                                        Our Basic plan includes email support, while the Standard and Custom plans
                                        offer
                                        priority email and dedicated account manager support, respectively.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-3">
                                <div class="accordion-header font-base" id="heading-5">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-5" aria-expanded="false"
                                        aria-controls="collapse-5">
                                        <span class="lead heading-color">Are there any setup fees?</span>
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-5" class="accordion-collapse collapse" aria-labelledby="heading-5"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pb-0">
                                        No, there are no setup fees for any of our plans. You only pay the monthly
                                        subscription fee. We provide a range of tools, guides, and best practices to
                                        help you create designs, websites.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion END -->
                    </div>

                </div>
            </div>
        </section>
        <!-- =======================
 Faq END -->

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

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>