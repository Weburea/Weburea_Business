<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - Home Page Management</title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea">

    <!-- Dark mode -->
    <script src="assets/js/dark-mode.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon/Vector.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/OverlayScrollbars.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css?v=<?= time() ?>">

</head>

<body>
    <!-- =======================
Header START -->
    <?php include 'include/header.php'; ?>
    <!-- =======================
Header END -->

    <main>
        <section class="py-4">
            <div class="container">
                <div class="row pb-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h2 mb-2">Home Page Configuration</h1>
                        <p class="text-secondary">Manage sections, content, and visual elements of your landing page</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="storage-card shadow-lg">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-white mb-0"><i class="bi bi-hdd-network me-2"></i>Storage Usage</h6>
                                <span class="badge bg-primary" id="storage-count">0 files</span>
                            </div>
                            <div class="storage-progress">
                                <div id="storage-bar" class="storage-progress-bar" style="width: 0%"></div>
                            </div>
                            <div class="d-flex justify-content-between small opacity-75">
                                <span id="storage-used">0 MB</span>
                                <span>Limit: 500 MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="text-center mb-4">
                    <ul class="nav nav-tabs premium-nav-tabs justify-content-center mb-4 px-3" id="homeTabs"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="hero-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-hero" type="button" role="tab"><i
                                    class="bi bi-megaphone me-2"></i>Hero Banner</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#tab-gallery"
                                type="button" role="tab"><i class="bi bi-images me-2"></i>Gallery</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#tab-stats"
                                type="button" role="tab"><i class="bi bi-graph-up-arrow me-2"></i>Statistics</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="benefits-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-benefits" type="button" role="tab"><i
                                    class="bi bi-star me-2"></i>Benefits</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advantages-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-advantages" type="button" role="tab"><i
                                    class="bi bi-person-badge me-2"></i>Advantages</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews"
                                type="button" role="tab"><i class="bi bi-people me-2"></i>Trusted Leaders</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="testimonials-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-testimonials" type="button" role="tab"><i
                                    class="bi bi-chat-quote me-2"></i>Testimonials</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cta-tab" data-bs-toggle="tab" data-bs-target="#tab-cta"
                                type="button" role="tab"><i class="bi bi-lightning-charge me-2"></i>Call To
                                Action</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="enterprise-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-enterprise" type="button" role="tab"><i
                                    class="bi bi-building me-2"></i>Enterprise</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="homeTabsContent">
                    <!-- Tab: Hero -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-megaphone"></i></div>
                                <div>
                                    <h4 class="mb-0">Main Hero Section</h4>
                                    <small class="text-secondary">Adjust titles, subtext, and call-to-action
                                        buttons</small>
                                </div>
                            </div>
                            <form id="hero-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Pre-Title Badge</label>
                                        <input type="text" name="pre_title" class="form-control"
                                            placeholder="Creativity in Motion">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Main Title Prefix</label>
                                        <input type="text" name="main_title_prefix" class="form-control"
                                            placeholder="We build meaningful experiences with">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Lead Paragraph</label>
                                        <textarea name="lead_text" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-3">
                                            <h6 class="mb-3">Button 1 (Primary)</h6>
                                            <div class="mb-2">
                                                <label class="form-label small">Text</label>
                                                <input type="text" name="btn1_text"
                                                    class="form-control form-control-sm">
                                            </div>
                                            <div>
                                                <label class="form-label small">Link / URL</label>
                                                <input type="text" name="btn1_link"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-3">
                                            <h6 class="mb-3">Button 2 (Secondary)</h6>
                                            <div class="mb-2">
                                                <label class="form-label small">Text</label>
                                                <input type="text" name="btn2_text"
                                                    class="form-control form-control-sm">
                                            </div>
                                            <div>
                                                <label class="form-label small">Link / URL</label>
                                                <input type="text" name="btn2_link"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i
                                                class="bi bi-check2-circle me-2"></i>Save Hero Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Gallery -->
                    <div class="tab-pane fade" id="tab-gallery" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-images"></i></div>
                                <div>
                                    <h4 class="mb-0">Scrolling Image Ticker</h4>
                                    <small class="text-secondary">Manage images displayed in the automated scrolling
                                        gallery</small>
                                </div>
                            </div>
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Portfolio Screenshots (<span id="gallery-count">0</span>)</h6>
                                    <small class="text-secondary d-block mt-1">Upload Location: <span
                                            class="badge text-dark" style="border: 1px solid var(--premium-card-border); background: var(--premium-body-bg);">assets/uploads/portfolio/</span></small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="openMediaSelector('gallery')">
                                    <i class="bi bi-plus-lg me-1"></i>Add Screenshot
                                </button>
                            </div>
                            <div class="gallery-grid" id="gallery-container">
                                <!-- Dynamic Items -->
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-premium" onclick="saveGallery()"><i
                                        class="bi bi-check2-circle me-2"></i>Save Gallery</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Stats -->
                    <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-graph-up-arrow"></i></div>
                                <div>
                                    <h4 class="mb-0">Impact Statistics</h4>
                                    <small class="text-secondary">Numerical data shown in the workflow section</small>
                                </div>
                            </div>
                            <div id="stats-container">
                                <!-- Dynamic Stat Rows -->
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-premium" onclick="saveStats()"><i
                                        class="bi bi-check2-circle me-2"></i>Save Statistics</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Benefits -->
                    <div class="tab-pane fade" id="tab-benefits" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-star"></i></div>
                                <div>
                                    <h4 class="mb-0">Benefits & Floating Icons</h4>
                                    <small class="text-secondary">Control the "Streamline Operations" section</small>
                                </div>
                            </div>
                            <form id="benefits-form">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Section Title (HTML
                                            supported)</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Description</label>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <h6 class="mb-3">Benefits Icons (V-Shape Arrangement)</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover align-middle border table-premium">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 60px;">Pos</th>
                                                        <th style="width: 80px;">Preivew</th>
                                                        <th style="min-width: 180px;">Name / Tooltip</th>
                                                        <th style="min-width: 250px;">Path</th>
                                                        <th style="width: 150px;">Size</th>
                                                        <th style="width: 150px;">Shadow</th>
                                                        <th class="text-center" style="width: 100px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="benefits-icons-body">
                                                    <!-- Dynamic rows for 9 icons -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i
                                                class="bi bi-check2-circle me-2"></i>Save Benefits</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Advantages -->
                    <div class="tab-pane fade" id="tab-advantages" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-person-badge"></i></div>
                                <div>
                                    <h4 class="mb-0">Advantages & Experts</h4>
                                    <small class="text-secondary">Manage the "Full scope advantages" card</small>
                                </div>
                            </div>
                            <form id="advantages-form">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Main Text</label>
                                        <input type="text" name="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Link Text</label>
                                        <input type="text" name="link_text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Link URL</label>
                                        <input type="text" name="link_url" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <h6 class="mb-3">Expert Avatars List</h6>
                                        <div id="avatars-container" class="d-flex flex-wrap gap-3 mb-3">
                                            <!-- Dynamic avatars with remove buttons -->
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="openMediaSelector('avatars')">
                                            <i class="bi bi-person-plus me-1"></i>Add Avatar
                                        </button>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i
                                                class="bi bi-check2-circle me-2"></i>Save Advantages</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Tab: Reviews -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-people"></i></div>
                                <div>
                                    <h4 class="mb-0">Trusted Leaders & Reviews</h4>
                                    <small class="text-secondary">Manage customer testimonials and the vertical marquee
                                        layout</small>
                                </div>
                            </div>
                            <form id="reviews-form">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Section Title</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Trusted by industry leaders">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-base fw-bold">Rating Badge</label>
                                        <input type="text" name="rating_badge" class="form-control"
                                            placeholder="4.9/5.0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-base fw-bold">Rating Subtext</label>
                                        <input type="text" name="rating_text" class="form-control"
                                            placeholder="by over 100,000+ users">
                                    </div>

                                    <div class="col-12">
                                        <h6 class="mb-3">Rating Avatars (Group)</h6>
                                        <div id="rating-avatars-container" class="d-flex flex-wrap gap-3 mb-3">
                                            <!-- Dynamic rating avatars -->
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="openMediaSelector('rating_avatar')">
                                            <i class="bi bi-plus-circle me-1"></i>Add Rating Avatar
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h6 class="mb-0">Review Cards List</h6>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="addReviewCard()">
                                                <i class="bi bi-plus-lg me-1"></i>Add New Review
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle border table-premium">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 100px;">Avatar</th>
                                                        <th style="width: 170px;">Author Info</th>
                                                        <th style="width: auto;">Review Content</th>
                                                        <th style="width: 180px;">Column</th>
                                                        <th style="width: 180px;">Social</th>
                                                        <th class="text-end" style="width: 120px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="reviews-list-body">
                                                    <!-- Dynamic review items -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i
                                                class="bi bi-check2-circle me-2"></i>Save Reviews Configuration</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Testimonials -->
                    <div class="tab-pane fade" id="tab-testimonials" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-chat-quote"></i></div>
                                <div>
                                    <h4 class="mb-0">Client Testimonials Slider</h4>
                                    <small class="text-secondary">Manage the premium slider testimonials and platform
                                        ratings</small>
                                </div>
                            </div>
                            <form id="testimonials-form">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Section Title <small> (add fun
                                                emojies)</small></label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Client Testimonials 😍">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Subtitle / Platform Text</label>
                                        <input type="text" name="clients_text" class="form-control"
                                            placeholder="More than 500+ clients using Weburea platform">
                                    </div>

                                    <div class="col-12">
                                        <h6 class="mb-3">Platform Ratings</h6>
                                        <div class="row g-3" id="platform-ratings-container">
                                            <!-- Dynamic platform ratings -->
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h6 class="mb-0">Testimonial Items List</h6>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="addTestimonialItem()">
                                                <i class="bi bi-plus-lg me-1"></i>Add New Testimonial
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle border table-premium">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 100px;">Avatar</th>
                                                        <th style="min-width: 200px;">Author Info</th>
                                                        <th style="min-width: 400px;">Quote / Testimonial</th>
                                                        <th style="width: 150px;">Rating</th>
                                                        <th class="text-end" style="width: 120px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="testimonials-list-body">
                                                    <!-- Dynamic testimonial items -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i
                                                class="bi bi-check2-circle me-2"></i>Save Testimonials</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                        <div class="home-card">
                            <div class="card-header border-bottom">
                                <h5 class="mb-0"><i class="bi bi-lightning-charge text-primary me-2"></i>Call To Action
                                    Banner Settings</h5>
                            </div>
                            <form id="cta-form" class="card-body" onsubmit="event.preventDefault(); saveCta();">
                                <div class="row g-4">
                                    <div class="col-md-6 pt-3">
                                        <label class="form-label small">Title Prefix</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="col-md-6  pt-3">
                                        <label class="form-label small">Title Highlight (Gradient Gradient)</label>
                                        <input type="text" name="title_highlight" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Button Text</label>
                                        <input type="text" name="btn_text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Button Link</label>
                                        <input type="text" name="btn_link" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="mb-3">Feature Checklist Items</h6>
                                        <div id="cta-list-items-container" class="d-flex flex-column gap-2 mb-3">
                                            <!-- Dynamic items -->
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="addCtaListItem()">
                                            <i class="bi bi-plus-circle me-1"></i>Add Checklist Item
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Enterprise -->
                    <div class="tab-pane fade" id="tab-enterprise" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-building"></i></div>
                                <div>
                                    <h4 class="mb-0">Enterprise Plan Card</h4>
                                    <small class="text-secondary">Manage the dynamic custom plan shown on the pricing page</small>
                                </div>
                            </div>
                            <form id="enterprise-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Section Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enterprise plan">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Price Text</label>
                                        <input type="text" name="price_text" class="form-control" placeholder="Custom">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Description</label>
                                        <textarea name="description" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Text</label>
                                        <input type="text" name="btn_text" class="form-control" placeholder="Contact us">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Link</label>
                                        <input type="text" name="btn_link" class="form-control" placeholder="#">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <h6 class="mb-3">Quick Look Features</h6>
                                        <div id="enterprise-features-container" class="d-flex flex-column gap-2 mb-3">
                                            <!-- Dynamic items -->
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addEnterpriseFeature()">
                                            <i class="bi bi-plus-circle me-1"></i>Add Feature Item
                                        </button>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Enterprise Plan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img id="previewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="upload-tab">
                        <div class="p-4 text-center border-dashed rounded" style="border: 2px dashed #cbd5e1;">
                            <input type="file" id="media-upload-input" class="d-none" onchange="handleFileUpload(this)">
                            <label for="media-upload-input" style="cursor: pointer;">
                                <i class="bi bi-cloud-arrow-up display-4 text-secondary"></i>
                                <p class="mt-2">Click to upload or drag and drop</p>
                                <small class="text-secondary">Images (PNG, JPG, SVG) or Videos (MP4)</small>
                            </label>
                            <div id="upload-progress" class="mt-3 d-none">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>
    <script src="assets/js/functions.js"></script>

    <script>
        let fullConfig = {};
        let mediaTarget = null; // Used to track which field/array will receive the selected path

        async function fetchConfig() {
            try {
                const res = await fetch('../api/home_config.php');
                const result = await res.json();
                if (result.success) {
                    result.data.forEach(item => {
                        fullConfig[item.section_key] = item.section_content;
                    });
                    initHeroForm();
                    initGalleryUI();
                    initStatsUI();
                    initBenefitsForm();
                    initAdvantagesForm();
                    initReviewsForm();
                    initTestimonialsUI();
                    initCtaForm();
                    initEnterpriseForm();
                    fetchStorageInfo();
                }
            } catch (err) {
                console.error('Fetch failed', err);
            }
        }

        async function fetchStorageInfo() {
            try {
                const res = await fetch('../api/home_config.php?action=storage');
                const data = await res.json();
                if (data.success) {
                    document.getElementById('storage-used').textContent = data.usage_formatted;
                    document.getElementById('storage-count').textContent = data.file_count + ' files';
                    const pct = Math.min(100, (data.usage_bytes / data.quota_bytes) * 100);
                    document.getElementById('storage-bar').style.width = pct + '%';
                }
            } catch (e) { }
        }

        // Media Selector Logic
        const mediaModal = new bootstrap.Modal(document.getElementById('mediaModal'));

        function openMediaSelector(targetType, extra = null) {
            mediaTarget = { type: targetType, extra: extra };
            mediaModal.show();
        }

        async function handleFileUpload(input) {
            if (!input.files || !input.files[0]) return;

            const progress = document.getElementById('upload-progress');
            progress.classList.remove('d-none');
            const bar = progress.querySelector('.progress-bar');

            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('media_type', mediaTarget.type === 'gallery' ? 'portfolio' : (mediaTarget.type === 'avatars' ? 'avatars' : 'icons'));
            formData.append('prefix', mediaTarget.type);

            try {
                const res = await fetch('../api/media-manager.php', {
                    method: 'POST',
                    headers: { 'X-API-Key': 'weburea_secret_2026' },
                    body: formData
                });
                const result = await res.json();
                if (result.success) {
                    selectPath(result.path);
                    fetchStorageInfo(); // Refresh storage after upload
                    showToast('File uploaded successfully', 'success');
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (err) {
                showToast('Upload failed', 'danger');
            } finally {
                progress.classList.add('d-none');
                input.value = '';
            }
        }

        function selectPath(path) {
            if (mediaTarget.type === 'gallery') {
                fullConfig.gallery.images.push(path);
                initGalleryUI();
                saveGallery(); // Auto-save for gallery
            } else if (mediaTarget.type === 'avatars') {
                fullConfig.advantages.avatars.push(path);
                initAdvantagesForm();
                saveAdvantages(); // Need to define this or call updateSection
            } else if (mediaTarget.type === 'benefit_icon') {
                const idx = mediaTarget.extra;
                fullConfig.benefits.floating_icons[idx].img = path;
                renderBenefitsIcons();
                saveBenefits(); // Auto-save for benefits too
            } else if (mediaTarget.type === 'rating_avatar') {
                fullConfig.reviews.rating_avatars.push(path);
                renderRatingAvatars();
                saveReviews();
            } else if (mediaTarget.type === 'review_author_avatar') {
                const idx = mediaTarget.extra;
                fullConfig.reviews.review_cards[idx].avatar = path;
                renderReviewsList();
                saveReviews();
            } else if (mediaTarget.type === 'testimonial_avatar') {
                const idx = mediaTarget.extra;
                fullConfig.testimonials.testimonial_items[idx].avatar = path;
                renderTestimonialsList();
                saveTestimonials();
            } else if (mediaTarget.type === 'platform_icon') {
                const idx = mediaTarget.extra;
                fullConfig.testimonials.platform_ratings[idx].icon = path;
                renderPlatformRatings();
                saveTestimonials();
            }
            mediaModal.hide();
        }

        async function saveAdvantages() {
            const formData = new FormData(document.getElementById('advantages-form'));
            const content = Object.fromEntries(formData.entries());
            content.avatars = fullConfig.advantages.avatars;
            await updateSection('advantages', content);
        }

        // Hero
        function initHeroForm() {
            const form = document.getElementById('hero-form');
            const data = fullConfig['hero'];
            Object.keys(data).forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key];
            });
        }

        document.getElementById('hero-form').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const content = Object.fromEntries(formData.entries());
            await updateSection('hero', content);
        }

        // Gallery
        function initGalleryUI() {
            const container = document.getElementById('gallery-container');
            const images = fullConfig['gallery'].images || [];
            document.getElementById('gallery-count').textContent = images.length;
            container.innerHTML = images.map((img, i) => `
                <div class="gallery-item group">
                    <img src="../${img}" onerror="this.src='../assets/images/logo.svg'" onclick="showImagePreview('../${img}')" style="cursor: zoom-in;">
                    <button class="remove-btn" onclick="removeImage(${i})">Remove</button>
                    <button type="button" class="view-btn" onclick="showImagePreview('../${img}')">
                        <i class="bi bi-eye me-1"></i> Preview
                    </button>
                </div>
            `).join('');
        }

        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        function showImagePreview(path) {
            document.getElementById('previewImage').src = path;
            previewModal.show();
        }

        function removeImage(index) {
            showPremiumDeleteModal(
                'Delete Portfolio Screenshot?',
                'This screenshot will be permanently removed from the ticker.',
                async () => {
                    fullConfig['gallery'].images.splice(index, 1);
                    initGalleryUI();
                    saveGallery();
                    showToast('Screenshot removed', 'success');
                },
                'dark'
            );
        }

        async function saveGallery() {
            await updateSection('gallery', fullConfig['gallery']);
        }

        // Stats
        function initStatsUI() {
            const container = document.getElementById('stats-container');
            const counters = fullConfig['stats'].counters || [];

            // 1. Render rows with placeholders for custom selects
            container.innerHTML = counters.map((stat, i) => `
                <div class="stat-input-row" id="stat-row-${i}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <label class="small text-secondary fw-bold">LABEL</label>
                            <input type="text" class="form-control form-control-sm" value="${stat.label}" onchange="updateStatValue(${i}, 'label', this.value)">
                        </div>
                        <div class="col-md-2">
                            <label class="small text-secondary fw-bold">VALUE</label>
                            <input type="number" class="form-control form-control-sm" value="${stat.value}" onchange="updateStatValue(${i}, 'value', this.value)">
                        </div>
                        <div class="col-md-2">
                            <label class="small text-secondary fw-bold">SUFFIX</label>
                            <input type="text" class="form-control form-control-sm" value="${stat.suffix}" onchange="updateStatValue(${i}, 'suffix', this.value)">
                        </div>
                         <div class="col-md-3">
                            <label class="small text-secondary fw-bold">COLOR</label>
                            <div id="stat-color-container-${i}"></div>
                        </div>
                    </div>
                </div>
            `).join('');

            // 2. Initialize premium selects
            counters.forEach((stat, i) => {
                const colorOptions = [
                    { value: 'primary', label: 'Blue (Primary)', icon: 'bi-circle-fill text-primary' },
                    { value: 'pink', label: 'Pink', icon: 'bi-circle-fill text-pink' },
                    { value: 'info', label: 'Cyan (Info)', icon: 'bi-circle-fill text-info' },
                    { value: 'warning', label: 'Orange (Warning)', icon: 'bi-circle-fill text-warning' }
                ];
                renderPremiumSelect(`stat-color-container-${i}`, colorOptions, stat.color, (val) => {
                    updateStatValue(i, 'color', val);
                });
            });
        }

        function updateStatValue(i, key, val) {
            fullConfig['stats'].counters[i][key] = (key === 'value') ? parseInt(val) : val;
        }

        async function saveStats() {
            await updateSection('stats', fullConfig['stats']);
        }

        // Benefits
        function initBenefitsForm() {
            const form = document.getElementById('benefits-form');
            const data = fullConfig['benefits'];
            // Fill title/desc/btn
            ['title', 'description', 'btn_text', 'btn_link'].forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key] || '';
            });

            // Ensure floating_icons exists (init with 9 if empty)
            if (!data.floating_icons || data.floating_icons.length === 0) {
                data.floating_icons = Array(9).fill().map((_, i) => ({
                    name: `Icon ${i + 1}`,
                    img: 'assets/images/logo.svg',
                    size: 'md',
                    shadow: 'sm'
                }));
            }
            renderBenefitsIcons();
        }

        function renderBenefitsIcons() {
            const body = document.getElementById('benefits-icons-body');
            const icons = fullConfig.benefits.floating_icons;

            // 1. Render table rows with placeholders
            body.innerHTML = icons.map((icon, i) => `
                <tr style="vertical-align: middle;">
                    <td class="small fw-bold text-center">${i + 1}</td>
                    <td>
                        <div class="avatar avatar-clickable p-1 border rounded bg-light d-inline-block shadow-sm" onclick="openMediaSelector('benefit_icon', ${i})">
                            <img src="../${icon.img}" style="height: 32px; width:32px; object-fit:contain;" alt="preview" onerror="this.src='../assets/images/logo.svg'">
                        </div>
                    </td>
                    <td><input type="text" class="form-control form-control-sm" value="${icon.name}" onchange="fullConfig.benefits.floating_icons[${i}].name = this.value"></td>
                    <td><input type="text" class="form-control form-control-sm text-muted small" value="${icon.img}" readonly style="background: #f8fafc; font-size: 0.75rem;"></td>
                    <td style="width: 140px;"><div id="benefit-size-container-${i}"></div></td>
                    <td style="width: 140px;"><div id="benefit-shadow-container-${i}"></div></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-light-primary" onclick="openMediaSelector('benefit_icon', ${i})"><i class="bi bi-image text-primary"></i></button>
                    </td>
                </tr>
            `).join('');

            // 2. Initialize premium selects
            icons.forEach((icon, i) => {
                const sizeOptions = [
                    { value: 'md', label: 'Medium' },
                    { value: 'lg', label: 'Large' },
                    { value: 'xl', label: 'X-Large' },
                    { value: 'xxl', label: 'XX-Large' }
                ];
                const shadowOptions = [
                    { value: 'sm', label: 'Small' },
                    { value: 'md', label: 'Medium' },
                    { value: 'xl', label: 'None' }
                ];

                renderPremiumSelect(`benefit-size-container-${i}`, sizeOptions, icon.size, (val) => {
                    fullConfig.benefits.floating_icons[i].size = val;
                });
                renderPremiumSelect(`benefit-shadow-container-${i}`, shadowOptions, icon.shadow, (val) => {
                    fullConfig.benefits.floating_icons[i].shadow = val;
                });
            });
        }

        document.getElementById('benefits-form').onsubmit = async (e) => {
            e.preventDefault();
            saveBenefits();
        }

        async function saveBenefits() {
            const formData = new FormData(document.getElementById('benefits-form'));
            const content = Object.fromEntries(formData.entries());
            content.floating_icons = fullConfig['benefits'].floating_icons;
            await updateSection('benefits', content);
        }

        // Advantages
        function initAdvantagesForm() {
            const form = document.getElementById('advantages-form');
            const data = fullConfig['advantages'];
            ['text', 'link_text', 'link_url'].forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key] || '';
            });

            const container = document.getElementById('avatars-container');
            const avatars = data.avatars || [];
            container.innerHTML = avatars.map((path, i) => `
                <div class="position-relative">
                    <img src="../${path}" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;" onerror="this.src='../assets/images/avatar/default.jpg'">
                    <button type="button" class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle p-0" style="width:18px; height:18px;" onclick="removeAvatar(${i})">
                        <i class="bi bi-x small" style="font-size: 10px;"></i>
                    </button>
                </div>
            `).join('');
        }

        function removeAvatar(idx) {
            showPremiumDeleteModal(
                'Remove Expert Avatar?',
                'This avatar will be permanently removed.',
                async () => {
                    fullConfig.advantages.avatars.splice(idx, 1);
                    initAdvantagesForm();
                    saveAdvantages();
                    showToast('Avatar removed', 'success');
                },
                'dark'
            );
        }

        // CTA
        function initCtaForm() {
            const form = document.getElementById('cta-form');
            if (!fullConfig['cta']) fullConfig['cta'] = { list_items: [] };
            const data = fullConfig['cta'];

            ['title', 'title_highlight', 'btn_text', 'btn_link'].forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key] || '';
            });

            renderCtaListItems();
        }

        function renderCtaListItems() {
            const container = document.getElementById('cta-list-items-container');
            const items = fullConfig['cta']?.list_items || [];
            container.innerHTML = items.map((item, i) => `
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control" value="${item.replace(/"/g, '&quot;')}" onchange="fullConfig['cta'].list_items[${i}] = this.value">
                    <button type="button" class="btn btn-outline-danger" onclick="removeCtaListItem(${i})"><i class="bi bi-trash"></i></button>
                </div>
            `).join('');
        }

        function addCtaListItem() {
            if (!fullConfig['cta']) fullConfig['cta'] = { list_items: [] };
            if (!fullConfig['cta'].list_items) fullConfig['cta'].list_items = [];
            fullConfig['cta'].list_items.push('New Checklist Item');
            renderCtaListItems();
        }

        function removeCtaListItem(idx) {
            fullConfig['cta'].list_items.splice(idx, 1);
            renderCtaListItems();
        }

        // Reviews
        function initReviewsForm() {
            const form = document.getElementById('reviews-form');
            if (!fullConfig['reviews']) return;
            const data = fullConfig['reviews'];

            ['title', 'rating_badge', 'rating_text'].forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key] || '';
            });

            renderRatingAvatars();
            renderReviewsList();

            form.onsubmit = async (e) => {
                e.preventDefault();
                saveReviews();
            }
        }

        function renderRatingAvatars() {
            const container = document.getElementById('rating-avatars-container');
            const avatars = fullConfig.reviews?.rating_avatars || [];
            container.innerHTML = avatars.map((path, i) => `
                <div class="position-relative">
                    <img src="../${path}" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;" onerror="this.src='../assets/images/avatar/default.jpg'">
                    <button type="button" class="btn btn-danger btn-xs position-absolute top-0 start-100 translate-middle rounded-circle p-0" style="width:18px; height:18px;" onclick="removeRatingAvatar(${i})">
                        <i class="bi bi-x small" style="font-size: 10px;"></i>
                    </button>
                </div>
            `).join('');
        }

        function removeRatingAvatar(idx) {
            fullConfig.reviews.rating_avatars.splice(idx, 1);
            renderRatingAvatars();
            saveReviews();
        }

        function renderReviewsList() {
            const body = document.getElementById('reviews-list-body');
            const cards = fullConfig.reviews?.review_cards || [];

            body.innerHTML = cards.map((card, i) => `
                <tr>
                    <td>
                        <div class="avatar flex-shrink-0" onclick="openMediaSelector('review_author_avatar', ${i})" style="cursor:pointer">
                            <img class="avatar-img rounded-circle border" src="../${card.avatar}" style="width:48px; height:48px; object-fit:cover" onerror="this.src='../assets/images/avatar/default.jpg'">
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm mb-1" value="${card.name}" placeholder="Name" onchange="fullConfig.reviews.review_cards[${i}].name = this.value">
                        <input type="text" class="form-control form-control-sm" value="${card.handle}" placeholder="@handle" onchange="fullConfig.reviews.review_cards[${i}].handle = this.value">
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm" rows="4" onchange="fullConfig.reviews.review_cards[${i}].content = this.value">${card.content}</textarea>
                    </td>
                    <td>
                        <div id="review-column-select-${i}" style="min-width: 160px;"></div>
                    </td>
                    <td>
                        <div id="review-social-select-${i}"></div>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-light-danger" onclick="removeReviewCard(${i})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');

            // Initialize premium selects for each row
            cards.forEach((card, i) => {
                const columnOptions = [
                    { value: 1, label: 'Col-1 (Swiper)', icon: 'bi-grid-1x2' },
                    { value: 2, label: 'Col-2 (Static)', icon: 'bi-grid-fill' },
                    { value: 3, label: 'Col-3 (Swiper)', icon: 'bi-grid-3x3-gap' }
                ];
                renderPremiumSelect(`review-column-select-${i}`, columnOptions, card.column, (val) => {
                    fullConfig.reviews.review_cards[i].column = parseInt(val);
                });

                const socialOptions = [
                    { value: 'bi-facebook', label: 'Facebook', icon: 'bi-facebook' },
                    { value: 'bi-instagram', label: 'Instagram', icon: 'bi-instagram' },
                    { value: 'bi-twitter-x', label: 'Twitter/X', icon: 'bi-twitter-x' },
                    { value: 'bi-linkedin', label: 'LinkedIn', icon: 'bi-linkedin' },
                    { value: 'bi-tiktok', label: 'TikTok', icon: 'bi-tiktok' },
                    { value: 'bi-whatsapp', label: 'WhatsApp', icon: 'bi-whatsapp' }
                ];
                renderPremiumSelect(`review-social-select-${i}`, socialOptions, card.social_icon.replace('bi ', ''), (val) => {
                    fullConfig.reviews.review_cards[i].social_icon = 'bi ' + val;
                });
            });
        }

        function addReviewCard() {
            if (!fullConfig.reviews.review_cards) fullConfig.reviews.review_cards = [];
            fullConfig.reviews.review_cards.push({
                name: 'New Customer',
                handle: '@newhandle',
                avatar: 'assets/images/avatar/default.jpg',
                content: 'They did an amazing job...',
                social_icon: 'bi bi-twitter-x',
                column: 1
            });
            renderReviewsList();
        }

        function removeReviewCard(idx) {
            showPremiumDeleteModal(
                'Delete Review?',
                'Are you sure you want to remove this testimonial?',
                async () => {
                    fullConfig.reviews.review_cards.splice(idx, 1);
                    renderReviewsList();
                    saveReviews();
                },
                'dark'
            );
        }

        async function saveReviews() {
            const formData = new FormData(document.getElementById('reviews-form'));
            const content = Object.fromEntries(formData.entries());
            content.rating_avatars = fullConfig.reviews.rating_avatars;
            content.review_cards = fullConfig.reviews.review_cards;
            fullConfig.reviews = content;
            await updateSection('reviews', content);
        }

        async function saveCta() {
            const formData = new FormData(document.getElementById('cta-form'));
            const content = Object.fromEntries(formData.entries());
            content.list_items = fullConfig['cta']?.list_items || [];
            fullConfig['cta'] = content;
            await updateSection('cta', content);
        }

        // Testimonials
        function initTestimonialsUI() {
            const form = document.getElementById('testimonials-form');
            if (!fullConfig['testimonials']) return;
            const data = fullConfig['testimonials'];

            ['title', 'clients_text'].forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key] || '';
            });

            renderPlatformRatings();
            renderTestimonialsList();

            form.onsubmit = async (e) => {
                e.preventDefault();
                saveTestimonials();
            }
        }

        function renderPlatformRatings() {
            const container = document.getElementById('platform-ratings-container');
            const platforms = fullConfig.testimonials?.platform_ratings || [];
            container.innerHTML = platforms.map((p, i) => `
                <div class="col-md-6">
                    <div class="p-3 border rounded-4 bg-light-subtle shadow-sm mb-2" style="border: 2px solid #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-4">
                             <div class="avatar avatar-xl avatar-clickable flex-shrink-0" onclick="openMediaSelector('platform_icon', ${i})" style="width: 65px; height: 65px; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1;">
                                <img class="avatar-img" src="../${p.icon}" style="width:100%; height:100%; object-fit:contain; padding: 10px; background: white;" onerror="this.src='../assets/images/logo.svg'">
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-2">
                                    <label class="small text-secondary fw-bold mb-1 d-block" style="font-size: 0.65rem;">NETWORK / PLATFORM</label>
                                    <input type="text" class="form-control form-control-sm fw-bold border-0 bg-white shadow-none p-0" style="font-size: 1rem; color: #1e293b;" value="${p.platform}" onchange="fullConfig.testimonials.platform_ratings[${i}].platform = this.value">
                                </div>
                                <div class="row g-2 align-items-center">
                                     <div class="col-auto">
                                        <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-3 fw-bold" style="background: rgba(244, 140, 6, 0.1); color: #F48C06 !important;">Rating</span>
                                     </div>
                                     <div class="col">
                                        <input type="number" step="0.1" max="5" min="0" class="form-control form-control-sm fw-bold rounded-3 text-center" style="width: 80px; height: 38px; background: #fff; border: 1px solid #cbd5e1;" value="${p.rating}" onchange="fullConfig.testimonials.platform_ratings[${i}].rating = parseFloat(this.value)">
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderTestimonialsList() {
            const body = document.getElementById('testimonials-list-body');
            const items = fullConfig.testimonials?.testimonial_items || [];

            body.innerHTML = items.map((item, i) => `
                <tr>
                    <td>
                        <div class="avatar avatar-clickable flex-shrink-0" onclick="openMediaSelector('testimonial_avatar', ${i})">
                            <img class="avatar-img rounded-circle border" src="../${item.avatar}" style="width:48px; height:48px; object-fit:cover" onerror="this.src='../assets/images/avatar/default.jpg'">
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm mb-1" value="${item.name}" placeholder="Name" onchange="fullConfig.testimonials.testimonial_items[${i}].name = this.value">
                        <input type="text" class="form-control form-control-sm" value="${item.role}" placeholder="Role" onchange="fullConfig.testimonials.testimonial_items[${i}].role = this.value">
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm" rows="5" onchange="fullConfig.testimonials.testimonial_items[${i}].quote = this.value">${item.quote}</textarea>
                    </td>
                    <td>
                        <input type="number" step="0.5" class="form-control form-control-sm" value="${item.rating}" onchange="fullConfig.testimonials.testimonial_items[${i}].rating = parseFloat(this.value)">
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-light-danger" onclick="removeTestimonialItem(${i})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        function addTestimonialItem() {
            if (!fullConfig.testimonials.testimonial_items) fullConfig.testimonials.testimonial_items = [];
            fullConfig.testimonials.testimonial_items.push({
                name: 'New Client',
                role: 'Client Role',
                avatar: 'assets/images/avatar/default.jpg',
                quote: 'Great service...',
                rating: 5.0
            });
            renderTestimonialsList();
        }

        function removeTestimonialItem(idx) {
            showPremiumDeleteModal(
                'Delete Testimonial?',
                'Are you sure you want to remove this testimonial?',
                async () => {
                    fullConfig.testimonials.testimonial_items.splice(idx, 1);
                    renderTestimonialsList();
                    saveTestimonials();
                },
                'dark'
            );
        }

        async function saveTestimonials() {
            const formData = new FormData(document.getElementById('testimonials-form'));
            const content = Object.fromEntries(formData.entries());
            content.platform_ratings = fullConfig.testimonials.platform_ratings;
            content.testimonial_items = fullConfig.testimonials.testimonial_items;
            fullConfig.testimonials = content;
            await updateSection('testimonials', content);
        }

        // Enterprise
        function initEnterpriseForm() {
            const form = document.getElementById('enterprise-form');
            if (!form) return;
            const data = fullConfig['pricing_enterprise'] || {};
            Object.keys(data).forEach(key => {
                if (form.elements[key] && key !== 'features') form.elements[key].value = data[key];
            });
            renderEnterpriseFeatures();
        }

        function renderEnterpriseFeatures() {
            const container = document.getElementById('enterprise-features-container');
            if (!container) return;
            const features = fullConfig['pricing_enterprise']?.features || [];
            container.innerHTML = features.map((feat, i) => `
                <div class="input-group">
                    <input type="text" class="form-control" value="${feat}" onchange="fullConfig.pricing_enterprise.features[${i}] = this.value">
                    <button class="btn btn-outline-danger" type="button" onclick="removeEnterpriseFeature(${i})"><i class="bi bi-trash"></i></button>
                </div>
            `).join('');
        }

        function addEnterpriseFeature() {
            if (!fullConfig.pricing_enterprise) fullConfig.pricing_enterprise = { features: [] };
            if (!fullConfig.pricing_enterprise.features) fullConfig.pricing_enterprise.features = [];
            fullConfig.pricing_enterprise.features.push('New Feature Item');
            renderEnterpriseFeatures();
        }

        function removeEnterpriseFeature(idx) {
            fullConfig.pricing_enterprise.features.splice(idx, 1);
            renderEnterpriseFeatures();
        }

        document.getElementById('enterprise-form').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const content = Object.fromEntries(formData.entries());
            content.features = fullConfig.pricing_enterprise.features;
            content.icon_img = fullConfig.pricing_enterprise.icon_img || 'assets/images/elements/thunder.png';
            await updateSection('pricing_enterprise', content);
        };

        async function updateSection(key, content) {
            try {
                const res = await fetch('../api/home_config.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-API-Key': 'weburea_secret_2026'
                    },
                    body: JSON.stringify({ section_key: key, section_content: content })
                });
                const result = await res.json();
                if (result.success) {
                    showToast(result.message, 'success');
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (err) {
                showToast('Server update failed', 'danger');
            }
        }

        document.addEventListener('DOMContentLoaded', fetchConfig);
    </script>
    <?php inject_premium_delete_modal(); ?>
    <?php inject_toast_system(); ?>
</body>

</html>