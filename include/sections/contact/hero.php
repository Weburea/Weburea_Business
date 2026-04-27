<?php
$data = $contact_config['hero'] ?? [
    'icon' => '👋',
    'title' => "Let's Connect",
    'subtitle' => "We’re here to help",
    'support_hours' => "24/7"
];
?>
<section class="bg-dark position-relative overflow-hidden pt-xl-8" data-bs-theme="dark">
    <!-- Blur decoration -->
    <div class="position-absolute bottom-0 end-0 mb-n9">
        <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9" alt="Grad shape">
    </div>

    <div class="container position-relative pt-4 pt-sm-5">
        <!-- Title and content -->
        <span class="h1"><?= htmlspecialchars($data['icon'] ?? '👋') ?></span>
        <h1 class="display-5 mt-3"><?= htmlspecialchars($data['title'] ?? '') ?></h1>

        <p class="mb-1"><?= htmlspecialchars($data['subtitle'] ?? '') ?></p>
        <p>Support hours: <span class="text-primary fw-bold"><?= htmlspecialchars($data['support_hours'] ?? '') ?></span></p>
    </div>
</section>
