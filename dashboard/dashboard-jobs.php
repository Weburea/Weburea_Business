<?php 
require_once('../include/db.php');
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weburea | Career Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Dark mode -->
    <script src="assets/js/dark-mode.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon/Vector.ico">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
</head>

<body>
    <?php include 'include/header.php'; ?>

    <main>
        <section class="py-4">
            <div class="container">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h1 class="h3 mb-1">Career Management</h1>
                                <p class="mb-0 text-muted">Manage active job openings and recruitment.</p>
                            </div>
                            <button class="btn btn-primary btn-sm shadow" onclick="showJobModal()">
                                <i class="bi bi-plus-lg me-2"></i>Post New Job
                            </button>
                        </div>

                        <div id="jobs_container">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Job Modal -->
    <div class="modal fade" id="jobModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title fs-6 fw-bold"><i class="bi bi-briefcase me-2"></i>Job Listing Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="jobForm">
                        <input type="hidden" id="job_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Position Title</label>
                                <input type="text" id="job_title" class="form-control bg-light border-0" required placeholder="e.g. Creative Designer">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Department</label>
                                <input type="text" id="job_dept" class="form-control bg-light border-0" required placeholder="e.g. Creative">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Location</label>
                                <input type="text" id="job_loc" class="form-control bg-light border-0" required placeholder="e.g. Remote">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Status</label>
                                <select id="job_status" class="form-select bg-light border-0">
                                    <option value="active">Open / Hiring</option>
                                    <option value="closed">Closed / Filled</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary w-100 mt-4 py-2" onclick="saveJob()">Publish Job Listing</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>

    <script>
        let jobModal;

        document.addEventListener('DOMContentLoaded', function() {
            jobModal = new bootstrap.Modal(document.getElementById('jobModal'));
            loadJobs();
        });

        async function loadJobs() {
            const container = document.getElementById('jobs_container');
            container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>`;

            try {
                const response = await fetch('../api/jobs.php');
                const result = await response.json();
                if (result.success) {
                    renderJobsTable(result.data);
                }
            } catch (error) {
                container.innerHTML = `<div class="alert alert-danger">Failed to load jobs.</div>`;
            }
        }

        function renderJobsTable(data) {
            const container = document.getElementById('jobs_container');
            let rows = data.map(job => `
                <tr class="align-middle">
                    <td class="ps-4 fw-bold text-dark">${job.title}</td>
                    <td><span class="badge bg-light text-dark border">${job.department}</span></td>
                    <td class="text-muted small">${job.location}</td>
                    <td><span class="badge ${job.status === 'active' ? 'bg-success' : 'bg-secondary'}">${job.status.toUpperCase()}</span></td>
                    <td class="text-end pe-4">
                        <button class="btn btn-link text-primary p-0 me-2" onclick='editJob(${JSON.stringify(job)})'><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-link text-danger p-0" onclick="deleteJob(${job.id})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');

            container.innerHTML = `
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-premium table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 small text-uppercase fw-bold text-secondary">Position</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-secondary">Department</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-secondary">Location</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-secondary">Status</th>
                                    <th class="text-end pe-4 py-3 border-0 small text-uppercase fw-bold text-secondary">Action</th>
                                </tr>
                            </thead>
                            <tbody>${rows || '<tr><td colspan="5" class="text-center py-4">No active job listings</td></tr>'}</tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        function showJobModal() {
            document.getElementById('jobForm').reset();
            document.getElementById('job_id').value = '';
            jobModal.show();
        }

        function editJob(data) {
            document.getElementById('job_id').value = data.id;
            document.getElementById('job_title').value = data.title;
            document.getElementById('job_dept').value = data.department;
            document.getElementById('job_loc').value = data.location;
            document.getElementById('job_status').value = data.status;
            jobModal.show();
        }

        async function saveJob() {
            const id = document.getElementById('job_id').value;
            const payload = {
                id: id,
                title: document.getElementById('job_title').value,
                department: document.getElementById('job_dept').value,
                location: document.getElementById('job_loc').value,
                status: document.getElementById('job_status').value
            };

            try {
                const res = await fetch('../api/jobs.php', {
                    method: id ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await res.json();
                if (result.success) {
                    jobModal.hide();
                    showToast(result.message, 'success');
                    loadJobs();
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (e) { showToast('Operation failed', 'danger'); }
        }

        async function deleteJob(id) {
            showPremiumDeleteModal(
                'Retract Job Posting?',
                'This will permanently remove this listing from the career page. This action cannot be reversed.',
                async () => {
                    try {
                        const res = await fetch(`../api/jobs.php?id=${id}`, { method: 'DELETE' });
                        const result = await res.json();
                        if (result.success) {
                            showToast('Job listing removed', 'success');
                            loadJobs();
                        } else {
                            showToast(result.message, 'danger');
                        }
                    } catch (error) { 
                        showToast('Action failed', 'danger'); 
                    }
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
