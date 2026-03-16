-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 16, 2026 at 12:18 PM
-- Server version: 12.1.2-MariaDB-ubu2404
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `festivaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `artist_name`, `age`, `nationality`, `genre`, `about`) VALUES
(1, 'Hardwell', '38', 'Dutch', 'dance and house', 'Hardwell, a two-time DJ Mag #1 DJ in the World, is renowned for his explosive sets and anthems like Spaceman. Headlining Tomorrowland and Ultra, he’s a trailblazer in electronic music, known for pushing boundaries with his festival hits and groundbreaking performances.'),
(2, 'Armin van Buuren', '49', 'Dutch', 'trance and techno', 'Armin van Buuren, a five-time DJ Mag #1 DJ, is a global trance legend. Known for his iconic A State of Trance radio show, he has headlined every major festival, earned Grammy nominations, and captivated millions with hits like This Is What It Feels Like.'),
(3, 'Martin Garrix', '29', 'Dutch', 'dance / electronic', 'Martin Garrix rose to global stardom with his smash hit Animals and has since headlined festivals like Coachella and Tomorrowland. A three-time winner of DJ Mag’s #1 DJ in the World title, he’s collaborated with icons like Dua Lipa, Usher, and David Guetta, solidifying his place as a trailblazer in EDM.'),
(4, 'Tiësto', '57', 'Dutch', 'trance, techno, minimal, house, electro', 'Tiësto, a Grammy-winning DJ and producer, has shaped electronic music for decades. With legendary tracks like Adagio for Strings and The Business, he’s headlined festivals worldwide, from Tomorrowland to Coachella, solidifying his status as a global dance music icon.'),
(5, 'Nicky Romero', '37', 'Dutch', 'electrohouse / progressive house', 'Nicky Romero, a chart-topping DJ and producer, gained global fame with hits like Toulouse and I Could Be the One with Avicii. A festival favorite at Tomorrowland and Ultra, he’s also the founder of Protocol Recordings, nurturing the next generation of electronic music talent.'),
(6, 'Afrojack', '37', 'Dutch', 'house', 'Afrojack, a global EDM icon, has headlined the world’s biggest festivals, including Tomorrowland and Ultra Music Festival. Known for chart-topping hits like Take Over Control and collaborations with stars like Beyoncé, David Guetta, and Pitbull, he continues to redefine the electronic music scene.');

-- --------------------------------------------------------

--
-- Table structure for table `artist_musics`
--

CREATE TABLE `artist_musics` (
  `artist_music_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `music_title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `music_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dance_venues`
--

CREATE TABLE `dance_venues` (
  `venue_id` int(11) NOT NULL,
  `venue_name` varchar(255) NOT NULL,
  `venue_location` varchar(255) NOT NULL,
  `name` varchar(255) GENERATED ALWAYS AS (`venue_name`) STORED,
  `location` varchar(255) GENERATED ALWAYS AS (`venue_location`) STORED,
  `capacity` int(11) NOT NULL,
  `venue_image` varchar(255) DEFAULT NULL,
  `map_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dance_venues`
--

INSERT INTO `dance_venues` (`venue_id`, `venue_name`, `venue_location`, `capacity`, `venue_image`, `map_url`) VALUES
(1, 'Lichtfabriek', 'Minckelersweg 2, 2031 EM Haarlem', 1500, 'aaa', 'aaaaa'),
(2, 'Sachthuis', 'Rockplein 6, 2033 KK Haarlem', 100, '', ''),
(3, 'Jopenkerk', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', 100, '', ''),
(4, 'XO the Club', 'Grote Markt 8, 2011 RD Haarlem', 100, '', ''),
(5, 'Puncher comedy club', 'Grote Markt 10, 2011 RD Haarlem', 100, '', ''),
(6, 'Caprera Openluchttheater', 'Hoge Duin en Daalseweg 2, 2061 AG Bloemendaal', 100, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `primary_theme_color` varchar(20) DEFAULT NULL,
  `secondary_theme_color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_type`, `title`, `image_url`, `description`, `status`, `start_date`, `end_date`, `primary_theme_color`, `secondary_theme_color`) VALUES
(1, 'Yummy', 'Yummy', '69aaff2f8caa86.87631750_yummy-events.jpg', 'Are you coming to the yummy event in Haarlem? For four days, you\'ll enjoy the most delicious dishes in Haarlem\'s Grote Markt. Don\'t miss out! Enjoy various tastings and live bands. Gather your group. Admission is free, so mark the dates in your calendar.\r\n', 1, '2026-07-26', '2026-07-30', 'D35472', 'F57B5F'),
(2, 'Dance', 'Dance', '69b576fc6deb83.96166153_Dance (1).png', 'Experience an unforgettable weekend of music, energy, and world-class DJs in Haarlem!', 1, '2026-06-27', '2026-06-28', 'D35472', 'F57B5F');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `image_url`, `name`) VALUES
(1, '/images/69a98251800624.94485628_Placeholder-Image-2.png', 'Planning a party?'),
(2, '/images/69acac2f884617.63145441_639565879_18079722086596251_5554071152351958995_n.jpg', 'Best value of food');

-- --------------------------------------------------------

--
-- Table structure for table `history_events`
--

CREATE TABLE `history_events` (
  `history_event_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_event_date`
--

CREATE TABLE `history_event_date` (
  `event_date_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_info`
--

CREATE TABLE `history_info` (
  `content_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `section_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_tickets`
