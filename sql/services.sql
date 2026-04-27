-- Weburea Agency - Enriched Services Population Script
-- Version: 3.0
-- This script clears existing services and populates all 7 core Weburea Agency services with ENRICHED CONTENT.

USE weburea_db;

-- Clear existing data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `services`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. UI/UX & Product Design
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert, comparison_features_json, comparison_values_json) 
VALUES 
(
 'UI/UX & Product Design', 
 'ui-ux-design', 
 'We craft intuitive interfaces and seamless user journeys that turn visitors into loyal customers through user-centered research and data-driven design systems.', 
 'Experience-First Digital Design', 
 'assets/images/services/4by3/UI_UX.mp4', 
 'Experience Design', 
 'Designing the Future of Personal and Professional Digital Interaction', 
 'Design is not just what it looks like; it\'s how it works and how it feels to the end user.', 
 'At Weburea, our UI/UX methodology is rooted in deep human psychology and behavioral data. We don\'t just create pretty screens; we build high-conversion ecosystems where every pixel serves a purpose. From the initial discovery phase and user persona development to wireframing, rapid prototyping, and exhaustive A/B testing, our team ensures that your digital product is intuitive, accessible, and ahead of the curve in terms of modern design trends. We specialize in complex dashboard designs, mobile-first applications, and enterprise-level software interfaces that simplify the user experience while maximizing business value.', 
 'assets/images/services/4by3/UI_UX.mp4', 
 'assets/images/services/3d-icon/app-dev.png', 
 '[{"title": "UX Research", "content": "Our deep-dive research into user behavior and psychology allows us to map out journeys that eliminate friction and drive long-term engagement and brand loyalty."}, {"title": "Design Systems", "content": "We build scalable, robust design systems that ensure brand consistency across all digital platforms, reducing development time and improving team collaboration."}, {"title": "Accessibility (A11y)", "content": "We prioritize inclusive design, ensuring your product is usable by everyone, regardless of their physical or cognitive abilities, while remaining WCAG compliant."}]', 
 '[{"title": "User-Centered", "text": "We design for your actual users, not just for design awards or trends. Every decision is backed by data.", "icon": "bi-people"}, {"title": "Glitch-Free UI", "text": "Our designers work closely with QA to ensure that every interaction is smooth and performs perfectly.", "icon": "bi-bug"}, {"title": "Rapid Prototyping", "text": "We turn ideas into interactive prototypes in days, not weeks, allowing for early feedback and iteration.", "icon": "bi-speedometer2"}, {"title": "Scalable Systems", "text": "Our designs are built to grow with your business, from MVP to enterprise-level global software.", "icon": "bi-layers"}]',
 '["UX Research & User Journeys", "Wireframing & Prototyping", "Mobile & Web Interfaces"]',
 '["Number of Screens", "UX Research Depth", "Design System", "Prototyping Level", "Device Support", "Usability Testing", "Dev Handoff Mode", "Revisions"]'
);

-- 2. Branding & Graphic Design
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert, comparison_features_json, comparison_values_json) 
VALUES 
(
 'Branding & Graphic Design', 
 'branding-graphics', 
 'Build a powerful brand identity that stands out in a crowded market. From logos to complete design systems.', 
 'Distinctive Brand Legacies', 
 'assets/images/services/4by3/Branding.mp4', 
 'Creative Identity', 
 'Your Brand, Reimagined for the Modern Digital Global Marketplace', 
 'We don\'t just design logos; we build emotional connections between brands and people.', 
 'Weburea\'s branding philosophy centers on the idea of "Visual Truth." We dig deep into your company history, culture, and future aspirations to craft a brand identity that feels authentic and powerful. Our team of graphic designers and brand strategists work in tandem to develop a comprehensive brand book that covers everything from logo anatomy and typography to color theory and brand voice. Whether you are a startup looking to make a splash or an established firm needing a modern refresh, we provide the creative direction and visual assets necessary to dominate your niche and win the trust of your target audience.', 
 assets/images/services/4by3/Branding.mp4', 
 'assets/images/services/3d-icon/brand.png', 
 '[{"title": "Logo Architecture", "content": "We create iconic marks that are mathematically balanced and visually striking, ensuring they remain timeless and recognizable across all scales and mediums."}, {"title": "Typography & Voice", "content": "Selecting the right fonts and tone of voice is critical. We define a unique verbal and visual personality that speaks directly to your ideal customer profile."}, {"title": "Collateral Design", "content": "From business cards to large-scale environmental graphics, we ensure your brand looks premium and professional in every physical and digital touchpoint."}]', 
 '[{"title": "Memorable Impact", "text": "We create brands that stick in the customer\'s mind long after the first impression is made.", "icon": "bi-bookmark-star"}, {"title": "Strategy First", "text": "Our designs are rooted in market research and competitor analysis to ensure a unique market position.", "icon": "bi-lightbulb"}, {"title": "Full Brand Book", "text": "We provide a complete guide on how to use your brand, ensuring consistency across your entire team.", "icon": "bi-book"}, {"title": "Global Standards", "text": "Our branding is designed to work across cultures and languages, preparing you for international expansion.", "icon": "bi-globe"}]',
 '["Brand Identity & Logos", "Marketing Visual Assets", "Design Systems"]'
);

