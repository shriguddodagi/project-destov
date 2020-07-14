-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 12:36 PM
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
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `image`) VALUES
(1, 'New blog', 'This is sort description', 'storage/1594381971carbon (3).png'),
(2, 'Second Blog', 'No description required', 'storage/1594382074carbon.png');

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
(1, 'qwertyuiop', 'zxcvbnmsadfghjkl34567jklm;tg'),
(2, 'xsedignv', 'ddbui');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `mode` varchar(5) DEFAULT 'open',
  `check_mode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `mode`, `check_mode`) VALUES
(124, 'dfnskm', 'hjfdsk@hfjdkf.urefjdsks', '4538920', 'gfhdsjk', '2020-07-10', 'open', ''),
(125, 'hgdfjk', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '2020-07-10', 'open', ''),
(126, 'hgdfjk', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '2020-07-10', 'close', ''),
(127, 'hgdfjk', 'dfuhsj@gdhfsj.ergufdjs', '348920', 'fdhjsk', '2020-07-10', 'open', ''),
(128, 'from contact page', 'my@sajdh.codsin', '3642879289786554534567', 'dfjskcmxkjekhds', '2020-07-10', 'open', ''),
(129, 'hygh', 'sdvnk@kdnv.dosm', '238423480918', 'isdhcnsdjc', '2020-07-13', 'open', 'on'),
(130, 'sdknf', 'sksdnf@sdlkm.sd', '8472349881', 'knfdsfsd', '2020-07-13', 'open', ''),
(131, 'sdkkfmc', 'klsdmf@oskdfm.asdk', '384572842394', '<p>sdkfnsmdkdf</p>\r\n', '2020-07-14', 'open', 'on'),
(132, 'hii', 'skdn@ksjsndf.saod', '1286371948', 'jsfnsdkf', '2020-07-14', 'open', 'on'),
(133, 'sdkgj', 'sdklfn@ksfnd.wsdlkj', '2839473294', 'kjdvndkmsdl', '2020-07-14', 'open', 'on'),
(134, 'dskjfn', 'skldn@ksdnf.woj', '293329849', 'kdjfmsdkfsd', '2020-07-14', 'open', 'on');

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
(6, 'India', 'kasdk', 'ksdfnjksm', 'ksdnf', 'skdnf', 'ksdnf', 'ksdnf', 'ksfn', 15);

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
  `calender` varchar(100) NOT NULL,
  `containercapacity` varchar(100) NOT NULL,
  `incoterms` varchar(100) NOT NULL,
  `paymenterms` text NOT NULL,
  `certifications` text NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `subcategory_id`, `title`, `description`, `varieties`, `color`, `size`, `weight`, `tss`, `calender`, `containercapacity`, `incoterms`, `paymenterms`, `certifications`, `image`) VALUES
(4, 1, 'New title', 'update', 'update', 'update', 'update', 'update', 'update', '1,2,3,4,7,8,9,11', 'update', 'update', 'dfjckupdate', 'fdjkupdate', 'storage/159457515302.jpg'),
(5, 2, 'House', 'description', 'hjbj', 'dskjvn', 'kjcvn', 'ksncvmc', 'ckvn', '2,4,9,11', 'jfhdskjfs', 'ijldsfksd', 'lksjdvkdn', 'lksddjvmdk', 'storage/159461458303.jpg'),
(6, 3, 'sdkfjgf', 'kcvxnm', 'dfkbnfo', 'dgfjv', 'jdjfkvn', 'jdjnv', 'dknv', '1,4,8,11', 'ojdfs', 'dfkfnv', 'dkfvn', 'dkfng', 'storage/159461478202.jpg'),
(7, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461474401.jpg'),
(8, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461474901.jpg'),
(9, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461475101.jpg'),
(10, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461475301.jpg'),
(11, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461475401.jpg'),
(12, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461479701.jpg'),
(13, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461475701.jpg'),
(14, 2, 'isdhfj', 'odpidfjv', 'odfdfjv', 'oidjf', 'oskdk', 'ojv', 'oissdjf', '1,5,9,12', 'odsijfds', 'osidjifm', 'oijdfs', 'osisdifj', 'storage/159461476501.jpg'),
(15, 1, 'Title', 'New Description', 'asjdns', 'black', '12x23', '123', 'sdkdsf', '2,5,9', 'ldkfjgkl', 'lmgdklv', '<ul>\r\n	<li>sldfm,lvsf</li>\r\n	<li>ldkmgfd</li>\r\n</ul>\r\n', '<ul>\r\n	<li>skedgnfksd</li>\r\n	<li>jsdfnd</li>\r\n</ul>\r\n', 'storage/159472230601.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `description`, `image`) VALUES
(5, 'First Slide', 'This is not a long description', 'storage/1594316518fruits-bosbes.jpg'),
(6, 'secondslide', 'no a long description ', 'storage/1594316553pineapple-water-splash-5k-3k.jpg'),
(7, 'skd sdas asdmasd asdmas', 'asdas aodjasdo erfjdsf sdjo', 'storage/1594316719kiwi-pic.jpg'),
(8, 'asn', 'aksnfds', 'storage/159472236801.jpg');

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
(1, 'wsgyvf', 1),
(2, 'frybdp', 1),
(3, 'cfthb', 2);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packing_specifications`
--
ALTER TABLE `packing_specifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `packing_specifications`
--
ALTER TABLE `packing_specifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
