-- Weburea Agency - Professional Pricing Data Population Script (Standardized Tiers)
-- This script populates comparison features and exactly 4 standardized plans for all 7 core services.

USE weburea_db;

-- Clear existing pricing plans before repopulating
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE pricing_plans;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. UI/UX & Product Design (ID 1)
UPDATE services SET comparison_features_json = '["Number of Screens", "UX Research Depth", "Design System", "Prototyping Level", "Device Support", "Usability Testing", "Dev Handoff Mode", "Revisions"]' WHERE id = 1;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(1, 'Basic plan', '2,500', '2,200', '["Up to 5 Screens", "Basic UX Research", "Color & Typography Guide", "Static Wireframes", "Mobile OR Web"]', '{"Number of Screens": "Up to 5", "UX Research Depth": "Basic", "Design System": "Style Guide", "Prototyping Level": "Static", "Device Support": "Single", "Usability Testing": "1 Round", "Dev Handoff Mode": "PDF", "Revisions": "2"}', 0, NULL),
(1, 'Standard plan', '5,500', '4,800', '["Up to 15 Screens", "Full UX Persona Research", "Comprehensive Design System", "Interactive Prototypes", "Mobile & Web"]', '{"Number of Screens": "Up to 15", "UX Research Depth": "Full Audit", "Design System": "Complete", "Prototyping Level": "High-Fi", "Device Support": "Responsive", "Usability Testing": "3 Rounds", "Dev Handoff Mode": "Figma", "Revisions": "Unlimited"}', 1, 'MOST POPULAR'),
(1, 'Business plan', '9,500', '8,200', '["Up to 30 Screens", "Multi-user Journey Mapping", "Internal Design Library", "Advanced Low-Level Motion", "Cross-Platform Ecosystems"]', '{"Number of Screens": "30+", "UX Research Depth": "Strategic", "Design System": "Advanced", "Prototyping Level": "Complex", "Device Support": "Multi-Platform", "Usability Testing": "Continuous", "Dev Handoff Mode": "Managed", "Revisions": "Unlimited"}', 0, NULL),
(1, 'Enterprise plan', 'Custom', NULL, '["Unlimited Screens", "End-to-End Product Design", "Scaling Component Libraries", "Production-Ready Specs", "Dedicated Research Team"]', '{"Number of Screens": "Unlimited", "UX Research Depth": "Corporate", "Design System": "Enterprise", "Prototyping Level": "Atomic", "Device Support": "Omni-channel", "Usability Testing": "Global", "Dev Handoff Mode": "Enterprise", "Revisions": "Priority"}', 0, NULL);

-- 2. Branding & Graphic Design (ID 2)
UPDATE services SET comparison_features_json = '["Logo Concepts", "Brand Style Guide", "Social Media Kit", "Stationery Design", "Brand Voice/Tone", "Presentation Deck", "Packaging Design", "Trademark Support"]' WHERE id = 2;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(2, 'Basic plan', '1,800', '1,500', '["2 Logo Concepts", "Basic Style Guide", "Profile Pictures", "Business Cards"]', '{"Logo Concepts": "2", "Brand Style Guide": "Basic (5 pgs)", "Social Media Kit": "Profiles", "Stationery Design": "Business Card", "Brand Voice/Tone": "Basic", "Presentation Deck": "No", "Packaging Design": "No", "Trademark Support": "No"}', 0, NULL),
(2, 'Standard plan', '4,200', '3,600', '["5 Logo Concepts", "Full Brand Book", "Complete Social Kit", "Letterheads & Folders"]', '{"Logo Concepts": "5", "Brand Style Guide": "Full (25 pgs)", "Social Media Kit": "Complete", "Stationery Design": "Full Set", "Brand Voice/Tone": "Advanced", "Presentation Deck": "10 Slides", "Packaging Design": "Basic", "Trademark Support": "Yes"}', 1, 'RECOMMENDED'),
(2, 'Business plan', '7,000', '6,200', '["Unlimited Designs", "Global Brand Strategy", "High-Fidelity Assets", "Marketing Material Pack"]', '{"Logo Concepts": "10+", "Brand Style Guide": "Strategic", "Social Media Kit": "Master Pack", "Stationery Design": "Full Suite", "Brand Voice/Tone": "Enterprise", "Presentation Deck": "20 Slides", "Packaging Design": "Full Line", "Trademark Support": "Managed"}', 0, NULL),
(2, 'Enterprise plan', 'Custom', NULL, '["Master Brand Ecosystem", "Global Marketing Assets", "Corporate Deck Library", "Legal Coordination"]', '{"Logo Concepts": "Unlimited", "Brand Style Guide": "Master Level", "Social Media Kit": "Omni-channel", "Stationery Design": "Corporate", "Brand Voice/Tone": "Strategic", "Presentation Deck": "Custom Lib", "Packaging Design": "Premium", "Trademark Support": "Managed"}', 0, NULL);

