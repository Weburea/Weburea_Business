-- Pricing Plans Table
CREATE TABLE IF NOT EXISTS pricing_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price VARCHAR(100) NOT NULL,
    annual_price VARCHAR(100) DEFAULT NULL,
    description TEXT,
    features_json JSON,
    comparison_values_json JSON,
    is_custom BOOLEAN DEFAULT FALSE,
    is_recommended BOOLEAN DEFAULT FALSE,
    label VARCHAR(50) DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

-- Initial data for Product Design (Service ID 1 - assuming IDs 1-7 from static list)
-- Note: Real IDs will depend on the current services table state. 
-- I will run a script to populate this based on slugs to be safer.
