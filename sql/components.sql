DROP TABLE IF EXISTS `site_components`;
CREATE TABLE `site_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_type` varchar(50) NOT NULL COMMENT 'header_nav, footer_col_1, footer_col_2, footer_col_3, footer_social, global_media',
  `label` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `badge_text` varchar(100) DEFAULT NULL,
  `badge_class` varchar(100) DEFAULT NULL,
  `special_type` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Include seeds
INSERT INTO `site_components` (`component_type`, `label`, `url`, `icon`, `image`, `badge_text`, `badge_class`, `special_type`, `sort_order`, `status`) VALUES
('header_nav', 'Work', 'work.php', NULL, NULL, NULL, NULL, NULL, 10, 'active'),
('header_nav', 'Services', '#', NULL, NULL, NULL, NULL, 'services_dropdown', 20, 'active'),
('header_nav', 'Benefits', 'benefits.php', NULL, NULL, NULL, NULL, NULL, 30, 'active'),
('header_nav', 'Pricing', 'pricing.php', NULL, NULL, NULL, NULL, NULL, 40, 'active'),
('header_nav', 'About Us', 'about.php', NULL, NULL, NULL, NULL, NULL, 50, 'active'),
('header_nav', 'Blog', 'blog.php', NULL, NULL, NULL, NULL, NULL, 60, 'active'),
('header_nav', 'Contact us', 'contact.php', NULL, NULL, NULL, NULL, NULL, 70, 'active'),

('footer_col_1', 'About us', 'about-v1.html', NULL, NULL, NULL, NULL, NULL, 10, 'active'),
('footer_col_1', 'Contact us', 'contact-us.html', NULL, NULL, NULL, NULL, NULL, 20, 'active'),
('footer_col_1', 'Career', 'career.html', NULL, NULL, 'We are hiring!', 'text-bg-success', NULL, 30, 'active'),
('footer_col_1', 'Career detail', 'career-single.html', NULL, NULL, NULL, NULL, NULL, 40, 'active'),
('footer_col_1', 'Become a partner', 'contact-us-v2.html', NULL, NULL, NULL, NULL, NULL, 50, 'active'),
('footer_col_1', 'Services', 'service-v1.html', NULL, NULL, NULL, NULL, NULL, 60, 'active'),

('footer_col_2', 'Case studies', 'portfolio-case-study-v1.html', NULL, NULL, NULL, NULL, NULL, 10, 'active'),
('footer_col_2', 'Pricing', 'pricing-v1.html', NULL, NULL, NULL, NULL, NULL, 20, 'active'),
('footer_col_2', 'Blogs', 'blog-minimal.html', NULL, NULL, NULL, NULL, NULL, 30, 'active'),
('footer_col_2', 'Blog detail', 'blog-single.html', NULL, NULL, NULL, NULL, NULL, 40, 'active'),
('footer_col_2', 'Success stories', '#', 'bi-box-arrow-up-right', NULL, NULL, NULL, NULL, 50, 'active'),

('footer_col_3', 'Documentation', '#', 'bi-file-earmark-text', NULL, NULL, NULL, NULL, 10, 'active'),
('footer_col_3', 'Changelog', '#', 'bi-bullseye', NULL, 'v2.0.0', 'text-bg-primary', NULL, 20, 'active'),
('footer_col_3', 'Supports', '#', 'bi-chat-left', NULL, NULL, NULL, NULL, 30, 'active'),
('footer_col_3', 'Newsletter', '#', 'bi-send', NULL, NULL, NULL, NULL, 40, 'active'),

('footer_social', 'Facebook', 'https://facebook.com', 'bi-facebook', NULL, NULL, NULL, NULL, 10, 'active'),
('footer_social', 'Twitter', 'https://twitter.com', 'bi-twitter', NULL, NULL, NULL, NULL, 20, 'active'),
('footer_social', 'Instagram', 'https://instagram.com', 'bi-instagram', NULL, NULL, NULL, NULL, 30, 'active'),
('footer_social', 'LinkedIn', 'https://linkedin.com', 'bi-linkedin', NULL, NULL, NULL, NULL, 40, 'active'),

('global_media', 'Services Megamenu CTA', NULL, NULL, 'assets/images/elements/nav-cta.jpg', NULL, NULL, 'services_cta', 0, 'active');
