<?php
require_once('include/db.php');

try {
    // Create Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS homepage_sections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section_key VARCHAR(100) UNIQUE NOT NULL,
        section_name VARCHAR(100) NOT NULL,
        section_content JSON NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    echo "Table created.\n";

    // Seed Data using PHP to ensure valid JSON
    $seed = [
        'hero' => [
            'name' => 'Hero Banner',
            'content' => [
                'pre_title' => 'Creativity in Motion',
                'main_title_prefix' => 'We build meaningful experiences with',
                'lead_text' => 'Weburea combines creativity, strategy, and technology. As Africa’s emerging creative powerhouse, we deliver high-fidelity design, robust software testing, and cinematic motion graphics.',
                'btn1_text' => 'Explore Services',
                'btn1_link' => 'services.php',
                'btn2_text' => 'Get a Quote',
                'btn2_link' => 'contact.php'
            ]
        ],
        'gallery' => [
            'name' => 'Scrolling Gallery',
            'content' => [
                'images' => [
                    "assets/images/pages-ss/01.jpg",
                    "assets/images/pages-ss/02.jpg",
                    "assets/images/pages-ss/03.jpg",
                    "assets/images/pages-ss/04.jpg",
                    "assets/images/pages-ss/05.jpg",
                    "assets/images/pages-ss/06.jpg",
                    "assets/images/pages-ss/07.jpg",
                    "assets/images/pages-ss/08.jpg",
                    "assets/images/pages-ss/09.jpg",
                    "assets/images/pages-ss/10.jpg",
                    "assets/images/pages-ss/11.jpg",
                    "assets/images/pages-ss/12.jpg",
                    "assets/images/pages-ss/13.jpg",
                    "assets/images/pages-ss/14.jpg",
                    "assets/images/pages-ss/15.jpg",
                    "assets/images/pages-ss/16.jpg",
                    "assets/images/pages-ss/17.jpg",
                    "assets/images/pages-ss/18.jpg",
                    "assets/images/pages-ss/19.jpg",
                    "assets/images/pages-ss/20.jpg",
                    "assets/images/pages-ss/21.jpg",
                    "assets/images/pages-ss/22.jpg"
                ]
            ]
        ],
        'stats' => [
            'name' => 'Impact Statistics',
            'content' => [
                'counters' => [
                    ['label' => 'Team Years of experience', 'value' => 7, 'suffix' => '+', 'color' => 'primary'],
                    ['label' => 'Projects Delivered', 'value' => 20, 'suffix' => '+', 'color' => 'pink'],
                    ['label' => 'Client Satisfaction', 'value' => 99, 'suffix' => '%', 'color' => 'info'],
                    ['label' => 'Avg. Turnaround Time', 'value' => 24, 'suffix' => 'h', 'color' => 'warning']
                ]
            ]
        ],
        'benefits' => [
            'name' => 'Benefits & Icons',
            'content' => [
                'title' => 'Streamline operations and experience the <span class="text-primary">benefits of Weburea</span>',
                'description' => 'Eliminate the hassle and hidden costs of managing multiple vendors. By consolidating your creative, development, and testing needs with us, you get a unified workflow, consistent quality, and significant cost savings.',
                'btn_text' => 'Explore all benefits',
                'btn_link' => '#contact-us',
                'floating_icons' => [
                    ['name' => 'Motion Graphics', 'img' => 'assets/images/client/icons/adobe-illustrator.svg', 'size' => 'md', 'shadow' => 'primary'],
                    ['name' => 'UI/UX Design', 'img' => 'assets/images/client/icons/figma.svg', 'size' => 'lg', 'shadow' => 'primary'],
                    ['name' => 'Web Development', 'img' => 'assets/images/client/icons/jira.svg', 'size' => 'lg', 'shadow' => 'primary'],
                    ['name' => 'QA Testing', 'img' => 'assets/images/client/icons/slack.svg', 'size' => 'xl', 'shadow' => 'primary'],
                    ['name' => 'Efficiency', 'img' => 'assets/images/client/icons/social.svg', 'size' => 'xl', 'shadow' => 'primary'],
                    ['name' => 'Brand Strategy', 'img' => 'assets/images/client/icons/social-media.svg', 'size' => 'lg', 'shadow' => 'primary'],
                    ['name' => 'Social Media', 'img' => 'assets/images/client/icons/trello.svg', 'size' => 'lg', 'shadow' => 'primary'],
                    ['name' => 'Business Growth', 'img' => 'assets/images/client/icons/04.svg', 'size' => 'md', 'shadow' => 'primary']
                ]
            ]
        ],
        'advantages' => [
            'name' => 'Advantages & Avatars',
            'content' => [
                'text' => "Discover the full scope of Weburea's advantages.",
                'link_text' => 'View more benefit details',
                'link_url' => 'benefits.php',
                'avatars' => [
                    "assets/images/avatar/02.jpg",
                    "assets/images/avatar/05.jpg",
                    "assets/images/avatar/10.jpg",
                    "assets/images/avatar/09.jpg"
                ]
            ]
        ],
        'cta' => [
            'name' => 'Call To Action Banner',
            'content' => [
                'title' => 'Ready to put your design on',
                'title_highlight' => 'auto-pilot?',
                'list_items' => [
                    'Pause or cancel anytime',
                    'Flat monthly rate'
                ],
                'btn_text' => 'View subscription plans',
                'btn_link' => 'pricing.php'
            ]
        ],
        'reviews' => [
            'name' => 'Trusted Leaders & Reviews',
            'content' => [
                'title' => 'Trusted by industry leaders',
                'rating_badge' => '4.9/5.0',
                'rating_text' => 'by over 100,000+ users',
                'rating_avatars' => [
                    "assets/images/avatar/02.jpg",
                    "assets/images/avatar/05.jpg",
                    "assets/images/avatar/10.jpg",
                    "assets/images/avatar/09.jpg"
                ],
                'review_cards' => [
                    [
                        'name' => 'Jacqueline Miller',
                        'handle' => '@jaqmilr56',
                        'avatar' => 'assets/images/avatar/09.jpg',
                        'content' => 'Their team went above and beyond to understand our needs.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 1
                    ],
                    [
                        'name' => 'Louis Ferguson',
                        'handle' => '@fregulois2589',
                        'avatar' => 'assets/images/avatar/02.jpg',
                        'content' => 'Frequently partiality possession resolution at or appearance unaffected me.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 1
                    ],
                    [
                        'name' => 'Allen Smith',
                        'handle' => '@smith4u',
                        'avatar' => 'assets/images/avatar/05.jpg',
                        'content' => 'Working with this team has been an absolute pleasure. They took the time to understand our vision.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 2
                    ],
                    [
                        'name' => 'Michael Davis',
                        'handle' => '@Davischhotu',
                        'avatar' => 'assets/images/avatar/08.jpg',
                        'content' => 'Our passion for customer excellence is just one reason why we are the market leader.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 2
                    ],
                    [
                        'name' => 'Samuel Bishop',
                        'handle' => '@samshop',
                        'avatar' => 'assets/images/avatar/06.jpg',
                        'content' => 'Two before narrow not relied on how except moment myself Dejection assurance.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 3
                    ],
                    [
                        'name' => 'Sarah Brown',
                        'handle' => '@Brownmunde',
                        'avatar' => 'assets/images/avatar/01.jpg',
                        'content' => 'Was out laughter raptures returned outweigh. Luckily cheered colonel.',
                        'social_icon' => 'bi bi-twitter-x',
                        'column' => 3
                    ]
                ]
            ]
        ],
        'testimonials' => [
            'name' => 'Client Testimonials Slider',
            'content' => [
                'title' => 'Client Testimonials 😍',
                'clients_text' => 'More than 500+ clients using <span class="text-primary">Weburea</span> platform',
                'platform_ratings' => [
                    [
                        'platform' => 'App Store',
                        'rating' => 4.8,
                        'icon' => 'assets/images/elements/apple.svg'
                    ],
                    [
                        'platform' => 'Google',
                        'rating' => 4.6,
                        'icon' => 'assets/images/elements/gicon.svg'
                    ]
                ],
                'testimonial_items' => [
                    [
                        'name' => 'Jacqueline Miller',
                        'role' => 'Product designer',
                        'avatar' => 'assets/images/avatar/09.jpg',
                        'rating' => 4.5,
                        'quote' => "Our passion for customer excellence is just one reason why we are the market leader. We've always worked very hard to give our customers the best experience. Was out laughter raptures returned outweigh. Luckily cheered colonel I do we attack highest enabled."
                    ],
                    [
                        'name' => 'Louis Ferguson',
                        'role' => 'Web Developer',
                        'avatar' => 'assets/images/avatar/10.jpg',
                        'rating' => 5.0,
                        'quote' => "Their team went above and beyond to understand our needs and deliver a solution that exceeded our expectations. They demonstrated throughout the process was truly impressive."
                    ],
                    [
                        'name' => 'Emma Watson',
                        'role' => 'UI/UX designer',
                        'avatar' => 'assets/images/avatar/01.jpg',
                        'rating' => 4.5,
                        'quote' => "Was out laughter raptures returned outweigh. Luckily cheered colonel I do we attack highest enabled. Tried law yet style child. The bore of true of no be deal."
                    ]
                ]
            ]
        ]
    ];

    foreach ($seed as $key => $data) {
        $stmt = $pdo->prepare("INSERT INTO homepage_sections (section_key, section_name, section_content) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE section_content = VALUES(section_content)");
        $stmt->execute([$key, $data['name'], json_encode($data['content'])]);
        echo "Seeded section: $key\n";
    }

    echo "All sections seeded successfully.\n";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
