<!DOCTYPE html>
<html lang="en">

<head>

    <title><?php echo $article_title; ?> | Weburea Agency Insights</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weburea Agency">

    <meta name="description" content="<?php echo $article_summary; ?>">

    <meta name="keywords"
        content="Weburea Blog, UI UX Design, Web Development, QA Testing, Branding, Digital Strategy, Tech Insights">

    <meta property="og:type" content="article">
    <meta property="og:title" content="<?php echo $article_title; ?>">
    <meta property="og:description" content="<?php echo $article_summary; ?>">
    <meta property="og:image" content="<?php echo $article_image_url; ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo $article_title; ?>">
    <meta property="twitter:description" content="<?php echo $article_summary; ?>">

    <?php include('include/dark_mode.php') ?>

    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body>

    <!-- Header START -->
    <?php include('include/front_header.php') ?>
    <!-- Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Blog detail START -->
        <section class="position-relative overflow-hidden pt-xl-8">
            <!-- Blur decoration START -->
            <div class="position-absolute start-0 top-0">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg"
                    class="opacity-1 blur-9 h-300px rotate-335" alt="Grad shape">
            </div>

            <div class="position-absolute end-0 top-0">
                <img src="assets/images/elements/grad-shape/blur-decoration-2.svg"
                    class="opacity-1 blur-8 h-300px rotate-335" alt="Grad shape">
            </div>
            <!-- Blur decoration END -->

            <div class="container position-relative pt-4 pt-sm-5">
                <div class="row">
                    <!-- Title -->
                    <div class="col-lg-8 mx-auto text-center mb-4 mb-sm-6">
                        <a href="#" class="badge text-bg-dark mb-4">Lifestyle</a>
                        <h1 class="h2 mb-0">Building a strong identity for your business</h1>
                    </div>

                    <!-- Image -->
                    <div class="col-12 mx-auto text-center mb-4 mb-sm-6">
                        <img src="assets/images/blog/blog-detail.jpg" class="img-fluid rounded" alt="blog-img">
                    </div>

                    <!-- Detail START -->
                    <div class="col-md-11 mx-auto mb-4 mb-sm-6">
                        <div class="row">
                            <div class="col-md-4 text-center mb-6 mb-md-0">
                                <!-- Avatar -->
                                <div class="avatar avatar-xxl mx-auto flex-shrink-0 mb-3">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg"
                                        alt="avatar">
                                </div>
                                <p class="mb-1 opacity-6">Word by</p>
                                <h6 class="mb-3">Joan Wallace</h6>

                                <!-- Action -->
                                <div class="d-flex justify-content-center align-items-center flex-wrap">
                                    <!-- Like -->
                                    <a href="#" class="text-primary-hover mb-0"><i class="bi bi-heart me-2"></i>20</a>

                                    <!-- Divider -->
                                    <span class="vr mx-3"></span>

                                    <!-- Comment -->
                                    <a href="#" class="text-primary-hover mb-0"><i class="bi bi-chat me-2"></i>5</a>

                                    <!-- Divider -->
                                    <span class="vr mx-3"></span>

                                    <!-- Share button -->
                                    <div class="dropdown">
                                        <a href="#" class="text-primary-hover" id="cardFeedAction"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-share me-2"></i>14
                                        </a>
                                        <!-- Card feed action dropdown menu -->
                                        <ul class="dropdown-menu min-w-auto" aria-labelledby="cardFeedAction">
                                            <li><a class="dropdown-item" href="#"> <i
                                                        class="bi bi-facebook fa-fw me-2"></i>Facebook</a></li>
                                            <li><a class="dropdown-item" href="#"> <i
                                                        class="bi bi-instagram fa-fw me-2"></i>Instagram</a></li>
                                            <li><a class="dropdown-item" href="#"> <i
                                                        class="bi bi-whatsapp fa-fw me-2"></i>Whatsapp</a></li>
                                            <li><a class="dropdown-item" href="#"> <i
                                                        class="bi bi-copy fa-fw me-2"></i>Copy link</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-7 ms-auto">
                                <p><span
                                        class="dropcap heading-color bg-secondary bg-opacity-50 rounded px-2">T</span>he
                                    simple act of cultivating gratitude has the remarkable ability to bring joy and
                                    abundance into our lives, shifting our perspective from lack to abundance. In this
                                    article, we will explore the power of gratitude and how it can enhance our overall
                                    well-being and create a positive ripple effect in our lives and the lives of those
                                    around us. <strong>In a world filled with chaos</strong> and uncertainty, it's easy
                                    to lose sight of the things that truly matter.</p>
                                <p>Additionally, expressing gratitude to others through acts of kindness or <u>
                                        heartfelt appreciation strengthens our relationships and</u> fosters a sense of
                                    interconnectedness.</p>
                                <p class="mb-0">By reframing obstacles as opportunities for growth and learning,
                                    <mark>we can navigate through difficulties with</mark> a sense of gratitude for the
                                    lessons they bring. This mindset shift empowers us to find joy and meaning in every
                                    circumstance, leading to a more fulfilling and purposeful life.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Detail END -->

                    <!-- Images -->
                    <div class="col-12 mb-4 mb-sm-6">
                        <div class="row g-4 g-lg-6">
                            <div class="col-sm-4">
                                <a href="assets/images/blog/4by4/01.jpg" data-glightbox="" data-gallery="image-popup">
                                    <img src="assets/images/blog/4by4/01.jpg" class="rounded h-100" alt="blog-img">
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a href="assets/images/blog/4by4/03.jpg" data-glightbox="" data-gallery="image-popup">
                                    <img src="assets/images/blog/4by4/03.jpg" class="rounded h-100" alt="blog-img">
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a href="assets/images/blog/4by4/04.jpg" data-glightbox="" data-gallery="image-popup">
                                    <img src="assets/images/blog/4by4/04.jpg" class="rounded h-100" alt="blog-img">
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- List content -->
                    <div class="col-lg-10 mx-auto mb-4 mb-sm-6">
                        <h6>Step 1: Shifting Perspective: From Lack to Abundance</h6>
                        <p class="mb-5">Gratitude has the unique ability to shift our perspective from focusing on what
                            we lack to appreciating what we have. Often, we get caught up in the pursuit of material
                            possessions or achievements, believing that they will bring us happiness. However, true
                            abundance is found in appreciating the present moment and recognizing the blessings that
                            already exist in our lives. Cultivating gratitude allows us to break free from the cycle of
                            perpetual longing and embrace the abundance that surrounds us.</p>

                        <h6>Step 2: The Ripple Effect of Gratitude</h6>
                        <!-- List -->
                        <ul class="ps-4 mb-5">
                            <li class="mb-2">Shift in Perspective: Gratitude allows us to shift our perspective from
                                focusing on what we lack to appreciating what we have. </li>

                            <li class="mb-2">By recognizing and acknowledging the blessings in our lives, we invite a
                                sense of abundance and contentment.</li>
                            <li class="mb-2">Scientific research has demonstrated that gratitude positively impacts our
                                mental and physical health. </li>
                            <ul>
                                <li class="mb-2">It allows us to focus on the positive aspects.</li>
                                <li class="mb-2">It enables us to reframe obstacles as opportunities.</li>
                                <li class="mb-2">The power of gratitude extends beyond ourselves.</li>
                            </ul>
                            <li class="mb-2">Enables us to reframe obstacles as opportunities for growth and learning.
                                By embracing a mindset of gratitude.</li>
                            <li class="mb-2">Recognizing and acknowledging the blessings in our lives, we invite a sense
                                of abundance and contentment.</li>
                        </ul>

                        <!-- Blockquote -->
                        <blockquote class="card card-body bg-secondary bg-opacity-50 overflow-hidden p-sm-5 mb-5">
                            <!-- Vertical line -->
                            <div class="vr bg-primary-grad h-100 position-absolute top-0 start-0"
                                style="width: 3px; opacity:100%"></div>

                            <!-- Quote icon -->
                            <span class="display-4 text-primary position-absolute top-0 start-0 opacity-1 mt-n3"><i
                                    class="bi bi-quote"></i></span>

                            <q class="fs-6 heading-color">Fulfilled direction use continual set him propriety continued.
                                Farther-related bed and passage comfort civilly. Concluded boy perpetual old
                                supposing.</q>
                            <div class="blockquote-footer mb-0 mt-3">
                                Albert Schweitzer
                            </div>
                        </blockquote>

                        <!-- Tags -->
                        <div class="align-items-center mb-5">
                            <h6>Popular Tags:</h6>
                            <ul class="list-inline d-flex flex-wrap gap-2 mb-0">
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0"
                                        href="#">blog</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0"
                                        href="#">business</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0"
                                        href="#">bootstrap</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0" href="#">data
                                        science</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0" href="#">deep
                                        learning</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0" href="#">deep
                                        learning</a> </li>
                                <li class="list-inline-item"> <a class="btn btn-secondary btn-sm mb-lg-0" href="#">deep
                                        learning</a> </li>
                            </ul>
                        </div>

                        <!-- Helpful box -->
                        <div
                            class="bg-secondary bg-opacity-50 rounded d-md-flex justify-content-between align-items-center text-center px-4 py-3">
                            <!-- Title -->
                            <h6 class="mb-0">Was this article helpful?</h6>
                            <small class="py-3 p-md-0 d-block">25 out of 78 found this helpful</small>
                            <!-- Check buttons -->
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <!-- Yes button -->
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1">
                                <label class="btn btn-outline-primary btn-sm mb-0" for="btnradio1"><i
                                        class="bi bi-hand-thumbs-up"></i> Yes</label>
                                <!-- No button -->
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                                <label class="btn btn-outline-primary btn-sm mb-0" for="btnradio2"> No <i
                                        class="bi bi-hand-thumbs-down"></i></label>
                            </div>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="col-lg-10 mx-auto mb-4">
                        <hr class="mb-4 mb-sm-6"> <!-- Divider -->
                        <!-- Title -->
                        <h5>3 comments</h5>

                        <!-- Comment level 1-->
                        <div class="my-4 d-flex">
                            <img class="avatar avatar-md rounded-circle me-3" src="assets/images/avatar/01.jpg"
                                alt="avatar">
                            <div>
                                <div class="mb-2">
                                    <h6 class="m-0">Frances Guerrero</h6>
                                    <span class="me-3 small">June 11, 2021 at 6:01 am</span>
                                </div>
                                <p class="mb-2">Satisfied conveying a dependent contented he gentleman agreeable do be.
                                    Warrant private blushes removed an in equally totally if. Delivered dejection
                                    necessary objection do Mr prevailed. Mr feeling does chiefly cordial in do.</p>
                                <!-- Action -->
                                <ul class="nav nav-divider align-items-center">
                                    <li class="nav-item">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Like (1)</a>
                                    </li>
                                    <li class="nav-item d-none d-sm-block">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Reply</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Comment children level 2 -->
                        <div class="my-4 d-flex ps-3 ps-md-4">
                            <img class="avatar avatar-md rounded-circle me-3" src="assets/images/avatar/06.jpg"
                                alt="avatar">
                            <div>
                                <div class="mb-2">
                                    <h6 class="m-0">Allen Smith</h6>
                                    <span class="me-3 small">June 12, 2021 at 7:30 am</span>
                                </div>
                                <p class="mb-2">Water timed folly right aware if oh truth.</p>
                                <!-- Action -->
                                <ul class="nav nav-divider align-items-center">
                                    <li class="nav-item">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Like</a>
                                    </li>
                                    <li class="nav-item d-none d-sm-block">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Reply</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Comment level 1 -->
                        <div class="my-4 d-flex">
                            <img class="avatar avatar-md rounded-circle me-3" src="assets/images/avatar/04.jpg"
                                alt="avatar">
                            <div>
                                <div class="mb-2">
                                    <h6 class="m-0">Judy Nguyen</h6>
                                    <span class="me-3 small">June 18, 2021 at 11:55 am</span>
                                </div>
                                <p class="mb-2">Fulfilled direction use continual set him propriety continued. Saw met
                                    applauded favorite deficient engrossed concealed and her. Concluded boy perpetual
                                    old supposing. Farther-related bed and passage comfort civilly.</p>
                                <!-- Action -->
                                <ul class="nav nav-divider align-items-center">
                                    <li class="nav-item">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Like</a>
                                    </li>
                                    <li class="nav-item d-none d-sm-block">
                                        <a class="text-body-secondary text-primary-hover mb-0" href="#!">Reply</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Form START -->
                    <div class="col-lg-10 mx-auto">
                        <div class="bg-secondary bg-opacity-50 rounded-4 p-4 p-sm-5">
                            <!-- Title -->
                            <h5 class="mb-0">Your Views Please!</h5>
                            <small>Your email address will not be published. Required fields are marked *</small>

                            <form class="row g-3 mt-2">
                                <!-- Name -->
                                <div class="col-lg-6">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" aria-label="First name">
                                </div>
                                <!-- Email -->
                                <div class="col-lg-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control">
                                </div>
                                <!-- Comment -->
                                <div class="col-12">
                                    <label class="form-label">Your Comment *</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                <!-- Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mb-0">Post comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Form END -->
                </div>
            </div>
        </section>
        <!-- =======================
