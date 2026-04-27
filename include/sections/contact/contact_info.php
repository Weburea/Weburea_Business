<?php
$data = $contact_config['contact_info'] ?? [
    'call_us' => ['icon' => 'bi-telephone', 'title' => 'Call us', 'desc' => 'Speak with a member of our team. We’re always ready to assist you.', 'contact' => '+(251) 854-6308', 'link' => 'tel:+(251)854-6308'],
    'mail_us' => ['icon' => 'bi-envelope', 'title' => 'Mail us', 'desc' => 'We’re prompt and aim to respond to all inquiries within 24 hours.', 'contact' => 'example@gmail.com', 'link' => 'mailto:example@gmail.com'],
    'support' => ['icon' => 'bi-headset', 'title' => 'Support', 'desc' => 'Check out helpful resources, FAQs and developer tools.', 'contact' => 'Chat now', 'link' => '#']
];
?>
<section class="pt-0 mt-n6 mt-lg-n7 mt-xl-n8">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <?php foreach(['call_us' => 'bg-pink', 'mail_us' => 'bg-primary', 'support' => 'bg-warning'] as $key => $color): ?>
            <?php $item = $data[$key] ?? []; ?>
            <div class="col-md-4">
                <div class="card bg-secondary rounded-4 p-4 h-100">
                    <div class="card-body p-0">
                        <div class="icon-lg <?= $color ?> text-white rounded-circle mb-3"><i class="bi <?= htmlspecialchars($item['icon'] ?? '') ?>"></i></div>
                        <h6><?= htmlspecialchars($item['title'] ?? '') ?></h6>
                        <p class="mb-0"><?= htmlspecialchars($item['desc'] ?? '') ?></p>
                    </div>
                    <div class="card-footer bg-transparent p-0 pt-3">
                        <?php if ($key === 'support'): ?>
                        <a class="btn btn-sm btn-white-shadow icon-link icon-link-hover" href="<?= htmlspecialchars($item['link'] ?? '#') ?>"><?= htmlspecialchars($item['contact'] ?? '') ?><i class="bi bi-arrow-right"></i> </a>
                        <?php else: ?>
                        <a href="<?= htmlspecialchars($item['link'] ?? '#') ?>" class="text-primary-grad"><?= htmlspecialchars($item['contact'] ?? '') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