-- 3. Motion Graphics & Animation
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert) 
VALUES 
(
 'Motion Graphics & Animation', 
 'motion-animation', 
 'Cinematic motion graphics and 3D storytelling that bring your brand\'s message to life with energy, precision, and impact.', 
 'High-Fidelity Creativity in Motion', 
 'assets/images/services/4by3/Motions_Graphics.mp4', 
 'Motion & VFX', 
 'Bring Your Ideas to Life with Cinematic Digital Storytelling', 
 'Motion tells a story that static images simply cannot convey to a modern, fast-paced audience.', 
 'In the age of social media and short attention spans, motion graphics are the most effective way to communicate complex ideas quickly. At Weburea, our motion studio combines advanced animation techniques with professional sound design to create immersive video experiences. We specialize in 2D vector animation, 3D product renders, cinematic title sequences, and dynamic advertising content. Our workflow is highly collaborative, involving storyboarding and styleframe development long before the final render. We ensure that every movement is synchronized with your brand identity and optimized for the platforms where they will be viewed.', 
 'assets/images/services/4by3/Motions_Graphics.mp4', 
 'assets/images/services/3d-icon/marketing.png', 
 '[{"title": "3D Product Renders", "content": "We create hyper-realistic 3D animations of your products, allowing you to showcase features and internal components that are impossible to film with a camera."}, {"title": "Explainer Videos", "content": "Simpify complex software or business processes with engaging 2D animations that guide your customers through your value proposition in seconds."}, {"title": "Live-Event Visuals", "content": "We design heavy-hitting motion backdrops for conferences, trade shows, and music festivals that leave a lasting impression on your live audience."}]', 
 '[{"title": "High Engagement", "text": "Animated content captures 3x more attention than static imagery on social media platforms.", "icon": "bi-eye"}, {"title": "Emotional Storytelling", "text": "We use music, timing, and motion to evoke specific emotions that drive user action and sharing.", "icon": "bi-heart"}, {"title": "Technical Precision", "text": "Our animations are frame-perfect, ensuring smooth playback on everything from phones to giant LEDs.", "icon": "bi-bullseye"}, {"title": "Future proof", "text": "We provide assets in 4K and various aspect ratios to ensure they work for TikTok, YouTube, and Cinema.", "icon": "bi-vector-pen"}]',
 '["Motion Graphics & Ads", "Corporate Video Editing", "Color Grading & Effects"]'
);

