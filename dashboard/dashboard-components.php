<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - Site Components Layout</title>
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
    <!-- Header START -->
    <?php include 'include/header.php'; ?>
    <!-- Header END -->

    <main>
        <section class="py-4">
            <div class="container">
                <div class="row pb-4">
                    <div class="col-12">
                        <div class="d-sm-flex justify-content-sm-between align-items-center mt-4 text-start">
                            <div>
                                <h1 class="mb-2 mb-sm-0 h2">Site Components</h1>
                                <p class="mb-0 text-secondary">Manage and organize navigation zones across the entire
                                    platform.</p>
                            </div>
                            <button class="btn btn-premium mb-0" data-bs-toggle="modal" onclick="resetForm()"
                                data-bs-target="#componentModal"><i class="fas fa-plus me-2"></i>Add NEW Link</button>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs premium-nav-tabs mb-4 px-3" id="componentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="header-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-header" type="button" role="tab" onclick="loadZone('header_nav')"><i
                                class="bi bi-layout-sidebar-inset me-2"></i>Header Navbar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer1-tab" data-bs-toggle="tab" data-bs-target="#tab-footer1"
                            type="button" role="tab" onclick="loadZone('footer_col_1')"><i
                                class="bi bi-columns me-2"></i>Footer Col 1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer2-tab" data-bs-toggle="tab" data-bs-target="#tab-footer2"
                            type="button" role="tab" onclick="loadZone('footer_col_2')"><i
                                class="bi bi-columns me-2"></i>Footer Col 2</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer3-tab" data-bs-toggle="tab" data-bs-target="#tab-footer3"
                            type="button" role="tab" onclick="loadZone('footer_col_3')"><i
                                class="bi bi-columns me-2"></i>Footer Col 3</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#tab-social"
                            type="button" role="tab" onclick="loadZone('footer_social')"><i
                                class="bi bi-share me-2"></i>Socials</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#tab-media"
                            type="button" role="tab" onclick="loadZone('global_media')"><i
                                class="bi bi-images me-2"></i>Media Assets</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="home-cta-tab" data-bs-toggle="tab" data-bs-target="#tab-home-cta"
                            type="button" role="tab" onclick="loadHomeCTAs()"><i class="bi bi-megaphone me-2"></i>Home
                            CTAs</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-header" role="tabpanel">
                        <div id="header_nav_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-footer1" role="tabpanel">
                        <div id="footer_col_1_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-footer2" role="tabpanel">
                        <div id="footer_col_2_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-footer3" role="tabpanel">
                        <div id="footer_col_3_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-social" role="tabpanel">
                        <div id="footer_social_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-media" role="tabpanel">
                        <div id="global_media_container"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-home-cta" role="tabpanel">
                        <div id="home_cta_container"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Detailed Management Modal -->
    <div class="modal fade premium-alert-modal" id="componentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content overflow-hidden border-0 shadow-lg">
                <div class="premium-alert-header bg-dark-blue overflow-visible">
                    <div class="frosted-icon-circle modal-icon-animate-up">
                        <i class="bi bi-gear-fill text-white fs-1"></i>
                    </div>
                </div>

                <div class="modal-body p-5">
                    <div class="premium-alert-badge badge-dark-blue-soft mb-3">CONFGURATION ENGINE</div>
                    <h2 class="premium-alert-title h3 mb-4" id="modalTitle">Manage Component</h2>

                    <form id="componentForm">
                        <input type="hidden" id="component_id" value="">
                        <div class="row g-4 text-start">
                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Layout Zone</label>
                                <div id="zone-select-container"></div>
                                <input type="hidden" id="component_type" required>
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Link Label <span class="text-danger">*</span></label>
                                <input class="form-control border-0 bg-light py-2" type="text" id="label"
                                    placeholder="e.g. Portfolio" required>
                            </div>

                            <div class="col-md-12 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Target URL / Route</label>
                                <input class="form-control border-0 bg-light py-2 text-primary font-monospace"
                                    type="text" id="url" placeholder="e.g. work.php or https://...">
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Icon Class (Bootstrap Icons)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light text-primary"><i
                                            class="bi bi-info-circle"></i></span>
                                    <input class="form-control border-0 bg-light py-2" type="text" id="icon"
                                        placeholder="e.g. bi-facebook">
                                </div>
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Badge Text (Optional)</label>
                                <input class="form-control border-0 bg-light py-2" type="text" id="badge_text"
                                    placeholder="e.g. New!">
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Badge Aesthetic</label>
                                <div id="badge-select-container"></div>
                                <input type="hidden" id="badge_class">
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Priority / Sort Order</label>
                                <input class="form-control border-0 bg-light py-2" type="number" id="sort_order"
                                    value="10">
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Special Behavior</label>
                                <div id="special-select-container"></div>
                                <input type="hidden" id="special_type">
                            </div>

                            <div class="col-md-6 text-start">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">Global Visibility</label>
                                <div id="status-select-container"></div>
                                <input type="hidden" id="status" value="active">
                            </div>

                            <div class="col-12 text-start" id="image-section" style="display:none;">
                                <label class="form-label small fw-bold text-secondary text-uppercase"
                                    style="letter-spacing: 1px;">CTA Image / Component Media</label>
                                <div class="media-uploader-box p-4 border rounded-3 text-center mb-3"
                                    onclick="document.getElementById('image_file').click()">
                                    <input type="file" id="image_file" hidden onchange="uploadImage(this)">
                                    <div id="image-preview-container" class="mb-2 d-none">
                                        <img id="image-preview" src="" class="img-fluid rounded shadow-sm"
                                            style="max-height: 150px;">
                                    </div>
                                    <div id="upload-placeholder">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                        <p class="mb-0 small text-secondary">Click to upload image (Recom: 400x200px)
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" id="image_path" value="">
                                <small class="text-muted d-block mt-n2">Current Path: <span id="display-path"
                                        class="font-monospace">None</span></small>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4 opacity-10">

                    <button type="button" class="btn btn-premium-action bg-dark-blue shadow-lg w-100 py-3 mb-2"
                        onclick="saveComponent()">
                        <i class="bi bi-save2-fill me-2"></i>Verify & Push Changes
                    </button>
                    <button type="button" class="btn btn-premium-cancel w-100 small" data-bs-dismiss="modal">Discard & Return</button>
                </div>

                <div class="verified-secure-footer py-4 px-3 bg-dark-blue">
                    <div class="secure-branding">
                        <img src="../assets/images/logo-light.svg" alt="Weburea" class="secure-logo">
                        <span class="secure-status text-white opacity-75">Verified Secure Session</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Home CTA Modal -->
    <div class="modal fade" id="ctaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title fs-6 fw-bold"><i class="bi bi-megaphone me-2"></i>Configure Home CTA</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="ctaForm">
                        <input type="hidden" id="cta_id">
                        <input type="hidden" id="cta_type">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Title</label>
                                <input type="text" id="cta_title" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Subtitle / Description</label>
                                <textarea id="cta_subtitle" class="form-control bg-light border-0" rows="2"></textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Button Text</label>
                                <input type="text" id="cta_btn_text" class="form-control bg-light border-0">
                            </div>
                            <div class="col-6" id="cta_url_group">
                                <label class="form-label small fw-bold">Button URL</label>
                                <input type="text" id="cta_btn_url" class="form-control bg-light border-0">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Status</label>
                                <select id="cta_status" class="form-select bg-light border-0">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Image Attachment</label>
                                <div class="p-3 border rounded text-center cursor-pointer mb-2"
                                    onclick="document.getElementById('cta_file').click()">
                                    <input type="file" id="cta_file" hidden onchange="uploadCTAImage(this)">
                                    <img id="cta_preview" src="" class="img-fluid rounded d-none"
                                        style="max-height: 100px;">
                                    <div id="cta_upload_placeholder">
                                        <i class="bi bi-upload text-primary fs-4"></i>
                                        <p class="small mb-0">Upload New Image</p>
                                    </div>
                                </div>
                                <input type="hidden" id="cta_image_path">
                                <small class="text-muted font-monospace tiny" id="cta_path_display"></small>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary w-100 mt-4 py-2" onclick="saveCTA()">Update CTA
                        Configuration</button>
                </div>
            </div>
        </div>
    </div>

    <?php inject_premium_delete_modal(); ?>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js"></script>
    <script src="assets/js/functions.js"></script>

    <script>
        const API_URL = '../api/components.php';
        let componentModal, ctaModal;
        let currentZone = 'header_nav';
        let allZoneComponents = [];

        document.addEventListener('DOMContentLoaded', function () {
            componentModal = new bootstrap.Modal(document.getElementById('componentModal'));
            ctaModal = new bootstrap.Modal(document.getElementById('ctaModal'));
            loadZone(currentZone);
        });

        async function loadZone(zone) {
            currentZone = zone;
            const containerId = `${zone}_container`;
            const container = document.getElementById(containerId);

            // Show loading
            container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>`;

            try {
                const response = await fetch(`${API_URL}?component_type=${zone}`);
                const result = await response.json();

                if (result.success) {
                    allZoneComponents = result.data;
                    renderZoneTable(zone, result.data);
                } else {
                    container.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
                }
            } catch (error) {
                container.innerHTML = `<div class="alert alert-danger">Connection failed.</div>`;
            }
        }

        function renderZoneTable(zone, data) {
            const container = document.getElementById(`${zone}_container`);

            if (data.length === 0) {
                container.innerHTML = `<div class="text-center py-5 border rounded-4 bg-light bg-opacity-50"><p class="text-secondary mb-0">No components defined for this zone.</p></div>`;
                return;
            }

            let html = `
            <div class="card border shadow-sm">
                <div class="table-responsive">
                    <table class="table table-premium align-middle mb-0 table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 p-3">Label</th>
                                <th class="border-0 p-3">URL</th>
                                <th class="border-0 p-3 text-center">Status</th>
                                <th class="border-0 p-3 text-center">Priority</th>
                                <th class="border-0 p-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>`;

            data.forEach(item => {
                const statusBadge = item.status === 'active'
                    ? `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="padding: 5px 10px; font-size: 0.6rem; letter-spacing: 0.5px;">ACTIVE</span>`
                    : `<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="padding: 5px 10px; font-size: 0.6rem; letter-spacing: 0.5px;">INACTIVE</span>`;

                const iconHtml = item.icon ? `<i class="bi ${item.icon} me-2 text-primary opacity-50"></i>` : '';
                const specialBadge = item.special_type ? `<span class="badge bg-primary ms-2" style="font-size: 0.5rem;">${item.special_type.toUpperCase()}</span>` : '';

                let imagePreviewHtml = '';
                if (item.component_type === 'global_media' && item.image) {
                    imagePreviewHtml = `<div class="mt-2"><img src="../${item.image}" class="rounded border shadow-sm" style="height: 40px; width: 80px; object-fit: cover;"></div>`;
                }

                html += `
                <tr>
                    <td class="p-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-dark">${iconHtml}${item.label}</span>
                            ${specialBadge}
                        </div>
                        ${item.badge_text ? `<small class="badge ${item.badge_class || 'bg-light text-dark'} mt-1" style="font-size: 10px;">${item.badge_text}</small>` : ''}
                        ${imagePreviewHtml}
                    </td>
                    <td class="p-3"><code class="small text-muted">${item.url || '-'}</code></td>
                    <td class="p-3 text-center">${statusBadge}</td>
                    <td class="p-3 text-center"><span class="badge bg-dark bg-opacity-10 text-dark small fw-normal">${item.sort_order}</span></td>
                    <td class="p-3 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <button class="btn btn-sm btn-light btn-round mb-0" onclick="editComponent(${item.id})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light btn-round mb-0 text-danger" onclick="showDeleteConfirm(${item.id})"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
            });

            html += `</tbody></table></div></div>`;
            container.innerHTML = html;
        }

        function resetForm() {
            document.getElementById('componentForm').reset();
            document.getElementById('component_id').value = '';
            document.getElementById('modalTitle').innerText = 'Add New link';

            // Render Premium Selects
            renderZoneSelect(currentZone);
            renderSpecialSelect('');
            renderBadgeSelect('text-bg-primary');
            renderStatusSelect('active');

            document.getElementById('image-section').style.display = 'none';
            document.getElementById('image-preview-container').classList.add('d-none');
            document.getElementById('upload-placeholder').classList.remove('d-none');
            document.getElementById('image_path').value = '';
            document.getElementById('display-path').innerText = 'None';
        }

        function renderZoneSelect(currentValue) {
            const options = [
                { label: 'Header Navigation', value: 'header_nav', icon: 'bi-window' },
                { label: 'Footer: Column 1', value: 'footer_col_1', icon: 'bi-layout-sidebar' },
                { label: 'Footer: Column 2', value: 'footer_col_2', icon: 'bi-layout-sidebar' },
                { label: 'Footer: Column 3', value: 'footer_col_3', icon: 'bi-layout-sidebar' },
                { label: 'Footer: Social Links', value: 'footer_social', icon: 'bi-share' },
                { label: 'Media Assets', value: 'global_media', icon: 'bi-images' }
            ];
            renderPremiumSelect('zone-select-container', options, currentValue, (val) => {
                document.getElementById('component_type').value = val;
            });
            document.getElementById('component_type').value = currentValue;
        }

        function renderSpecialSelect(currentValue) {
            const options = [
                { label: 'Standard Link', value: '', icon: 'bi-link-45deg' },
                { label: 'Mega Menu (Services)', value: 'services_dropdown', icon: 'bi-grid-3x3-gap-fill' },
                { label: 'Services CTA Asset', value: 'services_cta', icon: 'bi-image' }
            ];
            renderPremiumSelect('special-select-container', options, currentValue, (val) => {
                document.getElementById('special_type').value = val;
                toggleImageSection(val);
            });
            document.getElementById('special_type').value = currentValue;
            toggleImageSection(currentValue);
        }

        function toggleImageSection(specialType) {
            const section = document.getElementById('image-section');
            if (specialType === 'services_dropdown' || specialType === 'services_cta') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        function renderBadgeSelect(currentValue) {
            const options = [
                { label: 'Normal (Dark)', value: 'text-bg-dark', dotColor: '#24292d' },
                { label: 'Primary (Blue)', value: 'text-bg-primary', dotColor: '#2163e8' },
                { label: 'Success (Green)', value: 'text-bg-success', dotColor: '#0cbc87' },
                { label: 'Warning (Yellow)', value: 'text-bg-warning', dotColor: '#f7c32e' },
                { label: 'Info (Cyan)', value: 'text-bg-info', dotColor: '#0dcaf0' },
                { label: 'Hot (Red)', value: 'text-bg-danger', dotColor: '#d6293e' }
            ];

            renderPremiumSelect('badge-select-container', options, currentValue, (val) => {
                document.getElementById('badge_class').value = val;
            });
            document.getElementById('badge_class').value = currentValue;
        }

        function renderStatusSelect(currentValue) {
            const options = [
                { label: 'Active / Published', value: 'active', icon: 'bi-check-circle-fill' },
                { label: 'Inactive / Hidden', value: 'inactive', icon: 'bi-eye-slash-fill' }
            ];
            renderPremiumSelect('status-select-container', options, currentValue, (val) => {
                document.getElementById('status').value = val;
            });
            document.getElementById('status').value = currentValue;
        }

        function editComponent(id) {
            const item = allZoneComponents.find(c => c.id == id);
            if (!item) return;

            document.getElementById('component_id').value = item.id;
            document.getElementById('component_type').value = item.component_type;
            document.getElementById('label').value = item.label;
            document.getElementById('url').value = item.url || '';
            document.getElementById('icon').value = item.icon || '';
            document.getElementById('badge_text').value = item.badge_text || '';
            document.getElementById('sort_order').value = item.sort_order;
            document.getElementById('special_type').value = item.special_type || '';
            document.getElementById('image_path').value = item.image || '';
            updateImagePreview(item.image);

            document.getElementById('modalTitle').innerText = 'Edit Link Configuration';

            renderZoneSelect(item.component_type);
            renderSpecialSelect(item.special_type || '');
            renderBadgeSelect(item.badge_class || 'text-bg-primary');
            renderStatusSelect(item.status);

            componentModal.show();
        }

        async function saveComponent() {
            const id = document.getElementById('component_id').value;
            const method = id ? 'PUT' : 'POST';

            const payload = {
                component_type: document.getElementById('component_type').value,
                label: document.getElementById('label').value,
                url: document.getElementById('url').value,
                icon: document.getElementById('icon').value || null,
                badge_text: document.getElementById('badge_text').value || null,
                badge_class: document.getElementById('badge_class').value || null,
                special_type: document.getElementById('special_type').value || null,
                image: document.getElementById('image_path').value || null,
                sort_order: document.getElementById('sort_order').value || 10,
                status: document.getElementById('status').value
            };

            if (id) payload.id = id;

            try {
                const response = await fetch(API_URL, {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();

                if (result.success) {
                    componentModal.hide();
                    showToast(result.message, 'success');
                    loadZone(payload.component_type);
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (error) {
                showToast('Targeting server failed', 'danger');
            }
        }

        function showDeleteConfirm(id) {
            showPremiumDeleteModal(
                'Delete Link?',
                'This component will be permanently stripped from the site layout.',
                async () => {
                    try {
                        const response = await fetch(`${API_URL}?id=${id}`, { method: 'DELETE' });
                        const result = await response.json();

                        if (result.success) {
                            showToast('Component stripped successfully', 'success');
                            loadZone(currentZone);
                        } else {
                            showToast(result.message, 'danger');
                        }
                    } catch (error) {
                        showToast('Communication failed', 'danger');
                    }
                },
                'dark'
            );
        }

        async function uploadImage(input) {
            if (!input.files[0]) return;

            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('media_type', 'images');
            formData.append('prefix', 'nav-cta');

            try {
                const response = await fetch('../api/media-manager.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    document.getElementById('image_path').value = result.path;
                    updateImagePreview(result.path);
                    showToast('Image uploaded successfully', 'success');
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (error) {
                showToast('Upload failed', 'danger');
            }
        }

        function updateImagePreview(path) {
            const previewContainer = document.getElementById('image-preview-container');
            const placeholder = document.getElementById('upload-placeholder');
            const previewImg = document.getElementById('image-preview');
            const pathDisplay = document.getElementById('display-path');

            if (path) {
                previewImg.src = '../' + path;
                previewContainer.classList.remove('d-none');
                placeholder.classList.add('d-none');
                pathDisplay.innerText = path;
            } else {
                previewContainer.classList.add('d-none');
                placeholder.classList.remove('d-none');
                pathDisplay.innerText = 'None';
            }
        }

        // --- Home CTA Management ---
        async function loadHomeCTAs() {
            currentZone = 'home-cta';
            const container = document.getElementById('home_cta_container');
            container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>`;

            try {
                const resNews = await fetch('../api/home_ctas.php?type=newsletter');
                const dataNews = await resNews.json();

                const resCareer = await fetch('../api/home_ctas.php?type=career');
                const dataCareer = await resCareer.json();

                renderHomeCTACards(dataNews.data, dataCareer.data);
            } catch (error) {
                container.innerHTML = `<div class="alert alert-danger">Failed to load CTAs.</div>`;
            }
        }

        function renderHomeCTACards(news, career) {
            const container = document.getElementById('home_cta_container');
            container.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm overflow-hidden h-100">
                            <div class="card-header bg-primary text-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white"><i class="bi bi-rocket-takeoff me-2"></i>Newsletter CTA</h6>
                                    <span class="badge ${news.status === 'active' ? 'bg-success' : 'bg-secondary'}">${news.status.toUpperCase()}</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3 text-center">
                                    <img src="../${news.image_path}" class="rounded shadow-sm mb-3" style="max-height: 120px; object-fit: contain;">
                                </div>
                                <h5 class="fw-bold mb-1">${news.title}</h5>
                                <p class="text-muted small mb-3">${news.subtitle}</p>
                                <button class="btn btn-outline-primary btn-sm w-100" onclick='editCTA(${JSON.stringify(news)}, "newsletter")'>
                                    <i class="bi bi-pencil-square me-2"></i>Configure Newsletter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm overflow-hidden h-100">
                            <div class="card-header bg-primary-grad text-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white"><i class="bi bi-briefcase me-2"></i>Careers CTA</h6>
                                    <span class="badge ${career.status === 'active' ? 'bg-success' : 'bg-secondary'}">${career.status.toUpperCase()}</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3 text-center">
                                    <img src="../${career.image_path}" class="rounded shadow-sm mb-3" style="max-height: 120px; object-fit: contain;">
                                </div>
                                <h5 class="fw-bold mb-1">${career.title}</h5>
                                <p class="text-muted small mb-3">${career.subtitle}</p>
                                <button class="btn btn-outline-primary btn-sm w-100" onclick='editCTA(${JSON.stringify(career)}, "career")'>
                                    <i class="bi bi-pencil-square me-2"></i>Configure Careers
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }


        // --- CTA/Job Modal Handlers ---
        function editCTA(data, type) {
            document.getElementById('cta_id').value = data.id;
            document.getElementById('cta_type').value = type;
            document.getElementById('cta_title').value = data.title;
            document.getElementById('cta_subtitle').value = data.subtitle;
            document.getElementById('cta_btn_text').value = data.btn_text || '';
            document.getElementById('cta_status').value = data.status;
            document.getElementById('cta_image_path').value = data.image_path;

            const urlGroup = document.getElementById('cta_url_group');
            if (type === 'career') {
                urlGroup.style.display = 'block';
                document.getElementById('cta_btn_url').value = data.btn_url || '';
            } else {
                urlGroup.style.display = 'none';
            }

            const preview = document.getElementById('cta_preview');
            const placeholder = document.getElementById('cta_upload_placeholder');
            if (data.image_path) {
                preview.src = '../' + data.image_path;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                document.getElementById('cta_path_display').innerText = data.image_path;
            } else {
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
            }

            ctaModal.show();
        }

        async function uploadCTAImage(input) {
            if (!input.files[0]) return;
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('media_type', 'images');
            formData.append('prefix', 'home-cta');

            try {
                const response = await fetch('../api/media-manager.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    document.getElementById('cta_image_path').value = result.path;
                    document.getElementById('cta_preview').src = '../' + result.path;
                    document.getElementById('cta_preview').classList.remove('d-none');
                    document.getElementById('cta_upload_placeholder').classList.add('d-none');
                    document.getElementById('cta_path_display').innerText = result.path;
                    showToast('CTA Image uploaded', 'success');
                }
            } catch (e) { showToast('Upload failed', 'danger'); }
        }

        async function saveCTA() {
            const payload = {
                id: document.getElementById('cta_id').value,
                type: document.getElementById('cta_type').value,
                title: document.getElementById('cta_title').value,
                subtitle: document.getElementById('cta_subtitle').value,
                btn_text: document.getElementById('cta_btn_text').value,
                btn_url: document.getElementById('cta_btn_url').value,
                image_path: document.getElementById('cta_image_path').value,
                status: document.getElementById('cta_status').value
            };

            try {
                const res = await fetch('../api/home_ctas.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await res.json();
                if (result.success) {
                    ctaModal.hide();
                    showToast(result.message, 'success');
                    loadHomeCTAs();
                }
            } catch (e) { showToast('Update failed', 'danger'); }
        }


    </script>
    <?php inject_toast_system(); ?>
</body>

</html>