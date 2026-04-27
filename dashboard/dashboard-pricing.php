<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
require_once('../include/db.php');

// Helper to calculate directory stats for the storage widget
function getDirStats($dir) {
    $stats = ['files' => 0, 'imgs' => 0, 'vids' => 0, 'docs' => 0, 'folders' => 0, 'size' => 0];
    if (!is_dir($dir)) return $stats;
    $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($items as $item) {
        if ($item->isDir()) $stats['folders']++;
        else {
            $stats['files']++;
            $stats['size'] += $item->getSize();
            $ext = strtolower($item->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) $stats['imgs']++;
            elseif (in_array($ext, ['mp4', 'mov', 'webm', 'ogg'])) $stats['vids']++;
            elseif (in_array($ext, ['pdf', 'doc', 'docx', 'txt', 'zip'])) $stats['docs']++;
        }
    }
    return $stats;
}

$uploadStats = getDirStats('../assets/uploads');
$usedMB = round($uploadStats['size'] / (1024 * 1024), 2);
$capacityMB = 500;
$storagePercent = min(100, round(($usedMB / $capacityMB) * 100, 1));

// Fetch all services for the selector with 3D icons
$services_stmt = $pdo->query("SELECT id, name, icon_3d FROM services WHERE status = 'active' ORDER BY name ASC");
$all_services = $services_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weburea - Manage Pricing</title>
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
    <link rel="stylesheet" type="text/css" href="assets/vendor/apexcharts/dist/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/OverlayScrollbars.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard-pricing.css?v=<?= time() ?>">
</head>

<body>
    <?php include 'include/header.php'; ?>
    <main>
        <section class="py-4">
            <div class="container">

            <div class="page-content-wrapper p-xxl-4">
                <!-- Title and Actions -->
                <div class="row pb-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h2 mb-2">Pricing Management</h1>
                        <p class="mb-0">Configure pricing plans for each agency service.</p>
                    </div>
                    <div class="col-lg-4 text-end">
                        <button class="btn btn-premium mb-0" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                            <i class="bi bi-plus-lg me-2"></i>Add New Plan
                        </button>
                    </div>
                </div>

                <!-- Stats and Controls START -->
                <div class="row g-4 mb-5">
                    <!-- Active Plans Stat -->
                    <div class="col-md-4 col-xl-3">
                        <div class="card-stat-premium">
                            <div class="stat-badge">
                                <i class="bi bi-tag-fill"></i>
                            </div>
                            <span class="stat-label">Active Plans</span>
                            <h3 class="stat-number" id="active-plan-count">0</h3>
                            
                            <div class="stat-footer">
                                <span><i class="bi bi-check-circle-fill text-success me-1"></i> STATUS: ACTIVE</span>
                                <span id="last-sync-time">SYNCED JUST NOW</span>
                            </div>
                        </div>
                    </div>

                    <!-- Config Card -->
                    <div class="col-md-8 col-xl-9">
                        <div class="config-card-premium">
                            <div class="row g-0">
                                <div class="col-md-5 config-left">
                                    <label class="form-label font-base fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">Select Active Service</label>
                                    <div id="service-select-container"></div>
                                    
                                    <div class="section-tagline mt-4">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Manage pricing models and structural comparison features for the selected agency service.
                                    </div>
                                </div>
                                <div class="col-md-7 config-right">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="mb-0 text-uppercase fw-800 small" style="letter-spacing: 1px;">Comparison Attributes</h6>
                                        <button class="btn btn-premium-soft btn-sm py-1 px-3 rounded-pill fw-bold" onclick="addComparisonAttributeInput()">
                                            <i class="bi bi-plus-lg me-1"></i> Add
                                        </button>
                                    </div>
                                    <div id="service-comparison-attributes" class="attribute-list-scroll">
                                        <!-- Dynamic Inputs -->
                                    </div>
                                    <button class="btn btn-sync-premium" onclick="saveServiceComparisonAttributes()">
                                        <i class="bi bi-cloud-arrow-up-fill"></i> Sync Attributes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Stats and Controls END -->

                <!-- Plans Grid -->
                <div id="plans-container" class="row g-4">
                    <!-- Dynamic Content -->
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading pricing plans...</p>
                    </div>
                </div>

            </div>
        </section>
    </main>
