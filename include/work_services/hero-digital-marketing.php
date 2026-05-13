<?php
// Default values based on the HTML template
$heroTitle = $serviceData['dm_hero_title'] ?? 'High-Impact Marketing & ROI-Driven Ad Strategies';
$heroSubtitle = $serviceData['dm_hero_subtitle'] ?? 'Transforming brand visibility into measurable revenue through precision-targeted campaigns and data-driven ad optimization.';
$heroCta = $serviceData['dm_hero_cta'] ?? 'Request Strategy Audit';
$heroLink = $serviceData['dm_hero_link'] ?? '#';

$benefitsTitle = $serviceData['dm_benefits_title'] ?? 'Maximize Your Digital Footprint with Performance Marketing';
$benefitsListStr = $serviceData['dm_benefits_list'] ?? 'Omnichannel Campaign Management, Conversion Rate Optimization (CRO), Precision Audience Segmenting';
$benefitsList = array_map('trim', explode(',', $benefitsListStr));

$stat1Val = $serviceData['dm_stat_1_val'] ?? '250';
$stat1Sym = $serviceData['dm_stat_1_sym'] ?? '+';
$stat1Color = $serviceData['dm_stat_1_color'] ?? 'text-primary';
$stat1Label = $serviceData['dm_stat_1_label'] ?? 'Campaigns Launched';

$stat2Val = $serviceData['dm_stat_2_val'] ?? '15';
$stat2Sym = $serviceData['dm_stat_2_sym'] ?? 'M+';
$stat2Color = $serviceData['dm_stat_2_color'] ?? 'text-primary';
$stat2Label = $serviceData['dm_stat_2_label'] ?? 'Ad Impressions';

$stat3Val = $serviceData['dm_stat_3_val'] ?? '4.5';
$stat3Sym = $serviceData['dm_stat_3_sym'] ?? 'x';
$stat3Color = $serviceData['dm_stat_3_color'] ?? 'text-primary';
$stat3Label = $serviceData['dm_stat_3_label'] ?? 'Avg. Ad ROI';

$stat4Val = $serviceData['dm_stat_4_val'] ?? '98';
$stat4Sym = $serviceData['dm_stat_4_sym'] ?? '%';
$stat4Color = $serviceData['dm_stat_4_color'] ?? 'text-primary';
$stat4Label = $serviceData['dm_stat_4_label'] ?? 'Client Retention';

