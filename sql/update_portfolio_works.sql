-- Weburea Agency - Portfolio Works Table Expansion
-- Adds support for service-specific content, rich case studies, and SEO.

USE weburea_db;

ALTER TABLE portfolio_works 
ADD COLUMN IF NOT EXISTS project_overview TEXT AFTER description,
ADD COLUMN IF NOT EXISTS project_challenge TEXT AFTER project_overview,
ADD COLUMN IF NOT EXISTS challenge_points TEXT AFTER project_challenge,
ADD COLUMN IF NOT EXISTS additional_images TEXT AFTER image, -- Will store JSON array of image paths
ADD COLUMN IF NOT EXISTS comparison_image VARCHAR(255) AFTER additional_images,
ADD COLUMN IF NOT EXISTS testimonial_text TEXT AFTER comparison_image,
ADD COLUMN IF NOT EXISTS testimonial_author VARCHAR(255) AFTER testimonial_text,
ADD COLUMN IF NOT EXISTS testimonial_role VARCHAR(255) AFTER testimonial_author,
ADD COLUMN IF NOT EXISTS testimonial_image VARCHAR(255) AFTER testimonial_role,
ADD COLUMN IF NOT EXISTS meta_title VARCHAR(255) AFTER testimonial_image,
ADD COLUMN IF NOT EXISTS meta_description TEXT AFTER meta_title,
ADD COLUMN IF NOT EXISTS meta_keywords VARCHAR(255) AFTER meta_description,
ADD COLUMN IF NOT EXISTS industry VARCHAR(100) AFTER year,
ADD COLUMN IF NOT EXISTS project_direction VARCHAR(100) AFTER industry,
ADD COLUMN IF NOT EXISTS service_data_json TEXT AFTER project_direction,
ADD COLUMN IF NOT EXISTS client_logo_light VARCHAR(255) AFTER testimonial_image,
ADD COLUMN IF NOT EXISTS client_logo_dark VARCHAR(255) AFTER client_logo_light;
