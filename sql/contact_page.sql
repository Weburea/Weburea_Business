CREATE TABLE IF NOT EXISTS `contact_page_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) NOT NULL,
  `section_content` json NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `contact_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new', 'read', 'archived') DEFAULT 'new',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `contact_page_sections` (`section_key`, `section_content`) VALUES
('hero', '{"icon": "👋", "title": "Let\'s Connect", "subtitle": "We\'re here to help", "support_hours": "24/7"}'),
('contact_info', '{"call_us": {"icon": "bi-telephone", "title": "Call us", "desc": "Speak with a member of our team. We’re always ready to assist you.", "contact": "+(251) 854-6308", "link": "tel:+(251)854-6308"}, "mail_us": {"icon": "bi-envelope", "title": "Mail us", "desc": "We’re prompt and aim to respond to all inquiries within 24 hours.", "contact": "example@gmail.com", "link": "mailto:example@gmail.com"}, "support": {"icon": "bi-headset", "title": "Support", "desc": "Check out helpful resources, FAQs and developer tools.", "contact": "Chat now", "link": "#"}}'),
('contact_form', '{"title": "Say Hello", "subtitle": "Have an idea, need advice, or just want to say hello? We’re all ears.", "typed_words": "Hello&&Hola&&Ciao&&Bonjour", "admin_email": "admin@weburea.com", "social_links": {"facebook": "#", "instagram": "#", "twitter": "#", "linkedin": "#"}}')
ON DUPLICATE KEY UPDATE `section_key`=`section_key`;
