<!-- Company history START -->
<section class="pt-9 overflow-hidden">
    <div class="container pt-6 pt-sm-8">
        <!-- Title and Slider button -->
        <div class="row mb-md-5">
            <!-- Title -->
            <div class="col-sm-8 col-md-7 col-lg-5">
                <h2><?php echo htmlspecialchars($history['title'] ?? 'A legacy of creativity and growth'); ?></h2>
            </div>

            <!-- Slider arrow -->
            <div class="col-sm-3 col-md-4 ms-auto">
                <div class="d-flex justify-content-end gap-2 position-relative">
                    <a href="#"
                        class="btn btn-lg btn-secondary btn-icon rounded-circle mb-0 swiper-button-prev"><i
                            class="bi bi-arrow-left"></i></a>
                    <a href="#"
                        class="btn btn-lg btn-secondary btn-icon rounded-circle mb-0 swiper-button-next"><i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- History start -->
        <div class="swiper swiper-step swiper-outside-end-n20" data-swiper-options='{
    "spaceBetween": 0,
    "loop": true,
    "autoplay": false,
    "navigation":{
        "nextEl":".swiper-button-next",
        "prevEl":".swiper-button-prev"
    },
    "breakpoints": { 
        "576": {"slidesPerView": 1},
        "768": {"slidesPerView": 3},
        "992": {"slidesPerView": 3},
        "1200": {"slidesPerView": 4}
    }}'>

            <div class="swiper-wrapper">
                <?php 
                $timeline = $history['timeline'] ?? [];
                foreach ($timeline as $item):
                ?>
                <!-- History item -->
                <div class="swiper-slide">
                    <!-- Swiper divider -->
                    <div class="swiper-step-divider"></div>
                    <!-- History card -->
                    <div class="card card-body bg-secondary bg-opacity-50 p-4 me-2 me-sm-5">
                        <h6 class="text-primary"><?php echo htmlspecialchars($item['year'] ?? ''); ?> - <?php echo htmlspecialchars($item['title'] ?? ''); ?></h6>
                        <p class="mb-0"><?php echo htmlspecialchars($item['content'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- History END -->
    </div>
</section>
<!-- Company history END -->
