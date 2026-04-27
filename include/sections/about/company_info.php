<!-- About START -->
<section class="bg-secondary pt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <!-- About content START -->
                <div class="row g-4 g-lg-6 mb-6 mb-md-8">
                    <!-- Images -->
                    <div class="col-md-7 position-relative">
                        <!-- vector blur decoration -->
                        <div class="position-absolute bottom-0 start-50 translate-middle-x ms-n5">
                            <img src="assets/images/elements/grad-shape/11.png" class="blur-2" alt="Decoration shape">
                        </div>
                        <!-- Blur decoration -->
                        <div class="position-absolute top-0 start-50 translate-middle-x ms-7">
                            <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="opacity-3 blur-8"
                                alt="Grad shape">
                        </div>
                        <!-- Images -->
                        <div class="row position-relative">
                            <div class="col-sm-6">
                                <img src="<?php echo htmlspecialchars($company_info['image_1'] ?? 'assets/images/about/08.jpg'); ?>"
                                    class="rounded-4" alt="">
                            </div>
                            <div class="col-sm-6 mt-5 mt-sm-8">
                                <img src="<?php echo htmlspecialchars($company_info['image_2'] ?? 'assets/images/about/09.jpg'); ?>"
                                    class="rounded-4" alt="">
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-md-5">
                        <h2 class="mb-3">
                            <?php echo htmlspecialchars($company_info['title'] ?? 'Creativity in Motion'); ?></h2>
                        <p><?php echo htmlspecialchars($company_info['description_1'] ?? ''); ?></p>
                        <p><?php echo htmlspecialchars($company_info['description_2'] ?? ''); ?></p>
                        <a class="btn btn-primary icon-link icon-link-hover mt-3"
                            href="<?php echo htmlspecialchars($company_info['btn_link'] ?? 'portfolio-grid.php'); ?>"><?php echo htmlspecialchars($company_info['btn_text'] ?? 'Explore our work'); ?><i
                                class="bi bi-arrow-right"></i> </a>
                    </div>
                </div>
                <!-- About content END -->

                <!-- Features START -->
                <div class="row g-4 g-lg-5">
                    <?php
                    $mission_vision = $sections['mission_vision'] ?? [];
                    foreach (['mission', 'vision', 'goal'] as $key):
                        $item = $mission_vision[$key] ?? [];
                        if (!empty($item)):
                            ?>
                            <!-- Feature item -->
                            <div class="col-md-4">
                                <h6 class="mb-2"><i
                                        class="<?php echo htmlspecialchars($item['icon'] ?? ''); ?> me-2"></i><?php echo htmlspecialchars($item['title'] ?? ''); ?>
                                </h6>
                                <p><?php echo htmlspecialchars($item['content'] ?? ''); ?></p>
                            </div>
                        <?php endif; endforeach; ?>
                </div>
                <!-- Features END -->
            </div>
        </div> <!-- Row END -->
    </div>
</section>
<!-- About END -->