<!DOCTYPE html>
<html lang="en">

<head>

    <title>Our Services — Weburea Agency</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea Agency">
    <meta name="description"
        content="Explore Weburea Agency's professional services: UI/UX Design, Branding, Motion Graphics, QA Testing, and Web Development. Delivering creativity in motion.">

    <!-- Dark mode -->
    <?php include('include/dark_mode.php') ?>

    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <?php
    // We already have $pdo from front_header.php
    try {
        $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id ASC");
        $all_services_list = $stmt->fetchAll();
    } catch (Exception $e) {
        $all_services_list = [];
    }
    ?>

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <section class="bg-secondary-grad position-relative pt-xl-8 overflow-hidden">
            <!-- Curve decoration -->
            <span>
                <svg class="position-absolute bottom-0 start-0 mb-n3 z-index-2" viewBox="0 0 1950 178"
                    style="enable-background:new 0 0 1950 178;">
                    <path class="fill-body"
                        d="M1480.3,21.8c238.7-17.4,359.6,39,469.7,74.4V178H0v-54.2V4.4c57.3,38.5,287.7,14.6,446.4,0 c170.6-15.7,342.3,14.5,440.8,33C1104,78,1274.8,36.9,1480.3,21.8z" />
                </svg>
            </span>
            <!-- Patten decoration -->
            <div class="position-absolute end-0 top-0 rotate-180 mt-n5 me-n9">
                <img src="assets/images/elements/geo-grad-pattern.svg" class="h-700px opacity-1" alt="bg pattern">
            </div>
            <!-- Patten decoration -->
            <div class="position-absolute start-0 bottom-0 mb-8 ms-n7">
                <img src="assets/images/elements/geo-grad-pattern.svg" class="h-400px opacity-1" alt="bg pattern">
            </div>

            <!-- Grad blur -->
            <div class="position-absolute top-0 start-50 mt-n9 ms-n9">
                <img src="assets/images/elements/grad-shape/blur-decoration.svg" class="blur-8 opacity-1"
                    alt="Grad shape">
            </div>

            <div class="container position-relative pt-4 pt-sm-5 pb-5 pb-lg-8">
                <!-- Breadcrumb -->
                <nav class="mb-2 d-flex justify-content-center" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
                    </ol>
                </nav>

                <!-- Title -->
                <h1 class="mb-4 text-center">Our Services</h1>

                <!-- Services START -->
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <div class="row g-4 g-lg-5">
                            <?php 
                            $count = 0;
                            foreach($all_services_list as $service): 
                                $is_even = ($count % 2 == 0);
                                $container_class = $is_even ? "col-xl-11" : "col-xl-11 ms-auto";
                                $why_choose = json_decode($service['why_choose_json'], true);
                                $count++;
                            ?>
                            <!-- Service item START -->
                            <div class="<?php echo $container_class; ?>">
                                <div class="card card-hover-shadow card-hover-transition shadow-primary-sm bg-body bg-opacity-75 bg-blur rounded-4 p-3 p-lg-4">
                                    <div class="row g-0">
                                        <div class="col-md-5">
                                            <!-- Image -->
                                            <video class="card-img mb-3 mb-md-0 rounded-4 w-100 h-100"
                                                style="object-fit: cover;" autoplay loop muted playsinline>
                                                <source src="<?php echo $service['hero_video']; ?>" type="video/mp4">
                                            </video>
                                        </div>
                                        <div class="col-md-7">
                                            <!-- Content -->
                                            <div class="card-body d-flex flex-column h-100 px-2 px-md-4 py-0 py-md-2">
                                                <!-- Title -->
                                                <h5 class="card-title mt-2 mt-md-0"><?php echo $service['name']; ?></h5>
                                                <p class="card-text small"><?php echo $service['description_short']; ?></p>

                                                <!-- List (Why Choose Us items) -->
                                                <ul class="list-inline d-flex flex-wrap gap-2 mb-3">
                                                    <?php if($why_choose): foreach($why_choose as $item): ?>
                                                    <li class="list-inline-item heading-color small"> 
                                                        <i class="bi bi-check-circle text-success me-1"></i>
                                                        <?php echo $item['title']; ?>
                                                    </li>
                                                    <?php endforeach; endif; ?>
                                                </ul>

                                                <!-- Button links -->
                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <a class="icon-link icon-link-hover"
                                                        href="single_services.php?slug=<?php echo $service['slug']; ?>">View detail<i
                                                            class="bi bi-arrow-right"></i> </a>
                                                    <a class="icon-link icon-link-hover"
                                                        href="main-pricing.php?service=<?php echo $service['slug']; ?>">View Pricing<i
                                                            class="bi bi-arrow-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Service item END -->
                            <?php endforeach; ?>


                        </div>
                    </div>
                </div>
                <!-- Services END -->
            </div>
        </section>
        <!-- =======================
Hero END -->

        <!-- =======================