-- 3. Motion Graphics & Animation (ID 3)
UPDATE services SET comparison_features_json = '["Video Duration", "Resolution", "Scriptwriting", "Voiceover Included", "3D Animation", "Stock Footage Lib", "Background Music", "Render Speed"]' WHERE id = 3;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(3, 'Basic plan', '950', '800', '["15s-30s Duration", "1080p Resolution", "Client Provided Script", "No Voiceover"]', '{"Video Duration": "15-30s", "Resolution": "1080p", "Scriptwriting": "Client", "Voiceover Included": "No", "3D Animation": "No", "Stock Footage Lib": "Basic", "Background Music": "Included", "Render Speed": "Standard"}', 0, NULL),
(3, 'Standard plan', '2,800', '2,400', '["Up to 2m Duration", "4K Resolution", "Professional Scripting", "AI Voiceover Included"]', '{"Video Duration": "2 min", "Resolution": "4K", "Scriptwriting": "Pro", "Voiceover Included": "Yes (AI)", "3D Animation": "Partial", "Stock Footage Lib": "Premium", "Background Music": "Sound Design", "Render Speed": "Express"}', 1, 'POPULAR'),
(3, 'Business plan', '5,500', '4,800', '["Up to 5m Duration", "Raw Render Access", "Strategic Narrative", "Custom Characters"]', '{"Video Duration": "5 min", "Resolution": "5K", "Scriptwriting": "Master", "Voiceover Included": "Pro Duo", "3D Animation": "Full 3D", "Stock Footage Lib": "Unlimited", "Background Music": "Bespoke", "Render Speed": "Instant"}', 0, NULL),
(3, 'Enterprise plan', 'Custom', NULL, '["Strategic Storytelling", "Studio Voiceover", "Hyper-Realistic 3D", "Original Score"]', '{"Video Duration": "Custom", "Resolution": "8K", "Scriptwriting": "Strategic", "Voiceover Included": "Pro Studio", "3D Animation": "Full 3D", "Stock Footage Lib": "Custom", "Background Music": "Original", "Render Speed": "Instant"}', 0, NULL);

