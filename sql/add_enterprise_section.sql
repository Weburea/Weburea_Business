-- Seed data for dynamic Enterprise Pricing Section
INSERT INTO homepage_sections (section_key, section_name, section_content, status) 
VALUES (
    'pricing_enterprise', 
    'Pricing Enterprise Card', 
    JSON_OBJECT(
        'title', 'Enterprise plan',
        'price_text', 'Custom',
        'description', 'For businesses with unique requirements, our Custom Plan delivers a fully personalized experience.',
        'icon_img', 'assets/images/elements/thunder.png',
        'features_title', 'Quick look at all the features',
        'features', JSON_ARRAY(
            'Unlimited projects',
            'Custom reporting and analytics',
            'Dedicated account manager',
            'Tailored support and consulting',
            'Personalized onboarding and training'
        ),
        'btn_text', 'Contact us',
        'btn_link', '#'
    ), 
    'active'
) 
ON DUPLICATE KEY UPDATE 
    section_name = VALUES(section_name);
