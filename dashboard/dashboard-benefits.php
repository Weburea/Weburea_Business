<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - Benefits Page Management</title>
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
    <?php include 'include/header.php'; ?>

    <main>
        <section class="py-4">
            <div class="container">
                <div class="row pb-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h2 mb-2">Benefits Page Configuration</h1>
                        <p class="text-secondary">Manage career benefits, platform features, and testimonials</p>
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
                    <ul class="nav nav-tabs premium-nav-tabs justify-content-center mb-4 px-3" id="benTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab"><i class="bi bi-megaphone me-2"></i>Hero Banner</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#tab-stats" type="button" role="tab"><i class="bi bi-graph-up-arrow me-2"></i>Statistics</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="solutions-tab" data-bs-toggle="tab" data-bs-target="#tab-solutions" type="button" role="tab"><i class="bi bi-diagram-3 me-2"></i>Solutions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="platform-tab" data-bs-toggle="tab" data-bs-target="#tab-platform" type="button" role="tab"><i class="bi bi-layers me-2"></i>Platform Features</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="benTabsContent">
                    <!-- Tab: Hero -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-megaphone"></i></div>
                                <div>
                                    <h4 class="mb-0">Benefits Hero Section</h4>
                                    <small class="text-secondary">Control headings and the 5 floating avatars</small>
                                </div>
                            </div>
                            <form id="ben-hero-form">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Title Prefix</label>
                                        <input type="text" name="title_prefix" class="form-control" placeholder="Grow Your Career & Enjoy the">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Highlighted Word</label>
                                        <input type="text" name="title_highlight" class="form-control" placeholder="Benefits">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Highlight Type</label>
                                        <div id="hero-title-color-select"></div>
                                        <input type="hidden" name="title_highlight_type">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Hero Description</label>
                                        <textarea name="description" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="mb-3">Floating Avatars (5 Slots)</h6>
                                        <div class="ben-avatar-grid h-scroll" id="ben-hero-avatars" style="display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 1rem;">
                                            <!-- Dynamic items -->
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Hero Section</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Stats -->
                    <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-graph-up-arrow"></i></div>
                                <div>
                                    <h4 class="mb-0">Key Metrics Bar</h4>
                                    <small class="text-secondary">Manage the 3 impact statistics shown below the hero</small>
                                </div>
                            </div>
                            <form id="ben-stats-form">
                                <div id="ben-stats-container" class="row g-3">
                                    <!-- Dynamic rows -->
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Statistics</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Solutions -->
                    <div class="tab-pane fade" id="tab-solutions" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-diagram-3"></i></div>
                                <div>
                                    <h4 class="mb-0">"One Body" Solutions</h4>
                                    <small class="text-secondary">Manage the Stop juggling freelancers section and feature cards</small>
                                </div>
                            </div>
                            <form id="ben-solutions-form">
                                <div class="row g-4">
                                    <div class="col-md-6 border-end">
                                        <h6 class="mb-3">Content & Links</h6>
                                        <div class="mb-3">
                                            <label class="form-label small">Title Prefix</label>
                                            <input type="text" name="sol_title_prefix" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small">Highlighted Word</label>
                                            <input type="text" name="sol_title_highlight" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small">Highlight Type</label>
                                            <div id="sol-title-color-select"></div>
                                            <input type="hidden" name="sol_title_highlight_type">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small">Description</label>
                                            <textarea name="description" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <label class="form-label small">Button Text</label>
                                                <input type="text" name="btn_text" class="form-control">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small">WhatsApp Hub Link</label>
                                                <input type="text" name="whatsapp_link" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Media Assets</h6>
                                        <div class="row g-3">
                                            <div class="col-6 text-center">
                                                <label class="form-label small d-block">Main Product Image</label>
                                                <div class="avatar-clickable" style="width: 100%; height: 120px;" id="ben-media-main-trigger">
                                                    <img id="ben-media-main-preview" src="" style="max-height: 100%; width: auto;">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <label class="form-label small d-block">Background Decoration</label>
                                                <div class="avatar-clickable" style="width: 100%; height: 120px;" id="ben-media-decor-trigger">
                                                    <img id="ben-media-decor-preview" src="" style="max-height: 100%; width: auto;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <hr>
                                        <h6 class="mb-3">Feature Cards (2 Items)</h6>
                                        <div id="ben-features-container" class="row g-3">
                                            <!-- Dynamic features -->
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Solutions</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Platform Features -->
                    <div class="tab-pane fade" id="tab-platform" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-layers"></i></div>
                                <div>
                                    <h4 class="mb-0">Platform Features (Tabs)</h4>
                                    <small class="text-secondary">Manage the interactive pills and content cards for the platform overview</small>
                                </div>
                            </div>
                            <form id="ben-tabs-form">
                                <div class="row g-4">
                                    <div class="col-md-8 border-end">
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label font-base fw-bold">Section Title</label>
                                                <input type="text" name="title" class="form-control" placeholder="Discover the power of our platform">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label font-base fw-bold">Section Description</label>
                                                <textarea name="description" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-premium align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Icon</th>
                                                        <th style="width: 180px;">Badges</th>
                                                        <th style="width: 150px;">Status</th>
                                                        <th class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ben-tabs-list">
                                                    <!-- Dynamic tabs list -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPlatformTab()"><i class="bi bi-plus-lg me-2"></i>Add New Tab</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="tab-editor-placeholder" class="text-center py-5">
                                            <i class="bi bi-pencil-square display-5 opacity-25"></i>
                                            <p class="mt-3 text-secondary">Click "Edit Card" to configure specific tab contents</p>
                                        </div>
                                        <div id="tab-card-editor" class="d-none">
                                            <h6 class="mb-3" id="editing-tab-name">Edit Tab Card</h6>
                                            <div class="avatar-clickable mb-3" style="width: 100%; height: 120px;" id="tab-card-image-trigger">
                                                <img id="tab-card-image-preview" src="" style="max-height: 100%; width: auto;">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Card Title</label>
                                                <input type="text" id="edit-card-title" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Card Description</label>
                                                <textarea id="edit-card-desc" class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small">Metric Value</label>
                                                    <input type="text" id="edit-card-metric-val" class="form-control">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small">Metric Label</label>
                                                    <input type="text" id="edit-card-metric-label" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">List Items (one per line)</label>
                                                <textarea id="edit-card-list" class="form-control" rows="3"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm w-100" onclick="saveTabCardChanges()">Apply Card Changes</button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Platform Section</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Media Selector Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="p-4 media-uploader-box rounded">
                        <input type="file" id="media-upload-input" class="d-none" onchange="handleFileUpload(this)">
                        <label for="media-upload-input" style="cursor: pointer;">
                            <i class="bi bi-cloud-arrow-up display-4 text-secondary"></i>
                            <p class="mt-2">Click to upload or drag and drop</p>
                            <small class="text-secondary">Images (PNG, JPG, SVG) supported</small>
                        </label>
                        <div id="upload-progress" class="mt-3 d-none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Icon Modal -->
    <div class="modal fade" id="svgModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tab Icon (SVG Code)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
                        Paste the raw <code>&lt;path&gt;</code> or SVG children code here. The system handles the wrapper.
                    </div>
                    <textarea id="svg-code-input" class="form-control" rows="10" placeholder='<path d="..." />'></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100" onclick="saveSvgCode()">Save SVG Icon</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>
    <script src="assets/js/functions.js"></script>

    <script>
        let sections = {};
        let mediaTarget = null;
        let editingTabIndex = null;
        const mediaModal = new bootstrap.Modal(document.getElementById('mediaModal'));
        const svgModal = new bootstrap.Modal(document.getElementById('svgModal'));

        async function initDashboard() {
            try {
                const res = await fetch('../api/benefits_config.php');
                const result = await res.json();
                if (result.success) {
                    result.data.forEach(s => sections[s.section_key] = s.section_content);
                    renderHero();
                    renderStats();
                    renderSolutions();
                    renderPlatform();
                    updateStorageReport();
                }
            } catch (e) { console.error(e); }
        }

        async function updateStorageReport() {
            try {
                const res = await fetch('../api/media-manager.php?action=report', {
                    headers: { 'X-API-Key': 'weburea_secret_2026' }
                });
                const report = await res.json();
                if (report.success) {
                    document.getElementById('storage-count').textContent = `${report.count} files`;
                    document.getElementById('storage-used').textContent = report.usage_formatted;
                    const percent = Math.min((report.size / report.quota_bytes) * 100, 100);
                    document.getElementById('storage-bar').style.width = percent + '%';
                }
            } catch (e) { console.error('Storage report failed', e); }
        }

        // --- Renderers ---

        function renderHero() {
            const data = sections.ben_hero;
            const form = document.getElementById('ben-hero-form');
            
            const titleHtml = data.title || "";
            const match = titleHtml.match(/^(.*?)<span class="(.*?)">(.*?)<\/span>(.*)$/);
            if (match) {
                form.title_prefix.value = match[1].trim();
                form.title_highlight_type.value = match[2];
                form.title_highlight.value = match[3];
            } else {
                form.title_prefix.value = titleHtml;
                form.title_highlight.value = "";
            }
            
            form.description.value = data.description;

            renderColorSelect('hero-title-color-select', form.title_highlight_type.value || 'text-primary', (val) => {
                form.title_highlight_type.value = val;
            });

            const avatarsDiv = document.getElementById('ben-hero-avatars');
            avatarsDiv.innerHTML = data.avatars.map((path, idx) => `
                <div class="ben-avatar-item">
                    <div class="avatar-clickable avatar-responsive border rounded-circle mb-2 mx-auto" style="width: 100px; height: 100px;" onclick="openMediaSelector('ben_hero_avatar', ${idx})">
                        <img src="../${path}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="text-center small fw-bold text-secondary" style="font-size: 0.75rem;">Slot #${idx + 1}</div>
                </div>
            `).join('');
        }

        function renderStats() {
            const data = sections.ben_stats;
            const container = document.getElementById('ben-stats-container');
            container.innerHTML = data.stats.map((s, idx) => `
                <div class="col-md-4">
                    <div class="card p-3 bg-body border h-100">
                        <h6 class="mb-3 small text-uppercase">Statistic ${idx + 1}</h6>
                        <div class="mb-2">
                            <label class="form-label small opacity-50">Value (e.g. 360)</label>
                            <input type="text" class="form-control form-control-sm" value="${s.value}" onchange="sections.ben_stats.stats[${idx}].value = this.value">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small opacity-50">Suffix (e.g. °)</label>
                            <input type="text" class="form-control form-control-sm" value="${s.suffix}" onchange="sections.ben_stats.stats[${idx}].suffix = this.value">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small opacity-50">Label Text</label>
                            <input type="text" class="form-control form-control-sm" value="${s.label}" onchange="sections.ben_stats.stats[${idx}].label = this.value">
                        </div>
                        <hr class="my-2 opacity-10">
                        <div class="form-check form-switch card-footer bg-transparent border-0 p-0 ps-5 mt-2">
                            <input class="form-check-input" type="checkbox" id="statStars${idx}" ${s.show_stars ? 'checked' : ''} onchange="sections.ben_stats.stats[${idx}].show_stars = this.checked">
                            <label class="form-check-label small" for="statStars${idx}">Show Stars</label>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderSolutions() {
            const data = sections.ben_solutions;
            const form = document.getElementById('ben-solutions-form');
            
            const titleHtml = data.title || "";
            const match = titleHtml.match(/^(.*?)<span class="(.*?)">(.*?)<\/span>(.*)$/);
            if (match) {
                form.sol_title_prefix.value = match[1].trim();
                form.sol_title_highlight_type.value = match[2];
                form.sol_title_highlight.value = match[3];
            } else {
                form.sol_title_prefix.value = titleHtml;
                form.sol_title_highlight.value = "";
            }

            form.description.value = data.description;
            form.btn_text.value = data.btn_text;
            form.whatsapp_link.value = data.whatsapp_link;

            renderColorSelect('sol-title-color-select', form.sol_title_highlight_type.value || 'text-primary', (val) => {
                form.sol_title_highlight_type.value = val;
            });

            document.getElementById('ben-media-main-preview').src = '../' + data.media_main;
            document.getElementById('ben-media-decor-preview').src = '../' + data.media_decor;

            document.getElementById('ben-media-main-trigger').onclick = () => openMediaSelector('ben_solutions_main');
            document.getElementById('ben-media-decor-trigger').onclick = () => openMediaSelector('ben_solutions_decor');

            const featDiv = document.getElementById('ben-features-container');
            featDiv.innerHTML = data.features.map((f, idx) => `
                <div class="col-md-6">
                    <div class="card p-3 border h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-clickable border me-3" style="width: 50px; height: 50px;" onclick="openMediaSelector('ben_feature_icon', ${idx})">
                                <img src="../${f.icon}" style="padding: 10px;">
                            </div>
                            <input type="text" class="form-control form-control-sm fw-bold border-0 bg-transparent" value="${f.title}" placeholder="Feature Title" onchange="sections.ben_solutions.features[${idx}].title = this.value">
                        </div>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Card Content" onchange="sections.ben_solutions.features[${idx}].content = this.value">${f.content}</textarea>
                    </div>
                </div>
            `).join('');
        }

        function renderPlatform() {
            const data = sections.ben_tabs;
            const form = document.getElementById('ben-tabs-form');
            form.title.value = data.title;
            form.description.value = data.description;

            const list = document.getElementById('ben-tabs-list');
            list.innerHTML = data.tabs.map((t, idx) => `
                <tr>
                    <td>
                        <div class="d-flex align-items-center" style="min-width: 140px;">
                            <div class="avatar-clickable border me-2" style="width: 32px; height: 32px;" onclick="openMediaSelector('ben_tab_icon', ${idx})">
                                <img src="../${t.icon_image || 'assets/images/elements/saas-decoration/01.png'}" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;">
                            </div>
                            <input type="text" class="form-control form-control-sm w-auto d-inline fw-bold border-0 bg-transparent text-truncate" value="${t.label}" onchange="sections.ben_tabs.tabs[${idx}].label = this.value">
                        </div>
                    </td>
                    <td class="toggle-column">
                        <div class="form-check form-switch d-flex align-items-center gap-2 p-0">
                            <input class="form-check-input ms-0" type="checkbox" id="tabSoon${idx}" ${t.coming_soon ? 'checked' : ''} onchange="sections.ben_tabs.tabs[${idx}].coming_soon = this.checked; renderPlatform()">
                            <label class="form-check-label small-mobile-text mb-0" for="tabSoon${idx}">Soon</label>
                        </div>
                    </td>
                    <td class="toggle-column">
                        <div class="form-check form-switch d-flex align-items-center gap-2 p-0">
                            <input class="form-check-input ms-0" type="checkbox" id="tabDisabled${idx}" ${t.is_disabled ? 'checked' : ''} onchange="sections.ben_tabs.tabs[${idx}].is_disabled = this.checked; renderPlatform()">
                            <label class="form-check-label small-mobile-text mb-0" for="tabDisabled${idx}">${t.is_disabled ? 'Off' : 'On'}</label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-light-primary me-1" onclick="editTabCard(${idx})"><i class="bi bi-pencil me-1"></i> Card</button>
                        <button type="button" class="btn btn-sm btn-light-danger" onclick="removePlatformTab(${idx})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }


        // --- Logic Helpers ---

        function openSvgModal(idx) {
            editingTabIndex = idx;
            document.getElementById('svg-code-input').value = sections.ben_tabs.tabs[idx].icon_svg || '';
            svgModal.show();
        }

        function saveSvgCode() {
            sections.ben_tabs.tabs[editingTabIndex].icon_svg = document.getElementById('svg-code-input').value;
            svgModal.hide();
            showToast('SVG updated locally. Remember to save section.', 'info');
        }

        function editTabCard(idx) {
            editingTabIndex = idx;
            const card = sections.ben_tabs.tabs[idx].card;
            document.getElementById('editing-tab-name').textContent = `Edit Card: ${sections.ben_tabs.tabs[idx].label}`;
            document.getElementById('tab-card-image-preview').src = '../' + card.image;
            document.getElementById('edit-card-title').value = card.title;
            document.getElementById('edit-card-desc').value = card.description;
            document.getElementById('edit-card-metric-val').value = card.metric_value;
            document.getElementById('edit-card-metric-label').value = card.metric_label;
            document.getElementById('edit-card-list').value = (card.list || []).join('\n');
            
            document.getElementById('tab-editor-placeholder').classList.add('d-none');
            document.getElementById('tab-card-editor').classList.remove('d-none');
            document.getElementById('tab-card-image-trigger').onclick = () => openMediaSelector('ben_tab_card_image', idx);
        }

        function saveTabCardChanges() {
            const card = sections.ben_tabs.tabs[editingTabIndex].card;
            card.title = document.getElementById('edit-card-title').value;
            card.description = document.getElementById('edit-card-desc').value;
            card.metric_value = document.getElementById('edit-card-metric-val').value;
            card.metric_label = document.getElementById('edit-card-metric-label').value;
            card.list = document.getElementById('edit-card-list').value.split('\n').filter(l => l.trim() !== '');
            showToast('Card changes applied locally', 'info');
        }

        function addPlatformTab() {
            sections.ben_tabs.tabs.push({
                id: 'new-tab-' + Date.now(),
                label: 'New Tab',
                icon_svg: '',
                icon_image: '',
                coming_soon: false,
                is_disabled: false,
                is_active: false,
                card: { title: 'New Feature', description: 'Description', list: [], metric_value: '0', metric_label: 'Label', image: 'assets/images/elements/saas-decoration/tab-1.png' }
            });
            renderPlatform();
        }

        function removePlatformTab(idx) {
            showPremiumDeleteModal('Remove Tab?', 'This will permanently remove this platform feature tab.', () => {
                sections.ben_tabs.tabs.splice(idx, 1);
                renderPlatform();
                document.getElementById('tab-editor-placeholder').classList.remove('d-none');
                document.getElementById('tab-card-editor').classList.add('d-none');
            }, 'dark');
        }


        // --- Submits ---

        document.getElementById('ben-hero-form').onsubmit = async (e) => {
            e.preventDefault();
            const f = e.target;
            const fullTitle = f.title_prefix.value + 
                (f.title_highlight.value ? ` <span class="${f.title_highlight_type.value}">${f.title_highlight.value}</span>` : "");
            const content = { ...sections.ben_hero, title: fullTitle, description: f.description.value };
            await updateSection('ben_hero', content);
        };

        document.getElementById('ben-stats-form').onsubmit = async (e) => {
            e.preventDefault();
            await updateSection('ben_stats', sections.ben_stats);
        };

        document.getElementById('ben-solutions-form').onsubmit = async (e) => {
            e.preventDefault();
            const f = e.target;
            const fullTitle = f.sol_title_prefix.value + 
                (f.sol_title_highlight.value ? ` <span class="${f.sol_title_highlight_type.value}">${f.sol_title_highlight.value}</span>` : "");
            const content = { ...sections.ben_solutions, title: fullTitle, description: f.description.value, btn_text: f.btn_text.value, whatsapp_link: f.whatsapp_link.value };
            await updateSection('ben_solutions', content);
        };

        document.getElementById('ben-tabs-form').onsubmit = async (e) => {
            e.preventDefault();
            const f = e.target;
            const content = { ...sections.ben_tabs, title: f.title.value, description: f.description.value };
            await updateSection('ben_tabs', content);
        };


        async function updateSection(key, content) {
            try {
                const res = await fetch('../api/benefits_config.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-API-Key': 'weburea_secret_2026' },
                    body: JSON.stringify({ section_key: key, section_content: content })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('Section saved successfully', 'success');
                    initDashboard();
                } else { showToast(result.message, 'danger'); }
            } catch (e) { showToast('Network error', 'danger'); }
        }

        // --- Media ---

        function openMediaSelector(target, extra = null) {
            mediaTarget = { target, extra };
            mediaModal.show();
        }

        async function handleFileUpload(input) {
            if (!input.files[0]) return;
            const progress = document.getElementById('upload-progress');
            const bar = progress.querySelector('.progress-bar');
            progress.classList.remove('d-none');

            const fd = new FormData();
            fd.append('file', input.files[0]);
            fd.append('media_type', 'benefits');

            try {
                const res = await fetch('../api/media-manager.php', {
                    method: 'POST',
                    headers: { 'X-API-Key': 'weburea_secret_2026' },
                    body: fd
                });
                const result = await res.json();
                if (result.success) {
                    const path = result.path;
                    if (mediaTarget.target === 'ben_hero_avatar') {
                        sections.ben_hero.avatars[mediaTarget.extra] = path;
                        renderHero();
                    } else if (mediaTarget.target === 'ben_solutions_main') {
                        sections.ben_solutions.media_main = path;
                        renderSolutions();
                    } else if (mediaTarget.target === 'ben_solutions_decor') {
                        sections.ben_solutions.media_decor = path;
                        renderSolutions();
                    } else if (mediaTarget.target === 'ben_feature_icon') {
                        sections.ben_solutions.features[mediaTarget.extra].icon = path;
                        renderSolutions();
                    } else if (mediaTarget.target === 'ben_tab_icon') {
                        sections.ben_tabs.tabs[mediaTarget.extra].icon_image = path;
                        renderPlatform();
                    } else if (mediaTarget.target === 'ben_tab_card_image') {
                        sections.ben_tabs.tabs[mediaTarget.extra].card.image = path;
                        editTabCard(mediaTarget.extra);
                    }
                    
                    mediaModal.hide();
                    showToast('Media uploaded', 'success');
                    updateStorageReport();
                } else { showToast(result.message, 'danger'); }
            } catch (e) { showToast('Upload failed', 'danger'); }
            finally { progress.classList.add('d-none'); input.value = ''; }
        }

        function renderColorSelect(containerId, currentValue, onChange) {
            const options = [
                { label: 'Orange (Primary)', value: 'text-primary', icon: 'bi-circle-fill text-primary' },
                { label: 'Green (Success)', value: 'text-success', icon: 'bi-circle-fill text-success' },
                { label: 'Blue (Info)', value: 'text-info', icon: 'bi-circle-fill text-info' },
                { label: 'Yellow (Warning)', value: 'text-warning', icon: 'bi-circle-fill text-warning' },
                { label: 'Purple', value: 'text-purple', icon: 'bi-circle-fill text-purple' }
            ];
            renderPremiumSelect(containerId, options, currentValue, onChange);
        }

        initDashboard();
    </script>

    <?php inject_premium_delete_modal(); ?>
    <?php inject_toast_system(); ?>
</body>
</html>
