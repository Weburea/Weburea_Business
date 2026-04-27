-- SQL Script for Weburea Admin Users
-- Database: weburea_db

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default admin account
-- Email: admin@weburea.com
-- Password: admin123
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Weburea Admin', 'admin@weburea.com', '$2y$10$5Zc7hWF6PZxg4cqp7ls2x.SxtUCcMq/DUd2qC2mZJliIYCf.NqI1.', 'admin')
ON DUPLICATE KEY UPDATE `email` = `email`;