--

CREATE TABLE `history_tickets` (
  `history_ticket_id` int(11) NOT NULL,
  `history_event_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `ticket_type` enum('Regular','Family') NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `event_date_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tour_location_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_timeslots`
--

CREATE TABLE `history_timeslots` (
  `timetable_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_tours`
--

CREATE TABLE `history_tours` (
  `tour_id` int(11) NOT NULL,
  `timetable_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `available_guides` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music_events`
--

CREATE TABLE `music_events` (
  `music_event_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `artist_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `event_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `session_type` varchar(100) NOT NULL DEFAULT 'Club',
  `event_start_time` time NOT NULL,
  `event_duration` int(11) NOT NULL,
  `music_event_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music_event_tickets`
--

CREATE TABLE `music_event_tickets` (
  `music_ticket_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) NOT NULL,
  `music_event_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `session_type` enum('Club','Back to Back') NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music_performance`
--

CREATE TABLE `music_performance` (
  `music_performance_id` int(11) NOT NULL,
  `music_event_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `session_type` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_duration` int(11) NOT NULL,
  `event_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'completed',
  `payment_date` datetime DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `payment_method`, `payment_status`, `payment_date`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 7, 30.00, NULL, 'completed', NULL, '2026-03-08 00:07:34', '2026-03-08 00:07:34', '2026-03-08 00:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `title`, `content`, `active`, `slug`) VALUES
(2, 'Yummy', NULL, 1, 'yummy'),
(3, 'About', NULL, 1, 'about'),
(4, 'Events', NULL, 1, 'events');

-- --------------------------------------------------------

--
-- Table structure for table `price_list`
--

CREATE TABLE `price_list` (
  `list_id` int(11) NOT NULL,
  `ticket_type` enum('Regular','Family','Daily Pass','All Access Pass') NOT NULL,
  `price` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reservation_date` date NOT NULL,
  `total_adult` int(11) NOT NULL DEFAULT 1,
  `total_children` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `confirmation_code` varchar(100) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ratings` tinyint(4) NOT NULL,
  `cuisines` varchar(255) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `location` varchar(500) NOT NULL,
  `number_of_seats` int(11) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `gallery_images` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `title`, `image_url`, `description`, `ratings`, `cuisines`, `session_id`, `event_id`, `location`, `number_of_seats`, `contact_email`, `contact_phone`, `gallery_images`) VALUES
(1, 'Café de Roemer', '/images/69aafdbf458ae4.44129310_yummy_events.jpg', '&lt;p&gt;Welcome to Café de Roemer, an iconic spot located on Botermarkt in the heart of Haarlem. A Haarlem institution for over 30 years, it&#039;s now owned by two enthusiastic entrepreneurs who are continuing the Roemer legacy with renewed energy. Step inside and discover our diverse menu, where classics meet surprising new flavors. Whether you&#039;re looking for a delicious lunch, a leisurely dinner, or just a relaxing drink, you&#039;re sure to find something to suit your taste. Enjoy the sun on our spacious and sunny terrace, or experience the outdoors year-round in our beautiful glass conservatory. Whatever the weather, at Café de Roemer we always offer a warm welcome and a cozy atmosphere. Our team is ready to make your experience unforgettable, with enthusiasm, hospitality, and a smile. Whether you&#039;re stopping by for a quick bite or a long night out, you&#039;ll always feel at home at Café de Roemer. Come visit us and discover the unique charm of Café de Roemer for yourself. We look forward to welcoming you!&lt;/p&gt;', 4, 'Dutch, fish and seafood, European', 1, 1, 'Botermarkt 17, 2011 XL Haarlem', 35, 'info@cafederoemer.nl', '02857488', '[\"\\/images\\/69aafdbf479990.19159331_yummy_events.jpg\",\"\\/images\\/69acae9da4a2e0.32909133_639565879_18079722086596251_5554071152351958995_n.jpg\",\"\\/images\\/69acae9daf53d2.17401647_642509984_18080492510596251_7090866304138896856_n.jpg\",\"\\/images\\/69acae9dba47c4.44593639_643545031_18080492501596251_1310653718942307600_n.jpg\",\"\\/images\\/69acae9dc2c316.06554831_645841499_18080957423596251_3190953387532787824_n.jpg\"]');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_features`
--

CREATE TABLE `restaurant_features` (
  `restaurant_features_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_features`
--

INSERT INTO `restaurant_features` (`restaurant_features_id`, `restaurant_id`, `feature_id`) VALUES
(10, 1, 1),
(11, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_sub_title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `map_url` varchar(255) DEFAULT NULL,
  `section_type` varchar(100) DEFAULT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_title`, `section_sub_title`, `content`, `image_url`, `map_url`, `section_type`, `page_id`) VALUES
(1, 'A DELICIOUSLY COMPOSED MENU', '', '<font color=\"#2a4634\" face=\"helvetica-w01-light, sans-serif\">Our menu is inspired by the flavors of the Mediterranean, with a mix of delicious tapas, tasty mezze, fresh main courses and tempting desserts.  ​  Whether you\'re coming for dinner, a cozy evening with friends, or drinks on our terrace: Vester is all about sharing, enjoying, and experiencing together. Be amazed by our dishes and discover the perfect combination of authentic flavors, fresh ingredients, and stylish presentation.  ​  Take a look and plan your favorites for an unforgettable evening!</font>', '/images/69a982efaaf230.79610024_Haarlem-Culinair-Blackline-Media-Edit-52-1-2048x1365.jpg', 'https://maps.app.goo.gl/o69KfbnbDv6tDm8q8', 'header', 2),
(2, 'About Us', '', '<p>Our journey began at Inholland University of Applied Sciences, where we met as a team of students passionate about technology and problem-solving. With backgrounds in IT and a shared curiosity for how digital solutions could make life easier, we often found ourselves discussing real-world challenges and how software could solve them. It wasn’t long before the idea sparked: What if we started our own IT company—one that focused not on trends or hype, but on building useful, reliable tools that actually help businesses grow? That idea became our mission. We founded our company with one goal in mind: to build valuable digital products that solve real business problems. From the start, we’ve focused on clarity, practicality, and purpose—cutting through the noise to deliver solutions that truly support teams and organizations. Our vision is simple: empower businesses to scale and thrive through technology. We believe digital tools should feel like an extension of your goals, not a barrier. That means making digital less confusing, more helpful, and always aligned with your needs. We’re human-first, results-driven, and always collaborative. We listen before we build. We explain things clearly. We avoid shortcuts, respect your time, and treat every project like a partnership. With us, you’ll always know where things stand, and what’s coming next. This is our story—rooted in curiosity, grown through collaboration, and driven by a commitment to help businesses succeed with technology that works. #inholland hashtag #LearningTogether hashtag #InhollandUniversityofAppliedSciences</p>', '', '', 'instruction', 3),
(3, 'You don\'t want to miss this', '', '<font color=\"#4a4a49\" face=\"WixMadeforText-VariableFont_wght, sans-serif\"><span style=\"font-size: 17px;\">From Dutch Masters to modern art, from arthouse films to children\'s theater, from pop concerts to city history: if you\'re looking for inspiration, art, and culture, Haarlem is sure to satisfy your cravings. Not only is Haarlem home to the oldest museum in the Netherlands, but its historic city center is also bustling with cultural hotspots, (art) history, and creative initiatives.</span></font>', '', '', 'tour_information', 4),
(4, 'Art and Culture', '', '<p>Be amazed by Haarlem\'s rich art and culture. Will it be a museum, the theater, or a stroll past historic monuments?&nbsp; Haarlem\'s artistic soul. Haarlem is a paradise for art lovers, with a wide range of museums, galleries, and cultural events. Immerse yourself in the city\'s artistic offerings and witness the interplay between tradition and innovation. Art and culture in Haarlem truly embrace and celebrate the spirit of creativity. Here\'s a glimpse of what this enchanting city has to offer</p>', '', '', 'header', 4);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `session_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `session_type` varchar(100) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `sessions_per_day` int(11) DEFAULT NULL,
  `total_session` int(11) DEFAULT NULL,
  `duration` varchar(50) NOT NULL,
  `first_session` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_date`, `start_time`, `end_time`, `session_type`, `event_id`, `venue_id`, `restaurant_id`, `capacity`, `sessions_per_day`, `total_session`, `duration`, `first_session`) VALUES
