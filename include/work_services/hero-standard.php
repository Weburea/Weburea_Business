<!-- Standard Case Study Hero (General Services) START  -->
    <section class="bg-secondary pt-xl-8 pb-0">
        <!-- Title and content -->
        <div class="container position-relative pt-4 pt-sm-5">
            <div class="row g-4">
                <!-- Title and breadcrumb -->
                <div class="col-lg-5">
                    <nav class="mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-dots pt-0">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="work.php">Our Work</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($work['service_name']) ?></li>
                        </ol>
                    </nav>

                    <!-- Title -->
                    <h1 class="display-6 fw-bold mb-3 mb-md-4 mb-0"><?= htmlspecialchars($work['title']) ?></h1>
                    <!-- button link  -->
                    <?php if (!empty($work['live_url'])): ?>
                        <a href="<?= htmlspecialchars($work['live_url']) ?>" target="_blank" class="btn btn-primary-grad mb-0">View Project</a> 
                    <?php endif; ?>
                </div>

                <!-- Project detail -->
                <div class="col-lg-4 ms-auto">
                    <div class="row g-3 g-sm-4">
                        <!-- Item -->
                        <div class="col-sm-6 col-md-4 col-lg-6">
                            <small class="text-primary-grad">Industry:</small>
                            <p class="heading-color fw-semibold mt-1 mb-0"><?= htmlspecialchars($serviceData['motion_industry'] ?? $work['industry'] ?? 'Digital Services') ?></p>
                        </div>

                        <!-- Item -->
                        <div class="col-sm-6 col-md-4 col-lg-6">
                            <small class="text-primary-grad">Year Published:</small>
                            <p class="heading-color fw-semibold mt-1 mb-0"><?= htmlspecialchars($work['year'] ?? date('Y')) ?></p>
                        </div>

                        <!-- Item -->
                        <div class="col-sm-12 col-md-10 col-lg-10">
                            <small class="text-primary-grad">Project direction:</small>
                            <p class="heading-color fw-semibold mt-1 mb-0"><?= htmlspecialchars($serviceData['motion_direction'] ?? $work['project_direction'] ?? 'Custom Solution') ?></p>
                        </div>
                    </div>
                </div>
            </div> <!-- Row END -->
        </div>

        <!-- BG image or video -->
        <?php if (!empty($work['image']) && strpos($work['image'], '.mp4') !== false): ?>
            <div class="h-600px h-md-700px mt-6 overflow-hidden">
                <video src="<?= htmlspecialchars($work['image']) ?>" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
            </div>
        <?php else: ?>
            <div class="h-600px h-md-700px mt-6"
                style="background:url(<?= htmlspecialchars($work['image'] ?: 'assets/images/portfolio/list/04.jpg') ?>) no-repeat; background-size:cover; background-position:center;">
            </div>
        <?php endif; ?>
    </section>
    <!-- =======================
Standard Case Study Hero END -->
