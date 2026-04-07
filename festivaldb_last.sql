-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 07, 2026 at 05:29 PM
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

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `artist_id`, `album_name`, `image_url`, `year`) VALUES
(1, 1, 'United We Are', 'hardwell-united-we-are.jpg', 2015),
(2, 1, 'Rebels Never Die', 'hardwell-rebels-never-die.jpg', 2022),
(3, 2, 'Imagine', 'armin-imagine.jpg', 2008),
(4, 2, 'Intense', 'armin-intense.jpg', 2013),
(5, 3, 'Sentio', 'martin-sentio.jpg', 2022),
(6, 3, 'The Martin Garrix Experience', 'martin-garrix-experience.jpg', 2019),
(7, 4, 'Just Be', 'tiesto-just-be.jpg', 2004),
(8, 4, 'Drive', 'tiesto-drive.jpg', 2023),
(9, 5, 'Nicky Romero Presents Protocol', 'nicky-romero-protocol.jpg', 2020),
(10, 5, 'Redefine', 'nicky-romero-redefine.jpg', 2023),
(11, 6, 'Forget the World', 'afrojack-forget-the-world.jpg', 2014),
(12, 6, 'Press Play', 'afrojack-press-play.jpg', 2022);

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
  `about` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `artist_name`, `age`, `nationality`, `genre`, `about`, `image_url`) VALUES
(1, 'Hardwell', '38', 'Dutch', 'dance and house', 'Hardwell, a two-time DJ Mag #1 DJ in the World, is renowned for his explosive sets and anthems like Spaceman. Headlining Tomorrowland and Ultra, he’s a trailblazer in electronic music, known for pushing boundaries with his festival hits and groundbreaking performances.', '69d110e0c02d29.40049753_Hardwell.jpg'),
(2, 'Armin van Buuren', '49', 'Dutch', 'trance and techno', 'Armin van Buuren, a five-time DJ Mag #1 DJ, is a global trance legend. Known for his iconic A State of Trance radio show, he has headlined every major festival, earned Grammy nominations, and captivated millions with hits like This Is What It Feels Like.', '69d10f55d7c7c6.14229673_Armin.jpg'),
(3, 'Martin Garrix', '29', 'Dutch', 'dance / electronic', 'Martin Garrix rose to global stardom with his smash hit Animals and has since headlined festivals like Coachella and Tomorrowland. A three-time winner of DJ Mag’s #1 DJ in the World title, he’s collaborated with icons like Dua Lipa, Usher, and David Guetta, solidifying his place as a trailblazer in EDM.', '69d10f6ddf9fd5.32538491_Martin.jpg'),
(4, 'Tiësto', '57', 'Dutch', 'trance, techno, minimal, house, electro', 'Tiësto, a Grammy-winning DJ and producer, has shaped electronic music for decades. With legendary tracks like Adagio for Strings and The Business, he’s headlined festivals worldwide, from Tomorrowland to Coachella, solidifying his status as a global dance music icon.', '69d10f924a44f6.77053517_Tiësto.jpg'),
(5, 'Nicky Romero', '37', 'Dutch', 'electrohouse / progressive house', 'Nicky Romero, a chart-topping DJ and producer, gained global fame with hits like Toulouse and I Could Be the One with Avicii. A festival favorite at Tomorrowland and Ultra, he’s also the founder of Protocol Recordings, nurturing the next generation of electronic music talent.', '69d10fe28d6d11.13029654_Nicky Romero.png'),
(6, 'Afrojack', '37', 'Dutch', 'house', 'Afrojack, a global EDM icon, has headlined the world’s biggest festivals, including Tomorrowland and Ultra Music Festival. Known for chart-topping hits like Take Over Control and collaborations with stars like Beyoncé, David Guetta, and Pitbull, he continues to redefine the electronic music scene.', '69d10ffa46f724.95255612_Afrojack.jpg');

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

--
-- Dumping data for table `artist_musics`
--