-- 4. Software Testing & QA (ID 4)
UPDATE services SET comparison_features_json = '["Testing Type", "Device Coverage", "Automation Level", "Bug Reporting", "API Documentation", "Security Audits", "Performance Benchmarks", "Release Support"]' WHERE id = 4;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(4, 'Basic plan', '1,200', '1,000', '["Functional Testing", "Top 5 Devices", "Manual Only", "Jira/Trello Report"]', '{"Testing Type": "Functional", "Device Coverage": "5 Devices", "Automation Level": "Manual", "Bug Reporting": "Standard", "API Documentation": "Review", "Security Audits": "No", "Performance Benchmarks": "No", "Release Support": "Basic"}', 0, NULL),
(4, 'Standard plan', '3,500', '3,000', '["Full Regression", "25+ Devices & OS", "Semi-Automated", "Visual Bug Video Log"]', '{"Testing Type": "Full Suite", "Device Coverage": "25 Devices", "Automation Level": "Hybrid", "Bug Reporting": "Video Logs", "API Documentation": "Complete", "Security Audits": "Yes", "Performance Benchmarks": "Load Test", "Release Support": "Launch"}', 1, 'BEST VALUE'),
(4, 'Business plan', '6,500', '5,800', '["DevOps Integration", "Unlimited Browsers", "Full Playwright Suite", "Penetration Testing"]', '{"Testing Type": "Full Audit", "Device Coverage": "Unlimited", "Automation Level": "Auto-DevOps", "Bug Reporting": "Live Feed", "API Documentation": "Postman Suite", "Security Audits": "Advanced", "Performance Benchmarks": "Chaos Eng", "Release Support": "Strategic"}', 0, NULL),
(4, 'Enterprise plan', 'Custom', NULL, '["Embedded QA Team", "Full CI/CD Automation", "Real-time Dashboards", "Post-Launch Monitoring"]', '{"Testing Type": "Continuous", "Device Coverage": "Unlimited", "Automation Level": "Full Auto", "Bug Reporting": "Real-time", "API Documentation": "Strategic", "Security Audits": "Pentest", "Performance Benchmarks": "Chaos Eng", "Release Support": "Strategic"}', 0, NULL);

-- 5. Web Design & Development (ID 5)
UPDATE services SET comparison_features_json = '["Platform Used", "Custom Features", "E-commerce Support", "API Integrations", "Speed Performance", "SEO Optimization", "User Dashboard", "CMS Access"]' WHERE id = 5;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(5, 'Basic plan', '3,500', '3,000', '["React/Next.js/WP", "Up to 10 Pages", "Basic Shop", "Standard APIs"]', '{"Platform Used": "React/Stack", "Custom Features": "10 Pages", "E-commerce Support": "Basic", "API Integrations": "Stripe/Mail", "Speed Performance": "85+", "SEO Optimization": "Basic", "User Dashboard": "Standard", "CMS Access": "Yes"}', 0, NULL),
(5, 'Standard plan', '8,500', '7,200', '["Custom Architecture", "Unified Ecosystem", "Full Advanced Shop", "Complex API Syncs"]', '{"Platform Used": "Custom Arc", "Custom Features": "Unlimited", "E-commerce Support": "Advanced", "API Integrations": "Multi-Sync", "Speed Performance": "98+", "SEO Optimization": "Strategic", "User Dashboard": "Custom Portals", "CMS Access": "Managed"}', 1, 'CLIENT FAVORITE'),
(5, 'Business plan', '15,000', '13,500', '["Enterprise Infrastructure", "Microservices Setup", "Advanced AI Features", "Corporate Security"]', '{"Platform Used": "Node Cluster", "Custom Features": "Corporate", "E-commerce Support": "Multi-Store", "API Integrations": "ERP/SAP", "Speed Performance": "Absolute", "SEO Optimization": "Domination", "User Dashboard": "Admin Suite", "CMS Access": "Custom"}', 0, NULL),
(5, 'Enterprise plan', 'Custom', NULL, '["Global Marketplaces", "Custom ERP Connect", "Bespoke Edge Perf", "Infrastructure Management"]', '{"Platform Used": "Enterprise", "Custom Features": "Ecosystem", "E-commerce Support": "Global", "API Integrations": "Omni-Connect", "Speed Performance": "Absolute", "SEO Optimization": "Domination", "User Dashboard": "Admin Suite", "CMS Access": "Corporate"}', 0, NULL);

