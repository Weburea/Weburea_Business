<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');

// Helper to calculate directory stats for the premium cards
function getDirStats($dir)
{
    $stats = [
        'files' => 0,
        'imgs' => 0,
        'vids' => 0,
        'docs' => 0,
        'folders' => 0,
        'size' => 0
    ];

    if (!is_dir($dir))
        return $stats;

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        if ($item->isDir()) {
            $stats['folders']++;
        } else {
            $stats['files']++;
            $stats['size'] += $item->getSize();

            $ext = strtolower($item->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                $stats['imgs']++;
            } elseif (in_array($ext, ['mp4', 'mov', 'webm', 'ogg'])) {
                $stats['vids']++;
            } elseif (in_array($ext, ['pdf', 'doc', 'docx', 'txt', 'zip'])) {
                $stats['docs']++;
            }
        }
    }
    return $stats;
}

$uploadStats = getDirStats('../assets/uploads');
$usedMB = round($uploadStats['size'] / (1024 * 1024), 2);
$capacityMB = 5000; // Increased to 5GB (5000MB) for high-fidelity assets
$storagePercent = min(100, round(($usedMB / $capacityMB) * 100, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - Portfolio Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea">

    <!-- Dark mode -->
    <script src="assets/js/dark-mode.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon/Vector.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/OverlayScrollbars.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css?v=<?= time() ?>">

    <style>
        .drag-handle:hover { color: #F48C06 !important; }
        .sortable-ghost { opacity: 0.4; background: rgba(244, 140, 6, 0.1); border: 2px dashed #F48C06; }
        .modal-footer.sticky-footer {
            position: sticky;
            bottom: 0;
            z-index: 10;
            box-shadow: 0 -10px 20px rgba(0,0,0,0.05);
            border-top: 1px solid var(--premium-card-border) !important;
        }

        /* High-Fidelity UI Fixes */
        .premium-row-bg {
            background: var(--premium-panel-soft) !important;
            border: 1px solid var(--premium-card-border) !important;
            transition: all 0.2s ease;
        }
        
        .testimonial-row-item .t-text {
            color: var(--premium-text-main) !important;
            font-weight: 500;
            line-height: 1.5;
            background: var(--premium-card-bg) !important;
            border: 1px solid var(--premium-card-border) !important;
            padding: 15px !important;
        }
        .testimonial-row-item .t-text::placeholder { color: var(--premium-text-muted) !important; }
        
        .tech-row-item .tech-label {
            background: #1e293b !important;
            color: #ffffff !important;
            border-radius: 10px;
            padding: 8px 12px !important;
            font-size: 13px;
        }
        .tech-row-item .tech-label::placeholder { color: rgba(255,255,255,0.4) !important; }
        
        .tech-icon-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
            background: var(--premium-card-bg);
        }
        .tech-icon-preview[src*="placeholder.jpg"], 
        .tech-icon-preview[src*="Vector.ico"] {
            opacity: 0.2;
            filter: grayscale(1);
        }
    </style>
</head>

<body>
    <!-- Header START -->
    <?php include 'include/header.php'; ?>
    <!-- Header END -->

    <main>
        <section class="py-4">
            <div class="container">
                <!-- Page Header -->
                <div class="row pb-4">
                    <div class="col-12">
                        <div class="d-sm-flex justify-content-sm-between align-items-center mt-4 text-center">
                            <h1 class="mb-2 mb-sm-0 h2">Portfolio Management <span
                                    class="badge bg-primary bg-opacity-10 text-primary ms-2" id="work_count"
                                    style="font-weight: 600; border-radius: 8px; padding: 6px 12px;">0</span></h1>
                            <button class="btn btn-premium mb-0" data-bs-toggle="modal" onclick="resetForm()"
                                data-bs-target="#workModal"><i class="fas fa-plus me-2"></i>Add NEW Work</button>
                        </div>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="row g-4 mb-5">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-info">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h3 class="mb-0" id="total_works_stat">0</h3>
                            <h6 class="mb-0 text-secondary small">Total Works</h6>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-warning">
                                <i class="bi bi-star"></i>
                            </div>
                            <h3 class="mb-0" id="published_works_stat">0</h3>
                            <h6 class="mb-0 text-secondary small">Published</h6>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-emerald">
                                <i class="bi bi-image"></i>
                            </div>
                            <h3 class="mb-0" id="images_stat"><?php echo $uploadStats['imgs']; ?></h3>
                            <h6 class="mb-0 text-secondary small">Images</h6>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-success">
                                <i class="bi bi-collection"></i>
                            </div>
                            <h3 class="mb-0" id="service_linked_stat">0</h3>
                            <h6 class="mb-0 text-secondary small">Services Linked</h6>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card card-body h-100">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Portfolio Storage</h5>
                                <div class="ms-auto stat-icon bg-light mb-0"
                                    style="width: 32px; height: 32px; font-size: 1rem;">
                                    <i class="bi bi-cloud-check"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="mt-0 text-secondary small" id="storage_usage_text">Usage <?php echo $storagePercent; ?>%</h6>
                                <span class="small fw-bold text-primary" id="storage_usage_mb"><?php echo $usedMB; ?>MB of
                                    <?php echo $capacityMB; ?>MB</span>
                            </div>
                            <div class="progress progress-premium">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="storage_progress_bar" role="progressbar"
                                    style="width: <?php echo $storagePercent; ?>%; background: linear-gradient(90deg, #F48C06, #EBAF41);"
                                    aria-valuenow="<?php echo $storagePercent; ?>" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Works Table START -->
                <div class="card rounded-3">
                    <div class="card-header bg-transparent border-bottom p-3">
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-md-8">
                                <form class="rounded position-relative">
                                    <input class="form-control pe-5" type="search" id="workSearch"
                                        placeholder="Search works by title or category..." aria-label="Search" onkeyup="filterWorks()"
                                        style="border-radius: 12px; padding: 12px 20px;">
                                    <button
                                        class="btn bg-transparent border-0 px-2 py-0 position-absolute top-50 end-0 translate-middle-y"
                                        type="button"><i class="fas fa-search fs-6 text-primary"></i></button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div id="filter-status-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive border-0">
                            <table class="table table-premium align-middle p-4 mb-0 table-hover">
                                <thead class="table-dark" style="background: #1e293b;">
                                    <tr>
                                        <th scope="col" class="border-0 rounded-start" style="padding: 15px 20px;">
                                            Work Details</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Category</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Year</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Status</th>
                                        <th scope="col" class="border-0 rounded-end" style="padding: 15px 20px;">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0" id="works-table-body">
                                    <!-- Table items will be loaded here via JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4 mt-sm-3">
                            <p class="mb-sm-0 text-center text-sm-start text-secondary small" id="pagination-info">
                                Showing 0 to 0 of 0 entries</p>
                            <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
                                <ul class="pagination pagination-sm pagination-bordered mb-0" id="pagination-list">
                                    <!-- Pagination will be loaded here -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Works Table END -->
            </div>
        </section>
    </main>

    <!-- Work Modal -->
    <div class="modal fade modal-premium" id="workModal" tabindex="-1" aria-labelledby="workModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workModalLabel">Portfolio Work Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs premium-nav-tabs mb-4" id="workTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="link-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-link" type="button" role="tab">1. Connection</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="hero-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-hero" type="button" role="tab">2. Hero Section</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="body-tab" data-bs-toggle="tab" data-bs-target="#tab-body"
                                type="button" role="tab">3. Body Content</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-seo" type="button" role="tab">4. SEO & Meta</button>
                        </li>
                    </ul>

                    <form id="workForm">
                        <input type="hidden" id="work-id">

                        <div class="tab-content" id="workTabContent">
                            <!-- Tab 1: Connection -->
                            <div class="tab-pane fade show active" id="tab-link" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-link-45deg me-2"></i> Select the primary service to configure dynamic fields.
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Related Service (Drives View Logic)</label>
                                        <div id="service-select-container"></div>
                                        <input type="hidden" name="service_id" id="service_id">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0">Pricing Reference</label>
                                            <span id="sync-badge" class="badge bg-success-soft text-success d-none">
                                                <i class="bi bi-check-circle-fill me-1"></i> Pricing Synchronized
                                            </span>
                                        </div>
                                        <div class="premium-select-trigger disabled bg-light" id="pricing-status-box" style="cursor: default; opacity: 1;">
                                            <span><i class="bi bi-link-45deg me-2 text-secondary"></i>Select a Service first...</span>
                                        </div>
                                        <input type="hidden" id="pricing_id" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <div id="status-select-container-modal"></div>
                                        <input type="hidden" id="status" value="published">
                                    </div>
                                    <div class="col-md-6">
                                         <label class="form-label">Sort Order (Optional)</label>
                                         <input type="number" class="form-control" id="sort_order" placeholder="e.g. 1" value="0">
                                         <div class="form-text small">Lower numbers appear first. 0 means unassigned.</div>
                                     </div>
                                </div>
                            </div>

                            <!-- Tab 2: Hero Section -->
                            <div class="tab-pane fade" id="tab-hero" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-layout-text-window-reverse me-2"></i> Configure the hero section displayed at the top of the project view.
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Work Title</label>
                                        <input type="text" class="form-control" id="title" required placeholder="e.g. Project Antigravity UI Design">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Project Year</label>
                                        <input type="text" class="form-control" id="year" placeholder="e.g. 2024">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Live Project URL</label>
                                        <input type="text" class="form-control" id="live_url" placeholder="https://...">
                                    </div>
                                    <div class="col-12 mt-4" id="dynamic-hero-fields"></div>

                                    <div id="standard-hero-specs" class="row g-4 p-0 m-0 mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Industry</label>
                                            <input type="text" class="form-control" id="industry" placeholder="e.g. Digital, Fashion, Tech">
                                            <small class="text-muted d-block mt-1">Displays as metadata or list tags on certain layouts.</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Project Direction</label>
                                            <input type="text" class="form-control" id="project_direction" placeholder="e.g. Custom Solution, Redesign">
                                            <small class="text-muted d-block mt-1">Displays as metadata or list tags on certain layouts.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Main Showcase Hero Image / Video <span class="text-muted small fw-normal ms-2">(1930x1080)</span></label>
                                        <div class="media-uploader-box" onclick="document.getElementById('image_file').click()">
                                            <i class="bi bi-cloud-arrow-up display-6 text-primary mb-1"></i>
                                            <p class="small mb-0">Click to Upload Hero Visual</p>
                                            <input type="file" id="image_file" class="d-none" onchange="handleSingleUpload(this, 'portfolio', 'image')" accept="image/*,video/*">
                                        </div>
                                        <div id="image_preview" class="media-preview-container d-none">
                                            <img src="" class="work-image-preview">
                                        </div>
                                        <input type="hidden" id="image">
                                    </div>
                                    <div class="col-md-12" id="comparison-image-container">
                                        <label class="form-label">Comparison Image (Optional Before/After)</label>
                                        <div class="media-uploader-box" onclick="document.getElementById('comparison_image_file').click()">
                                            <i class="bi bi-images display-6 text-primary mb-1"></i>
                                            <p class="small mb-0">Click to Upload Comparison Visual</p>
                                            <input type="file" id="comparison_image_file" class="d-none" onchange="handleSingleUpload(this, 'portfolio', 'comparison_image')" accept="image/*">
                                        </div>
                                        <div id="comparison_image_preview" class="media-preview-container d-none">
                                            <img src="" class="work-image-preview">
                                            <div class="text-center mt-2"><span id="comparison_image_path" class="small text-muted d-none"></span></div>
                                        </div>
                                        <input type="hidden" id="comparison_image">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Body Content -->
                            <div class="tab-pane fade" id="tab-body" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-file-text-fill me-2"></i> Detailed project narrative, assets, and testimonials.
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label">Short Description (Grid View)</label>
                                        <textarea class="form-control" id="description" rows="2" placeholder="Brief summary for the portfolio list..."></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Categories (Comma separated)</label>
                                        <input type="text" class="form-control" id="categories" placeholder="e.g. Branding, UI/UX, Web Development">
                                    </div>
                                    <div id="standard-body-narrative" class="row g-4 p-0 m-0 mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Project Overview</label>
                                            <textarea class="form-control" id="project_overview" rows="5" placeholder="Deep dive into values, target audience..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">The Challenge</label>
                                            <textarea class="form-control" id="project_challenge" rows="5" placeholder="Modernizing legacy brand without losing customers..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Challenge Highlights (Comma separated)</label>
                                            <input type="text" class="form-control mb-3" id="challenge_points" placeholder="Visual Identity, Art Direction, Typography & Colors">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label fw-bold">Project Result / Outcome</label>
                                            <textarea class="form-control" id="project_result" rows="4" placeholder="Describe the final result, impact, and success of the project..."></textarea>
                                        </div>
                                    </div>
                                    <!-- Dynamic Body Fields Container -->
                                    <div class="col-12" id="dynamic-body-fields"></div>

                                    <div class="col-md-6" id="additional-images-container">
                                        <label class="form-label">Additional Case Study Images</label>
                                        <div class="d-flex flex-wrap gap-2 mb-2" id="gallery-preview-container">
                                            <!-- Thumbnails will appear here -->
                                        </div>
                                        <div class="media-uploader-box small-box" onclick="document.getElementById('gallery_files').click()" style="height: 100px;">
                                            <i class="bi bi-images text-primary mb-1"></i>
                                            <p class="small mb-0">Add Gallery Images / Videos</p>
                                            <input type="file" id="gallery_files" class="d-none" onchange="handleMultipleUpload(this)" multiple accept="image/*,video/*">
                                        </div>
                                        <input type="hidden" id="additional_images" value="[]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Client Logos</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-sm btn-light w-100" onclick="document.getElementById('client_logo_light_file').click()">Light Logo</button>
                                                <input type="file" id="client_logo_light_file" class="d-none" onchange="handleSingleUpload(this, 'logos', 'client_logo_light')" accept="image/*">
                                                <input type="hidden" id="client_logo_light">
                                                <div id="client_logo_light_preview" class="mt-2 text-center border rounded p-2 bg-light d-none" style="height: 60px;">
                                                    <!-- Preview will appear here -->
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-sm btn-dark w-100" onclick="document.getElementById('client_logo_dark_file').click()">Dark Logo</button>
                                                <input type="file" id="client_logo_dark_file" class="d-none" onchange="handleSingleUpload(this, 'logos', 'client_logo_dark')" accept="image/*">
                                                <input type="hidden" id="client_logo_dark">
                                                <div id="client_logo_dark_preview" class="mt-2 text-center border rounded p-2 bg-dark d-none" style="height: 60px;">
                                                    <!-- Preview will appear here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                            <h6 class="mb-0">Client Testimonials (Slider)</h6>
                                            <button type="button" class="btn btn-sm btn-premium" onclick="addTestimonialRow()"><i class="bi bi-plus-lg me-1"></i>Add Slide</button>
                                        </div>
                                        <div id="testimonials-container" class="row g-3">
                                            <!-- Testimonial rows will be added here -->
                                        </div>
                                        <input type="hidden" id="testimonials_json" value="[]">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 4: SEO -->
                            <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-search me-2"></i> Optimize this project for search engines.
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title" placeholder="Project Name | Weburea Agency">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Meta Description</label>
                                        <textarea class="form-control" id="meta_description" rows="3" placeholder="Compelling summary for Google search results..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" id="meta_keywords" placeholder="branding, ui design, weburea project">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">OG / Social Image</label>
                                        <div class="media-uploader-box small-box" onclick="document.getElementById('meta_og_image_file').click()">
                                            <i class="bi bi-share text-primary mb-1"></i>
                                            <p class="small mb-0">Social Preview Image</p>
                                            <input type="file" id="meta_og_image_file" class="d-none" onchange="handleSingleUpload(this, 'seo', 'meta_og_image')" accept="image/*">
                                        </div>
                                        <input type="hidden" id="meta_og_image">
                                        <div id="meta_og_image_preview" class="mt-2 d-none"><img src="" class="rounded" style="height: 40px;"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Twitter Card Image</label>
                                        <div class="media-uploader-box small-box" onclick="document.getElementById('meta_twitter_image_file').click()">
                                            <i class="bi bi-twitter text-primary mb-1"></i>
                                            <p class="small mb-0">Twitter Preview Image</p>
                                            <input type="file" id="meta_twitter_image_file" class="d-none" onchange="handleSingleUpload(this, 'seo', 'meta_twitter_image')" accept="image/*">
                                        </div>
                                        <input type="hidden" id="meta_twitter_image">
                                        <div id="meta_twitter_image_preview" class="mt-2 d-none"><img src="" class="rounded" style="height: 40px;"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">OG Type</label>
                                        <select class="form-select" id="meta_og_type">
                                            <option value="website">Website</option>
                                            <option value="article">Article / Project</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer sticky-footer bg-light border-0">
                    <button type="button" class="btn btn-premium-close mb-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-premium-save mb-0" onclick="saveWork()"><i
                            class="bi bi-save me-2"></i>Save Work Asset</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
        inject_premium_delete_modal(); 
        inject_premium_alert_modal();
        inject_toast_system();
    ?>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        const API_URL = '../api/works.php?all=1';
        let workModal;
        let allWorks = [];
        let filteredWorks = [];
        let servicesList = [];
        let currentPage = 1;
        const itemsPerPage = 8;

        document.addEventListener('DOMContentLoaded', () => {
            workModal = new bootstrap.Modal(document.getElementById('workModal'));
            loadInitialData();

            // Status filter for the table
            renderPremiumSelect('filter-status-container', [
                { label: 'All Status', value: 'all', icon: 'bi-grid-fill' },
                { label: 'Published', value: 'published', icon: 'bi-check-circle-fill' },
                { label: 'Archived', value: 'archived', icon: 'bi-archive-fill' }
            ], 'all', (val) => {
                window.currentStatusFilter = val;
                filterWorks();
            });

            // Status select for the modal
            renderPremiumSelect('status-select-container-modal', [
                { label: 'Published', value: 'published', dotColor: '#10b981' },
                { label: 'Archived', value: 'archived', dotColor: '#6c757d' }
            ], 'published', (val) => {
                document.getElementById('status').value = val;
            });
        });

        function initSortable() {
            const el = document.getElementById('works-table-body');
            if (!el) return;
            
            // Only allow sorting if we are seeing ALL works in their default order
            const isFiltered = document.getElementById('workSearch').value !== '' || (window.currentStatusFilter && window.currentStatusFilter !== 'all');
            
            if (window.sortableInstance) window.sortableInstance.destroy();

            window.sortableInstance = new Sortable(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                disabled: isFiltered,
                onEnd: async function() {
                    const rows = el.querySelectorAll('tr[data-id]');
                    const newOrder = [];
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    
                    rows.forEach((row, index) => {
                        newOrder.push({
                            id: row.getAttribute('data-id'),
                            sort_order: startIndex + index + 1
                        });
                    });

                    try {
                        const res = await fetch('../api/reorder-works.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ order: newOrder })
                        });
                        const json = await res.json();
                        if (json.success) {
                            showToast('Sequence updated successfully', 'success');
                            // Small delay before reload to let animation finish
                            setTimeout(() => {
                                loadWorks();
                            }, 300);
                        } else {
                            showToast(json.message || 'Failed to sync order', 'danger');
                        }
                    } catch (err) {
                        showToast('Connection error: Failed to sync', 'danger');
                    }
                }
            });
        }

        async function loadInitialData() {
            try {
                const sRes = await fetch('../api/services.php');
                const sJson = await sRes.json();
                if (sJson.success) {
                    servicesList = sJson.data.map(s => ({ label: s.name, value: s.id, slug: s.slug, img: s.icon_3d }));
                    renderPremiumSelect('service-select-container', servicesList, null, (val) => {
                        document.getElementById('service_id').value = val;
                        const service = servicesList.find(s => s.value == val);
                        if (service) {
                            updatePricingSelect(val);
                            populateServiceSpecificFields(service.slug);
                        }
                    });
                }
                loadWorks();
            } catch (err) {
                console.error('Failed to load initial data:', err);
            }
        }

        async function updatePricingSelect(serviceId) {
            const pricingBox = document.getElementById('pricing-status-box');
            const syncBadge = document.getElementById('sync-badge');
            
            if (!serviceId) {
                pricingBox.innerHTML = '<span><i class="bi bi-link-45deg me-2 text-secondary"></i>Select a Service first...</span>';
                syncBadge.classList.add('d-none');
                return;
            }

            pricingBox.innerHTML = '<span><i class="bi bi-hourglass-split me-2 text-primary"></i>Verifying pricing sync...</span>';
            
            try {
                const res = await fetch(`../api/pricing.php?service_id=${serviceId}`);
                const json = await res.json();
                
                if (json.success && json.data.length > 0) {
                    pricingBox.innerHTML = `<span><i class="bi bi-link-45deg me-2 text-success"></i>Automatically linked to <strong>${json.data.length} Plans</strong></span>`;
                    syncBadge.classList.remove('d-none');
                    // We keep pricing_id empty to signify "Auto-Sync with Service" (NULL in DB)
                    document.getElementById('pricing_id').value = '';
                } else {
                    pricingBox.innerHTML = '<span><i class="bi bi-exclamation-circle me-2 text-warning"></i>No pricing plans found for this service</span>';
                    syncBadge.classList.add('d-none');
                    document.getElementById('pricing_id').value = '';
                }
            } catch (err) {
                pricingBox.innerHTML = '<span><i class="bi bi-x-circle me-2 text-danger"></i>Error loading pricing</span>';
                syncBadge.classList.add('d-none');
            }
        }

        async function loadWorks() {
            try {
                const res = await fetch(API_URL);
                const json = await res.json();
                if (json.success) {
                    allWorks = json.data;
                    filterWorks();
                    updateStats();
                }
            } catch (err) {
                showToast('Failed to load works', 'danger');
            }
        }

        function filterWorks() {
            const query = document.getElementById('workSearch').value.toLowerCase();
            const statusFilter = window.currentStatusFilter || 'all';

            filteredWorks = allWorks.filter(w => {
                const matchesSearch = w.title.toLowerCase().includes(query) || 
                                     (w.service_name && w.service_name.toLowerCase().includes(query)) ||
                                     (w.categories && w.categories.toLowerCase().includes(query));
                
                const matchesStatus = statusFilter === 'all' || w.status === statusFilter;

                return matchesSearch && matchesStatus;
            });

            currentPage = 1;
            renderWorksTable();
        }

        function renderWorksTable() {
            const tbody = document.getElementById('works-table-body');
            const startIndex = (currentPage - 1) * itemsPerPage;
            
            tbody.innerHTML = '';
            
            // Only show items for current page
            const paginatedItems = filteredWorks.slice(startIndex, startIndex + itemsPerPage);

            if (paginatedItems.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5"><div class="text-muted"><i class="bi bi-inbox display-4 d-block mb-2"></i>No projects found.</div></td></tr>';
                return;
            }

            paginatedItems.forEach(w => {
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', w.id);
                const isDraft = w.status === 'archived';
                
                tr.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="drag-handle me-3" style="cursor: grab; color: #cbd5e1;">
                                <i class="bi bi-grip-vertical fs-5"></i>
                            </div>
                            <div class="avatar avatar-lg me-3 flex-shrink-0" style="width: 60px; height: 60px;">
                                <div class="avatar-img rounded-2 overflow-hidden w-100 h-100">
                                    ${w.image && w.image.toLowerCase().endsWith('.mp4') 
                                        ? `<video src="../${w.image}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>`
                                        : `<img src="../${w.image || 'assets/images/placeholder.jpg'}" class="w-100 h-100 object-fit-cover">`
                                    }
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-0"><a href="../work-view.php?id=${w.id}" target="_blank">${w.title}</a></h6>
                                ${w.industry ? `<p class="small mb-0 text-secondary">${w.industry}</p>` : ''}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            ${w.service_name || 'Unlinked'}
                            ${!w.service_id ? '<i class="bi bi-exclamation-triangle-fill text-warning ms-1" title="Service Link Missing"></i>' : ''}
                        </span>
                    </td>
                    <td><span class="text-secondary small fw-bold">${w.year || ''}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge ${w.status === 'published' ? 'bg-success' : 'bg-secondary'} bg-opacity-10 ${w.status === 'published' ? 'text-success' : 'text-secondary'} mb-0">
                                ${w.status.charAt(0).toUpperCase() + w.status.slice(1)}
                            </span>
                            <span class="ms-2 text-muted small" title="Sort Order">#${w.sort_order}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-premium-soft" onclick="editWork(${w.id})" title="Edit Work"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-soft-danger" onclick="deleteWork(${w.id})" title="Delete Work"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            renderPagination();
            initSortable();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredWorks.length / itemsPerPage);
            const paginationList = document.getElementById('pagination-list');
            const info = document.getElementById('pagination-info');
            const paginationNav = paginationList.closest('nav');

            paginationList.innerHTML = '';
            
            const start = filteredWorks.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredWorks.length);
            info.innerText = `Showing ${start} to ${end} of ${filteredWorks.length} entries`;

            if (totalPages <= 1) {
                if (paginationNav) paginationNav.classList.add('d-none');
                return;
            } else {
                if (paginationNav) paginationNav.classList.remove('d-none');
            }

            // Prev
            paginationList.innerHTML += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="${currentPage > 1 ? `changePage(${currentPage - 1})` : ''}">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>`;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                paginationList.innerHTML += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage(${i})">${i}</a>
                    </li>`;
            }

            // Next
            paginationList.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="${currentPage < totalPages ? `changePage(${currentPage + 1})` : ''}">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>`;
        }

        function changePage(p) {
            currentPage = p;
            renderWorksTable();
        }

        function updateStats() {
            document.getElementById('work_count').innerText = allWorks.length;
            document.getElementById('total_works_stat').innerText = allWorks.length;
            document.getElementById('published_works_stat').innerText = allWorks.filter(w => w.status === 'published').length;
            document.getElementById('service_linked_stat').innerText = new Set(allWorks.map(w => w.service_id).filter(id => id)).size;
            
            // Update storage stats dynamically
            fetch('../api/storage-stats.php')
                .then(r => r.json())
                .then(json => {
                    if(json.success) {
                        const usedMB = json.data.used_mb;
                        const percent = json.data.percent;
                        document.getElementById('storage_usage_text').innerText = `Usage ${percent}%`;
                        document.getElementById('storage_usage_mb').innerText = `${usedMB}MB of ${json.data.capacity_mb}MB`;
                        document.getElementById('storage_progress_bar').style.width = `${percent}%`;
                        document.getElementById('images_stat').innerText = json.data.image_count;
                    }
                });
        }

        function resetForm() {
            document.getElementById('workForm').reset();
            document.getElementById('work-id').value = '';
            document.getElementById('project_result').value = '';
            document.getElementById('image').value = '';
            document.getElementById('image_preview').classList.add('d-none');
            document.getElementById('comparison_image').value = '';
            document.getElementById('comparison_image_preview').classList.add('d-none');
            document.getElementById('client_logo_light').value = '';
            document.getElementById('client_logo_dark').value = '';
            document.getElementById('pricing_id').value = '';
            document.getElementById('sort_order').value = allWorks.length + 1;
            
            // Reset Dynamic Containers
            document.getElementById('dynamic-hero-fields').innerHTML = '';
            document.getElementById('dynamic-body-fields').innerHTML = '';

            const pricingBox = document.getElementById('pricing-status-box');
            pricingBox.innerHTML = '<span><i class="bi bi-link-45deg me-2 text-secondary"></i>Select a Service first...</span>';
            document.getElementById('sync-badge').classList.add('d-none');
            
            // Reset visibility of standard fields
            document.getElementById('standard-hero-specs').classList.remove('d-none');
            document.getElementById('standard-body-narrative').classList.remove('d-none');

            // Reset Selects
            let defaultServiceId = servicesList.length > 0 ? servicesList[0].value : '';
            document.getElementById('service_id').value = defaultServiceId;
            renderPremiumSelect('service-select-container', servicesList, defaultServiceId, (val) => {
                document.getElementById('service_id').value = val;
                const service = servicesList.find(s => s.value == val);
                updatePricingSelect(val);
                if(service) populateServiceSpecificFields(service.slug);
            });
            if (servicesList.length > 0) {
                updatePricingSelect(defaultServiceId);
                populateServiceSpecificFields(servicesList[0].slug);
            }

            document.getElementById('status').value = 'published';
            renderPremiumSelect('status-select-container-modal', [
                { label: 'Published', value: 'published', dotColor: '#10b981' },
                { label: 'Archived', value: 'archived', dotColor: '#6c757d' }
            ], 'published', (val) => {
                document.getElementById('status').value = val;
            });

            document.getElementById('workModalLabel').innerText = 'Create a Portfolio Work Asset';
            document.getElementById('testimonials-container').innerHTML = '';
            document.getElementById('testimonials_json').value = '[]';
            document.getElementById('meta_og_image').value = '';
            document.getElementById('meta_og_image_preview').classList.add('d-none');
            document.getElementById('meta_twitter_image').value = '';
            document.getElementById('meta_twitter_image_preview').classList.add('d-none');
            document.getElementById('meta_og_type').value = 'website';
        }

        function editWork(id) {
            const work = allWorks.find(w => w.id == id);
            if (!work) {
                showToast('Work asset not found', 'danger');
                return;
            }

            resetForm();
            // ✅ Show modal FIRST — no downstream JS error can block it
            workModal.show();

            const setVal = (elId, val) => {
                const el = document.getElementById(elId);
                if (el) el.value = (val !== null && val !== undefined) ? val : '';
            };

            try {
                document.getElementById('workModalLabel').innerText = 'Edit Portfolio Work Asset';
                setVal('work-id',             work.id);
                setVal('title',               work.title);
                setVal('description',         work.description);
                setVal('service_id',          work.service_id);
                setVal('pricing_id',          work.pricing_id);
                setVal('year',                work.year);
                setVal('industry',            work.industry);
                setVal('project_direction',   work.project_direction);
                setVal('project_overview',    work.project_overview);
                setVal('project_challenge',   work.project_challenge);
                setVal('project_result',      work.project_result);
                setVal('challenge_points',    work.challenge_points);
                setVal('categories',          work.categories);
                setVal('testimonial_text',    work.testimonial_text);
                setVal('testimonial_author',  work.testimonial_author);
                setVal('testimonial_role',    work.testimonial_role);
                setVal('meta_title',          work.meta_title);
                setVal('meta_description',    work.meta_description);
                setVal('meta_keywords',       work.meta_keywords);
                setVal('meta_og_image',       work.meta_og_image);
                setVal('meta_twitter_image',  work.meta_twitter_image);
                setVal('meta_og_type',        work.meta_og_type || 'website');
                setVal('status',              work.status || 'published');
                setVal('sort_order',          work.sort_order || 0);
                setVal('live_url',            work.live_url || '');
                setVal('client_logo_light',   work.client_logo_light);
                setVal('client_logo_dark',    work.client_logo_dark);
                
                if (work.client_logo_light) updateMediaPreview('client_logo_light_preview', work.client_logo_light);
                if (work.client_logo_dark) updateMediaPreview('client_logo_dark_preview', work.client_logo_dark);

                if (work.meta_og_image) {
                    updateMediaPreview('meta_og_image_preview', work.meta_og_image);
                }
                if (work.meta_twitter_image) {
                    updateMediaPreview('meta_twitter_image_preview', work.meta_twitter_image);
                }
                if (work.image) {
                    setVal('image', work.image);
                    updateMediaPreview('image_preview', work.image);
                }
                if (work.comparison_image) {
                    setVal('comparison_image', work.comparison_image);
                    updateMediaPreview('comparison_image_preview', work.comparison_image);
                }

                // Populate testimonials
                const tContainer = document.getElementById('testimonials-container');
                if (tContainer) {
                    tContainer.innerHTML = '';
                    let testimonials = [];
                    try {
                        testimonials = typeof work.testimonials_json === 'string' ? JSON.parse(work.testimonials_json || '[]') : (work.testimonials_json || []);
                    } catch(e) { testimonials = []; }
                    
                    if (Array.isArray(testimonials) && testimonials.length > 0) {
                        testimonials.forEach(t => addTestimonialRow(t));
                    } else if (work.testimonial_text) {
                        addTestimonialRow({ text: work.testimonial_text, author: work.testimonial_author, role: work.testimonial_role, image: work.testimonial_image });
                    }
                }

                // Populate additional images
                let galleryData = work.additional_images;
                if (typeof galleryData === 'string') {
                    try { galleryData = JSON.parse(galleryData || '[]'); } catch(e) { galleryData = []; }
                }
                setVal('additional_images', Array.isArray(galleryData) ? JSON.stringify(galleryData) : (galleryData || '[]'));
                renderGallery();

                setVal('service_id', work.service_id);
                renderPremiumSelect('service-select-container', servicesList, work.service_id, (val) => {
                    setVal('service_id', val);
                    const svc = servicesList.find(s => s.value == val);
                    if (svc) { updatePricingSelect(val); populateServiceSpecificFields(svc.slug); }
                });
                setVal('status', work.status);
                renderPremiumSelect('status-select-container-modal', [
                    { label: 'Published', value: 'published', dotColor: '#10b981' },
                    { label: 'Archived',  value: 'archived',  dotColor: '#6c757d' }
                ], work.status, (val) => setVal('status', val));

                if (work.service_id) {
                    updatePricingSelect(work.service_id).then(() => {
                        const svc = servicesList.find(s => s.value == work.service_id);
                        if (svc) populateServiceSpecificFields(svc.slug, work.service_data_json);
                    });
                }

                if (!work.service_id) {
                    showToast('No service linked — assign one to unlock dynamic fields', 'warning');
                }

            } catch(err) {
                console.error('editWork population error:', err);
                showToast('Some fields could not be loaded', 'warning');
            }
        }



        function getTestimonialsJSON() {
            const rows = document.querySelectorAll('#testimonials-container .testimonial-row-item');
            const result = [];
            rows.forEach(row => {
                const text   = row.querySelector('.t-text')?.value?.trim()   || '';
                const author = row.querySelector('.t-author')?.value?.trim() || '';
                const role   = row.querySelector('.t-role')?.value?.trim()   || '';
                const image  = row.querySelector('.t-image')?.value?.trim()  || '';
                if (text || author) result.push({ text, author, role, image });
            });
            return JSON.stringify(result);
        }

        function getServiceDataJSON() {
            const data = {};
            // Collect all named inputs from dynamic hero and body containers
            ['dynamic-hero-fields', 'dynamic-body-fields'].forEach(containerId => {
                const container = document.getElementById(containerId);
                if (!container) return;
                container.querySelectorAll('input[name], textarea[name], select[name]').forEach(el => {
                    if (el.type === 'checkbox') {
                        data[el.name] = el.checked ? (el.value || '1') : '0';
                    } else {
                        data[el.name] = el.value;
                    }
                });
            });

            // Handle Tech Stack Serialization
            const techRows = document.querySelectorAll('.tech-row-item');
            if (techRows.length > 0) {
                const techStack = [];
                techRows.forEach(row => {
                    const icon = row.querySelector('.tech-icon-val').value;
                    const label = row.querySelector('.tech-label').value.trim();
                    if (icon || label) techStack.push({ icon, label });
                });
                data.tech_stack_json = JSON.stringify(techStack);
            }

            // Handle Section Features Serialization
            const featureRows = document.querySelectorAll('.feature-row-item');
            if (featureRows.length > 0) {
                const features = [];
                featureRows.forEach(row => {
                    const icon = row.querySelector('.feat-icon').value.trim();
                    const title = row.querySelector('.feat-title').value.trim();
                    const desc = row.querySelector('.feat-desc').value.trim();
                    if (title || desc) features.push({ icon, title, desc });
                });
                data.section_features_json = JSON.stringify(features);
            }

            // Handle Highlights Serialization
            const highlightRows = document.querySelectorAll('.highlight-row-val');
            if (highlightRows.length > 0) {
                const highlights = [];
                highlightRows.forEach(input => {
                    if (input.value.trim()) highlights.push({ text: input.value.trim() });
                });
                data.highlights_json = JSON.stringify(highlights);
            }

            // Handle Rating Stats Serialization
            const ratingRows = document.querySelectorAll('.rating-row-item');
            if (ratingRows.length > 0) {
                const ratings = [];
                ratingRows.forEach(row => {
                    const val = row.querySelector('.rating-val').value.trim();
                    const label = row.querySelector('.rating-label').value.trim();
                    if (val || label) ratings.push({ val, label });
                });
                data.rating_stats_json = JSON.stringify(ratings);
            }

            // Handle Motion Points Serialization
            const motionRows = document.querySelectorAll('.motion-point-val');
            if (motionRows.length > 0) {
                const points = [];
                motionRows.forEach(input => {
                    if (input.value.trim()) points.push(input.value.trim());
                });
                data.motion_challenge_points = points;
            }

            return JSON.stringify(data);
        }

        async function saveWork() {
            const saveBtn = document.querySelector('button[onclick="saveWork()"]');
            if (saveBtn) {
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
            }

            try {
                const getVal = (id) => {
                    const el = document.getElementById(id);
                    return el ? el.value : '';
                };

                const id = getVal('work-id');
                const data = {
                    id: id,
                    title: getVal('title'),
                    description: getVal('description'),
                    service_id: getVal('service_id'),
                    pricing_id: getVal('pricing_id'),
                    year: getVal('year'),
                    industry: getVal('industry'),
                    project_direction: getVal('project_direction'),
                    project_overview: getVal('project_overview'),
                    project_challenge: getVal('project_challenge'),
                    project_result: getVal('project_result'),
                    challenge_points: getVal('challenge_points'),
                    categories: getVal('categories'),
                    testimonial_text: getVal('testimonial_text'),
                    testimonial_author: getVal('testimonial_author'),
                    testimonial_role: getVal('testimonial_role'),
                    testimonial_image: getVal('testimonial_image'),
                    meta_title: getVal('meta_title'),
                    meta_description: getVal('meta_description'),
                    meta_keywords: getVal('meta_keywords'),
                    status: getVal('status'),
                    sort_order: getVal('sort_order'),
                    image: getVal('image'),
                    comparison_image: getVal('comparison_image'),
                    client_logo_light: getVal('client_logo_light'),
                    client_logo_dark: getVal('client_logo_dark'),
                    additional_images: getVal('additional_images'),
                    meta_og_image: getVal('meta_og_image'),
                    meta_twitter_image: getVal('meta_twitter_image'),
                    meta_og_type: getVal('meta_og_type'),
                    live_url: getVal('live_url'),
                    testimonials_json: getTestimonialsJSON(),
                    service_data_json: getServiceDataJSON()
                };

                if (!data.title || !data.service_id) {
                    if (!data.service_id) {
                        showPremiumAlert('Missing Service Link', 'Every portfolio project must be associated with a service to determine its layout and SEO structure. Please select a service before saving.', 'warning', 'Got it', 'services');
                    } else {
                        showToast('Project title is required', 'warning');
                    }
                    return;
                }

                const url = id ? `../api/works.php?id=${id}` : '../api/works.php';
                const res = await fetch(url, {
                    method: id ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const json = await res.json();
                if (json.success) {
                    showToast(id ? 'Work updated successfully' : 'Work created successfully', 'success');
                    workModal.hide();
                    loadWorks();
                } else {
                    const errorMsg = json.error || json.message || 'Failed to save work';
                    showToast(errorMsg, 'danger');
                }
            } catch (err) {
                console.error('Save error:', err);
                showToast('Connection Error: ' + err.message, 'danger');
            } finally {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'Save Work Asset';
                }
            }
        }


        function deleteWork(id) {
            showPremiumDeleteModal('Delete Work Asset', 'Are you sure you want to permanently delete this portfolio project and its associated files?', async () => {
                try {
                    const res = await fetch(`../api/works.php?id=${id}`, { method: 'DELETE' });
                    const json = await res.json();
                    if (json.success) {
                        showToast('Work deleted successfully', 'success');
                        loadWorks();
                    } else {
                        showToast('Failed to delete', 'danger');
                    }
                } catch (err) {
                    showToast('API Error', 'danger');
                }
            });
        }

        function handleSingleUpload(input, folder, targetId) {
            if (!input.files || !input.files[0]) return;
            
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('folder', folder);
            
            // Pass work title for context-aware naming
            const workTitle = document.getElementById('title')?.value || '';
            formData.append('work_title', workTitle);

            const parent = input.parentElement;
            
            // Non-destructive spinner overlay
            parent.classList.add('position-relative');
            const overlay = document.createElement('div');
            overlay.className = 'upload-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-75 rounded-3 z-index-10';
            overlay.innerHTML = '<div class="spinner-border text-primary spinner-border-sm" role="status"></div><span class="small mt-1" style="font-size: 10px;">Uploading...</span>';
            parent.appendChild(overlay);

            fetch('../api/upload.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(json => {
                if (json.success) {
                    document.getElementById(targetId).value = json.path;
                    updateMediaPreview(targetId + '_preview', json.path);
                    showToast('File uploaded', 'success');
                    loadWorks();
                } else {
                    showToast(json.error || json.message || 'Upload failed', 'danger');
                }
            })
            .catch(err => {
                console.error('Upload Error:', err);
                showToast('Server connection error', 'danger');
            })
            .finally(() => {
                overlay.remove();
                parent.classList.remove('position-relative');
            });
        }

        function updateMediaPreview(containerId, path) {
            const container = document.getElementById(containerId);
            if (!container) return;

            container.classList.remove('d-none');
            const isVideo = path.toLowerCase().endsWith('.mp4') || path.toLowerCase().endsWith('.webm');
            
            if (isVideo) {
                container.innerHTML = `<video src="../${path}" class="work-image-preview w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>`;
            } else {
                container.innerHTML = `<img src="../${path}" class="work-image-preview w-100 h-100 object-fit-cover">`;
            }
        }

        function handleMultipleUpload(input) {
            if (!input.files || input.files.length === 0) return;
            
            const files = Array.from(input.files);
            const additionalImagesInput = document.getElementById('additional_images');
            let currentImages = [];
            try {
                const val = additionalImagesInput.value;
                currentImages = typeof val === 'string' ? JSON.parse(val || '[]') : (val || []);
            } catch(e) { currentImages = []; }

            // Enforce limit of 4
            if (currentImages.length + files.length > 4) {
                showPremiumAlert('Gallery Limit Reached', 'You can only upload a maximum of 4 additional case study images.', 'info');
                input.value = ''; // Reset file input
                return;
            }

            showToast(`Uploading ${files.length} assets...`, 'info');

            const uploadPromises = files.map(file => {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('folder', 'portfolio/gallery');
                
                // Pass work title for context-aware naming
                const workTitle = document.getElementById('title')?.value || '';
                formData.append('work_title', workTitle);

                return fetch('../api/upload.php', { method: 'POST', body: formData }).then(r => r.json());
            });

            Promise.all(uploadPromises)
            .then(results => {
                let successCount = 0;
                results.forEach(res => {
                    if (res.success) {
                        currentImages.push(res.path);
                        successCount++;
                    }
                });
                additionalImagesInput.value = JSON.stringify(currentImages);
                renderGallery();
                showToast(`Successfully uploaded ${successCount} files`, 'success');
            })
            .catch(err => {
                console.error('Multiple upload error:', err);
                showToast('Some files failed to upload', 'danger');
            });
        }

        function renderGallery() {
            const container = document.getElementById('gallery-preview-container');
            const input = document.getElementById('additional_images');
            if (!container || !input) return;

            let images = [];
            try {
                const val = input.value;
                images = typeof val === 'string' ? JSON.parse(val || '[]') : (val || []);
            } catch(e) { images = []; }

            container.innerHTML = '';
            images.forEach((path, index) => {
                const isVideo = path.toLowerCase().endsWith('.mp4') || path.toLowerCase().endsWith('.webm');
                const div = document.createElement('div');
                div.className = 'position-relative rounded overflow-hidden border';
                div.style.width = '80px';
                div.style.height = '80px';
                
                if (isVideo) {
                    div.innerHTML = `<video src="../${path}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>`;
                } else {
                    div.innerHTML = `<img src="../${path}" class="w-100 h-100 object-fit-cover">`;
                }

                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger btn-xs position-absolute top-0 end-0 p-1 m-1 lh-1 rounded-circle';
                removeBtn.style.fontSize = '10px';
                removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                removeBtn.onclick = (e) => {
                    e.stopPropagation();
                    removeGalleryImage(index);
                };
                
                div.appendChild(removeBtn);
                container.appendChild(div);
            });
        }

        function removeGalleryImage(index) {
            const input = document.getElementById('additional_images');
            const val = input.value;
            let images = typeof val === 'string' ? JSON.parse(val || '[]') : (val || []);
            images.splice(index, 1);
            input.value = JSON.stringify(images);
            renderGallery();
            showToast('Image removed from gallery', 'info');
        }

        function populateServiceSpecificFields(slug, rawData = null) {
            let data = rawData;
            if (typeof rawData === 'string') {
                try { data = JSON.parse(rawData); } catch(e) { data = {}; }
            }
            if (!data) data = {};
            // Escape double quotes ONLY for non-JSON fields to prevent breaking HTML input values
            for (let key in data) {
                if (typeof data[key] === 'string' && !key.endsWith('_json')) {
                    data[key] = data[key].replace(/"/g, '&quot;');
                }
            }

            const heroContainer = document.getElementById('dynamic-hero-fields');
            const bodyContainer = document.getElementById('dynamic-body-fields');
            const standardHeroSpecs = document.getElementById('standard-hero-specs');
            const standardBodyNarrative = document.getElementById('standard-body-narrative');
            
            heroContainer.innerHTML = '';
            bodyContainer.innerHTML = '';
            
            if (standardHeroSpecs) standardHeroSpecs.classList.remove('d-none');
            if (standardBodyNarrative) standardBodyNarrative.classList.remove('d-none');
            
            const comparisonContainer = document.getElementById('comparison-image-container');
            if (comparisonContainer) comparisonContainer.classList.remove('d-none');
            
            const additionalImagesContainer = document.getElementById('additional-images-container');
            if (additionalImagesContainer) additionalImagesContainer.classList.remove('d-none');

            if (slug === 'web-development' || slug === 'software-qa') {
                    heroContainer.innerHTML = `
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                                <div class="card-body p-4">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-stack me-2"></i>Technology Stack Configuration</h6>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Stack Section Title</label>
                                        <input type="text" class="form-control" name="tech_stack_title" value="${data.tech_stack_title || 'Development stack and QA toolkits we utilize'}" placeholder="e.g. Development stack and QA toolkits we utilize">
                                    </div>
                                    <div id="tech-stack-container" class="row g-3"></div>
                                    <button type="button" class="btn btn-sm btn-primary mt-3" onclick="addTechStackRow()">
                                        <i class="bi bi-plus-circle me-2"></i>Add Tech Icon
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    bodyContainer.innerHTML = `
                        <!-- Section 1: Functionality List -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-dark bg-opacity-10 border-0 p-3">
                                    <h6 class="mb-0"><i class="bi bi-grid-3x3-gap me-2"></i>1. High-Performance Functionality Grid</h6>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Section Main Title</label>
                                        <input type="text" class="form-control" name="section_title" value="${data.section_title || ''}" placeholder="e.g. High-Performance Development & Rigorous QA">
                                    </div>
                                    <div id="section-features-container"></div>
                                    <button type="button" class="btn btn-sm btn-soft-primary mt-3" onclick="addSectionFeatureRow()">
                                        <i class="bi bi-plus-circle me-2"></i>Add Feature Card
                                    </button>
                                </div>
                            </div>
                        </div>


                    `;

                    // Populate rows
                    if (data.tech_stack_json) {
                        try {
                            const stack = JSON.parse(data.tech_stack_json);
                            stack.forEach(item => addTechStackRow(item));
                        } catch(e) {}
                    }
                    if (data.section_features_json) {
                        try {
                            const features = typeof data.section_features_json === 'string' ? JSON.parse(data.section_features_json) : (data.section_features_json || []);
                            if (Array.isArray(features) && features.length > 0) {
                                features.slice(0, 4).forEach(item => addSectionFeatureRow(item));
                            } else {
                                for(let i=0; i<4; i++) addSectionFeatureRow();
                            }
                        } catch(e) {
                            console.error("Error parsing features:", e);
                            for(let i=0; i<4; i++) addSectionFeatureRow();
                        }
                    } else {
                        for(let i=0; i<4; i++) addSectionFeatureRow();
                    }

                    if (data.highlights_json) {
                        try {
                            const highlights = typeof data.highlights_json === 'string' ? JSON.parse(data.highlights_json) : (data.highlights_json || []);
                            if (Array.isArray(highlights) && highlights.length > 0) {
                                highlights.forEach(item => addHighlightRow(item));
                            }
                        } catch(e) {}
                    }

                    if (data.rating_stats_json) {
                        try {
                            const ratings = typeof data.rating_stats_json === 'string' ? JSON.parse(data.rating_stats_json) : (data.rating_stats_json || []);
                            if (Array.isArray(ratings) && ratings.length > 0) {
                                ratings.forEach(item => addRatingStatRow(item));
                            }
                        } catch(e) {}
                    }
                }
            else if (slug === 'brand-identity') {
                // Future implementation for Brand Identity specific fields
                heroContainer.innerHTML = ''; 
                bodyContainer.innerHTML = '';
            } else if (slug === 'motion-animation') {
                // HIDE Standard fields that are replaced by Motion specialized fields
                standardHeroSpecs.classList.add('d-none');
                standardBodyNarrative.classList.add('d-none');
                if (comparisonContainer) comparisonContainer.classList.add('d-none');
                if (additionalImagesContainer) additionalImagesContainer.classList.add('d-none');

                heroContainer.innerHTML = `
                    <div class="col-12 mb-4">
                        <div class="card premium-row-bg border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="mb-3 text-primary"><i class="bi bi-film me-2"></i>Motion Graphics Hero Specs</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Industry Label</label>
                                        <input type="text" class="form-control" name="motion_industry" value="${data.motion_industry || ''}" placeholder="e.g. Digital Entertainment">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Project Direction Label</label>
                                        <input type="text" class="form-control" name="motion_direction" value="${data.motion_direction || ''}" placeholder="e.g. 3D Animation & VFX">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                bodyContainer.innerHTML = `
                    <div class="col-12 mb-4">
                        <div class="card premium-row-bg border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="mb-3 text-primary"><i class="bi bi-journal-text me-2"></i>Visual Storytelling Content</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label text-primary-grad">01. Overview</label>
                                        <textarea class="form-control" name="motion_overview" rows="3" placeholder="A strong brand identity is...">${data.motion_overview || ''}</textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label text-primary-grad">02. The Challenge</label>
                                        <textarea class="form-control" name="motion_challenge" rows="3" placeholder="The primary challenge was...">${data.motion_challenge || ''}</textarea>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-bold">Challenge Key Points (List Icons)</label>
                                        <div id="motion-challenge-list-container"></div>
                                        <button type="button" class="btn btn-sm btn-soft-primary mt-2" onclick="addMotionChallengePoint()">
                                            <i class="bi bi-plus-lg me-1"></i> Add Challenge Point
                                        </button>
                                    </div>

                                    <div class="col-12 mt-5 pt-4 border-top">
                                        <h6 class="mb-4 text-primary d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-layout-three-columns me-2"></i>Media Sequence Builder</span>
                                            <span class="badge bg-soft-primary text-primary fw-normal" style="font-size: 0.7rem;">High-Fidelity Mode</span>
                                        </h6>
                                        
                                        <!-- Part 1: Showcase Grid -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-3" style="letter-spacing: 1px;">Part 1: Showcase Grid (12 Items - 3x4 Layout)</label>
                                            <div class="row g-2">
                                                ${[1,2,3,4,5,6,7,8,9,10,11,12].map(i => `
                                                    <div class="col-4 col-md-2">
                                                        <div class="motion-media-slot border rounded-3 p-1 bg-white text-center shadow-sm position-relative">
                                                            <div id="m_grid_1_${i}_preview" class="ratio ratio-1x1 rounded overflow-hidden bg-light mb-1 border">
                                                                ${data['m_grid_1_' + i] ? (data['m_grid_1_' + i].endsWith('.mp4') ? `<video src="../${data['m_grid_1_' + i]}" class="w-100 h-100 object-fit-cover"></video>` : `<img src="../${data['m_grid_1_' + i]}" class="w-100 h-100 object-fit-cover">`) : `<div class="d-flex align-items-center justify-content-center text-muted"><i class="bi bi-plus-lg fs-4"></i></div>`}
                                                            </div>
                                                            <button type="button" class="btn btn-xs btn-outline-primary w-100 py-1" onclick="triggerSingleUpload('m_grid_1_${i}_val')">Slot ${i}</button>
                                                            <input type="hidden" name="m_grid_1_${i}" id="m_grid_1_${i}_val" value="${data['m_grid_1_' + i] || ''}">
                                                        </div>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>

                                        <!-- Parallax 1 -->
                                        <div class="mb-4 premium-row-bg p-3 rounded-3 border">
                                            <label class="form-label fw-bold text-primary small text-uppercase mb-2">Immersive Breakpoint: Parallax 01</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <div id="motion_parallax_1_preview" class="border rounded-3 overflow-hidden bg-white shadow-sm" style="width: 120px; height: 60px;">
                                                    ${data.motion_parallax_1 ? `<img src="../${data.motion_parallax_1}" class="w-100 h-100 object-fit-cover">` : `<div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>`}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="triggerSingleUpload('motion_parallax_1_val')">Upload Parallax Image</button>
                                                    <p class="mb-0 small text-muted">Large landscape image recommended for the parallax effect.</p>
                                                    <input type="hidden" name="motion_parallax_1" id="motion_parallax_1_val" value="${data.motion_parallax_1 || ''}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Part 2: Focused Grid -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-muted small text-uppercase mb-3" style="letter-spacing: 1px;">Part 2: Focused View (2 Items - Centered)</label>
                                            <div class="row g-2 justify-content-center">
                                                ${[1,2].map(i => `
                                                    <div class="col-4 col-md-3">
                                                        <div class="motion-media-slot border rounded-3 p-1 bg-white text-center shadow-sm">
                                                            <div id="m_grid_2_${i}_preview" class="ratio ratio-1x1 rounded overflow-hidden bg-light mb-1 border">
                                                                ${data['m_grid_2_' + i] ? (data['m_grid_2_' + i].endsWith('.mp4') ? `<video src="../${data['m_grid_2_' + i]}" class="w-100 h-100 object-fit-cover"></video>` : `<img src="../${data['m_grid_2_' + i]}" class="w-100 h-100 object-fit-cover">`) : `<div class="d-flex align-items-center justify-content-center text-muted"><i class="bi bi-plus-lg fs-4"></i></div>`}
                                                            </div>
                                                            <button type="button" class="btn btn-xs btn-outline-primary w-100 py-1" onclick="triggerSingleUpload('m_grid_2_${i}_val')">Focus ${i}</button>
                                                            <input type="hidden" name="m_grid_2_${i}" id="m_grid_2_${i}_val" value="${data['m_grid_2_' + i] || ''}">
                                                        </div>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>

                                        <!-- Results Section -->
                                        <div class="mt-5 mb-4">
                                            <div class="card premium-row-bg border-0 shadow-sm">
                                                <div class="card-body p-4">
                                                    <h6 class="mb-3 text-primary"><i class="bi bi-graph-up-arrow me-2"></i>Motion Graphics Results</h6>
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Result Description</label>
                                                            <textarea class="form-control" name="motion_result_text" rows="3" placeholder="Describe the impact of the motion work...">${data.motion_result_text || ''}</textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Stat 1 (Value | Label)</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="motion_stat_1_val" value="${data.motion_stat_1_val || ''}" placeholder="99.9%">
                                                                <input type="text" class="form-control" name="motion_stat_1_label" value="${data.motion_stat_1_label || ''}" placeholder="Engagement">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Stat 2 (Value | Label)</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="motion_stat_2_val" value="${data.motion_stat_2_val || ''}" placeholder="3X">
                                                                <input type="text" class="form-control" name="motion_stat_2_label" value="${data.motion_stat_2_label || ''}" placeholder="Brand Recall">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Stat 3 (Value | Label)</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="motion_stat_3_val" value="${data.motion_stat_3_val || ''}" placeholder="10M+">
                                                                <input type="text" class="form-control" name="motion_stat_3_label" value="${data.motion_stat_3_label || ''}" placeholder="Views">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Final Parallax 2 -->
                                        <div class="premium-row-bg p-3 rounded-3 border">
                                            <label class="form-label fw-bold text-primary small text-uppercase mb-2">Conclusion Breakpoint: Parallax 02</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <div id="motion_parallax_2_preview" class="border rounded-3 overflow-hidden bg-white shadow-sm" style="width: 120px; height: 60px;">
                                                    ${data.motion_parallax_2 ? `<img src="../${data.motion_parallax_2}" class="w-100 h-100 object-fit-cover">` : `<div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>`}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="triggerSingleUpload('motion_parallax_2_val')">Upload Parallax Image</button>
                                                    <p class="mb-0 small text-muted">Final immersive image at the bottom of the case study.</p>
                                                    <input type="hidden" name="motion_parallax_2" id="motion_parallax_2_val" value="${data.motion_parallax_2 || ''}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                if (data.motion_challenge_points) {
                    try {
                        const points = typeof data.motion_challenge_points === 'string' ? JSON.parse(data.motion_challenge_points) : (data.motion_challenge_points || []);
                        if (Array.isArray(points)) points.forEach(p => addMotionChallengePoint(p));
                    } catch(e) {}
                }
            } else if (slug === 'ui-ux-design') {
                // HIDE Standard fields that are replaced by PD specialized fields
                if (standardHeroSpecs) standardHeroSpecs.classList.add('d-none');
                // We keep standardBodyNarrative visible for Overview and Challenge
                if (standardBodyNarrative) standardBodyNarrative.classList.remove('d-none');
                
                heroContainer.innerHTML = `
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-primary"><i class="bi bi-palette me-2"></i>Product Design Hero Specs</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Hero Main Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pd_hero_title" value="${data.pd_hero_title || ''}" placeholder="e.g. Smart, Secure, and Simple">
                                        <input type="text" class="form-control border-primary" name="pd_hero_title_highlight" value="${data.pd_hero_title_highlight || ''}" placeholder="Highlight (e.g. Banking)">
                                    </div>
                                    <small class="text-muted">The highlight text will be rendered with the primary gradient effect.</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Hero Subtitle</label>
                                    <textarea class="form-control" name="pd_hero_subtitle" rows="2" placeholder="e.g. Experience seamless money transfers and secure account management.">${data.pd_hero_subtitle || ''}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Google Play Link</label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" name="pd_google_play_enabled" value="1" ${data.pd_google_play_enabled === '1' ? 'checked' : ''} aria-label="Enable Google Play">
                                        </div>
                                        <input type="text" class="form-control" name="pd_google_play" value="${data.pd_google_play || ''}" placeholder="https://play.google.com/...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">App Store Link</label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" name="pd_app_store_enabled" value="1" ${data.pd_app_store_enabled === '1' ? 'checked' : ''} aria-label="Enable App Store">
                                        </div>
                                        <input type="text" class="form-control" name="pd_app_store" value="${data.pd_app_store || ''}" placeholder="https://apps.apple.com/...">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Social Proof Label</label>
                                    <input type="text" class="form-control" name="pd_social_proof" value="${data.pd_social_proof || ''}" placeholder="e.g. 5000+ downloads">
                                </div>
                                
                                <!-- Hero Deco Images -->
                                <div class="col-md-6">
                                    <label class="form-label">Hero Decoration 1 (Small Overlay)</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <div id="pd_hero_deco_1_preview" class="border rounded bg-light" style="width: 60px; height: 40px; overflow: hidden;">
                                            ${data.pd_hero_deco_1 ? `<img src="../${data.pd_hero_deco_1}" class="w-100 h-100 object-fit-cover">` : ''}
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="triggerSingleUpload('pd_hero_deco_1_val')">Upload</button>
                                        <input type="hidden" name="pd_hero_deco_1" id="pd_hero_deco_1_val" value="${data.pd_hero_deco_1 || ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hero Decoration 2 (Medium Overlay)</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <div id="pd_hero_deco_2_preview" class="border rounded bg-light" style="width: 60px; height: 40px; overflow: hidden;">
                                            ${data.pd_hero_deco_2 ? `<img src="../${data.pd_hero_deco_2}" class="w-100 h-100 object-fit-cover">` : ''}
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="triggerSingleUpload('pd_hero_deco_2_val')">Upload</button>
                                        <input type="hidden" name="pd_hero_deco_2" id="pd_hero_deco_2_val" value="${data.pd_hero_deco_2 || ''}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                bodyContainer.innerHTML = `
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-dark bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0"><i class="bi bi-layout-three-columns me-2"></i>Product Features & Metrics</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label">Features Section Title</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pd_features_title" value="${data.pd_features_title || ''}" placeholder="e.g. Discover the power of our online">
                                    <input type="text" class="form-control border-primary" name="pd_features_title_highlight" value="${data.pd_features_title_highlight || ''}" placeholder="Highlight (e.g. Banking)">
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary mb-3">Left Features (1-3)</label>
                                    ${[1, 2, 3].map(i => `
                                        <div class="mb-3 p-2 border rounded bg-light">
                                            <div class="row g-2">
                                                <div class="col-3"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_icon" value="${data['pd_feat_' + i + '_icon'] || 'bi-check-lg'}" placeholder="Icon"></div>
                                                <div class="col-9"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_title" value="${data['pd_feat_' + i + '_title'] || ''}" placeholder="Title"></div>
                                                <div class="col-12 mt-1"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_desc" value="${data['pd_feat_' + i + '_desc'] || ''}" placeholder="Description"></div>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary mb-3">Right Features (4-6)</label>
                                    ${[4, 5, 6].map(i => `
                                        <div class="mb-3 p-2 border rounded bg-light">
                                            <div class="row g-2">
                                                <div class="col-3"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_icon" value="${data['pd_feat_' + i + '_icon'] || 'bi-check-lg'}" placeholder="Icon"></div>
                                                <div class="col-9"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_title" value="${data['pd_feat_' + i + '_title'] || ''}" placeholder="Title"></div>
                                                <div class="col-12 mt-1"><input type="text" class="form-control form-control-sm" name="pd_feat_${i}_desc" value="${data['pd_feat_' + i + '_desc'] || ''}" placeholder="Description"></div>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>

                            <div class="row g-3 mb-4 p-3 bg-secondary bg-opacity-10 rounded">
                                <div class="col-md-4">
                                    <label class="form-label">Stat 1 (e.g. 4.5/5.0)</label>
                                    <input type="text" class="form-control" name="pd_stat_1_val" value="${data.pd_stat_1_val || ''}">
                                    <input type="text" class="form-control mt-1" name="pd_stat_1_label" value="${data.pd_stat_1_label || ''}" placeholder="Label">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stat 2 (e.g. 35K+)</label>
                                    <input type="text" class="form-control" name="pd_stat_2_val" value="${data.pd_stat_2_val || ''}">
                                    <input type="text" class="form-control mt-1" name="pd_stat_2_label" value="${data.pd_stat_2_label || ''}" placeholder="Label">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stat 3 (e.g. 86M)</label>
                                    <input type="text" class="form-control" name="pd_stat_3_val" value="${data.pd_stat_3_val || ''}">
                                    <input type="text" class="form-control mt-1" name="pd_stat_3_label" value="${data.pd_stat_3_label || ''}" placeholder="Label">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Impact Result Description</label>
                                <textarea class="form-control" name="pd_result_text" rows="3" placeholder="Describe the outcome of the project...">${data.pd_result_text || ''}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Product Screens Gallery <span class="text-primary small ms-2">(Recommended: UI Design Screenshots / Mobile Screens)</span></label>
                                <input type="text" class="form-control mb-2" name="pd_gallery_title" value="${data.pd_gallery_title || ''}" placeholder="Gallery Section Title (e.g. Get a closer look at how it works)">
                                <textarea class="form-control mb-3" name="pd_gallery_desc" rows="2" placeholder="Gallery description...">${data.pd_gallery_desc || ''}</textarea>
                                <div class="row g-2">
                                    ${[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map(i => `
                                        <div class="col-4 col-md-3 col-lg-2">
                                            <div class="card border-0 shadow-sm bg-white p-1 text-center position-relative h-100 transition-all hover-shadow-md" style="border: 1px solid rgba(0,0,0,0.05) !important; border-radius: 12px !important; overflow: hidden;">
                                                <div id="pd_screen_${i}_preview" class="bg-light rounded-top overflow-hidden d-flex align-items-center justify-content-center" style="aspect-ratio: 9/16; min-height: 140px; background-size: cover; background-position: center; border-bottom: 1px solid rgba(0,0,0,0.05);">
                                                    ${data['pd_screen_' + i] ? 
                                                        (data['pd_screen_' + i].endsWith('.mp4') ? 
                                                            `<video src="../${data['pd_screen_' + i]}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>` : 
                                                            `<img src="../${data['pd_screen_' + i]}" class="w-100 h-100 object-fit-cover">`
                                                        ) : 
                                                        '<div class="text-center"><i class="bi bi-phone text-muted opacity-25 fs-1"></i><p class="mb-0 x-small text-muted opacity-50">Empty</p></div>'}
                                                </div>
                                                <div class="p-2">
                                                    <button type="button" class="btn btn-xs btn-soft-primary w-100 py-1 fw-bold" style="font-size: 10px; border-radius: 6px;" onclick="triggerSingleUpload('pd_screen_${i}_val')">
                                                        <i class="bi bi-cloud-arrow-up me-1"></i>SCREEN ${i}
                                                    </button>
                                                </div>
                                                <div id="pd_screen_${i}_status" class="position-absolute top-0 end-0 m-2 ${data['pd_screen_' + i] ? '' : 'd-none'}">
                                                    <span class="badge rounded-circle bg-success p-1 shadow-sm"><i class="bi bi-check-lg" style="font-size: 8px;"></i></span>
                                                </div>
                                                <input type="hidden" name="pd_screen_${i}" id="pd_screen_${i}_val" value="${data['pd_screen_' + i] || ''}">
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Steps Section -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-success bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-success"><i class="bi bi-list-check me-2"></i>Product Development Phases (Steps)</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                ${[1, 2, 3].map(i => `
                                    <div class="col-md-4">
                                        <div class="p-3 border rounded bg-light h-100">
                                            <label class="form-label fw-bold">Step ${i}</label>
                                            <input type="text" class="form-control form-control-sm mb-2" name="pd_step_${i}_phase" value="${data['pd_step_' + i + '_phase'] || `Phase ${i}`}" placeholder="Phase Name">
                                            <input type="text" class="form-control form-control-sm mb-2" name="pd_step_${i}_title" value="${data['pd_step_' + i + '_title'] || ''}" placeholder="Step Title">
                                            <textarea class="form-control form-control-sm mb-2" name="pd_step_${i}_desc" rows="3" placeholder="Description">${data['pd_step_' + i + '_desc'] || ''}</textarea>
                                            
                                            <label class="form-label small">Step Image</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <div id="pd_step_${i}_img_preview" class="border rounded bg-white" style="width: 50px; height: 50px; overflow: hidden;">
                                                    ${data['pd_step_' + i + '_img'] ? `<img src="../${data['pd_step_' + i + '_img']}" class="w-100 h-100 object-fit-cover">` : ''}
                                                </div>
                                                <button type="button" class="btn btn-xs btn-outline-success" onclick="triggerSingleUpload('pd_step_${i}_img_val')">Upload</button>
                                                <input type="hidden" name="pd_step_${i}_img" id="pd_step_${i}_img_val" value="${data['pd_step_' + i + '_img'] || ''}">
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>

                    <!-- Showcase Grids -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-warning bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-warning"><i class="bi bi-grid-3x3-gap me-2"></i>Visual Showcase Grids</h6>
                        </div>
                        <div class="card-body p-4">
                            <label class="form-label fw-bold">Grid 1 (4 Quadrant Images)</label>
                            <div class="row g-2 mb-4">
                                ${[1, 2, 3, 4].map(i => `
                                    <div class="col-3">
                                        <div class="border rounded p-1 bg-light text-center">
                                            <div id="pd_grid1_${i}_preview" class="ratio ratio-1x1 bg-white rounded overflow-hidden mb-1">
                                                ${data['pd_grid1_' + i] ? `<img src="../${data['pd_grid1_' + i]}" class="w-100 h-100 object-fit-cover">` : ''}
                                            </div>
                                            <button type="button" class="btn btn-xs btn-outline-warning py-0 w-100" onclick="triggerSingleUpload('pd_grid1_${i}_val')">Img ${i}</button>
                                            <input type="hidden" name="pd_grid1_${i}" id="pd_grid1_${i}_val" value="${data['pd_grid1_' + i] || ''}">
                                        </div>
                                    </div>
                                `).join('')}
                            </div>

                            <label class="form-label fw-bold">Grid 2 (2 Side-by-Side + 1 Parallax)</label>
                            <div class="row g-2 mb-3">
                                ${[1, 2].map(i => `
                                    <div class="col-6">
                                        <div class="border rounded p-1 bg-light text-center">
                                            <div id="pd_grid2_${i}_preview" class="ratio ratio-4x3 bg-white rounded overflow-hidden mb-1">
                                                ${data['pd_grid2_' + i] ? `<img src="../${data['pd_grid2_' + i]}" class="w-100 h-100 object-fit-cover">` : ''}
                                            </div>
                                            <button type="button" class="btn btn-xs btn-outline-warning py-0 w-100" onclick="triggerSingleUpload('pd_grid2_${i}_val')">Side ${i}</button>
                                            <input type="hidden" name="pd_grid2_${i}" id="pd_grid2_${i}_val" value="${data['pd_grid2_' + i] || ''}">
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="border rounded p-2 bg-light">
                                <label class="form-label small fw-bold">Large Parallax Background</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div id="pd_parallax_preview" class="border rounded bg-white shadow-sm" style="width: 150px; height: 60px; overflow: hidden;">
                                        ${data.pd_parallax ? `<img src="../${data.pd_parallax}" class="w-100 h-100 object-fit-cover">` : ''}
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="triggerSingleUpload('pd_parallax_val')">Upload Parallax</button>
                                    <input type="hidden" name="pd_parallax" id="pd_parallax_val" value="${data.pd_parallax || ''}">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else if (slug === 'video-editing-production' || slug === 'video-editing' || slug === 'video-production') {
                if (comparisonContainer) comparisonContainer.classList.add('d-none');
                if (additionalImagesContainer) additionalImagesContainer.classList.add('d-none');

                heroContainer.innerHTML = `
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-primary"><i class="bi bi-camera-video me-2"></i>Video Editing & Production Specs</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Hero Main Title (Supports HTML)</label>
                                    <input type="text" class="form-control" name="ve_hero_title" value="${data.ve_hero_title || 'High-Impact <span class=&quot;text-purple&quot;>Video Production</span> & Editing'}" placeholder="Hero Title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Scope</label>
                                    <input type="text" class="form-control" name="ve_scope" value="${data.ve_scope || 'Global'}" placeholder="e.g. Global, Local">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                bodyContainer.innerHTML = `
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-primary"><i class="bi bi-film me-2"></i>Media Sequence Builder (Videos)</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label">Video Gallery Title</label>
                                <input type="text" class="form-control" name="ve_gallery_title" value="${data.ve_gallery_title || 'Impactful Video & Motion Graphics'}" placeholder="Gallery Section Title">
                            </div>

                            <div class="row g-4">
                                ${[1, 2, 3, 4, 5].map(i => `
                                    <div class="col-md-6 col-lg-4">
                                        <div class="border rounded p-3 bg-light position-relative h-100">
                                            <h6 class="mb-2 text-muted">Video Slot ${i}</h6>
                                            <div id="ve_video_${i}_preview" class="ratio ratio-16x9 bg-dark rounded overflow-hidden mb-2 shadow-sm d-flex align-items-center justify-content-center">
                                                ${data['ve_video_' + i] ? 
                                                    `<video src="../${data['ve_video_' + i]}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>` : 
                                                    '<i class="bi bi-play-circle text-muted fs-1 opacity-50"></i>'}
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2" onclick="triggerSingleUpload('ve_video_${i}_val')"><i class="bi bi-upload me-1"></i> Upload Video</button>
                                            <input type="hidden" name="ve_video_${i}" id="ve_video_${i}_val" value="${data['ve_video_' + i] || ''}">
                                            
                                            <input type="text" class="form-control form-control-sm mb-1" name="ve_video_${i}_title" value="${data['ve_video_' + i + '_title'] || ''}" placeholder="Video Title">
                                            <input type="text" class="form-control form-control-sm" name="ve_video_${i}_desc" value="${data['ve_video_' + i + '_desc'] || ''}" placeholder="Short Description">
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            } else if (slug === 'digital-marketing-ads' || slug === 'digital-marketing') {
                if (comparisonContainer) comparisonContainer.classList.add('d-none');
                if (standardHeroSpecs) standardHeroSpecs.classList.add('d-none');
                if (standardBodyNarrative) standardBodyNarrative.classList.add('d-none');
                heroContainer.innerHTML = `
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-primary"><i class="bi bi-graph-up-arrow me-2"></i>Digital Marketing Specs</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Hero Title (Supports HTML)</label>
                                    <input type="text" class="form-control" name="dm_hero_title" value="${data.dm_hero_title || 'High-Impact Marketing & ROI-Driven Ad Strategies'}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hero Subtitle</label>
                                    <textarea class="form-control" name="dm_hero_subtitle" rows="2">${data.dm_hero_subtitle || 'Transforming brand visibility into measurable revenue through precision-targeted campaigns and data-driven ad optimization.'}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hero CTA Label</label>
                                    <input type="text" class="form-control" name="dm_hero_cta" value="${data.dm_hero_cta || 'Request Strategy Audit'}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hero CTA Link</label>
                                    <input type="text" class="form-control" name="dm_hero_link" value="${data.dm_hero_link || '#'}">
                                </div>
                                
                                <div class="col-md-12 mt-4">
                                    <h6 class="border-bottom pb-2">Benefits Section</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Benefits Title</label>
                                    <input type="text" class="form-control" name="dm_benefits_title" value="${data.dm_benefits_title || 'Maximize Your Digital Footprint with Performance Marketing'}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Benefits List (Comma separated)</label>
                                    <textarea class="form-control" name="dm_benefits_list" rows="2">${data.dm_benefits_list || 'Omnichannel Campaign Management, Conversion Rate Optimization (CRO), Precision Audience Segmenting'}</textarea>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <h6 class="border-bottom pb-2">Stats block</h6>
                                </div>
                                ${[1, 2, 3, 4].map(i => `
                                <div class="col-md-3">
                                    <div class="border rounded p-2 bg-light">
                                        <label class="form-label small mb-1">Stat ${i}</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <input type="text" class="form-control" name="dm_stat_${i}_val" value="${data['dm_stat_'+i+'_val'] || (i===1?'250':(i===2?'15':(i===3?'4.5':'98')))}" placeholder="Value">
                                            <input type="text" class="form-control" name="dm_stat_${i}_sym" value="${data['dm_stat_'+i+'_sym'] || (i===1?'+':(i===2?'M+':(i===3?'x':'%')))}" placeholder="Sym" style="max-width: 50px;">
                                        </div>
                                        <select class="form-select form-select-sm mb-2" name="dm_stat_${i}_color">
                                            <option value="text-primary" ${data['dm_stat_'+i+'_color'] === 'text-primary' || !data['dm_stat_'+i+'_color'] ? 'selected' : ''}>Primary Color</option>
                                            <option value="text-success" ${data['dm_stat_'+i+'_color'] === 'text-success' ? 'selected' : ''}>Success (Green)</option>
                                            <option value="text-warning" ${data['dm_stat_'+i+'_color'] === 'text-warning' ? 'selected' : ''}>Warning (Yellow)</option>
                                            <option value="text-danger" ${data['dm_stat_'+i+'_color'] === 'text-danger' ? 'selected' : ''}>Danger (Red)</option>
                                            <option value="text-pink" ${data['dm_stat_'+i+'_color'] === 'text-pink' ? 'selected' : ''}>Pink</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm" name="dm_stat_${i}_label" value="${data['dm_stat_'+i+'_label'] || (i===1?'Campaigns Launched':(i===2?'Ad Impressions':(i===3?'Avg. Ad ROI':'Client Retention')))}" placeholder="Label">
                                    </div>
                                </div>
                                `).join('')}

                                <div class="col-md-12 mt-4">
                                    <h6 class="border-bottom pb-2">Decoration Images</h6>
                                </div>
                                ${[1, 2, 3].map(i => `
                                <div class="col-md-4">
                                    <label class="form-label">Decor ${i} ${i===1?'(Top)':(i===2?'(Bottom)':'(Benefits)')}</label>
                                    <div class="media-uploader-box position-relative" onclick="document.getElementById('dm_hero_decor_${i}_file').click()">
                                        <i class="bi bi-cloud-arrow-up display-6 text-primary mb-1"></i>
                                        <p class="small mb-0">Upload Decor ${i}</p>
                                        <input type="file" id="dm_hero_decor_${i}_file" class="d-none" onchange="handleSingleUpload(this, 'service_sections', 'dm_hero_decor_${i}')" accept="image/*">
                                    </div>
                                    <div id="dm_hero_decor_${i}_preview" class="media-preview-container mt-2 ${data['dm_hero_decor_'+i] ? '' : 'd-none'}">
                                        <img src="${data['dm_hero_decor_'+i] ? '../' + data['dm_hero_decor_'+i] : ''}" class="work-image-preview w-100 rounded" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    <input type="hidden" name="dm_hero_decor_${i}" id="dm_hero_decor_${i}" value="${data['dm_hero_decor_'+i] || ''}">
                                </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;

                bodyContainer.innerHTML = `
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 p-3">
                            <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Core Features & Parallax</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                ${[1, 2, 3].map(i => `
                                <div class="col-md-12">
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="mb-3 text-muted">Feature ${i}</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control" name="dm_feature_${i}_title" value="${data['dm_feature_'+i+'_title'] || (i===1 ? 'Precision Audience Targeting' : (i===2 ? 'Real-time Ad Performance Tracking' : 'Scalable Multi-Channel Growth'))}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Feature ${i} Image</label>
                                                <div class="media-uploader-box position-relative" onclick="document.getElementById('dm_feature_${i}_img_file').click()">
                                                    <i class="bi bi-cloud-arrow-up display-6 text-primary mb-1"></i>
                                                    <p class="small mb-0">Upload Feature Image</p>
                                                    <input type="file" id="dm_feature_${i}_img_file" class="d-none" onchange="handleSingleUpload(this, 'service_sections', 'dm_feature_${i}_img')" accept="image/*">
                                                </div>
                                                <div id="dm_feature_${i}_img_preview" class="media-preview-container mt-2 ${data['dm_feature_'+i+'_img'] ? '' : 'd-none'}">
                                                    <img src="${data['dm_feature_'+i+'_img'] ? '../' + data['dm_feature_'+i+'_img'] : ''}" class="work-image-preview w-100 rounded" style="max-height: 150px; object-fit: cover;">
                                                </div>
                                                <input type="hidden" name="dm_feature_${i}_img" id="dm_feature_${i}_img" value="${data['dm_feature_'+i+'_img'] || ''}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="dm_feature_${i}_desc" rows="2">${data['dm_feature_'+i+'_desc'] || ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `).join('')}

                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Parallax Background Image</label>
                                    <div class="media-uploader-box position-relative" onclick="document.getElementById('dm_parallax_file').click()">
                                        <i class="bi bi-cloud-arrow-up display-6 text-primary mb-1"></i>
                                        <p class="small mb-0">Upload Parallax Image</p>
                                        <input type="file" id="dm_parallax_file" class="d-none" onchange="handleSingleUpload(this, 'service_sections', 'dm_parallax')" accept="image/*">
                                    </div>
                                    <div id="dm_parallax_preview" class="media-preview-container mt-2 ${data.dm_parallax ? '' : 'd-none'}">
                                        <img src="${data.dm_parallax ? '../' + data.dm_parallax : ''}" class="work-image-preview w-100 rounded" style="max-height: 250px; object-fit: cover;">
                                    </div>
                                    <input type="hidden" name="dm_parallax" id="dm_parallax" value="${data.dm_parallax || ''}">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        function addTechStackRow(data = null) {
            const container = document.getElementById('tech-stack-container');
            if (!container) return;
            const id = 'tech-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.className = 'col-md-4 tech-row-item';
            div.id = id;
            div.innerHTML = `
                <div class="premium-row-bg rounded-3 p-2 d-flex align-items-center gap-2 position-relative shadow-sm">
                    <div class="avatar avatar-sm border rounded-2 flex-shrink-0 bg-light" style="cursor: pointer; width: 35px; height: 35px;" onclick="triggerRowUpload('${id}')">
                        <img src="${data && data.icon ? '../' + data.icon : '../assets/images/favicon/Vector.ico'}" class="avatar-img tech-icon-preview">
                        <input type="hidden" class="tech-icon-val" value="${data ? data.icon : ''}">
                    </div>
                    <input type="text" class="form-control form-control-sm border-0 tech-label" placeholder="Label (e.g. Laravel)" value="${data ? data.label : ''}">
                    <button type="button" class="btn btn-link text-danger p-0 ms-auto me-1" onclick="document.getElementById('${id}').remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        }

        function addSectionFeatureRow(data = null) {
            const container = document.getElementById('section-features-container');
            if (!container) return;

            // Enforce limit of 4
            const existingRows = container.querySelectorAll('.feature-row-item');
            if (!data && existingRows.length >= 4) {
                showPremiumAlert('Feature Limit Reached', 'Maximum 4 feature cards allowed for this section.', 'info');
                return;
            }

            const id = 'feat-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.className = 'feature-row-item mb-3 p-3 premium-row-bg rounded-3 border';
            div.id = id;
            
            // Safer data extraction
            const iconVal = (data && data.icon) ? data.icon : 'bi-cpu';
            const titleVal = (data && data.title) ? data.title : '';
            const descVal = (data && data.desc) ? data.desc : '';

            div.innerHTML = `
                <div class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm feat-icon" placeholder="Icon (bi-cpu)" value="${iconVal}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm feat-title" placeholder="Title" value="${titleVal}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-control-sm feat-desc" placeholder="Short Description" value="${descVal}">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="document.getElementById('${id}').remove()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        function triggerRowUpload(rowId) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (e) => {
                const file = e.target.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('folder', 'tech_stack');
                fetch('../api/upload.php', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(json => {
                    if (json.success) {
                        const row = document.getElementById(rowId);
                        row.querySelector('.tech-icon-val').value = json.path;
                        row.querySelector('.tech-icon-preview').src = '../' + json.path;
                    }
                });
            };
            input.click();
        }

        function triggerSingleUpload(targetId) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*,video/mp4';
            input.onchange = (e) => {
                const file = e.target.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('folder', 'service_sections');
                
                // Pass work title for context-aware naming
                const workTitle = document.getElementById('title')?.value || '';
                formData.append('work_title', workTitle);

                fetch('../api/upload.php', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(json => {
                    if (json.success) {
                        document.getElementById(targetId).value = json.path;
                        
                        const previewId = targetId.replace('_val', '') + '_preview';
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            preview.classList.remove('d-none');
                            if (json.path.toLowerCase().endsWith('.mp4')) {
                                preview.innerHTML = `<video src="../${json.path}" class="w-100 h-100 object-fit-cover" autoplay loop muted playsinline></video>`;
                            } else {
                                preview.innerHTML = `<img src="../${json.path}" class="w-100 h-100 object-fit-cover">`;
                            }
                        }
                        
                        const statusId = targetId.replace('_val', '') + '_status';
                        const statusEl = document.getElementById(statusId);
                        if (statusEl) statusEl.classList.remove('d-none');
                        
                        showToast('Screen uploaded successfully', 'success');
                    } else {
                        showToast(json.error || 'Upload failed', 'danger');
                    }
                });
            };
            input.click();
        }

        function addMotionChallengePoint(val = '') {
            const container = document.getElementById('motion-challenge-list-container');
            if (!container) return;
            const id = 'motion-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.id = id;
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <span class="input-group-text bg-light text-primary"><i class="bi bi-check2-circle"></i></span>
                <input type="text" class="form-control motion-point-val" value="${val}" placeholder="e.g. Visual Identity Transition">
                <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('${id}').remove()">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addTestimonialRow(data = null) {
            const container = document.getElementById('testimonials-container');
            if (!container) return;
            const id = 'testimonial-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.id = id;
            div.className = 'testimonial-row-item p-3 mb-3 premium-row-bg rounded-4 position-relative transition-all';
            
            // Check for broken images or placeholders
            const imgPath = data && data.image ? '../' + data.image : '../assets/images/avatar/01.jpg';
            
            div.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold text-muted">QUOTE</label>
                        <textarea class="form-control t-text shadow-none" rows="4" placeholder="Enter client testimonial text..." style="border-radius: 15px; resize: none;">${data ? data.text : ''}</textarea>
                    </div>
                    <div class="col-md-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label small fw-bold mb-0">AUTHOR INFO</label>
                            <button type="button" class="btn btn-link text-danger p-0" onclick="document.getElementById('${id}').remove()" title="Remove Slide">
                                <i class="bi bi-x-circle-fill fs-5"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control form-control-sm mb-2 t-author" placeholder="Author Name" value="${data ? data.author : ''}" style="border-radius: 12px;">
                        <input type="text" class="form-control form-control-sm mb-3 t-role" placeholder="Role / Company" value="${data ? data.role : ''}" style="border-radius: 12px;">
                        
                        <div class="d-flex align-items-center gap-3 mt-auto">
                            <div class="avatar avatar-lg avatar-clickable border-2 border-primary" onclick="this.closest('.testimonial-row-item').querySelector('.testimonial-file-input').click()" style="width: 50px; height: 50px; cursor: pointer; min-width: 50px;">
                                <img src="${imgPath}" class="avatar-img rounded-circle t-img-preview" style="object-fit:cover; width: 100%; height: 100%; aspect-ratio: 1/1;">
                                <div class="avatar-clickable-overlay rounded-circle">
                                    <i class="bi bi-camera text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block small fw-bold text-muted mb-0">Client Avatar</span>
                                <button type="button" class="btn btn-link p-0 small text-primary text-decoration-none" onclick="this.closest('.testimonial-row-item').querySelector('.testimonial-file-input').click()">
                                    Change Image
                                </button>
                                <input type="hidden" class="t-image" value="${data ? data.image : ''}">
                                <input type="file" class="d-none testimonial-file-input" onchange="handleTestimonialImageUpload(this, '${id}')" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        function handleTestimonialImageUpload(input, rowId) {
            if (!input.files || !input.files[0]) return;
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('folder', 'testimonials');

            fetch('../api/upload.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(json => {
                if (json.success) {
                    const row = document.getElementById(rowId);
                    if (row) {
                        row.querySelector('.t-image').value = json.path;
                        row.querySelector('.t-img-preview').src = '../' + json.path;
                        showToast('Client avatar updated', 'success');
                    }
                } else {
                    showToast(json.error || 'Upload failed', 'danger');
                }
            })
            .catch(err => {
                console.error('Upload error:', err);
                showToast('Upload Error', 'danger');
            });
        }


        function addHighlightRow(data = null) {
            const container = document.getElementById('highlights-list-container');
            const id = 'highlight-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.id = id;
            div.className = 'col-md-6 mb-2';
            div.innerHTML = `
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-info bg-opacity-10 text-info"><i class="bi bi-check2"></i></span>
                    <input type="text" class="form-control highlight-row-val" value="${data ? data.text : ''}" placeholder="Highlight feature...">
                    <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('${id}').remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        }

        function addRatingStatRow(data = null) {
            const container = document.getElementById('ratings-list-container');
            const id = 'rating-' + Date.now() + Math.floor(Math.random() * 1000);
            const div = document.createElement('div');
            div.id = id;
            div.className = 'col-md-4 mb-3 rating-row-item';
            div.innerHTML = `
                <div class="p-2 border rounded bg-light">
                    <div class="d-flex justify-content-between mb-2">
                        <label class="form-label small fw-bold mb-0">Stat Item</label>
                        <button type="button" class="btn btn-link text-danger p-0" onclick="document.getElementById('${id}').remove()">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control form-control-sm mb-1 rating-val" value="${data ? data.val : ''}" placeholder="Value (e.g. 4.5/5.0)">
                    <input type="text" class="form-control form-control-sm rating-label" value="${data ? data.label : ''}" placeholder="Label (e.g. Reviews)">
                </div>
            `;
            container.appendChild(div);
        }

    </script>
</body>

</html>
