-- Benefits Page Sections Table
CREATE TABLE IF NOT EXISTS benefits_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_key VARCHAR(100) UNIQUE NOT NULL,
    section_name VARCHAR(100) NOT NULL,
    section_content JSON NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Initial Content for all sections
TRUNCATE TABLE benefits_sections;

INSERT INTO benefits_sections (section_key, section_name, section_content) VALUES 
(
    'ben_hero', 
    'Benefits Hero', 
    '{
        "title": "Grow Your Career & Enjoy the <span class=\"text-primary\">Benefits</span>",
        "description": "Join a team where creativity meets innovation. Explore our competitive employee benefits, exciting career opportunities, and comfortable work culture at Weburea.",
        "avatars": [
            "assets/images/avatar/10.jpg",
            "assets/images/avatar/02.jpg",
            "assets/images/avatar/06.jpg",
            "assets/images/avatar/09.jpg",
            "assets/images/avatar/01.jpg"
        ]
    }'
),
(
    'ben_stats', 
    'Benefits Statistics', 
    '{
        "stats": [
            {"value": "360", "suffix": "°", "label": "End-to-end digital solutions"},
            {"value": "5.0", "suffix": "", "label": "World-class design standards", "show_stars": true},
            {"value": "24/7", "suffix": "", "label": "Seamless global remote collaboration"}
        ]
    }'
),
(
    'ben_solutions', 
    'Our Solutions (One Body)', 
    '{
        "title": "Stop juggling freelancers. Build with <span class=\"text-primary\">One Body.</span>",
        "description": "Many businesses have good ideas but no clear digital structure. They design with one person, build with another, and advertise with a third. The result? Confusion and wasted money.",
        "btn_text": "See how we work",
        "btn_link": "about.php",
        "whatsapp_text": "Start your project today",
        "whatsapp_link": "https://wa.me/2348053964571",
        "media_main": "assets/images/about/19.png",
        "media_decor": "assets/images/elements/saas-decoration/05.png",
        "features": [
            {
                "title": "Eliminate Disconnected Work",
                "content": "We solve the \"scattered work\" problem. Nothing is lost in translation because your Designers, Developers, and Marketers work as one team.",
                "icon": "assets/images/elements/hourglass.png"
            },
            {
                "title": "Complete Digital Trust",
                "content": "A CAC license isn''t enough. We build the branding, website, and social presence that makes customers actually trust your business.",
                "icon": "assets/images/elements/report-book.png"
            }
        ]
    }'
),
(
    'ben_tabs',
    'Platform Features (Tabs)',
    '{
        "title": "Discover the power of our platform",
        "description": "We build systems that work together, giving you full control over your digital growth.",
        "tabs": [
            {
                "id": "integration",
                "label": "Integration",
                "icon_svg": "<path d=\"M18 4.375V7.29167M18 4.375C14.3756 4.375 11.0944 5.84407 8.71923 8.21923M18 4.375C21.6241 4.375 24.9052 5.84391 27.2804 8.21883M8.71923 8.21923C6.34407 10.5944 4.875 13.8756 4.875 17.5M8.71923 8.21923L10.7802 10.2802M27.2804 8.21883C29.6557 10.594 31.125 13.8754 31.125 17.5M27.2804 8.21883L25.218 10.2812M4.875 17.5H7.79167M4.875 17.5C4.875 21.1241 6.34391 24.4052 8.71883 26.7804M8.71883 26.7804C11.094 29.1557 14.3754 30.625 18 30.625M8.71883 26.7804L10.7812 24.718M31.125 17.5H28.2083M31.125 17.5C31.125 21.1244 29.6559 24.4056 27.2808 26.7808M27.2808 26.7808C24.9056 29.1559 21.6244 30.625 18 30.625M27.2808 26.7808L25.217 24.717M18 30.625V27.7083M17.9994 15.3125C19.2075 15.3125 20.1875 16.2919 20.1875 17.5C20.1875 18.7081 19.2081 19.6875 18 19.6875C16.7919 19.6875 15.8125 18.7078 15.8125 17.4997C15.8125 16.2919 16.7916 15.3125 17.9994 15.3125ZM17.9994 15.3125V11.3021\" stroke=\"currentColor\" stroke-width=\"2.1875\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />",
                "is_active": true,
                "is_disabled": false,
                "card": {
                    "image": "assets/images/elements/saas-decoration/tab-1.png",
                    "title": "Integrated Development Environment",
                    "description": "We unite your digital ecosystem. From third-party APIs to complex software architecture, we ensure your development stack operates as one cohesive unit.",
                    "list": [
                        "Seamless API integration",
                        "Unified development workflows",
                        "Cross-platform compatibility"
                    ],
                    "metric_value": "100",
                    "metric_symbol": "%",
                    "metric_label": "System Connectivity"
                }
            },
            {
                "id": "analytics",
                "label": "Growth",
                "icon_svg": "<path d=\"M22.6575 5.42667C21.6595 4.99974 21.1604 4.78627 20.5971 5.01507C20.4401 5.07877 20.2396 5.21111 20.1195 5.33027C19.6875 5.75822 19.6875 6.3915 19.6875 7.65809V15.3121H27.3414C28.608 15.3121 29.2413 15.3121 29.6692 14.8802C29.7885 14.7598 29.9208 14.5593 29.9845 14.4025C30.2133 13.8392 29.9998 13.3401 29.5728 12.3421C28.2462 9.24043 25.7591 6.7534 22.6575 5.42667Z\" stroke=\"CurrentColor\" stroke-width=\"2.1875\" stroke-linejoin=\"round\" /><path d=\"M4.375 17.4997C4.375 24.7483 10.2513 30.6247 17.5 30.6247C23.2383 30.6247 28.1164 26.9422 29.9002 21.8115C30.2406 20.8327 30.4108 20.3433 30.1685 19.8116C30.1006 19.6625 29.9669 19.4745 29.8484 19.3614C29.4257 18.958 28.8218 18.958 27.6137 18.958H18.6667C17.5731 18.958 17.0262 18.958 16.6428 18.6795C16.519 18.5895 16.4102 18.4805 16.3202 18.3567C16.0417 17.9735 16.0417 17.4266 16.0417 16.333V7.38588C16.0417 6.17789 16.0417 5.57389 15.6381 5.15123C15.5251 5.03274 15.3371 4.89904 15.188 4.83113C14.6563 4.58886 14.1669 4.75901 13.1881 5.09933C8.05744 6.88319 4.375 11.7614 4.375 17.4997Z\" stroke=\"CurrentColor\" stroke-width=\"2.1875\" stroke-linejoin=\"round\" />\",
                "card": {
                    "image": \"assets/images/elements/saas-decoration/tab-2.png\",
                    "title": \"Strategic Business Growth\",
                    "description": \"We don''t just build; we grow. Our systems are engineered to scale alongside your business, providing the data and tools needed for sustainable expansion.\",
                    "list": [
                        \"Scalable infrastructure planning\",
                        \"Market-driven feature roadmaps\",
                        \"Conversion-optimized user flows\"
                    ],
                    "metric_value": \"85\",
                    "metric_symbol": \"%",
                    "metric_label": \"Growth Acceleration\"
                }
            },
            {
                "id": "reports",
                "label": "Reports",
                "icon_svg": "<path d=\"M18.9596 4.375V5.25C18.9596 8.53102 18.9596 10.1715 19.7953 11.3216C20.0651 11.693 20.3917 12.0196 20.763 12.2894C21.9131 13.125 23.5537 13.125 26.8346 13.125H27.7096M27.7096 14.9287V22.75C27.7096 26.031 27.7096 27.6716 26.8742 28.8216C26.6042 29.1929 26.2775 29.5196 25.9063 29.7895C24.7562 30.625 23.1156 30.625 19.8346 30.625H15.168C11.887 30.625 10.2464 30.625 9.0964 29.7895C8.72499 29.5196 8.39837 29.1929 8.12852 28.8216C7.29297 27.6716 7.29297 26.031 7.29297 22.75V12.25C7.29297 8.96898 7.29297 7.32848 8.12852 6.17843C8.39837 5.80702 8.72499 5.4804 9.0964 5.21055C10.2464 4.375 11.887 4.375 15.168 4.375H17.156C18.5846 4.375 19.2987 4.375 19.9577 4.58913C20.1757 4.65996 20.3878 4.74779 20.5919 4.85185C21.2094 5.16644 21.7144 5.67147 22.7245 6.68153L25.4031 9.36014C26.4132 10.3702 26.9182 10.8752 27.2328 11.4926C27.3369 11.6969 27.4247 11.9089 27.4956 12.1269C27.7096 12.7859 27.7096 13.5001 27.7096 14.9287Z\" stroke=\"currentColor\" stroke-width=\"2.1875\" stroke-linejoin=\"round\" /><path d=\"M18.9596 18.229H11.668M23.3346 22.604H11.668\" stroke=\"currentColor\" stroke-width=\"2.1875\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />\",
                "card": {
                    "image": \"assets/images/elements/saas-decoration/tab-3.png\",
                    "title": \"Real-time Performance Metrics\",
                    "description": \"Gain deep insights into your system''s performance. Our reporting tools provide crystal-clear visibility through intuitive dashboards and automated analytics.\",
                    "list": [
                        \"Live traffic and event tracking\",
                        \"Custom automated KPI reports\",
                        \"Data-driven decision support\"
                    ],
                    "metric_value": \"2.4\",
                    "metric_symbol": \"x\",
                    "metric_label": \"Efficiency Boost\"
                }
            },
            {
                "id": "dashboard-mgmt",
                "label": "Dashboard Management",
                "icon_svg": \"<path d=\\\"M10.2083 24.7918C6.98667 24.7918 4.375 22.1801 4.375 18.9585V15.3127C4.375 11.908 4.375 10.2057 5.06379 8.91701C5.60766 7.89952 6.44102 7.06615 7.45851 6.52228C8.74716 5.8335 10.4495 5.8335 13.8542 5.8335H21.1458C24.5505 5.8335 26.2528 5.8335 27.5415 6.52228C28.559 7.06615 29.3924 7.89952 29.9362 8.91701C30.625 10.2057 30.625 11.908 30.625 15.3127C30.625 18.7173 30.625 20.4196 29.9362 21.7083C29.3924 22.7258 28.559 23.5592 27.5415 24.1031C26.2528 24.7918 24.5505 24.7918 21.1458 24.7918H17.5\\\" stroke=\\\"currentColor\\\" stroke-width=\\\"2.1875\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\" /><path d=\\\"M18.9596 13.125H11.668M23.3346 17.5H11.668\\\" stroke=\\\"currentColor\\\" stroke-width=\\\"2.1875\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\" /><path d=\\\"M10.2083 24.7915L8.75 29.1665L17.5 24.7915\\\" stroke=\\\"currentColor\\\" stroke-width=\\\"2.1875\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\" />\",
                "is_active": false,
                "is_disabled": true,
                "coming_soon": true,
                "card": {
                    "image": \"assets/images/elements/saas-decoration/tab-4.png\",
                    "title": \"Centralized Platform Control\",
                    "description": \"Take control of your entire digital presence from one place. Our management dashboard gives you the power to configure every aspect of your application with ease.\",
                    "list": [
                        \"Granular permission management\",
                        \"Global setting synchronization\",
                        \"Activity and audit logging\"
                    ],
                    "metric_value": \"0\",
                    "metric_symbol": \"\",
                    "metric_label": \"Configuration Latency\"
                }
            }
        ]
    }'
),
(
    'ben_testimonials',
    'What People Say',
    '{
        "title": "What people say about us",
        "subtext": "More than 500+ clients using Weburea platform",
        "ratings": [
            {"platform": "Google", "icon": "assets/images/client/google-icon.svg", "rating": "4.5/5.0"},
            {"platform": "Clutch", "icon": "assets/images/client/clutch-icon.svg", "rating": "4.8/5.0"}
        ],
        "items": [
            {
                "avatar": "assets/images/avatar/09.jpg",
                "name": "Jacqueline Miller",
                "role": "Product designer",
                "content": "Weburea team is incredibly professional and responsive. They took the time to understand our needs and deliver a solution that exceeded our expectations. They demonstrated throughout the process was truly impressive.",
                "rating": 5
            },
            {
                "avatar": "assets/images/avatar/10.jpg",
                "name": "Louis Ferguson",
                "role": "Web Developer",
                "content": "Frequently partiality possession resolution at or appearance unaffected me. Ye goodness felicity do disposal dwelling no.",
                "rating": 5
            },
            {
                "avatar": "assets/images/avatar/04.jpg",
                "name": "Emma Watson",
                "role": "UI/UX designer",
                "content": "Was out laughter raptures returned outweigh. Luckily cheered colonel I do we attack highest enabled. Tried law yet style child. The bore of true of no be deal.",
                "rating": 4.5
            },
            {
                "avatar": "assets/images/avatar/07.jpg",
                "name": "Allen Smith",
                "role": "Manager",
                "content": "Our passion for customer excellence is just one reason why we are the market leader. We''ve always worked very hard to give our customers the best experience.",
                "rating": 4.5
            }
        ]
    }'
);