INSERT INTO `artist_musics` (`artist_music_id`, `artist_id`, `music_title`, `image_url`, `music_url`) VALUES
(1, 1, 'Spaceman', 'spaceman.jpg', 'hardwell-spaceman.mp3'),
(2, 1, 'Apollo', 'apollo.jpg', 'hardwell-apollo.mp3'),
(3, 1, 'Run Wild', 'run-wild.jpg', 'hardwell-run-wild.mp3'),
(4, 2, 'This Is What It Feels Like', 'this-is-what-it-feels-like.jpg', 'armin-this-is-what-it-feels-like.mp3'),
(5, 2, 'Blah Blah Blah', 'blah-blah-blah.jpg', 'armin-blah-blah-blah.mp3'),
(6, 2, 'In and Out of Love', 'in-and-out-of-love.jpg', 'armin-in-and-out-of-love.mp3'),
(7, 3, 'Animals', 'animals.jpg', 'martin-animals.mp3'),
(8, 3, 'Scared to Be Lonely', 'scared-to-be-lonely.jpg', 'martin-scared-to-be-lonely.mp3'),
(9, 3, 'High on Life', 'high-on-life.jpg', 'martin-high-on-life.mp3'),
(10, 4, 'Adagio for Strings', 'adagio-for-strings.jpg', 'tiesto-adagio-for-strings.mp3'),
(11, 4, 'The Business', 'the-business.jpg', 'tiesto-the-business.mp3'),
(12, 4, 'Red Lights', 'red-lights.jpg', 'tiesto-red-lights.mp3'),
(13, 5, 'Toulouse', 'toulouse.jpg', 'nicky-toulouse.mp3'),
(14, 5, 'I Could Be the One', 'i-could-be-the-one.jpg', 'nicky-i-could-be-the-one.mp3'),
(15, 5, 'Like Home', 'like-home.jpg', 'nicky-like-home.mp3'),
(16, 6, 'Take Over Control', 'take-over-control.jpg', 'afrojack-take-over-control.mp3'),
(17, 6, 'Ten Feet Tall', 'ten-feet-tall.jpg', 'afrojack-ten-feet-tall.mp3'),
(18, 6, 'No Beef', 'no-beef.jpg', 'afrojack-no-beef.mp3');

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

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`award_id`, `artist_id`, `title`, `image_url`) VALUES
(1, 1, 'DJ Mag Top 100 DJs #1', 'hardwell-award-1.jpg'),
(2, 1, 'Best Global DJ', 'hardwell-award-2.jpg'),
(3, 2, 'DJ Mag Top 100 DJs #1', 'armin-award-1.jpg'),
(4, 2, 'International Dance Music Award', 'armin-award-2.jpg'),
(5, 3, 'DJ Mag Top 100 DJs #1', 'martin-award-1.jpg'),
(6, 3, 'MTV Europe Music Award', 'martin-award-2.jpg'),
(7, 4, 'Grammy Award Winner', 'tiesto-award-1.jpg'),
(8, 4, 'DJ Mag Top 100 DJs Legend Award', 'tiesto-award-2.jpg'),
(9, 5, 'MTV Clubland Award Nominee', 'nicky-award-1.jpg'),
(10, 5, 'Protocol Recordings Recognition Award', 'nicky-award-2.jpg'),
(11, 6, 'Grammy Award Winner', 'afrojack-award-1.jpg'),
(12, 6, 'NRJ DJ Award', 'afrojack-award-2.jpg');

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
(1, 'Lichtfabriek', 'Minckelersweg 2, 2031 EM Haarlem', 1500, '69d112f4ac3855.69508695_Lichtfabriek.jpg', '69d112a53a5b11.85821531_Lichtfabriek.jpg'),
(2, 'Sachthuis', 'Rockplein 6, 2033 KK Haarlem', 100, '69d113de3b58b4.30144645_Sachthuis.jpg', 'https://maps.app.goo.gl/vk4fLgZ4REjKFaAh8'),
(3, 'Jopenkerk', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', 100, '69d1140e852ce6.42120188_Jopenkerk.jpg', 'https://maps.app.goo.gl/mfzzDw8WHC36pp8R9'),
(4, 'XO the Club', 'Grote Markt 8, 2011 RD Haarlem', 100, '69d1144e4eabb0.02404578_XO.jpg', 'https://maps.app.goo.gl/9jfxL3RuvcXvC5666'),
(5, 'Puncher comedy club', 'Grote Markt 10, 2011 RD Haarlem', 100, '69d114867be5e2.82910195_Puncher comedy club.jpg', 'https://maps.app.goo.gl/tLUZ55yoMzPV7SD7A'),
(6, 'Caprera Openluchttheater', 'Hoge Duin en Daalseweg 2, 2061 AG Bloemendaal', 100, '69d114dc584517.80675513_Caprera Openluchttheater.jpg', 'https://maps.app.goo.gl/Eik8ntYbiTAVhcK66');

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
(2, 'Dance', 'Dance', '69cd55a06fead8.72393054_images.jpeg', 'Experience an unforgettable weekend of music, energy, and world-class DJs in Haarlem.', 1, '2024-07-27', '2024-07-29', 'D35472', 'F57B5F'),
(3, 'History', 'Haarlem Veterans Day 2026', '69cd55ab0922b0.97271831_ai-generated-concert-crowd-enjoying-live-music-event-photo.jpg', 'Veterans Day Haarlem on Sunday, May 10 (1:00 PM–5:00 PM) brings past and present together with vehicles and stands on the Grote Markt. Free admission, an afternoon full of experiences for young and old.', 1, '2026-05-10', '2026-05-13', '3772FF', '080708');

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

--
-- Dumping data for table `history_event_date`
--

INSERT INTO `history_event_date` (`event_date_id`, `date`) VALUES
(1, '2026-05-10'),
(2, '2026-05-11');

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

--
-- Dumping data for table `history_info`
--

INSERT INTO `history_info` (`content_id`, `title`, `description`, `image`, `url`, `section_type`) VALUES
(10, 'Churches & Religious Landmarks Tour', 'Discover the spiritual side of the city by visiting its most significant churches, cathedrals, and religious landmarks. Experience awe-inspiring architecture ranging from ', '69cd5d006ae2b1.99221733_51325507921_09f706f4b3_c 2.jpg', 'https://www.example.com/history/religious-landmarks-tour', 'Header'),
(11, 'Ancient City Ruins', 'Step into a world frozen in time as you explore the ruins of an ancient city that flourished centuries ago. Wander through crumbling stone walls, weathered temples, and old marketplaces where merchants once traded goods from distant lands.', '69cd5d2754c951.32140409_the-top-15-things-to-do-in-tours-francerent.jpg', 'https://www.example.com/history/ancient-city-ruins', 'Introduction'),
(12, 'Medieval Castle Tour', 'Discover a colonial town frozen in time, where cobblestone streets, old town halls, and vintage houses tell stories of settlers and colonists. Learn about the architectural styles introduced during the colonial era and how they blended with local culture. Explore museums, public squares, and historical buildings that showcase governance, trade, and social life of the past. Hear tales of exploration, conflict, and community growth that shaped the town’s unique identity. This tour immerses you in centuries of history, giving insights into the everyday lives and struggles of people who built the town.', '69cd5d46d3b771.50439394_5-2-1.jpg', 'https://www.example.com/history/medieval-castle', 'Information'),
(13, 'Historic Port City', 'Visit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant', '69cd5d7b3e9ef3.16638183_images (1).jpeg', 'https://www.example.com/history/historic-port-city', 'RegularTicket'),
(14, 'Ancient Temples Expedition', 'Visit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant streets that once connected continents through commerce. Learn about legendary explorers, maritime adventures, and the city’s role in shaping regional and global trade routes\r\n\r\nVisit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant streets that once connected continents through commerce. Learn about legendary explorers, maritime adventures, and the city’s role in shaping regional and global trade routes', '69cd5de30d6783.33979010_pexels-tkirkgoz-11408378.jpg', 'https://www.example.com/history/historic-port-city', 'Information'),
(15, 'Ancient Temples Expedition', 'Embark on a journey to ancient temples that have survived the test of time, standing as a testament to human devotion and architectural brilliance. Marvel at intricately carved pillars, ', '69cd5e09bddf21.54010894_51325507921_09f706f4b3_c 2.jpg', 'https://www.example.com/history/ancient-temples', 'RegularTicket'),
(16, 'Royal Palace & Gardens', 'Step into the opulent world of royalty by visiting grand palaces and meticulously maintained gardens. Explore luxurious halls adorned with golden chandeliers, intricate frescoes, and royal artifacts that showcase wealth,', '69cd5e27a300d6.73665516_5-2-1.jpg', 'https://www.example.com/history/royal-palace', 'FamilyTicket'),
(17, 'Colonial Town Heritage', 'Discover a colonial town frozen in time, where cobblestone streets, old town halls, and vintage houses tell stories of settlers and colonists. Learn about the architectural styles introduced during the colonial era and how they blended with local culture', '69cd5e4a23fc85.78503403_images.jpeg', 'https://www.example.com/history/colonial-town', 'Routes');

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

--
-- Dumping data for table `history_timeslots`
--

INSERT INTO `history_timeslots` (`timetable_id`, `date`, `start_time`, `end_time`) VALUES
(1, '2026-05-16', '10:00:00', '17:00:00'),
(2, '2026-05-17', '10:00:00', '17:00:00');

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

--
-- Dumping data for table `history_tours`
--

INSERT INTO `history_tours` (`tour_id`, `timetable_id`, `language_id`, `available_guides`) VALUES
(1, 1, 3, 24),
(3, 2, 1, 2);

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

--
-- Dumping data for table `music_events`
--

INSERT INTO `music_events` (`music_event_id`, `event_id`, `artist_id`, `venue_id`, `event_date`, `event_name`, `event_price`, `session_type`, `event_start_time`, `event_duration`, `music_event_image`) VALUES
(101, 2, 1, 1, '2024-07-27', 'Hardwell Live', 65.00, 'Club', '20:00:00', 90, '69d1181cd4fb33.44639002_Hardwell Live.jpg'),
(102, 2, 2, 4, '2024-07-27', 'Armin After Dark', 55.00, 'Club', '23:00:00', 120, '69d11854b342f8.02458632_Armin Live.jpg'),
(103, 2, 3, 1, '2024-07-28', 'Martin Garrix Festival Set', 70.00, 'Club', '21:00:00', 90, '69d1186be168d1.47160605_Martin Garrix live.jpg'),
(104, 2, 6, 4, '2024-07-28', 'Afrojack Midnight Session', 60.00, 'Club', '23:30:00', 90, '69d1188d391cc4.28859870_Afrojack live.jpg'),
(105, 2, 4, 6, '2024-07-29', 'Tiësto Closing Show', 85.00, 'Club', '20:30:00', 120, '69d118a89580f9.93287490_Tiësto live.jpg'),
(106, 2, 5, 1, '2024-07-29', 'Nicky Romero Finale', 58.00, 'Club', '22:30:00', 90, '69d118becb3045.78588179_Nicky Romero live.jpg');

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

--
-- Dumping data for table `music_performance`
--

INSERT INTO `music_performance` (`music_performance_id`, `music_event_id`, `artist_id`, `event_id`, `title`, `session_type`, `start_date`, `event_start_time`, `event_duration`, `event_price`, `quantity`) VALUES
(201, 101, 1, 2, 'Hardwell Live', 'Club', '2024-07-27', '20:00:00', 90, 65.00, 500),
(202, 102, 2, 2, 'Armin After Dark', 'Club', '2024-07-27', '23:00:00', 120, 55.00, 500),
(203, 103, 3, 2, 'Martin Garrix Festival Set', 'Club', '2024-07-28', '21:00:00', 90, 70.00, 500),
(204, 104, 6, 2, 'Afrojack Midnight Session', 'Club', '2024-07-28', '23:30:00', 90, 60.00, 500),
(205, 105, 4, 2, 'Tiësto Closing Show', 'Club', '2024-07-29', '20:30:00', 120, 85.00, 500),
(206, 106, 5, 2, 'Nicky Romero Finale', 'Club', '2024-07-29', '22:30:00', 90, 58.00, 500);

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
(1, 7, 30.00, NULL, 'completed', NULL, '2026-03-08 00:07:34', '2026-03-08 00:07:34', '2026-03-08 00:07:34'),
(2, 5, 40.00, NULL, 'completed', NULL, '2026-03-17 11:02:11', '2026-03-17 11:02:11', '2026-03-17 11:02:11'),
(3, 5, 30.00, NULL, 'completed', NULL, '2026-03-17 11:41:27', '2026-03-17 11:41:27', '2026-03-17 11:41:27'),
(4, 8, 120.00, NULL, 'completed', NULL, '2026-04-03 20:47:57', '2026-04-03 20:47:57', '2026-04-03 20:47:57'),
(5, 8, 0.00, NULL, 'completed', NULL, '2026-04-03 20:51:17', '2026-04-03 20:51:17', '2026-04-03 20:51:17'),
(6, 8, 0.00, NULL, 'completed', NULL, '2026-04-03 20:51:22', '2026-04-03 20:51:22', '2026-04-03 20:51:22'),
(7, 8, 120.00, NULL, 'completed', NULL, '2026-04-04 11:05:14', '2026-04-04 11:05:14', '2026-04-04 11:05:14'),
(8, 8, 0.00, NULL, 'completed', NULL, '2026-04-04 11:09:09', '2026-04-04 11:09:09', '2026-04-04 11:09:09'),
(9, 8, 143.00, NULL, 'completed', NULL, '2026-04-04 11:09:41', '2026-04-04 11:09:41', '2026-04-04 11:09:41'),
(10, 5, 134.00, NULL, 'completed', NULL, '2026-04-04 18:44:25', '2026-04-04 18:44:25', '2026-04-04 18:44:25'),
(11, 5, 55.00, NULL, 'completed', NULL, '2026-04-04 18:45:07', '2026-04-04 18:45:07', '2026-04-04 18:45:07'),
(12, 8, 120.00, NULL, 'completed', NULL, '2026-04-07 16:07:48', '2026-04-07 16:07:48', '2026-04-07 16:07:48'),
(13, 8, 144.00, NULL, 'completed', NULL, '2026-04-07 16:18:52', '2026-04-07 16:18:52', '2026-04-07 16:18:52'),
(14, 8, 144.00, NULL, 'completed', NULL, '2026-04-07 16:19:03', '2026-04-07 16:19:03', '2026-04-07 16:19:03'),
(15, 8, 185.00, NULL, 'completed', NULL, '2026-04-07 16:19:46', '2026-04-07 16:19:46', '2026-04-07 16:19:46'),
(16, 8, 120.00, NULL, 'completed', NULL, '2026-04-07 16:55:31', '2026-04-07 16:55:31', '2026-04-07 16:55:31'),
(17, 8, 130.00, NULL, 'completed', NULL, '2026-04-07 16:58:03', '2026-04-07 16:58:03', '2026-04-07 16:58:03'),
(18, 8, 120.00, NULL, 'completed', NULL, '2026-04-07 17:01:41', '2026-04-07 17:01:41', '2026-04-07 17:01:41'),
(19, 8, 130.00, NULL, 'completed', NULL, '2026-04-07 17:02:53', '2026-04-07 17:02:53', '2026-04-07 17:02:53'),
(20, 8, 120.00, NULL, 'completed', NULL, '2026-04-07 17:11:37', '2026-04-07 17:11:37', '2026-04-07 17:11:37'),
(21, 8, 120.00, NULL, 'completed', NULL, '2026-04-07 17:15:45', '2026-04-07 17:15:45', '2026-04-07 17:15:45');

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

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_type`, `item_id`, `event_id`, `quantity`) VALUES
(1, 2, 'reservation', 1, NULL, 1),
(2, 3, 'reservation', 2, NULL, 1),
(3, 4, 'dance_ticket', 1, NULL, 1),
(4, 4, 'dance_ticket', 2, NULL, 1),
(5, 7, 'dance_ticket', 3, NULL, 1),
(6, 7, 'dance_ticket', 4, NULL, 1),
(7, 9, 'dance_ticket', 5, NULL, 1),
(8, 9, 'dance_ticket', 6, NULL, 1),
(9, 11, 'dance_ticket', 7, NULL, 1),
(10, 12, 'dance_ticket', 8, NULL, 1),
(11, 12, 'dance_ticket', 9, NULL, 1),
(12, 13, 'dance_ticket', 10, NULL, 1),
(13, 14, 'dance_ticket', 11, NULL, 1),
(14, 15, 'dance_ticket', 12, NULL, 1),
(15, 15, 'dance_ticket', 13, NULL, 1),
(16, 15, 'dance_ticket', 14, NULL, 1),
(17, 16, 'dance_ticket', 15, NULL, 1),
(18, 16, 'dance_ticket', 16, NULL, 1),
(19, 17, 'dance_ticket', 17, NULL, 1),
(20, 17, 'dance_ticket', 18, NULL, 1),
(21, 18, 'dance_ticket', 19, NULL, 1),
(22, 18, 'dance_ticket', 20, NULL, 1),
(23, 19, 'dance_ticket', 21, NULL, 1),
(24, 19, 'dance_ticket', 22, NULL, 1),
(25, 20, 'dance_ticket', 23, NULL, 1),
(26, 20, 'dance_ticket', 24, NULL, 1),
(27, 21, 'dance_ticket', 25, NULL, 1),
(28, 21, 'dance_ticket', 26, NULL, 1);

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
(1, 'Home', NULL, 1, 'home'),
(2, 'Events', NULL, 1, 'events'),
(3, 'History', NULL, 1, 'history'),
(5, 'Dance', NULL, 1, 'dance'),
(6, 'Yummy', NULL, 1, 'yummy'),
(7, 'About', NULL, 1, 'about');

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

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `name`, `reservation_date`, `total_adult`, `total_children`, `email`, `phone`, `user_id`, `session_id`, `restaurant_id`, `remarks`, `total_cost`, `payment_status`, `confirmation_code`, `is_paid`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Ahsanul Rabbi Khan', '2024-07-27', 3, 1, 'admin@gmail.com', '0630414048', 5, 3, 1, 'this is test ', 40.00, 'completed', 'CONF-69B934B33A211', 0, 1, '2026-03-17 11:02:11', '2026-03-17 11:02:11'),
(2, 'Ahsanul Rabbi Khan', '2024-07-27', 2, 1, 'admin@gmail.com', '0630414048', 5, 3, 1, 'This is test', 30.00, 'completed', 'CONF-69B93DE7B5CAE', 0, 1, '2026-03-17 11:41:27', '2026-03-17 11:41:27');

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
(1, 'Café de Roemer', '/images/69aafdbf458ae4.44129310_yummy_events.jpg', '&lt;p&gt;Welcome to Café de Roemer, an iconic spot located on Botermarkt in the heart of Haarlem. A Haarlem institution for over 30 years, it&#039;s now owned by two enthusiastic entrepreneurs who are continuing the Roemer legacy with renewed energy. Step inside and discover our diverse menu, where classics meet surprising new flavors. Whether you&#039;re looking for a delicious lunch, a leisurely dinner, or just a relaxing drink, you&#039;re sure to find something to suit your taste. Enjoy the sun on our spacious and sunny terrace, or experience the outdoors year-round in our beautiful glass conservatory. Whatever the weather, at Café de Roemer we always offer a warm welcome and a cozy atmosphere. Our team is ready to make your experience unforgettable, with enthusiasm, hospitality, and a smile. Whether you&#039;re stopping by for a quick bite or a long night out, you&#039;ll always feel at home at Café de Roemer. Come visit us and discover the unique charm of Café de Roemer for yourself. We look forward to welcoming you!&lt;/p&gt;', 4, 'Dutch, Fish and Seafood, European', 1, 1, 'Botermarkt 17, 2011 XL Haarlem', 35, 'info@cafederoemer.nl', '02857488', '[\"\\/images\\/69aafdbf479990.19159331_yummy_events.jpg\",\"\\/images\\/69acae9da4a2e0.32909133_639565879_18079722086596251_5554071152351958995_n.jpg\",\"\\/images\\/69acae9daf53d2.17401647_642509984_18080492510596251_7090866304138896856_n.jpg\",\"\\/images\\/69acae9dba47c4.44593639_643545031_18080492501596251_1310653718942307600_n.jpg\",\"\\/images\\/69acae9dc2c316.06554831_645841499_18080957423596251_3190953387532787824_n.jpg\"]');

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
(12, 1, 1),
(13, 1, 2);

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
(1, 'Discover Food  & Drinks', '', '<p><span style=\"font-family: Arial;\">﻿</span>When you say Haarlem, you immediately think of culinary experiences. This vibrant city offers something for every taste, from chic restaurants where you can enjoy refined dining to cozy cafés and lively eateries perfect for a quick and delicious bite. Stroll through its charming streets and you’ll find inviting coffee bars serving expertly brewed drinks, welcoming tasting rooms where you can sample local flavors, and atmospheric breweries offering craft beers with character. Whether you’re looking for a relaxed lunch, an indulgent dinner, or simply a place to unwind with a drink, Haarlem’s diverse food and drink scene makes it a true destination for anyone who loves good taste and great atmosphere. 🍽️☕🍺</p>', '/images/69a982efaaf230.79610024_Haarlem-Culinair-Blackline-Media-Edit-52-1-2048x1365.jpg', 'https://maps.app.goo.gl/o69KfbnbDv6tDm8q8', 'header', 6),
(2, 'About Us', '', '<p>Our journey began at Inholland University of Applied Sciences, where we met as a team of students passionate about technology and problem-solving. With backgrounds in IT and a shared curiosity for how digital solutions could make life easier, we often found ourselves discussing real-world challenges and how software could solve them. It wasn’t long before the idea sparked: What if we started our own IT company—one that focused not on trends or hype, but on building useful, reliable tools that actually help businesses grow? That idea became our mission. We founded our company with one goal in mind: to build valuable digital products that solve real business problems. From the start, we’ve focused on clarity, practicality, and purpose—cutting through the noise to deliver solutions that truly support teams and organizations. Our vision is simple: empower businesses to scale and thrive through technology. We believe digital tools should feel like an extension of your goals, not a barrier. That means making digital less confusing, more helpful, and always aligned with your needs. We’re human-first, results-driven, and always collaborative. We listen before we build. We explain things clearly. We avoid shortcuts, respect your time, and treat every project like a partnership. With us, you’ll always know where things stand, and what’s coming next. This is our story—rooted in curiosity, grown through collaboration, and driven by a commitment to help businesses succeed with technology that works. #inholland hashtag #LearningTogether hashtag #InhollandUniversityofAppliedSciences</p>', '', '', 'instruction', 7),
(3, 'You don\'t want to miss this', '', '<font color=\"#4a4a49\" face=\"WixMadeforText-VariableFont_wght, sans-serif\"><span style=\"font-size: 17px;\">From Dutch Masters to modern art, from arthouse films to children\'s theater, from pop concerts to city history: if you\'re looking for inspiration, art, and culture, Haarlem is sure to satisfy your cravings. Not only is Haarlem home to the oldest museum in the Netherlands, but its historic city center is also bustling with cultural hotspots, (art) history, and creative initiatives.</span></font>', '', '', 'tour_information', 2),
(4, 'Art and Culture', '', '<p>Be amazed by Haarlem\'s rich art and culture. Will it be a museum, the theater, or a stroll past historic monuments?&nbsp; Haarlem\'s artistic soul. Haarlem is a paradise for art lovers, with a wide range of museums, galleries, and cultural events. Immerse yourself in the city\'s artistic offerings and witness the interplay between tradition and innovation. Art and culture in Haarlem truly embrace and celebrate the spirit of creativity. Here\'s a glimpse of what this enchanting city has to offer</p>', '', '', 'header', 2);

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

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `customer_name`, `event_name`, `event_date`, `event_time`, `qr_code`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '1451a4a7f9f827bf0578fccb36f5d4bf', 'new', '2026-04-03 20:47:57', '2026-04-03 20:47:57'),
(2, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '694b30b667a3ce7d56ea963579d4ceb8', 'new', '2026-04-03 20:47:57', '2026-04-03 20:47:57'),
(3, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', 'f8753188f2bce6dbffa099999e9ec2b1', 'new', '2026-04-04 11:05:14', '2026-04-04 11:05:14'),
(4, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '3ec702aee1199d0ae67940e887f02129', 'new', '2026-04-04 11:05:14', '2026-04-04 11:05:14'),
(5, NULL, 'Tabeeb', 'Tiësto Closing Show', '2024-07-29', '20:30:00', '56671940f55b6ab76047120ea7a24699', 'new', '2026-04-04 11:09:41', '2026-04-04 11:09:41'),
(6, NULL, 'Tabeeb', 'Nicky Romero Finale', '2024-07-29', '22:30:00', '57ba9c21576ff30f6ea4b33dc065f928', 'new', '2026-04-04 11:09:41', '2026-04-04 11:09:41'),
(7, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2024-07-27', '23:00:00', 'f444bd53ea4dedf42c7119096e17e9b6', 'new', '2026-04-04 18:45:07', '2026-04-04 18:45:07'),
(8, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '5a8362597834b760a38215a0794740be', 'new', '2026-04-07 16:07:48', '2026-04-07 16:07:48'),
(9, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', 'a4754986303229b5e1047d8a9f670b3c', 'new', '2026-04-07 16:07:48', '2026-04-07 16:07:48'),
(10, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', 'c8953b03ce8067028e1d7a029af71106', 'new', '2026-04-07 16:18:52', '2026-04-07 16:18:52'),
(11, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '364eaf060e2e4963a975508f647041bb', 'new', '2026-04-07 16:19:03', '2026-04-07 16:19:03'),
(12, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', 'de1d6af5f56d83a0ff9431abcb5d9f11', 'new', '2026-04-07 16:19:46', '2026-04-07 16:19:46'),
(13, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '6103cb027cf5ccc64adca2f9f8ff7666', 'new', '2026-04-07 16:19:46', '2026-04-07 16:19:46'),
(14, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', 'b96ea63167ef1aad28c9494e779032c4', 'new', '2026-04-07 16:19:46', '2026-04-07 16:19:46'),
(15, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '543ca841ad4ecca4b74ed3548857e277', 'new', '2026-04-07 16:55:31', '2026-04-07 16:55:31'),
(16, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '0b138b0964305a1f635332c74b615a7e', 'new', '2026-04-07 16:55:31', '2026-04-07 16:55:31'),
(17, NULL, 'Tabeeb', 'Afrojack Midnight Session', '2024-07-28', '23:30:00', 'baf873d12be7a165814e1115fea7aa40', 'new', '2026-04-07 16:58:03', '2026-04-07 16:58:03'),
(18, NULL, 'Tabeeb', 'Martin Garrix Festival Set', '2024-07-28', '21:00:00', 'f2823879a440300b8b594cf63c3530fa', 'new', '2026-04-07 16:58:03', '2026-04-07 16:58:03'),
(19, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '6f79acb8e3225638199d5f96785f10fe', 'new', '2026-04-07 17:01:41', '2026-04-07 17:01:41'),
(20, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '39b01b3236beb937851d005985d05a5a', 'new', '2026-04-07 17:01:41', '2026-04-07 17:01:41'),
(21, NULL, 'Tabeeb', 'Martin Garrix Festival Set', '2024-07-28', '21:00:00', 'e63830c1a8143d5f50dcc5ac846351a9', 'new', '2026-04-07 17:02:53', '2026-04-07 17:02:53'),
(22, NULL, 'Tabeeb', 'Afrojack Midnight Session', '2024-07-28', '23:30:00', 'c87ec15a0cb5b1c506942cde5d565fdb', 'new', '2026-04-07 17:02:53', '2026-04-07 17:02:53'),
(23, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '918757b8d2450f846e1031228f870f46', 'new', '2026-04-07 17:11:37', '2026-04-07 17:11:37'),
(24, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', 'c42921a9a10388a5a69c0599d7929e44', 'new', '2026-04-07 17:11:37', '2026-04-07 17:11:37'),
(25, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '9eb4fc0cefa50cd2aeb8736ebb9da088', 'new', '2026-04-07 17:15:45', '2026-04-07 17:15:45'),
(26, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '9c8e5aefda011c8e66507e3797bbb17c', 'new', '2026-04-07 17:15:45', '2026-04-07 17:15:45');

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

--
-- Dumping data for table `ticket_pass`
--

INSERT INTO `ticket_pass` (`pass_id`, `passName`, `passDescription`, `passPrice`, `passType`) VALUES
(1, 'Saturday Dance Pass', 'Access to all Haarlem Festival dance events on Saturday 27 July 2024.', 79.00, 'Day Pass'),
(2, 'Sunday Dance Pass', 'Access to all Haarlem Festival dance events on Sunday 28 July 2024.', 79.00, 'Day Pass'),
(3, 'Weekend Dance Pass', 'Full access to all Haarlem Festival dance events from 27 to 29 July 2024.', 199.00, 'Weekend Pass'),
(4, 'Friday Dance Pass', 'Access to all Haarlem Festival dance events on Friday 26 July 2024.', 79.00, 'Day Pass');

-- --------------------------------------------------------

--
-- Table structure for table `tour_language`
--

CREATE TABLE `tour_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `flag_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_language`
--

INSERT INTO `tour_language` (`language_id`, `name`, `flag_image`) VALUES
(1, 'Dutch', NULL),
(2, 'English', NULL),
(3, 'Mandarin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour_locations`
--

CREATE TABLE `tour_locations` (
  `tour_location_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `contact_info` text NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_locations`
--

INSERT INTO `tour_locations` (`tour_location_id`, `location_name`, `description`, `address`, `contact_info`, `images`) VALUES
(6, 'Old Town Square', 'Old Town Square is the historic and cultural centerpiece of the city, dating back several centuries. Surrounded by beautifully preserved buildings, charming cafes, and traditional shops, the square reflects a blend of medieval and modern influences. Over the years, it has served as a marketplace, a gathering point for social and political events, and a hub for cultural celebrations. Visitors can enjoy street performances, seasonal festivals, and local artisan stalls that bring the area to life. The atmosphere changes throughout the day—from peaceful mornings with soft sunlight over cobblestone streets to vibrant evenings filled with music and activity. It offers an immersive experience for anyone interested in history, architecture, and local traditions.', 'Old Town Square, Central District, Haarlem, Netherlands', 'Phone: +31 23 123 4567 Email: info@oldtownhaarlem.nl', '69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg'),
(7, 'St. Bavo Church', 'St. Bavo Church is one of the most iconic landmarks in the city, showcasing remarkable Gothic architecture and centuries of history. Constructed during the medieval period, the church stands as a testament to the craftsmanship and artistic excellence of its time. Inside, visitors are greeted by intricate stonework, stunning stained glass windows, and a magnificent pipe organ that has attracted musicians from around the world—including the legendary Mozart. The church has played an important role not only as a place of worship but also as a center for community gatherings and historical events.', 'Grote Markt 22, 2011 RD Haarlem, Netherlands', 'Phone: +31 23 555 7890 Email: contact@stbavochurch.nl', '69cd5753edbbb5.83085371_IMG_8670-scaled.jpg'),
(8, 'Haarlemmerhout Park', 'Haarlemmerhout Park is one of the oldest public parks in the Netherlands, offering a peaceful escape from the busy city environment. Known for its lush greenery, walking trails, and scenic landscapes, the park has been a favorite destination for locals and visitors for generations. Historically, it served as a recreational space for the city’s residents and has gradually evolved into a well-maintained urban park with modern amenities. Visitors can enjoy leisurely walks, cycling, picnics, and outdoor activities while surrounded by tall trees and open green spaces. The park also hosts seasonal events, cultural activities, and small gatherings that make it a lively yet relaxing destination. Its combination of natural beauty and historical significance makes it a must-visit location for anyone exploring the area.', 'Haarlemmerhout, 2012 Haarlem, Netherlands', 'Phone: +31 23 987 6543 Email: info@haarlemmerhoutpark.nl', '69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tour_timetable`
--

CREATE TABLE `tour_timetable` (
  `timetable_id` int(11) NOT NULL,
  `event_date_id` int(11) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_timetable`
--

INSERT INTO `tour_timetable` (`timetable_id`, `event_date_id`, `time`) VALUES
(1, 2, '10:00:00');

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
(8, 'Tabeeb', 'tabeeb788@gmail.com', '$2y$12$zoaz2udD5ND.0kZ5rT45JOxsXT7UTOyX1omw36WnzpjTBExLQGQxu', '/images/69af97612f35d6.29856032_sign.jpg', '2026-03-10 04:00:33', 'Customer');

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
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artist_musics`
--
ALTER TABLE `artist_musics`
  MODIFY `artist_music_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dance_venues`
--
ALTER TABLE `dance_venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history_event_date`
--
ALTER TABLE `history_event_date`
  MODIFY `event_date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_info`
--
ALTER TABLE `history_info`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `history_tickets`
--
ALTER TABLE `history_tickets`
  MODIFY `history_ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_timeslots`
--
ALTER TABLE `history_timeslots`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_tours`
--
ALTER TABLE `history_tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `music_events`
--
ALTER TABLE `music_events`
  MODIFY `music_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `music_performance`
--
ALTER TABLE `music_performance`
  MODIFY `music_performance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `price_list`
--
ALTER TABLE `price_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant_features`
--
ALTER TABLE `restaurant_features`
  MODIFY `restaurant_features_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ticket_pass`
--
ALTER TABLE `ticket_pass`
  MODIFY `pass_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tour_language`
--
ALTER TABLE `tour_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_locations`
--
ALTER TABLE `tour_locations`
  MODIFY `tour_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tour_timetable`
--
ALTER TABLE `tour_timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