-- 6. Video Editing & Production (ID 6)
UPDATE services SET comparison_features_json = '["Production Mode", "Raw Footage Limit", "Final Edit Length", "Color Grading", "Sound Mixing", "Stock Asset Lib", "Revisions", "Delivery Time"]' WHERE id = 6;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(6, 'Basic plan', '750', '600', '["Remote Editing", "Up to 30 min Raw", "Sub 2m Final", "Film Filters"]', '{"Production Mode": "Editing Only", "Raw Footage Limit": "30 mins", "Final Edit Length": "Under 2m", "Color Grading": "Filters", "Sound Mixing": "Levels", "Stock Asset Lib": "Basic", "Revisions": "2", "Delivery Time": "48h"}', 0, NULL),
(6, 'Standard plan', '2,200', '1,900', '["Hybrid Directing", "Unlimited Raw", "Custom Final Length", "Cinema Grade"]', '{"Production Mode": "Hybrid", "Raw Footage Limit": "Unlimited", "Final Edit Length": "Custom", "Color Grading": "Cinema", "Sound Mixing": "Pro Mix", "Stock Asset Lib": "Premium", "Revisions": "Unlimited", "Delivery Time": "Express"}', 1, 'HIGH QUALITY'),
(6, 'Business plan', '4,500', '4,000', '["Strategic Storytelling", "On-site Crew", "4K Mastering", "Dolby Audio Mix"]', '{"Production Mode": "Full Suite", "Raw Footage Limit": "Exhaustive", "Final Edit Length": "Narrative", "Color Grading": "High-Fi", "Sound Mixing": "Mastered", "Stock Asset Lib": "Exclusive", "Revisions": "High", "Delivery Time": "Planned"}', 0, NULL),
(6, 'Enterprise plan', 'Custom', NULL, '["Master Colorist", "Orchestral Mixing", "Exclusive Scoring", "Project Managed"]', '{"Production Mode": "Full Crew", "Raw Footage Limit": "Unlimited", "Final Edit Length": "Narrative", "Color Grading": "Mastered", "Sound Mixing": "Atmos", "Stock Asset Lib": "Exclusive", "Revisions": "Executive", "Delivery Time": "Project"}', 0, NULL);

-- 7. Digital Marketing & Ads (ID 7)
UPDATE services SET comparison_features_json = '["Ad Platforms", "Monthly Spend Cap", "Campaign Audit", "Content Pieces", "Retargeting Setup", "Email Funnels", "Performance Data", "Consulting Hours"]' WHERE id = 7;

INSERT INTO pricing_plans (service_id, name, price, annual_price, features_json, comparison_values_json, is_recommended, label) VALUES
(7, 'Basic plan', '1,500', '1,200', '["Google & Meta", "Up to $5k Spend", "Standard Audit", "5 Graphics/mo"]', '{"Ad Platforms": "Google/Meta", "Monthly Spend Cap": "$5,000", "Campaign Audit": "Standard", "Content Pieces": "5 Posts", "Retargeting Setup": "Yes", "Email Funnels": "No", "Performance Data": "Monthly", "Consulting Hours": "1 hr"}', 0, NULL),
(7, 'Standard plan', '4,500', '3,900', '["Omni-channel Ads", "Up to $50k Spend", "Deep-Dive Strategy", "20 Graphics/Video"]', '{"Ad Platforms": "Omni-channel", "Monthly Spend Cap": "$50,000", "Campaign Audit": "Strategic", "Content Pieces": "20 Assets", "Retargeting Setup": "Dynamic", "Email Funnels": "3-Step", "Performance Data": "Real-time", "Consulting Hours": "Weekly"}', 1, 'AGGRESSIVE GROWTH'),
(7, 'Business plan', '8,500', '7,600', '["Advanced Ads Ecosystem", "Unlimited Spend Mgmt", "Global Content Engine", "BI Solution"]', '{"Ad Platforms": "Advanced", "Monthly Spend Cap": "Mastered", "Campaign Audit": "Full Data", "Content Pieces": "Unlimited", "Retargeting Setup": "AI-Driven", "Email Funnels": "Mastery", "Performance Data": "Live Data", "Consulting Hours": "Bi-Weekly"}', 0, NULL),
(7, 'Enterprise plan', 'Custom', NULL, '["Enterprise Ad Stack", "Executive Strategy", "Full Funnel Ecosystem", "Priority Access"]', '{"Ad Platforms": "Enterprise", "Monthly Spend Cap": "Unlimited", "Campaign Audit": "Executive", "Content Pieces": "Unlimited", "Retargeting Setup": "Strategic", "Email Funnels": "Ecosystem", "Performance Data": "Custom BI", "Consulting Hours": "Unlimited"}', 0, NULL);
