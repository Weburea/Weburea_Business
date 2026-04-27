<?php
require_once('../include/auth_check.php');
require_once('../include/db.php');
require_once('../include/alerts.php');

// Fetch submissions
$stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC");
$submissions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weburea - Contact Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="assets/js/dark-mode.js"></script>
    <link rel="shortcut icon" href="../assets/images/favicon/Vector.ico">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/OverlayScrollbars.min.css">
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
                        <h1 class="h2 mb-2">Contact Page & Submissions</h1>
                        <p class="text-secondary">Manage contact details, form settings, and view user messages.</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="text-center mb-4">
                    <ul class="nav nav-tabs premium-nav-tabs justify-content-center mb-4 px-3" id="contactTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab"><i class="bi bi-megaphone me-2"></i>Hero & Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="form-tab" data-bs-toggle="tab" data-bs-target="#tab-form" type="button" role="tab"><i class="bi bi-input-cursor-text me-2"></i>Form Settings</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="subs-tab" data-bs-toggle="tab" data-bs-target="#tab-subs" type="button" role="tab"><i class="bi bi-inbox me-2"></i>Submissions</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <!-- Hero & Info -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <div class="home-card mb-4">
                            <h4 class="mb-3">Hero Section</h4>
                            <form id="hero-form">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Icon</label>
                                        <input type="text" name="icon" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" name="subtitle" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Support Hours</label>
                                        <input type="text" name="support_hours" class="form-control">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium">Save Hero</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="home-card">
                            <h4 class="mb-3">Contact Information Cards</h4>
                            <form id="info-form">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <h6>Call Us Card</h6>
                                        <input type="text" name="call_us_icon" class="form-control mb-2" placeholder="Icon">
                                        <input type="text" name="call_us_title" class="form-control mb-2" placeholder="Title">
                                        <textarea name="call_us_desc" class="form-control mb-2" rows="2" placeholder="Description"></textarea>
                                        <input type="text" name="call_us_contact" class="form-control mb-2" placeholder="Contact Text">
                                        <input type="text" name="call_us_link" class="form-control" placeholder="Link">
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Mail Us Card</h6>
                                        <input type="text" name="mail_us_icon" class="form-control mb-2" placeholder="Icon">
                                        <input type="text" name="mail_us_title" class="form-control mb-2" placeholder="Title">
                                        <textarea name="mail_us_desc" class="form-control mb-2" rows="2" placeholder="Description"></textarea>
                                        <input type="text" name="mail_us_contact" class="form-control mb-2" placeholder="Contact Text">
                                        <input type="text" name="mail_us_link" class="form-control" placeholder="Link">
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Support Card</h6>
                                        <input type="text" name="support_icon" class="form-control mb-2" placeholder="Icon">
                                        <input type="text" name="support_title" class="form-control mb-2" placeholder="Title">
                                        <textarea name="support_desc" class="form-control mb-2" rows="2" placeholder="Description"></textarea>
                                        <input type="text" name="support_contact" class="form-control mb-2" placeholder="Contact Text">
                                        <input type="text" name="support_link" class="form-control" placeholder="Link">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium">Save Information</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Form Settings -->
                    <div class="tab-pane fade" id="tab-form" role="tabpanel">
                        <div class="home-card">
                            <h4 class="mb-3">Form Configuration</h4>
                            <form id="contact-settings-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Form Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Typed Words (use && as separator)</label>
                                        <input type="text" name="typed_words" class="form-control" placeholder="Hello&&Hola&&Ciao">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Form Subtitle</label>
                                        <input type="text" name="subtitle" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Admin Email (Where submissions are sent)</label>
                                        <input type="email" name="admin_email" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <h6 class="mt-3">Social Links (Leave '#' to hide)</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" name="social_facebook" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" name="social_instagram" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Twitter/X</label>
                                        <input type="text" name="social_twitter" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" name="social_linkedin" class="form-control">
                                    </div>
                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-premium">Save Settings</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Submissions -->
                    <div class="tab-pane fade" id="tab-subs" role="tabpanel">
                        <div class="home-card">
                            <h4 class="mb-3">Inbox</h4>
                            <div class="table-responsive">
                                <table class="table table-premium align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small fw-bold">Date / Time</th>
                                            <th class="small fw-bold">Name</th>
                                            <th class="small fw-bold">Email</th>
                                            <th class="small fw-bold">Subject</th>
                                            <th class="small fw-bold text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($submissions)): ?>
                                        <tr><td colspan="6" class="text-center text-muted py-4">No submissions yet.</td></tr>
                                        <?php else: ?>
                                            <?php foreach($submissions as $sub): ?>
                                            <tr>
                                                <td class="small">
                                                    <?= htmlspecialchars(date('M d, Y', strtotime($sub['created_at']))) ?><br>
                                                    <span class="text-muted small">(<?= date('H:i', strtotime($sub['created_at'])) ?>)</span>
                                                </td>
                                                <td class="small fw-bold text-dark"><?= htmlspecialchars($sub['name']) ?></td>
                                                <td class="small"><a href="mailto:<?= htmlspecialchars($sub['email']) ?>" class="text-secondary"><?= htmlspecialchars($sub['email']) ?></a></td>
                                                <td class="small">
                                                    <span class="text-truncate d-inline-block" style="max-width: 150px;">
                                                        <?= htmlspecialchars($sub['subject'] ?: 'No Subject') ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button class="btn btn-sm btn-light border-0 shadow-sm px-2" 
                                                                title="View Message"
                                                                onclick="viewSubmission(<?= htmlspecialchars(json_encode($sub), ENT_QUOTES, 'UTF-8') ?>)">
                                                            <i class="bi bi-eye text-primary"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-light border-0 shadow-sm px-2" 
                                                                title="Delete"
                                                                onclick="confirmDeleteSubmission(<?= $sub['id'] ?>)">
                                                            <i class="bi bi-trash3 text-danger"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        let fullConfig = {};

        async function fetchConfig() {
            try {
                const res = await fetch('../api/contact_config.php');
                const result = await res.json();
                if (result.success) {
                    result.data.forEach(sec => {
                        fullConfig[sec.section_key] = sec.section_content;
                    });
                    initForms();
                }
            } catch (err) { console.error('Failed to fetch config', err); }
        }

        function initForms() {
            // Hero
            const heroForm = document.getElementById('hero-form');
            const heroData = fullConfig['hero'] || {};
            Object.keys(heroData).forEach(k => { if(heroForm.elements[k]) heroForm.elements[k].value = heroData[k]; });
            heroForm.onsubmit = (e) => { e.preventDefault(); saveSimpleSection('hero', heroForm); };

            // Info
            const infoForm = document.getElementById('info-form');
            const infoData = fullConfig['contact_info'] || {};
            ['call_us', 'mail_us', 'support'].forEach(k => {
                if(infoData[k]) {
                    if(infoForm.elements[k+'_icon']) infoForm.elements[k+'_icon'].value = infoData[k].icon;
                    if(infoForm.elements[k+'_title']) infoForm.elements[k+'_title'].value = infoData[k].title;
                    if(infoForm.elements[k+'_desc']) infoForm.elements[k+'_desc'].value = infoData[k].desc;
                    if(infoForm.elements[k+'_contact']) infoForm.elements[k+'_contact'].value = infoData[k].contact;
                    if(infoForm.elements[k+'_link']) infoForm.elements[k+'_link'].value = infoData[k].link;
                }
            });
            infoForm.onsubmit = (e) => {
                e.preventDefault();
                const formData = new FormData(infoForm);
                const content = {
                    call_us: { icon: formData.get('call_us_icon'), title: formData.get('call_us_title'), desc: formData.get('call_us_desc'), contact: formData.get('call_us_contact'), link: formData.get('call_us_link') },
                    mail_us: { icon: formData.get('mail_us_icon'), title: formData.get('mail_us_title'), desc: formData.get('mail_us_desc'), contact: formData.get('mail_us_contact'), link: formData.get('mail_us_link') },
                    support: { icon: formData.get('support_icon'), title: formData.get('support_title'), desc: formData.get('support_desc'), contact: formData.get('support_contact'), link: formData.get('support_link') }
                };
                updateBackend('contact_info', content);
            };

            // Form settings
            const settingsForm = document.getElementById('contact-settings-form');
            const settingsData = fullConfig['contact_form'] || {};
            if (settingsForm.elements['title']) settingsForm.elements['title'].value = settingsData.title || '';
            if (settingsForm.elements['subtitle']) settingsForm.elements['subtitle'].value = settingsData.subtitle || '';
            if (settingsForm.elements['typed_words']) settingsForm.elements['typed_words'].value = settingsData.typed_words || '';
            if (settingsForm.elements['admin_email']) settingsForm.elements['admin_email'].value = settingsData.admin_email || '';
            
            const socials = settingsData.social_links || {};
            if (settingsForm.elements['social_facebook']) settingsForm.elements['social_facebook'].value = socials.facebook || '#';
            if (settingsForm.elements['social_instagram']) settingsForm.elements['social_instagram'].value = socials.instagram || '#';
            if (settingsForm.elements['social_twitter']) settingsForm.elements['social_twitter'].value = socials.twitter || '#';
            if (settingsForm.elements['social_linkedin']) settingsForm.elements['social_linkedin'].value = socials.linkedin || '#';

            settingsForm.onsubmit = (e) => {
                e.preventDefault();
                const formData = new FormData(settingsForm);
                const content = {
                    title: formData.get('title'),
                    subtitle: formData.get('subtitle'),
                    typed_words: formData.get('typed_words'),
                    admin_email: formData.get('admin_email'),
                    social_links: {
                        facebook: formData.get('social_facebook'),
                        instagram: formData.get('social_instagram'),
                        twitter: formData.get('social_twitter'),
                        linkedin: formData.get('social_linkedin')
                    }
                };
                updateBackend('contact_form', content);
            };
        }

        async function saveSimpleSection(key, form) {
            const formData = new FormData(form);
            const content = Object.fromEntries(formData.entries());
            await updateBackend(key, content);
        }

        async function updateBackend(key, content) {
            try {
                const res = await fetch('../api/contact_config.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-API-Key': 'weburea_secret_2026' },
                    body: JSON.stringify({ section_key: key, section_content: content })
                });
                const result = await res.json();
                if (result.success) showToast(result.message, 'success');
                else showToast(result.message, 'danger');
            } catch (err) { showToast('Update failed', 'danger'); }
        }

        document.addEventListener('DOMContentLoaded', fetchConfig);
    </script>
    <?php 
        inject_toast_system(); 
        inject_premium_delete_modal();
    ?>

    <!-- View Submission Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white border-0 py-4 px-4">
                    <h5 class="modal-title fw-bold" id="viewTitle">Message Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-md-5">
                    <div class="mb-4">
                        <label class="small text-uppercase fw-bold text-primary mb-1 d-block">From</label>
                        <h5 id="viewName" class="mb-0 fw-bold"></h5>
                        <p id="viewEmail" class="text-secondary small mb-0"></p>
                    </div>
                    <div class="mb-4">
                        <label class="small text-uppercase fw-bold text-primary mb-1 d-block">Subject</label>
                        <p id="viewSubject" class="fw-bold text-dark mb-0"></p>
                    </div>
                    <div>
                        <label class="small text-uppercase fw-bold text-primary mb-1 d-block">Message</label>
                        <div id="viewMessage" class="bg-light p-3 rounded-3 text-secondary small" style="min-height: 100px; white-space: pre-wrap;"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
                    <a id="replyBtn" href="#" class="btn btn-primary px-4 rounded-pill shadow-sm">Reply via Email</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewSubmission(sub) {
            document.getElementById('viewName').innerText = sub.name;
            document.getElementById('viewEmail').innerText = sub.email;
            document.getElementById('viewSubject').innerText = sub.subject || 'No Subject';
            document.getElementById('viewMessage').innerText = sub.message;
            document.getElementById('replyBtn').href = 'mailto:' + sub.email + '?subject=Re: ' + (sub.subject || 'Weburea Agency Inquiry');
            
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function confirmDeleteSubmission(id) {
            showPremiumDeleteModal(
                null,
                null,
                async () => {
                    try {
                        const res = await fetch('../api/delete_contact.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: id })
                        });
                        const result = await res.json();
                        if (result.success) {
                            showToast(result.message, 'success');
                            location.reload();
                        } else {
                            showToast(result.message, 'danger');
                        }
                    } catch (err) {
                        showToast('Failed to delete submission', 'danger');
                    }
                },
                'danger',
                'global'
            );
        }
    </script>
</body>
</html>
