-- Weburea Agency - Portfolio Dummy Testimonial Population
-- Populates existing works with high-fidelity JSON dummy data for demonstration.

USE weburea_db;

UPDATE portfolio_works 
SET testimonials_json = '[
    {
        "text": "Weburea transformed our digital presence with a stunning, high-performance platform. Their attention to detail in UI/UX and rigorous QA process gave us the confidence to launch globally.",
        "author": "Emma Thompson",
        "role": "Product Director at TechNova",
        "image": "assets/images/avatar/01.jpg"
    },
    {
        "text": "The team\'s ability to handle complex backend challenges while maintaining a pixel-perfect frontend is unmatched. We saw a 40% increase in user engagement within the first month of launch.",
        "author": "David Chen",
        "role": "CEO of Zenith Solutions",
        "image": "assets/images/avatar/02.jpg"
    },
    {
        "text": "Exceptional communication and delivery. They didn\'t just build a website; they built a brand identity that truly resonates with our audience. Highly recommended for any ambitious startup.",
        "author": "Sophia Rodriguez",
        "role": "Marketing Lead at Aura Digital",
        "image": "assets/images/avatar/03.jpg"
    }
]'
WHERE (testimonials_json IS NULL OR testimonials_json = '' OR testimonials_json = '[]')
AND status = 'published';
