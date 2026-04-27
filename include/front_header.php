<?php
require_once('db.php');
// Fetch active services for the dropdown
try {
    $stmt = $pdo->query("SELECT name, slug, description_short FROM services WHERE status = 'active' ORDER BY id ASC");
    $header_services = $stmt->fetchAll();

    // Fetch dynamic header components
    $stmtNav = $pdo->query("SELECT * FROM site_components WHERE component_type = 'header_nav' AND status = 'active' ORDER BY sort_order ASC, id ASC");
    $header_navs = $stmtNav->fetchAll(PDO::FETCH_ASSOC);

    // Fetch global media assets (like services cta)
    $stmtMedia = $pdo->query("SELECT label, image FROM site_components WHERE component_type = 'global_media' AND status = 'active'");
    $global_media = $stmtMedia->fetchAll(PDO::FETCH_KEY_PAIR); // label as key, image as value
    
    // Alternative: fetch by special_type for more precision
    $stmtCta = $pdo->query("SELECT image FROM site_components WHERE special_type = 'services_cta' AND status = 'active' LIMIT 1");
    $services_cta_img = $stmtCta->fetchColumn();
} catch (Exception $e) {
    $header_services = [];
    $header_navs = [];
    $services_cta_img = 'assets/images/elements/nav-cta.jpg';
}
?>
<header class="header-sticky header-absolute" <?php if(isset($header_theme)) echo 'data-bs-theme="' . htmlspecialchars($header_theme) . '"'; ?>>
    <!-- Logo Nav START -->
    <nav class="navbar navbar-expand-xl">
        <div class="container">
            <!-- Logo START -->
            <a class="navbar-brand me-0" href="index.php">
                <img class="light-mode-item navbar-brand-item" src="assets/images/logo.svg" alt="logo">
                <img class="dark-mode-item navbar-brand-item" src="assets/images/logo-light.svg" alt="logo">
            </a>
            <!-- Logo END -->

            <!-- Main navbar START -->
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll dropdown-hover mx-auto">
                    <?php 
                    $current_page = basename($_SERVER['PHP_SELF']);
                    if (!empty($header_navs)): 
                        foreach($header_navs as $nav): 
                            // Determine if this nav item is active
                            $is_active = false;
                            $nav_url = $nav['url'];
                            
                            if ($nav['special_type'] == 'services_dropdown') {
                                // Services is active if on all_services or single_services
                                if ($current_page == 'all_services.php' || $current_page == 'single_services.php') {
                                    $is_active = true;
                                }
                            } else {
                                if ($current_page == $nav_url) {
                                    $is_active = true;
                                }
                            }
                            
                            $active_class = $is_active ? 'active' : '';
                            
                            if ($nav['special_type'] == 'services_dropdown'): 
                    ?>
                                <!-- Services Megamenu START -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?php echo $active_class; ?>" href="#" data-bs-auto-close="outside"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($nav['label']); ?></a>

                                    <div class="dropdown-menu dropdown-menu-size-xl dropdown-menu-center p-xl-3">
                                        <div class="row row-cols-1 row-cols-md-2 pt-2">
                                            <!-- All Services -->
                                            <div class="col">
                                                <div class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                    <div class="d-flex">
                                                        <div class="icon-md bg-primary bg-opacity-15 text-primary rounded flex-shrink-0">
                                                            <i class="bi bi-grid-fill fs-6"></i>
                                                        </div>
                                                        <div class="mx-3">
                                                            <p class="stretched-link heading-color fw-bold mb-0">
                                                                <a href="all_services.php">All Services</a>
                                                            </p>
                                                            <p class="mb-0 text-body small">Explore our full range of creative and tech solutions.</p>
                                                        </div>
                                                    </div>
                                                    <a class="icon-link icon-link-hover text-primary-hover stretched-link" href="all_services.php"><i class="bi bi-chevron-right"></i></a>
                                                </div>
                                            </div>

                                            <?php 
                                            $icons = [
                                                'bi-pencil-square text-success',
                                                'bi-palette text-pink',
                                                'bi-camera-reels text-warning',
                                                'bi-bug text-info',
                                                'bi-code-slash text-purple',
                                                'bi-megaphone text-info',
                                                'bi-film text-danger'
                                            ];
                                            $i = 0;
                                            foreach($header_services as $hs): 
                                                $icon_class = $icons[$i % count($icons)];
                                                $i++;
                                            ?>
                                            <!-- Dynamic Service Item -->
                                            <div class="col">
                                                <div class="dropdown-item bg-secondary-hover d-flex align-items-center justify-content-between position-relative text-wrap py-3">
                                                    <div class="d-flex">
                                                        <div class="icon-md bg-opacity-15 rounded flex-shrink-0">
                                                            <i class="bi <?php echo $icon_class; ?> fs-6"></i>
                                                        </div>
                                                        <div class="mx-3">
                                                            <p class="stretched-link heading-color fw-bold mb-0">
                                                                <a href="single_services.php?slug=<?php echo $hs['slug']; ?>"><?php echo $hs['name']; ?></a>
                                                            </p>
                                                            <p class="mb-0 text-body small">
                                                                <?php 
                                                                    $words = explode(' ', $hs['description_short']);
                                                                    echo implode(' ', array_slice($words, 0, 8)) . (count($words) > 8 ? '...' : '');
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <a class="icon-link icon-link-hover text-primary-hover stretched-link"
                                                        href="single_services.php?slug=<?php echo $hs['slug']; ?>"><i class="bi bi-chevron-right"></i></a>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- CTA Background -->
                                        <div class="h-200px position-relative mt-3"
                                            style="background:url(<?php echo !empty($services_cta_img) ? $services_cta_img : 'assets/images/elements/nav-cta.jpg'; ?>) no-repeat; background-size:cover; background-position:center;">
                                            <div class="bg-overlay bg-dark bg-opacity-10"></div>
                                        </div>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="nav-item"> <a class="nav-link <?php echo $active_class; ?>" href="<?php echo htmlspecialchars($nav['url']); ?>"><?php echo htmlspecialchars($nav['label']); ?></a> </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Main navbar END -->

            <!-- Buttons -->
            <ul class="nav align-items-center dropdown-hover ms-sm-2">
                <!-- Dark mode option START -->
                <li class="nav-item dropdown dropdown-animation">
                    <button class="btn btn-link mb-0 px-2 lh-1" id="bd-theme" type="button" aria-expanded="false"
                        data-bs-toggle="dropdown" data-bs-display="static">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            class="bi bi-circle-half theme-icon-active fill-mode fa-fw" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                            <use href="#"></use>
                        </svg>
                    </button>

                    <ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
                        <li class="mb-1">
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="light">
                                <svg width="16" height="16" fill="currentColor"
                                    class="bi bi-brightness-high-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                                    <use href="#"></use>
                                </svg>Light
                            </button>
                        </li>
                        <li class="mb-1">
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-moon-stars-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                                    <path
                                        d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                                    <use href="#"></use>
                                </svg>Dark
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active"
                                data-bs-theme-value="auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-circle-half fa-fw mode-switch me-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                                    <use href="#"></use>
                                </svg>Auto
                            </button>
                        </li>
                    </ul>
                </li>
                <!-- Dark mode option END -->

                <!-- Sign up button -->
                <li class="nav-item ms-2 d-none d-sm-block">
                    <a href="https://calendly.com/" class="btn btn-sm btn-primary-grad mb-0">Book a Call</a>
                </li>
                <!-- Responsive navbar toggler -->
                <li class="nav-item">
                    <button class="navbar-toggler weburea-toggler ms-sm-3"
                        type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="weburea-toggler-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </li>
            </ul>

        </div>
    </nav>
    <!-- Logo Nav END -->
</header>