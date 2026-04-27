<?php
require_once('db.php');
$footer_cols = ['footer_col_1' => [], 'footer_col_2' => [], 'footer_col_3' => [], 'footer_social' => []];
try {
    $stmtFooter = $pdo->query("SELECT * FROM site_components WHERE component_type LIKE 'footer_%' AND status = 'active' ORDER BY sort_order ASC, id ASC");
    $footer_items = $stmtFooter->fetchAll(PDO::FETCH_ASSOC);
    foreach($footer_items as $item) {
        $footer_cols[$item['component_type']][] = $item;
    }
} catch (Exception $e) {}
?>
<footer class="bg-dark position-relative pt-6 pt-lg-8" data-bs-theme="dark">

    <!-- Shape decoration -->
    <div class="position-absolute top-0 end-0 mt-n8 z-index-9 d-none d-md-block">
        <img src="assets/images/elements/grad-shape/06.png" class="w-250px" alt="Shape">
    </div>

    <div class="container position-relative">
        <div class="row mb-4 mb-lg-7">
            <!-- Logo -->
            <div class="col-lg-3 col-xl-4 mb-4 mb-lg-0">
                <!-- logo -->
                <a class="me-0" href="index.html">
                    <img class="h-40px" src="assets/images/logo-light.svg" alt="logo">
                </a>
            </div>

            <!-- CTA -->
            <div class="col-lg-9 col-xl-7 ms-md-auto">
                <div class="bg-white d-md-flex justify-content-between align-items-center rounded-4 p-4"
                    style="--bs-bg-opacity:0.05">
                    <h5 class="mb-3 mb-md-0"><span class="hand-wave-animate">🖐️</span> Let's innovate together</h5>
                    <a href="contact-us-v1.html" class="btn btn-sm btn-primary-grad text-nowrap mb-0">Start
                        innovating</a>
                </div>
            </div>
        </div>

        <!-- Link widgets -->
        <div class="row">
            <div class="col-xl-8">
                <div class="row g-4">
                    <!-- Widget item -->
                    <div class="col-sm-6 col-md-4">
                        <h6 class="mb-0">Company</h6>
                        <hr class="opacity-1 my-md-4"> <!-- Divider -->
                        <ul class="nav flex-column gap-1">
                            <?php foreach($footer_cols['footer_col_1'] as $item): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>">
                                    <?php if($item['icon']): ?><i class="<?php echo htmlspecialchars($item['icon']); ?> me-2"></i><?php endif; ?>
                                    <?php echo htmlspecialchars($item['label']); ?>
                                    <?php if($item['badge_text']): ?>
                                        <span class="badge <?php echo htmlspecialchars($item['badge_class']); ?> ms-2"><?php echo htmlspecialchars($item['badge_text']); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Widget item -->
                    <div class="col-sm-6 col-md-4">
                        <h6 class="mb-0">Resources</h6>
                        <hr class="opacity-1 my-md-4"> <!-- Divider -->
                        <ul class="nav flex-column gap-1">
                            <?php foreach($footer_cols['footer_col_2'] as $item): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>">
                                    <?php if($item['icon']): ?><i class="<?php echo htmlspecialchars($item['icon']); ?> me-2"></i><?php endif; ?>
                                    <?php echo htmlspecialchars($item['label']); ?>
                                    <?php if($item['badge_text']): ?>
                                        <span class="badge <?php echo htmlspecialchars($item['badge_class']); ?> ms-2"><?php echo htmlspecialchars($item['badge_text']); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Widget item -->
                    <div class="col-sm-6 col-md-4">
                        <h6 class="mb-0">Community</h6>
                        <hr class="opacity-1 my-md-4"> <!-- Divider -->
                        <ul class="nav flex-column gap-1">
                            <?php foreach($footer_cols['footer_col_3'] as $item): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>">
                                    <?php if($item['icon']): ?><i class="<?php echo htmlspecialchars($item['icon']); ?> me-2"></i><?php endif; ?>
                                    <?php echo htmlspecialchars($item['label']); ?>
                                    <?php if($item['badge_text']): ?>
                                        <span class="badge <?php echo htmlspecialchars($item['badge_class']); ?> ms-2"><?php echo htmlspecialchars($item['badge_text']); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Widget item -->
            <div class="col-xl-4 mt-6 mt-xl-0">
                <h6 class="mb-0">Download our app</h6>

                <hr class="opacity-1 my-md-4"> <!-- Divider -->
                <p>Get instant access to exclusive features for FREE!</p>

                <div class="row g-2 mt-2 mb-4 mb-sm-5">
                    <!-- Google play store button -->
                    <div class="col-5 col-sm-3 col-lg-2 col-xl-4">
                        <a href="#"> <img src="assets/images/elements/google-play.svg" alt=""> </a>
                    </div>
                    <!-- App store button -->
                    <div class="col-5 col-sm-3 col-lg-2 col-xl-4">
                        <a href="#"> <img src="assets/images/elements/app-store.svg" alt="app-store"> </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="mt-xl-5 mb-0 opacity-1">

        <!-- Bottom footer -->
        <div class="d-md-flex justify-content-between align-items-center text-center text-lg-start py-4">
            <!-- copyright text -->
            <div class="text-body small mb-3 mb-md-0"> Copyrights ©2025 Weburea. Build by <a href="#" target="_blank"
                    class="text-body text-primary-hover hover-underline-animation">Weburea Team</a>. </div>
            <!-- copyright links-->

            <!-- Social link -->
            <ul class="list-inline mb-0">
                <?php foreach($footer_cols['footer_social'] as $social): ?>
                <li class="list-inline-item"> 
                    <a class="btn btn-xs btn-icon btn-secondary" href="<?php echo htmlspecialchars($social['url']); ?>" <?php if(strpos($social['url'], '#') !== 0) echo 'target="_blank"'; ?>>
                        <i class="<?php echo htmlspecialchars($social['icon']); ?> lh-base"></i>
                    </a> 
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</footer>