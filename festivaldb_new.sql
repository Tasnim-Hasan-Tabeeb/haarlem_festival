-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 18, 2026 at 11:21 AM
-- Server version: 12.3.2-MariaDB-ubu2404
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
(1, 1, 'Rebels Never Die', '/images/Rebels Never Die.jpg', 2022),
(2, 2, 'Intense', '/images/Intense.jpg', 2013),
(3, 3, 'Sentio', '/images/Sentio.jpg', 2022),
(4, 4, 'Just Be', '/images/Justbealbum.jpg', 2004),
(5, 5, 'Redefine', '/images/Redefine.webp', 2019),
(6, 6, 'Forget the World', '/images/Forget the World.jpg', 2014);

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `artist_real_name` varchar(255) DEFAULT NULL,
  `age` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `detail_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `artist_name`, `artist_real_name`, `age`, `nationality`, `genre`, `about`, `image_url`, `detail_image`) VALUES
(1, 'Hardwell', 'test', '11', 'Dutch', 'dance and house', 'Hardwell, a two-time DJ Mag #1 DJ in the World, is renowned for his explosive sets and anthems like Spaceman. Headlining Tomorrowland and Ultra, he’s a trailblazer in electronic music, known for pushing boundaries with his festival hits and groundbreaking performances.', '/images/6a32f9eb5f93c6.93125060_hardwell.jpg', '/images/69ef54407d7189.03796798_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg'),
(2, 'Armin van Buuren', 'Ar', '49', 'Dutch', 'trance and techno', 'Armin van Buuren, a five-time DJ Mag #1 DJ, is a global trance legend. Known for his iconic A State of Trance radio show, he has headlined every major festival, earned Grammy nominations, and captivated millions with hits like This Is What It Feels Like.', '/images/6a32f9f5a6c218.82431933_Armin.jpg', '/images/69ef544a381389.89115683_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg'),
(3, 'Martin Garrix', 'Mat', '29', 'Dutch', 'dance / electronic', 'Martin Garrix rose to global stardom with his smash hit Animals and has since headlined festivals like Coachella and Tomorrowland. A three-time winner of DJ Mag’s #1 DJ in the World title, he’s collaborated with icons like Dua Lipa, Usher, and David Guetta, solidifying his place as a trailblazer in EDM.', '/images/6a32f9fc9cfce7.83423358_Martin.jpg', '/images/69ef545ca7d478.79993914_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg'),
(4, 'Tiësto', 'Tiësto', '57', 'Dutch', 'trance, techno, minimal, house, electro', 'Tiësto, a Grammy-winning DJ and producer, has shaped electronic music for decades. With legendary tracks like Adagio for Strings and The Business, he’s headlined festivals worldwide, from Tomorrowland to Coachella, solidifying his status as a global dance music icon.', '/images/6a32fa0508cb35.80556608_Tiesto.jpg', '/images/69ef5474457054.24371226_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg'),
(5, 'Nicky Romero', 'Romero', '37', 'Dutch', 'electrohouse / progressive house', 'Nicky Romero, a chart-topping DJ and producer, gained global fame with hits like Toulouse and I Could Be the One with Avicii. A festival favorite at Tomorrowland and Ultra, he’s also the founder of Protocol Recordings, nurturing the next generation of electronic music talent.', '/images/6a32fa0d980a06.51533280_Nicky.jpg', '/images/69ef547e4a1400.90013039_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg'),
(6, 'Afrojack', 'test', '37', 'Dutch', 'house', 'Afrojack, a global EDM icon, has headlined the world’s biggest festivals, including Tomorrowland and Ultra Music Festival. Known for chart-topping hits like Take Over Control and collaborations with stars like Beyoncé, David Guetta, and Pitbull, he continues to redefine the electronic music scene.', '/images/6a32fa1bf12d88.57073902_Afrojack_2015.jpg', '/images/69ef546a16fec7.70209575_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg');

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
  `map_url` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dance_venues`
--