</body>

    <!-- Add Plan Modal -->
    <div class="modal fade modal-premium" id="addPlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="premium-alert-header bg-dark-blue">
                    <div class="frosted-icon-circle">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPlanForm">
                    <div class="modal-body p-5">
                        <div class="premium-alert-badge badge-dark-blue-soft mb-3">CONFIGURATION ENGINE</div>
                        <h2 class="premium-alert-title h3 mb-4">Create New Pricing Plan</h2>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="label-premium">PLAN NAME</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Basic, Pro, Enterprise" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">BADGE LABEL (OPTIONAL)</label>
                                <input type="text" name="label" class="form-control" placeholder="e.g. MOST POPULAR">
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">DISPLAY PRICE</label>
                                <input type="text" name="price" class="form-control" placeholder="$2,500" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">ANNUAL PRICE (OPTIONAL)</label>
                                <input type="text" name="annual_price" class="form-control" placeholder="$2,000 / month">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_recommended" id="addIsRecommended">
                                    <label class="form-check-label label-premium mb-0 ms-2" for="addIsRecommended">Mark as Recommended</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_custom" id="addIsCustom">
                                    <label class="form-check-label label-premium mb-0 ms-2" for="addIsCustom">Custom Plan (Hide price)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="label-premium">PLAN DESCRIPTION</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Brief tagline for this plan"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="label-premium mb-0">KEY FEATURES</label>
                                    <button type="button" class="btn btn-premium-soft btn-sm-ref" onclick="addFeatureInput('add-features-list')">
                                        <i class="bi bi-plus-lg"></i> Add Feature
                                    </button>
                                </div>
                                <div id="add-features-list" class="p-3 rounded-4 border" style="max-height: 300px; overflow-y: auto; background: var(--premium-panel-soft);">
                                    <!-- Dynamic Inputs -->
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2 opacity-50">
                                <label class="label-premium">COMPARISON ATTRIBUTES</label>
                                <div id="add-comparison-values-list" class="row g-3">
                                    <!-- Dynamic Inputs -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-premium-close" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-premium-save">Deploy Plan</button>
                    </div>
                    <div class="verified-secure-footer">
                        <div class="secure-branding">
                            <span><i class="bi bi-shield-check me-1"></i> VERIFIED SECURE VAULT</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Plan Modal -->
    <div class="modal fade modal-premium" id="editPlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="premium-alert-header bg-dark-blue">
                    <div class="frosted-icon-circle">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPlanForm">
                    <div class="modal-body p-5">
                        <div class="premium-alert-badge badge-dark-blue-soft mb-3">RECORD UPDATE</div>
                        <h2 class="premium-alert-title h3 mb-4">Edit Configuration</h2>
                        <input type="hidden" name="id">
                        <input type="hidden" name="service_id">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="label-premium">PLAN NAME</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">BADGE LABEL (OPTIONAL)</label>
                                <input type="text" name="label" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">DISPLAY PRICE</label>
                                <input type="text" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-premium">ANNUAL PRICE (OPTIONAL)</label>
                                <input type="text" name="annual_price" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_recommended" id="editIsRecommended">
                                    <label class="form-check-label label-premium mb-0 ms-2" for="editIsRecommended">Recommended</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_custom" id="editIsCustom">
                                    <label class="form-check-label label-premium mb-0 ms-2" for="editIsCustom">Custom Plan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="label-premium">PLAN DESCRIPTION</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Brief tagline for this plan"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="label-premium mb-0">KEY FEATURES</label>
                                    <button type="button" class="btn btn-premium-soft btn-sm-ref" onclick="addFeatureInput('edit-features-list')">
                                        <i class="bi bi-plus-lg"></i> Add Feature
                                    </button>
                                </div>
                                <div id="edit-features-list" class="p-3 rounded-4 border" style="max-height: 300px; overflow-y: auto; background: var(--premium-panel-soft);"></div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2 opacity-50">
                                <label class="label-premium">COMPARISON ATTRIBUTES</label>
                                <div id="edit-comparison-values-list" class="row g-3">
                                    <!-- Dynamic Inputs -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-premium-close" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-premium-save">Save Changes</button>
                    </div>
                    <div class="verified-secure-footer">
                        <div class="secure-branding">
                            <span><i class="bi bi-shield-check me-1"></i> VERIFIED SECURE VAULT</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>
    <script src="assets/js/functions.js"></script>
    
    <script>
        let currentServiceId = null;
        let servicesList = <?php echo json_encode($all_services); ?>;
        let currentServiceAttributes = [];
        
        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            initDashboard();
            const urlParams = new URLSearchParams(window.location.search);
            const initialServiceId = parseInt(urlParams.get('service_id')) || servicesList[0]?.id;

            renderPremiumSelect('service-select-container', 
                servicesList.map(s => ({ value: s.id, label: s.name, img: s.icon_3d })), 
                initialServiceId, 
                (newId) => {
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('service_id', newId);
                    window.history.pushState({}, '', newUrl);
                    loadServiceDetails(newId);
                    loadServicePlans(newId);
                }
            );
            
            if (initialServiceId) {
                loadServiceDetails(initialServiceId);
                loadServicePlans(initialServiceId);
            }
        });

        async function initDashboard() {
            fetchStorageInfo();
        }

        async function fetchStorageInfo() {
            try {
                const res = await fetch('../api/home_config.php?action=storage');
                const data = await res.json();
                if (data.success) {
                    document.getElementById('storage-used').textContent = data.usage_formatted;
                    document.getElementById('storage-count').textContent = data.file_count + ' files';
                    const pct = Math.min(100, (data.usage_bytes / data.quota_bytes) * 100);
                    const bar = document.getElementById('storage-bar');
                    if(bar) bar.style.width = pct + '%';
                }
            } catch (e) { }
        }

        function loadServiceDetails(serviceId) {
            fetch(`../api/services.php`)
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        const service = res.data.find(s => s.id == serviceId);
                        if (service) {
                            currentServiceAttributes = service.comparison_features_json || [];
                            renderServiceAttributes();
                        }
                    }
                });
        }

        function renderServiceAttributes() {
            const container = document.getElementById('service-comparison-attributes');
            container.innerHTML = currentServiceAttributes.length === 0 
                ? '<div class="text-center py-4 text-muted small">No attributes defined. Click "Add" to start.</div>'
                : currentServiceAttributes.map((attr, idx) => `
                <div class="attr-pill-item">
                    <input type="text" value="${attr}" placeholder="Attribute Name..." onchange="updateAttribute(${idx}, this.value)">
                    <i class="bi bi-x-circle-fill attr-delete-btn" onclick="removeAttributeConfirm(${idx})"></i>
                </div>
            `).join('');
            
            renderComparisonValueInputs('add-comparison-values-list');
        }

        function addComparisonAttributeInput() {
            currentServiceAttributes.push('');
            renderServiceAttributes();
        }

        function updateAttribute(idx, val) {
            currentServiceAttributes[idx] = val;
        }

        function removeAttributeConfirm(idx) {
            showPremiumDeleteModal(
                'Remove Attribute?',
                'This will remove this attribute across all plans for this service. This action is permanent.',
                () => {
                    currentServiceAttributes.splice(idx, 1);
                    renderServiceAttributes();
                    saveServiceComparisonAttributes(); // Auto-persist after confirmation
                },
                'dark'
            );
        }

        function saveServiceComparisonAttributes() {
            const attrs = currentServiceAttributes.filter(a => a.trim() !== '');
            fetch(`../api/services.php?id=${currentServiceId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: currentServiceId,
                    comparison_features_json: attrs
                })
            }).then(r => r.json()).then(res => {
                if (res.success) {
                    showToast('Attributes synced across all plans!', 'success');
                    const now = new Date();
                    document.getElementById('last-sync-time').innerText = `SYNCED AT ${now.getHours()}:${now.getMinutes().toString().padStart(2, '0')}`;
                } else {
                    showToast(res.message, 'danger');
                }
            });
        }

        function renderComparisonValueInputs(containerId, planValues = {}) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            if (currentServiceAttributes.length === 0) {
                container.innerHTML = '<p class="small text-muted mb-0">No attributes defined for this service.</p>';
                return;
            }

            container.innerHTML = currentServiceAttributes.map(attr => `
                <div class="col-md-6 mb-3">
                    <label class="form-label label-premium mb-1" style="font-size: 10px; opacity: 0.7;">${attr}</label>
                    <input type="text" class="form-control form-control-premium" data-attr="${attr}" value="${planValues[attr] || ''}" placeholder="Value for ${attr}">
                </div>
            `).join('');
        }

        function getComparisonValuesFromContainer(containerId) {
            const values = {};
            document.querySelectorAll(`#${containerId} input`).forEach(input => {
                values[input.dataset.attr] = input.value;
            });
            return values;
        }
        function loadServicePlans(serviceId) {
            currentServiceId = serviceId;
            const container = document.getElementById('plans-container');
            container.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-primary"></div></div>';
            
            fetch(`../api/pricing.php?service_id=${serviceId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        renderPlans(data.data);
                        document.getElementById('active-plan-count').innerText = data.data.length;
                        
                        // Detailed breakdown for the stat card
                        const customCount = data.data.filter(p => p.is_custom).length;
                        const standardCount = data.data.length - customCount;
                        const breakdownText = `${standardCount} Standard, ${customCount} Custom`;
                        
                        // Insert breakdown into the stat card if it exists
                        const footer = document.querySelector('.card-stat-premium .stat-footer span:first-child');
                        if (footer) {
                            footer.innerHTML = `<i class="bi bi-pie-chart-fill text-success me-1"></i> ${breakdownText}`;
                        }
                    } else {
                        container.innerHTML = `<div class="col-12"><div class="alert alert-danger">${data.message}</div></div>`;
                    }
                });
        }

        function renderPlans(plans) {
            const container = document.getElementById('plans-container');
            if (plans.length === 0) {
                container.innerHTML = `<div class="col-12 text-center py-5">
                    <div class="frosted-icon-circle mx-auto mb-3" style="background: rgba(244,140,6,0.1);">
                        <i class="bi bi-tag-fill text-orange" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-800">No plans configured</h5>
                    <p class="text-muted small">Start by adding a pricing plan for this service.</p>
                    <button class="btn btn-premium btn-sm" onclick="bootstrap.Modal.getOrCreateInstance('#addPlanModal').show()">Add First Plan</button>
                </div>`;
                return;
            }

            container.innerHTML = plans.map(plan => `
                <div class="col-md-6 col-xl-4">
                    <div class="plan-card-premium">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <span class="plan-badge-label ${plan.is_recommended ? 'recommended' : ''}">
                                    ${plan.is_recommended ? '<i class="bi bi-star-fill me-1"></i> TOP CHOICE' : 'PRESET'}
                                </span>
                                <h4 class="mb-0 fw-900">${plan.name}</h4>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-baseline gap-2">
                            <h2 class="plan-price-large">${plan.is_custom ? 'Custom' : '$' + plan.price}</h2>
                            ${!plan.is_custom ? `<span class="plan-price-period">/Project</span>` : ''}
                        </div>
                        
                        <p class="text-secondary small mb-4 mt-2" style="line-height: 1.6; min-height: 48px;">${plan.description || 'Professional tier for high-growth projects and dedicated infrastructure.'}</p>
                        
                        <div class="snapshot-grid">
                            ${Object.entries(plan.comparison_values_json || {}).slice(0, 4).map(([key, val]) => `
                                <div class="snapshot-item">
                                    <span class="title">${key}</span>
                                    <span class="value">${val || 'N/A'}</span>
                                </div>
                            `).join('')}
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-configure-premium" onclick='openEditModal(${JSON.stringify(plan).replace(/'/g, "&apos;")})'>
                                <i class="bi bi-pencil-square me-2"></i> Configure
                            </button>
                            <button class="btn btn-delete-plain" onclick="deletePlan(${plan.id})" title="Delete Plan">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function addFeatureInput(containerId, value = '') {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'feature-input-group input-group';
            div.innerHTML = `
                <input type="text" class="form-control" value="${value}" placeholder="Enter feature description...">
                <button type="button" class="btn btn-remove-feature" onclick="this.parentElement.remove()" title="Remove Feature">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        function getFeaturesFromContainer(containerId) {
            return Array.from(document.getElementById(containerId).querySelectorAll('input'))
                .map(input => input.value.trim())
                .filter(v => v !== '');
        }

        // Add Logic
        document.getElementById('addPlanForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            const payload = {
                service_id: currentServiceId,
                name: formData.get('name'),
                label: formData.get('label'),
                price: formData.get('price'),
                annual_price: formData.get('annual_price'),
                description: formData.get('description'),
                is_recommended: formData.get('is_recommended') === 'on',
                is_custom: formData.get('is_custom') === 'on',
                features_json: getFeaturesFromContainer('add-features-list'),
                comparison_values_json: getComparisonValuesFromContainer('add-comparison-values-list'),
                status: 'active'
            };

            fetch('../api/pricing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(res => {
                if (res.success) {
                    showToast('Plan successfully deployed!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('addPlanModal')).hide();
                    this.reset();
                    document.getElementById('add-features-list').innerHTML = '';
                    loadServicePlans(currentServiceId);
                } else {
                    showToast(res.message, 'danger');
                }
            });
        };

        function openEditModal(plan) {
            const form = document.getElementById('editPlanForm');
            form.id.value = plan.id;
            form.name.value = plan.name;
            form.label.value = plan.label || '';
            form.price.value = plan.price;
            form.annual_price.value = plan.annual_price || '';
            form.description.value = plan.description || '';
            form.is_recommended.checked = plan.is_recommended;
            form.is_custom.checked = plan.is_custom;
            
            // Populate features
            const featuresContainer = document.getElementById('edit-features-list');
            featuresContainer.innerHTML = '';
            (plan.features_json || []).forEach(f => addFeatureInput('edit-features-list', f));
            
            renderComparisonValueInputs('edit-comparison-values-list', plan.comparison_values_json || {});
            
            bootstrap.Modal.getOrCreateInstance('#editPlanModal').show();
        }

        document.getElementById('editPlanForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');
            
            const payload = {
                name: formData.get('name'),
                label: formData.get('label'),
                price: formData.get('price'),
                annual_price: formData.get('annual_price'),
                description: formData.get('description'),
                is_recommended: formData.get('is_recommended') === 'on',
                is_custom: formData.get('is_custom') === 'on',
                features_json: getFeaturesFromContainer('edit-features-list'),
                comparison_values_json: getComparisonValuesFromContainer('edit-comparison-values-list'),
                status: 'active'
            };

            fetch(`../api/pricing.php?id=${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(res => {
                if (res.success) {
                    showToast('Configuration updated!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('editPlanModal')).hide();
                    loadServicePlans(currentServiceId);
                } else {
                    showToast(res.message, 'danger');
                }
            });
        };

        function deletePlan(id) {
            showPremiumDeleteModal(
                'Purge Configuration?',
                'This action will permanently delete this pricing plan from the service catalogue.',
                async () => {
                    fetch(`../api/pricing.php?id=${id}`, { method: 'DELETE' })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            showToast('Plan purged successfully', 'success');
                            loadServicePlans(currentServiceId);
                        } else {
                            showToast(res.message, 'danger');
                        }
                    });
                },
                'dark'
            );
        }
    </script>
    
    <?php 
        inject_toast_system(); 
        inject_premium_delete_modal(); 
        inject_premium_alert_modal();
    ?>
</body>
</html>
