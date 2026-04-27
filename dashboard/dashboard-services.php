<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');

// Helper to calculate directory stats
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
$capacityMB = 500;
$storagePercent = min(100, round(($usedMB / $capacityMB) * 100, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - Manage Services</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

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
                <div class="row pb-4">
                    <div class="col-12">
                        <div class="d-sm-flex justify-content-sm-between align-items-center mt-4 text-center">
                            <h1 class="mb-2 mb-sm-0 h2">Service Management <span
                                    class="badge bg-primary bg-opacity-10 text-primary ms-2" id="service_count"
                                    style="font-weight: 600; border-radius: 8px; padding: 6px 12px;">0</span></h1>
                            <button class="btn btn-premium mb-0" data-bs-toggle="modal" onclick="resetForm()"
                                data-bs-target="#serviceModal"><i class="fas fa-plus me-2"></i>Add NEW service</button>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <!-- Stat Card 1: Documents -->
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-info">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h3 class="mb-0"><?php echo $uploadStats['docs']; ?></h3>
                            <h6 class="mb-0 text-secondary small">Documents</h6>
                        </div>
                    </div>

                    <!-- Stat Card 2: Videos -->
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-warning">
                                <i class="bi bi-camera-reels"></i>
                            </div>
                            <h3 class="mb-0"><?php echo $uploadStats['vids']; ?></h3>
                            <h6 class="mb-0 text-secondary small">Videos</h6>
                        </div>
                    </div>

                    <!-- Stat Card 3: Images -->
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-emerald">
                                <i class="bi bi-image"></i>
                            </div>
                            <h3 class="mb-0"><?php echo $uploadStats['imgs']; ?></h3>
                            <h6 class="mb-0 text-secondary small">Images</h6>
                        </div>
                    </div>

                    <!-- Stat Card 4: Folders -->
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <div class="card card-body h-100">
                            <div class="stat-icon bg-soft-success">
                                <i class="bi bi-folder2-open"></i>
                            </div>
                            <h3 class="mb-0"><?php echo $uploadStats['folders']; ?></h3>
                            <h6 class="mb-0 text-secondary small">Folders</h6>
                        </div>
                    </div>

                    <!-- Storage Card -->
                    <div class="col-lg-4">
                        <div class="card card-body h-100">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0">Storage space</h5>
                                <div class="ms-auto stat-icon bg-light mb-0"
                                    style="width: 32px; height: 32px; font-size: 1rem;">
                                    <i class="bi bi-cloud-check"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="mt-0 text-secondary small">Usage <?php echo $storagePercent; ?>%</h6>
                                <span class="small fw-bold text-primary"><?php echo $usedMB; ?>MB of
                                    <?php echo $capacityMB; ?>MB</span>
                            </div>
                            <div class="progress progress-premium">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: <?php echo $storagePercent; ?>%; background: linear-gradient(90deg, #F48C06, #EBAF41);"
                                    aria-valuenow="<?php echo $storagePercent; ?>" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5" id="services-grid">
                    <!-- Services will be loaded here via JS -->
                </div>

                <!-- Services Table START -->
                <div class="card rounded-3">
                    <div class="card-header bg-transparent border-bottom p-3">
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-md-8">
                                <form class="rounded position-relative">
                                    <input class="form-control pe-5" type="search" id="serviceSearch"
                                        placeholder="Search services..." aria-label="Search" onkeyup="filterServices()"
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
                                            Service Name</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Slug</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Badge</th>
                                        <th scope="col" class="border-0" style="padding: 15px 20px;">Status</th>
                                        <th scope="col" class="border-0 rounded-end" style="padding: 15px 20px;">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0" id="services-table-body">
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
                <!-- Services Table END -->
            </div>
        </section>
    </main>

    <!-- Service Modal -->
    <div class="modal fade modal-premium" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Service Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs premium-nav-tabs mb-4" id="serviceTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-general" type="button" role="tab">General Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero"
                                type="button" role="tab">Hero Section</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-overview" type="button" role="tab">Detailed Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="toolkit-tab" data-bs-toggle="tab" data-bs-target="#tab-toolkit"
                                type="button" role="tab">Tool Kit</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="asset-tab" data-bs-toggle="tab" data-bs-target="#tab-asset"
                                type="button" role="tab">Asset Library</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#tab-data"
                                type="button" role="tab">Dynamic Data</button>
                        </li>
                    </ul>

                    <form id="serviceForm">
                        <input type="hidden" id="service-id">

                        <div class="tab-content" id="serviceTabContent">
                            <!-- Tab 1: General -->
                            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-info-circle-fill me-2"></i> This information defines the core
                                    identification and visibility of the service across the platform.
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Service Name</label>
                                        <input type="text" class="form-control" id="name" required
                                            placeholder="e.g. Web Development">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">URL Slug</label>
                                        <input type="text" class="form-control" id="slug" required
                                            placeholder="e.g. web-development">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Short Marketing Description</label>
                                        <textarea class="form-control" id="description_short" rows="3"
                                            placeholder="A brief summary for cards and lists..."></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">3D Icon Asset</label>
                                        <div class="media-uploader-box"
                                            onclick="document.getElementById('icon_3d_file').click()">
                                            <i class="bi bi-image display-6 text-primary mb-1"></i>
                                            <p class="small mb-0">Click to Upload 3D Icon</p>
                                            <input type="file" id="icon_3d_file" class="d-none"
                                                onchange="handleSingleUpload(this, 'icons', 'icon_3d')"
                                                accept="image/*">
                                        </div>
                                        <div id="icon_3d_preview" class="media-preview-container d-none">
                                            <img src="" class="icon-preview">
                                        </div>
                                        <input type="hidden" id="icon_3d">
                                        <span id="icon_3d_path" class="path-span d-none"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Publishing Status</label>
                                        <div id="status-select-container"></div>
                                        <input type="hidden" id="status" value="active">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Hero -->
                            <div class="tab-pane fade" id="tab-hero" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-camera-reels-fill me-2"></i> The Hero section is the first thing
                                    users see. Ensure you use high-quality video backgrounds and clear headlines.
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label">Hero Banner Title</label>
                                        <input type="text" class="form-control" id="hero_title"
                                            placeholder="Main headline for the service page">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Hero Background Video</label>
                                        <div class="media-uploader-box"
                                            onclick="document.getElementById('hero_video_file').click()">
                                            <i class="bi bi-play-circle display-6 text-primary mb-1"></i>
                                            <p class="small mb-0">Click to Upload Hero Video</p>
                                            <input type="file" id="hero_video_file" class="d-none"
                                                onchange="handleSingleUpload(this, 'videos', 'hero_video')"
                                                accept="video/*">
                                        </div>
                                        <div id="hero_video_preview" class="media-preview-container d-none">
                                            <video autoplay muted loop class="video-preview"></video>
                                        </div>
                                        <input type="hidden" id="hero_video">
                                        <span id="hero_video_path" class="path-span d-none"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Overview -->
                            <div class="tab-pane fade" id="tab-overview" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-file-text-fill me-2"></i> Provide a deep-dive into your service.
                                    This section appears as a detailed content block with a supporting video.
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Overview Badge</label>
                                        <input type="text" class="form-control" id="overview_badge"
                                            value="Company Overview">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Section Title</label>
                                        <input type="text" class="form-control" id="overview_title">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Lead Paragraph (Bold Intro)</label>
                                        <textarea class="form-control" id="overview_lead" rows="2"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Main Content Text</label>
                                        <textarea class="form-control" id="overview_text" rows="5"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Supporting Detail Video</label>
                                        <div class="media-uploader-box"
                                            onclick="document.getElementById('detail_video_file').click()">
                                            <i class="bi bi-play-circle display-6 text-primary mb-1"></i>
                                            <p class="small mb-0">Click to Upload Detail Video</p>
                                            <input type="file" id="detail_video_file" class="d-none"
                                                onchange="handleSingleUpload(this, 'videos', 'detail_video')"
                                                accept="video/*">
                                        </div>
                                        <div id="detail_video_preview" class="media-preview-container d-none">
                                            <video autoplay muted loop class="video-preview"></video>
                                        </div>
                                        <input type="hidden" id="detail_video">
                                        <span id="detail_video_path" class="path-span d-none"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 4: Tool Kit -->
                            <div class="tab-pane fade" id="tab-toolkit" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-tools me-2"></i> Manage the tool logos displayed in the "Trusted by
                                    industry Tools Kits" section.
                                </div>
                                <div class="tool-manager-container">
                                    <div class="upload-placeholder mb-4" id="tool-dropzone"
                                        onclick="document.getElementById('tool-bulk-upload').click()">
                                        <i class="bi bi-cloud-arrow-up display-6 text-primary mb-2"></i>
                                        <h6 class="mb-1">Click or drag to Bulk Upload Tools</h6>
                                        <p class="small text-secondary mb-0">Select multiple images at once to add them
                                            to your kit</p>
                                        <input type="file" id="tool-bulk-upload" multiple class="d-none"
                                            onchange="handleBulkUpload(this)" accept="image/*">
                                    </div>

                                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="tool-kit-grid">
                                        <!-- Tool cards will appear here -->
                                    </div>
                                </div>
                                <!-- Hidden inputs for compatibility -->
                                <textarea id="tools_json" style="display:none"></textarea>
                            </div>

                            <!-- Tab 5: Asset Library -->
                            <div class="tab-pane fade" id="tab-asset" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-collection-play-fill me-2"></i> Manage your global Benefit Icons
                                    Library. Upload new 3D icons and assign labels to use them in any service.
                                </div>

                                <div class="row g-4 align-items-end mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">New Benefit Label</label>
                                        <input type="text" class="form-control" id="new-benefit-label"
                                            placeholder="e.g. AI Powered">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Select Icon</label>
                                        <input type="file" class="form-control" id="new-benefit-file" accept="image/*">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary w-100"
                                            onclick="uploadNewBenefit()"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>

                                <h6 class="mb-3 fw-bold">Existing Benefit Icons</h6>
                                <div class="row row-cols-3 row-cols-md-4 row-cols-lg-6 g-3" id="benefit-library-grid">
                                    <!-- Loaded via JS -->
                                </div>
                            </div>

                            <!-- Tab 6: Dynamic Data -->
                            <div class="tab-pane fade" id="tab-data" role="tabpanel">
                                <div class="section-desc">
                                    <i class="bi bi-lightning-charge-fill me-2"></i> Manage advanced interactive
                                    components like Ecosystem Features and Why Choose Benefits.
                                </div>

                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-bold"><i class="bi bi-list-stars me-2"></i>Homepage Expertise List</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="addHomeExpertItem()"><i class="bi bi-plus-lg me-1"></i>Add
                                            Item</button>
                                    </div>
                                    <p class="small text-secondary mb-3">These appear as bullet points on the homepage "Our Expertise" cards.</p>
                                    <div id="home-expert-manager-container"></div>
                                    <!-- Hidden inputs for compatibility -->
                                    <textarea id="home_list_expert" style="display:none"></textarea>
                                </div>

                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-bold"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Ecosystem
                                            Features</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="addEcosystemItem()"><i class="bi bi-plus-lg me-1"></i>Add
                                            Feature</button>
                                    </div>
                                    <p class="small text-secondary mb-3">These appear in the accordion section on your
                                        service page.</p>
                                    <div id="ecosystem-manager-container"></div>
                                    <!-- Hidden inputs for compatibility -->
                                    <textarea id="ecosystem_json" style="display:none"></textarea>
                                </div>

                                <div class="mb-0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-bold"><i class="bi bi-patch-check-fill me-2"></i>"Why Choose"
                                            Benefits</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="addWhyChooseItem()"><i class="bi bi-plus-lg me-1"></i>Add
                                            Benefit</button>
                                    </div>
                                    <p class="small text-secondary mb-3">These appear as 3D icon cards to highlight key
                                        value propositions.</p>
                                    <div id="why-choose-manager-container"></div>
                                    <!-- Hidden inputs for compatibility -->
                                    <textarea id="why_choose_json" style="display:none"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-premium-close mb-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-premium-save mb-0" onclick="saveService()"><i
                            class="bi bi-save me-2"></i>Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
        inject_premium_delete_modal(); 
        inject_premium_alert_modal();
    ?>

    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        const API_URL = '../api/services.php';
        let servicesModal;
        let allServices = [];
        let filteredServices = [];
        let currentPage = 1;
        const itemsPerPage = 6;

        document.addEventListener('DOMContentLoaded', () => {
            servicesModal = new bootstrap.Modal(document.getElementById('serviceModal'));
            loadServices();

            // Initial status filter in table
            renderPremiumSelect('filter-status-container', [
                { label: 'All Status', value: 'all', icon: 'bi-grid-fill' },
                { label: 'Active', value: 'active', icon: 'bi-check-circle-fill' },
                { label: 'Draft', value: 'draft', icon: 'bi-pencil-fill' }
            ], 'all', (val) => {
                window.currentStatusFilter = val;
                filterServices();
            });
        });

        async function loadServices() {
            try {
                const res = await fetch(API_URL);
                const json = await res.json();
                if (json.success) {
                    allServices = json.data;
                    filteredServices = [...allServices];
                    renderServices();
                    document.getElementById('service_count').innerText = allServices.length.toString().padStart(2, '0');
                } else if (json.message === 'Unauthorized access') {
                    window.location.href = 'signin.php';
                }
            } catch (err) {
                console.error('Failed to load services', err);
            }
        }

        function filterServices() {
            const query = document.getElementById('serviceSearch').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;

            filteredServices = allServices.filter(s => {
                const matchesSearch = s.name.toLowerCase().includes(query) || s.slug.toLowerCase().includes(query);
                const matchesStatus = status === 'all' || s.status === status;
                return matchesSearch && matchesStatus;
            });

            currentPage = 1;
            renderServices();
        }

        function renderServices() {
            // 1. Render Grid
            const grid = document.getElementById('services-grid');
            grid.innerHTML = filteredServices.map(s => `
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 ${s.status === 'draft' ? 'service-draft' : ''}">
                <div class="card-header border-bottom p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-lg shadow-sm bg-body rounded-circle d-flex align-items-center justify-content-center">
                            <img src="../${s.icon_3d}" style="width:30px" onerror="this.src='../assets/images/logo.svg'">
                        </div>
                        <h3 class="mb-0 ms-3 h5">${s.name}</h3>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="small text-secondary mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${s.description_short}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge ${s.status === 'active' ? 'bg-success' : 'bg-warning'} bg-opacity-10 text-${s.status === 'active' ? 'success' : 'warning'} small font-monospace">${s.status === 'draft' ? 'DRAFT' : s.status.toUpperCase()}</span>
                        <div class="d-flex gap-2">
                            <a class="btn btn-sm btn-light btn-round mb-0" href="dashboard-pricing.php?service_id=${s.id}" title="Manage Pricing"><i class="bi bi-tag-fill text-orange"></i></a>
                            <button class="btn btn-sm btn-light btn-round mb-0" onclick="editService(${s.id})"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-light btn-round mb-0 text-danger" onclick="deleteService(${s.id})"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');

            // 2. Render Table with Pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedItems = filteredServices.slice(startIndex, endIndex);

            const tableBody = document.getElementById('services-table-body');
            tableBody.innerHTML = paginatedItems.map(s => `
        <tr class="${s.status === 'draft' ? 'table-row-draft' : ''}">
            <td>
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width:36px; height:36px;">
                        <img src="../${s.icon_3d}" style="width:20px" onerror="this.src='../assets/images/logo.svg'">
                    </div>
                    <div>
                        <div class="mb-0 fw-bold text-dark">${s.name}</div>
                    </div>
                </div>
            </td>
            <td><code class="small text-primary">${s.slug}</code></td>
            <td><span class="badge text-primary bg-primary bg-opacity-10 small" style="border-radius: 6px; padding: 6px 12px;">${s.overview_badge}</span></td>
            <td><span class="badge ${s.status === 'active' ? 'bg-success text-success' : 'bg-warning text-warning'} bg-opacity-10" style="border-radius: 6px; padding: 5px 10px; font-size: 0.65rem; letter-spacing: 0.5px; font-weight: 700;">${s.status === 'draft' ? 'DRAFT' : 'ACTIVE'}</span></td>
            <td>
                <div class="d-flex gap-2">
                    <a class="btn btn-light btn-round mb-0" href="dashboard-pricing.php?service_id=${s.id}" title="Manage Pricing"><i class="bi bi-tag-fill text-orange"></i></a>
                    <button class="btn btn-light btn-round mb-0" onclick="editService(${s.id})" title="Edit"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-light btn-round mb-0 text-danger" onclick="deleteService(${s.id})" title="Delete"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('');

            renderPagination();
        }

        function renderPagination() {
            const totalItems = filteredServices.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const info = document.getElementById('pagination-info');
            const list = document.getElementById('pagination-list');

            const start = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, totalItems);
            info.innerText = `Showing ${start} to ${end} of ${totalItems} entries`;

            let html = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage - 1})">Prev</a>
        </li>
    `;

            for (let i = 1; i <= totalPages; i++) {
                html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToPage(${i})">${i}</a>
            </li>
        `;
            }

            html += `
        <li class="page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage + 1})">Next</a>
        </li>
    `;

            list.innerHTML = html;
        }

        function goToPage(page) {
            if (page < 1 || page > Math.ceil(filteredServices.length / itemsPerPage)) return;
            currentPage = page;
            renderServices();
        }

        function resetForm() {
            document.getElementById('serviceForm').reset();
            document.getElementById('service-id').value = '';

            // Clear visual managers
            toolKitItems = [];
            ecosystemItems = [];
            whyChooseItems = [];
            homeExpertItems = [];

            renderToolKit();
            renderEcosystem();
            renderWhyChoose();
            renderHomeExpert();

            // Clear Media Previews
            ['icon_3d', 'hero_video', 'detail_video'].forEach(id => updateMediaPreview(id, ''));

            // Reset Premium Status Select
            document.getElementById('status').value = 'active';
            renderPremiumSelect('status-select-container', [
                { label: 'Active (Visible)', value: 'active', icon: 'bi-eye-fill' },
                { label: 'Draft (Hidden)', value: 'draft', icon: 'bi-eye-slash-fill' }
            ], 'active', (val) => { document.getElementById('status').value = val; });

            document.getElementById('serviceModalLabel').innerText = 'Add New Service';

            // Reset tabs: Set first tab active
            document.querySelectorAll('.premium-nav-tabs .nav-link').forEach(btn => btn.classList.remove('active'));
            document.getElementById('general-tab').classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
            document.getElementById('tab-general').classList.add('show', 'active');
        }

        async function saveService() {
            const id = document.getElementById('service-id').value;

            const data = {
                name: document.getElementById('name').value,
                slug: document.getElementById('slug').value,
                description_short: document.getElementById('description_short').value,
                hero_title: document.getElementById('hero_title').value,
                hero_video: document.getElementById('hero_video').value,
                overview_badge: document.getElementById('overview_badge').value,
                overview_title: document.getElementById('overview_title').value,
                overview_lead: document.getElementById('overview_lead').value,
                overview_text: document.getElementById('overview_text').value,
                detail_video: document.getElementById('detail_video').value,
                icon_3d: document.getElementById('icon_3d').value,
                ecosystem_json: JSON.stringify(ecosystemItems),
                why_choose_json: JSON.stringify(whyChooseItems),
                home_list_expert: JSON.stringify(homeExpertItems),
                tools_json: JSON.stringify(toolKitItems),
                status: document.getElementById('status').value || 'active'
            };

            try {
                const url = id ? `${API_URL}?id=${id}` : API_URL;
                const res = await fetch(url, {
                    method: id ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const json = await res.json();
                if (json.success) {
                    servicesModal.hide();
                    loadServices();
                    showToast(id ? 'Service updated successfully!' : 'Service created successfully!', 'success');
                } else {
                    showToast(json.message, 'danger');
                }
            } catch (err) {
                showToast('Error saving service: ' + err.message, 'danger');
            }
        }

        let toolKitItems = [];

        async function handleBulkUpload(input) {
            if (!input.files || input.files.length === 0) return;

            const formData = new FormData();
            for (let i = 0; i < input.files.length; i++) {
                formData.append('tools[]', input.files[i]);
            }

            try {
                const res = await fetch('../api/upload-tools.php', {
                    method: 'POST',
                    body: formData
                });
                const json = await res.json();

                if (json.success) {
                    json.paths.forEach(path => {
                        toolKitItems.push({
                            logo_light: path,
                            logo_dark: path
                        });
                    });
                    renderToolKit();
                    showToast(`${json.paths.length} tools added!`, 'success');
                } else {
                    showToast(json.message, 'danger');
                }
            } catch (err) {
                showToast('Upload failed', 'danger');
            }
            input.value = ''; // Reset input
        }

        function renderToolKit() {
            const grid = document.getElementById('tool-kit-grid');
            grid.innerHTML = toolKitItems.map((tool, index) => `
        <div class="col">
            <div class="tool-card">
                <button class="btn btn-delete" onclick="removeTool(${index})"><i class="bi bi-x"></i></button>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="tool-logo-box" onclick="swapLogo(${index}, 'light')" title="Light Logo">
                            <img src="../${tool.logo_light}" onerror="this.src='assets/images/placeholder.png'">
                        </div>
                        <div class="mt-1 text-center small text-secondary">Light</div>
                    </div>
                    <div class="col-6">
                        <div class="tool-logo-box" onclick="swapLogo(${index}, 'dark')" title="Dark Logo">
                            <img src="../${tool.logo_dark}" onerror="this.src='assets/images/placeholder.png'">
                        </div>
                        <div class="mt-1 text-center small text-secondary">Dark</div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');

            // Hidden file inputs for swapping
            if (!document.getElementById('swap-upload')) {
                const input = document.createElement('input');
                input.type = 'file';
                input.id = 'swap-upload';
                input.style.display = 'none';
                document.body.appendChild(input);
            }
        }

        function removeTool(index) {
            toolKitItems.splice(index, 1);
            renderToolKit();
        }

        let swapContext = null;

        function swapLogo(index, type) {
            swapContext = { index, type };
            document.getElementById('swap-upload').click();
        }

        document.addEventListener('change', async (e) => {
            if (e.target.id === 'swap-upload' && swapContext) {
                const input = e.target;
                if (!input.files[0]) return;

                const formData = new FormData();
                formData.append('tools[]', input.files[0]);

                try {
                    const res = await fetch('../api/upload-tools.php', {
                        method: 'POST',
                        body: formData
                    });
                    const json = await res.json();
                    if (json.success) {
                        const path = json.paths[0];
                        if (swapContext.type === 'light') {
                            toolKitItems[swapContext.index].logo_light = path;
                        } else {
                            toolKitItems[swapContext.index].logo_dark = path;
                        }
                        renderToolKit();
                    }
                } catch (err) {
                    showToast('Swap failed', 'danger');
                }
                swapContext = null;
                input.value = '';
            }
        });

        /**
         * Standard select handling
         */

        // Update standard select handling
        async function editService(id) {
            const service = allServices.find(s => s.id == id);
            if (service) {
                document.getElementById('serviceModalLabel').innerText = 'Edit Service: ' + service.name;
                document.getElementById('service-id').value = service.id;
                document.getElementById('name').value = service.name;
                document.getElementById('slug').value = service.slug;
                document.getElementById('description_short').value = service.description_short;
                document.getElementById('hero_title').value = service.hero_title;
                document.getElementById('hero_video').value = service.hero_video;
                document.getElementById('overview_badge').value = service.overview_badge;
                document.getElementById('overview_title').value = service.overview_title;
                document.getElementById('overview_lead').value = service.overview_lead;
                document.getElementById('overview_text').value = service.overview_text;
                document.getElementById('detail_video').value = service.detail_video;
                document.getElementById('icon_3d').value = service.icon_3d;

                // Update Media Previews
                updateMediaPreview('icon_3d', service.icon_3d);
                updateMediaPreview('hero_video', service.hero_video);
                updateMediaPreview('detail_video', service.detail_video);

                // Populate Visual Managers (Safe Parsing)
                ecosystemItems = typeof service.ecosystem_json === 'string' ? JSON.parse(service.ecosystem_json || '[]') : (service.ecosystem_json || []);
                whyChooseItems = typeof service.why_choose_json === 'string' ? JSON.parse(service.why_choose_json || '[]') : (service.why_choose_json || []);
                homeExpertItems = typeof service.home_list_expert === 'string' ? JSON.parse(service.home_list_expert || '[]') : (service.home_list_expert || []);
                toolKitItems = typeof service.tools_json === 'string' ? JSON.parse(service.tools_json || '[]') : (service.tools_json || []);

                renderEcosystem();
                renderWhyChoose();
                renderHomeExpert();
                renderToolKit();

                // Premium Status Select
                document.getElementById('status').value = service.status;
                renderPremiumSelect('status-select-container', [
                    { label: 'Active (Visible)', value: 'active', icon: 'bi-eye-fill' },
                    { label: 'Draft (Hidden)', value: 'draft', icon: 'bi-eye-slash-fill' }
                ], service.status, (val) => { document.getElementById('status').value = val; });

                // Reset tabs: Set first tab active
                document.querySelectorAll('.premium-nav-tabs .nav-link').forEach(btn => btn.classList.remove('active'));
                document.getElementById('general-tab').classList.add('active');
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                document.getElementById('tab-general').classList.add('show', 'active');

                servicesModal.show();
            }
        }

        // Initial status filter in table
        renderPremiumSelect('filter-status-container', [
            { label: 'All Status', value: 'all', icon: 'bi-grid-fill' },
            { label: 'Active', value: 'active', icon: 'bi-check-circle-fill' },
            { label: 'Draft', value: 'draft', icon: 'bi-pencil-fill' }
        ], 'all', (val) => {
            // Hidden standard filter logic
            const mockSelect = { value: val };
            window.currentStatusFilter = val;
            filterServices();
        });

        function filterServices() {
            const query = document.getElementById('serviceSearch').value.toLowerCase();
            const status = window.currentStatusFilter || 'all';

            filteredServices = allServices.filter(s => {
                const matchesSearch = s.name.toLowerCase().includes(query) || s.slug.toLowerCase().includes(query);
                const matchesStatus = status === 'all' || s.status === status;
                return matchesSearch && matchesStatus;
            });

            currentPage = 1;
            renderServices();
        }


        let whyChooseIconsList = []; // Now dynamic

        async function fetchBenefitIcons() {
            try {
                const res = await fetch('../api/media-manager.php?type=benefit_icons');
                const json = await res.json();
                if (json.success) {
                    whyChooseIconsList = json.data.map(item => ({
                        label: item.label,
                        path: item.icon_path,
                        id: item.id
                    }));
                    renderBenefitLibrary();
                    renderWhyChoose(); // Update existing why choose builders
                }
            } catch (err) { console.error('Failed to fetch icons', err); }
        }

        function renderBenefitLibrary() {
            const grid = document.getElementById('benefit-library-grid');
            grid.innerHTML = whyChooseIconsList.map(icon => `
        <div class="col">
            <div class="asset-library-card position-relative">
                <button type="button" class="btn-delete-asset" onclick="deleteBenefitIcon(${icon.id})">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
                <img src="../${icon.path}" onerror="this.src='../assets/images/logo.svg'">
                <div class="label">${icon.label}</div>
            </div>
        </div>
    `).join('');
        }

        async function deleteBenefitIcon(id) {
            showPremiumDeleteModal(
                'Remove Icon?',
                'Are you sure you want to remove this icon from the library? This might affect services using it.',
                async () => {
                    try {
                        const res = await fetch(`../api/media-manager.php?id=${id}`, { method: 'DELETE' });
                        const json = await res.json();
                        if (json.success) {
                            showToast('Icon removed successfully', 'success');
                            fetchBenefitIcons();
                        } else {
                            showToast(json.message, 'danger');
                        }
                    } catch (err) { console.error('Delete failed', err); }
                },
                'dark'
            );
        }



        async function uploadNewBenefit() {
            const label = document.getElementById('new-benefit-label').value;
            const fileInput = document.getElementById('new-benefit-file');

            if (!label || !fileInput.files[0]) {
                showToast('Please provide both label and icon', 'warning');
                return;
            }

            // 50MB Limit Check
            if (fileInput.files[0].size > 50 * 1024 * 1024) {
                showToast('File is too large! Maximum limit is 50MB.', 'danger');
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('media_type', 'icons');
            formData.append('save_as_benefit', 'true');
            formData.append('label', label);
            formData.append('prefix', 'benefit');

            try {
                const res = await fetch('../api/media-manager.php', { method: 'POST', body: formData });
                const json = await res.json();
                if (json.success) {
                    showToast('New benefit icon added!', 'success');
                    document.getElementById('new-benefit-label').value = '';
                    fileInput.value = '';
                    fetchBenefitIcons();
                } else {
                    showToast(json.message, 'danger');
                }
            } catch (err) { showToast('Upload failed: ' + err.message, 'danger'); }
        }

        async function handleSingleUpload(input, type, targetId) {
            if (!input.files[0]) return;

            // 50MB Limit Check
            if (input.files[0].size > 50 * 1024 * 1024) {
                showToast('File is too large! Maximum limit is 50MB.', 'danger');
                input.value = '';
                return;
            }

            // Show loading state
            const box = input.closest('.media-uploader-box');
            const originalHtml = box.innerHTML;
            box.innerHTML = '<div class="spinner-border spinner-border-sm text-primary me-2"></div> Uploading...';
            box.style.pointerEvents = 'none';

            // Get service name for naming
            const serviceName = document.getElementById('name').value || 'service';
            const slug = serviceName.toLowerCase().replace(/[^a-z0-9]/g, '-');

            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('media_type', type); // icons, videos
            formData.append('prefix', slug + '-' + targetId);

            try {
                const res = await fetch('../api/media-manager.php', { method: 'POST', body: formData });
                const json = await res.json();
                if (json.success) {
                    document.getElementById(targetId).value = json.path;
                    updateMediaPreview(targetId, json.path);
                    showToast('Media uploaded & organized', 'success');
                } else {
                    showToast(json.message || 'Upload failed', 'danger');
                }
            } catch (err) {
                showToast('Upload failed: ' + err.message, 'danger');
            } finally {
                box.innerHTML = originalHtml;
                box.style.pointerEvents = 'auto';
            }
        }

        function updateMediaPreview(targetId, path) {
            const previewContainer = document.getElementById(targetId + '_preview');
            const pathSpan = document.getElementById(targetId + '_path');

            if (!path) {
                previewContainer.classList.add('d-none');
                pathSpan.classList.add('d-none');
                return;
            }

            previewContainer.classList.remove('d-none');
            pathSpan.classList.remove('d-none');
            pathSpan.innerText = path;

            if (targetId.includes('video')) {
                const video = previewContainer.querySelector('video');
                video.src = '../' + path;
                video.load();
            } else {
                const img = previewContainer.querySelector('img');
                img.src = '../' + path;
            }
        }

        // Initial fetch
        fetchBenefitIcons();

        let ecosystemItems = [];
        const ecosystemIcons = ['bi-lightbulb', 'bi-speedometer2', 'bi-shield-check', 'bi-link-45deg', 'bi-cpu'];

        let homeExpertItems = [];

        function addHomeExpertItem() {
            homeExpertItems.push('');
            renderHomeExpert();
        }

        function removeHomeExpertItem(index) {
            homeExpertItems.splice(index, 1);
            renderHomeExpert();
        }

        function updateHomeExpertItem(index, value) {
            homeExpertItems[index] = value;
        }

        function renderHomeExpert() {
            const container = document.getElementById('home-expert-manager-container');
            if (homeExpertItems.length === 0) {
                container.innerHTML = `
            <div class="text-center py-4 border rounded-3 bg-light opacity-50">
                <p class="mb-0 small text-secondary">No expertise items added yet.</p>
            </div>
        `;
                return;
            }

            container.innerHTML = homeExpertItems.map((item, index) => `
        <div class="manager-card">
            <button type="button" class="btn-remove" onclick="removeHomeExpertItem(${index})"><i class="bi bi-trash"></i></button>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Expertise Item ${index + 1}</label>
                    <input type="text" class="form-control form-control-sm" value="${item.replace(/"/g, '&quot;')}" 
                        oninput="updateHomeExpertItem(${index}, this.value)" placeholder="e.g. UX Research & User Journeys">
                </div>
            </div>
        </div>
    `).join('');
        }

        function addEcosystemItem() {
            ecosystemItems.push({ title: '', content: '' });
            renderEcosystem();
        }

        function removeEcosystemItem(index) {
            ecosystemItems.splice(index, 1);
            renderEcosystem();
        }

        function updateEcosystemItem(index, field, value) {
            ecosystemItems[index][field] = value;
        }

        function renderEcosystem() {
            const container = document.getElementById('ecosystem-manager-container');
            if (ecosystemItems.length === 0) {
                container.innerHTML = `
            <div class="text-center py-4 border rounded-3 bg-light opacity-50">
                <p class="mb-0 small text-secondary">No ecosystem features added yet.</p>
            </div>
        `;
                return;
            }

            container.innerHTML = ecosystemItems.map((item, index) => `
        <div class="manager-card">
            <button type="button" class="btn-remove" onclick="removeEcosystemItem(${index})"><i class="bi bi-trash"></i></button>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Feature Title</label>
                    <input type="text" class="form-control form-control-sm" value="${item.title || ''}" 
                        oninput="updateEcosystemItem(${index}, 'title', this.value)" placeholder="e.g. Multi-platform Support">
                </div>
                <div class="col-12">
                    <label class="form-label">Feature Description</label>
                    <textarea class="form-control form-control-sm" rows="2" 
                        oninput="updateEcosystemItem(${index}, 'content', this.value)" placeholder="Explain this feature...">${item.content || ''}</textarea>
                </div>
            </div>
        </div>
    `).join('');
        }

        let activeWhyChooseIndex = null;

        function addWhyChooseItem() {
            whyChooseItems.push({ title: '', text: '', icon: whyChooseIconsList[0]?.path || '' });
            renderWhyChoose();
        }

        function removeWhyChooseItem(index) {
            whyChooseItems.splice(index, 1);
            renderWhyChoose();
        }

        function updateWhyChooseItem(index, field, value) {
            whyChooseItems[index][field] = value;
        }

        function renderWhyChoose() {
            const container = document.getElementById('why-choose-manager-container');
            if (whyChooseItems.length === 0) {
                container.innerHTML = `
            <div class="text-center py-4 border rounded-3 bg-light opacity-50">
                <p class="mb-0 small text-secondary">No benefits added yet.</p>
            </div>
        `;
                return;
            }

            container.innerHTML = whyChooseItems.map((item, index) => {
                const selectId = `why-choose-icon-select-${index}`;
                setTimeout(() => {
                    renderPremiumSelect(selectId, whyChooseIconsList.map(icon => ({
                        label: icon.label,
                        value: icon.path,
                        img: icon.path
                    })), item.icon, (val) => {
                        updateWhyChooseItem(index, 'icon', val);
                        const previewImg = document.getElementById(`why-choose-preview-img-${index}`);
                        if (previewImg) previewImg.src = '../' + val;
                    });
                }, 0);

                return `
        <div class="manager-card">
            <button type="button" class="btn-remove" onclick="removeWhyChooseItem(${index})"><i class="bi bi-trash"></i></button>
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="preview-image-wrapper d-flex justify-content-center align-items-center p-3" style="height: 160px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px;">
                        <img id="why-choose-preview-img-${index}" src="../${item.icon}" style="width: 100px; height: 100px; object-fit: contain;" onerror="this.src='../assets/images/logo.svg'">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label">Benefit Title</label>
                        <input type="text" class="form-control" value="${item.title || ''}" 
                            oninput="updateWhyChooseItem(${index}, 'title', this.value)" placeholder="e.g. Scalable Architecture">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Select Icon</label>
                        <div id="${selectId}"></div>
                    </div>
                </div>
                <div class="col-12 mt-0">
                    <label class="form-label">Benefit Description</label>
                    <textarea class="form-control" rows="3" 
                        oninput="updateWhyChooseItem(${index}, 'text', this.value)" placeholder="Why should users care?">${item.text || ''}</textarea>
                </div>
            </div>
        </div>
        `;
            }).join('');
        }

        function deleteService(id) {
            showPremiumDeleteModal(
                'Delete Service?',
                'Are you sure you want to remove this service? This action is permanent.',
                async () => {
                    try {
                        const res = await fetch(`${API_URL}?id=${id}`, { method: 'DELETE' });
                        const json = await res.json();
                        if (json.success) {
                            loadServices();
                            showToast('Service deleted successfully.', 'success');
                        } else if (json.message === 'Unauthorized access') {
                            window.location.href = 'signin.php';
                        } else {
                            showToast(json.message, 'danger');
                        }
                    } catch (err) {
                        showToast('Error deleting service', 'danger');
                        console.error(err);
                    }
                },
                'dark'
            );
        }
    </script>
    <?php inject_toast_system(); ?>
</body>
</html>