-- 4. Software Testing & QA
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert) 
VALUES 
(
 'Software Testing & QA', 
 'software-qa', 
 'Ensure your products are glitch-free. We perform rigorous testing to guarantee a flawless, high-performance software launch.', 
 'Glitch-Free Software Assurance', 
 'assets/images/services/4by3/Software_Testing.mp4', 
 'Quality Assurance', 
 'Reliability You Can Trust Through Rigorous Scientific Testing', 
 'Bugs cost money. Quality saves it. We make sure your users never see a loading error again.', 
 'Weburea\'s QA engineers deliver manual and automated testing solutions that encompass the entire software development lifecycle. We believe that testing is not just a final step, but a continuous process of improvement. Our team specializes in functional testing, usability audits, performance benchmarking, and security vulnerability scans. We use state-of-the-art automation tools like Selenium and Cypress to run regression tests overnight, ensuring that new features never break existing functionality. Our full bug documentation provides clear steps for developers to reproduce and fix issues, significantly reducing time-to-market for your software products.', 
 'assets/images/services/4by3/Software_Testing.mp4', 
 'assets/images/services/3d-icon/database.png', 
 '[{"title": "Automated Regression", "content": "We write scripts that test your entire application in minutes, ensuring that every update is safe and stable for your growing user base."}, {"title": "Penetration Testing", "content": "Our security experts simulate cyberattacks to find and patch vulnerabilities in your system before malicious actors can exploit them."}, {"title": "Performance Stressing", "content": "We simulate thousands of concurrent users to identify where your server might fail, then help you optimize for massive traffic spikes."}]', 
 '[{"title": "Error-Free Launch", "text": "Launch your MVP with 100% confidence, knowing that every button and link works exactly as it should.", "icon": "bi-check-circle"}, {"title": "Device Compatibility", "text": "We test across hundreds of real devices (iOS, Android, Windows) to ensure a consistent experience.", "icon": "bi-phone"}, {"title": "Better User Rating", "text": "Clean, bug-free software leads directly to higher App Store ratings and better customer reviews.", "icon": "bi-star-fill"}, {"title": "Cost Efficiency", "text": "Finding bugs early in the design phase is 10x cheaper than fixing them after the product is live.", "icon": "bi-cash-coin"}]',
 '["Manual & Automation Testing", "API & Performance Checks", "Full Bug Documentation"]'
);

-- 5. Web Design & Development
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert) 
VALUES 
(
 'Web Design & Development', 
 'web-development', 
 'Build scalable, high-performance websites and web applications tailored to your business goals. Frontend to backend mastery.', 
 'Scalable Digital Growth Architectures', 
 'assets/images/services/4by3/Web_Development.mp4', 
 'Web Engineering', 
 'Driving Success Through World-Class Digital Engineering & Excellence', 
 'Custom web solutions that drive business growth through performance-first engineering and design.', 
 'At Weburea, web development is about more than just writing code; it\'s about building a digital foundation for your future. We specialize in creating robust web applications using the MERN stack (MongoDB, Express, React, Node.js), Next.js, and modern PHP architectures like Laravel. Our developers prioritize speed, SEO, and security in every project. We understand that a slow website is a dead website, so we optimize every asset and query for sub-second load times. From custom e-commerce platforms with complex payment integrations to internal business automation tools, we deliver code that is clean, documented, and ready to scale with your company.', 
 'assets/images/services/4by3/Web_Development.mp4', 
 'assets/images/services/3d-icon/development.png', 
 '[{"title": "Full-Stack Mastery", "content": "We handle everything from the database architecture to the pixel-perfect frontend, ensuring a seamless data flow and high performance."}, {"title": "SEO Optimization", "content": "Our code is structured using semantic HTML and schema markup to ensure your site ranks on page one of search engine results from day one."}, {"title": "API Integrations", "content": "We connect your website to third-party tools like Stripe, Salesforce, and HubSpot to automate your business and improve efficiency."}]', 
 '[{"title": "Scalable Code", "text": "Our architectures are built to handle thousands of concurrent users seamlessly without crashing.", "icon": "bi-server"}, {"title": "Mobile First", "text": "Every site we build is perfectly responsive, ensuring a great experience on phones, tablets, and desktops.", "icon": "bi-display"}, {"title": "Ultra-Fast Load", "text": "We optimize images and code to ensure your site loads faster than 90% of the internet.", "icon": "bi-lightning-charge"}, {"title": "Security First", "text": "We implement the latest encryption and security protocols to keep your user data safe from breaches.", "icon": "bi-shield-lock"}]',
 '["Custom Website Build", "Frontend (React/Vue)", "Backend & Optimization"]'
);

