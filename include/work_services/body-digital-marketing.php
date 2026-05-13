<?php
$f1Title = $serviceData['dm_feature_1_title'] ?? 'Precision Audience Targeting';
$f1Desc = $serviceData['dm_feature_1_desc'] ?? 'Leveraging deep demographic insights to reach high-value prospects. For this project, we refactored the client\'s targeting parameters, resulting in a 35% surge in engagement by focusing on intent-based audience segments that were previously untapped.';
$f1Img = $serviceData['dm_feature_1_img'] ?? 'assets/images/elements/saas-decoration/tab-3.png';

$f2Title = $serviceData['dm_feature_2_title'] ?? 'Real-time Ad Performance Tracking';
$f2Desc = $serviceData['dm_feature_2_desc'] ?? 'Eliminating ad spend waste through instantaneous conversion analytics. By deploying custom tracking pixels, we enabled the company to monitor lead flow in real-time, allowing for rapid creative testing and budget optimization that halved their customer acquisition costs.';
$f2Img = $serviceData['dm_feature_2_img'] ?? 'assets/images/elements/saas-decoration/tab-2.png';

$f3Title = $serviceData['dm_feature_3_title'] ?? 'Scalable Multi-Channel Growth';
$f3Desc = $serviceData['dm_feature_3_desc'] ?? 'Building a robust digital ecosystem that converts across every touchpoint. We synchronized the brand\'s presence across Google and Meta, creating a unified sales funnel that improved overall conversion rates by 50% within the first fiscal quarter.';
$f3Img = $serviceData['dm_feature_3_img'] ?? 'assets/images/elements/saas-decoration/step-3.png';

$parallaxImg = $serviceData['dm_parallax'] ?? 'assets/images/portfolio/04.jpg';

$additionalImages = json_decode($work['additional_images'] ?? '[]', true);
$img1 = !empty($additionalImages[0]) ? $additionalImages[0] : 'assets/images/portfolio/3by4/09.jpg';
$img2 = !empty($additionalImages[1]) ? $additionalImages[1] : 'assets/images/portfolio/3by4/06.jpg';
$img3 = !empty($additionalImages[2]) ? $additionalImages[2] : 'assets/images/portfolio/04.jpg'; // default
?>
<!--  ============ Digital Marketing & Ads Sections  Start =========  -->

<!-- =======================
Digital Marketing & Ads Sections Core features START -->
<section class="pt-md-0 ">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<!-- Feature item 1 -->
				<div class="row g-4 align-items-center mb-6">
					<div class="col-md-6 pe-md-5">
						<div class="bg-secondary-grad p-4 rounded-4">
							<img src="<?= htmlspecialchars($f1Img) ?>" class="rounded-4 w-100" style="object-fit: cover;" alt="feature image">
						</div>
					</div>

					<div class="col-md-6">
						<h4 class="mb-md-4"><?= htmlspecialchars($f1Title) ?></h4>
						<p class="mb-0"><?= nl2br(htmlspecialchars($f1Desc)) ?></p>
					</div>
				</div>

				<!-- Feature item 2 -->
				<div class="row g-4 align-items-center mb-6">
					<div class="col-md-6 order-2">
						<h4 class="mb-md-4"><?= htmlspecialchars($f2Title) ?></h4>
						<p class="mb-0"><?= nl2br(htmlspecialchars($f2Desc)) ?></p>
					</div>

					<div class="col-md-6 ps-md-5 order-md-2">
						<div class="bg-secondary p-4 rounded-4">
							<img src="<?= htmlspecialchars($f2Img) ?>" class="rounded-4 w-100" style="object-fit: cover;" alt="feature image">
						</div>
					</div>
				</div>

				<!-- Feature item 3 -->
				<div class="row g-4 align-items-center">
					<div class="col-md-6 pe-md-5">
						<div class="bg-secondary-grad p-4 rounded-4">
							<img src="<?= htmlspecialchars($f3Img) ?>" class="rounded-4 w-100" style="object-fit: cover;" alt="feature image">
						</div>
					</div>

					<div class="col-md-6">
						<h4 class="mb-md-4"><?= htmlspecialchars($f3Title) ?></h4>
						<p class="mb-0"><?= nl2br(htmlspecialchars($f3Desc)) ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- =======================
Digital Marketing & Ads Sections Core features END -->

<!-- =======================
Images Digital Marketing & Ads Sections START -->
<section class="bg-opacity-50 py-0">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <!-- Image 1 -->
            <div class="col-12 col-md-4">
                <a href="<?= htmlspecialchars($img1) ?>" data-glightbox data-gallery="image-popup">
                    <img src="<?= htmlspecialchars($img1) ?>" class="rounded w-100 h-300px h-sm-400px bg-white" style="object-fit: contain;" alt="portfolio-img">
                </a>
            </div>

            <!-- Image 2 -->
            <div class="col-12 col-md-4">
                <a href="<?= htmlspecialchars($img2) ?>" data-glightbox data-gallery="image-popup">
                    <img src="<?= htmlspecialchars($img2) ?>" class="rounded w-100 h-300px h-sm-400px bg-white" style="object-fit: contain;" alt="portfolio-img">
                </a>
            </div>

            <!-- Image 3 -->
            <div class="col-12 col-md-4">
                <a href="<?= htmlspecialchars($img3) ?>" data-glightbox data-gallery="image-popup">
                    <img src="<?= htmlspecialchars($img3) ?>" class="rounded w-100 h-300px h-sm-400px bg-white" style="object-fit: contain;" alt="portfolio-img">
                </a>
            </div>

            <!-- Parallax image -->
            <div class="col-12 mt-5 mb-2">
                <div class="bg-parallax rounded h-400px h-xl-700px overflow-hidden" data-jarallax
                    data-speed="0.6"
                    style="background:url(<?= htmlspecialchars($parallaxImg) ?>) no-repeat; background-size:cover; background-position:center;">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =======================
Images Digital Marketing & Ads Sections END -->
<!--  ============ Digital Marketing & Ads Sections  End =========  -->
