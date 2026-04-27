<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
require_once('../include/db.php');

$all_configs = get_all_modal_configs();
$contexts = ['global', 'newsletter', 'contact', 'careers', 'services'];
$current_context = $_GET['context'] ?? 'global';
$configs = $all_configs[$current_context] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weburea - User Pop-up Modals</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Dark mode -->
    <script src="assets/js/dark-mode.js"></script>
    <link rel="shortcut icon" href="../assets/images/favicon/Vector.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css?v=<?= time() ?>">
    
    <style>
        .modal-config-card { border-radius: 20px; overflow: hidden; transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; border: 1px solid rgba(0,0,0,0.05); background: var(--bs-card-bg); }
        .modal-config-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
        .config-header { padding: 2.5rem; display: flex; align-items: center; justify-content: center; position: relative; }
        .config-icon-preview { width: 100px; height: 100px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.3); }
        .config-icon-preview img { width: 60px; height: 60px; object-fit: contain; }
        .config-body { padding: 2rem; flex-grow: 1; }
        .config-footer { padding: 1.5rem 2rem; background: rgba(0,0,0,0.02); border-top: 1px solid rgba(0,0,0,0.05); display: flex; gap: 10px; }
        .label-premium { font-size: 0.65rem; font-weight: 800; text-uppercase; letter-spacing: 1.5px; color: var(--bs-primary); margin-bottom: 0.5rem; display: block; }
        .form-control-premium { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid rgba(0,0,0,0.1); font-weight: 600; font-size: 0.9rem; }
        [data-bs-theme="dark"] .modal-config-card { border-color: rgba(255,255,255,0.1); }
        [data-bs-theme="dark"] .config-footer { background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1); }
        .btn-test-modal { background: #f8f9fa; color: #333; border: 1px solid #ddd; border-radius: 10px; padding: 0.5rem 1rem; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; transition: all 0.2s; cursor: pointer; }
        .btn-test-modal:hover { background: #333; color: #fff; }

        /* Avatar Clickable Overrides */
        .config-icon-trigger { position: relative; cursor: pointer; }
        .config-icon-trigger:hover .avatar-overlay { opacity: 1; transform: scale(1); }
        .avatar-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(244, 140, 6, 0.7); border-radius: 50%; display: flex; align-items: center; justify-content: center; opacity: 0; transform: scale(0.8); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 5; }
        .avatar-overlay i { color: white; font-size: 1.5rem; }
    </style>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <main>
        <section class="py-4">
            <div class="container">
                <div class="row pb-4 align-items-center">
                    <div class="col-lg-7">
                        <h1 class="h2 mb-1">User Pop-up Modals</h1>
                        <p class="mb-0 text-muted">Page-specific feedback configurations.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm p-2" style="border-radius: 15px; background: var(--bs-light);">
                            <div class="d-flex align-items-center">
                                <span class="label-premium mb-0 me-3 ms-2">CONTEXT:</span>
                                <div id="context-selector-container" class="flex-grow-1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4" id="modal-configs-container">
                    <?php
                    $modal_types = [
                        'success' => ['icon' => 'bi-check-lg', 'bg' => 'bg-primary-grad', 'label' => 'Success Alert'],
                        'warning' => ['icon' => 'bi-exclamation-triangle-fill', 'bg' => 'bg-dark-blue', 'label' => 'Warning Alert'],
                        'error'   => ['icon' => 'bi-trash3-fill', 'bg' => 'bg-danger', 'label' => 'Danger/Delete Alert'],
                        'info'    => ['icon' => 'bi-info-circle-fill', 'bg' => 'bg-dark-blue', 'label' => 'Info Alert']
                    ];

                    foreach ($modal_types as $type => $meta):
                        $config = $configs[$type] ?? [
                            'title' => '', 'message' => '', 'button_text' => 'Dismiss', 'animation_type' => 'float-up', 'image_path' => 'assets/images/elements/rocket-02.png'
                        ];
                    ?>
                    <div class="col-xl-6">
                        <div class="modal-config-card">
                            <div class="config-header <?= $meta['bg'] ?>">
                                <!-- Avatar Clickable Trigger -->
                                <div class="config-icon-trigger" onclick="triggerImageUpload('<?= $type ?>')">
                                    <div class="config-icon-preview">
                                        <img src="../<?= htmlspecialchars($config['image_path']) ?>" alt="preview" id="img-preview-<?= $type ?>">
                                    </div>
                                    <div class="avatar-overlay">
                                        <i class="bi bi-camera-fill"></i>
                                    </div>
                                    <input type="file" id="file-input-<?= $type ?>" class="d-none" accept="image/*" onchange="handleImageUpload(this, '<?= $type ?>')">
                                </div>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-white bg-opacity-25 text-white fw-bold"><?= strtoupper($type) ?></span>
                                </div>
                            </div>
                            <div class="config-body">
                                <form id="form-<?= $type ?>" onsubmit="saveModalConfig(event, '<?= $type ?>')">
                                    <input type="hidden" name="context_key" value="<?= $current_context ?>">
                                    <input type="hidden" name="image_path" id="input-path-<?= $type ?>" value="<?= htmlspecialchars($config['image_path']) ?>">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="label-premium">MODAL TITLE</label>
                                            <input type="text" name="title" class="form-control form-control-premium" value="<?= htmlspecialchars($config['title']) ?>" placeholder="Enter Title..." required>
                                        </div>
                                        <div class="col-12">
                                            <label class="label-premium">MODAL MESSAGE</label>
                                            <textarea name="message" class="form-control form-control-premium" rows="2" placeholder="Enter Message..." required><?= htmlspecialchars($config['message']) ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="label-premium">BUTTON TEXT</label>
                                            <input type="text" name="button_text" class="form-control form-control-premium" value="<?= htmlspecialchars($config['button_text']) ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="label-premium">ANIMATION FLOW</label>
                                            <select name="animation_type" class="form-select form-control-premium">
                                                <option value="float-up" <?= $config['animation_type'] == 'float-up' ? 'selected' : '' ?>>Floating Upward</option>
                                                <option value="float-down" <?= $config['animation_type'] == 'float-down' ? 'selected' : '' ?>>Floating Downward</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" id="btn-save-<?= $type ?>" class="btn btn-premium w-100 mt-4 shadow-sm">
                                        <i class="bi bi-cloud-arrow-up-fill me-2"></i>Sync Configuration
                                    </button>
                                </form>
                            </div>
                            <div class="config-footer">
                                <button class="btn-test-modal flex-grow-1" onclick="testModal('<?= $type ?>')">
                                    <i class="bi bi-play-fill me-1"></i> Live Test
                                </button>
                                <div class="btn-test-modal text-muted small px-3 d-flex align-items-center" style="cursor: default;">
                                    <i class="bi bi-layers me-1"></i> <?= ucfirst($current_context) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Inject Modals for Testing -->
    <?php inject_premium_alert_modal(); inject_premium_delete_modal(); inject_toast_system(); ?>

    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>
    <script src="assets/js/functions.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contextOptions = [
                { value: 'global', label: 'Global Defaults', icon: 'bi-globe' },
                { value: 'newsletter', label: 'Newsletter', icon: 'bi-envelope-paper' },
                { value: 'contact', label: 'Contact Page', icon: 'bi-chat-dots' },
                { value: 'careers', label: 'Careers', icon: 'bi-briefcase' },
                { value: 'services', label: 'Services', icon: 'bi-gear' }
            ];
            
            renderPremiumSelect('context-selector-container', contextOptions, '<?= $current_context ?>', (val) => {
                window.location.href = 'dashboard-modals.php?context=' + val;
            });
        });

        function triggerImageUpload(type) {
            document.getElementById('file-input-' + type).click();
        }

        async function handleImageUpload(input, type) {
            if (!input.files || !input.files[0]) return;
            
            const file = input.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('media_type', 'images');
            formData.append('prefix', 'modal-icon-' + type);

            showToast('Uploading asset...', 'info');

            try {
                const res = await fetch('../api/media-manager.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                
                if (result.success) {
                    const publicPath = result.path;
                    document.getElementById('img-preview-' + type).src = '../' + publicPath;
                    document.getElementById('input-path-' + type).value = publicPath;
                    showToast('Asset uploaded successfully!', 'success');
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (err) {
                showToast('Failed to upload asset', 'danger');
            }
        }

        async function saveModalConfig(e, type) {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('btn-save-' + type);
            const originalHTML = btn.innerHTML;
            
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Syncing...';
            btn.disabled = true;

            const formData = new FormData(form);
            const data = {
                context_key: formData.get('context_key'),
                modal_type: type,
                title: formData.get('title'),
                message: formData.get('message'),
                button_text: formData.get('button_text'),
                image_path: formData.get('image_path'),
                animation_type: formData.get('animation_type')
            };

            try {
                const res = await fetch('../api/modals.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                if (result.success) {
                    showToast('Configuration synced to ' + data.context_key, 'success');
                    if (window.premiumModalConfigs) {
                        if(!window.premiumModalConfigs[data.context_key]) window.premiumModalConfigs[data.context_key] = {};
                        window.premiumModalConfigs[data.context_key][type] = data;
                    }
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (err) {
                showToast('Network error occurred', 'danger');
            } finally {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        }

        function testModal(type) {
            const form = document.getElementById('form-' + type);
            const formData = new FormData(form);
            const title = formData.get('title');
            const message = formData.get('message');
            const btnText = formData.get('button_text');
            const anim = formData.get('animation_type');
            const img = formData.get('image_path');
            const ctx = formData.get('context_key');

            if (window.premiumModalConfigs) {
                if(!window.premiumModalConfigs[ctx]) window.premiumModalConfigs[ctx] = {};
                window.premiumModalConfigs[ctx][type] = { title, message, button_text: btnText, animation_type: anim, image_path: img };
            }

            if (type === 'error') {
                showPremiumDeleteModal(title, message, () => {
                    showToast('Action confirmed in test!', 'info');
                }, 'danger', ctx);
            } else {
                showPremiumAlert(title, message, type, btnText, ctx);
            }
        }
    </script>
</body>
</html>