Blog detail END -->

        <!-- =======================
Related blogs START -->
        <section class="bg-secondary overflow-hidden">
            <div class="container">
                <!-- Title -->
                <h3 class="mb-5 text-center">Related blogs</h3>

                <!-- Projects START -->
                <div class="swiper" data-swiper-options='{
            "spaceBetween": 50,
            "loop": true,
            "autoplay":false,
            "pagination":{
                "el":".swiper-pagination"
            },
            "breakpoints": { 
                "576": {"slidesPerView": 1},
                "768": {"slidesPerView": 2},
                "992": {"slidesPerView": 3}
            }}'>

                    <div class="swiper-wrapper">

                        <!-- Project item -->
                        <div class="swiper-slide">
                            <article class="card card-img-scale bg-transparent overflow-hidden h-100 p-0">
                                <!-- Badge -->
                                <div class="d-flex gap-2 position-absolute top-0 start-0 z-index-2 m-4">
                                    <span class="badge bg-dark">Design</span>
                                    <span class="badge bg-white text-dark">June 28, 2024</span>
                                </div>

                                <!-- Card image -->
                                <div class="card-img-scale-wrapper rounded-4">
                                    <img src="assets/images/blog/4by3/02.jpg" class="rounded-4 img-scale"
                                        alt="Blog-img">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body px-2">
                                    <!-- Title -->
                                    <h6 class="card-title mb-2"><a href="#">Techniques to captivate your audience</a>
                                    </h6>
                                    <a class="icon-link icon-link-hover stretched-link" href="blog-single.html">Read
                                        more<i class="bi bi-arrow-right"></i> </a>
                                </div>
                            </article>
                        </div>

                        <!-- Project item -->
                        <div class="swiper-slide">
                            <article class="card card-img-scale bg-transparent overflow-hidden h-100 p-0">
                                <!-- Badge -->
                                <div class="d-flex gap-2 position-absolute top-0 start-0 z-index-2 m-4">
                                    <span class="badge bg-dark">Research</span>
                                    <span class="badge bg-white text-dark">July 15, 2024</span>
                                </div>

                                <!-- Card image -->
                                <div class="card-img-scale-wrapper rounded-4">
                                    <img src="assets/images/blog/4by3/04.jpg" class="rounded-4 img-scale"
                                        alt="Blog-img">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body px-2">
                                    <!-- Title -->
                                    <h6 class="card-title mb-2"><a href="#">Tips for improving your website's
                                            visibility</a></h6>
                                    <a class="icon-link icon-link-hover stretched-link" href="blog-single.html">Read
                                        more<i class="bi bi-arrow-right"></i> </a>
                                </div>
                            </article>
                        </div>

                        <!-- Project item -->
                        <div class="swiper-slide">
                            <article class="card card-img-scale bg-transparent overflow-hidden h-100 p-0">
                                <!-- Badge -->
                                <div class="d-flex gap-2 position-absolute top-0 start-0 z-index-2 m-4">
                                    <span class="badge bg-dark">Research</span>
                                    <span class="badge bg-white text-dark">July 15, 2024</span>
                                </div>

                                <!-- Card image -->
                                <div class="card-img-scale-wrapper rounded-4">
                                    <img src="assets/images/blog/4by3/03.jpg" class="rounded-4 img-scale"
                                        alt="Blog-img">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body px-2">
                                    <!-- Title -->
                                    <h6 class="card-title mb-2"><a href="#">Never underestimate the influence</a></h6>
                                    <a class="icon-link icon-link-hover stretched-link" href="blog-single.html">Read
                                        more<i class="bi bi-arrow-right"></i> </a>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Slider Pagination -->
                    <div class="swiper-pagination swiper-pagination-primary position-relative mt-0"></div>
                </div>
                <!-- Projects END -->
            </div>
        </section>
        <!-- =======================
Related blogs END -->

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

    <!-- Vendor -->
    <script src="assets/vendor/glightbox/js/glightbox.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>