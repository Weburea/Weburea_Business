    <!-- ============ Block 2: UI/UX & Product Design Narrative =========-->
    <section class="bg-secondary pb-0 pt-10 pt-md-12">
        <div class="container">
            <div class="row mb-7">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">01.</span>
                    <h5>Overview</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($work['project_overview'] ?? '')) ?></p>
                    <ul class="list-inline">
                        <?php 
                        $tags = array_filter(array_map('trim', explode(',', $work['categories'] ?? '')));
                        foreach($tags as $tag): ?>
                        <li class="list-inline-item"> <span class="btn btn-light btn-sm mb-lg-0"><?= htmlspecialchars($tag) ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">02.</span>
                    <h5>The Challenge</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p><?= nl2br(htmlspecialchars($work['project_challenge'] ?? '')) ?></p>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="list-group list-group-borderless">
                                <div class="row">
                                    <?php if ($challengePoints):
                                        foreach($challengePoints as $point): ?>
                                        <div class="col-md-6">
                                            <li class="list-group-item d-flex heading-color"><i class="bi bi-check-circle text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                        </div>
                                        <?php endforeach; 
                                    endif; ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Result START -->
    <?php if(!empty($work['project_result']) || !empty($serviceData['pd_result_text'])): ?>
    <section class="bg-secondary">
        <div class="container pt-10 pb-10">
            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">03.</span>
                    <h5>Result</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($work['project_result'] ?: $serviceData['pd_result_text'])) ?></p>
                    
                    <div class="row row-cols-2 row-cols-md-3 mt-0 g-4 g-lg-5">
                        <?php for($i=1; $i<=3; $i++): 
                            $val = $serviceData["pd_stat_{$i}_val"] ?? null;
                            $label = $serviceData["pd_stat_{$i}_label"] ?? null;
                            if($val): ?>
                            <div class="col">
                                <h2 class="mb-0"><?= htmlspecialchars($val) ?></h2>
                                <p class="mb-0"><?= htmlspecialchars($label ?? '') ?></p>
                            </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- UI/UX Features -->
    <?php if(!empty($serviceData['pd_features_title'])): ?>
    <section class="bg-secondary position-relative overflow-hidden z-index-2 pt-10 pb-10">
        <div class="container">
            <div class="inner-container-small text-center mb-4 mb-md-6">
                <h2 class="mb-0">
                    <?= htmlspecialchars($serviceData['pd_features_title']) ?>
                    <?php if(!empty($serviceData['pd_features_title_highlight'])): ?>
                        <span class="text-primary-grad"><?= htmlspecialchars($serviceData['pd_features_title_highlight']) ?></span>
                    <?php endif; ?>
                </h2>
            </div>

            <div class="row g-4 g-lg-5 align-items-lg-center">
                <div class="col-md-6 col-lg-4 order-1 pe-5">
                    <?php for($i=1; $i<=3; $i++): if(!empty($serviceData["pd_feat_{$i}_title"])): ?>
                    <div class="aos d-flex justify-content-lg-end mb-4 mb-md-6" data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000">
                        <div class="text-lg-end order-1 ms-3 ms-lg-0 me-lg-3">
                            <h6 class="mb-2"><?= htmlspecialchars($serviceData["pd_feat_{$i}_title"]) ?></h6>
                            <p class="mb-0 small"><?= htmlspecialchars($serviceData["pd_feat_{$i}_desc"] ?? '') ?></p>
                        </div>
                        <div class="icon-lg bg-body text-success rounded-circle flex-shrink-0 order-lg-2"><i class="bi <?= htmlspecialchars($serviceData["pd_feat_{$i}_icon"] ?? 'bi-check-lg') ?>"></i></div>
                    </div>
                    <?php endif; endfor; ?>
                </div>

                <div class="col-md-8 col-lg-4 mx-auto order-3 order-lg-2 text-center">
                    <img src="<?= htmlspecialchars($work['image']) ?>" class="aos mw-100" data-aos="fade-up" alt="UI Showcase">
                </div>

                <div class="col-md-6 col-lg-4 order-2 order-lg-3">
                    <?php for($i=4; $i<=6; $i++): if(!empty($serviceData["pd_feat_{$i}_title"])): ?>
                    <div class="aos d-flex mb-4 mb-md-6" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000">
                        <div class="icon-lg bg-body text-info rounded-circle flex-shrink-0"><i class="bi <?= htmlspecialchars($serviceData["pd_feat_{$i}_icon"] ?? 'bi-check-lg') ?>"></i></div>
                        <div class="ms-3">
                            <h6 class="mb-2"><?= htmlspecialchars($serviceData["pd_feat_{$i}_title"]) ?></h6>
                            <p class="mb-0 small"><?= htmlspecialchars($serviceData["pd_feat_{$i}_desc"] ?? '') ?></p>
                        </div>
                    </div>
                    <?php endif; endfor; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Showcase Grids (PD) -->
    <?php if(!empty($serviceData['pd_grid1_1']) || !empty($serviceData['pd_parallax'])): ?>
    <section class="py-0 my-9 mb-n9">
        <div class="container">
            <div class="row g-4">
                <?php for($i=1; $i<=4; $i++): if(!empty($serviceData["pd_grid1_{$i}"])): ?>
                    <div class="col-6 col-md-6">
                        <img src="<?= htmlspecialchars($serviceData["pd_grid1_{$i}"]) ?>" class="rounded-4 w-100 shadow-sm" alt="UI Grid">
                    </div>
                <?php endif; endfor; ?>
                <?php if(!empty($serviceData['pd_parallax'])): ?>
                    <div class="col-12 mt-4">
                        <div class="bg-parallax rounded-4 h-400px h-xl-500px overflow-hidden" data-jarallax data-speed="0.6"
                            style="background:url(<?= htmlspecialchars($serviceData['pd_parallax']) ?>) no-repeat; background-size:cover; background-position:center;">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Product Screens Swiper -->
    <?php if(!empty($serviceData['pd_screen_1'])): ?>
    <section class="position-relative z-index-2 py-8 mt-10" data-bs-theme="dark">
        <br><br><br><br><br><br>
        <br><br><br><br><br><br>
        <div class="container-fluid position-relative">
            <div class="max-width-1550 bg-dark position-relative rounded-4 overflow-hidden py-6 py-lg-8 mx-auto">
                <div class="container text-center mb-7">
                    <h2 class="mb-4"><?= htmlspecialchars($serviceData['pd_gallery_title'] ?? 'Digital Product Interface Showcase') ?></h2>
                    <p class="mb-4"><?= htmlspecialchars($serviceData['pd_gallery_desc'] ?? '') ?></p>
                </div>
                <div class="swiper px-4 product-screens-swiper" data-swiper-options='{"slidesPerView": 1.5, "spaceBetween": 20, "centeredSlides": true, "loop": true, "grabCursor": true, "autoplay": {"delay": 2500, "disableOnInteraction": false}, "pagination": {"el": ".swiper-pagination", "clickable": true}, "breakpoints": {"576": {"slidesPerView": 3.5}, "992": {"slidesPerView": 6}, "1300": {"slidesPerView": 8.5}}}'>
                    <div class="swiper-wrapper align-items-center">
                        <?php for($i=1; $i<=12; $i++): if(!empty($serviceData["pd_screen_{$i}"])): ?>
                        <div class="swiper-slide text-center">
                            <a href="<?= htmlspecialchars($serviceData["pd_screen_{$i}"]) ?>" data-glightbox data-gallery="product-screens">
                                <img src="<?= htmlspecialchars($serviceData["pd_screen_{$i}"]) ?>" class="rounded-4 border border-secondary border-3 mw-100" alt="Screen">
                            </a>
                        </div>
                        <?php endif; endfor; ?>
                    </div>
                    <!-- Pagination dots -->
                    <div class="swiper-pagination swiper-pagination-primary position-relative mt-5"></div>
                </div>	
            </div>
        </div>
    </section>
    <?php endif; ?>
