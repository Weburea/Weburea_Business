<!-- Team START -->
<section class="bg-secondary position-relative overflow-hidden py-0">
    <!-- Curve bg -->
    <span class="position-absolute start-0 bottom-0 mb-n1">
        <svg class="fill-body" width="1950" height="237" viewBox="0 0 1950 237" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0 236.442H1949.5V72.4424C1232.3 -58.7576 351 17.7757 0 72.4424V236.442Z" />
        </svg>
    </span>

    <div class="container-fluid position-relative">
        <!-- Rocket vector -->
        <div class="position-absolute end-0 bottom-0 me-6 z-index-9 d-none d-lg-block">
            <img src="assets/images/elements/rocket-03.png" class="h-200px" alt="rocket image">
        </div>

        <div class="max-width-1550 bg-dark position-relative rounded-4 overflow-hidden py-5 py-sm-6 py-lg-8"
            data-bs-theme="dark">
            <!-- Blur decoration -->
            <div class="position-absolute top-0 start-50 translate-middle">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9"
                    alt="Grad shape">
            </div>

            <!-- Blur decoration -->
            <div class="position-absolute bottom-0 start-0 mb-n8 ms-n5">
                <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-7 opacity-2"
                    alt="Grad shape">
            </div>

            <div class="container position-relative">
                <!-- Title -->
                <h2 class="text-center mb-4 mb-md-6"><?php echo htmlspecialchars($team_preview['title'] ?? 'Meet our creative team'); ?></h2>

                <div
                    class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
                    <?php 
                    $members = $team_preview['members'] ?? [];
                    if (!empty($members)):
                        foreach ($members as $member):
                    ?>
                    <!-- Team item -->
                    <div class="col">
                        <div class="card card-body bg-transparent text-center p-0">
                            <!-- Image -->
                            <div class="avatar avatar-xxl mx-auto flex-shrink-0 mb-3">
                                <img class="avatar-img rounded-circle" src="<?php echo htmlspecialchars($member['image'] ?? 'assets/images/team/01.jpg'); ?>"
                                    alt="avatar">
                            </div>

                            <!-- Content -->
                            <h6 class="mb-1"><a href="#"><?php echo htmlspecialchars($member['name'] ?? ''); ?></a></h6>
                            <small><?php echo htmlspecialchars($member['role'] ?? ''); ?></small>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else:
                        // Fallback if no members in DB
                        for ($i = 1; $i <= 5; $i++):
                    ?>
                    <!-- Team item fallback -->
                    <div class="col">
                        <div class="card card-body bg-transparent text-center p-0">
                            <div class="avatar avatar-xxl mx-auto flex-shrink-0 mb-3">
                                <img class="avatar-img rounded-circle" src="assets/images/team/0<?php echo $i; ?>.jpg"
                                    alt="avatar">
                            </div>
                            <h6 class="mb-1"><a href="#">Team Member</a></h6>
                            <small>Position</small>
                        </div>
                    </div>
                    <?php 
                        endfor;
                    endif; 
                    ?>
                </div> <!-- Row END -->

                <!-- Buttons -->
                <div class="text-center d-inline-flex flex-column align-items-center gap-2 w-100 mt-5">
                    <a href="contact-us.html" class="btn btn-primary-grad">Connect with our team</a>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Team END -->
