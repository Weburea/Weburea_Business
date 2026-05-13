    <!-- ============ Block 3: Standard Narrative Flow (Branding, Motion, Marketing, etc.) =========-->
    <section class="pb-0 pt-10 pt-md-12">
        <div class="container">
            <div class="row g-4 g-md-6">
                <!-- Overview & Challenge -->
                <div class="col-md-6 col-lg-5">
                    <h2 class="mb-4">Project Overview</h2>
                    <p class="mb-0 fs-5"><?= nl2br(htmlspecialchars($work['project_overview'] ?: '')) ?></p>
                    
                    <div class="mt-5 p-4 bg-light rounded-4 border border-white border-opacity-10 shadow-sm position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-n3 me-n3 opacity-1">
                            <i class="bi bi-bullseye display-1 text-primary"></i>
                        </div>
                        <h5 class="mb-3 text-primary-grad position-relative">The Challenge</h5>
                        <p class="mb-3 position-relative"><?= nl2br(htmlspecialchars($work['project_challenge'] ?: '')) ?></p>
                        
                        <?php if ($challengePoints): ?>
                            <ul class="list-group list-group-borderless mt-3 position-relative">
                                <?php foreach ($challengePoints as $point): ?>
                                    <li class="list-group-item d-flex mb-0"><i class="bi bi-arrow-right-circle-fill text-primary me-2"></i><?= htmlspecialchars($point) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Showcase Grid -->
                <div class="col-md-6 col-lg-6 ms-auto">
                    <div class="row g-3">
                        <?php 
                        $gridImagesFound = 0;
                        for ($i=1; $i<=6; $i++): 
                            $gridImg = $serviceData['m_grid_1_'.$i] ?? $serviceData['pd_grid1_'.$i] ?? '';
                            if (empty($gridImg) && $i == 1) $gridImg = $work['image']; // Fallback for first slot
                            if (!empty($gridImg)):
                                $gridImagesFound++;
                        ?>
                            <div class="<?= ($i <= 2) ? 'col-6' : 'col-4' ?>">
                                <div class="rounded-4 overflow-hidden shadow-sm h-200px h-md-300px">
                                    <?php if (strpos($gridImg, '.mp4') !== false): ?>
                                        <video src="<?= $gridImg ?>" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>
                                    <?php else: ?>
                                        <img src="<?= $gridImg ?>" class="w-100 h-100 object-fit-cover" alt="Portfolio Showcase">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Result Section -->
    <section class="pt-10 pt-md-12 pb-10">
        <div class="container">
            <?php 
            $parallax = $serviceData['motion_parallax_1'] ?? $serviceData['pd_parallax'] ?? '';
            if (!empty($parallax)): ?>
                <div class="rounded-4 overflow-hidden mb-6 h-300px h-md-500px position-relative jarallax" data-speed="0.2">
                    <img class="jarallax-img" src="<?= $parallax ?>" alt="Visual Impact">
                </div>
            <?php endif; ?>

            <div class="row align-items-center g-4 g-md-6">
                <div class="col-md-6 order-md-2">
                    <div class="position-relative">
                        <?php 
                        $resultMedia = $serviceData['m_grid_2_1'] ?? $serviceData['pd_grid2_1'] ?? $work['image'];
                        if (!empty($resultMedia)): ?>
                            <?php if (strpos($resultMedia, '.mp4') !== false): ?>
                                <video src="<?= $resultMedia ?>" class="rounded-4 w-100 shadow-lg" autoplay loop muted playsinline></video>
                            <?php else: ?>
                                <img src="<?= $resultMedia ?>" class="rounded-4 w-100 shadow-lg" alt="Project Result">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="mb-4">The Result</h2>
                    <div class="project-result-content fs-5 mb-5">
                        <?= nl2br(htmlspecialchars($work['project_result'] ?: 'The final outcome represents our commitment to excellence, delivering measurable value and a premium visual presence for the client.')) ?>
                    </div>
                    
                    <div class="row g-4">
                        <?php 
                        $statsFound = false;
                        for($i=1; $i<=3; $i++): 
                            $val = $serviceData['motion_stat_'.$i.'_val'] ?? $serviceData['pd_stat_'.$i.'_val'] ?? $serviceData['stat_'.$i.'_val'] ?? '';
                            $label = $serviceData['motion_stat_'.$i.'_label'] ?? $serviceData['pd_stat_'.$i.'_label'] ?? $serviceData['stat_'.$i.'_label'] ?? '';
                            if (!empty($val)):
                                $statsFound = true;
                        ?>
                            <div class="col-4">
                                <h3 class="mb-0 text-primary-grad"><?= htmlspecialchars($val) ?></h3>
                                <p class="mb-0 small text-uppercase fw-bold text-muted"><?= htmlspecialchars($label) ?></p>
                            </div>
                        <?php endif; endfor; ?>
                        
                        <?php if (!$statsFound): ?>
                            <div class="col-4">
                                <h3 class="mb-0 text-primary-grad">100%</h3>
                                <p class="mb-0 small text-uppercase fw-bold text-muted">Quality</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text-primary-grad">Global</h3>
                                <p class="mb-0 small text-uppercase fw-bold text-muted">Impact</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