INSERT INTO `dance_venues` (`venue_id`, `venue_name`, `venue_location`, `capacity`, `venue_image`, `map_url`) VALUES
(1, 'Lichtfabriek', 'Minckelersweg 2, 2031 EM Haarlem', 1000, '/images/6a32fab4e7a279.57205592_Lichtfabriek.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.1115475338047!2d4.6491592742282375!3d52.38652814610591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef64b076482b%3A0x7baf87bc704c5b47!2sMinckelersweg%202%2C%202031%20TC%20Haarlem!5e0!3m2!1sen!2snl!4v1781726242863!5m2!1sen!2snl'),
(2, 'Sachthuis', 'Rockplein 6, 2033 KK Haarlem', 100, '/images/6a32fabb7e0790.97441639_Sachthuis.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.83723426582!2d4.645765788527047!3d52.37337129988675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef67998a2033%3A0x70e72125409378cb!2sSlachthuis%20Haarlem!5e0!3m2!1sen!2snl!4v1781726302168!5m2!1sen!2snl'),
(3, 'Jopenkerk', 'Gedempte Voldersgracht 2, 2011 WD Haarlem', 100, '/images/6a32fac15624f2.34360965_Jopenkerk.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.4046471194188!2d4.627156576406148!3d52.38121447202506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef14ed768603%3A0x5ff6ab7a87061c90!2sJopen!5e0!3m2!1sen!2snl!4v1781726356991!5m2!1sen!2snl'),
(4, 'XO the Club', 'Grote Markt 8, 2011 RD Haarlem', 100, '/images/6a32fac6b2f224.68174397_XO the Club.webp', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.4046471194188!2d4.627156576406148!3d52.38121447202506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6b7544b863%3A0x2c30c30bcd58e92f!2zQ2Fmw6kgWE8!5e0!3m2!1sen!2snl!4v1781726388119!5m2!1sen!2snl'),
(5, 'Puncher comedy club', 'Grote Markt 10, 2011 RD Haarlem', 100, '/images/6a32facd7da770.82412485_Puncher comedy club.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.4046636666744!2d4.632680176406136!3d52.381214172025096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5effb7e82034d%3A0xd3bfae70dd4a57b6!2sPuncher%20Comedy%20Club!5e0!3m2!1sen!2snl!4v1781726427557!5m2!1sen!2snl'),
(6, 'Caprera Openluchttheater', 'Hoge Duin en Daalseweg 2, 2061 AG Bloemendaal', 10, '/images/6a32fad56bb702.02134125_Caprera Openluchttheater.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2433.7531466887162!2d4.605706076408157!3d52.4111499720329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ee4d7202058f%3A0xe045c5b6e4ee44e4!2sCaprera%20Open%20Air%20Theatre!5e0!3m2!1sen!2snl!4v1781726459902!5m2!1sen!2snl');

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
(1, 'Yummy', 'Yummy', '/images/6a009efa557029.85583048_restaurant_events.jpg', 'Are you coming to the yummy event in Haarlem? For four days, you\'ll enjoy the most delicious dishes in Haarlem\'s Grote Markt. Don\'t miss out! Enjoy various tastings and live bands. Gather your group. Admission is free, so mark the dates in your calendar.\r\n', 1, '2026-07-26', '2026-07-31', 'D35472', 'F57B5F'),
(2, 'Dance', 'Dance', '/images/69ef54be219a26.65227161_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg', 'Experience an unforgettable weekend of music, energy, and world-class DJs in Haarlem.', 1, '2024-07-27', '2024-07-29', 'D35472', 'F57B5F'),
(3, 'History', 'History', '/images/69ef54c5e88588.63359250_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', 'Veterans Day Haarlem on Sunday, May 10 (1:00 PM–5:00 PM) brings past and present together with vehicles and stands on the Grote Markt. Free admission, an afternoon full of experiences for young and old.', 1, '2026-05-10', '2026-05-13', '3772FF', '080708');

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
(1, '/images/69f0f990596ac2.19617768_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', 'Planning a party?'),
(2, '/images/69f0f996b85650.84630794_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', 'Best value of food'),
(4, '/images/69f0f99dcfc9b1.40722995_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', 'Ratatouille colse days : Monday &amp; Tuesday'),
(5, '/images/69f0f9a6d26fc9.74194349_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg', 'Free own parking facilities');

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
(10, 'Churches & Religious Landmarks Tour', 'Discover the spiritual side of the city by visiting its most significant churches, cathedrals, and religious landmarks. Experience awe-inspiring architecture ranging from ', '/images/69ef5382175d18.47434352_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', 'https://www.example.com/history/religious-landmarks-tour', 'Header'),
(11, 'Ancient City Ruins', 'Step into a world frozen in time as you explore the ruins of an ancient city that flourished centuries ago. Wander through crumbling stone walls, weathered temples, and old marketplaces where merchants once traded goods from distant lands.', '/images/69ef53892a86e7.57690091_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', 'https://www.example.com/history/ancient-city-ruins', 'Introduction'),
(12, 'Medieval Castle Tour', 'Discover a colonial town frozen in time, where cobblestone streets, old town halls, and vintage houses tell stories of settlers and colonists. Learn about the architectural styles introduced during the colonial era and how they blended with local culture. Explore museums, public squares, and historical buildings that showcase governance, trade, and social life of the past. Hear tales of exploration, conflict, and community growth that shaped the town’s unique identity. This tour immerses you in centuries of history, giving insights into the everyday lives and struggles of people who built the town.', '/images/69ef539027b080.01846979_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg', 'https://www.example.com/history/medieval-castle', 'Information'),
(13, 'Historic Port City', 'Visit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant', '/images/69ef53976a9365.45098076_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', 'https://www.example.com/history/historic-port-city', 'RegularTicket'),
(14, 'Ancient Temples Expedition', 'Visit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant streets that once connected continents through commerce. Learn about legendary explorers, maritime adventures, and the city’s role in shaping regional and global trade routes\r\n\r\nVisit a historic port city that was a hub of trade, exploration, and cultural exchange for centuries. Walk along ancient docks, warehouses, and bustling merchant streets that once connected continents through commerce. Learn about legendary explorers, maritime adventures, and the city’s role in shaping regional and global trade routes', '/images/69ef539f644871.81370380_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg', 'https://www.example.com/history/historic-port-city', 'Information'),
(15, 'Ancient Temples Expedition', 'Embark on a journey to ancient temples that have survived the test of time, standing as a testament to human devotion and architectural brilliance. Marvel at intricately carved pillars, ', '/images/69ef53b94ffb81.09432597_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg', 'https://www.example.com/history/ancient-temples', 'RegularTicket'),
(16, 'Royal Palace & Gardens', 'Step into the opulent world of royalty by visiting grand palaces and meticulously maintained gardens. Explore luxurious halls adorned with golden chandeliers, intricate frescoes, and royal artifacts that showcase wealth,', '/images/69ef53b1ca0233.95926746_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', 'https://www.example.com/history/royal-palace', 'FamilyTicket'),
(17, 'Colonial Town Heritage', 'Discover a colonial town frozen in time, where cobblestone streets, old town halls, and vintage houses tell stories of settlers and colonists. Learn about the architectural styles introduced during the colonial era and how they blended with local culture', '/images/69ef53a97852c3.23166105_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', 'https://www.example.com/history/colonial-town', 'Routes');

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
(3, 2, 1, 2),
(4, 1, 3, 1000);

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
(101, 2, 1, 3, '2026-06-27', 'Hardwell Livex', 65.00, 'Club', '20:01:00', 90, '/images/6a330d4a9e6463.66060629_img1.jpg'),
(102, 2, 2, 4, '2026-07-31', 'Armin After Dark', 55.00, 'Club', '23:00:00', 120, '/images/6a330d536a2c47.90790943_img2.jpg'),
(103, 2, 3, 1, '2026-08-02', 'Martin Garrix Festival Set', 70.00, 'Club', '21:00:00', 90, '/images/6a330d5c210147.74236909_img3.jpg'),
(104, 2, 6, 4, '2026-07-31', 'Afrojack Midnight Session', 60.00, 'Club', '23:30:00', 90, '/images/6a330d6248fd78.58784105_img4.jpg'),
(105, 2, 4, 6, '2026-07-31', 'Tiësto Closing Show', 85.00, 'Club', '20:30:00', 120, '/images/6a330d6872bd24.51204897_img5.jpg'),
(106, 2, 5, 1, '2024-07-29', 'Nicky Romero Finale', 58.00, 'Club', '22:30:00', 90, '/images/6a330d6e6f7f66.03693300_img6.jpg');

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
(359, 101, 3, 2, 'Hardwell Livex', 'Club', '2026-06-27', '20:01:00', 90, 65.00, 1),
(360, 101, 4, 2, 'Hardwell Livex', 'Club', '2026-06-27', '20:01:00', 90, 65.00, 1),
(361, 101, 5, 2, 'Hardwell Livex', 'Club', '2026-06-27', '20:01:00', 90, 65.00, 1),
(362, 101, 6, 2, 'Hardwell Livex', 'Club', '2026-06-27', '20:01:00', 90, 65.00, 1),
(363, 102, 2, 2, 'Armin After Dark', 'Club', '2026-07-31', '23:00:00', 120, 55.00, 1),
(364, 102, 3, 2, 'Armin After Dark', 'Club', '2026-07-31', '23:00:00', 120, 55.00, 1),
(365, 102, 4, 2, 'Armin After Dark', 'Club', '2026-07-31', '23:00:00', 120, 55.00, 1),
(366, 103, 3, 2, 'Martin Garrix Festival Set', 'Club', '2026-08-02', '21:00:00', 90, 70.00, 1),
(367, 104, 6, 2, 'Afrojack Midnight Session', 'Club', '2026-07-31', '23:30:00', 90, 60.00, 1),
(368, 105, 4, 2, 'Tiësto Closing Show', 'Club', '2026-07-31', '20:30:00', 120, 85.00, 1),
(369, 106, 5, 2, 'Nicky Romero Finale', 'Club', '2024-07-29', '22:30:00', 90, 58.00, 1);

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
(58, 5, 275.00, NULL, 'completed', NULL, '2026-05-06 12:55:14', '2026-05-06 12:55:14', '2026-05-06 12:55:14');

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
(72, 58, 'reservation', 44, NULL, 1),
(73, 58, 'dance_ticket', 32, NULL, 1),
(74, 58, 'dance_ticket', 33, NULL, 1),
(75, 58, 'dance_ticket', 34, NULL, 1),
(76, 58, 'history_ticket', 35, NULL, 1);

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
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
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
(1, 'Ahsanul Rabbi Khan', '2024-07-27', 3, 1, 'admin@gmail.com', '0630414048', 5, 3, 1, 'this is test ', 40.00, 'completed', 'CONF-69B934B33A211', 0, 1, '2026-03-17 11:02:11', '2026-04-29 15:40:12'),
(3, 'Shad Callahan', '2024-07-28', 11, 59, 'kuwudirif@mailinator.com', '+1 (972) 585-3399', 5, 3, 1, 'Eligendi qui placeat', 700.00, 'completed', 'CONF-69D1EACB89D39', 0, 1, '2026-04-05 04:53:31', '2026-04-05 04:53:31'),
(5, 'Breanna Thomas', '2024-07-29', 75, 10, 'qobyd@mailinator.com', '+1 (636) 974-8198', 5, 2, 1, 'Quia consectetur in ', 850.00, 'completed', 'CONF-69D1ED1044AE9', 0, 1, '2026-04-05 05:03:12', '2026-04-05 05:03:12'),
(44, 'Ahsanul Rabbi Khan', '2024-07-30', 0, 2, 'admin@gmail.com', '+1 (435) 589-5129', 5, 2, 1, 'Distinctio Officia ', 35.00, 'completed', 'CONF-69FB3A32C6029', 0, 0, '2026-05-06 12:55:14', '2026-06-18 10:54:54'),
(45, 'Ahsanul Rabbi Khan', '2024-07-27', 2, 1, 'me.ahsanul01@gmail.com', '0630414048', 7, 4, 2, 'na', 92.50, 'completed', 'CONF-69FB5D8B0A61D', 0, 0, '2026-05-06 15:26:03', '2026-06-18 10:54:53'),
(46, 'Ahsanul Rabbi Khan', '2026-07-27', 1, 1, 'admin@gmail.com', '0630414048', 5, 2, 1, 'na', 52.50, 'completed', 'CONF-69FE6AF3B925B', 0, 1, '2026-05-08 23:00:03', '2026-05-08 23:00:03'),
(49, 'Tabeeb', '2026-07-28', 2, 1, 'tabeeb788@gmail.com', '0685807591', 26, 2, 1, '', 87.50, 'completed', 'CONF-6A33BF3D11824', 0, 1, '2026-06-18 09:49:49', '2026-06-18 09:49:49'),
(50, 'Asif Iqbal', '2026-07-27', 2, 1, 'asif170391@gmail.com', '0685807591', 28, 2, 1, '', 87.50, 'completed', 'CONF-6A33CA05A91EB', 0, 0, '2026-06-18 10:35:49', '2026-06-18 10:54:48');

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
  `price_for_child` double NOT NULL DEFAULT 0,
  `price_for_adult` double NOT NULL DEFAULT 0,
  `number_of_seats` int(11) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `gallery_images` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `title`, `image_url`, `description`, `ratings`, `cuisines`, `session_id`, `event_id`, `location`, `price_for_child`, `price_for_adult`, `number_of_seats`, `contact_email`, `contact_phone`, `gallery_images`) VALUES
