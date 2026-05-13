    <!-- =======================
Product Design Hero START -->
    <section class="position-relative overflow-hidden pt-sm-8 pt-lg-9 pb-0">
        <!-- Curve bg -->
        <span>
            <svg class="position-absolute bottom-0 start-0 mb-n1 mb-lg-n4" viewBox="0 0 1920 149" style="enable-background:new 0 0 1920 149; z-index: 4" xml:space="preserve">
                <path class="text-secondary" d="M873.3,37.9C775,19.2,603.7-11.5,433.5,4.4C275.1,19.3,45.1,43.4-12,4.4v121V149l1946-2.6V97.6 c-109.9-35.9-230.6-93.1-468.8-75.4C1260.2,37.3,1089.7,79,873.3,37.9z" fill="currentColor"/>
            </svg>
        </span>

        <!-- Blur decoration -->
        <div class="position-absolute end-0 top-0">
            <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9 h-300px rotate-335" alt="Grad shape">
        </div>

        <div class="container position-relative pt-4 pt-sm-0 pb-8 pb-xl-9">
            <div class="row align-items-center">
                <!-- Content -->
                <div class="col-lg-6 mb-6 mb-lg-0">
                    <h1 class="fw-bold mb-3 mb-md-4">
                        <?= htmlspecialchars($serviceData['pd_hero_title'] ?? 'Smart, Secure, and Simple') ?>
                        <?php if(!empty($serviceData['pd_hero_title_highlight'])): ?>
                            <span class="text-primary-grad"><?= htmlspecialchars($serviceData['pd_hero_title_highlight']) ?></span>
                        <?php endif; ?>
                    </h1>
                    <p class="lead mb-3 mb-md-4"><?= htmlspecialchars($serviceData['pd_hero_subtitle'] ?? 'Experience seamless money transfers, hassle-free bill payments, and secure account management—all in one app.') ?></p>

                    <!-- Buttons -->
                    <div class="d-sm-flex mb-4 mb-lg-7">
                        <?php if(($serviceData['pd_google_play_enabled'] ?? '') === '1'): ?>
                            <a href="<?= htmlspecialchars($serviceData['pd_google_play'] ?? '#') ?>" target="_blank"> <img src="assets/images/elements/google-play.svg" class="btn-transition me-4 mb-2 mb-sm-0" width="180" alt="play store"> </a>
                        <?php endif; ?>
                        <?php if(($serviceData['pd_app_store_enabled'] ?? '') === '1'): ?>
                            <a href="<?= htmlspecialchars($serviceData['pd_app_store'] ?? '#') ?>" target="_blank"> <img src="assets/images/elements/app-store.svg" class="btn-transition" width="180" alt="app-store"> </a>
                        <?php endif; ?>
                        
                        <?php if(($serviceData['pd_google_play_enabled'] ?? '') !== '1' && ($serviceData['pd_app_store_enabled'] ?? '') !== '1' && !empty($work['live_url'])): ?>
                            <a href="<?= htmlspecialchars($work['live_url']) ?>" target="_blank" class="btn btn-primary-grad btn-lg">View Live Project</a>
                        <?php endif; ?>
                    </div>

                    <!-- Review deco -->
                    <div class="d-flex align-items-center">
                        <!-- Avatar list -->
                        <ul class="avatar-group align-items-center justify-content-center mb-0 me-2">
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar"></li>
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar"></li>
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar"></li>
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar"></li>
                            <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar"></li>
                        </ul>
                        <p class="heading-color mb-0"><span class="text-primary"><?= htmlspecialchars($serviceData['pd_social_proof'] ?? '5000+') ?></span> users have downloaded our app</p>
                    </div>
                </div>

                <!-- Image -->
                <div class="col-sm-9 col-lg-5 col-xxl-4 position-relative mx-auto">
                    <!-- Decoration images -->
                    <?php if(!empty($serviceData['pd_hero_deco_1'])): ?>
                    <div class="position-absolute start-0 top-0 mt-6 ms-xl-n7 z-index-2 d-none d-sm-block">
                        <img src="<?= htmlspecialchars($serviceData['pd_hero_deco_1']) ?>" class="aos rounded-3 shadow-primary" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800" data-aos-easing="ease-in-out" style="height: 80px;" alt="deocration">
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($serviceData['pd_hero_deco_2'])): ?>
                    <div class="position-absolute top-50 end-0 translate-middle-y me-n6 me-xl-n8 mt-xl-n5 d-none d-sm-block">
                        <img src="<?= htmlspecialchars($serviceData['pd_hero_deco_2']) ?>" class="aos rounded-3 shadow-primary" data-aos="zoom-in" data-aos-delay="600" data-aos-duration="800" data-aos-easing="ease-in-out" alt="deocration">
                    </div>
                    <?php endif; ?>

                    <!-- Main image -->
                    <img src="<?= htmlspecialchars($work['image']) ?>" class="aos mb-n8 mb-md-n9 mb-xxl-n8" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800" data-aos-easing="ease-in-out" alt="mobile image">
                </div>
            </div>
        </div>
    </section>
    <!-- =======================
    Product Design Hero END -->
