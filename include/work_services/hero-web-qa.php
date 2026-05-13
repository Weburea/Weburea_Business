    <!-- =======================
Web Development and Software Testing & QAHero START -->
<section class="position-relative pt-sm-8 pt-lg-9 pb-4">
	<!-- Right side svg decoration -->
	<div class="position-absolute top-0 end-0 z-index-2 d-none d-md-block rtl-flip">
		<img src="assets/images/elements/grad-shape/07.png" alt="">
	</div>

	<div class="container pt-4">		<div class="col-md-9 pe-3">
			<!-- Pre title -->
			<p class="heading-color bg-secondary d-inline-block rounded px-3 py-2 mb-3"><span class="badge bg-dark me-2">New</span> <?= htmlspecialchars($work['project_direction'] ?: 'Case Study') ?></p>

			<!-- Client Logo & Title -->
            <div class="mb-4">
                <div style="min-height: 50px; display: flex; align-items: center;" class="mb-3">
                    <?php if ($work['client_logo_dark']): ?>
                        <img src="<?= $work['client_logo_dark'] ?>" class="light-mode-item h-50px" style="width: auto; max-width: 250px; object-fit: contain;" alt="Client Logo">
                    <?php endif; ?>
                    <?php if ($work['client_logo_light']): ?>
                        <img src="<?= $work['client_logo_light'] ?>" class="dark-mode-item h-50px" style="width: auto; max-width: 250px; object-fit: contain;" alt="Client Logo">
                    <?php endif; ?>
                </div>
			    <h1 class="display-7 fw-semibold mb-0"><?= $work['title'] ?> <span class="text-purple"><?= $work['service_name'] ?></span></h1>
            </div>

			<!-- Button and info -->
			<div class="d-flex gap-3 gap-sm-4 flex-wrap">
				<!-- Button -->
                <?php if (!empty($work['live_url'])): ?>
				    <a href="<?= htmlspecialchars($work['live_url']) ?>" target="_blank" class="btn btn-primary-grad">Preview Live Work</a>
                <?php endif; ?>

				<!-- Info -->
				<div class="d-flex gap-4 align-items-center">
					 <!-- Item -->
                            <div class="col-sm-6 col-md-3 col-lg-6">
                                <small class="text-purple">Date Published</small>
                                <p class="heading-color fw-semibold mt-1 mb-0"><?= $work['year'] ?: '2026' ?></p>
                            </div>

                             <!-- Item -->
                            <div class="col-sm-6 col-md-3 col-lg-6">
                                <small class="text-purple">Categories</small>
                                <p class="heading-color fw-semibold mt-1 mb-0"><?= htmlspecialchars($work['categories'] ?: 'Technology') ?></p>
                            </div>

                               <!-- Item -->
                            <div class="col-sm-6 col-md-3 col-lg-6">
                                <small class="text-purple">Industry</small>
                                <p class="heading-color fw-semibold mt-1 mb-0"><?= htmlspecialchars($work['industry'] ?: 'Innovation') ?></p>
                            </div>
				
				</div>
			</div>

		</div>

	</div>


    <!-- =======================Image  START -->
    <div class=" position-relative overflow-hidden my-5">
        <!-- skewed divider	 -->
        <span class="position-absolute top-0 start-0">
            <svg class="fill-body" width="1920" height="237" viewBox="0 0 1920 237" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1940.5 0H-9V164C708.2 295.2 1589.5 218.667 1940.5 164V0Z"/>
            </svg>
        </span>

        <div class="container position-relative z-index-9">
            <!-- Grad blur decoration -->
            <div class="position-absolute top-0 start-50 translate-middle-x mt-n3">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-8" alt="Grad shape">
            </div>

            <!-- Image -->
            <div class="bg-body bg-opacity-10 bg-blur border border-white border-opacity-25 position-relative rounded-4 shadow-primary-lg p-4">
                <!-- Dots -->
                <span class="text-purple">
                    <svg class="mt-n4" width="40" height="10" viewBox="0 0 40 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 5C10 7.76142 7.76142 10 5 10C2.23858 10 0 7.76142 0 5C0 2.23858 2.23858 0 5 0C7.76142 0 10 2.23858 10 5Z" fill="currentColor"/>
                        <path d="M25 5C25 7.76142 22.7614 10 20 10C17.2386 10 15 7.76142 15 5C15 2.23858 17.2386 0 20 0C22.7614 0 25 2.23858 25 5Z" fill="currentColor"/>
                        <path d="M40 5C40 7.76142 37.7614 10 35 10C32.2386 10 30 7.76142 30 5C30 2.23858 32.2386 0 35 0C37.7614 0 40 2.23858 40 5Z" fill="currentColor"/>
                    </svg>
                </span>

                <!-- Comparison Slider START -->
                <div class="comparison-slider-wrapper rounded-4 overflow-hidden">
                    <div class="comparison-slider" id="imageComparisonSlider">
                        <!-- Before Content (Bottom Layer) -->
                        <div class="before-layer">
                            <?php if (strpos($work['image'], '.mp4') !== false): ?>
                                <video src="<?= $work['image'] ?>" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                            <?php else: ?>
                                <img src="<?= $work['image'] ?>" class="w-100 h-100 object-fit-cover" alt="Primary View">
                            <?php endif; ?>
                            <div class="label-badge before-label">Visual Interface</div>
                        </div>
                        
                        <!-- After Content (Top Layer) -->
                        <div class="after-layer">
                            <?php if (strpos($work['comparison_image'], '.mp4') !== false): ?>
                                <video src="<?= $work['comparison_image'] ?>" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                            <?php else: ?>
                                <img src="<?= $work['comparison_image'] ?: 'assets/images/bg/code.jpg' ?>" class="w-100 h-100 object-fit-cover" alt="Process View">
                            <?php endif; ?>
                            <div class="label-badge after-label"><?= $work['comparison_image'] ? 'Process View' : 'Core Logic' ?></div>
                        </div>
                        
                        <!-- Handle -->
                        <div class="slider-handle">
                            <div class="handle-button">
                                <i class="bi bi-chevron-left"></i>
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Comparison Slider END -->
            </div>
        </div>
    </div>
    <!-- =======================Image -->
</section>
    <!-- =======================
Web Development and Software Testing & QAHero END -->
