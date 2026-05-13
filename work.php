<!DOCTYPE html>
<html lang="en">

<head>

    <title>Our Work — Weburea Agency | Portfolio & Case Studies</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea Agency">

    <meta name="description"
        content="Explore our portfolio of UI/UX design, web development, and branding projects. See how Weburea Agency helps businesses build and scale digital products.">

    <meta name="keywords"
        content="Weburea Portfolio, UI UX Design Projects, Web Development Case Studies, Branding Examples, Motion Graphics Work, Agency Portfolio Nigeria">

    <!-- Dark mode -->
    <?php include('include/dark_mode.php') ?>

    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="assets/css/main.css?v=<?php echo time(); ?>">

</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <section class="pt-xl-8 pb-5 pb-md-7">
            <!-- Title and content -->
            <div class="container text-center position-relative pt-4 pt-sm-5">
                <!-- Breadcrumb -->
                <nav class="d-flex justify-content-center mb-2" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0 mb-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our Work</li>
                    </ol>
                </nav>
                <!-- Title -->
                <h1>Our Work</h1>
            </div>
        </section>
        <!-- =======================
Hero END -->

        <!-- =======================
Portfolio START -->

        <section class="pt-0">
            <div class="container position-relative pb-5" id="portfolio-container">
                <!-- Continuous Timeline Tracks -->
                <div class="timeline-track d-none d-lg-block"></div>
                <div class="timeline-fluid d-none d-lg-block" id="timeline-fluid"></div>

                <div id="portfolio-list">
                    <!-- Dynamic portfolio items will be injected here via JS -->
                </div>

                <!-- Skeleton Container (Initially Hidden) -->
                <div id="skeleton-container" class="d-none"></div>

            </div>
            
            <div class="container pb-5">
                <!-- Load more button -->
                <div class="d-grid justify-content-center mt-6 position-relative z-index-9">
                    <button id="load-more-btn" class="btn btn-secondary mb-0"> Load more work </button>
                </div>
            </div>
        </section>

        <!-- Timeline Animation & Load More Logic -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timelineFluid = document.getElementById('timeline-fluid');
            const container = document.getElementById('portfolio-container');
            const portfolioList = document.getElementById('portfolio-list');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const skeletonContainer = document.getElementById('skeleton-container');
            
            let works = [];
            let displayedCount = 0;
            const itemsPerLoad = 4;

            // Fetch works from API
            async function fetchWorks() {
                // Show skeletons initially
                showSkeletons(itemsPerLoad);
                loadMoreBtn.style.display = 'none';

                try {
                    const res = await fetch('api/works.php');
                    const json = await res.json();
                    if(json.success && json.data.length > 0) {
                        works = json.data;
                        skeletonContainer.classList.add('d-none');
                        skeletonContainer.innerHTML = '';
                        renderWorks(itemsPerLoad);
                    } else {
                        skeletonContainer.innerHTML = '<p class="text-center mt-5">No portfolio works found.</p>';
                    }
                } catch(err) {
                    console.error("Failed to load works:", err);
                    skeletonContainer.innerHTML = '<p class="text-center mt-5 text-danger">Failed to load works.</p>';
                }
            }

            function renderWorks(count) {
                const limit = Math.min(displayedCount + count, works.length);
                
                for(let i = displayedCount; i < limit; i++) {
                    const w = works[i];
                    const isEven = i % 2 !== 0; // Alternating layout
                    
                    // Split categories into li items
                    const catsHtml = (w.categories || '').split(',').map(c => 
                        c.trim() ? `<li class="nav-item heading-color">${c.trim()}</li>` : ''
                    ).join('');

                    const isVideo = w.image && (w.image.toLowerCase().endsWith('.mp4') || w.image.toLowerCase().endsWith('.webm'));
                    const mediaHtml = isVideo 
                        ? `<video src="${w.image}" class="rounded-4 img-scale w-100" style="object-fit:cover; aspect-ratio:4/3" autoplay loop muted playsinline></video>`
                        : `<img src="${w.image || 'assets/images/logo.svg'}" class="rounded-4 img-scale w-100" style="object-fit:cover; aspect-ratio:4/3" alt="portfolio image">`;

                    const html = `
                    <div class="card card-img-scale bg-transparent p-0 mb-4 mb-lg-0">
                        <span class="position-absolute top-50 start-50 translate-middle rounded-circle timeline-dot d-none d-lg-block">
                            <span class="d-block rounded-circle bg-body p-1"> </span>
                        </span>
                        <div class="row align-items-center g-0">
                            ${isEven ? `
                            <div class="col-lg-6 order-2">
                                <div class="card-body px-2 p-lg-5">
                                    <div class="mb-3 mb-lg-4" style="min-height: 50px; display: flex; align-items: center;">
                                        ${w.client_logo_dark ? `<img src="${w.client_logo_dark}" class="light-mode-item h-50px" style="width: auto; max-width: 200px; object-fit: contain; object-position: left;" alt="client logo">` : `<img src="assets/images/logo.svg" class="light-mode-item h-40px" alt="agency logo">`}
                                        ${w.client_logo_light ? `<img src="${w.client_logo_light}" class="dark-mode-item h-50px" style="width: auto; max-width: 200px; object-fit: contain; object-position: left;" alt="client logo">` : `<img src="assets/images/logo-light.svg" class="dark-mode-item h-40px" alt="agency logo">`}
                                    </div>
                                    <h5 class="mb-3">${w.title}</h5>
                                    <p>${w.description}</p>
                                    <ul class="nav nav-divider align-items-center mb-3 mb-lg-4">
                                        ${w.year ? `<li class="nav-item heading-color">${w.year}</li>` : ''}
                                        ${catsHtml}
                                    </ul>
                                    <a href="work-view.php?id=${w.id}" class="link-primary-grad icon-link icon-link-hover text-primary">View project <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 p-lg-5">
                                <div class="card-img-scale-wrapper rounded-4">
                                    <a href="work-view.php?id=${w.id}">${mediaHtml}</a>
                                </div>
                            </div>
                            ` : `
                            <div class="col-lg-6 p-lg-5">
                                <div class="card-img-scale-wrapper rounded-4">
                                    <a href="work-view.php?id=${w.id}">${mediaHtml}</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body px-2 p-lg-5">
                                    <div class="mb-3 mb-lg-4" style="min-height: 50px; display: flex; align-items: center;">
                                        ${w.client_logo_dark ? `<img src="${w.client_logo_dark}" class="light-mode-item h-50px" style="width: auto; max-width: 150px; object-fit: contain; object-position: left;" alt="client logo">` : `<img src="assets/images/logo.svg" class="light-mode-item h-40px" alt="agency logo">`}
                                        ${w.client_logo_light ? `<img src="${w.client_logo_light}" class="dark-mode-item h-50px" style="width: auto; max-width: 150px; object-fit: contain; object-position: left;" alt="client logo">` : `<img src="assets/images/logo-light.svg" class="dark-mode-item h-40px" alt="agency logo">`}
                                    </div>
                                    <h5 class="mb-3">${w.title}</h5>
                                    <p>${w.description}</p>
                                    <ul class="nav nav-divider align-items-center mb-3 mb-lg-4">
                                        ${w.year ? `<li class="nav-item heading-color">${w.year}</li>` : ''}
                                        ${catsHtml}
                                    </ul>
                                    <a href="work-view.php?id=${w.id}" class="link-primary-grad icon-link icon-link-hover text-primary">View project <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                            `}
                        </div>
                    </div>
                    `;
                    portfolioList.insertAdjacentHTML('beforeend', html);
                }
                
                displayedCount = limit;

                // Update timeline dots mapping
                updateTimeline();

                if(displayedCount < works.length) {
                    loadMoreBtn.style.display = 'inline-block';
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }

            function showSkeletons(count) {
                skeletonContainer.classList.remove('d-none');
                skeletonContainer.innerHTML = '';
                for(let i = 0; i < count; i++) {
                    const isEven = (displayedCount + i) % 2 !== 0; 
                    const skeletonHtml = `
                    <div class="card card-img-scale bg-transparent p-0 mb-4 mb-lg-0 skeleton-card">
                        <span class="position-absolute top-50 start-50 translate-middle rounded-circle timeline-dot d-none d-lg-block z-index-2">
                            <span class="d-block rounded-circle bg-body p-1"></span>
                        </span>
                        <div class="row align-items-center g-0">
                            ${isEven ? `
                            <div class="col-lg-6 order-2">
                                <div class="card-body px-2 p-lg-5">
                                    <div class="skeleton-title"></div>
                                    <div class="skeleton-text"></div>
                                    <div class="skeleton-text w-75"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 p-lg-5">
                                <div class="skeleton-img"></div>
                            </div>
                            ` : `
                            <div class="col-lg-6 p-lg-5">
                                <div class="skeleton-img"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body px-2 p-lg-5">
                                    <div class="skeleton-title"></div>
                                    <div class="skeleton-text"></div>
                                    <div class="skeleton-text w-75"></div>
                                </div>
                            </div>
                            `}
                        </div>
                    </div>`;
                    skeletonContainer.innerHTML += skeletonHtml;
                }
                updateTimeline();
            }

            // 1. Fluid Timeline Scroll Animation
            function updateTimeline() {
                const dots = document.querySelectorAll('.timeline-dot');
                if(!timelineFluid || !container) return;
                
                const rect = container.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                
                let scrollPercentage = 0;
                if (rect.top > viewportHeight / 2) {
                    scrollPercentage = 0;
                } else if (rect.bottom < viewportHeight / 2) {
                    scrollPercentage = 100;
                } else {
                    const totalDistance = rect.height;
                    const scrolledDistance = (viewportHeight / 2) - rect.top;
                    scrollPercentage = (scrolledDistance / totalDistance) * 100;
                }
                
                scrollPercentage = Math.max(0, Math.min(100, scrollPercentage));
                timelineFluid.style.height = scrollPercentage + '%';

                dots.forEach(dot => {
                    const dotRect = dot.getBoundingClientRect();
                    if (dotRect.top < viewportHeight / 2) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            window.addEventListener('scroll', updateTimeline);
            window.addEventListener('resize', updateTimeline);

            // Load more event
            if(loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadMoreBtn.style.display = 'none';
                    showSkeletons(itemsPerLoad);
                    
                    setTimeout(() => {
                        skeletonContainer.classList.add('d-none');
                        skeletonContainer.innerHTML = '';
                        renderWorks(itemsPerLoad);
                    }, 1000);
                });
            }

            // Init fetch
            fetchWorks();
        });
        </script>
        <!-- =======================
Portfolio END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <!-- =======================
Footer START -->
    <?php include('include/front_footer.php') ?>
    <!-- =======================
Footer END -->

    <!-- Back to top -->
    <div class="back-top"></div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>