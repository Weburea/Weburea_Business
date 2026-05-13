    <!-- ============ Web Development and Software Testing & QA Narrative Sections Start =========-->

    <!-- Tech Stack Logos Start -->
    <?php 
    $techStack = isset($serviceData['tech_stack_json']) ? json_decode($serviceData['tech_stack_json'], true) : [];
    if (!empty($techStack)): ?>
    <div class="inner-container text-center pt-8 mb-5 pt-md-10 pb-0">
        <h4 class="mb-5"><?= htmlspecialchars($serviceData['tech_stack_title'] ?? 'Development stack and QA toolkits we utilize') ?></h4>
        <ul class="list-inline d-flex justify-content-center flex-wrap gap-4 mb-0">
            <?php foreach ($techStack as $item): ?>
            <li class="list-inline-item me-0">
                <div class="icon-xl btn-transition bg-white border border-white border-opacity-10 d-flex justify-content-center align-items-center rounded-2 shadow-sm" style="--bs-bg-opacity:0.05" title="<?= htmlspecialchars($item['name'] ?? '') ?>">
                    <img src="<?= htmlspecialchars($item['icon'] ?? '') ?>" class="h-40px" alt="<?= htmlspecialchars($item['name'] ?? 'icon') ?>">
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <!-- Tech Stack Logos End -->

    <!-- Functionality list offers Start -->
    <section class="bg-dark overflow-hidden position-relative mt-10" data-bs-theme="dark">
        <!-- Background Image -->
        <div class="col-md-8 col-lg-7 col-xl-12 col-xxl-9 position-absolute bottom-0 end-0 me-xl-n9 d-none d-md-block">
            <img src="assets/images/product/feature-bg.png" class="ps-8 position-relative z-index-2" alt="">
        </div>
        <!-- Blur decoration -->
        <div class="position-absolute bottom-50 end-0">
            <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9" alt="Grad shape">
        </div>

        <div class="container py-8 py-md-10">
            <div class="row">
                <div class="col-xl-6">
                    <!-- Title -->
                    <h2 class="mb-4 mb-md-6"><?= htmlspecialchars($serviceData['section_title'] ?? 'High-Performance Development & Rigorous QA') ?></h2>

                    <!-- Features START -->
                    <div class="row g-4 g-lg-5">
                        <?php 
                        $features = isset($serviceData['section_features_json']) ? json_decode($serviceData['section_features_json'], true) : [];
                        foreach ($features as $feature): ?>
                        <div class="col-md-6">
                            <span class="text-primary fs-3"><i class="bi <?= htmlspecialchars($feature['icon'] ?? 'bi-cpu') ?>"></i></span>
                            <h6 class="my-3"><?= htmlspecialchars($feature['title'] ?? 'Feature') ?></h6>
                            <p class="mb-0 small text-muted"><?= htmlspecialchars($feature['desc'] ?? '') ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Features END -->
                </div>
            </div>
        </div>
    </section>
    <!-- Functionality list offers End -->



    <!-- Case Study Narrative START -->
    <section class="pt-10 pt-md-12">
        <div class="container">
            <!-- Overview -->
            <div class="row mb-5 mb-md-8">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">01.</span>
                    <h5 class="mt-2">Overview</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($work['project_overview'] ?? '')) ?></p>
                    <ul class="list-inline mt-4">
                        <?php 
                        $tags = array_filter(array_map('trim', explode(',', $work['categories'] ?? '')));
                        foreach($tags as $tag): ?>
                        <li class="list-inline-item"> <span class="btn btn-light btn-sm mb-lg-0"><?= htmlspecialchars($tag) ?></span> </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Challenge -->
            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">02.</span>
                    <h5 class="mt-2">The Challenge</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p><?= nl2br(htmlspecialchars($work['project_challenge'] ?? '')) ?></p>
                    <?php if (!empty($challengePoints)): ?>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <ul class="list-group list-group-borderless">
                                <div class="row g-2">
                                    <?php foreach($challengePoints as $point): ?>
                                    <div class="col-md-6">
                                        <li class="list-group-item d-flex heading-color"><i class="bi bi-check-circle text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Images Section START -->
    <?php if (!empty($additionalImages)): ?>
    <section class="py-10 mb-8 mb-n9">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <?php 
                // Show first 3 images in a grid
                $firstThree = array_slice($additionalImages, 0, 3);
                foreach($firstThree as $img): ?>
                <div class="col-6 col-md-4">
                    <a href="<?= htmlspecialchars($img) ?>" data-glightbox data-gallery="image-popup">
                        <img src="<?= htmlspecialchars($img) ?>" class="rounded shadow-sm w-100" alt="portfolio-img">
                    </a>
                </div>
                <?php endforeach; ?>

               

                <?php 
                // Show any remaining images (5th onwards)
                if (count($additionalImages) > 4):
                $remaining = array_slice($additionalImages, 4);
                foreach($remaining as $img): ?>
                <div class="col-6 col-md-4 mt-4">
                    <a href="<?= htmlspecialchars($img) ?>" data-glightbox data-gallery="image-popup">
                        <img src="<?= htmlspecialchars($img) ?>" class="rounded shadow-sm w-100" alt="portfolio-img">
                    </a>
                </div>
                <?php endforeach; endif; ?>

                 <?php if (count($additionalImages) > 3): ?>
                <!-- 4th Image as Parallax -->
                <div class="col-12 mt-4">
                    <a href="<?= htmlspecialchars($additionalImages[3]) ?>" data-glightbox data-gallery="image-popup" class="d-block bg-parallax rounded h-400px h-xl-500px overflow-hidden" data-jarallax data-speed="0.6" style="background:url(<?= htmlspecialchars($additionalImages[3]) ?>) no-repeat; background-size:cover; background-position:center;">
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- Images Section END -->

    <!-- Result Section START -->
    <section class="bg-secondary bg-opacity-50 mt-10">
        <div class="container pt-8 pb-10">
            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">03.</span>
                    <h5 class="mt-2">Result</h5>
                </div>
                <!-- Content -->
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($work['project_result'] ?? '')) ?></p>
                    
                    <div class="row row-cols-2 row-cols-md-3 mt-4 g-4 g-lg-5">
                        <?php for($i=1; $i<=3; $i++): 
                            $val = $serviceData["stat_{$i}_val"] ?? null;
                            $label = $serviceData["stat_{$i}_label"] ?? null;
                            if($val): ?>
                            <div class="col">
                                <h2 class="mb-0 text-primary-grad"><?= htmlspecialchars($val) ?></h2>
                                <p class="mb-0 small fw-bold text-uppercase text-muted"><?= htmlspecialchars($label ?? '') ?></p>
                            </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Result Section END -->
