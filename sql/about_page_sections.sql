-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 03:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weburea_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_page_sections`
--

CREATE TABLE `about_page_sections` (
  `id` int(11) NOT NULL,
  `section_key` varchar(50) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `section_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`section_content`)),
  `status` enum('active','inactive') DEFAULT 'active',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_page_sections`
--

INSERT INTO `about_page_sections` (`id`, `section_key`, `section_name`, `section_content`, `status`, `updated_at`) VALUES
(1, 'hero', 'Hero Section', '{\"pre_title\":\"About Weburea\",\"main_title_line1\":\"Creativity\",\"main_title_highlight\":\"in Motion\",\"main_title_line2\":\"\",\"lead_text\":\"Weburea Agency is a creative digital studio specializing in UI\\/UX design, motion graphics, software testing, and web applications. We build meaningful, user-centered digital experiences.\",\"bg_image\":\"assets\\/images\\/bg\\/06.png\"}', 'active', '2026-04-24 01:47:02'),
(2, 'company_info', 'About Company', '{\"founding_year\":\"2024\",\"title\":\"Creativity in Motion\",\"description_1\":\"We honestly believe that design should be fluid, creative, and timeless. Weburea stands for pure energy in digital creation.\",\"description_2\":\"Our creative team combines innovative design with strategic insights to deliver visuals with soul\\u2014flexible enough for any digital frontier.\",\"features\":[\"Creative UI\\/UX\",\"Motion Graphics\",\"Software Testing\",\"Web Creation\"],\"btn_text\":\"Explore our work\",\"btn_link\":\"portfolio-grid.php\"}', 'active', '2026-04-24 01:47:52'),
(3, 'awards', 'Awards & Achievements', '{\n    \"title\": \"Our awards and achievements\",\n    \"award_list\": [\n        {\"icon\": \"assets/images/elements/fwa-light.svg\", \"label\": \"Digital vanguard award\"},\n        {\"icon\": \"assets/images/elements/clutch-light.svg\", \"label\": \"Best website of the week\"},\n        {\"icon\": \"assets/images/elements/webby.svg\", \"label\": \"5X developer awards\"}\n    ],\n    \"side_image\": \"assets/images/elements/awards-saly.png\"\n}', 'active', '2026-04-24 00:39:07'),
(4, 'history', 'Company History', '{\n    \"title\": \"A legacy of creativity and growth\",\n    \"timeline\": [\n        {\"year\": \"Present - 2024\", \"title\": \"Vision for the Future\", \"content\": \"We are excited to explore new opportunities and expand our services.\"},\n        {\"year\": \"2022\", \"title\": \"Reaching new heights\", \"content\": \"Our commitment to quality and innovation continued to drive our growth.\"},\n        {\"year\": \"2020\", \"title\": \"Adapting and innovating\", \"content\": \"Significant pivot towards digital solutions and collaboration tools.\"},\n        {\"year\": \"2014\", \"title\": \"Industry recognition\", \"content\": \"Accolades that highlighted our capabilities and motivated us.\"},\n        {\"year\": \"2008\", \"title\": \"The Beginning\", \"content\": \"Founded with a vision to revolutionize the visual design industry.\"}\n    ]\n}', 'active', '2026-04-24 00:39:07'),
(5, 'team_preview', 'Team Preview', '{\n    \"title\": \"Meet the minds behind the magic\",\n    \"description\": \"Our team is a blend of creative thinkers, tech enthusiasts, and strategic planners.\",\n    \"members\": [\n        {\"name\": \"Emma Watson\", \"role\": \"CEO & Founder\", \"image\": \"assets/images/team/01.jpg\"},\n        {\"name\": \"Samuel Bishop\", \"role\": \"Creative Director\", \"image\": \"assets/images/team/02.jpg\"},\n        {\"name\": \"Sarah Brown\", \"role\": \"Lead Developer\", \"image\": \"assets/images/team/03.jpg\"}\n    ]\n}', 'active', '2026-04-24 00:39:07'),
(11, 'mission_vision', '', '{\"mission\":{\"title\":\"Our mission\",\"content\":\"To build meaningful, user-centered digital experiences that combine creativity, strategy, and technology.\",\"icon\":\"bi bi-lightning-charge-fill text-success\"},\"vision\":{\"title\":\"Our vision\",\"content\":\"Weburea is to be recognized as a leading force in the world of visual communication and creativity in motion.\",\"icon\":\"bi bi-rocket-takeoff-fill text-pink\"},\"goal\":{\"title\":\"Our goal\",\"content\":\"Our aim is to not only meet our clients\' objectives but to surpass them, earning their trust and loyalty through fluid and timeless design.\",\"icon\":\"bi bi-bullseye text-warning\"}}', 'active', '2026-04-24 01:47:23'),
(12, 'awards_intro', 'Awards Intro', '{\"founding_year\":\"2025\",\"title\":\"Bringing ideas to life\",\"description_1\":\"Our creative experts blend innovation with strategy to turn your vision into reality.\",\"description_2\":\"We believe great design is strategic. Our approach combines industry knowledge with creative insights to ensure your visual identity is impactful and results-driven.\",\"list_items\":[\"UI\\/UX Design\",\"Motion Graphics\",\"Software Testing\",\"Web Application\"],\"btn_text\":\"Explore our services\",\"btn_link\":\"services-list.html\"}', 'active', '2026-04-24 02:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_page_sections`
--
ALTER TABLE `about_page_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_page_sections`
--
ALTER TABLE `about_page_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
