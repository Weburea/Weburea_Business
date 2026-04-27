-- Weburea Agency - Benefit Icons Table
-- Version: 1.0

USE weburea_db;

CREATE TABLE IF NOT EXISTS `benefit_icons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(255) NOT NULL,
    `icon_path` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed defaults
INSERT INTO `benefit_icons` (`label`, `icon_path`) VALUES 
('Consulting', 'assets/images/services/3d-icon/consulting.png'),
('App Dev', 'assets/images/services/3d-icon/app-dev.png'),
('Development', 'assets/images/services/3d-icon/development.png'),
('Marketing', 'assets/images/services/3d-icon/marketing.png'),
('Branding', 'assets/images/services/3d-icon/brand.png'),
('Database', 'assets/images/services/3d-icon/database.png');
