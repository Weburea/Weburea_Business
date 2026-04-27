<!-- Hero START -->
<section class="position-relative pt-sm-8 pt-lg-9 pb-0 overflow-hidden">
    <!-- Right side svg decoration -->
    <div class="position-absolute top-0 end-0 z-index-2 mt-7 me-n9 d-none d-md-block">
        <img src="assets/images/elements/grad-shape/05.png" class="rotate-180" alt="">
    </div>

    <!-- Blur decoration -->
    <div class="position-absolute top-0 start-0 ms-n4 mt-7">
        <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-7 opacity-1"
            alt="Grad shape">
    </div>

    <div class="container position-relative z-index-2 pt-4 pb-5 pb-lg-8">
        <!-- Breadcrumb -->
        <nav class="mb-2" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About us</li>
            </ol>
        </nav>

        <!-- Title -->
        <h1><?php echo htmlspecialchars($hero['main_title_line1'] ?? 'Creativity'); ?></h1>
        <h6 class="display-1"><span class="text-primary"><?php echo htmlspecialchars($hero['main_title_highlight'] ?? 'in Motion'); ?></span></h6>

        <!-- Content -->
        <div class="d-lg-flex justify-content-end align-items-start gap-3 mt-4 mt-sm-5">
            <p class="inner-container-small border-purple border-2 border-start mx-0 ps-2"><?php echo htmlspecialchars($hero['lead_text'] ?? ''); ?></p>
            <a class="btn btn-light icon-link icon-link-hover mt-2" href="<?php echo htmlspecialchars($hero['btn_link'] ?? 'team.php'); ?>"><?php echo htmlspecialchars($hero['btn_text'] ?? 'Meet our team'); ?><i
                    class="bi bi-arrow-right"></i> </a>
        </div>
    </div>

    <!-- Image -->
    <div class="bg-secondary-grad position-relative pb-5 pb-lg-8 px-2 px-md-5">
        <!-- Blur divider -->
        <div class="bg-body blur-5 h-300px w-100 position-absolute top-0 start-0 mt-n5"></div>
        <!-- Main image -->
        <div class="h-300px h-md-500px h-xl-700px z-index-2 position-relative rounded-4"
            style="background:url(<?php echo htmlspecialchars($hero['bg_image'] ?? 'assets/images/bg/06.png'); ?>) no-repeat; background-size:cover; background-position:top;">
        </div>
    </div>
</section>
<!-- Hero END -->
