-- Newsletter Subscriptions
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Job Listings (for the Career CTA)
CREATE TABLE IF NOT EXISTS `job_listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('active', 'closed') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed some jobs
INSERT INTO `job_listings` (`title`, `department`, `location`, `status`) VALUES
('Motion Graphics Designer', 'Creative', 'Remote', 'active'),
('Frontend Developer (React)', 'Engineering', 'London, UK', 'active'),
('UI/UX Specialist', 'Design', 'Remote', 'active');
