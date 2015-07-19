-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2015 at 09:39 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gotheels`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `category_icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `category_icon`) VALUES
(2, 'BRAND', 'Shop by different shoes brand', 'default_icon.png'),
(3, 'SIZE', 'Shop by different size', 'default_icon.png'),
(4, 'STYLE', 'Shop all shoe filter by Style', 'default_icon.png'),
(5, 'OCCASION', 'Shop shoe for different occasion, events', 'default_icon.png'),
(6, 'BOOTS', 'Shop all boots: Ankel boot, mid calf bootss and knee boots..', 'default_icon.png'),
(7, 'SALES', 'All shoes in sale, promotion shoes, clearance shoes, on-sale shoes', 'default_icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_fname` char(20) NOT NULL,
  `customer_lname` char(20) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` char(40) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `street` char(40) DEFAULT NULL,
  `city` char(40) DEFAULT NULL,
  `state` char(20) DEFAULT NULL,
  `zip` char(10) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_fname`, `customer_lname`, `email`, `password`, `level`, `street`, `city`, `state`, `zip`) VALUES
(75, 'Hong', 'Todd', 'test@yahoo.com', '806b2af4633e64af88d33fbe4165a06a', 1, NULL, NULL, NULL, NULL),
(76, 'Hong', 'min', 'test2@yahoo.com', '806b2af4633e64af88d33fbe4165a06a', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) NOT NULL,
  `thumb_filename` varchar(50) NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `filename`, `thumb_filename`, `caption`, `product_id`) VALUES
(1, 'Amachi_MAIN_LG.jpg', 'Amachi_MAIN_TH.jpg', 'Wedge open toe shoes', 1),
(2, 'Yuky_MAIN_LG.jpg', 'Yuky_MAIN_TH.jpg', 'Faux Fur Boot shoes', 2),
(3, 'benson_MAIN_LG.jpg', 'benson_MAIN_TH.jpg', 'Red Pump shoe', 3),
(4, 'mindy_MAIN_LG.jpg', 'mindy_MAIN_TH.jpg', 'Flat ballet shoes', 4),
(5, 'leno_MAIN_LG.jpg', 'leno_MAIN_TH.jpg', 'Orange Flat Ballet shoe', 5),
(6, 'vies_MAIN_LG.jpg', 'vies_MAIN_TH.jpg', 'Texture brown pump shoes', 6),
(7, 'coral_MAIN_LG.jpg', 'coral_MAIN_TH.jpg', 'Orange Yellow Coral Reef pump holiday sandal shoes', 7),
(8, 'Luis_MAIN_LG.jpg', 'Luis_MAIN_TH.jpg', 'black open-toe shoes', 8),
(9, 'Amenica_MAIN_LG.jpg', 'Amenica_MAIN_TH.jpg', 'Blue stripe pump sandal shoe', 9),
(10, 'holesoul_MAIN_LG.jpg', 'holesoul_MAIN_TH.jpg', 'milky knee boots', 10),
(11, 'Beaky_MAIN_LG.jpg', 'Beaky_MAIN_TH.jpg', 'Red snake skin pump sandal', 11),
(12, 'beakys_MAIN_LG.jpg', 'beakys_MAIN_TH.jpg', 'Silver sandal open-toe shoe', 12),
(13, 'beakyg_MAIN_LG.jpg', 'beakyg_MAIN_TH.jpg', 'gold sandal open-toe working holiday shoes', 13),
(14, 'jungle_MAIN_LG.jpg', 'jungle_MAIN_TH.jpg', 'High heel black pump Sandals shoe ', 14),
(15, 'alani_MAIN_LG.jpg', 'alani_MAIN_TH.jpg', 'black ankle boot', 15);

-- --------------------------------------------------------

--
-- Table structure for table `imagezoom`
--

