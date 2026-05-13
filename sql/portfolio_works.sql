CREATE TABLE IF NOT EXISTS portfolio_works (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    client_logo_light VARCHAR(255),
    client_logo_dark VARCHAR(255),
    image VARCHAR(255),
    year VARCHAR(4),
    categories VARCHAR(255), -- Comma separated categories like "Branding, UI/UX design"
    service_id INT,
    pricing_id INT,
    status ENUM('published', 'draft', 'archived') DEFAULT 'published',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
    FOREIGN KEY (pricing_id) REFERENCES pricing_plans(id) ON DELETE SET NULL
);

-- Insert demo data matching the existing work.php structure
INSERT INTO portfolio_works (title, description, client_logo_light, client_logo_dark, image, year, categories, sort_order)
VALUES 
('Mobile app development', 'The app received positive feedback for its functionality and user experience, helping the client reach a wider audience.', 'assets/images/client/logo-light/01.svg', 'assets/images/client/logo-dark/01.svg', 'assets/images/portfolio/list/04.jpg', '2024', 'Branding, Packaging, UI/UX design', 1),

('Brand identity development', 'The most powerful software & app landing page for any kind of app and software marketing business.', 'assets/images/client/logo-light/03.svg', 'assets/images/client/logo-dark/03.svg', 'assets/images/portfolio/list/02.jpg', '2023', 'Graphics, UI/UX design', 2),

('Transforming ideas into reality', 'The website significantly improved the client''s online sales and customer engagement.', 'assets/images/client/logo-light/08.svg', 'assets/images/client/logo-dark/08.svg', 'assets/images/portfolio/list/03.jpg', '2021', 'Web Design, Branding, UI/UX design', 3),

('Digital marketing overhaul', 'Designed and developed a responsive e-commerce platform for folio agency retail.', 'assets/images/client/logo-light/05.svg', 'assets/images/client/logo-dark/05.svg', 'assets/images/portfolio/list/01.jpg', '2020', 'Marketing, SEO, Social media', 4);
