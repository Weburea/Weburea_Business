<!-- Review START -->
<section class="position-relative overflow-hidden py-1">
    <!-- Bg blur -->
    <div class="bg-body blur-6 h-300px w-100 position-absolute bottom-0 start-0 z-index-2 mb-n6"></div>

    <div class="container position-relative mb-n5">
        <!-- Title and content -->
        <div class="text-center mb-4 mb-md-5">
            <h2 class="mb-4"><?= htmlspecialchars($reviews_config['title'] ?? 'Trusted by industry leaders') ?></h2>
            <!-- Avatar list -->
            <ul class="avatar-group align-items-center justify-content-center mb-2">
                <?php foreach ($reviews_config['rating_avatars'] ?? [] as $avatar): ?>
                    <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                            src="<?= htmlspecialchars($avatar) ?>" alt="avatar"
                            onerror="this.src='assets/images/avatar/default.jpg'"></li>
                <?php endforeach; ?>
            </ul>
            <!-- Info -->
            <p><?= $reviews_config['rating_badge'] ?? 'Rated <span class="badge bg-primary">4.9/5.0</span>' ?>
                <?= htmlspecialchars($reviews_config['rating_text'] ?? 'by over 100,000+ users') ?>
            </p>
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
<!-- Review END -->