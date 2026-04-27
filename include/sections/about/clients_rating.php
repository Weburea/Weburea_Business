<!-- Client and rating START -->
<section class="bg-secondary-grad pt-1">
    <div class="container">
        <div class="row g-4">
            <!-- Title and clients -->
            <div class="col-md-7 mb-3 mb-md-0">
                <h3 class="mb-4 mb-sm-5 pe-7">Join over <span class="text-purple">1,000+</span> companies using
                    Weburea</h3>
                <!-- Client logos -->
                <div class="d-flex flex-wrap gap-4 gap-sm-5">
                    <?php for($i=1; $i<=8; $i++): ?>
                    <!-- Item -->
                    <div class="swap-logo">
                        <img src="assets/images/client/logo-gray/0<?php echo $i; ?>.svg" class="h-30px" alt="client-img">
                        <div class="swap-item">
                            <img src="assets/images/client/logo-light/0<?php echo $i; ?>.svg" class="dark-mode-item h-30px"
                                alt="client logo">
                            <img src="assets/images/client/logo-dark/0<?php echo $i; ?>.svg" class="light-mode-item h-30px"
                                alt="client logo">
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Ratings and button -->
            <div class="col-md-5 col-lg-4 ms-auto">
                <div class="d-flex gap-4 gap-lg-2 flex-wrap mb-4">
                    <!-- Apple rating -->
                    <div>
                        <!-- Icon -->
                        <img src="assets/images/elements/apple.svg" class="icon-lg mb-3" alt="">
                        <!-- Rating -->
                        <ul class="list-inline mb-1">
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-half text-warning"></i></li>
                        </ul>
                        <span>4.8 stars on App Store</span>
                    </div>

                    <!-- Google rating -->
                    <div class="ms-xl-auto">
                        <!-- Icon -->
                        <img src="assets/images/elements/gicon.svg" class="icon-lg mb-3" alt="">
                        <!-- Rating -->
                        <ul class="list-inline mb-1">
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-fill text-warning"></i></li>
                            <li class="list-inline-item me-0"><i class="bi bi-star-half text-warning"></i></li>
                        </ul>
                        <span>4.6 stars on Google</span>
                    </div>
                </div>
                <!-- Button -->
                <a class="btn btn-outline-primary icon-link icon-link-hover mt-2" href="contact-us.html">Join
                    our community<i class="bi bi-arrow-right"></i> </a>
            </div>
        </div>
    </div>
</section>
<!-- Client and rating END -->