$decor1 = $serviceData['dm_hero_decor_1'] ?? 'assets/images/elements/saas-decoration/03.png';
$decor2 = $serviceData['dm_hero_decor_2'] ?? 'assets/images/elements/saas-decoration/06.png';
$decor3 = $serviceData['dm_hero_decor_3'] ?? 'assets/images/elements/saas-decoration/07.png';
$mainImg = !empty($work['image']) ? $work['image'] : 'assets/images/about/11.jpg';
?>
<!-- =======================
Digital Marketing & Ads Hero START -->
<section class="bg-secondary bg-opacity-50 position-relative pt-xl-8 overflow-hidden">
	<!-- Curve decoration -->
	<span>
		<svg class="position-absolute bottom-0 start-0 mb-n3 z-index-2" viewBox="0 0 1950 178" style="enable-background:new 0 0 1950 178;">
			<path class="fill-body" d="M1480.3,21.8c238.7-17.4,359.6,39,469.7,74.4V178H0v-54.2V4.4c57.3,38.5,287.7,14.6,446.4,0 c170.6-15.7,342.3,14.5,440.8,33C1104,78,1274.8,36.9,1480.3,21.8z"/>
		</svg>
	</span>
	
	<div class="container position-relative pt-4 pt-sm-5 pb-4 pb-lg-8">
		<!-- Main title and images START -->
		<div class="row">
			<!-- Title and content -->
			<div class="col-lg-5 mb-6 mb-lg-0">
				<h1 class="h2 mb-lg-4"><?= htmlspecialchars_decode($heroTitle) ?></h1>
				<p class="mb-lg-4"><?= htmlspecialchars($heroSubtitle) ?></p>
				<ul class="list-inline mb-4">
					<?php if (!empty($work['year'])): ?>
					<li class="list-inline-item me-4"><i class="bi bi-calendar-check-fill text-primary me-2"></i><?= htmlspecialchars($work['year']) ?></li>
					<?php endif; ?>
				</ul>
				<a href="<?= htmlspecialchars($heroLink) ?>" class="btn btn-primary-grad mb-0"><?= htmlspecialchars($heroCta) ?></a>
			</div>

			<!-- Image -->
			<div class="col-lg-6 position-relative ms-auto">
				<!-- Decoration images -->
				<div class="position-absolute top-0 start-50 translate-middle ms-6">
					<img src="<?= htmlspecialchars($decor1) ?>" class="shadow-primary-lg rounded-4" alt="feature image">
				</div>

				<!-- Decoration images -->
				<div class="position-absolute bottom-0 start-0 mb-n4">
					<img src="<?= htmlspecialchars($decor2) ?>" class="h-100px h-sm-200px shadow-primary-lg rounded-4" alt="feature image">
				</div>

				<!-- Main image -->
				<div class="ps-md-7">
					<img src="<?= htmlspecialchars($mainImg) ?>" class="rounded-4 w-100" style="object-fit: cover;" alt="Main Showcase Image">
				</div>
			</div>
		</div>
		<!-- Main title and images END -->

		<!-- Benefits and skill sets START -->
		<div class="row align-items-center g-4 mt-6 mt-lg-9">
			<!-- Image -->
			<div class="col-md-4 col-lg-3 order-2">
				<img src="<?= htmlspecialchars($decor3) ?>" class="w-md-300px shadow-primary-lg rounded-4" alt="feature image">
			</div>

			<!-- Content -->
			<div class="col-md-8 ms-auto order-1 order-md-2">
				<div class="row g-4 align-items-center">
					<!-- Benefits -->
					<div class="col-md-6">
						<!-- Title -->
						<h6 class="mb-3"><?= htmlspecialchars($benefitsTitle) ?></h6>
						<!-- List -->
						<ul class="list-group list-group-borderless">
                            <?php foreach ($benefitsList as $benefit): ?>
                                <?php if (!empty($benefit)): ?>
							    <li class="list-group-item d-flex pb-0"><i class="bi bi-check-circle text-success me-2"></i><?= htmlspecialchars($benefit) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
						</ul>
					</div>

					<!-- Skill sets -->
					<div class="col-md-6 border-start border-2 border-pink ps-sm-5">
						<div class="row row-cols-2 g-4">
							<!-- Item -->
							<div class="col">
								<h3 class="mb-0"><?= htmlspecialchars($stat1Val) ?><span class="<?= htmlspecialchars($stat1Color) ?>"><?= htmlspecialchars($stat1Sym) ?></span></h3>
								<p class="mb-0"><?= htmlspecialchars($stat1Label) ?></p>
							</div>
		
							<!-- Item -->
							<div class="col">
								<h3 class="mb-0"><?= htmlspecialchars($stat2Val) ?><span class="<?= htmlspecialchars($stat2Color) ?>"><?= htmlspecialchars($stat2Sym) ?></span></h3>
								<p class="mb-0"><?= htmlspecialchars($stat2Label) ?></p>
							</div>

							<!-- Item -->
							<div class="col">
								<h3 class="mb-0"><?= htmlspecialchars($stat3Val) ?><span class="<?= htmlspecialchars($stat3Color) ?>"><?= htmlspecialchars($stat3Sym) ?></span></h3>
								<p class="mb-0"><?= htmlspecialchars($stat3Label) ?></p>
							</div>
		
							<!-- Item -->
							<div class="col">
								<h3 class="mb-0"><?= htmlspecialchars($stat4Val) ?><span class="<?= htmlspecialchars($stat4Color) ?>"><?= htmlspecialchars($stat4Sym) ?></span></h3>
								<p class="mb-0"><?= htmlspecialchars($stat4Label) ?></p>
							</div>
						</div>
					</div>
				</div> <!-- Row END -->
			</div>
		</div>
		<!-- Benefits and skill sets END -->

	</div>
</section>
<!-- =======================
Digital Marketing & Ads Hero END -->