-- 6. Video Editing & Production
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert) 
VALUES 
(
 'Video Editing & Production', 
 'video-production', 
 'Professional video production and editing to elevate your marketing and corporate communications to international standards.', 
 'Cinematic Visual Storytelling', 
 'assets/images/services/4by3/Videos_Editing.mp4', 
 'Video Production', 
 'Tell Your Unique Story with Visual Impact and Soul', 
 'Visual content is the language of the modern web, and we speak it fluently through high-end production.', 
 'We provide end-to-end video production services for brands that want to leave a lasting mark. Our editing suite specializes in cinematic color grading, immersive sound design, and narrative pacing. We take raw footage and transform it into a compelling story that aligns with your marketing objectives. Whether it\'s a high-energy brand film, a corporate documentary, or a series of educational videos, Weburea provides the technical expertise and creative vision to elevate your brand above the noise. We work with 4K and 8K footage, ensuring that your content remains high-quality on the largest of screens while being optimized for mobile viewing.', 
 'assets/images/services/4by3/Videos_Editing.mp4', 
 'assets/images/services/3d-icon/consulting.png', 
 '[{"title": "Cinematic Grading", "content": "We use advanced color science to give your footage a premium film look that matches your brand\'s emotional tone and visual style."}, {"title": "Sound Engineering", "content": "Professional audio mixing, foley, and score selection ensure that your video sounds as good as it looks, creating a fully immersive environment."}, {"title": "VFX & Compositing", "content": "We can add digital elements, replace backgrounds, and clean up footage to ensure every shot is perfect and distractions are removed."}]', 
 '[{"title": "Premium Quality", "text": "We deliver studio-grade editing and production that makes your brand look like a global industry leader.", "icon": "bi-star"}, {"title": "Fast Turnaround", "text": "Our optimized editing workflow allows us to deliver high-quality first drafts in as little as 48 hours for short tasks.", "icon": "bi-clock-history"}, {"title": "Engaging Cuts", "text": "Our editors understand pacing and rhythm, ensuring your audience stays engaged from the first second to the last.", "icon": "bi-scissors"}, {"title": "Multi-Platform", "text": "We deliver versions of your video optimized for YouTube, Instagram Reels, LinkedIn, and Cinema screens.", "icon": "bi-play-btn"}]',
 '["Cinematic Editing", "Sound Design & Foley", "VFX & Compositing"]'
);

-- 7. Digital Marketing & Ads
INSERT INTO `services` 
(name, slug, description_short, hero_title, hero_video, overview_badge, overview_title, overview_lead, overview_text, detail_video, icon_3d, ecosystem_json, why_choose_json, home_list_expert) 
VALUES 
(
 'Digital Marketing & Ads', 
 'digital-marketing', 
 'Data-driven marketing campaigns that maximize reach, engagement, and actual revenue conversion for your modern brand.', 
 'Strategic Growth Partnering', 
 'assets/images/services/4by3/Ads_Marketing.mp4', 
 'Growth Strategy', 
 'Maximize Your ROI Through Advanced Data Analytics', 
 'Marketing is an investment, not an expense. We ensure your marketing spend delivers measurable growth.', 
 'Weburea\'s digital marketing team combines creative content with analytical rigor to drive real business results. We don\'t care about "vanity metrics" like likes or follows unless they lead directly to revenue. Our approach covers everything from Search Engine Optimization (SEO) and Pay-Per-Click (PPC) advertising on Google and Meta, to social commerce and influencer partnerships. We build custom marketing funnels that guide potential customers from awareness to purchase, using retargeting ads and email automation to maximize the lifetime value of every customer. Every campaign is tracked and optimized in real-time based on actual performance data.', 
 'assets/images/services/4by3/Ads_Marketing.mp4', 
 'assets/images/services/3d-icon/marketing.png', 
 '[{"title": "Deep-Data Analytics", "content": "We set up advanced tracking ecosystems that show you exactly where your customers are coming from and what they are doing on your site."}, {"title": "Content Engine", "content": "We build a consistent content calendar that positions your brand as a thought leader in your industry, driving trust and organic traffic."}, {"title": "Funnel Automation", "content": "We automate your lead generation and nurturing process, allowing you to close sales while you sleep through intelligent email and ad sequences."}]', 
 '[{"title": "ROI Focused", "text": "We focus on sales and leads, providing you with a clear return on every dollar spent on advertising.", "icon": "bi-graph-up-arrow"}, {"title": "Transparency", "text": "You get monthly reports that explain exactly what we did and what the results were, with no technical jargon.", "icon": "bi-search"}, {"title": "A/B Testing", "text": "We constantly test different headlines, images, and audiences to find the most profitable marketing combinations.", "icon": "bi-diagram-3"}, {"title": "Social Mastery", "text": "We understand the nuances of every platform, from LinkedIn for B2B to TikTok for younger consumer brands.", "icon": "bi-chat-dots"}]',
 '["Content Strategy & Mgmt", "Paid Ad Campaigns", "Community Growth"]'
);
