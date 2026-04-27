<?php 
require_once('../include/db.php');
require_once('../include/auth_check.php');
require_once('../include/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weburea | Newsletter Subscriptions</title>
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
                                <h1 class="h3 mb-1">Newsletter Subscriptions</h1>
                                <p class="mb-0 text-muted">Manage and export your audience data.</p>
                            </div>
                            <button class="btn btn-premium btn-sm shadow-sm" onclick="exportSubscribers()">
                                <i class="bi bi-file-earmark-arrow-down me-2"></i>Export CSV
                            </button>
                        </div>

                        <div id="subscribers_container">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
            loadSubscribers();
        });

        async function loadSubscribers() {
            const container = document.getElementById('subscribers_container');
            container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>`;

            try {
                const response = await fetch('../api/subscribers.php');
                const result = await response.json();
                if (result.success) {
                    renderSubscribersTable(result.data);
                }
            } catch (error) {
                container.innerHTML = `<div class="alert alert-danger">Failed to load subscribers.</div>`;
            }
        }

        function renderSubscribersTable(data) {
            const container = document.getElementById('subscribers_container');
            let rows = data.map(sub => `
                <tr class="align-middle">
                    <td class="ps-4 fw-medium text-dark">${sub.email}</td>
                    <td class="text-muted small">${new Date(sub.created_at).toLocaleDateString()}</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-link text-danger p-0" onclick="deleteSubscriber(${sub.id})"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).join('');

            container.innerHTML = `
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-premium table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 small text-uppercase fw-bold text-secondary">Email Address</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-secondary">Signed Up</th>
                                    <th class="text-end pe-4 py-3 border-0 small text-uppercase fw-bold text-secondary">Action</th>
                                </tr>
                            </thead>
                            <tbody>${rows || '<tr><td colspan="3" class="text-center py-4">No subscribers found</td></tr>'}</tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        async function deleteSubscriber(id) {
            showPremiumDeleteModal(
                'Remove Subscriber?',
                'This will permanently delete this email from your subscription list. This action cannot be undone.',
                async () => {
                    try {
                        const res = await fetch(`../api/subscribers.php?id=${id}`, { method: 'DELETE' });
                        const result = await res.json();
                        if (result.success) {
                            showToast('Subscriber removed', 'success');
                            loadSubscribers();
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

        function exportSubscribers() {
            window.location.href = '../api/subscribers.php?export=csv';
        }
    </script>
    <?php 
        inject_toast_system(); 
        inject_premium_delete_modal(); 
        inject_premium_alert_modal();
    ?>
</body>
</html>
