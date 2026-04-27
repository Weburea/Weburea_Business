<?php
$data = $contact_config['contact_form'] ?? [
    'title' => 'Say Hello',
    'subtitle' => 'Have an idea, need advice, or just want to say hello? We’re all ears.',
    'typed_words' => 'Hello&&Hola&&Ciao&&Bonjour',
    'social_links' => ['facebook' => '#', 'instagram' => '#', 'twitter' => '#', 'linkedin' => '#']
];
$titleParts = explode(' ', $data['title'] ?? 'Say Hello');
$firstWord = array_shift($titleParts);
?>
<section class="position-relative pt-0">
    <div class="container bg-secondary-grad rounded-4 p-4 p-md-6 p-xxl-8">
        <div class="position-absolute bottom-0 end-0 mb-n3 me-n7 d-none d-xl-block">
            <img src="assets/images/elements/relex-slay.png" class="h-400px h-xxl-500px rtl-flip" alt="image">
        </div>
        <div class="inner-container-small">
            <h1 class="fw-bold mb-2 lh-base text-center"><i class="bi bi-emoji-smile me-2"></i><?= htmlspecialchars($firstWord) ?>
                <span class="cd-headline clip big-clip is-full-width text-primary-grad mb-0">
                    <span class="typed" data-type-text="<?= htmlspecialchars($data['typed_words'] ?? '') ?>"></span>
                </span>
            </h1>
            <p class="text-center"><?= htmlspecialchars($data['subtitle'] ?? '') ?></p>

            <form id="contactForm" class="row form-border-transparent g-3 mt-4" novalidate>
                <div class="col-md-6">
                    <label class="form-label">Your name <span class="text-primary">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required minlength="3">
                    <div class="invalid-feedback">Please enter your name (at least 3 characters).</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email address <span class="text-primary">*</span></label>
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile number</label>
                    <input type="tel" name="mobile" class="form-control" placeholder="+234 ...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="What is this about?">
                </div>
                <div class="col-12">
                    <label class="form-label">Message <span class="text-primary">*</span></label>
                    <textarea class="form-control" name="message" id="floatingTextarea2" style="height: 100px" placeholder="Your message here..." required minlength="10"></textarea>
                    <div class="invalid-feedback">Please enter a message (at least 10 characters).</div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input border" id="exampleCheck1" required>
                        <label class="form-check-label" for="exampleCheck1">I agree that my data is <a href="privacy.php" class="hover-underline-animation text-primary-hover">collected and stored</a>.</label>
                        <div class="invalid-feedback">You must agree to the terms.</div>
                    </div>
                </div>
                <div class="col-12 d-sm-flex align-items-center gap-3 mt-4">
                    <button type="submit" class="btn btn-primary mb-2 mb-md-0" id="btnSubmitContact">
                        <span class="btn-text">Send a message</span>
                        <span class="spinner-border spinner-border-sm d-none mx-2" role="status" aria-hidden="true"></span>
                    </button>
                    <ul class="list-inline mb-0 ms-auto">
                        <li class="list-inline-item small heading-color">Connect with:</li>
                        <?php if(!empty($data['social_links']['facebook']) && $data['social_links']['facebook'] !== '#'): ?>
                        <li class="list-inline-item"> <a href="<?= htmlspecialchars($data['social_links']['facebook']) ?>" class="heading-color text-primary-hover"><i class="bi bi-facebook"></i></a> </li>
                        <?php endif; ?>
                        <?php if(!empty($data['social_links']['instagram']) && $data['social_links']['instagram'] !== '#'): ?>
                        <li class="list-inline-item"> <a href="<?= htmlspecialchars($data['social_links']['instagram']) ?>" class="heading-color text-primary-hover"><i class="bi bi-instagram"></i></a> </li>
                        <?php endif; ?>
                        <?php if(!empty($data['social_links']['twitter']) && $data['social_links']['twitter'] !== '#'): ?>
                        <li class="list-inline-item"> <a href="<?= htmlspecialchars($data['social_links']['twitter']) ?>" class="heading-color text-primary-hover"><i class="bi bi-twitter-x"></i></a> </li>
                        <?php endif; ?>
                        <?php if(!empty($data['social_links']['linkedin']) && $data['social_links']['linkedin'] !== '#'): ?>
                        <li class="list-inline-item"> <a href="<?= htmlspecialchars($data['social_links']['linkedin']) ?>" class="heading-color text-primary-hover"><i class="bi bi-linkedin"></i></a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Include Modal API dependencies -->
<?php 
require_once('include/alerts.php');
inject_premium_alert_modal();
inject_toast_system();
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    if(contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Premium Frontend Validation
            if (!this.checkValidity()) {
                showPremiumAlert(
                    'Incomplete Form',
                    'Please fill in all required fields and accept the privacy terms before sending.',
                    'warning',
                    'Got it',
                    'contact'
                );
                this.classList.add('was-validated');
                return;
            }

            const btn = document.getElementById('btnSubmitContact');
            const spinner = btn.querySelector('.spinner-border');
            const btnText = btn.querySelector('.btn-text');
            
            btn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.innerText = 'Sending...';
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const res = await fetch('api/submit_contact.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await res.json();
                
                if (result.success) {
                    showPremiumAlert(null, null, 'success', null, 'contact');
                    contactForm.reset();
                    contactForm.classList.remove('was-validated');
                } else {
                    showPremiumAlert(
                        'Submission Failed',
                        result.message || 'We encountered an error processing your request.',
                        'warning',
                        'Try Again',
                        'contact'
                    );
                }
            } catch (err) {
                showPremiumAlert(
                    'Connection Error',
                    'Could not reach the server. Please check your internet connection.',
                    'warning',
                    'Close',
                    'contact'
                );
            } finally {
                btn.disabled = false;
                spinner.classList.add('d-none');
                btnText.innerText = 'Send a message';
            }
        });
    }
});
</script>
