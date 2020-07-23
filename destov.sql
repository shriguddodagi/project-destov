-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2020 at 08:10 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `destov`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@test.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `image`, `created_at`) VALUES
(3, 'skdfnkdsjnkdfmg', 'lkjdsmfdsklgm', 'storage/159498190401.jpg', '2020-07-20 16:38:11'),
(4, 'lkjgmflkd', 'lmsdgklmv', 'storage/1594981917logo2.JPG', '2020-07-20 16:38:11'),
(5, 'skadfnds', '<p>klsdfmkdslfnm</p>\r\n\r\n<p>sjdfhdsk</p>\r\n\r\n<p>alsdkf</p>\r\n', 'storage/1595091580download.png', '2020-07-20 16:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `calender`
--

CREATE TABLE `calender` (
  `id` int(11) NOT NULL,
  `product_id` int(10) NOT NULL,
  `January` varchar(10) NOT NULL,
  `February` varchar(10) NOT NULL,
  `March` varchar(10) NOT NULL,
  `April` varchar(10) NOT NULL,
  `May` varchar(10) NOT NULL,
  `June` varchar(10) NOT NULL,
  `July` varchar(10) NOT NULL,
  `August` varchar(10) NOT NULL,
  `September` varchar(10) NOT NULL,
  `October` varchar(10) NOT NULL,
  `November` varchar(10) NOT NULL,
  `December` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calender`
--

INSERT INTO `calender` (`id`, `product_id`, `January`, `February`, `March`, `April`, `May`, `June`, `July`, `August`, `September`, `October`, `November`, `December`) VALUES
(1, 35, 'Lean', 'N/A', 'Lean', 'Peak', 'Peak', 'N/A', 'N/A', 'Peak', 'Peak', 'Peak', 'N/A', 'N/A'),
(2, 36, 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak', 'Peak'),
(3, 38, 'Lean', 'N/A', 'N/A', 'Lean', 'Lean', 'Peak', 'Peak', 'Peak', 'Lean', 'N/A', 'N/A', 'Peak');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `terms` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `terms`) VALUES
(1, 'qwertyuiop', '<p>With edited text</p>\r\n\r\n<p>and other also</p>\r\n'),
(4, 'New Category', '<p>Terms and Condition</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(5) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `phone`, `message`, `status`, `created_at`) VALUES
(1, 'skdnf', 'kls@ksdjf.sdflj', '48372238947382', 'skfjmdskf', '0', '2020-07-15 20:50:53'),
(2, 'skdnf', 'kls@ksdjf.sdflj', '48372238947382', 'skfjmdskf', '0', '2020-07-15 20:50:53'),
(3, 'skdnf', 'kls@ksdjf.sdflj', '48372238947382', 'skfjmdskf', '0', '2020-07-15 20:50:53'),
(4, 'sdjfg', 'kn@slsdkjf.asdj', '349857948392', 'dsifjkdm', '0', '2020-07-17 09:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `productId` int(10) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `file`, `productId`, `type`) VALUES
(2, 'storage/1595243353download.png', 12, 'image'),
(8, 'storage/1595300773download.png', 12, 'image'),
(9, 'storage/1595300783download.png', 12, 'image'),
(10, 'storage/1595300792download.png', 12, 'image'),
(11, 'storage/1595326995Lesson 1. Course Introduction.mp4', 12, 'video');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` longtext NOT NULL,
  `product` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `mode` varchar(5) DEFAULT 'open',
  `destination_port` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `position`, `company`, `email`, `phone`, `message`, `product`, `created_at`, `mode`, `destination_port`) VALUES
(124, 'dfnskm', '', '', 'hjfdsk@hfjdkf.urefjdsks', '4538920', 'gfhdsjk', '', '2020-07-10 00:00:00', 'open', ''),
(125, 'hgdfjk', '', '', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '', '2020-07-10 00:00:00', 'open', ''),
(126, 'hgdfjk', '', '', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '', '2020-07-10 00:00:00', 'close', ''),
(127, 'hgdfjk', '', '', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '', '2020-07-10 00:00:00', 'open', ''),
(128, 'from contact page', '', '', 'my@sajdh.codsin', '3642879289786554534567', 'dfjskcmxkjekhds', '', '2020-07-10 00:00:00', 'open', ''),
(129, 'hygh', '', '', 'sdvnk@kdnv.dosm', '238423480918', 'isdhcnsdjc', '', '2020-07-13 00:00:00', 'open', ''),
(130, 'sdknf', '', '', 'sksdnf@sdlkm.sd', '8472349881', 'knfdsfsd', '', '2020-07-13 00:00:00', 'open', ''),
(131, 'sdkkfmc', '', '', 'klsdmf@oskdfm.asdk', '384572842394', '<p>sdkfnsmdkdf</p>\r\n', '', '2020-07-14 00:00:00', 'open', ''),
(132, 'hii', '', '', 'skdn@ksjsndf.saod', '1286371948', 'jsfnsdkf', '', '2020-07-14 00:00:00', 'open', ''),
(133, 'sdkgj', '', '', 'sdklfn@ksfnd.wsdlkj', '2839473294', 'kjdvndkmsdl', '', '2020-07-14 00:00:00', 'open', ''),
(134, 'dskjfn', '', '', 'skldn@ksdnf.woj', '293329849', 'kdjfmsdkfsd', '', '2020-07-14 00:00:00', 'open', ''),
(135, 'asdkj', 'kasnd', 'klsnd', 'kns@ksdnf.sdko', '2834783', 'lsdkfmsld', '', '2020-07-15 20:07:15', 'open', ''),
(136, 'test name', 'skfj', 'iodjfds', 'sdkjf@skdjf.sdflih', '3298574857239', 'sjdkfnsdkjfdsf\r\nfrom index page', 'Title', '2020-07-20 10:25:29', 'open', '');

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id`, `name`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `packing_specifications`
--

CREATE TABLE `packing_specifications` (
  `id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `specs` varchar(100) NOT NULL,
  `net_wt` varchar(100) NOT NULL,
  `gross_wt` varchar(100) NOT NULL,
  `boxes` varchar(100) NOT NULL,
  `container_type` varchar(100) NOT NULL,
  `container_loadability` varchar(100) NOT NULL,
  `other_details` varchar(1000) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packing_specifications`
--

INSERT INTO `packing_specifications` (`id`, `country`, `specs`, `net_wt`, `gross_wt`, `boxes`, `container_type`, `container_loadability`, `other_details`, `product_id`) VALUES
(3, 'hd', 'sjd', 'jdsfn', 'kjdsfn', 'sksdjfnf', 'sksjdvn', 'skdjn', 'skdjfn', 1),
(4, 'ghb', 'fghj', 'rdtfghytre', 'qweyghh', 'qwer', 'qweriu', 'qwertyuuytq', 'qwertyui', 4),
(5, 'djgf', 'odjfv', 'kncxv', 'ojdfmvkd', 'kldsnv', 'osdkjv', 'lklssjvn', 'kldjvndc', 5),
(6, 'India', 'kasdk', 'ksdfnjksm', 'ksdnf', 'skdnf', 'ksdnf', 'ksdnf', 'ksfn', 15),
(7, 'djfghdsfj', 'wjdsf', 'ojsdkj', 'sdjfdjs', 'sdkjfds', 'sjsdfsdj', 'jsdfnsdj', 'sjdf', 13);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `subcategory_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `varieties` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `tss` varchar(100) NOT NULL,
  `containercapacity` varchar(100) NOT NULL,
  `incoterms` varchar(100) NOT NULL,
  `paymenterms` text NOT NULL,
  `certifications` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `display_on_home` varchar(3) DEFAULT NULL,
  `position` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `subcategory_id`, `title`, `description`, `varieties`, `color`, `size`, `weight`, `tss`, `containercapacity`, `incoterms`, `paymenterms`, `certifications`, `image`, `display_on_home`, `position`) VALUES
