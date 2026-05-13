<?php
/**
 * Weburea Premium Alert System
 * Handles context-aware session-based flash messages and premium dynamic modals.
 * Updated to match high-fidelity design standards (v2.1).
 * Refactored to comply with "No Internal CSS" mandate.
 */

// Start session if not already started and headers not sent
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

/**
 * Fetch All Modal Configurations from Database
 */
function get_all_modal_configs() {
    global $pdo;
    if (!isset($pdo)) {
        require_once dirname(__FILE__) . '/db.php';
    }
    try {
        $stmt = $pdo->query("SELECT * FROM modal_configurations");
        $configs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ctx = $row['context_key'];
            $type = $row['modal_type'];
            if (!isset($configs[$ctx])) $configs[$ctx] = [];
            $configs[$ctx][$type] = $row;
        }
        return $configs;
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Set a flash message for the next page load
 */
function set_alert($message, $type = 'success') {
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) session_start();
    $_SESSION['weburea_alerts'][] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Render any pending session alerts (Inline Bootstrap Alerts)
 */
function render_alerts() {
    if (!isset($_SESSION['weburea_alerts']) || empty($_SESSION['weburea_alerts'])) {
        return '';
    }

    $html = '<div class="weburea-alerts-container mb-4">';
    foreach ($_SESSION['weburea_alerts'] as $alert) {
        $type = $alert['type'];
        $icon = 'bi-check-circle-fill';
        if ($type === 'danger') $icon = 'bi-exclamation-octagon-fill';
        if ($type === 'warning') $icon = 'bi-exclamation-triangle-fill';
        if ($type === 'info') $icon = 'bi-info-circle-fill';

        $html .= "
        <div class='alert alert-{$type} alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-2' role='alert'>
            <i class='bi {$icon} me-2 fs-5'></i>
            <div>{$alert['message']}</div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    $html .= '</div>';
    
    unset($_SESSION['weburea_alerts']);
    return $html;
}

/**
 * Inject the Toast container and JS helper
 */
function inject_toast_system() {
    ?>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="webureaToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center text-white">
                    <i id="toastIcon" class="bi me-2 fs-5"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('webureaToast');
            const messageEl = document.getElementById('toastMessage');
            const iconEl = document.getElementById('toastIcon');
            toastEl.className = 'toast align-items-center border-0 bg-' + type;
            messageEl.innerText = message;
            iconEl.className = 'bi me-2 fs-5 ';
            if (type === 'success') iconEl.classList.add('bi-check-circle-fill');
            else if (type === 'danger') iconEl.classList.add('bi-exclamation-octagon-fill');
            else if (type === 'warning') iconEl.classList.add('bi-exclamation-triangle-fill');
            else iconEl.classList.add('bi-info-circle-fill');
            const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
            toast.show();
        }
    </script>
    <?php
}

/**
 * Inject the Premium Confirmation Modals
 */
function inject_premium_delete_modal() {
    $all_configs = get_all_modal_configs();
    ?>
    <div class="modal fade premium-alert-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg premium-modal-container">
                <div id="modalHeader" class="premium-alert-header bg-dark-blue">
                    <div id="deleteIconCircle" class="frosted-icon-circle">
                        <div id="modalIconContainer" class="premium-rocket-icon h-100 w-100 d-flex align-items-center justify-content-center">
                        </div>
                    </div>
                </div>
                <div class="premium-alert-body p-5 text-center">
                    <div id="modalBadge" class="premium-alert-badge badge-dark-blue-soft mb-3">Security Protocol</div>
                    <h2 class="premium-alert-title fw-800 mb-2 text-white" id="deleteModalTitle">Are you sure?</h2>
                    <p class="premium-alert-text mb-4 fs-6" id="deleteModalMessage">This action is permanent and cannot be reversed by the system.</p>
                    
                    <button type="button" class="btn-premium-action w-100 py-3 fw-bold text-uppercase bg-dark-blue shadow" id="confirmDeleteBtn">Confirm Removal</button>
                    <button type="button" class="btn btn-premium-cancel mt-3 small w-100 text-secondary fw-bold" data-bs-dismiss="modal">Cancel Request</button>
                </div>
                <div class="verified-secure-footer py-4 px-3 bg-dark-blue">
                    <div id="secureBrandingDelete" class="secure-branding d-flex flex-column align-items-center"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (typeof window.premiumModalConfigs === 'undefined') window.premiumModalConfigs = <?php echo json_encode($all_configs); ?>;
        if (typeof window.globalDeleteCallback === 'undefined') window.globalDeleteCallback = null;
        if (typeof window.globalDeleteModalInstance === 'undefined') window.globalDeleteModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const deleteModalEl = document.getElementById('deleteModal');
            if (deleteModalEl) window.globalDeleteModalInstance = new bootstrap.Modal(deleteModalEl);
            const isDashboard = window.location.pathname.includes('/dashboard/');
            const logoPath = isDashboard ? '../assets/images/logo-light.svg' : 'assets/images/logo-light.svg';
            const brandingHTML = `
                <img src="${logoPath}" class="secure-logo">
                <span class="secure-status text-white opacity-75">Verified Secure Portal</span>
            `;
            const deleteBranding = document.getElementById('secureBrandingDelete');
            if(deleteBranding) deleteBranding.innerHTML = brandingHTML;

            // Global Confirmation Handler
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (typeof window.globalDeleteCallback === 'function') {
                        window.globalDeleteCallback();
                    }
                    if (window.globalDeleteModalInstance) {
                        window.globalDeleteModalInstance.hide();
                    }
                });
            }
        });

        function showPremiumDeleteModal(title, message, onConfirm, type = 'dark', context = 'global') {
            const modalEl = document.getElementById('deleteModal');
            if (!modalEl) return;
            const isDashboard = window.location.pathname.includes('/dashboard/');
            const assetRoot = isDashboard ? '../' : '';

            const ctxConfigs = (window.premiumModalConfigs && window.premiumModalConfigs[context]) || (window.premiumModalConfigs && window.premiumModalConfigs['global']) || {};
            const config = ctxConfigs[type] || ctxConfigs['error'] || {};
            
            document.getElementById('deleteModalTitle').innerText = title || config.title || 'Are you sure?';
            document.getElementById('deleteModalMessage').innerText = message || config.message || 'This action is permanent.';
            
            const header = document.getElementById('modalHeader');
            const badge = document.getElementById('modalBadge');
            const btn = document.getElementById('confirmDeleteBtn');
            const iconContainer = document.getElementById('modalIconContainer');
            const iconCircle = document.getElementById('deleteIconCircle');

            btn.innerText = config.button_text || 'Confirm Deletion';
            const animType = config.animation_type || 'float-down';
            iconCircle.className = 'frosted-icon-circle ' + (animType === 'float-up' ? 'modal-icon-animate-up' : 'modal-icon-animate-down');
            const rotation = animType === 'float-up' ? '-5deg' : '175deg';
            
            const imgPath = assetRoot + (config.image_path || 'assets/images/elements/rocket-02.png');
            iconContainer.innerHTML = `<img src="${imgPath}" class="modal-rocket-icon" style="transform: rotate(${rotation});">`;

            if (type === 'danger') {
                header.className = 'premium-alert-header bg-danger';
                badge.className = 'premium-alert-badge badge-danger-soft';
                badge.innerText = 'Removal Warning';
                btn.className = 'btn-premium-action w-100 py-3 fw-bold text-uppercase bg-danger shadow';
            } else {
                header.className = 'premium-alert-header bg-dark-blue';
                badge.className = 'premium-alert-badge badge-dark-blue-soft';
                badge.innerText = 'Security Protocol';
                btn.className = 'btn-premium-action w-100 py-3 fw-bold text-uppercase bg-dark-blue shadow';
            }
            window.globalDeleteCallback = onConfirm;
            if (!window.globalDeleteModalInstance) window.globalDeleteModalInstance = new bootstrap.Modal(modalEl);
            window.globalDeleteModalInstance.show();
        }
    </script>
    <?php
}

