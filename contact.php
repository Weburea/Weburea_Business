<!DOCTYPE html>
<html lang="en">

<head>

    <title>Contact Us — Weburea Agency | Start Your Project</title>

    <link rel="icon" type="image/png" href="assets/images/Vector_small.svg">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description"
        content="Ready to build something great? Contact Weburea Agency in Lagos. Get a quote for UI/UX design, web development, branding, or software testing (QA). Let's chat.">

    <meta name="keywords"
        content="Contact Weburea, Hire Creative Agency Lagos, Start Project, Web Development Quote, UI UX Design Contact, Software Testing Inquiry, Customer Support, Agency Location">

    <meta name="author" content="Weburea Agency">

    <?php include('include/dark_mode.php'); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body>

    <!-- Header START -->
    <?php 
    $header_theme = 'dark';
    include('include/front_header.php');
    ?>
    <!-- Header END -->

    <?php
    require_once('include/db.php');
    $contact_config = [];
    try {
        $stmt = $pdo->query("SELECT section_key, section_content FROM contact_page_sections");
        while ($row = $stmt->fetch()) {
            $contact_config[$row['section_key']] = json_decode($row['section_content'], true);
        }
    } catch (Exception $e) {
        // Fallback or handle error
    }
    ?>

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
Hero START -->
        <?php include('include/sections/contact/hero.php'); ?>
        <!-- =======================
Hero END -->

        <!-- =======================
Contact info START -->
        <?php include('include/sections/contact/contact_info.php'); ?>
        <!-- =======================
Contact info END -->

        <!-- =======================
Contact form START -->
        <?php include('include/sections/contact/contact_form.php'); ?>
        <!-- =======================
Contact form END -->


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

    <!--Vendors-->
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.js"></script>
    <script src="assets/vendor/ityped/index.js"></script>

    <!-- Theme Functions -->
    <script src="assets/js/functions.js"></script>

</body>

</html>