Step START -->
        <section class="pt-md-0 overflow-hidden">
            <div class="container">
                <h2 class="text-center mb-6">How we build meaningful experiences</h2>

                <div class="row position-relative g-6 g-lg-7">
                    <div class="col-md-4 mt-md-8">
                        <div class="card card-body bg-secondary bg-opacity-75 text-center rounded-4 p-4">
                            <div
                                class="icon-lg bg-primary rounded-circle text-white mx-auto position-absolute top-0 start-50 translate-middle mt-n2">
                                01</div>
                            <h6 class="mt-4">Discovery & Strategy</h6>
                            <p class="mb-0">We dig deep into your goals and audience to build a strategy, not just a
                                design.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-body bg-secondary bg-opacity-75 text-center rounded-4 p-4">
                            <div
                                class="icon-lg bg-pink rounded-circle text-white mx-auto position-absolute top-0 start-50 translate-middle mt-n2">
                                02</div>
                            <h6 class="mt-4">We Create</h6>
                            <p class="mb-0">From motion graphics to code, we execute the plan with transparency and
                                regular updates.</p>
                        </div>
                    </div>

                    <div class="col-md-4 mt-md-8">
                        <div class="card card-body bg-secondary bg-opacity-75 text-center rounded-4 p-4">
                            <div
                                class="icon-lg bg-purple rounded-circle text-white mx-auto position-absolute top-0 start-50 translate-middle mt-n2">
                                03</div>
                            <h6 class="mt-4">Launch & Scale</h6>
                            <p class="mb-0">We deliver the final product and provide the tools or support you need to
                                grow.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Step END -->

        <!-- =======================
Left right content START -->
        <section class="py-0">
            <div class="container">
                <div class="row align-items-center align-items-xl-end">
                    <div class="col-md-5 mb-9 mb-md-0">
                        <h2 class="mb-4">Elevate your brand with <span class="text-primary">comprehensive
                                solutions</span></h2>
                        <p class="mb-3">From the first sketch to the final bug test, we handle the entire digital
                            lifecycle so you can focus on growth.</p>
                        <ul class="list-group list-group-borderless mb-4">
                            <li class="list-group-item heading-color d-flex pb-0"><i
                                    class="bi bi-patch-check text-success me-2"></i>UI/UX & Brand Identity</li>
                            <li class="list-group-item heading-color d-flex pb-0"><i
                                    class="bi bi-patch-check text-success me-2"></i>Web Development & QA Testing</li>
                            <li class="list-group-item heading-color d-flex pb-0"><i
                                    class="bi bi-patch-check text-success me-2"></i>Motion Graphics & Video Editing</li>
                            <li class="list-group-item heading-color d-flex pb-0"><i
                                    class="bi bi-patch-check text-success me-2"></i>Digital Marketing Strategy</li>
                        </ul>
                        <a class="btn btn-dark icon-link icon-link-hover" href="work.php">See what we've
                            built<i class="bi bi-arrow-right"></i> </a>
                    </div>
                    <div class="col-md-6 ms-auto">
                        <div class="bg-secondary bg-opacity-50 rounded-4">
                            <img src="assets/images/elements/service-2.png" class="mt-n8" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Left right content END -->

        <!-- =======================
Contact us START-->
        <section class="pb-0 overflow-hidden">
            <div class="bg-secondary-grad position-relative pb-8">
                <!-- Skew bg decoration -->
                <span>
                    <svg class="position-abslolute top-0 start-0 mt-n3 mt-sm-n1" viewBox="0 0 1920 108"
                        style="enable-background:new 0 0 1920 108;" xml:space="preserve">
                        <path class="fill-body" d="M0,0l1920,1.5V108L0,0z" />
                    </svg>
                </span>

                <div class="container position-relative pt-5 pt-lg-0">
                    <div class="row align-items-center g-4">
                        <!-- Content -->
                        <div class="col-lg-5">
                            <span class="hand-wave-animate h2">🖐️</span>
                            <h2 class="mb-3 h1">Say Hello</h2>
                            <p>Our friendly team is ready to assist you with whatever you need.</p>

                            <!-- Contact info -->
                            <div class="row row-cols-1 row-cols-sm-2 g-4 mt-3 mt-md-5">
                                <!-- Call us -->
                                <div class="col">
                                    <span class="fs-3 text-primary-grad"><i class="bi bi-headset"></i></span>
                                    <h6 class="my-2 my-sm-3">Call us</h6>
                                    <p class="mb-2">Let's work together towards a common goal - get in touch!</p>
                                    <a href="https://wa.me/2348053964571"
                                        class="heading-color hover-underline-animation">+234 8053 964 571</a>
                                </div>

                                <!-- Email us -->
                                <div class="col">
                                    <span class="fs-3 text-primary-grad"><i class="bi bi-envelope"></i></span>
                                    <h6 class="my-2 my-sm-3">Email us</h6>
                                    <p class="mb-2">We respond to all inquiries within 24 hours.</p>
                                    <a href="mailto:webureaagency@gmail.com"
                                        class="heading-color hover-underline-animation">webureaagency@gmail.com</a>
                                </div>
                            </div>
                        </div>

                        <!-- Contact form -->
                        <div class="col-lg-6 ms-auto mt-5 mt-lg-n7">
                            <div class="card card-body rounded-4 shadow-primary-lg p-4">
                                <form class="row form-border-transparent g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">First name</label>
                                        <input type="text" class="form-control bg-secondary">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Last name</label>
                                        <input type="text" class="form-control bg-secondary">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control bg-secondary" id="floatingInput">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mobile number</label>
                                        <input type="text" class="form-control bg-secondary">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Subject</label>
                                        <input type="text" class="form-control bg-secondary">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control bg-secondary" id="floatingTextarea2"
                                            style="height: 150px"></textarea>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <!-- Button -->
                                        <button class="btn btn-primary mb-2 mb-md-0">Send a message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
Contact us END-->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <!-- =======================
Footer START -->
    <?php include('include/front_footer.php') ?>
    <!-- =======================
Footer END -->

    <!-- Back to top -->
    <div class="back-top"></div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>