(1, 'Café de Roemer', '/images/6a009a429cfc57.56735705_FRK4460k.jpg', '<p>Welcome to Café de Roemer, an iconic spot located on Botermarkt in the heart of Haarlem. A Haarlem institution for over 30 years, it\'s now owned by two enthusiastic entrepreneurs who are continuing the Roemer legacy with renewed energy. Step inside and discover our diverse menu, where classics meet surprising new flavors. Whether you\'re looking for a delicious lunch, a leisurely dinner, or just a relaxing drink, you\'re sure to find something to suit your taste. Enjoy the sun on our spacious and sunny terrace, or experience the outdoors year-round in our beautiful glass conservatory. Whatever the weather, at Café de Roemer we always offer a warm welcome and a cozy atmosphere. Our team is ready to make your experience unforgettable, with enthusiasm, hospitality, and a smile. Whether you\'re stopping by for a quick bite or a long night out, you\'ll always feel at home at Café de Roemer. Come visit us and discover the unique charm of Café de Roemer for yourself. We look forward to welcoming you!</p>', 4, 'Dutch, Fish and Seafood, European', 1, 1, 'Botermarkt 17, 2011 XL Haarlem', 17.5, 35, 35, 'info@cafederoemer.nl', '02857488', '[\"\\/images\\/6a009b9398e992.44975133_gallery-1.jpg\",\"\\/images\\/6a009b939d1353.81654949_img-2.jpg\",\"\\/images\\/6a009b93a2e1e2.46108925_img-3.png\"]'),
(2, 'Ratatouille', '/images/6a009d0a7b2337.08443244_img-r-1.jpg', 'Welkom bij Ratatouille Food and Wine, waar gastronomie een kunst wordt en gastvrijheid de kern vormt van onze ervaring. Gelegen in het hart van Haarlem, is ons restaurant onder leiding van de bevlogen chef Jozua Jaring een toevluchtsoord voor liefhebbers van verfijnde smaken en stijlvolle culinaire avonturen.', 4, 'French, fish and seafood, European', NULL, 1, 'Spaarne 96, 2011 CL Haarlem, Nederland', 22.5, 35, 52, 'info@ratatouillefoodandwine.nl', '023 542 7270', '[\"\\/images\\/6a009d8b584a98.83998233_img-r-2.jpg\",\"\\/images\\/6a009d8b5fd634.51047600_img-r-3.jpg\",\"\\/images\\/6a009d8b6732c8.19972633_img-r-4.jpg\"]'),
(4, 'Restaurant ML', '/images/6a009e4615d762.52485026_img-ml1.jpg', '<p>Restaurant ML is gevestigd in hart van het sfeervolle rijksmonument aan het Klokhuisplein. Het restaurant bevindt zich op de binnenplaats van voormalige drukker Johan Enschedé en in de oude stijlkamer van het voormalige woonhuis van de familie Enschedé. De elegante keuken van chef-kok Mark Gratama is gedurfd door de spannende combinatie van smaken. Het decor is strak en modern en vormt een prima achtergrond voor de culinaire sensaties die chef-kok Mark Gratama en zijn keukenteam presenteren. Vanuit het restaurant heeft u goed zicht op de open keuken en kunt u goed zien met hoeveel passie en aandacht de gerechten worden bereid.</p>', 4, 'Dutch, fish and seafood, European', NULL, 1, 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', 22.5, 45, 60, 'reserveringen@mlinhaarlem.nl', '+31 (0)23 512 39 10', '[\"\\/images\\/6a009e461a3723.58694176_image00061.jpeg\",\"\\/images\\/6a009e461cfbb6.38380308_Raam restaurant ML.jpg\",\"\\/images\\/6a009e4620d343.65639004_Restaurant ML 4.jpg\"]');

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
(103, 1, 1),
(104, 1, 2),
(105, 1, 5),
(108, 2, 2),
(109, 2, 4),
(110, 4, 1),
(111, 4, 2),
(112, 4, 5);

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
  `map_url` longtext DEFAULT NULL,
  `section_type` varchar(100) DEFAULT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_title`, `section_sub_title`, `content`, `image_url`, `map_url`, `section_type`, `page_id`) VALUES
(1, 'Discover Food  & Drinks', '', '<p><span style=\"font-family: Arial;\">﻿</span>When you say Haarlem, you immediately think of culinary experiences. This vibrant city offers something for every taste, from chic restaurants where you can enjoy refined dining to cozy cafés and lively eateries perfect for a quick and delicious bite. Stroll through its charming streets and you’ll find inviting coffee bars serving expertly brewed drinks, welcoming tasting rooms where you can sample local flavors, and atmospheric breweries offering craft beers with character. Whether you’re looking for a relaxed lunch, an indulgent dinner, or simply a place to unwind with a drink, Haarlem’s diverse food and drink scene makes it a true destination for anyone who loves good taste and great atmosphere. 🍽️☕🍺</p>', '/images/6a00a0b3e516d6.35189906_Rucola-rooftop-dining.jpg', 'https://maps.app.goo.gl/o69KfbnbDv6tDm8q8', 'header', 6),
(2, 'About Us', 'About our company', '<p>Our journey began at Inholland University of Applied Sciences, where we met as a team of students passionate about technology and problem-solving. With backgrounds in IT and a shared curiosity for how digital solutions could make life easier, we often found ourselves discussing real-world challenges and how software could solve them. It wasn’t long before the idea sparked: What if we started our own IT company—one that focused not on trends or hype, but on building useful, reliable tools that actually help businesses grow? That idea became our mission. We founded our company with one goal in mind: to build valuable digital products that solve real business problems. From the start, we’ve focused on clarity, practicality, and purpose—cutting through the noise to deliver solutions that truly support teams and organizations. Our vision is simple: empower businesses to scale and thrive through technology. We believe digital tools should feel like an extension of your goals, not a barrier. That means making digital less confusing, more helpful, and always aligned with your needs. We’re human-first, results-driven, and always collaborative. We listen before we build. We explain things clearly. We avoid shortcuts, respect your time, and treat every project like a partnership. With us, you’ll always know where things stand, and what’s coming next. This is our story—rooted in curiosity, grown through collaboration, and driven by a commitment to help businesses succeed with technology that works. #inholland hashtag #LearningTogether hashtag #InhollandUniversityofAppliedSciences</p>', '/images/69f09de0c990c9.09282870_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d77928.45010589875!2d4.5604782532059716!3d52.383763152369276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6c60e1e9fb%3A0x8ae15680b8a17e39!2sHaarlem!5e0!3m2!1sen!2snl!4v1781778696321!5m2!1sen!2snl', 'location', 7),
(3, 'You don\'t want to miss this', '', '<font color=\"#4a4a49\" face=\"WixMadeforText-VariableFont_wght, sans-serif\"><span style=\"font-size: 17px;\">From Dutch Masters to modern art, from arthouse films to children\'s theater, from pop concerts to city history: if you\'re looking for inspiration, art, and culture, Haarlem is sure to satisfy your cravings. Not only is Haarlem home to the oldest museum in the Netherlands, but its historic city center is also bustling with cultural hotspots, (art) history, and creative initiatives.</span></font>', '/images/69f09df0959509.33145692_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', '', 'tour_information', 2),
(4, 'Art and Culture', '', '<p>Be amazed by Haarlem\'s rich art and culture. Will it be a museum, the theater, or a stroll past historic monuments?  Haarlem\'s artistic soul. Haarlem is a paradise for art lovers, with a wide range of museums, galleries, and cultural events. Immerse yourself in the city\'s artistic offerings and witness the interplay between tradition and innovation. Art and culture in Haarlem truly embrace and celebrate the spirit of creativity. Here\'s a glimpse of what this enchanting city has to offer</p>', '/images/69f73528762be6.73121083_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', '', 'header', 2),
(15, 'Haarlem Festival', '', '<br>', '/images/69fafcd567a010.26327231_image9.png', '', 'header', 1),
(16, 'The largest Haarlem summer events of 2026 at a glance!', '', 'Good music, amazing food, and unforgettable vibes.<br data-start=\"187\" data-end=\"190\">\r\nJoin us for a night of dance, yummy flavors, and great moments at our restaurant event. Bring your friends and enjoy the perfect mix of fun and taste.', '/images/69fb3f9e75f066.38265893_section-2.png', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2433.744888616002!2d4.6141989!3d52.3961483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6c60e1e9fb%3A0x8ae15680b8a17e39!2sHaarlem%2C%20Netherlands!5e0!3m2!1sen!2sin!4v1649839892387!5m2!1sen!2sin', 'instruction', 1);

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
(3, NULL, '18:00:00', NULL, NULL, 1, NULL, 1, NULL, 3, 3, '1.5', '18:00:00'),
(4, NULL, '17:00:00', NULL, NULL, 1, NULL, 2, NULL, 4, 4, '2', '17:00:00'),
(5, NULL, '19:00:00', NULL, NULL, 1, NULL, 2, NULL, 4, 4, '2', '19:00:00'),
(6, NULL, '21:00:00', NULL, NULL, 1, NULL, 2, NULL, 4, 4, '2', '21:00:00'),
(7, NULL, '17:00:00', NULL, NULL, 1, NULL, 4, NULL, 4, 4, '2', '17:00:00'),
(8, NULL, '19:00:00', NULL, NULL, 1, NULL, 4, NULL, 4, 4, '2', '19:00:00'),
(10, NULL, '12:08:00', NULL, NULL, 1, NULL, 4, NULL, 200, 200, '200', '12:08:00'),
(11, NULL, '13:44:00', NULL, NULL, 1, NULL, 2, NULL, 2, 2, '2', '13:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` varchar(50) DEFAULT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `customer_name`, `event_name`, `event_date`, `event_time`, `qr_code`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', '4a3e2cbb040fb07ccbebc73d0254aea9', 'new', '2026-04-06 04:54:59', '2026-04-06 04:54:59'),
(2, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', 'da4ba9660c674bd87bdf5dcc78b02b4b', 'new', '2026-04-06 04:58:34', '2026-04-06 04:58:34'),
(3, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', '392ac36170b41feed7075d8706227d53', 'new', '2026-04-06 05:20:25', '2026-04-06 05:20:25'),
(4, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', 'fc82a0dbff01964d6b25765f83b7af4d', 'new', '2026-04-06 05:41:08', '2026-04-06 05:41:08'),
(5, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', '2bb5ec4815dc2a847264d4e7b991ef15', 'new', '2026-04-07 19:34:44', '2026-04-07 19:34:44'),
(6, NULL, 'Tabeeb', 'Hardwell Live', '2024-07-27', '20:00:00', '84098f0ff4f71deb4855faceb471fab2', 'new', '2026-04-07 20:57:52', '2026-04-07 20:57:52'),
(7, NULL, 'Tabeeb', 'Armin After Dark', '2024-07-27', '23:00:00', '7d65fd897b035de049cf886fc2f1c129', 'new', '2026-04-07 20:57:52', '2026-04-07 20:57:52'),
(8, NULL, 'Tabeeb', 'Tiësto Closing Show', '2024-07-29', '20:30:00', '810ceb10a72e1e0a0418ce05fbe5546f', 'new', '2026-04-07 21:01:45', '2026-04-07 21:01:45'),
(9, NULL, 'Tabeeb', 'Nicky Romero Finale', '2024-07-29', '22:30:00', 'ba99b7be1f5385b5698274c7d7fa9621', 'new', '2026-04-07 21:01:45', '2026-04-07 21:01:45'),
(10, NULL, 'Tabeeb', 'Tiësto Closing Show', '2024-07-29', '20:30:00', '1f41a5d0fce6bbd7b48088b843f30fcf', 'new', '2026-04-07 21:01:45', '2026-04-07 21:01:45'),
(11, NULL, 'Tabeeb', 'Nicky Romero Finale', '2024-07-29', '22:30:00', 'ebcf4bf90198ab4a083d351203ea404b', 'new', '2026-04-07 21:01:45', '2026-04-07 21:01:45'),
(12, NULL, 'Ahsanul Rabbi Khan', 'Mandarin', '2026-05-16', '10:00:00', '65738c28be9761bdc6ed74527b7fae5f', 'new', '2026-04-07 23:15:20', '2026-04-07 23:15:20'),
(13, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', 'd1abc1c4c0dfa5a79d6e4883ac4494b3', 'new', '2026-04-07 23:18:01', '2026-04-07 23:18:01'),
(14, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', '55eed661c9d3c1a3c175ac8fe6f63737', 'new', '2026-05-05 18:07:01', '2026-05-05 18:07:01'),
(15, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', '3aa630150226db8272f97a25f8f9cfca', 'new', '2026-05-05 18:07:01', '2026-05-05 18:07:01'),
(16, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', '3fbeee596a7b18e15a5f7ee9b24aaa90', 'new', '2026-05-05 18:07:01', '2026-05-05 18:07:01'),
(17, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', '62a561575cecb45d924732ac0a73c7e8', 'new', '2026-05-05 18:31:05', '2026-05-05 18:31:05'),
(18, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', '20d755ef30f55e2427f4ebc948575158', 'new', '2026-05-05 18:31:05', '2026-05-05 18:31:05'),
(19, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', '53b53758d58b1f6a3a77f43f0f1085a3', 'new', '2026-05-05 18:31:05', '2026-05-05 18:31:05'),
(20, NULL, 'Ahsanul Rabbi Khan', 'Saturday Dance Pass', NULL, NULL, '178b415f59a5dd861ee818a72b44f0a3', 'new', '2026-05-05 18:31:05', '2026-05-05 18:31:05'),
(21, NULL, 'Ahsanul Rabbi Khan', 'Hardwell Livex', '2026-06-27', '20:01:00', 'b4e2229b2cd8bdca6600b74f28f3d67f', 'new', '2026-05-05 18:31:05', '2026-05-05 18:31:05'),
(22, NULL, 'Paul Jacobson', 'Dutch', '2026-05-17', '10:00:00', '46f4f956545e76534469ea3253ffd58a', 'new', '2026-05-06 04:22:00', '2026-05-06 04:22:00'),
(23, NULL, 'Paul Jacobson', 'Martin Garrix Festival Set', '2026-08-02', '21:00:00', '2700263395e56a7d624fddfcf2babe1a', 'new', '2026-05-06 04:22:00', '2026-05-06 04:22:00'),
(24, NULL, 'Paul Jacobson', 'Hardwell Livex', '2026-06-27', '20:01:00', 'ec4874ec75916747466a7ccb6b78aa97', 'new', '2026-05-06 04:22:00', '2026-05-06 04:22:00'),
(25, NULL, 'Paul Jacobson', 'Dutch', '2026-05-17', '10:00:00', 'dc5cf0351edefbe62bfee21e57633f70', 'new', '2026-05-06 04:29:10', '2026-05-06 04:29:10'),
(26, NULL, 'Paul Jacobson', 'Armin After Dark', '2026-07-31', '23:00:00', '7af54f0285ca7acb0bee20d6e44b11c3', 'new', '2026-05-06 04:29:10', '2026-05-06 04:29:10'),
(27, NULL, 'Paul Jacobson', 'Afrojack Midnight Session', '2026-07-31', '23:30:00', 'd8e71f41c1285d89d59a5f50ab958374', 'new', '2026-05-06 04:29:10', '2026-05-06 04:29:10'),
(28, NULL, 'Paul Jacobson', 'Dutch', '2026-05-17', '10:00:00', 'c695afc588b6db609d006e7bb1f08a71', 'new', '2026-05-06 04:57:38', '2026-05-06 04:57:38'),
(29, NULL, 'Paul Jacobson', 'Afrojack Midnight Session', '2026-07-31', '23:30:00', 'e87365809a99c7f9e868b791664ee1b9', 'new', '2026-05-06 04:57:38', '2026-05-06 04:57:38'),
(30, NULL, 'Paul Jacobson', 'Armin After Dark', '2026-07-31', '23:00:00', '2efe809694ca164fa1be20d7baa13867', 'new', '2026-05-06 04:57:38', '2026-05-06 04:57:38'),
(31, NULL, 'Paul Jacobson', 'Hardwell Livex', '2026-06-27', '20:01:00', '8613cadfc8e330274267dd5be82ff7ae', 'new', '2026-05-06 04:57:38', '2026-05-06 04:57:38'),
(32, NULL, 'Ahsanul Rabbi Khan', 'Afrojack Midnight Session', '2026-07-31', '23:30:00', 'a0e6de3ed0342e075d8f805c3d203030', 'new', '2026-05-06 12:55:14', '2026-05-06 12:55:14'),
(33, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', 'eebbeb5ec50b5e875a084f86389cd55e', 'new', '2026-05-06 12:55:14', '2026-05-06 12:55:14'),
(34, NULL, 'Ahsanul Rabbi Khan', 'Hardwell Livex', '2026-06-27', '20:01:00', 'e6aaedd98e1a1c6d76b8fdc49e070cf3', 'new', '2026-05-06 12:55:14', '2026-05-06 12:55:14'),
(35, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', '5e642b9b6de3085cf91c908e5d9c5108', 'new', '2026-05-06 12:55:14', '2026-05-06 12:55:14'),
(36, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', 'a916a540b0fb6fb933b1d02119a059cd', 'new', '2026-05-06 15:26:03', '2026-05-06 15:26:03'),
(37, NULL, 'Ahsanul Rabbi Khan', 'Afrojack Midnight Session', '2026-07-31', '23:30:00', 'f5a86047dbf37fe930c2262600636118', 'used', '2026-05-06 15:26:03', '2026-05-06 15:28:27'),
(38, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', '1695293952b0933040eecd544aa75ee5', 'new', '2026-05-08 23:00:03', '2026-05-08 23:00:03'),
(39, NULL, 'Ahsanul Rabbi Khan', 'Armin After Dark', '2026-07-31', '23:00:00', 'f69131815542c72d0d5ee9735fe26605', 'new', '2026-05-08 23:00:03', '2026-05-08 23:00:03'),
(40, NULL, 'Ahsanul Rabbi Khan', 'Dutch', '2026-05-17', '10:00:00', '0330502846e454a72c6732e5b99bce3c', 'new', '2026-05-09 16:08:18', '2026-05-09 16:08:18'),
(41, NULL, 'Ahsanul Rabbi Khan', 'Afrojack Midnight Session', '2026-07-31', '23:30:00', '33a7611e1cde4086784e218b0e5277c0', 'new', '2026-05-09 16:08:18', '2026-05-09 16:08:18'),
(42, NULL, 'Tabeeb', 'Hardwell Livex', '2026-06-27', '20:01:00', '0590c72db1fdb7c267d31e8ebb6b8cee', 'new', '2026-06-18 07:20:26', '2026-06-18 07:20:26'),
(43, NULL, 'Tabeeb', 'Friday Dance Pass', NULL, NULL, '68cde654e7bff858e1347c5496edbf7b', 'new', '2026-06-18 07:20:26', '2026-06-18 07:20:26'),
(44, NULL, 'Tabeeb', 'Dutch', '2026-05-17', '10:00:00', '71d0073cde9237c8a29585c05c17eb9a', 'new', '2026-06-18 07:20:26', '2026-06-18 07:20:26'),
(45, NULL, 'Tabeeb', 'Mandarin', '2026-05-16', '10:00:00', 'd4bee333e018dc37eeb3b141d2025d21', 'used', '2026-06-18 09:49:49', '2026-06-18 09:51:57'),
(46, NULL, 'Tabeeb', 'Saturday Dance Pass', '2026-06-27', NULL, 'ade946d26979875c909838ff8ab4e255', 'used', '2026-06-18 09:49:49', '2026-06-18 09:52:09'),
(47, NULL, 'Tabeeb', 'Tiësto Closing Show', '2026-07-31', '20:30:00', 'a959f08bf3a68db821c6c6a675245dcd', 'used', '2026-06-18 09:49:49', '2026-06-18 09:52:22'),
(48, NULL, 'Asif Iqbal', 'Mandarin', '2026-05-16', '10:00:00', '4affa3cfc24a7c188475c9f647bd8108', 'used', '2026-06-18 10:35:49', '2026-06-18 10:36:18'),
(49, NULL, 'Asif Iqbal', 'Saturday Dance Pass', '2026-06-27', NULL, '361c2f828149aaa72232bb718d7afd18', 'used', '2026-06-18 10:35:49', '2026-06-18 10:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_pass`
--

CREATE TABLE `ticket_pass` (
  `pass_id` int(11) NOT NULL,
  `passName` varchar(255) DEFAULT NULL,
  `passDescription` text DEFAULT NULL,
  `passPrice` decimal(10,2) DEFAULT NULL,
  `passType` varchar(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `pass_scope` enum('day','all_dates') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `ticket_pass`
--

INSERT INTO `ticket_pass` (`pass_id`, `passName`, `passDescription`, `passPrice`, `passType`, `event_date`, `pass_scope`) VALUES
(1, 'Saturday Dance Pass', 'Access to all Haarlem Festival dance events on Saturday 27 June 2026.', 79.00, 'Day Pass', '2026-06-27', 'day'),
(2, 'Sunday Dance Pass', 'Access to all Haarlem Festival dance events on Sunday 2 August 2026.', 79.00, 'Day Pass', '2026-08-02', 'day'),
(3, 'All-Round Dance Pass', 'Access to every date that currently has a Haarlem Festival dance performance.', 199.00, 'All-Round Pass', NULL, 'all_dates'),
(4, 'Friday Dance Pass', 'Access to all Haarlem Festival dance events on Friday 31 July 2026.', 79.00, 'Day Pass', '2026-07-31', 'day');

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
(6, 'Old Town Square', 'Old Town Square is the historic and cultural centerpiece of the city, dating back several centuries. Surrounded by beautifully preserved buildings, charming cafes, and traditional shops, the square reflects a blend of medieval and modern influences. Over the years, it has served as a marketplace, a gathering point for social and political events, and a hub for cultural celebrations. Visitors can enjoy street performances, seasonal festivals, and local artisan stalls that bring the area to life. The atmosphere changes throughout the day—from peaceful mornings with soft sunlight over cobblestone streets to vibrant evenings filled with music and activity. It offers an immersive experience for anyone interested in history, architecture, and local traditions.', 'Old Town Square, Central District, Haarlem, Netherlands', 'Phone: +31 23 123 4567 Email: info@oldtownhaarlem.nl', '/images/69ef529900e4f1.81717248_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg'),
(7, 'St. Bavo Church', 'St. Bavo Church is one of the most iconic landmarks in the city, showcasing remarkable Gothic architecture and centuries of history. Constructed during the medieval period, the church stands as a testament to the craftsmanship and artistic excellence of its time. Inside, visitors are greeted by intricate stonework, stunning stained glass windows, and a magnificent pipe organ that has attracted musicians from around the world—including the legendary Mozart. The church has played an important role not only as a place of worship but also as a center for community gatherings and historical events.', 'Grote Markt 22, 2011 RD Haarlem, Netherlands', 'Phone: +31 23 555 7890 Email: contact@stbavochurch.nl', '/images/69ef52a00a70f8.99404637_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg'),
(8, 'Haarlemmerhout Park', 'Haarlemmerhout Park is one of the oldest public parks in the Netherlands, offering a peaceful escape from the busy city environment. Known for its lush greenery, walking trails, and scenic landscapes, the park has been a favorite destination for locals and visitors for generations. Historically, it served as a recreational space for the city’s residents and has gradually evolved into a well-maintained urban park with modern amenities. Visitors can enjoy leisurely walks, cycling, picnics, and outdoor activities while surrounded by tall trees and open green spaces. The park also hosts seasonal events, cultural activities, and small gatherings that make it a lively yet relaxing destination. Its combination of natural beauty and historical significance makes it a must-visit location for anyone exploring the area.', 'Haarlemmerhout, 2012 Haarlem, Netherlands', 'Phone: +31 23 987 6543 Email: info@haarlemmerhoutpark.nl', '/images/69ef52a761d884.19826769_69cd5706c66428.02771746_Malersaal-Event-1024x682.jpg');

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
(1, 'Admin', 'admin@example.com', '$2y$10$beDIFBAcgRMPmCCqdApyJeZx6tarAEkjieONMOMPnDrWKM2DSV.6O', NULL, '2026-06-13 19:12:33', 'Admin'),
(5, 'Ahsanul Rabbi Khan', 'admin@gmail.com', '$2y$12$TX96VFo68b5e92WKIaQGG.slu.Qbsrc5sascfOTeXUwbTZmr7dlw.', '/images/69ef54db0a4db4.63335257_69cd577a895885.60786419_premium_photo-1683140768507-fef7bb775f13.jpg', '2026-03-02 21:49:06', 'Admin'),
(6, 'Ahasanul Rabbi Khan', 'ahsan@gmail.com', '$2y$12$TnGSKXJmH0IYI1TzVWsPFunSDnlbU0XEcTblb8J0fNLrIDUryA5Aa', '/images/69ef55362cd362.02888171_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', '2026-03-06 20:03:12', 'Admin'),
(7, 'Ahsanul Rabbi Khan', 'me.ahsanul01@gmail.com', '$2y$12$x6juwndsZypeVtoKPTZWaOCsRD9s6ml1X4QBlmUx9DEAxlGSikGLi', '/images/69ef552f4db507.60842714_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', '2026-03-08 00:06:16', 'Customer'),
(16, 'Lara Daugherty', 'gekawudos@mailinator.com', '$2y$12$JkYk8rTZrOS6R56OfAG1g.ubazlnFxFU7eHauNMyXH3ZNzxYbNWX2', '', '2026-04-29 16:50:10', 'Customer'),
(17, 'Hilel Dalton', 'hybasuz@mailinator.com', '$2y$12$5yQzIUa88ArvxrSPtghEEOZruKmPR.G2E7QMvHnuoSJPWeoQokQsu', '/images/default.php', '2026-05-03 08:04:54', 'Customer'),
(18, 'Ignacia Norris', 'mohicywy@mailinator.com', '$2y$12$zNImQvXcjB6jPgNMIfxlCOSOqmbs/lW5NDI3yhy.Okpvuq8oJlJtu', '/images/default.php', '2026-05-03 08:05:37', 'Customer'),
(19, 'Bruno Harmon', 'cuhe@mailinator.com', '$2y$12$4uRAnrSP90iMgjL5vqtkDudwtnhVc1xZ5hInhIjfRGKZj61CpK0IW', '/images/default.php', '2026-05-03 08:05:45', 'Customer'),
(20, 'Lydia Joyner', 'lokamibuw@mailinator.com', '$2y$12$ZFpWgG5uJvPyByc4IIMhae4KOmiSAs4VTd6MMwQ3p3PLrH920VjLm', '/images/69f702651fb514.65497136_69cd5753edbbb5.83085371_IMG_8670-scaled.jpg', '2026-05-03 08:08:05', 'Customer'),
(22, 'Octavius Eaton', 'liqeba@mailinator.com', '$2y$12$0xC2MfRkg9o7tYld9GEoVO5Hg9dfZaINw8YJ40APv/xOfjJVV8vvO', '/images/default.php', '2026-05-05 04:46:07', 'Customer'),
(23, 'Alex', 'nafiz0khan1@gmail.com', '$2y$12$8JrNR04OenwF1B9GY/gxY.KSmhvlbrC7I7/WaI2XuYMZx8FvvXCE2', '/images/69fade1c0684d1.62826879_carbone.jpg', '2026-05-05 06:47:34', 'Customer'),
(24, 'Dylan Cervantes', 'dori@mailinator.com1', '$2y$12$mQ9QR/tZnTDoQjB4P8SfVenMXzPBZsrwuvRE3Jh2z5cDXD.gAiPKC', '/images/default.webp', '2026-05-06 04:20:19', 'Customer'),
(25, 'Alisa Garza', 'hotoriqobi@mailinator.com', '$2y$12$h6xXulCNPmuEvi5nW/hjJuf0GnJUyAkDaB2ciK50IXSlFNMM/rBJq', '', '2026-05-06 07:36:00', 'Customer'),
(26, 'Tabeeb', 'tabeeb788@gmail.com', '$2y$10$beDIFBAcgRMPmCCqdApyJeZx6tarAEkjieONMOMPnDrWKM2DSV.6O', '/images/6a330cd61c8f42.82867105_Sachthuis.jpg', '2026-06-13 19:11:58', 'Customer'),
(28, 'Asif Iqbal', 'asif170391@gmail.com', '$2y$12$/sEVjPR6gnbSCVvhKKgcMO90mFdqKag3lylSvJljaT.LJW2Zdg.Z2', '/images/default.php', '2026-06-18 10:33:00', 'Customer');

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
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history_event_date`
--
ALTER TABLE `history_event_date`
  MODIFY `event_date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_info`
--
ALTER TABLE `history_info`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `music_events`
--
ALTER TABLE `music_events`
  MODIFY `music_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `music_performance`
--
ALTER TABLE `music_performance`
  MODIFY `music_performance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `price_list`
--
ALTER TABLE `price_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `restaurant_features`
--
ALTER TABLE `restaurant_features`
  MODIFY `restaurant_features_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
  MODIFY `tour_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tour_timetable`
--
ALTER TABLE `tour_timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