(35, 2, 'skfdj', 'kdjmv', 'dklvm', 'lkdmv', 'kdnvm', 'klsdfm', 'sdkdskfm', 'wosfjsi', 'oisjfm', '<p>sidjf</p>\r\n', '<p>diogj</p>\r\n', 'storage/1595390942fruits-bosbes.jpg', NULL, NULL),
(36, 2, 'title', 'descriptino', 'kdfsngsk', 'klsgmdkm', 'kddfnkdfd', 'ksddsnfds', 'ksdsnf', 'kjsdfnh', 'jsdfnjk', 'lsksjd', 'ijdfn', 'storage/1595388625Rakotzbrücke.jpg', NULL, NULL),
(38, 2, 'skdfnsdk', ';lksdmfdslkfm', 'sdklfmdslkfm', 'kl', 'lkddfmdslkfm', 'skdklfmdsf', 'dkfmdsklf', 'askdfjksmf', 'kokodsnckm', 'oskdfmdskfm', 'ovkmkm', 'storage/1595391023strawberry-5k-4f.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `file` text NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `description`, `file`, `type`) VALUES
(5, 'First Slide', 'This is not a long description', 'storage/1594316518fruits-bosbes.jpg', 'image'),
(6, 'secondslide', 'no a long description ', 'storage/1594316553pineapple-water-splash-5k-3k.jpg', 'image'),
(7, '', '', 'storage/1594316719kiwi-pic.jpg', 'image'),
(8, 'asn', 'aksnfds', 'storage/159472236801.jpg', 'image'),
(9, '', '', 'storage/1594786415Rakotzbrücke.jpg', 'image'),
(11, '', '', 'storage/1594822235img_1.jpg', 'image'),
(12, '', '', 'storage/1595224798Lesson 1. Course Introduction.mp4', 'video');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES
(2, 'frybdp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`) VALUES
(1, 'hello@gmail.com'),
(2, 'info@destov.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calender`
--
ALTER TABLE `calender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