(2, NULL, '17:00:00', NULL, NULL, 1, NULL, 1, NULL, 3, 3, '1.5', '17:00:00'),
(3, NULL, '18:00:00', NULL, NULL, 1, NULL, 1, NULL, 3, 3, '1.5', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(50) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_pass`
--

CREATE TABLE `ticket_pass` (
  `pass_id` int(11) NOT NULL,
  `passName` varchar(255) DEFAULT NULL,
  `passDescription` text DEFAULT NULL,
  `passPrice` decimal(10,2) DEFAULT NULL,
  `passType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_language`
--

CREATE TABLE `tour_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_language`
--

INSERT INTO `tour_language` (`language_id`, `name`) VALUES
(1, 'Dutch'),
(2, 'English'),
(3, 'Mandarin');

-- --------------------------------------------------------

--
-- Table structure for table `tour_locations`
--

CREATE TABLE `tour_locations` (
  `tour_location_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `contact_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_timetable`
--

CREATE TABLE `tour_timetable` (
  `timetable_id` int(11) NOT NULL,
  `event_date_id` int(11) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(250) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('Visitor','Customer','Admin','Employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `profile_picture`, `registration_date`, `role`) VALUES
(5, 'Ahsanul Rabbi Khan', 'admin@gmail.com', '$2y$12$0EbV0MT.dKL3EUsM0pKJX.iY4yOA6RSXLw.cpxH9TulLldTE9HPJ2', 'download-5.jpeg', '2026-03-02 21:49:06', 'Admin'),
(6, 'Ahasanul Rabbi Khan', 'ahsan@gmail.com', '$2y$12$TnGSKXJmH0IYI1TzVWsPFunSDnlbU0XEcTblb8J0fNLrIDUryA5Aa', 'download-5.jpeg', '2026-03-06 20:03:12', 'Admin'),
(7, 'Ahsanul Rabbi Khan', 'me.ahsanul01@gmail.com', '$2y$12$x6juwndsZypeVtoKPTZWaOCsRD9s6ml1X4QBlmUx9DEAxlGSikGLi', 'download-5.jpeg', '2026-03-08 00:06:16', 'Customer'),
(8, 'Tabeeb', 'tabeeb@gmail.com', '$2y$12$zoaz2udD5ND.0kZ5rT45JOxsXT7UTOyX1omw36WnzpjTBExLQGQxu', '/images/69af97612f35d6.29856032_sign.jpg', '2026-03-10 04:00:33', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `artist_to_album` (`artist_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `artist_musics`
--
ALTER TABLE `artist_musics`
  ADD PRIMARY KEY (`artist_music_id`),
  ADD KEY `artist_to_music` (`artist_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`),
  ADD KEY `artist_to_awards` (`artist_id`);

--
-- Indexes for table `dance_venues`
--
ALTER TABLE `dance_venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `history_events`
--
ALTER TABLE `history_events`
  ADD PRIMARY KEY (`history_event_id`),
  ADD KEY `history_to_events` (`event_id`);

--
-- Indexes for table `history_event_date`
--
ALTER TABLE `history_event_date`
  ADD PRIMARY KEY (`event_date_id`);

--
-- Indexes for table `history_info`
--
ALTER TABLE `history_info`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `history_tickets`
--
ALTER TABLE `history_tickets`
  ADD PRIMARY KEY (`history_ticket_id`),
  ADD KEY `history_to_tickets` (`ticket_id`),
  ADD KEY `history_to_language` (`language_id`),
  ADD KEY `tour_to_date` (`event_date_id`),
  ADD KEY `tour_to_time` (`timetable_id`),
  ADD KEY `tour_to_location` (`tour_location_id`),
  ADD KEY `history_ticket_to_history_event` (`history_event_id`);

--
-- Indexes for table `history_timeslots`
--
ALTER TABLE `history_timeslots`
  ADD PRIMARY KEY (`timetable_id`);

--
-- Indexes for table `history_tours`
--
ALTER TABLE `history_tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `timetable_id` (`timetable_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `music_events`
--
ALTER TABLE `music_events`
  ADD PRIMARY KEY (`music_event_id`),
  ADD KEY `event_to_music_event` (`event_id`),
  ADD KEY `artist_to_music_event` (`artist_id`),
  ADD KEY `venue_to_music_event` (`venue_id`);

--
-- Indexes for table `music_event_tickets`
--
ALTER TABLE `music_event_tickets`
  ADD KEY `ticket_to_music_event` (`music_event_id`),
  ADD KEY `music_ticket_to_ticket` (`ticket_id`),
  ADD KEY `ticket_to_venue` (`venue_id`),
  ADD KEY `ticket_to_music_artists` (`artist_id`);

--
-- Indexes for table `music_performance`
--
ALTER TABLE `music_performance`
  ADD PRIMARY KEY (`music_performance_id`),
  ADD KEY `idx_mp_music_event_id` (`music_event_id`),
  ADD KEY `idx_mp_event_id` (`event_id`),
  ADD KEY `idx_music_performance_artist_id` (`artist_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_to_orders` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_to_items` (`order_id`),
  ADD KEY `event_to_items` (`event_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `events_id` (`event_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_to_reservation` (`user_id`),
  ADD KEY `session_to_reservation` (`session_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `restaurant_features`
--
ALTER TABLE `restaurant_features`
  ADD PRIMARY KEY (`restaurant_features_id`),
  ADD KEY `restaurant_to_restaurant_features` (`restaurant_id`),
  ADD KEY `feature_to_restaurant_feature` (`feature_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `idx_sessions_restaurant_id` (`restaurant_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `uq_ticket_qr_code` (`qr_code`),
  ADD KEY `ticket_to_event` (`event_id`);

--
-- Indexes for table `ticket_pass`
--
ALTER TABLE `ticket_pass`
  ADD PRIMARY KEY (`pass_id`);

--
-- Indexes for table `tour_language`
--
ALTER TABLE `tour_language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `tour_locations`
--
ALTER TABLE `tour_locations`
  ADD PRIMARY KEY (`tour_location_id`);

--
-- Indexes for table `tour_timetable`
--
ALTER TABLE `tour_timetable`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `timetable_to_event` (`event_date_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artist_musics`
--
ALTER TABLE `artist_musics`
  MODIFY `artist_music_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dance_venues`
--
ALTER TABLE `dance_venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history_event_date`
--
ALTER TABLE `history_event_date`
  MODIFY `event_date_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_tickets`
--
ALTER TABLE `history_tickets`
  MODIFY `history_ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_timeslots`
--
ALTER TABLE `history_timeslots`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_tours`
--
ALTER TABLE `history_tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `music_events`
--
ALTER TABLE `music_events`
  MODIFY `music_event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `music_performance`
--
ALTER TABLE `music_performance`
  MODIFY `music_performance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price_list`
--
ALTER TABLE `price_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant_features`
--
ALTER TABLE `restaurant_features`
  MODIFY `restaurant_features_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_pass`
--
ALTER TABLE `ticket_pass`
  MODIFY `pass_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_language`
--
ALTER TABLE `tour_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_locations`
--
ALTER TABLE `tour_locations`
  MODIFY `tour_location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_timetable`
--
ALTER TABLE `tour_timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `artist_to_album` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `artist_musics`
--
ALTER TABLE `artist_musics`
  ADD CONSTRAINT `artist_to_music` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `artist_to_awards` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_events`
--
ALTER TABLE `history_events`
  ADD CONSTRAINT `history_to_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_tickets`
--
ALTER TABLE `history_tickets`
  ADD CONSTRAINT `history_ticket_to_history_event` FOREIGN KEY (`history_event_id`) REFERENCES `history_events` (`history_event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_to_language` FOREIGN KEY (`language_id`) REFERENCES `tour_language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_to_tickets` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_to_date` FOREIGN KEY (`event_date_id`) REFERENCES `history_event_date` (`event_date_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_to_location` FOREIGN KEY (`tour_location_id`) REFERENCES `tour_locations` (`tour_location_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_to_time` FOREIGN KEY (`timetable_id`) REFERENCES `tour_timetable` (`timetable_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_tours`
--
ALTER TABLE `history_tours`
  ADD CONSTRAINT `1` FOREIGN KEY (`timetable_id`) REFERENCES `history_timeslots` (`timetable_id`),
  ADD CONSTRAINT `2` FOREIGN KEY (`language_id`) REFERENCES `tour_language` (`language_id`);

--
-- Constraints for table `music_events`
--
ALTER TABLE `music_events`
  ADD CONSTRAINT `artist_to_music_event` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_to_music_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venue_to_music_event` FOREIGN KEY (`venue_id`) REFERENCES `dance_venues` (`venue_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `music_event_tickets`
--
ALTER TABLE `music_event_tickets`
  ADD CONSTRAINT `music_ticket_to_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_to_music_artists` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_to_music_event` FOREIGN KEY (`music_event_id`) REFERENCES `music_events` (`music_event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_to_venue` FOREIGN KEY (`venue_id`) REFERENCES `dance_venues` (`venue_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `music_performance`
--
ALTER TABLE `music_performance`
  ADD CONSTRAINT `fk_mp_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mp_music_event` FOREIGN KEY (`music_event_id`) REFERENCES `music_events` (`music_event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `user_to_orders` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `event_to_items` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_to_items` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `price_list`
--
ALTER TABLE `price_list`
  ADD CONSTRAINT `events_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `session_to_reservation` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_to_reservation` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_features`
--
ALTER TABLE `restaurant_features`
  ADD CONSTRAINT `feature_to_restaurant_feature` FOREIGN KEY (`feature_id`) REFERENCES `features` (`feature_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant_to_restaurant_features` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `page_id` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `ticket_to_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour_timetable`
--
ALTER TABLE `tour_timetable`
  ADD CONSTRAINT `timetable_to_event` FOREIGN KEY (`event_date_id`) REFERENCES `history_event_date` (`event_date_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
