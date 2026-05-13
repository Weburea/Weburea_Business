<!--  ============ Video Editing & Production  Sections   Start =========  -->

<!-- Detail for Video Editing & Production Start -->
<section class="">
    <div class="container">
        <!-- Overview -->
        <div class="row mb-5">
            <div class="col-md-4">
                <span class="text-primary-grad fw-bold lead">01.</span>
                <h5>Overview</h5>
            </div>
            <!-- Content -->
            <div class="col-md-8 ms-auto">
                <p class="lead"><?= nl2br(htmlspecialchars($work['project_overview'] ?? '')) ?></p>
                <!-- Tag list -->
                <ul class="list-inline mt-3">
                    <?php 
                    $tags = array_filter(array_map('trim', explode(',', $work['categories'] ?? '')));
                    foreach($tags as $tag): ?>
                    <li class="list-inline-item"> <span class="btn btn-light btn-sm mb-lg-0"><?= htmlspecialchars($tag) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Challenge -->
        <div class="row">
            <div class="col-md-4">
                <span class="text-primary-grad fw-bold lead">02.</span>
                <h5>The Challenge</h5>
            </div>
            <!-- Content -->
            <div class="col-md-8 ms-auto">
                <p><?= nl2br(htmlspecialchars($work['project_challenge'] ?? '')) ?></p>

                <!-- List -->
                <div class="row mt-4">
                    <?php if ($challengePoints): 
                        // Split challenge points into two columns
                        $half = ceil(count($challengePoints) / 2);
                        $col1 = array_slice($challengePoints, 0, $half);
                        $col2 = array_slice($challengePoints, $half);
                    ?>
                        <div class="col-sm-6 col-lg-5">
                            <ul class="list-group list-group-borderless">
                                <?php foreach($col1 as $point): ?>
                                <li class="list-group-item d-flex heading-color"><i class="bi bi-check-circle text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-5">
                            <ul class="list-group list-group-borderless">
                                <?php foreach($col2 as $point): ?>
                                <li class="list-group-item d-flex heading-color"><i class="bi bi-check-circle text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Detail for Video Editing & Production End -->

<!-- =======================
Video Production START -->
<?php if(!empty($serviceData['ve_video_1'])): ?>
<section class="bg-secondary-grad overflow-hidden position-relative pt-5 mt-3">
	<!-- Geo gard pattern decoration -->
	<div class="position-absolute bottom-0 start-0 ms-n8 mb-n6">
		<img src="assets/images/elements/geo-grad-pattern.svg" class="h-500px opacity-2" alt="pattern">
	</div>

	<div class="container">
		<!-- Title and slider button -->
		<div class="row mb-4 mb-md-5">
			<!-- Title -->
			<div class="col-md-8 col-xl-6">
				<h2><?= htmlspecialchars($serviceData['ve_gallery_title'] ?? 'Impactful Video & Motion Graphics') ?></h2>
			</div>
			<!-- Buttons -->
			<div class="col-md-4 col-xl-6">
				<!-- Slider arrow -->
				<div class="d-flex justify-content-md-end gap-3 position-relative mt-3">
					<a href="#" class="btn btn-lg btn-white btn-icon rounded-circle mb-0 swiper-button-prev-feature rtl-flip"><i class="bi bi-arrow-left"></i></a>
					<a href="#" class="btn btn-lg btn-white btn-icon rounded-circle mb-0 swiper-button-next-feature rtl-flip"><i class="bi bi-arrow-right"></i></a>
				</div>
			</div>
		</div>

		<!-- Features slider START -->
		<div class="swiper swiper-outside-end-n20" data-swiper-options='{
			"spaceBetween": 50,
			"loop": true,
			"autoplay":{
				"pauseOnMouseEnter": true
			},
			"navigation":{
				"nextEl":".swiper-button-next-feature",
				"prevEl":".swiper-button-prev-feature"
			},
			"breakpoints": { 
				"576": {"slidesPerView": 2},
				"992": {"slidesPerView": 3},
				"1200": {"slidesPerView": 4}
			}}'>
			
			<div class="swiper-wrapper">
                <?php for($i=1; $i<=5; $i++): 
                    if(!empty($serviceData["ve_video_{$i}"])): 
                        $videoSrc = $serviceData["ve_video_{$i}"];
                        $title = $serviceData["ve_video_{$i}_title"] ?? '';
                        $desc = $serviceData["ve_video_{$i}_desc"] ?? '';
                ?>
				<!-- Feature item -->
				<div class="swiper-slide">
					<div class="card card-img-scale rounded-4 overflow-hidden h-100">
						<!-- Card Video -->              
						<video src="<?= htmlspecialchars($videoSrc) ?>" autoplay loop muted playsinline class="img-scale w-100 h-100" style="object-fit: cover; min-height: 450px;"></video>
						<!-- BG overlay -->
						<div class="bg-overlay bg-dark opacity-4"></div>

						<!-- Card elements -->
						<div class="card-img-overlay p-4 p-xxl-5 d-flex flex-column justify-content-end">
							<a href="<?= htmlspecialchars($videoSrc) ?>" class="glightbox stretched-link" data-glightbox="type: video"></a>
							<div class="position-relative z-index-2 pointer-events-none">
								<h5 class="text-white"><?= htmlspecialchars($title) ?></h5>
								<p class="text-white text-opacity-75 mb-0"><?= htmlspecialchars($desc) ?></p>
							</div>
						</div>						
					</div>
				</div>
                <?php endif; endfor; ?>
			</div>
		</div>
		<!-- Features slider END -->
	</div>
</section>
<?php endif; ?>
<!-- =======================
Video Production END -->

<!--  ============ Video Editing & Production  Sections   End =========  -->
