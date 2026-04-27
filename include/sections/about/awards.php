<!-- Awards START -->
<section class="bg-secondary-grad pt-0 pb-1 pt-3">
    <div class="container position-relative z-index-2">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <!-- About content START -->
                <div class="row align-items-center g-4 g-lg-6 mb-6 mb-md-8 pt-5">
                    <!-- Images -->
                    <div class="col-sm-8 col-lg-5 position-relative mx-auto">
                        <div class="text-bg-img text-center text-lg-start fw-bold lh-1"
                            style="background:url(assets/images/about/text-bg-two.jpeg) no-repeat; background-size:cover; background-position:center; background-clip: text;">
                            <?php echo htmlspecialchars($awards_intro['founding_year'] ?? '2025'); ?></div>
                        <!-- badge -->
                        <h5 class="bg-body px-4 py-2 position-absolute top-0 start-0 rotate-335">Since</h5>
                    </div>

                    <!-- Content -->
                    <div class="col-lg-7">
                        <h2 class="mb-4"><?php echo htmlspecialchars($awards_intro['title'] ?? 'Bringing ideas to life'); ?></h2>
                        <p><?php echo htmlspecialchars($awards_intro['description_1'] ?? 'Our creative experts blend innovation with strategy to turn your vision into reality.'); ?></p>
                        <p class="mb-4"><?php echo htmlspecialchars($awards_intro['description_2'] ?? 'We believe great design is strategic. Our approach combines industry knowledge with creative insights.'); ?></p>
                        <!-- List -->
                        <ul class="list-inline d-flex flex-wrap gap-2 gap-sm-4 mb-3">
                            <?php 
                            $intro_list = $awards_intro['list_items'] ?? ['UI/UX Design', 'Motion Graphics', 'Software Testing', 'Web Application'];
                            foreach($intro_list as $item):
                            ?>
                            <li class="list-inline-item heading-color"> <i
                                    class="bi bi-check-circle text-primary-grad me-1"></i><?php echo htmlspecialchars($item); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="btn btn-white-shadow mb-0 mt-3" href="<?php echo htmlspecialchars($awards_intro['btn_link'] ?? 'services-list.html'); ?>">
                            <?php echo htmlspecialchars($awards_intro['btn_text'] ?? 'Explore our services'); ?>
                        </a>
                    </div>
                </div>
                <!-- About content END -->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="max-width-1550 bg-dark position-relative rounded-4 py-5 py-sm-6 py-lg-8 mb-n9"
            data-bs-theme="dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <!-- Title -->
                        <h2 class="mb-4 mb-sm-6"><?php echo htmlspecialchars($awards['title'] ?? 'Our awards and achievements'); ?></h2>

                        <!-- Award items -->
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                            <?php 
                            $award_list = $awards['award_list'] ?? [];
                            foreach ($award_list as $award):
                            ?>
                            <!-- Item -->
                            <div class="col">
                                <img src="<?php echo htmlspecialchars($award['icon'] ?? ''); ?>" class="h-30px mb-3"
                                    alt="award logo">
                                <p class="mb-0"><?php echo htmlspecialchars($award['label'] ?? ''); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="col-lg-6 ms-auto position-absolute bottom-0 end-0 d-none d-lg-block">
                        <img src="<?php echo htmlspecialchars($awards['side_image'] ?? 'assets/images/elements/awards-saly.png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Awards END -->
