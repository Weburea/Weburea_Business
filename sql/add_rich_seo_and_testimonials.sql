-- Weburea Agency - Portfolio Rich SEO & Testimonials Expansion
-- Adds support for multi-testimonial JSON and advanced social media meta tags.

USE weburea_db;

ALTER TABLE portfolio_works 
ADD COLUMN IF NOT EXISTS testimonials_json TEXT AFTER testimonial_image,
ADD COLUMN IF NOT EXISTS meta_og_image VARCHAR(255) AFTER meta_keywords,
ADD COLUMN IF NOT EXISTS meta_twitter_image VARCHAR(255) AFTER meta_og_image,
ADD COLUMN IF NOT EXISTS meta_og_type VARCHAR(50) DEFAULT 'website' AFTER meta_twitter_image;
