    <!-- ============ Motion Graphics & Animation Sections Start =========-->
    
    <!-- Narrative Section START -->
    <section class="pt-10 pt-md-12">
        <div class="container">
            <!-- Overview -->
            <div class="row mb-5 mb-md-8">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">01.</span>
                    <h5 class="mt-2">Overview</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($serviceData['motion_overview'] ?? $work['project_overview'] ?? '')) ?></p>
                    <ul class="list-inline mt-4">
                        <?php 
                        $tags = array_filter(array_map('trim', explode(',', $work['categories'] ?? '')));
                        foreach($tags as $tag): ?>
                        <li class="list-inline-item"> <span class="btn btn-light btn-sm mb-lg-0"><?= htmlspecialchars($tag) ?></span> </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Challenge -->
            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">02.</span>
                    <h5 class="mt-2">The Challenge</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p><?= nl2br(htmlspecialchars($serviceData['motion_challenge'] ?? $work['project_challenge'] ?? '')) ?></p>
                    <?php 
                    $motionChallengePoints = $serviceData['motion_challenge_points'] ?? $challengePoints ?? [];
                    if (!empty($motionChallengePoints)): ?>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <ul class="list-group list-group-borderless">
                                <div class="row g-2">
                                    <?php foreach($motionChallengePoints as $point): ?>
                                    <div class="col-md-6">
                                        <li class="list-group-item d-flex heading-color"><i class="bi bi-check-circle text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Narrative Section END -->

    <!-- Media Showcase START -->
    <section class="py-10 mb-n9">
        <div class="container-fluid">
            <div class="row g-4 g-lg-5">
                <!-- Part 1: Showcase Grid (12 Items) -->
                <?php for($i=1; $i<=12; $i++): 
                    $img = $serviceData["m_grid_1_{$i}"] ?? '';
                    if(!empty($img)):
                ?>
                <div class="col-6 col-md-4">
                    <a href="<?= htmlspecialchars($img) ?>" data-glightbox data-gallery="motion-gallery">
                        <?php if(strpos($img, '.mp4') !== false): ?>
                            <video src="<?= htmlspecialchars($img) ?>" class="rounded w-100" autoplay loop muted playsinline></video>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($img) ?>" class="rounded w-100" alt="Motion Showcase">
                        <?php endif; ?>
                    </a>
                </div>
                <?php endif; endfor; ?>

                <!-- Immersive Parallax 1 -->
                <?php if(!empty($serviceData['motion_parallax_1'])): ?>
                <div class="col-12 mt-4 mt-lg-5">
                    <div class="bg-parallax rounded h-400px h-xl-700px overflow-hidden" data-jarallax data-speed="0.6"
                        style="background:url(<?= htmlspecialchars($serviceData['motion_parallax_1']) ?>) no-repeat; background-size:cover; background-position:center;">
                    </div>
                </div>
                <?php endif; ?>

                <!-- Part 2: Focused View (2 Items) -->
                <?php if(!empty($serviceData['m_grid_2_1']) || !empty($serviceData['m_grid_2_2'])): ?>
                <div class="col-9 mx-auto mt-4 mt-lg-5">
                    <div class="row g-2">
                        <?php for($i=1; $i<=2; $i++): 
                            $img = $serviceData["m_grid_2_{$i}"] ?? '';
                            if(!empty($img)):
                        ?>
                        <div class="col-6">
                            <a href="<?= htmlspecialchars($img) ?>" data-glightbox data-gallery="motion-gallery">
                                <?php if(strpos($img, '.mp4') !== false): ?>
                                    <video src="<?= htmlspecialchars($img) ?>" class="rounded w-100" autoplay loop muted playsinline></video>
                                <?php else: ?>
                                    <img src="<?= htmlspecialchars($img) ?>" class="rounded w-100" alt="Motion Focus">
                                <?php endif; ?>
                            </a>
                        </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Conclusion Parallax 2 -->
                <?php if(!empty($serviceData['motion_parallax_2'])): ?>
                <div class="col-12 mt-4 mt-lg-5">
                    <div class="bg-parallax rounded h-400px h-xl-700px overflow-hidden" data-jarallax data-speed="0.6"
                        style="background:url(<?= htmlspecialchars($serviceData['motion_parallax_2']) ?>) no-repeat; background-size:cover; background-position:center;">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Media Showcase END -->

    <!-- Result Section START -->
    <section class="bg-secondary bg-opacity-50 mt-12">
        <div class="container pt-10 pb-10">
            <div class="row">
                <div class="col-md-4">
                    <span class="text-primary-grad fw-bold lead">03.</span>
                    <h5 class="mt-2">Result</h5>
                </div>
                <div class="col-md-8 ms-auto">
                    <p class="lead"><?= nl2br(htmlspecialchars($serviceData['motion_result_text'] ?? $work['project_result'] ?? '')) ?></p>
                    
                    <div class="row row-cols-2 row-cols-md-3 mt-4 g-4 g-lg-5">
                        <?php for($i=1; $i<=3; $i++): 
                            $val = $serviceData["motion_stat_{$i}_val"] ?? null;
                            $label = $serviceData["motion_stat_{$i}_label"] ?? null;
                            if($val): ?>
                            <div class="col">
                                <h2 class="mb-0 text-primary-grad"><?= htmlspecialchars($val) ?></h2>
                                <p class="mb-0 small fw-bold text-uppercase text-muted"><?= htmlspecialchars($label ?? '') ?></p>
                            </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Result Section END -->
