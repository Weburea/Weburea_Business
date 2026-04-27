<?php
/**
 * Reusable Reviews Section
 * Fetches data from $home_config['reviews']
 */
$reviews_config = $home_config['reviews'] ?? [];
$review_cards = $reviews_config['review_cards'] ?? [];

// Helper function to render a single review card (if not already defined)
if (!function_exists('renderReviewCard')) {
    function renderReviewCard($card)
    {
        ?>
        <div class="card border rounded-4 p-3 m-0">
            <div class="card-header d-flex justify-content-between pb-0">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0">
                        <img class="avatar-img rounded-circle border border-primary border-opacity-10"
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