CREATE TABLE IF NOT EXISTS `imagezoom` (
  `imagezoom_id` int(11) NOT NULL AUTO_INCREMENT,
  `zoom_filename` varchar(50) NOT NULL,
  `zoom_thumb` varchar(50) NOT NULL,
  PRIMARY KEY (`imagezoom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `imagezoom`
--

INSERT INTO `imagezoom` (`imagezoom_id`, `zoom_filename`, `zoom_thumb`) VALUES
(1, 'Amachi_MAIN_LG.jpg', 'Amachi_MAIN_TH.jpg'),
(2, 'Amachi_font_LG.jpg', 'Amachi_font_TH.jpg'),
(3, 'Amachi_HEEL_LG.jpg', 'Amachi_HEEL_TH.jpg'),
(4, 'Amachi_IN_LG.jpg', 'Amachi_IN_TH.jpg'),
(5, 'Amachi_OUT_LG.jpg', 'Amachi_OUT_TH.jpg'),
(6, 'Yuky_MAIN_LG.jpg', 'Yuky_MAIN_TH.jpg'),
(7, 'Yuky_IN_LG.jpg', 'Yuky_IN_TH.jpg'),
(8, 'Yuky_OUT_LG.jpg', 'Yuky_OUT_TH.jpg'),
(9, 'Yuky_FRONT_LG.jpg', 'Yuky_FRONT_TH.jpg'),
(10, 'Yuky_HEEL_LG.jpg', 'Yuky_HEEL_TH.jpg'),
(11, 'benson_MAIN_LG.jpg', 'benson_MAIN_TH.jpg'),
(12, 'benson_IN_LG.jpg', 'benson_IN_TH.jpg'),
(13, 'benson_OUT_LG.jpg', 'benson_OUT_TH.jpg'),
(14, 'benson_FRONT_LG.jpg', 'benson_FRONT_TH.jpg'),
(15, 'benson_HEEL_LG.jpg', 'benson_HEEL_TH.jpg'),
(16, 'mindy_MAIN_LG.jpg', 'mindy_MAIN_TH.jpg'),
(17, 'mindy_IN_LG.jpg', 'mindy_IN_TH.jpg'),
(18, 'mindy_OUT_LG.jpg', 'mindy_OUT_TH.jpg'),
(19, 'mindy_FRONT_LG.jpg', 'mindy_FRONT_TH.jpg'),
(20, 'mindy_HEEL_LG.jpg', 'mindy_HEEL_TH.jpg'),
(21, 'leno_MAIN_LG.jpg', 'leno_MAIN_TH.jpg'),
(22, 'leno_IN_LG.jpg', 'leno_IN_TH.jpg'),
(23, 'leno_OUT_LG.jpg', 'leno_OUT_TH.jpg'),
(24, 'leno_FRONT_LG.jpg', 'leno_FRONT_TH.jpg'),
(25, 'leno_HEEL_LG.jpg', 'leno_HEEL_TH.jpg'),
(26, 'vies_MAIN_LG.jpg', 'vies_MAIN_TH.jpg'),
(27, 'vies_IN_LG.jpg', 'vies_IN_TH.jpg'),
(28, 'vies_OUT_LG.jpg', 'vies_OUT_TH.jpg'),
(29, 'vies_FRONT_LG.jpg', 'vies_FRONT_TH.jpg'),
(30, 'vies_HEEL_LG.jpg', 'vies_HEEL_TH.jpg'),
(31, 'coral_MAIN_LG.jpg', 'coral_MAIN_TH.jpg'),
(32, 'coral_IN_LG.jpg', 'coral_IN_TH.jpg'),
(33, 'coral_OUT_LG.jpg', 'coral_OUT_TH.jpg'),
(34, 'coral_FRONT_LG.jpg', 'coral_FRONT_TH.jpg'),
(35, 'coral_HEEL_LG.jpg', 'coral_HEEL_TH.jpg'),
(36, 'Luis_MAIN_LG.jpg', 'Luis_MAIN_TH.jpg'),
(37, 'Luis_IN_LG.jpg', 'Luis_IN_TH.jpg'),
(38, 'Luis_OUT_LG.jpg', 'Luis_OUT_TH.jpg'),
(39, 'Luis_FRONT_LG.jpg', 'Luis_FRONT_TH.jpg'),
(40, 'Luis_HEEL_LG.jpg', 'Luis_HEEL_TH.jpg'),
(41, 'Amenica_MAIN_LG.jpg', 'Amenica_MAIN_TH.jpg'),
(42, 'Amenica_IN_LG.jpg', 'Amenica_IN_TH.jpg'),
(43, 'Amenica_OUT_LG.jpg', 'Amenica_OUT_TH.jpg'),
(44, 'Amenica_FRONT_LG.jpg', 'Amenica_FRONT_TH.jpg'),
(45, 'Amenica_HEEL_LG.jpg', 'Amenica_HEEL_TH.jpg'),
(46, 'holesoul_MAIN_LG.jpg', 'holesoul_MAIN_TH.jpg'),
(47, 'holesoul_IN_LG.jpg', 'holesoul_IN_TH.jpg'),
(48, 'holesoul_OUT_LG.jpg', 'holesoul_OUT_TH.jpg'),
(49, 'holesoul_FRONT_LG.jpg', 'holesoul_FRONT_TH.jpg'),
(50, 'holesoul_HEEL_LG.jpg', 'holesoul_HEEL_TH.jpg'),
(51, 'Beaky_MAIN_LG.jpg', 'Beaky_MAIN_TH.jpg'),
(52, 'Beaky_IN_LG.jpg', 'Beaky_IN_TH.jpg'),
(53, 'Beaky_OUT_LG.jpg', 'Beaky_OUT_TH.jpg'),
(54, 'Beaky_FRONT_LG.jpg', 'Beaky_FRONT_TH.jpg'),
(55, 'Beaky_HEEL_LG.jpg', 'Beaky_HEEL_TH.jpg'),
(56, 'beakyg_MAIN_LG.jpg', 'beakyg_MAIN_TH.jpg'),
(57, 'beakyg_IN_LG.jpg', 'beakyg_IN_TH.jpg'),
(58, 'beakyg_OUT_LG.jpg', 'beakyg_OUT_TH.jpg'),
(59, 'beakyg_FRONT_LG.jpg', 'beakyg_FRONT_TH.jpg'),
(60, 'beakyg_HEEL_LG.jpg', 'beakyg_HEEL_TH.jpg'),
(61, 'beakys_MAIN_LG.jpg', 'beakys_MAIN_TH.jpg'),
(62, 'beakys_IN_LG.jpg', 'beakys_IN_TH.jpg'),
(63, 'beakys_OUT_LG.jpg', 'beakys_OUT_TH.jpg'),
(64, 'beakys_FRONT_LG.jpg', 'beakys_FRONT_TH.jpg'),
(65, 'beakys_HEEL_LG.jpg', 'beakys_HEEL_TH.jpg'),
(66, 'jungle_MAIN_LG.jpg', 'jungle_MAIN_TH.jpg'),
(67, 'jungle_IN_LG.jpg', 'jungle_IN_TH.jpg'),
(68, 'jungle_OUT_LG.jpg', 'jungle_OUT_TH.jpg'),
(69, 'jungle_FRONT_LG.jpg', 'jungle_FRONT_TH.jpg'),
(70, 'jungle_HEEL_LG.jpg', 'jungle_HEEL_TH.jpg'),
(71, 'alani_MAIN_LG.jpg', 'alani_MAIN_TH.jpg'),
(72, 'alani_IN_LG.jpg', 'alani_IN_TH.jpg'),
(73, 'alani_OUT_LG.jpg', 'alani_OUT_TH.jpg'),
(74, 'alani_FRONT_LG.jpg', 'alani_FRONT_TH.jpg'),
(75, 'alani_HEEL_LG.jpg', 'alani_HEEL_TH.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `imagezoom_lookup`
--

CREATE TABLE IF NOT EXISTS `imagezoom_lookup` (
  `product_id` int(11) NOT NULL,
  `imagezoom_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`imagezoom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `imagezoom_lookup`
--

INSERT INTO `imagezoom_lookup` (`product_id`, `imagezoom_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 29),
(6, 30),
(7, 31),
(7, 32),
(7, 33),
(7, 34),
(7, 35),
(8, 36),
(8, 37),
(8, 38),
(8, 39),
(8, 40),
(9, 41),
(9, 42),
(9, 43),
(9, 44),
(9, 45),
(10, 46),
(10, 47),
(10, 48),
(10, 49),
(10, 50),
(11, 51),
(11, 52),
(11, 53),
(11, 54),
(11, 55),
(12, 56),
(12, 57),
(12, 58),
(12, 59),
(12, 60),
(13, 61),
(13, 62),
(13, 63),
(13, 64),
(13, 65),
(14, 66),
(14, 67),
(14, 68),
(14, 69),
(14, 70),
(15, 71),
(15, 72),
(15, 73),
(15, 74),
(15, 75);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `order_status` char(10) NOT NULL,
  `ship_customer_fname` char(20) NOT NULL,
  `ship_customer_lname` char(20) NOT NULL,
  `ship_street` char(40) NOT NULL,
  `ship_city` char(40) NOT NULL,
  `ship_state` char(20) NOT NULL,
  `ship_zip` char(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `amount`, `order_status`, `ship_customer_fname`, `ship_customer_lname`, `ship_street`, `ship_city`, `ship_state`, `ship_zip`, `date`) VALUES
(1, 4, 70, 'N', 'monique', 'pheny', '425 beverlly', 'houston', 'texas', '85623', '2014-05-07'),
(2, 9, 80, 'N', 'rawen', 'cuute', '0239 bidden', 'rohyn', 'colorado', '52364', '2014-05-07'),
(3, 20, 50, 'N', 'beioh', 'riyewen', '893 locogn', 'indiana', 'indiana', '56542', '2014-05-07'),
(4, 22, 244, 'N', '', '', '', '', '', '', '2014-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `item_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`,`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `type_id`, `item_price`, `quantity`) VALUES
(1, 3, 6, 80, 1),
(2, 4, 5, 50, 1),
(4, 2, 5, 79, 1),
(4, 3, 8, 85, 1),
(4, 15, 6, 40, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `thumb_filename` varchar(50) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_description`, `thumb_filename`) VALUES
(1, 'Amachi ', 75, 'Be a trendsetter in the Amachi. This cute slide is on point with it''s vintage appearance and tan leather upper. A 5 inch wedge and 1 1/2 inch platform complete this retro look.\r\nShoe Details:\r\n\r\n    Leather Upper\r\n    Man Made Sole\r\n    Made In China\r\n   ', 'Amachi_MAIN_TH.jpg'),
(2, 'Yuki Monkey', 79, 'Find your happiness in this furry style by Yuki Monkey. The Close Call showcases a taupe fabric upper with faux fur and buckles. A stacked 4 1/2 inch heel and 1 inch platform perfects this fall ready boot.\r\nShoe Details:\r\n\r\n    Man Made Upper\r\n    Man Mad', 'Yuky_MAIN_TH.jpg'),
(3, 'Benson', 85, 'The Benson is practically flawless! This pump created by Enzo Angiolini is made with a rich red leather and stunning collar back. This curvy silhouette is finished with a 4 inch heel and pointed toe.\r\nShoe Details:\r\n    Leather Upper\r\n    Man Made Sole\r\n ', 'benson_MAIN_TH.jpg 	'),
(4, 'Mindy from De Qui', 80, 'A practical everyday flat doesn''t have to be boring! You''ll get a lot of attention with the eye catching Mindy from De Qui by Sam Edelman. This look features a silver iridescent upper with patent details and spiky bow adoring the vamp.\r\nShoe Details:\r\n   ', 'mindy_MAIN_TH.jpg'),
(5, 'Leno', 65, 'Get excited for the Celebration! This Leno oxford features a coral pink lace upper with faux leather detailing, capped toe and lace up vamp.', 'leno_MAIN_TH.jpg'),
(6, 'Vies Bon', 99, 'Feel the happiness radiate from the Hold Please by Unlisted. A cognac synthetic leather creates the upper and features buckle details. A beige fabric with embroidered design covers the 5 1/2 inch wedge and 1 1/2 inch platform for a flawless look.', 'vies_MAIN_TH.jpg'),
(7, 'Coral Reef', 99, 'Keep cool in the Coral Reef. This coral multi peep toe bootie features a slight sneaker inspiration with tie up vamp. Snake stamped accents, 6 inch heel and 1 1/2 inch platform create a flawless touch.', 'coral_MAIN_TH.jpg'),
(8, 'Luis', 99, 'You''ll inspire even the greatest fashionista in Luis by Ivanka Trump. This light natural style is made from a supple black leather and sports a cute peep toe. A 3 1/2 inch stiletto heel completes this style so you can be ready to take on whatever life thr', 'Luis_MAIN_TH.jpg'),
(9, 'Amenica', 77, 'Ooh la la! Love is in the air with the Amenica by Boohh. This Parisian inspired pump features a slingback strap with soft suede knot. A striped satin upper covers the silhouette, pointed toe and 4 1/2 inch heel. Last but not least is a stunning Eiffel Tow', 'Amenica_MAIN_TH.jpg'),
(10, 'Hole Soul', 82, 'Get that fab factor you''ve been looking for with this new style from  David. Vapor brings you a beige leather upper with slouch detail. This knee boot is finished off with an adjustable tie at the side, a stacked 4 1/4 inch heel and 1/2 inch hidden', 'holesoul_MAIN_TH.jpg'),
(11, 'Beaky Red', 85, 'Here comes trouble, the Luem is ready to make your girls night! This  Trenvor sandal is created with a snake print faux leather and multiple winding straps. A 5 inch heel and 1/2 inch subtle platform create a leg lengthening lift.', 'Beaky_MAIN_TH.jpg'),
(12, 'Beaky Silver', 82, 'Here comes trouble, the Luem is ready to make your girls night! This  Trenvor sandal is created with a silver metallic faux leather and multiple winding straps. A 5 inch heel and 1/2 inch subtle platform create a leg lengthening lift.', 'beakys_MAIN_TH.jpg'),
(13, 'Beaky Gold', 60, 'Here comes trouble, the Luem is ready to make your girls night! This  Trenvor sandal is created with a gold metallic faux leather and multiple winding straps. A 5 inch heel and 1/2 inch subtle platform create a leg lengthening lift.', 'beakyg_MAIN_TH.jpg'),
(14, 'Jungle Dee', 65, ' You''ll love the playful look of the Jungle Dee. This My Laundry sandal features a rich black leather vamp with double adjustable ankle strap in a glossy beige patent. Decorative studs, a wooden 6 inch heel and 1 1/2 inch platform complete this beauty.', 'jungle_MAIN_TH.jpg'),
(15, 'Alani', 40, 'The Alani adds edge to any look. This Steve Madden ankle boot features a brown leather upper with studded back and sides. A buckle detail, 3 1/2 inch heel and rounded toe perfect this wearable style.\r\n\r\n', 'alani_MAIN_TH.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_category_lookup`
--

CREATE TABLE IF NOT EXISTS `product_category_lookup` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category_lookup`
--

INSERT INTO `product_category_lookup` (`product_id`, `category_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 2),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 4),
(7, 1),
(7, 3),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(9, 3),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(10, 6),
(11, 1),
(11, 4),
(11, 7),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(13, 1),
(13, 2),
(13, 4),
(13, 7),
(14, 1),
(14, 2),
(14, 3),
(14, 5),
(14, 7),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7);

