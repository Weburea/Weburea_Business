-- Weburea Agency - Add Live Project URL Column
-- Adds support for live project links in the portfolio.

USE weburea_db;

ALTER TABLE portfolio_works 
ADD COLUMN IF NOT EXISTS live_url VARCHAR(255) AFTER categories;
