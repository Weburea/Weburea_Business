<?php
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weburea - About Page Management</title>
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
                <div class="row pb-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h2 mb-2">About Page Configuration</h1>
                        <p class="text-secondary">Manage the narrative, team, and milestones of Weburea Agency</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="text-center mb-4">
                    <ul class="nav nav-tabs premium-nav-tabs justify-content-center mb-4 px-3" id="aboutTabs"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="hero-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-hero" type="button" role="tab"><i
                                    class="bi bi-megaphone me-2"></i>Hero</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#tab-company"
                                type="button" role="tab"><i class="bi bi-info-circle me-2"></i>Company Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mission-tab" data-bs-toggle="tab" data-bs-target="#tab-mission"
                                type="button" role="tab"><i class="bi bi-lightning-charge me-2"></i>Mission/Vision</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="team-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-team" type="button" role="tab"><i
                                    class="bi bi-people me-2"></i>Team Preview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="awards-tab" data-bs-toggle="tab"
                                data-bs-target="#tab-awards" type="button" role="tab"><i
                                    class="bi bi-trophy me-2"></i>Awards</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#tab-history"
                                type="button" role="tab"><i class="bi bi-clock-history me-2"></i>History</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews"
                                type="button" role="tab"><i class="bi bi-star me-2"></i>Trusted Leaders</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cta-tab" data-bs-toggle="tab" data-bs-target="#tab-cta"
                                type="button" role="tab"><i class="bi bi-envelope me-2"></i>Call To Action</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="aboutTabsContent">
                    <!-- Tab: Hero -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-megaphone"></i></div>
                                <div>
                                    <h4 class="mb-0">Hero Section</h4>
                                    <small class="text-secondary">Introduction of the about page</small>
                                </div>
                            </div>
                            <form id="hero-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Pre-Title</label>
                                        <input type="text" name="pre_title" class="form-control" placeholder="About Weburea">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Title Line 1</label>
                                        <input type="text" name="main_title_line1" class="form-control" placeholder="Creativity">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Title Highlight</label>
                                        <input type="text" name="main_title_highlight" class="form-control" placeholder="in Motion">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Text</label>
                                        <input type="text" name="btn_text" class="form-control" placeholder="Meet our team">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Link</label>
                                        <input type="text" name="btn_link" class="form-control" placeholder="team.php">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Lead Text</label>
                                        <textarea name="lead_text" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Hero</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Company Info -->
                    <div class="tab-pane fade" id="tab-company" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-info-circle"></i></div>
                                <div>
                                    <h4 class="mb-0">Company Information</h4>
                                    <small class="text-secondary">Core details about the agency</small>
                                </div>
                            </div>
                            <form id="company-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Founding Year</label>
                                        <input type="text" name="founding_year" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Main Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <label class="form-label font-base fw-bold d-block">Image 1 (Left)</label>
                                        <div class="avatar avatar-xl border border-dashed p-1 mx-auto" onclick="openMediaSelector('company_image_1')" style="cursor:pointer; width: 80px; height: 80px;">
                                            <img id="company_image_1_preview" src="" class="avatar-img rounded" style="object-fit: cover;">
                                        </div>
                                        <input type="hidden" name="image_1" id="company_image_1_input">
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <label class="form-label font-base fw-bold d-block">Image 2 (Right)</label>
                                        <div class="avatar avatar-xl border border-dashed p-1 mx-auto" onclick="openMediaSelector('company_image_2')" style="cursor:pointer; width: 80px; height: 80px;">
                                            <img id="company_image_2_preview" src="" class="avatar-img rounded" style="object-fit: cover;">
                                        </div>
                                        <input type="hidden" name="image_2" id="company_image_2_input">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Description 1</label>
                                        <textarea name="description_1" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-base fw-bold">Description 2</label>
                                        <textarea name="description_2" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Text</label>
                                        <input type="text" name="btn_text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label font-base fw-bold">Button Link</label>
                                        <input type="text" name="btn_link" class="form-control">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Company Info</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Mission/Vision -->
                    <div class="tab-pane fade" id="tab-mission" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-lightning-charge"></i></div>
                                <div>
                                    <h4 class="mb-0">Mission, Vision & Goals</h4>
                                    <small class="text-secondary">Core values of the agency</small>
                                </div>
                            </div>
                            <form id="mission-form">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="card p-3 border-dashed">
                                            <h6 class="mb-3">Mission</h6>
                                            <input type="text" name="mission_title" class="form-control mb-2" placeholder="Title">
                                            <textarea name="mission_content" class="form-control mb-2" rows="4" placeholder="Content"></textarea>
                                            <input type="text" name="mission_icon" class="form-control" placeholder="Icon Class">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-3 border-dashed">
                                            <h6 class="mb-3">Vision</h6>
                                            <input type="text" name="vision_title" class="form-control mb-2" placeholder="Title">
                                            <textarea name="vision_content" class="form-control mb-2" rows="4" placeholder="Content"></textarea>
                                            <input type="text" name="vision_icon" class="form-control" placeholder="Icon Class">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-3 border-dashed">
                                            <h6 class="mb-3">Goal</h6>
                                            <input type="text" name="goal_title" class="form-control mb-2" placeholder="Title">
                                            <textarea name="goal_content" class="form-control mb-2" rows="4" placeholder="Content"></textarea>
                                            <input type="text" name="goal_icon" class="form-control" placeholder="Icon Class">
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Mission/Vision</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Team Preview -->
                    <div class="tab-pane fade" id="tab-team" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-people"></i></div>
                                <div>
                                    <h4 class="mb-0">Team Preview</h4>
                                    <small class="text-secondary">Team members list</small>
                                </div>
                            </div>
                            <form id="team-form">
                                <div class="mb-3">
                                    <label class="form-label font-base fw-bold">Section Title</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label font-base fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="2"></textarea>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name & Role</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="team-list-body"></tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-dark mb-3" onclick="addTeamMember()"><i class="bi bi-plus-circle me-2"></i>Add Member</button>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Team</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Awards -->
                    <div class="tab-pane fade" id="tab-awards" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-trophy"></i></div>
                                <div>
                                    <h4 class="mb-0">Awards & Achievements</h4>
                                    <small class="text-secondary">Milestones and recognition</small>
                                </div>
                            </div>

                            <!-- Awards Intro Section -->
                            <div class="card bg-light border p-4 mb-4">
                                <h5 class="mb-3">Awards Intro Section</h5>
                                <form id="awards-intro-form">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label font-base fw-bold">Founding Year (Big Text)</label>
                                            <input type="text" name="founding_year" class="form-control" placeholder="2025">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label font-base fw-bold">Main Title</label>
                                            <input type="text" name="title" class="form-control" placeholder="Bringing ideas to life">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label font-base fw-bold">Description 1</label>
                                            <textarea name="description_1" class="form-control" rows="2"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label font-base fw-bold">Description 2</label>
                                            <textarea name="description_2" class="form-control" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label font-base fw-bold">List Items (Comma separated)</label>
                                            <input type="text" name="list_items" class="form-control" placeholder="UI/UX Design, Motion Graphics, etc.">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label font-base fw-bold">Button Text</label>
                                            <input type="text" name="btn_text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label font-base fw-bold">Button Link</label>
                                            <input type="text" name="btn_link" class="form-control">
                                        </div>
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-dark"><i class="bi bi-check2-circle me-2"></i>Save Awards Intro</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <hr class="my-4">

                            <form id="awards-form">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label font-base fw-bold">Section Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="col-md-4 text-center">
                                         <label class="form-label font-base fw-bold d-block">Side Illustration</label>
                                         <div class="avatar border border-dashed p-1 mx-auto" onclick="openMediaSelector('award_side_image')" style="cursor:pointer; width: 150px; height: 150px;">
                                             <img id="award_side_image_preview" src="" class="avatar-img rounded" style="object-fit: contain;">
                                         </div>
                                         <input type="hidden" name="side_image" id="award_side_image_input">
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Icon</th>
                                                <th>Label</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="awards-list-body"></tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-dark mb-3" onclick="addAward()"><i class="bi bi-plus-circle me-2"></i>Add Award</button>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save Awards</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: History -->
                    <div class="tab-pane fade" id="tab-history" role="tabpanel">
                        <div class="home-card">
                            <div class="section-header">
                                <div class="section-icon"><i class="bi bi-clock-history"></i></div>
                                <div>
                                    <h4 class="mb-0">History Timeline</h4>
                                    <small class="text-secondary">Major agency milestones</small>
                                </div>
                            </div>
                            <form id="history-form">
                                <div class="mb-3">
                                    <label class="form-label font-base fw-bold">Section Title</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 150px;">Year</th>
                                                <th>Content</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="history-list-body"></tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-dark mb-3" onclick="addHistoryItem()"><i class="bi bi-plus-circle me-2"></i>Add Milestone</button>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-premium"><i class="bi bi-check2-circle me-2"></i>Save History</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Shared Tabs (Reviews/CTA) -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                        <div class="home-card text-center py-5">
                            <i class="bi bi-people display-4 text-secondary mb-3"></i>
                            <h4>Trusted Leaders (Reviews)</h4>
                            <p class="text-secondary mb-4">Manage the shared reviews section used across the site.</p>
                            <a href="dashboard-home.php#tab-reviews" class="btn btn-premium">Go to Home Dashboard (Reviews Tab)</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                        <div class="home-card text-center py-5">
                            <i class="bi bi-envelope display-4 text-secondary mb-3"></i>
                            <h4>Call To Action</h4>
                            <p class="text-secondary mb-4">Manage the shared CTA section used across the site.</p>
                            <a href="dashboard-home.php#tab-cta" class="btn btn-premium">Go to Home Dashboard (CTA Tab)</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modals -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="p-4 text-center border-dashed rounded">
                        <input type="file" id="media-upload-input" class="d-none" onchange="handleFileUpload(this)">
                        <label for="media-upload-input" style="cursor: pointer;">
                            <i class="bi bi-cloud-arrow-up display-4 text-secondary"></i>
                            <p class="mt-2">Click to upload or drag and drop</p>
                        </label>
                        <div id="upload-progress" class="mt-3 d-none">
                            <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div></div>
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
        let mediaTarget = null;
        const mediaModal = new bootstrap.Modal(document.getElementById('mediaModal'));

        async function fetchConfig() {
            try {
                const res = await fetch('../api/about_config.php');
                const result = await res.json();
                if (result.success) {
                    result.data.forEach(sec => {
                        fullConfig[sec.section_key] = sec.section_content;
                    });
                    initAllForms();
                }
            } catch (err) { console.error('Failed to fetch config', err); }
        }

        function initAllForms() {
            initHeroForm();
            initCompanyForm();
            initMissionForm();
            initAwardsIntroForm();
            renderTeamList();
            renderAwardsForm();
            renderHistoryList();
        }

        function initHeroForm() {
            const form = document.getElementById('hero-form');
            const data = fullConfig['hero'] || {};
            Object.keys(data).forEach(k => { if(form.elements[k]) form.elements[k].value = data[k]; });
            form.onsubmit = (e) => { e.preventDefault(); saveSimpleSection('hero', form); };
        }

        function initCompanyForm() {
            const form = document.getElementById('company-form');
            const data = fullConfig['company_info'] || {};
            Object.keys(data).forEach(k => { if(form.elements[k]) form.elements[k].value = data[k]; });
            
            // Set image previews
            document.getElementById('company_image_1_preview').src = '../' + (data.image_1 || 'assets/images/about/08.jpg');
            document.getElementById('company_image_1_input').value = data.image_1 || 'assets/images/about/08.jpg';
            document.getElementById('company_image_2_preview').src = '../' + (data.image_2 || 'assets/images/about/09.jpg');
            document.getElementById('company_image_2_input').value = data.image_2 || 'assets/images/about/09.jpg';

            form.onsubmit = (e) => { e.preventDefault(); saveSimpleSection('company_info', form); };
        }

        function initMissionForm() {
            const form = document.getElementById('mission-form');
            const data = fullConfig['mission_vision'] || {};
            ['mission', 'vision', 'goal'].forEach(k => {
                if (data[k]) {
                    if (form.elements[k+'_title']) form.elements[k+'_title'].value = data[k].title;
                    if (form.elements[k+'_content']) form.elements[k+'_content'].value = data[k].content;
                    if (form.elements[k+'_icon']) form.elements[k+'_icon'].value = data[k].icon;
                }
            });
            form.onsubmit = (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const content = {
                    mission: { title: formData.get('mission_title'), content: formData.get('mission_content'), icon: formData.get('mission_icon') },
                    vision: { title: formData.get('vision_title'), content: formData.get('vision_content'), icon: formData.get('vision_icon') },
                    goal: { title: formData.get('goal_title'), content: formData.get('goal_content'), icon: formData.get('goal_icon') }
                };
                updateBackend('mission_vision', content);
            };
        }

        function initAwardsIntroForm() {
            const form = document.getElementById('awards-intro-form');
            const data = fullConfig['awards_intro'] || {};
            if (form) {
                Object.keys(data).forEach(k => {
                    if (form.elements[k]) {
                        if (k === 'list_items' && Array.isArray(data[k])) {
                            form.elements[k].value = data[k].join(', ');
                        } else {
                            form.elements[k].value = data[k];
                        }
                    }
                });
                form.onsubmit = (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const content = Object.fromEntries(formData.entries());
                    content.list_items = content.list_items.split(',').map(i => i.trim()).filter(i => i !== "");
                    updateBackend('awards_intro', content);
                };
            }
        }

        function renderTeamList() {
            const body = document.getElementById('team-list-body');
            const data = fullConfig['team_preview'] || { members: [] };
            const members = data.members || [];
            document.querySelector('#team-form [name="title"]').value = data.title || '';
            document.querySelector('#team-form [name="description"]').value = data.description || '';

            body.innerHTML = members.map((m, i) => `
                <tr>
                    <td>
                        <div class="avatar avatar-clickable border p-1" onclick="openMediaSelector('team_member', ${i})">
                            <img src="../${m.image}" class="avatar-img rounded" style="width:48px; height:48px; object-fit:cover" onerror="this.src='../assets/images/avatar/default.jpg'">
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm mb-1" value="${m.name}" placeholder="Name" onchange="fullConfig.team_preview.members[${i}].name = this.value">
                        <input type="text" class="form-control form-control-sm" value="${m.role}" placeholder="Role" onchange="fullConfig.team_preview.members[${i}].role = this.value">
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmRemoveTeamMember(${i})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        function confirmRemoveTeamMember(i) {
            showPremiumDeleteModal(
                null, 
                null, 
                () => {
                    fullConfig.team_preview.members.splice(i, 1);
                    renderTeamList();
                    showToast('Member removed from list (Save to persist)', 'info');
                },
                'dark',
                'global'
            );
        }

        function addTeamMember() {
            if (!fullConfig.team_preview) fullConfig.team_preview = { members: [] };
            fullConfig.team_preview.members.push({ name: 'New Member', role: 'Designer', image: 'assets/images/avatar/default.jpg' });
            renderTeamList();
        }

        function removeTeamMember(i) {
            // Deprecated - using confirmRemoveTeamMember
        }

        document.getElementById('team-form').onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            fullConfig.team_preview.title = formData.get('title');
            fullConfig.team_preview.description = formData.get('description');
            updateBackend('team_preview', fullConfig.team_preview);
        };

        function renderAwardsForm() {
            const form = document.getElementById('awards-form');
            const data = fullConfig['awards'] || { award_list: [] };
            form.elements['title'].value = data.title || '';
            document.getElementById('award_side_image_preview').src = '../' + (data.side_image || 'assets/images/elements/awards-saly.png');
            document.getElementById('award_side_image_input').value = data.side_image || '';

            const body = document.getElementById('awards-list-body');
            body.innerHTML = (data.award_list || []).map((a, i) => `
                <tr>
                    <td>
                        <div class="avatar avatar-clickable border p-1" onclick="openMediaSelector('award_icon', ${i})">
                            <img src="../${a.icon}" class="avatar-img rounded" style="width:32px; height:32px; object-fit:contain">
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" value="${a.label}" onchange="fullConfig.awards.award_list[${i}].label = this.value">
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmRemoveAward(${i})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        function confirmRemoveAward(i) {
            showPremiumDeleteModal(
                null, 
                null, 
                () => {
                    fullConfig.awards.award_list.splice(i, 1);
                    renderAwardsForm();
                    showToast('Award removed (Save to persist)', 'info');
                },
                'dark',
                'global'
            );
        }

        function addAward() {
            if (!fullConfig.awards) fullConfig.awards = { award_list: [] };
            fullConfig.awards.award_list.push({ icon: 'assets/images/elements/fwa-light.svg', label: 'New Achievement' });
            renderAwardsForm();
        }
        function removeAward(i) { /* Deprecated */ }

        document.getElementById('awards-form').onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            fullConfig.awards.title = formData.get('title');
            fullConfig.awards.side_image = formData.get('side_image');
            updateBackend('awards', fullConfig.awards);
        };

        function renderHistoryList() {
            const body = document.getElementById('history-list-body');
            const data = fullConfig['history'] || { timeline: [] };
            document.querySelector('#history-form [name="title"]').value = data.title || '';

            body.innerHTML = (data.timeline || []).map((h, i) => `
                <tr>
                    <td><input type="text" class="form-control form-control-sm" value="${h.year}" onchange="fullConfig.history.timeline[${i}].year = this.value"></td>
                    <td>
                        <input type="text" class="form-control form-control-sm mb-1" value="${h.title}" placeholder="Title" onchange="fullConfig.history.timeline[${i}].title = this.value">
                        <textarea class="form-control form-control-sm" rows="2" onchange="fullConfig.history.timeline[${i}].content = this.value">${h.content}</textarea>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmRemoveHistory(${i})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        function confirmRemoveHistory(i) {
            showPremiumDeleteModal(
                null, 
                null, 
                () => {
                    fullConfig.history.timeline.splice(i, 1);
                    renderHistoryList();
                    showToast('Milestone removed (Save to persist)', 'info');
                },
                'dark',
                'global'
            );
        }

        function addHistoryItem() {
            if (!fullConfig.history) fullConfig.history = { timeline: [] };
            fullConfig.history.timeline.push({ year: '2024', title: 'New Era', content: 'Weburea continues to innovate...' });
            renderHistoryList();
        }
        function removeHistoryItem(i) { /* Deprecated */ }

        document.getElementById('history-form').onsubmit = (e) => {
            e.preventDefault();
            fullConfig.history.title = e.target.elements['title'].value;
            updateBackend('history', fullConfig.history);
        };

        function openMediaSelector(type, extra = null) {
            mediaTarget = { type, extra };
            mediaModal.show();
        }

        async function handleFileUpload(input) {
            if (!input.files[0]) return;
            const progress = document.getElementById('upload-progress');
            progress.classList.remove('d-none');
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('media_type', 'about');
            try {
                const res = await fetch('../api/media-manager.php', {
                    method: 'POST',
                    headers: { 'X-API-Key': 'weburea_secret_2026' },
                    body: formData
                });
                const result = await res.json();
                if (result.success) {
                    if (mediaTarget.type === 'team_member') {
                        fullConfig.team_preview.members[mediaTarget.extra].image = result.path;
                        renderTeamList();
                    } else if (mediaTarget.type === 'award_icon') {
                        fullConfig.awards.award_list[mediaTarget.extra].icon = result.path;
                        renderAwardsForm();
                    } else if (mediaTarget.type === 'award_side_image') {
                        fullConfig.awards.side_image = result.path;
                        renderAwardsForm();
                    } else if (mediaTarget.type === 'company_image_1') {
                        document.getElementById('company_image_1_preview').src = '../' + result.path;
                        document.getElementById('company_image_1_input').value = result.path;
                    } else if (mediaTarget.type === 'company_image_2') {
                        document.getElementById('company_image_2_preview').src = '../' + result.path;
                        document.getElementById('company_image_2_input').value = result.path;
                    }
                    mediaModal.hide();
                    showToast('File uploaded', 'success');
                }
            } catch (err) { showToast('Upload failed', 'danger'); }
            finally { progress.classList.add('d-none'); input.value = ''; }
        }

        async function saveSimpleSection(key, form) {
            const formData = new FormData(form);
            const content = Object.fromEntries(formData.entries());
            await updateBackend(key, content);
        }

        async function updateBackend(key, content) {
            try {
                const res = await fetch('../api/about_config.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-API-Key': 'weburea_secret_2026' },
                    body: JSON.stringify({ section_key: key, section_content: content })
                });
                const result = await res.json();
                if (result.success) showToast(result.message, 'success');
            } catch (err) { showToast('Update failed', 'danger'); }
        }

        document.addEventListener('DOMContentLoaded', fetchConfig);
    </script>
    <?php 
        inject_toast_system(); 
        inject_premium_alert_modal();
        inject_premium_delete_modal();
    ?>
</body>
</html>