/**
 * Inject Generic Premium Alert Modal (Success, Warning, Info)
 */
function inject_premium_alert_modal() {
    $all_configs = get_all_modal_configs();
    ?>
    <div class="modal fade premium-alert-modal" id="alertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg premium-modal-container">
                <div id="alertModalHeader" class="premium-alert-header bg-primary-grad">
                    <div id="alertIconCircle" class="frosted-icon-circle">
                        <div id="alertModalIcon" class="premium-rocket-icon h-100 w-100 d-flex align-items-center justify-content-center"></div>
                    </div>
                </div>
                <div class="premium-alert-body p-5 text-center">
                    <div id="alertModalBadge" class="premium-alert-badge badge-primary-soft mb-3">Operation Success</div>
                    <h2 class="premium-alert-title fw-800 mb-2 text-white" id="alertModalTitle">Success!</h2>
                    <p class="premium-alert-text mb-4 fs-6" id="alertModalMessage">Your request has been successfully processed.</p>
                    
                    <button type="button" class="btn-premium-action w-100 py-3 fw-bold text-uppercase bg-primary-grad shadow" id="alertConfirmBtn" data-bs-dismiss="modal">Dismiss</button>
                </div>
                <div class="verified-secure-footer py-4 px-3 bg-dark-blue">
                    <div id="secureBrandingAlert" class="secure-branding d-flex flex-column align-items-center"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (typeof window.premiumModalConfigs === 'undefined') window.premiumModalConfigs = <?php echo json_encode($all_configs); ?>;
        if (typeof window.globalAlertModalInstance === 'undefined') window.globalAlertModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const alertModalEl = document.getElementById('alertModal');
            if (alertModalEl) window.globalAlertModalInstance = new bootstrap.Modal(alertModalEl);
            const isDashboard = window.location.pathname.includes('/dashboard/');
            const logoPath = isDashboard ? '../assets/images/logo-light.svg' : 'assets/images/logo-light.svg';
            const brandingHTML = `
                <img src="${logoPath}" class="secure-logo">
                <span class="secure-status text-white opacity-75">Verified Secure Portal</span>
            `;
            const alertBranding = document.getElementById('secureBrandingAlert');
            if(alertBranding) alertBranding.innerHTML = brandingHTML;
        });

        function showPremiumAlert(title, message, type = 'success', btnText = null, context = 'global') {
            const modalEl = document.getElementById('alertModal');
            if (!modalEl) return;
            const isDashboard = window.location.pathname.includes('/dashboard/');
            const assetRoot = isDashboard ? '../' : '';

            const ctxConfigs = (window.premiumModalConfigs && window.premiumModalConfigs[context]) || (window.premiumModalConfigs && window.premiumModalConfigs['global']) || {};
            const config = ctxConfigs[type] || {};
            
            document.getElementById('alertModalTitle').innerText = title || config.title || 'Notice';
            document.getElementById('alertModalMessage').innerText = message || config.message || '';
            
            const header = document.getElementById('alertModalHeader');
            const badge = document.getElementById('alertModalBadge');
            const btn = document.getElementById('alertConfirmBtn');
            const icon = document.getElementById('alertModalIcon');
            const iconCircle = document.getElementById('alertIconCircle');

            btn.innerText = btnText || config.button_text || 'Dismiss';
            header.className = 'premium-alert-header';
            badge.className = 'premium-alert-badge';
            btn.className = 'btn-premium-action shadow w-100 py-3 fw-bold text-uppercase';
            
            const animType = config.animation_type || (type === 'success' ? 'float-up' : 'float-down');
            iconCircle.className = 'frosted-icon-circle ' + (animType === 'float-up' ? 'modal-icon-animate-up' : 'modal-icon-animate-down');
            const rotation = animType === 'float-up' ? '-5deg' : '175deg';
            
            const imgPath = assetRoot + (config.image_path || 'assets/images/elements/rocket-02.png');

            if (type === 'success') {
                header.classList.add('bg-primary-grad');
                badge.classList.add('badge-primary-soft');
                badge.innerText = 'Operation Success';
                btn.classList.add('bg-primary-grad');
            } else if (type === 'danger' || type === 'error') {
                header.classList.add('bg-danger');
                badge.classList.add('badge-danger-soft');
                badge.innerText = 'System Critical';
                btn.classList.add('bg-danger');
            } else if (type === 'warning') {
                header.classList.add('bg-dark-blue'); 
                badge.classList.add('badge-warning-soft');
                badge.innerText = 'System Warning';
                btn.classList.add('bg-dark-blue');
            } else {
                header.classList.add('bg-dark-blue');
                badge.classList.add('badge-dark-blue-soft');
                badge.innerText = 'Information';
                btn.classList.add('bg-dark-blue');
            }

            icon.innerHTML = `<img src="${imgPath}" class="modal-rocket-icon" style="transform: rotate(${rotation});">`;

            if (!window.globalAlertModalInstance) window.globalAlertModalInstance = new bootstrap.Modal(modalEl);
            window.globalAlertModalInstance.show();
        }
    </script>
    <?php
}