-- --------------------------------------------------------

--
-- Table structure for table `product_type_lookup`
--

CREATE TABLE IF NOT EXISTS `product_type_lookup` (
  `product_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `imagefile` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `inventory` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_type_lookup`
--

INSERT INTO `product_type_lookup` (`product_id`, `type_id`, `imagefile`, `price`, `inventory`) VALUES
(1, 5, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 6, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 7, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 8, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 9, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 10, 'Amachi_MAIN_TH.jpg', 75, 2),
(1, 11, 'Amachi_MAIN_TH.jpg', 75, 12),
(1, 12, 'Amachi_MAIN_TH.jpg', 75, 4),
(1, 55, 'Amachi_MAIN_TH.jpg', 75, 0),
(1, 65, 'Amachi_MAIN_TH.jpg', 75, 6),
(1, 75, 'Amachi_MAIN_TH.jpg', 75, 8),
(1, 85, 'Amachi_MAIN_TH.jpg', 75, 8),
(1, 95, 'Amachi_MAIN_TH.jpg', 75, 7),
(1, 105, 'Amachi_MAIN_TH.jpg', 75, 6),
(1, 115, 'Amachi_MAIN_TH.jpg', 75, 12),
(2, 5, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 6, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 7, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 8, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 9, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 10, 'Yuky_MAIN_TH.jpg', 79, 2),
(2, 11, 'Yuky_MAIN_TH.jpg', 79, 12),
(2, 12, 'Yuky_MAIN_TH.jpg', 79, 0),
(2, 55, 'Yuky_MAIN_TH.jpg', 79, 0),
(2, 65, 'Yuky_MAIN_TH.jpg', 79, 6),
(2, 75, 'Yuky_MAIN_TH.jpg', 79, 8),
(2, 85, 'Yuky_MAIN_TH.jpg', 79, 8),
(2, 95, 'Yuky_MAIN_TH.jpg', 79, 7),
(2, 105, 'Yuky_MAIN_TH.jpg', 79, 6),
(2, 115, 'Yuky_MAIN_TH.jpg', 79, 0),
(3, 5, 'benson_MAIN_TH.jpg', 85, 2),
(3, 6, 'benson_MAIN_TH.jpg', 85, 2),
(3, 7, 'benson_MAIN_TH.jpg', 85, 2),
(3, 8, 'benson_MAIN_TH.jpg', 85, 2),
(3, 9, 'benson_MAIN_TH.jpg', 85, 0),
(3, 10, 'benson_MAIN_TH.jpg', 85, 2),
(3, 11, 'benson_MAIN_TH.jpg', 85, 12),
(3, 12, 'benson_MAIN_TH.jpg', 85, 4),
(3, 55, 'benson_MAIN_TH.jpg', 85, 5),
(3, 65, 'benson_MAIN_TH.jpg', 85, 6),
(3, 75, 'benson_MAIN_TH.jpg', 85, 8),
(3, 85, 'benson_MAIN_TH.jpg', 85, 8),
(3, 95, 'benson_MAIN_TH.jpg', 85, 7),
(3, 105, 'benson_MAIN_TH.jpg', 85, 0),
(3, 115, 'benson_MAIN_TH.jpg', 85, 12),
(4, 5, 'mindy_MAIN_TH.jpg', 80, 0),
(4, 6, 'mindy_MAIN_TH.jpg', 80, 2),
(4, 7, 'mindy_MAIN_TH.jpg', 80, 2),
(4, 8, 'mindy_MAIN_TH.jpg', 80, 2),
(4, 9, 'mindy_MAIN_TH.jpg', 80, 4),
(4, 10, 'mindy_MAIN_TH.jpg', 80, 2),
(4, 11, 'mindy_MAIN_TH.jpg', 80, 12),
(4, 12, 'mindy_MAIN_TH.jpg', 80, 4),
(4, 55, 'mindy_MAIN_TH.jpg', 80, 5),
(4, 65, 'mindy_MAIN_TH.jpg', 80, 6),
(4, 75, 'mindy_MAIN_TH.jpg', 80, 8),
(4, 85, 'mindy_MAIN_TH.jpg', 80, 8),
(4, 95, 'mindy_MAIN_TH.jpg', 80, 7),
(4, 105, 'mindy_MAIN_TH.jpg', 80, 3),
(4, 115, 'mindy_MAIN_TH.jpg', 80, 11),
(5, 5, 'leno_MAIN_TH.jpg', 65, 1),
(5, 6, 'leno_MAIN_TH.jpg', 65, 2),
(5, 7, 'leno_MAIN_TH.jpg', 65, 2),
(5, 8, 'leno_MAIN_TH.jpg', 65, 2),
(5, 9, 'leno_MAIN_TH.jpg', 65, 0),
(5, 10, 'leno_MAIN_TH.jpg', 65, 2),
(5, 11, 'leno_MAIN_TH.jpg', 65, 0),
(5, 12, 'leno_MAIN_TH.jpg', 65, 4),
(5, 55, 'leno_MAIN_TH.jpg', 65, 5),
(5, 65, 'leno_MAIN_TH.jpg', 65, 6),
(5, 75, 'leno_MAIN_TH.jpg', 65, 8),
(5, 85, 'leno_MAIN_TH.jpg', 65, 8),
(5, 95, 'leno_MAIN_TH.jpg', 65, 7),
(5, 105, 'leno_MAIN_TH.jpg', 65, 3),
(5, 115, 'leno_MAIN_TH.jpg', 65, 11),
(6, 5, 'vies_MAIN_TH.jpg', 99, 2),
(6, 6, 'vies_MAIN_TH.jpg', 99, 2),
(6, 7, 'vies_MAIN_TH.jpg', 99, 2),
(6, 8, 'vies_MAIN_TH.jpg', 99, 2),
(6, 9, 'vies_MAIN_TH.jpg', 99, 2),
(6, 10, 'vies_MAIN_TH.jpg', 99, 0),
(6, 11, 'vies_MAIN_TH.jpg', 99, 12),
(6, 12, 'vies_MAIN_TH.jpg', 99, 4),
(6, 55, 'vies_MAIN_TH.jpg', 99, 3),
(6, 65, 'vies_MAIN_TH.jpg', 99, 6),
(6, 75, 'vies_MAIN_TH.jpg', 99, 8),
(6, 85, 'vies_MAIN_TH.jpg', 99, 8),
(6, 95, 'vies_MAIN_TH.jpg', 99, 7),
(6, 105, 'vies_MAIN_TH.jpg', 99, 0),
(6, 115, 'vies_MAIN_TH.jpg', 99, 12),
(7, 5, 'coral_MAIN_TH.jpg', 99, 2),
(7, 6, 'coral_MAIN_TH.jpg', 99, 2),
(7, 7, 'coral_MAIN_TH.jpg', 99, 2),
(7, 8, 'coral_MAIN_TH.jpg', 99, 2),
(7, 9, 'coral_MAIN_TH.jpg', 99, 2),
(7, 10, 'coral_MAIN_TH.jpg', 99, 6),
(7, 11, 'coral_MAIN_TH.jpg', 99, 12),
(7, 12, 'coral_MAIN_TH.jpg', 99, 4),
(7, 55, 'coral_MAIN_TH.jpg', 99, 0),
(7, 65, 'coral_MAIN_TH.jpg', 99, 0),
(7, 75, 'coral_MAIN_TH.jpg', 99, 8),
(7, 85, 'coral_MAIN_TH.jpg', 99, 8),
(7, 95, 'coral_MAIN_TH.jpg', 99, 7),
(7, 105, 'coral_MAIN_TH.jpg', 99, 5),
(7, 115, 'coral_MAIN_TH.jpg', 99, 8),
(8, 5, 'Luis_MAIN_TH.jpg', 99, 2),
(8, 6, 'Luis_MAIN_TH.jpg', 99, 2),
(8, 7, 'Luis_MAIN_TH.jpg', 99, 2),
(8, 8, 'Luis_MAIN_TH.jpg', 99, 2),
(8, 9, 'Luis_MAIN_TH.jpg', 99, 2),
(8, 10, 'Luis_MAIN_TH.jpg', 99, 0),
(8, 11, 'Luis_MAIN_TH.jpg', 99, 0),
(8, 12, 'Luis_MAIN_TH.jpg', 99, 4),
(8, 55, 'Luis_MAIN_TH.jpg', 99, 8),
(8, 65, 'Luis_MAIN_TH.jpg', 99, 1),
(8, 75, 'Luis_MAIN_TH.jpg', 99, 8),
(8, 85, 'Luis_MAIN_TH.jpg', 99, 8),
(8, 95, 'Luis_MAIN_TH.jpg', 99, 7),
(8, 105, 'Luis_MAIN_TH.jpg', 99, 5),
(8, 115, 'Luis_MAIN_TH.jpg', 99, 8),
(9, 5, '', 77, 2),
(9, 6, '', 77, 12),
(9, 7, '', 77, 2),
(9, 8, '', 77, 2),
(9, 9, '', 77, 2),
(9, 10, '', 77, 1),
(9, 11, '', 77, 6),
(9, 12, '', 77, 4),
(9, 55, 'Amenica_MAIN_TH.jpg', 77, 8),
(9, 65, '', 77, 1),
(9, 75, '', 77, 8),
(9, 85, '', 77, 8),
(9, 95, '', 77, 7),
(9, 105, '', 77, 5),
(9, 115, '', 77, 8),
(10, 5, '', 82, 2),
(10, 6, '', 82, 12),
(10, 7, '', 82, 2),
(10, 8, '', 82, 0),
(10, 9, '', 82, 0),
(10, 10, '', 82, 1),
(10, 11, '', 82, 6),
(10, 12, '', 82, 0),
(10, 55, '', 82, 8),
(10, 65, 'holesoul_MAIN_TH.jpg', 82, 1),
(10, 75, '', 82, 8),
(10, 85, '', 82, 8),
(10, 95, '', 82, 7),
(10, 105, '', 82, 5),
(10, 115, '', 82, 0),
(11, 5, '', 85, 2),
(11, 6, '', 85, 12),
(11, 7, '', 85, 2),
(11, 8, '', 85, 0),
(11, 9, '', 85, 4),
(11, 10, '', 85, 1),
(11, 11, '', 85, 6),
(11, 12, '', 85, 6),
(11, 55, '', 85, 8),
(11, 65, '', 85, 1),
(11, 75, 'Beaky_MAIN_TH.jpg', 85, 8),
(11, 85, '', 85, 8),
(11, 95, '', 85, 7),
(11, 105, '', 85, 5),
(11, 115, '', 85, 5),
(12, 5, '', 82, 2),
(12, 6, '', 82, 12),
(12, 7, '', 82, 2),
(12, 8, '', 82, 6),
(12, 9, '', 82, 0),
(12, 10, '', 82, 1),
(12, 11, '', 82, 6),
(12, 12, '', 82, 8),
(12, 55, '', 82, 8),
(12, 65, '', 82, 0),
(12, 75, '', 82, 8),
(12, 85, 'beakys_MAIN_TH.jpg', 82, 0),
(12, 95, '', 82, 7),
(12, 105, '', 82, 9),
(12, 115, '', 82, 6),
(13, 5, '', 60, 2),
(13, 6, '', 60, 12),
(13, 7, '', 60, 2),
(13, 8, '', 60, 6),
(13, 9, '', 60, 6),
(13, 10, '', 60, 1),
(13, 11, '', 60, 0),
(13, 12, '', 60, 4),
(13, 55, '', 60, 8),
(13, 65, '', 60, 0),
(13, 75, '', 60, 8),
(13, 85, '', 60, 0),
(13, 95, 'beakyg_MAIN_TH.jpg', 60, 7),
(13, 105, '', 60, 9),
(13, 115, '', 60, 6),
(14, 5, '', 65, 2),
(14, 6, '', 65, 12),
(14, 7, '', 65, 2),
(14, 8, '', 65, 6),
(14, 9, '', 65, 6),
(14, 10, '', 65, 1),
(14, 11, '', 65, 0),
(14, 12, '', 65, 4),
(14, 55, '', 65, 8),
(14, 65, '', 65, 0),
(14, 75, '', 65, 8),
(14, 85, '', 65, 0),
(14, 95, '', 65, 7),
(14, 105, 'jungle_MAIN_TH.jpg', 65, 9),
(14, 115, '', 65, 6),
(15, 5, 'alani_MAIN_TH.jpg', 40, 0),
(15, 6, 'alani_MAIN_TH.jpg', 40, 12),
(15, 7, 'alani_MAIN_TH.jpg', 40, 0),
(15, 8, 'alani_MAIN_TH.jpg', 40, 6),
(15, 9, 'alani_MAIN_TH.jpg', 40, 6),
(15, 10, 'alani_MAIN_TH.jpg', 40, 1),
(15, 11, 'alani_MAIN_TH.jpg', 40, 0),
(15, 12, 'alani_MAIN_TH.jpg', 40, 4),
(15, 55, 'alani_MAIN_TH.jpg', 40, 0),
(15, 65, 'alani_MAIN_TH.jpg', 40, 0),
(15, 75, 'alani_MAIN_TH.jpg', 40, 8),
(15, 85, 'alani_MAIN_TH.jpg', 40, 0),
(15, 95, 'alani_MAIN_TH.jpg', 40, 7),
(15, 105, 'alani_MAIN_TH.jpg', 40, 9),
(15, 115, 'alani_MAIN_TH.jpg', 40, 6);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  `type_description` varchar(250) NOT NULL,
  `type_icon` varchar(50) DEFAULT NULL,
  `type_icon_un` varchar(50) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`, `type_description`, `type_icon`, `type_icon_un`) VALUES
(5, '5', 'Size 5', '5.gif', '5u.gif'),
(6, '6', 'Size 6', '6.gif', '6u.gif'),
(7, '7', 'Size 7', '7.gif', '7u.gif'),
(8, '8', 'Size 8', '8.gif', '8u.gif'),
(9, '9', 'Size 9', '9.gif', '9u.gif'),
(10, '10', 'Size 10', '10.gif', '10u.gif'),
(11, '11', 'Size 11', '11.gif', '11u.gif'),
(12, '12', 'Size 12', '12.gif', '12u.gif'),
(55, '5.5', 'Size 5.5', '5_5.gif', '5_5u.gif'),
(65, '6.5', 'Size 6.5', '6_5.gif', '6_5u.gif'),
(75, '7.5', 'Size 7.5', '7_5.gif', '7_5u.gif'),
(85, '8.5', 'Size 8.5', '8_5.gif', '8_5u.gif'),
(95, '9.5', 'Size 9.5', '9_5.gif', '9_5u.gif'),
(105, '10.5', 'Size 10.5', '10_5.gif', '10_5u.gif'),
(115, '11.5', 'Size 11.5', '11_5.gif', '11_5u.gif');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
