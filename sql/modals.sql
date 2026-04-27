-- Refined Table for Context-Based Premium Modal Configurations
DROP TABLE IF EXISTS `modal_configurations`;

CREATE TABLE `modal_configurations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `context_key` VARCHAR(50) NOT NULL DEFAULT 'global',
    `modal_type` ENUM('success', 'warning', 'error', 'info') NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `button_text` VARCHAR(50) DEFAULT 'Dismiss',
    `image_path` VARCHAR(255) DEFAULT 'assets/images/elements/rocket-02.png',
    `animation_type` ENUM('float-up', 'float-down') DEFAULT 'float-up',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_modal_context` (`context_key`, `modal_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed initial data for multiple contexts
INSERT INTO `modal_configurations` (`context_key`, `modal_type`, `title`, `message`, `button_text`, `image_path`, `animation_type`) VALUES
-- Global Defaults
('global', 'success', 'Operation Success!', 'Your request has been processed successfully.', 'AWESOME!', 'assets/images/elements/rocket-02.png', 'float-up'),
('global', 'warning', 'Security Alert', 'Please review your action before proceeding further.', 'UNDERSTOOD', 'assets/images/elements/rocket-02.png', 'float-down'),
('global', 'error', 'System Error', 'An unexpected error occurred. Please contact support.', 'DISMISS', 'assets/images/elements/rocket-02.png', 'float-down'),
('global', 'info', 'Information', 'New system updates are available for your review.', 'VIEW NOW', 'assets/images/elements/rocket-02.png', 'float-up'),

-- Newsletter Specific
('newsletter', 'success', 'Welcome Aboard!', 'You have successfully subscribed to our newsletter. Exciting updates are on the way!', 'AWESOME!', 'assets/images/elements/rocket-02.png', 'float-up'),
('newsletter', 'warning', 'Subscription Issue', 'You are already subscribed! We appreciate your loyalty.', 'TRY AGAIN', 'assets/images/elements/rocket-02.png', 'float-down'),

-- Contact Page Specific
('contact', 'success', 'Message Received!', 'Thank you for reaching out. Our team will get back to you within 24 hours.', 'GREAT!', 'assets/images/elements/rocket-02.png', 'float-up'),
('contact', 'error', 'Delivery Failed', 'We could not send your message at this time. Please check your connection.', 'RETRY', 'assets/images/elements/rocket-02.png', 'float-down'),

-- Careers Specific
('careers', 'success', 'Application Sent!', 'Your resume has been received. Our HR team is reviewing it now.', 'FINGERS CROSSED', 'assets/images/elements/rocket-02.png', 'float-up');
