<!-- =======================
Video Editing & Production Hero START -->
<section class="pt-0">
	<!-- Title and content -->
	<div class="bg-dark position-relative overflow-hidden pb-6 pt-8 py-sm-9">
		<!-- Grad blur -->
		<div class="position-absolute end-0 top-0">
			<img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-1 blur-8 h-300px rotate-335" alt="Grad shape">
		</div>
		
		<!-- Title and content -->
		<div class="container position-relative pb-7" data-bs-theme="dark">
			<div class="inner-container">
				<!-- Main title -->
				<?php
					$raw_ve_title = !empty($serviceData['ve_hero_title']) ? htmlspecialchars_decode($serviceData['ve_hero_title']) : 'High-Impact <span class="text-purple">Video Production</span> & Editing';
					$safe_ve_title = strip_tags($raw_ve_title, '<span><br><b><i><strong><em><mark><u>');
				?>
				<h1 class="text-center mb-0"><?= $safe_ve_title ?></h1>
	
				<!-- List -->
				<ul class="list-inline d-flex justify-content-center flex-wrap gap-2 gap-md-4 mb-0 mt-4 mt-xl-5">
					<li class="list-inline-item"> <i class="bi bi-calendar-check-fill text-pink me-2 lead"></i>Date: <span class="fw-normal"><?= htmlspecialchars($work['year'] ?? '') ?></span></li>
					<li class="list-inline-item"> <i class="bi bi-film text-success me-2 lead"></i>Direction: <span class="fw-normal"><?= htmlspecialchars($work['project_direction'] ?? '') ?></span></li>
					<li class="list-inline-item"> <i class="bi bi-building-fill text-warning me-2 lead"></i>Industry: <span class="fw-normal"><?= htmlspecialchars($work['industry'] ?? '') ?></span></li>
					<li class="list-inline-item"> <i class="bi bi-globe text-info me-2 lead"></i>Scope: <span class="fw-normal"><?= htmlspecialchars($serviceData['ve_scope'] ?? 'Global') ?></span></li>
				</ul>
			</div>
		</div>
	</div>

	<!-- Image -->
	<div class="container mt-n7 mt-sm-n9">
		<!-- Image -->
		<div class="bg-body bg-opacity-10 bg-blur border border-white border-opacity-10 position-relative rounded-5 shadow-primary-lg p-2 p-sm-4">
			<!-- Dots -->
			<span class="d-none d-sm-block">
				<svg class="mt-n4" width="40" height="10" viewBox="0 0 40 10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path class="text-success" d="M10 5C10 7.76142 7.76142 10 5 10C2.23858 10 0 7.76142 0 5C0 2.23858 2.23858 0 5 0C7.76142 0 10 2.23858 10 5Z" fill="currentColor"></path>
					<path class="text-warning" d="M25 5C25 7.76142 22.7614 10 20 10C17.2386 10 15 7.76142 15 5C15 2.23858 17.2386 0 20 0C22.7614 0 25 2.23858 25 5Z" fill="currentColor"></path>
					<path class="text-danger" d="M40 5C40 7.76142 37.7614 10 35 10C32.2386 10 30 7.76142 30 5C30 2.23858 32.2386 0 35 0C37.7614 0 40 2.23858 40 5Z" fill="currentColor"></path>
				</svg>
			</span>
		
			<!-- Images -->
            <?php if (!empty($work['image'])): ?>
                <?php if(strtolower(pathinfo($work['image'], PATHINFO_EXTENSION)) === 'mp4'): ?>
                    <video src="<?= htmlspecialchars($work['image']) ?>" class="rounded-4 shadow-sm w-100" autoplay loop muted playsinline></video>
                <?php else: ?>
			        <img src="<?= htmlspecialchars($work['image']) ?>" class="rounded-4 shadow-sm" alt="hero image">
                <?php endif; ?>
            <?php endif; ?>

			<!-- Decoration image -->
			<img src="assets/images/elements/chat-heart.png" class="position-absolute top-0 start-0 ms-8 mt-n4 d-none d-sm-block" alt="">
		</div>
	</div>
</section>
<!-- =======================
Video Editing & Production Hero END -->
