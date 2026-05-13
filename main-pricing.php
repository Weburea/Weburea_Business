<?php
require_once('include/db.php');
$serviceSlug = isset($_GET['service']) ? $_GET['service'] : 'product-design-ui-ux'; // Default or error handle

// Fetch service
$stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? AND status = 'active'");
$stmt->execute([$serviceSlug]);
$service = $stmt->fetch();

if (!$service) {
    // Fallback or redirect if service not found
    $stmt = $pdo->prepare("SELECT * FROM services WHERE status = 'active' LIMIT 1");
    $stmt->execute();
    $service = $stmt->fetch();
}

// Fetch pricing plans
$planStmt = $pdo->prepare("SELECT * FROM pricing_plans 
                           WHERE service_id = ? AND status = 'active' 
                           ORDER BY is_custom ASC, 
                           CASE 
                             WHEN name LIKE '%Basic%' THEN 1 
                             WHEN name LIKE '%Standard%' THEN 2 
                             WHEN name LIKE '%Pro%' OR name LIKE '%Premium%' OR name LIKE '%Business%' THEN 3 
                             WHEN name LIKE '%Enterprise%' THEN 4 
                             ELSE 5 
                           END ASC");
$planStmt->execute([$service['id']]);
$plans = $planStmt->fetchAll();

$compareFeatures = json_decode($service['comparison_features_json'] ?? '[]', true);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="icon" type="image/png" href="assets/images/favicon/Vector.ico">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea Agency">

    <title><?php echo htmlspecialchars($service['name']); ?> Pricing — Weburea Agency | Packages & Rates</title>
    <meta name="description" content="<?php echo htmlspecialchars($service['description_short']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($service['name']); ?> Cost, <?php echo htmlspecialchars($service['name']); ?> Packages, Weburea Pricing">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://weburea.com/main-pricing.php?service=<?php echo $service['slug']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($service['name']); ?> Pricing — Weburea Agency">
    <meta property="og:description" content="<?php echo htmlspecialchars($service['description_short']); ?>">
    <meta property="og:image" content="<?php echo $service['icon_3d']; ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($service['name']); ?> Pricing — Weburea Agency">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($service['description_short']); ?>">
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

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <section class="price-wrap position-relative overflow-hidden pt-xl-8">
            <!-- Grad blur -->
            <div
                class="bg-primary-grad blur-9 h-300px w-100 opacity-2 position-absolute top-0 start-50 translate-middle-x mt-n7">
            </div>
            <!-- Title and switch -->
            <div class="container position-relative z-index-2 pt-4 pb-6 pb-xl-8">
                <!-- Breadcrumb -->
                <nav class="mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="pricing.php">Pricing</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($service['name']); ?></li>
                    </ol>
                </nav>

                <!-- Title -->
                <h3>Flexible Pricing</h3>
                <h1 class="fw-bold mb-4">For <span class="text-primary-grad"><?php echo htmlspecialchars($service['name']); ?></span> Service</h1>

                <!-- Switch -->
                <form
                    class="bg-body shadow-primary border border-primary d-inline-flex align-items-center rounded-3 p-3 px-sm-4 py-sm-3"
                    style="--bs-border-opacity: 0.20;">
                    <!-- Label -->
                    <span class="fw-semibold heading-color">Single Project</span>
                    <!-- Switch -->
                    <div class="form-check form-switch form-check-lg mx-2 mb-0">
                        <input class="form-check-input mt-0 price-toggle" type="checkbox" id="flexSwitchCheckDefault">
                    </div>
                    <!-- Label -->
                    <span class="fw-semibold heading-color">Multiple Projects</span>
                    <span class="badge bg-success ms-2">20% save</span>
                </form>
            </div>

            <!-- Pricing box START -->
            <div class="container-fluid">
                <div class="max-width-1550">
                    <div class="row">
                        <?php foreach ($plans as $index => $plan): 
                            $planFeatures = json_decode($plan['features_json'] ?? '[]', true);
                            $isRecommended = (bool)$plan['is_recommended'];
                            $isCustom = (bool)$plan['is_custom'];
                            
                            // Define icons and styles based on plan name or index
                            $iconClass = 'bi bi-lightning-charge-fill';
                            $cardClass = 'card shadow overflow-hidden p-1';
                            $headerClass = 'card-header bg-secondary bg-opacity-50 p-4 pb-0';
                            $footerClass = 'card-footer bg-secondary bg-opacity-50 p-4';
                            $btnClass = 'btn btn-dark btn-transition w-100 mt-4';
                            
                            if ($isRecommended) {
                                $cardClass = 'card shadow p-1'; // Removed overflow-hidden
                            }

                            if (stripos($plan['name'], 'Standard') !== false) {
                                $iconClass = 'bi bi-send-fill';
                            } elseif (stripos($plan['name'], 'Premium') !== false || $isRecommended) {
                                $iconClass = 'bi bi-rocket-takeoff-fill';
                                $headerClass = 'card-header bg-secondary-grad rounded-top p-4 pb-0';
                                $footerClass = 'card-footer bg-secondary-grad p-4';
                                $btnClass = 'btn btn-white-shadow w-100 mt-4';
                            } elseif (stripos($plan['name'], 'Business') !== false || $isCustom) {
                                $iconClass = 'bi bi-headset';
                            }
                        ?>
                        <div class="col-md-6 col-xl-3 mb-5 mb-xl-0 pt-4"> <!-- Added pt-4 for badge headroom -->
                            <div class="<?php echo $cardClass; ?> position-relative">
                                <?php if ($isRecommended): ?>
                                    <div class="bg-primary-grad small text-white rounded position-absolute top-0 start-50 translate-middle px-3 py-1">
                                        <?php echo htmlspecialchars($plan['label'] ?: 'Recommended'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Card header -->
                                <div class="<?php echo $headerClass; ?>">
                                    <?php if ($isCustom): ?>
                                         <div class="position-absolute top-0 end-0 mt-n8 me-n5">
                                            <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-7 opacity-2 h-300px" alt="Grad shape">
                                        </div>
                                    <?php endif; ?>

                                    <!-- Icon -->
                                    <div class="icon-lg <?php echo (stripos($plan['name'], 'Premium') !== false || $isRecommended) ? 'bg-pink' : 'bg-body shadow-primary'; ?> rounded-circle mb-3">
                                        <i class="<?php echo $iconClass; ?> fa-lg lh-1 <?php echo (stripos($plan['name'], 'Premium') !== false || $isRecommended) ? 'text-white' : 'heading-color'; ?>"></i>
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
                                            </span>/project
                                        </p>
                                    <?php endif; ?>
                                    <small><?php echo htmlspecialchars($plan['description']); ?></small>
                                    <!-- Button -->
                                    <a href="#" class="<?php echo $btnClass; ?>"><?php echo $isCustom ? 'Request pricing' : 'Get started'; ?></a>
                                </div>

                                <!-- Card footer -->
                                <div class="<?php echo $footerClass; ?>">
                                    <!-- List -->
                                    <ul class="list-group list-group-borderless mb-0">
                                        <?php if (!empty($planFeatures)): ?>
                                            <?php foreach ($planFeatures as $feature): ?>
                                            <li class="list-group-item d-flex heading-color mb-0">
                                                <i class="bi bi-check-lg text-primary me-1"></i>
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
                </div>
            </div>
            <!-- Pricing box END -->
        </section>
        <!-- =======================
Hero END -->

        <!-- =======================
Compare table START -->
        <section class="pt-0 position-relative">
            <div class="position-absolute end-0 top-0 mt-n7 me-6 d-none d-md-block">
                <img src="assets/images/elements/rocket-03.png" class="h-200px" alt="rocket image">
            </div>

            <div class="container">
                <h2 class="text-center mb-0">Compare Plans</h2>
                <p class="text-center text-muted mt-2">Detailed breakdown of UI/UX deliverables.</p>

                <div class="table-responsive-xl mt-2 mt-md-5">
                    <?php if (!empty($compareFeatures)): ?>
                    <table class="table table-striped table-borderless align-middle">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col">
                                    <p class="mb-0 fs-5 heading-color">Features</p>
                                </th>
                                <?php foreach ($plans as $plan): ?>
                                <th scope="col">
                                    <div class="text-center p-3">
                                        <p class="mb-3 heading-color"><?php echo htmlspecialchars($plan['name']); ?></p>
                                        <a href="#" class="btn btn-sm btn-outline-primary mb-0"><?php echo $plan['is_custom'] ? 'Talk to us' : 'Get started'; ?></a>
                                    </div>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <?php foreach ($compareFeatures as $feature): ?>
                            <tr>
                                <th scope="row"><span class="fw-normal heading-color ps-lg-4 mb-0"><?php echo htmlspecialchars($feature); ?></span></th>
                                <?php foreach ($plans as $plan): 
                                    $values = json_decode($plan['comparison_values_json'] ?? '{}', true);
                                    $val = isset($values[$feature]) ? $values[$feature] : '-';
                                    $lowVal = strtolower((string)$val);
                                    $isTrue = in_array($lowVal, ['true', 'yes', '1', 'check', 'included']);
                                    $isFalse = in_array($lowVal, ['false', 'no', '0', 'cross', 'not included', '-']);
                                ?>
                                <td class="text-center">
                                    <?php if ($isTrue): ?>
                                        <span class="text-success"><i class="bi bi-check-circle fa-lg"></i></span>
                                    <?php elseif ($isFalse && $lowVal != '-'): ?>
                                        <span class="text-danger"><i class="bi bi-x-circle fa-lg"></i></span>
                                    <?php else: ?>
                                        <span class="<?php echo $lowVal == 'unlimited' ? 'fw-bold text-success' : ''; ?>">
                                            <?php echo htmlspecialchars($val); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <p class="text-muted">Detailed comparison table coming soon for this service.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row g-4 align-items-center mt-6">
                    <div class="col-lg-3">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                            <h6 class="mb-0">Trusted by leading companies</h6>
                            <div class="vr bg-primary-grad opacity-1 d-none d-lg-block ms-3"></div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="swiper" data-swiper-options='{
                    "slidesPerView": 2, 
                    "spaceBetween": 50,
                    "autoplay": {"delay": 3000},
                    "breakpoints": { 
                        "576": {"slidesPerView": 3}, 
                        "768": {"slidesPerView": 4}, 
                        "1200": {"slidesPerView": 5}
                    }}'>

                            <div class="swiper-wrapper align-items-center">
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/01.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/01.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/01.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/02.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/02.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/02.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/03.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/03.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/03.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/04.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/04.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/04.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/05.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/05.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/05.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swap-logo">
                                        <img src="assets/images/client/logo-gray/06.svg" class="p-2 p-lg-3"
                                            alt="client-img">
                                        <div class="swap-item">
                                            <img src="assets/images/client/logo-light/06.svg"
                                                class="dark-mode-item p-2 p-lg-3" alt="client logo">
                                            <img src="assets/images/client/logo-dark/06.svg"
                                                class="light-mode-item p-2 p-lg-3" alt="client logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Compare table END -->

        <!-- =======================
 Faq START -->
        <section class="bg-secondary bg-opacity-75">
            <div class="container">

                <!-- Title -->
                <div class="inner-container position-relative text-center mb-4 mb-md-5">
                    <h2 class="mb-0">Have questions? (FAQs)</h2>
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
                                        What payment methods do you accept?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    aria-labelledby="heading-1" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0 pt-0">
                                        We accept all major credit cards, PayPal, and bank transfers for custom plans.
                                        Our expert team will turn your concept into a working prototype within 24 hours,
                                        ensuring rapid progress and immediate feedback.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-2">
                                    <button class="accordion-button fw-semibold rounded collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false"
                                        aria-controls="collapse-2">
                                        Can I change my plan later?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Yes, you can upgrade or downgrade your plan at any time from your account
                                        settings. We provide a range of tools, guides, and best practices to help you
                                        create designs, websites.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-3">
                                    <button class="accordion-button fw-semibold collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false"
                                        aria-controls="collapse-3">
                                        Is there a free trial available?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Yes, we offer a 14-day free trial for our Basic and Standard plans. No credit
                                        card required.
                                    </div>
                                </div>
                            </div>

                            <!-- Item -->
                            <div class="accordion-item mb-4">
                                <div class="accordion-header font-base" id="heading-4">
                                    <button class="accordion-button fw-semibold collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false"
                                        aria-controls="collapse-4">
                                        How does customer support work?
                                    </button>
                                </div>
                                <!-- Body -->
                                <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4"
                                    data-bs-parent="#accordionFaq">
                                    <div class="accordion-body pt-0">
                                        Our Basic plan includes email support, while the Standard and Custom plans offer
                                        priority email and dedicated account manager support, respectively.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion END -->

                        <!-- CTA text -->
                        <p class="heading-color text-center">Need help? Our team is ready to assist you. Start a chat
                            for quick support. <a href="#" class="hover-underline-animation fw-semibold">Talk to Us</a>
                        </p>
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

    <!--Vendors-->
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>