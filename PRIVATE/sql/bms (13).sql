-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 09:30 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activate_beneficiary_details`
--

CREATE TABLE `tbl_activate_beneficiary_details` (
  `activate_beneficiary_details_id` int(11) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_activated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_activate_beneficiary_details`
--

INSERT INTO `tbl_activate_beneficiary_details` (`activate_beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_activated`) VALUES
(1, 'BF2019091600007', 53, '2019-09-17'),
(2, 'BF2019090200002', 53, '2019-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_beneficiary_details`
--

CREATE TABLE `tbl_add_beneficiary_details` (
  `add_beneficiary_details_id` int(11) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barangay`
--

CREATE TABLE `tbl_barangay` (
  `barangay_id` int(11) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barangay`
--

INSERT INTO `tbl_barangay` (`barangay_id`, `barangay_name`, `city`, `contact_no`, `address`) VALUES
(1, 'Gulod', 'Cabuyao', '09265312545', 'Brgy. Gulod Health Center, 4025, Philippines'),
(2, 'Mamatid', 'Cabuyao', '09265487415', 'Brgy. Mamatid Health Center, 4025, Philippines'),
(3, 'Niugan', 'Cabuyao', '09542154545', 'Brgy. Niugan Health Center, 4025, Philippines'),
(4, 'Casile', 'Cabuyao', '09391245789', 'Brgy. Casile Health Center, 4025, Philippines'),
(5, 'San Isidro', 'Cabuyao', '09542154123', 'Brgy. San Isidro Health Center, 4025, Philippines'),
(6, 'Baclaran', 'Cabuyao', '09542151456', 'Brgy. Baclaran Health Center, 4025, Philippines'),
(7, 'Banay-Banay', 'Cabuyao', '09542154789', 'Brgy. Banay-Banay Health Center, 4025, Philippines'),
(8, 'Banlic', 'Cabuyao', '09651254632', 'Brgy. Banlic Health Center, 4025, Philippines'),
(9, 'Butong', 'Cabuyao', '09162542654', 'Brgy. Butong Health Center, 4025, Philippines'),
(10, 'Diezmo', 'Cabuyao', '09192154545', 'Brgy. Diezmo Health Center, 4025, Philippines'),
(11, 'Marinig', 'Cabuyao', '09202154545', 'Brgy. Marinig Health Center, 4025, Philippines'),
(12, 'Pittland', 'Cabuyao', '093054545', 'Brgy. Pittland Health Center, 4025, Philippines'),
(13, 'Sala', 'Cabuyao', '09402154545', 'Brgy. Sala Health Center, 4025, Philippines'),
(14, 'Poblacion Uno', 'Cabuyao', '09502154545', 'Brgy. Poblacion Uno Health Center, 4025, Philippines'),
(15, 'Poblacion Dos', 'Cabuyao', '09602154545', 'Brgy. Poblacion Dos Health Center, 4025, Philippines'),
(16, 'Poblacion Tres', 'Cabuyao', '09702154545', 'Brgy. Poblacion Tres Health Center, 4025, Philippines'),
(17, 'Pulo', 'Cabuyao', '09902154545', 'Brgy. Pulo Health Center, 4025, Philippines'),
(18, 'Bigaa', 'Cabuyao', '09092154545', 'Brgy. Bigaa Health Center, 4025, Philippines'),
(19, 'City Hall', 'Cabuyao', '09165478441', 'F.B. Bailon St. Cabuyao, 4025, Philippines'),
(20, 'none', 'none', 'none', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beneficiary`
--

CREATE TABLE `tbl_beneficiary` (
  `beneficiary_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `birth_date` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `educational_attainment` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `civil_status_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `beneficiary_type_id` int(11) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `barangay_id` varchar(255) NOT NULL,
  `voters_id` varchar(255) NOT NULL,
  `is_dependent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beneficiary`
--

INSERT INTO `tbl_beneficiary` (`beneficiary_id`, `first_name`, `last_name`, `middle_name`, `contact_no`, `birth_date`, `email_address`, `sex`, `address`, `educational_attainment`, `occupation`, `religion`, `civil_status_id`, `status`, `beneficiary_type_id`, `balance`, `barangay_id`, `voters_id`, `is_dependent`) VALUES
('BF2019090200001', 'Thelma', 'Almazan', 'Tacmoy', '09165478445', '1992-08-9', 'thelma@gmail.com', 'Female', 'Pulo, Cabuyao, Laguna', 'Bachelor\'s degree', 'Student', 'catholic', 1, 'Active', 2, '0', '1', '3404300', 0),
('BF2019090200002', 'Christian', 'Rivera', 'Fajardo', '09145625441', '1992-08-07', 'christian@gmail.com', 'Male', 'blk 20 Lot 9, phase 5, Ivory Our Mahogany Village ', 'Primary/Elementary', 'Crew/Factory worker', 'catholic', 1, 'Active', 2, '0', '2', '3404301', 0),
('BF2019090200003', 'John Carlos', 'Lopez', 'Villacorta', '09391177479', '1999-12-03', 'lopezjohncarlo@yahoo.com', 'Male', 'blk 20 lot 5, phase 1, celestine homes', 'Bachelor\'s degree', 'Student', 'catholic', 1, 'Not Active', 5, '490', '1', '3404302', 0),
('BF2019090200004', 'Rich', 'Rebana', 'Diongco', '09391177479', '1998-06-25', 'rich_rebana@gmail.com', 'Male', 'blk 20 lot 5, phase 1, celestine homes', 'Associate\'s degree', 'Student', 'catholic', 1, 'Not Active', 5, '0', '3', '3404303', 0),
('BF2019090200005', 'Vincent', 'Ortega', 'Basil', '09164587445', '1994-09-03', 'vincent@gmail.com', 'Male', '11, Bonifacio, our Mahogany Village Phase 1', 'Associate\'s degree', 'Self-employed', 'catholic', 1, 'Not Active', 5, '0', '4', '3404304', 0),
('BF2019090200006', 'Juanita', 'Caparas', 'Arca', '09154648774', '1985-09-02', 'juanita@gmail.com', 'Male', '12, Aguinaldo, Our Acacia Village', 'Primary/Elementary', 'Crew/Factory worker', 'catholic', 2, 'Not Active', 5, '0', '2', '3404305', 0),
('BF2019091600007', 'janus', 'tan', 'raymond', '09295522367', '1995-03-12', 'janus.tan@gmail.com', 'Male', 'blk 20 lot 2, payaman, st. joseph 7', 'Doctorate degree', 'Government employee', 'catholic', 1, 'Not Active', 5, '0', '2', '3404306', 0),
('BF2019091900008', 'april joy', 'palustre', 'retardo', '09456625917', '1998-01-09', 'apriljoy.palustre@gmail.com', 'Female', 'blk 20 lot 60, payapa, camella homes', 'Associate\'s degree', 'Student', 'catholic', 1, 'Not Active', 5, '0', '8', '3404307', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beneficiary_details`
--

CREATE TABLE `tbl_beneficiary_details` (
  `beneficiary_details_id` int(11) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beneficiary_details`
--

INSERT INTO `tbl_beneficiary_details` (`beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_added`) VALUES
(1, '53', 0, '2019-09-19'),
(2, '53', 0, '2019-09-19'),
(3, '53', 0, '2019-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beneficiary_type`
--

CREATE TABLE `tbl_beneficiary_type` (
  `beneficiary_type_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beneficiary_type`
--

INSERT INTO `tbl_beneficiary_type` (`beneficiary_type_id`, `description`) VALUES
(1, '4P\'s'),
(2, 'PWD'),
(3, 'Senior'),
(4, 'Indigent'),
(5, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `description`) VALUES
(1, 'Tablet'),
(2, 'Capsule'),
(3, 'Syrup'),
(10, 'Example'),
(11, 'dasdas'),
(12, 'aaaa'),
(13, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_civil_status`
--

CREATE TABLE `tbl_civil_status` (
  `civil_status_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_civil_status`
--

INSERT INTO `tbl_civil_status` (`civil_status_id`, `description`) VALUES
(1, 'Single'),
(2, 'Married'),
(3, 'Widowed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_date`
--

CREATE TABLE `tbl_date` (
  `date_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_date`
--

INSERT INTO `tbl_date` (`date_id`, `date`) VALUES
(1, '2018-01-01'),
(2, '2018-01-02'),
(3, '2018-01-03'),
(4, '2018-01-04'),
(5, '2018-01-05'),
(6, '2018-01-06'),
(7, '2018-01-07'),
(8, '2018-01-08'),
(9, '2018-01-09'),
(10, '2018-01-10'),
(11, '2018-01-11'),
(12, '2018-01-12'),
(13, '2018-01-13'),
(14, '2018-01-14'),
(15, '2018-01-15'),
(16, '2018-01-16'),
(17, '2018-01-17'),
(18, '2018-01-18'),
(19, '2018-01-19'),
(20, '2018-01-20'),
(21, '2018-01-21'),
(22, '2018-01-22'),
(23, '2018-01-23'),
(24, '2018-01-24'),
(25, '2018-01-25'),
(26, '2018-01-26'),
(27, '2018-01-27'),
(28, '2018-01-28'),
(29, '2018-01-29'),
(30, '2018-01-30'),
(31, '2018-01-31'),
(32, '2018-02-01'),
(33, '2018-02-02'),
(34, '2018-02-03'),
(35, '2018-02-04'),
(36, '2018-02-05'),
(37, '2018-02-06'),
(38, '2018-02-07'),
(39, '2018-02-08'),
(40, '2018-02-09'),
(41, '2018-02-10'),
(42, '2018-02-11'),
(43, '2018-02-12'),
(44, '2018-02-13'),
(45, '2018-02-14'),
(46, '2018-02-15'),
(47, '2018-02-16'),
(48, '2018-02-17'),
(49, '2018-02-18'),
(50, '2018-02-19'),
(51, '2018-02-20'),
(52, '2018-02-21'),
(53, '2018-02-22'),
(54, '2018-02-23'),
(55, '2018-02-24'),
(56, '2018-02-25'),
(57, '2018-02-26'),
(58, '2018-02-27'),
(59, '2018-02-28'),
(60, '2018-03-01'),
(61, '2018-03-02'),
(62, '2018-03-03'),
(63, '2018-03-04'),
(64, '2018-03-05'),
(65, '2018-03-06'),
(66, '2018-03-07'),
(67, '2018-03-08'),
(68, '2018-03-09'),
(69, '2018-03-10'),
(70, '2018-03-11'),
(71, '2018-03-12'),
(72, '2018-03-13'),
(73, '2018-03-14'),
(74, '2018-03-15'),
(75, '2018-03-16'),
(76, '2018-03-17'),
(77, '2018-03-18'),
(78, '2018-03-19'),
(79, '2018-03-20'),
(80, '2018-03-21'),
(81, '2018-03-22'),
(82, '2018-03-23'),
(83, '2018-03-24'),
(84, '2018-03-25'),
(85, '2018-03-26'),
(86, '2018-03-27'),
(87, '2018-03-28'),
(88, '2018-03-29'),
(89, '2018-03-30'),
(90, '2018-03-31'),
(91, '2018-04-01'),
(92, '2018-04-02'),
(93, '2018-04-03'),
(94, '2018-04-04'),
(95, '2018-04-05'),
(96, '2018-04-06'),
(97, '2018-04-07'),
(98, '2018-04-08'),
(99, '2018-04-09'),
(100, '2018-04-10'),
(101, '2018-04-11'),
(102, '2018-04-12'),
(103, '2018-04-13'),
(104, '2018-04-14'),
(105, '2018-04-15'),
(106, '2018-04-16'),
(107, '2018-04-17'),
(108, '2018-04-18'),
(109, '2018-04-19'),
(110, '2018-04-20'),
(111, '2018-04-21'),
(112, '2018-04-22'),
(113, '2018-04-23'),
(114, '2018-04-24'),
(115, '2018-04-25'),
(116, '2018-04-26'),
(117, '2018-04-27'),
(118, '2018-04-28'),
(119, '2018-04-29'),
(120, '2018-04-30'),
(121, '2018-05-01'),
(122, '2018-05-02'),
(123, '2018-05-03'),
(124, '2018-05-04'),
(125, '2018-05-05'),
(126, '2018-05-06'),
(127, '2018-05-07'),
(128, '2018-05-08'),
(129, '2018-05-09'),
(130, '2018-05-10'),
(131, '2018-05-11'),
(132, '2018-05-12'),
(133, '2018-05-13'),
(134, '2018-05-14'),
(135, '2018-05-15'),
(136, '2018-05-16'),
(137, '2018-05-17'),
(138, '2018-05-18'),
(139, '2018-05-19'),
(140, '2018-05-20'),
(141, '2018-05-21'),
(142, '2018-05-22'),
(143, '2018-05-23'),
(144, '2018-05-24'),
(145, '2018-05-25'),
(146, '2018-05-26'),
(147, '2018-05-27'),
(148, '2018-05-28'),
(149, '2018-05-29'),
(150, '2018-05-30'),
(151, '2018-05-31'),
(152, '2018-06-01'),
(153, '2018-06-02'),
(154, '2018-06-03'),
(155, '2018-06-04'),
(156, '2018-06-05'),
(157, '2018-06-06'),
(158, '2018-06-07'),
(159, '2018-06-08'),
(160, '2018-06-09'),
(161, '2018-06-10'),
(162, '2018-06-11'),
(163, '2018-06-12'),
(164, '2018-06-13'),
(165, '2018-06-14'),
(166, '2018-06-15'),
(167, '2018-06-16'),
(168, '2018-06-17'),
(169, '2018-06-18'),
(170, '2018-06-19'),
(171, '2018-06-20'),
(172, '2018-06-21'),
(173, '2018-06-22'),
(174, '2018-06-23'),
(175, '2018-06-24'),
(176, '2018-06-25'),
(177, '2018-06-26'),
(178, '2018-06-27'),
(179, '2018-06-28'),
(180, '2018-06-29'),
(181, '2018-06-30'),
(182, '2018-07-01'),
(183, '2018-07-02'),
(184, '2018-07-03'),
(185, '2018-07-04'),
(186, '2018-07-05'),
(187, '2018-07-06'),
(188, '2018-07-07'),
(189, '2018-07-08'),
(190, '2018-07-09'),
(191, '2018-07-10'),
(192, '2018-07-11'),
(193, '2018-07-12'),
(194, '2018-07-13'),
(195, '2018-07-14'),
(196, '2018-07-15'),
(197, '2018-07-16'),
(198, '2018-07-17'),
(199, '2018-07-18'),
(200, '2018-07-19'),
(201, '2018-07-20'),
(202, '2018-07-21'),
(203, '2018-07-22'),
(204, '2018-07-23'),
(205, '2018-07-24'),
(206, '2018-07-25'),
(207, '2018-07-26'),
(208, '2018-07-27'),
(209, '2018-07-28'),
(210, '2018-07-29'),
(211, '2018-07-30'),
(212, '2018-07-31'),
(213, '2018-08-01'),
(214, '2018-08-02'),
(215, '2018-08-03'),
(216, '2018-08-04'),
(217, '2018-08-05'),
(218, '2018-08-06'),
(219, '2018-08-07'),
(220, '2018-08-08'),
(221, '2018-08-09'),
(222, '2018-08-10'),
(223, '2018-08-11'),
(224, '2018-08-12'),
(225, '2018-08-13'),
(226, '2018-08-14'),
(227, '2018-08-15'),
(228, '2018-08-16'),
(229, '2018-08-17'),
(230, '2018-08-18'),
(231, '2018-08-19'),
(232, '2018-08-20'),
(233, '2018-08-21'),
(234, '2018-08-22'),
(235, '2018-08-23'),
(236, '2018-08-24'),
(237, '2018-08-25'),
(238, '2018-08-26'),
(239, '2018-08-27'),
(240, '2018-08-28'),
(241, '2018-08-29'),
(242, '2018-08-30'),
(243, '2018-08-31'),
(244, '2018-09-01'),
(245, '2018-09-02'),
(246, '2018-09-03'),
(247, '2018-09-04'),
(248, '2018-09-05'),
(249, '2018-09-06'),
(250, '2018-09-07'),
(251, '2018-09-08'),
(252, '2018-09-09'),
(253, '2018-09-10'),
(254, '2018-09-11'),
(255, '2018-09-12'),
(256, '2018-09-13'),
(257, '2018-09-14'),
(258, '2018-09-15'),
(259, '2018-09-16'),
(260, '2018-09-17'),
(261, '2018-09-18'),
(262, '2018-09-19'),
(263, '2018-09-20'),
(264, '2018-09-21'),
(265, '2018-09-22'),
(266, '2018-09-23'),
(267, '2018-09-24'),
(268, '2018-09-25'),
(269, '2018-09-26'),
(270, '2018-09-27'),
(271, '2018-09-28'),
(272, '2018-09-29'),
(273, '2018-09-30'),
(274, '2018-10-01'),
(275, '2018-10-02'),
(276, '2018-10-03'),
(277, '2018-10-04'),
(278, '2018-10-05'),
(279, '2018-10-06'),
(280, '2018-10-07'),
(281, '2018-10-08'),
(282, '2018-10-09'),
(283, '2018-10-10'),
(284, '2018-10-11'),
(285, '2018-10-12'),
(286, '2018-10-13'),
(287, '2018-10-14'),
(288, '2018-10-15'),
(289, '2018-10-16'),
(290, '2018-10-17'),
(291, '2018-10-18'),
(292, '2018-10-19'),
(293, '2018-10-20'),
(294, '2018-10-21'),
(295, '2018-10-22'),
(296, '2018-10-23'),
(297, '2018-10-24'),
(298, '2018-10-25'),
(299, '2018-10-26'),
(300, '2018-10-27'),
(301, '2018-10-28'),
(302, '2018-10-29'),
(303, '2018-10-30'),
(304, '2018-10-31'),
(305, '2018-11-01'),
(306, '2018-11-02'),
(307, '2018-11-03'),
(308, '2018-11-04'),
(309, '2018-11-05'),
(310, '2018-11-06'),
(311, '2018-11-07'),
(312, '2018-11-08'),
(313, '2018-11-09'),
(314, '2018-11-10'),
(315, '2018-11-11'),
(316, '2018-11-12'),
(317, '2018-11-13'),
(318, '2018-11-14'),
(319, '2018-11-15'),
(320, '2018-11-16'),
(321, '2018-11-17'),
(322, '2018-11-18'),
(323, '2018-11-19'),
(324, '2018-11-20'),
(325, '2018-11-21'),
(326, '2018-11-22'),
(327, '2018-11-23'),
(328, '2018-11-24'),
(329, '2018-11-25'),
(330, '2018-11-26'),
(331, '2018-11-27'),
(332, '2018-11-28'),
(333, '2018-11-29'),
(334, '2018-11-30'),
(335, '2018-12-01'),
(336, '2018-12-02'),
(337, '2018-12-03'),
(338, '2018-12-04'),
(339, '2018-12-05'),
(340, '2018-12-06'),
(341, '2018-12-07'),
(342, '2018-12-08'),
(343, '2018-12-09'),
(344, '2018-12-10'),
(345, '2018-12-11'),
(346, '2018-12-12'),
(347, '2018-12-13'),
(348, '2018-12-14'),
(349, '2018-12-15'),
(350, '2018-12-16'),
(351, '2018-12-17'),
(352, '2018-12-18'),
(353, '2018-12-19'),
(354, '2018-12-20'),
(355, '2018-12-21'),
(356, '2018-12-22'),
(357, '2018-12-23'),
(358, '2018-12-24'),
(359, '2018-12-25'),
(360, '2018-12-26'),
(361, '2018-12-27'),
(362, '2018-12-28'),
(363, '2018-12-29'),
(364, '2018-12-30'),
(365, '2018-12-31'),
(512, '2019-01-01'),
(513, '2019-01-02'),
(514, '2019-01-03'),
(515, '2019-01-04'),
(516, '2019-01-05'),
(517, '2019-01-06'),
(518, '2019-01-07'),
(519, '2019-01-08'),
(520, '2019-01-09'),
(521, '2019-01-10'),
(522, '2019-01-11'),
(523, '2019-01-12'),
(524, '2019-01-13'),
(525, '2019-01-14'),
(526, '2019-01-15'),
(527, '2019-01-16'),
(528, '2019-01-17'),
(529, '2019-01-18'),
(530, '2019-01-19'),
(531, '2019-01-20'),
(532, '2019-01-21'),
(533, '2019-01-22'),
(534, '2019-01-23'),
(535, '2019-01-24'),
(536, '2019-01-25'),
(537, '2019-01-26'),
(538, '2019-01-27'),
(539, '2019-01-28'),
(540, '2019-01-29'),
(541, '2019-01-30'),
(542, '2019-01-31'),
(543, '2019-02-01'),
(544, '2019-02-02'),
(545, '2019-02-03'),
(546, '2019-02-04'),
(547, '2019-02-05'),
(548, '2019-02-06'),
(549, '2019-02-07'),
(550, '2019-02-08'),
(551, '2019-02-09'),
(552, '2019-02-10'),
(553, '2019-02-11'),
(554, '2019-02-12'),
(555, '2019-02-13'),
(556, '2019-02-14'),
(557, '2019-02-15'),
(558, '2019-02-16'),
(559, '2019-02-17'),
(560, '2019-02-18'),
(561, '2019-02-19'),
(562, '2019-02-20'),
(563, '2019-02-21'),
(564, '2019-02-22'),
(565, '2019-02-23'),
(566, '2019-02-24'),
(567, '2019-02-25'),
(568, '2019-02-26'),
(569, '2019-02-27'),
(570, '2019-02-28'),
(571, '2019-03-01'),
(572, '2019-03-02'),
(573, '2019-03-03'),
(574, '2019-03-04'),
(575, '2019-03-05'),
(576, '2019-03-06'),
(577, '2019-03-07'),
(578, '2019-03-08'),
(579, '2019-03-09'),
(580, '2019-03-10'),
(581, '2019-03-11'),
(582, '2019-03-12'),
(583, '2019-03-13'),
(584, '2019-03-14'),
(585, '2019-03-15'),
(586, '2019-03-16'),
(587, '2019-03-17'),
(588, '2019-03-18'),
(589, '2019-03-19'),
(590, '2019-03-20'),
(591, '2019-03-21'),
(592, '2019-03-22'),
(593, '2019-03-23'),
(594, '2019-03-24'),
(595, '2019-03-25'),
(596, '2019-03-26'),
(597, '2019-03-27'),
(598, '2019-03-28'),
(599, '2019-03-29'),
(600, '2019-03-30'),
(601, '2019-03-31'),
(602, '2019-04-01'),
(603, '2019-04-02'),
(604, '2019-04-03'),
(605, '2019-04-04'),
(606, '2019-04-05'),
(607, '2019-04-06'),
(608, '2019-04-07'),
(609, '2019-04-08'),
(610, '2019-04-09'),
(611, '2019-04-10'),
(612, '2019-04-11'),
(613, '2019-04-12'),
(614, '2019-04-13'),
(615, '2019-04-14'),
(616, '2019-04-15'),
(617, '2019-04-16'),
(618, '2019-04-17'),
(619, '2019-04-18'),
(620, '2019-04-19'),
(621, '2019-04-20'),
(622, '2019-04-21'),
(623, '2019-04-22'),
(624, '2019-04-23'),
(625, '2019-04-24'),
(626, '2019-04-25'),
(627, '2019-04-26'),
(628, '2019-04-27'),
(629, '2019-04-28'),
(630, '2019-04-29'),
(631, '2019-04-30'),
(632, '2019-05-01'),
(633, '2019-05-02'),
(634, '2019-05-03'),
(635, '2019-05-04'),
(636, '2019-05-05'),
(637, '2019-05-06'),
(638, '2019-05-07'),
(639, '2019-05-08'),
(640, '2019-05-09'),
(641, '2019-05-10'),
(642, '2019-05-11'),
(643, '2019-05-12'),
(644, '2019-05-13'),
(645, '2019-05-14'),
(646, '2019-05-15'),
(647, '2019-05-16'),
(648, '2019-05-17'),
(649, '2019-05-18'),
(650, '2019-05-19'),
(651, '2019-05-20'),
(652, '2019-05-21'),
(653, '2019-05-22'),
(654, '2019-05-23'),
(655, '2019-05-24'),
(656, '2019-05-25'),
(657, '2019-05-26'),
(658, '2019-05-27'),
(659, '2019-05-28'),
(660, '2019-05-29'),
(661, '2019-05-30'),
(662, '2019-05-31'),
(663, '2019-06-01'),
(664, '2019-06-02'),
(665, '2019-06-03'),
(666, '2019-06-04'),
(667, '2019-06-05'),
(668, '2019-06-06'),
(669, '2019-06-07'),
(670, '2019-06-08'),
(671, '2019-06-09'),
(672, '2019-06-10'),
(673, '2019-06-11'),
(674, '2019-06-12'),
(675, '2019-06-13'),
(676, '2019-06-14'),
(677, '2019-06-15'),
(678, '2019-06-16'),
(679, '2019-06-17'),
(680, '2019-06-18'),
(681, '2019-06-19'),
(682, '2019-06-20'),
(683, '2019-06-21'),
(684, '2019-06-22'),
(685, '2019-06-23'),
(686, '2019-06-24'),
(687, '2019-06-25'),
(688, '2019-06-26'),
(689, '2019-06-27'),
(690, '2019-06-28'),
(691, '2019-06-29'),
(692, '2019-06-30'),
(693, '2019-07-01'),
(694, '2019-07-02'),
(695, '2019-07-03'),
(696, '2019-07-04'),
(697, '2019-07-05'),
(698, '2019-07-06'),
(699, '2019-07-07'),
(700, '2019-07-08'),
(701, '2019-07-09'),
(702, '2019-07-10'),
(703, '2019-07-11'),
(704, '2019-07-12'),
(705, '2019-07-13'),
(706, '2019-07-14'),
(707, '2019-07-15'),
(708, '2019-07-16'),
(709, '2019-07-17'),
(710, '2019-07-18'),
(711, '2019-07-19'),
(712, '2019-07-20'),
(713, '2019-07-21'),
(714, '2019-07-22'),
(715, '2019-07-23'),
(716, '2019-07-24'),
(717, '2019-07-25'),
(718, '2019-07-26'),
(719, '2019-07-27'),
(720, '2019-07-28'),
(721, '2019-07-29'),
(722, '2019-07-30'),
(723, '2019-07-31'),
(724, '2019-08-01'),
(725, '2019-08-02'),
(726, '2019-08-03'),
(727, '2019-08-04'),
(728, '2019-08-05'),
(729, '2019-08-06'),
(730, '2019-08-07'),
(731, '2019-08-08'),
(732, '2019-08-09'),
(733, '2019-08-10'),
(734, '2019-08-11'),
(735, '2019-08-12'),
(736, '2019-08-13'),
(737, '2019-08-14'),
(738, '2019-08-15'),
(739, '2019-08-16'),
(740, '2019-08-17'),
(741, '2019-08-18'),
(742, '2019-08-19'),
(743, '2019-08-20'),
(744, '2019-08-21'),
(745, '2019-08-22'),
(746, '2019-08-23'),
(747, '2019-08-24'),
(748, '2019-08-25'),
(749, '2019-08-26'),
(750, '2019-08-27'),
(751, '2019-08-28'),
(752, '2019-08-29'),
(753, '2019-08-30'),
(754, '2019-08-31'),
(755, '2019-09-01'),
(756, '2019-09-02'),
(757, '2019-09-03'),
(758, '2019-09-04'),
(759, '2019-09-05'),
(760, '2019-09-06'),
(761, '2019-09-07'),
(762, '2019-09-08'),
(763, '2019-09-09'),
(764, '2019-09-10'),
(765, '2019-09-11'),
(766, '2019-09-12'),
(767, '2019-09-13'),
(768, '2019-09-14'),
(769, '2019-09-15'),
(770, '2019-09-16'),
(771, '2019-09-17'),
(772, '2019-09-18'),
(773, '2019-09-19'),
(774, '2019-09-20'),
(775, '2019-09-21'),
(776, '2019-09-22'),
(777, '2019-09-23'),
(778, '2019-09-24'),
(779, '2019-09-25'),
(780, '2019-09-26'),
(781, '2019-09-27'),
(782, '2019-09-28'),
(783, '2019-09-29'),
(784, '2019-09-30'),
(785, '2019-10-01'),
(786, '2019-10-02'),
(787, '2019-10-03'),
(788, '2019-10-04'),
(789, '2019-10-05'),
(790, '2019-10-06'),
(791, '2019-10-07'),
(792, '2019-10-08'),
(793, '2019-10-09'),
(794, '2019-10-10'),
(795, '2019-10-11'),
(796, '2019-10-12'),
(797, '2019-10-13'),
(798, '2019-10-14'),
(799, '2019-10-15'),
(800, '2019-10-16'),
(801, '2019-10-17'),
(802, '2019-10-18'),
(803, '2019-10-19'),
(804, '2019-10-20'),
(805, '2019-10-21'),
(806, '2019-10-22'),
(807, '2019-10-23'),
(808, '2019-10-24'),
(809, '2019-10-25'),
(810, '2019-10-26'),
(811, '2019-10-27'),
(812, '2019-10-28'),
(813, '2019-10-29'),
(814, '2019-10-30'),
(815, '2019-10-31'),
(816, '2019-11-01'),
(817, '2019-11-02'),
(818, '2019-11-03'),
(819, '2019-11-04'),
(820, '2019-11-05'),
(821, '2019-11-06'),
(822, '2019-11-07'),
(823, '2019-11-08'),
(824, '2019-11-09'),
(825, '2019-11-10'),
(826, '2019-11-11'),
(827, '2019-11-12'),
(828, '2019-11-13'),
(829, '2019-11-14'),
(830, '2019-11-15'),
(831, '2019-11-16'),
(832, '2019-11-17'),
(833, '2019-11-18'),
(834, '2019-11-19'),
(835, '2019-11-20'),
(836, '2019-11-21'),
(837, '2019-11-22'),
(838, '2019-11-23'),
(839, '2019-11-24'),
(840, '2019-11-25'),
(841, '2019-11-26'),
(842, '2019-11-27'),
(843, '2019-11-28'),
(844, '2019-11-29'),
(845, '2019-11-30'),
(846, '2019-12-01'),
(847, '2019-12-02'),
(848, '2019-12-03'),
(849, '2019-12-04'),
(850, '2019-12-05'),
(851, '2019-12-06'),
(852, '2019-12-07'),
(853, '2019-12-08'),
(854, '2019-12-09'),
(855, '2019-12-10'),
(856, '2019-12-11'),
(857, '2019-12-12'),
(858, '2019-12-13'),
(859, '2019-12-14'),
(860, '2019-12-15'),
(861, '2019-12-16'),
(862, '2019-12-17'),
(863, '2019-12-18'),
(864, '2019-12-19'),
(865, '2019-12-20'),
(866, '2019-12-21'),
(867, '2019-12-22'),
(868, '2019-12-23'),
(869, '2019-12-24'),
(870, '2019-12-25'),
(871, '2019-12-26'),
(872, '2019-12-27'),
(873, '2019-12-28'),
(874, '2019-12-29'),
(875, '2019-12-30'),
(876, '2019-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dependent`
--

CREATE TABLE `tbl_dependent` (
  `dependent_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `civil_status_id` int(11) NOT NULL,
  `educational_attainment` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `voters_id` varchar(255) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_dependent`
--

INSERT INTO `tbl_dependent` (`dependent_id`, `fullname`, `sex`, `civil_status_id`, `educational_attainment`, `occupation`, `status`, `voters_id`, `beneficiary_id`) VALUES
(8, 'Christian Fajardo Rivera', 'Male', 1, 'Primary/Elementary', 'Crew/Factory worker', 'Not Active', '3404301', ''),
(9, 'John Carlos Villacorta Lopez', 'Male', 1, 'Bachelor\'s degree', 'Student', 'Not Active', '3404302', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dependent_to_beneficiary_details`
--

CREATE TABLE `tbl_dependent_to_beneficiary_details` (
  `dependent_to_beneficiary_details_id` int(11) NOT NULL,
  `beneficiary_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_transfer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_details`
--

CREATE TABLE `tbl_login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login_details`
--

INSERT INTO `tbl_login_details` (`login_details_id`, `user_id`, `date_login`) VALUES
(1, 52, '2019-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicine`
--

CREATE TABLE `tbl_medicine` (
  `medicine_id` int(11) NOT NULL,
  `supplier_medicine_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_details`
--

CREATE TABLE `tbl_purchase_details` (
  `purchase_details_id` int(11) NOT NULL,
  `purchase_order_id` varchar(255) NOT NULL,
  `supplier_medicine_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `received_quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_details`
--

INSERT INTO `tbl_purchase_details` (`purchase_details_id`, `purchase_order_id`, `supplier_medicine_id`, `quantity`, `received_quantity`) VALUES
(73, 'PO201909120001', 1, '1000', '0'),
(74, 'PO201909120001', 2, '1000', '1000'),
(75, 'PO201909120001', 3, '1000', '1000'),
(76, 'PO201909120001', 7, '1000', '1000'),
(77, 'PO201909120001', 9, '1000', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_order`
--

CREATE TABLE `tbl_purchase_order` (
  `purchase_order_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_ordered` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_order`
--

INSERT INTO `tbl_purchase_order` (`purchase_order_id`, `user_id`, `date_ordered`) VALUES
('PO201909120001', 4, '2019-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_order_details`
--

CREATE TABLE `tbl_purchase_order_details` (
  `purchase_order_details_id` int(11) NOT NULL,
  `purchase_order_id` varchar(255) NOT NULL,
  `supplier_medicine_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_order_details`
--

INSERT INTO `tbl_purchase_order_details` (`purchase_order_details_id`, `purchase_order_id`, `supplier_medicine_id`, `quantity`) VALUES
(79, 'PO201909120001', 1, '1000'),
(80, 'PO201909120001', 2, '1000'),
(81, 'PO201909120001', 3, '1000'),
(82, 'PO201909120001', 7, '1000'),
(83, 'PO201909120001', 9, '1000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_received`
--

CREATE TABLE `tbl_purchase_received` (
  `purchase_received_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_order_id` varchar(255) NOT NULL,
  `date_received` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_received`
--

INSERT INTO `tbl_purchase_received` (`purchase_received_id`, `user_id`, `purchase_order_id`, `date_received`) VALUES
('PR201909120001', 3, 'PO201909120001', '2019-09-12'),
('PR201909130002', 3, 'PO201909120001', '2019-09-13'),
('PR201909150003', 3, 'PO201909120001', '2019-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_received_details`
--

CREATE TABLE `tbl_purchase_received_details` (
  `purchase_received_details_id` int(11) NOT NULL,
  `purchase_received_id` varchar(255) NOT NULL,
  `supplier_medicine_id` int(11) NOT NULL,
  `received_quantity` varchar(255) NOT NULL,
  `expiration_date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_received_details`
--

INSERT INTO `tbl_purchase_received_details` (`purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, `received_quantity`, `expiration_date`, `status`, `barcode`) VALUES
(126, 'PR201909120001', 1, '590', '2022-09-12', 'Active', '12345678901'),
(127, 'PR201909120001', 2, '590', '2022-09-12', 'Active', '12345678902'),
(128, 'PR201909120001', 3, '700', '2022-09-12', 'Active', '12345678903'),
(129, 'PR201909120001', 7, '700', '2022-09-12', 'Active', '12345678904'),
(130, 'PR201909120001', 9, '700', '2022-09-12', 'Active', '12345678905'),
(131, 'PR201909130002', 1, '1000', '2022-05-12', 'Active', '12345678906'),
(132, 'PR201909150003', 1, '1000', '2022-09-12', 'Active', '123456788');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_received_details`
--

CREATE TABLE `tbl_received_details` (
  `received_details_id` int(11) NOT NULL,
  `received_order_id` varchar(255) NOT NULL,
  `date_received` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `expiration_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_received_order`
--

CREATE TABLE `tbl_received_order` (
  `received_order_id` varchar(255) NOT NULL,
  `send_order_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date_received` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_received_order`
--

INSERT INTO `tbl_received_order` (`received_order_id`, `send_order_id`, `user_id`, `date_received`, `barangay_id`) VALUES
('RCO201909120001', 'SO201909120001', '1', '2019-09-12', 1),
('RCO201909120002', 'SO201909120001', '1', '2019-09-12', 1),
('RCO201909120003', 'SO201909120001', '1', '2019-09-12', 1),
('RCO201909120004', 'SO201909120003', '2', '2019-09-12', 2),
('RCO201909130005', 'SO201909130004', '34', '2019-09-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_received_order_details`
--

CREATE TABLE `tbl_received_order_details` (
  `received_order_details_id` int(11) NOT NULL,
  `received_order_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `expiration_date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_received_order_details`
--

INSERT INTO `tbl_received_order_details` (`received_order_details_id`, `received_order_id`, `purchase_received_details_id`, `quantity`, `expiration_date`, `status`, `barcode`) VALUES
(84, 'RCO201909120001', 126, '100', '2022-09-12', 'Not Active', '12345678901'),
(85, 'RCO201909120001', 127, '80', '2022-09-12', 'Active', '12345678902'),
(86, 'RCO201909120001', 128, '80', '2022-09-12', 'Active', '12345678903'),
(87, 'RCO201909120001', 129, '85', '2022-09-12', 'Active', '12345678904'),
(88, 'RCO201909120001', 130, '85', '2022-09-12', 'Active', '12345678905'),
(89, 'RCO201909120001', 126, '100', '2019-09-12', 'Active', '12345678906'),
(90, 'RCO201909120001', 127, '100', '2019-09-12', 'Active', '12345678907'),
(91, 'RCO201909120001', 128, '100', '2019-09-12', 'Active', '12345678909'),
(92, 'RCO201909120001', 129, '100', '2019-09-12', 'Active', '12345678910'),
(93, 'RCO201909120001', 130, '100', '2019-09-12', 'Active', '12345678911'),
(94, 'RCO201909120002', 126, '50', '2027-02-12', 'Active', '12345678912'),
(96, 'RCO201909120003', 126, '50', '2027-01-12', 'Active', '12345678913'),
(97, 'RCO201909120001', 126, '100', '2022-02-12', 'Active', '12345678914'),
(98, 'RCO201909120001', 127, '100', '2027-03-12', 'Active', '12345678915'),
(99, 'RCO201909120004', 128, '100', '2022-02-12', 'Active', '12345678916'),
(100, 'RCO201909130005', 126, '100', '2022-09-12', 'Active', '1234567812'),
(101, 'RCO201909130005', 127, '100', '2022-09-12', 'Active', '1234567812');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referral_transaction`
--

CREATE TABLE `tbl_referral_transaction` (
  `referral_transaction_id` varchar(255) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referral_transaction_date` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_referral_transaction`
--

INSERT INTO `tbl_referral_transaction` (`referral_transaction_id`, `beneficiary_id`, `user_id`, `referral_transaction_date`, `barangay_id`) VALUES
('RT201909150001', 'BF2019090200001', 3, '2019-09-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referral_transaction_details`
--

CREATE TABLE `tbl_referral_transaction_details` (
  `referral_transaction_details_id` int(11) NOT NULL,
  `referral_transaction_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_referral_transaction_details`
--

INSERT INTO `tbl_referral_transaction_details` (`referral_transaction_details_id`, `referral_transaction_id`, `purchase_received_details_id`, `quantity`, `price`, `total_price`) VALUES
(1, 'RT201909150001', 126, 0, '10.00', '0'),
(2, 'RT201909150001', 127, 10, '12.00', '120');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request_details`
--

CREATE TABLE `tbl_request_details` (
  `request_details_id` int(11) NOT NULL,
  `request_order_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `delivered_quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_request_details`
--

INSERT INTO `tbl_request_details` (`request_details_id`, `request_order_id`, `purchase_received_details_id`, `delivered_quantity`) VALUES
(106, 'RO201909120001', 126, '100'),
(107, 'RO201909120001', 127, '100'),
(108, 'RO201909120001', 128, '100'),
(109, 'RO201909120001', 129, '100'),
(110, 'RO201909120001', 130, '100'),
(111, 'RO201909120002', 126, '100'),
(112, 'RO201909120002', 127, '100'),
(113, 'RO201909120002', 128, '100'),
(114, 'RO201909120002', 129, '100'),
(115, 'RO201909120002', 130, '100'),
(116, 'RO201909120003', 126, '0'),
(117, 'RO201909120003', 127, '0'),
(118, 'RO201909120003', 128, '0'),
(119, 'RO201909120003', 129, '0'),
(120, 'RO201909120003', 130, '0'),
(121, 'RO201909120004', 126, '100'),
(122, 'RO201909120004', 127, '100'),
(123, 'RO201909120004', 128, '100'),
(124, 'RO201909120004', 129, '100'),
(125, 'RO201909120004', 130, '100'),
(126, 'RO201909130005', 126, '100'),
(127, 'RO201909130005', 127, '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request_order`
--

CREATE TABLE `tbl_request_order` (
  `request_order_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_request` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `request_order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_request_order`
--

INSERT INTO `tbl_request_order` (`request_order_id`, `user_id`, `date_request`, `barangay_id`, `request_order_status`) VALUES
('RO201909120001', 43, '2019-09-12', 1, 'Completed'),
('RO201909120002', 40, '2019-09-12', 2, 'Completed'),
('RO201909120003', 1, '2019-09-12', 1, 'Pending'),
('RO201909120004', 2, '2019-09-12', 2, 'Completed'),
('RO201909130005', 43, '2019-09-13', 1, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request_order_details`
--

CREATE TABLE `tbl_request_order_details` (
  `request_order_details_id` int(11) NOT NULL,
  `request_order_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_request_order_details`
--

INSERT INTO `tbl_request_order_details` (`request_order_details_id`, `request_order_id`, `purchase_received_details_id`) VALUES
(108, 'RO201909120001', 126),
(109, 'RO201909120001', 127),
(110, 'RO201909120001', 128),
(111, 'RO201909120001', 129),
(112, 'RO201909120001', 130),
(113, 'RO201909120002', 126),
(114, 'RO201909120002', 127),
(115, 'RO201909120002', 128),
(116, 'RO201909120002', 129),
(117, 'RO201909120002', 130),
(118, 'RO201909120003', 126),
(119, 'RO201909120003', 127),
(120, 'RO201909120003', 128),
(121, 'RO201909120003', 129),
(122, 'RO201909120003', 130),
(123, 'RO201909120004', 126),
(124, 'RO201909120004', 127),
(125, 'RO201909120004', 128),
(126, 'RO201909120004', 129),
(127, 'RO201909120004', 130),
(128, 'RO201909130005', 126),
(129, 'RO201909130005', 127);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_medicine`
--

CREATE TABLE `tbl_return_medicine` (
  `return_medicine_id` varchar(255) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date_return` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_return_medicine`
--

INSERT INTO `tbl_return_medicine` (`return_medicine_id`, `beneficiary_id`, `user_id`, `transaction_id`, `date_return`, `barangay_id`) VALUES
('RM201909130001', 'BF2019090200001', 1, 'TRANS201909120001', '2019-09-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_medicine_details`
--

CREATE TABLE `tbl_return_medicine_details` (
  `return_medicine_details_id` int(11) NOT NULL,
  `return_medicine_id` varchar(255) NOT NULL,
  `received_order_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_return_medicine_details`
--

INSERT INTO `tbl_return_medicine_details` (`return_medicine_details_id`, `return_medicine_id`, `received_order_details_id`, `quantity`, `total_amount`, `remarks`) VALUES
(3, 'RM201909130001', 84, '10', '100', 'broken seal'),
(4, 'RM201909130001', 85, '10', '120', 'broken seal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_referral_medicine`
--

CREATE TABLE `tbl_return_referral_medicine` (
  `return_referral_medicine_id` varchar(255) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referral_transaction_id` varchar(255) NOT NULL,
  `return_referral_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_return_referral_medicine`
--

INSERT INTO `tbl_return_referral_medicine` (`return_referral_medicine_id`, `beneficiary_id`, `user_id`, `referral_transaction_id`, `return_referral_date`) VALUES
('RRM201909150001', 'BF2019090200001', 3, 'RT201909150001', '2019-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_referral_medicine_details`
--

CREATE TABLE `tbl_return_referral_medicine_details` (
  `return_referral_medicine_details_id` int(11) NOT NULL,
  `return_referral_medicine_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_return_referral_medicine_details`
--

INSERT INTO `tbl_return_referral_medicine_details` (`return_referral_medicine_details_id`, `return_referral_medicine_id`, `purchase_received_details_id`, `quantity`, `total_amount`, `remarks`) VALUES
(2, 'RRM201909150001', 126, '10', '100', 'broken seal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_send_details`
--

CREATE TABLE `tbl_send_details` (
  `send_details_id` int(11) NOT NULL,
  `send_order_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `received_quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_send_details`
--

INSERT INTO `tbl_send_details` (`send_details_id`, `send_order_id`, `purchase_received_details_id`, `quantity`, `received_quantity`) VALUES
(98, 'SO201909120001', 126, '100', 100),
(99, 'SO201909120001', 127, '100', 100),
(100, 'SO201909120001', 128, '100', 100),
(101, 'SO201909120001', 129, '100', 100),
(102, 'SO201909120001', 130, '100', 100),
(103, 'SO201909120002', 126, '100', 100),
(104, 'SO201909120002', 127, '100', 100),
(105, 'SO201909120002', 128, '100', 100),
(106, 'SO201909120002', 129, '100', 100),
(107, 'SO201909120002', 130, '100', 100),
(108, 'SO201909120003', 126, '100', 100),
(109, 'SO201909120003', 127, '100', 100),
(110, 'SO201909120003', 128, '100', 100),
(111, 'SO201909120003', 129, '100', 0),
(112, 'SO201909120003', 130, '100', 0),
(113, 'SO201909130004', 126, '100', 100),
(114, 'SO201909130004', 127, '100', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_send_order`
--

CREATE TABLE `tbl_send_order` (
  `send_order_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_order_id` varchar(255) NOT NULL,
  `date_send` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_send_order`
--

INSERT INTO `tbl_send_order` (`send_order_id`, `user_id`, `request_order_id`, `date_send`, `barangay_id`) VALUES
('SO201909120001', 3, 'RO201909120001', '2019-09-12', 1),
('SO201909120002', 3, 'RO201909120002', '2019-09-12', 2),
('SO201909120003', 3, 'RO201909120004', '2019-09-12', 2),
('SO201909130004', 3, 'RO201909130005', '2019-09-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_send_order_details`
--

CREATE TABLE `tbl_send_order_details` (
  `send_order_details_id` int(11) NOT NULL,
  `send_order_id` varchar(255) NOT NULL,
  `purchase_received_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_send_order_details`
--

INSERT INTO `tbl_send_order_details` (`send_order_details_id`, `send_order_id`, `purchase_received_details_id`, `quantity`) VALUES
(110, 'SO201909120001', 126, '100'),
(111, 'SO201909120001', 127, '100'),
(112, 'SO201909120001', 128, '100'),
(113, 'SO201909120001', 129, '100'),
(114, 'SO201909120001', 130, '100'),
(115, 'SO201909120002', 126, '100'),
(116, 'SO201909120002', 127, '100'),
(117, 'SO201909120002', 128, '100'),
(118, 'SO201909120002', 129, '100'),
(119, 'SO201909120002', 130, '100'),
(125, 'SO201909120003', 126, '100'),
(126, 'SO201909120003', 127, '100'),
(127, 'SO201909120003', 128, '100'),
(128, 'SO201909120003', 129, '100'),
(129, 'SO201909120003', 130, '100'),
(130, 'SO201909130004', 126, '100'),
(131, 'SO201909130004', 127, '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_contact_no` varchar(255) NOT NULL,
  `supplier_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`supplier_id`, `supplier_name`, `supplier_address`, `supplier_contact_no`, `supplier_status`) VALUES
(1, 'City Hall', 'F.B. Bailon Street, Cabuyao City', '09391177579', 'Active'),
(2, 'Unilever', 'Science Park', '09391177479', 'Active'),
(3, 'Unilab', 'LISP', '09391177479', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_medicine`
--

CREATE TABLE `tbl_supplier_medicine` (
  `supplier_medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit_category_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier_medicine`
--

INSERT INTO `tbl_supplier_medicine` (`supplier_medicine_id`, `medicine_name`, `category_id`, `unit_category_id`, `price`, `supplier_id`) VALUES
(1, 'Atenolol', 1, 1, '10.00', 2),
(2, 'Paracetamol', 1, 2, '12.00', 2),
(3, 'Metoprolol', 1, 1, '12.00', 2),
(4, 'Atenolol', 1, 1, '10.00', 3),
(5, 'Paracetamol', 1, 2, '30.00', 3),
(6, 'Metoprolol', 1, 1, '18.00', 3),
(7, 'Ibuprofen', 1, 5, '20.00', 2),
(8, 'Ibuprofen', 1, 5, '20.00', 3),
(9, 'Decolgen', 1, 1, '10.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `transaction_id` varchar(255) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`transaction_id`, `beneficiary_id`, `user_id`, `transaction_date`, `barangay_id`) VALUES
('TRANS201909120001', 'BF2019090200001', 1, '2019-09-12', 1),
('TRANS201909120002', 'BF2019090200003', 1, '2019-09-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_details`
--

CREATE TABLE `tbl_transaction_details` (
  `details_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `received_order_details_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total_price` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaction_details`
--

INSERT INTO `tbl_transaction_details` (`details_id`, `transaction_id`, `received_order_details_id`, `quantity`, `price`, `total_price`) VALUES
(239, 'TRANS201909120001', 84, '0', '10.00', 0),
(240, 'TRANS201909120001', 85, '0', '12.00', 0),
(241, 'TRANS201909120001', 86, '10', '12.00', 120),
(242, 'TRANS201909120001', 87, '10', '20.00', 200),
(243, 'TRANS201909120001', 88, '10', '10.00', 100),
(244, 'TRANS201909120002', 84, '10', '10.00', 100),
(245, 'TRANS201909120002', 85, '10', '12.00', 120),
(246, 'TRANS201909120002', 86, '10', '12.00', 120),
(247, 'TRANS201909120002', 87, '5', '20.00', 100),
(248, 'TRANS201909120002', 88, '5', '10.00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit_category`
--

CREATE TABLE `tbl_unit_category` (
  `unit_category_id` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_unit_category`
--

INSERT INTO `tbl_unit_category` (`unit_category_id`, `unit`) VALUES
(1, '100mg'),
(2, '500mg'),
(3, '600mg'),
(4, '250mg'),
(5, '200mg'),
(6, '400mg'),
(7, '500mg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_update_beneficiary_details`
--

CREATE TABLE `tbl_update_beneficiary_details` (
  `update_beneficiary_details_id` int(11) NOT NULL,
  `beneficiary_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_updated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_update_beneficiary_details`
--

INSERT INTO `tbl_update_beneficiary_details` (`update_beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_updated`) VALUES
(1, 'BF2019090200001', 53, '2019-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `birth_date` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_employed` tinyint(1) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `default_password` varchar(255) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `password`, `first_name`, `last_name`, `middle_name`, `contact_no`, `birth_date`, `email_address`, `sex`, `address`, `is_employed`, `barangay_id`, `user_type_id`, `default_password`, `date_added`) VALUES
(1, 'USER20190917001', '$2y$10$TZhNNg8/QG59i0BI7rLW5.UezZkwQ7aeK7VKRv9BGXsMvsR7Ol79m', 'John Carlo', 'Lopez', 'Villacora', '09265312545', '1999-03-12', 'lopezjohncarlo@rocketmail.com', 'Male', 'Blk 20 Lot 5, Phase 1, Celestine Homes', 1, 1, 1, 'bms123', '2019-09-17'),
(52, 'USER20190917002', '$2y$10$ouHRlnmO0M4YFpUYqiufr.chu/rvYCghizmTjuOmc9xP73i8Sc3We', 'romolo', 'tacmoy', 'jy', '09295566472', '1997-01-25', 'romolo.tacmoy@gmail.com', 'Male', 'blk 20 lot 5 phase 3, payaman, mahogany', 1, 19, 1, 'bms123', '2019-09-17'),
(53, 'USER20190917003', '$2y$10$p1GxJMyxCi2XzM9Qqj6c/epDBXrGIoAYmRCgszhUfJMAmqrz24gp6', 'jasper', 'diongco', 'patubo', '09495566456', '1998-02-12', 'jasper.diongco@gmail.com', 'Male', 'blk 20 lot 6 phase 5, patubo, hongkong village', 1, 19, 3, 'bms123', '2019-09-17'),
(54, 'USER20190917004', '$2y$10$6pdZyOXy/oEUIgCmjbpejel8WA6d/pyQ9AGnuONY5G49yva4xNj1S', 'dave', 'tacmoy', 'almazan', '09456728492', '1998-02-2', 'dave.tacmoy@gmail.com', 'Male', 'blk 5 lot 1 phase 2, pahirap, mahogany', 1, 19, 2, 'bms123', '2019-09-17'),
(55, 'USER20190917005', '$2y$10$XC3.aIEP29YRAp9YtOtd6.nYIybd929U52REasaK6E2tOLI1iAM1a', 'anna', 'lopez', 'vida', '09195577382', '1995-03-20', 'anna.lopez@gmail.com', 'Female', 'blk 20 lot 7 phase 1, payamaning, st joseph 6', 1, 1, 4, 'bms123', '2019-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `description`) VALUES
(1, 'Administrator'),
(2, 'Pharmacist'),
(3, 'Registration Staff'),
(4, 'Health Worker'),
(5, 'none');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activate_beneficiary_details`
--
ALTER TABLE `tbl_activate_beneficiary_details`
  ADD PRIMARY KEY (`activate_beneficiary_details_id`);

--
-- Indexes for table `tbl_add_beneficiary_details`
--
ALTER TABLE `tbl_add_beneficiary_details`
  ADD PRIMARY KEY (`add_beneficiary_details_id`);

--
-- Indexes for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  ADD PRIMARY KEY (`barangay_id`);

--
-- Indexes for table `tbl_beneficiary`
--
ALTER TABLE `tbl_beneficiary`
  ADD PRIMARY KEY (`beneficiary_id`);

--
-- Indexes for table `tbl_beneficiary_details`
--
ALTER TABLE `tbl_beneficiary_details`
  ADD PRIMARY KEY (`beneficiary_details_id`);

--
-- Indexes for table `tbl_beneficiary_type`
--
ALTER TABLE `tbl_beneficiary_type`
  ADD PRIMARY KEY (`beneficiary_type_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_civil_status`
--
ALTER TABLE `tbl_civil_status`
  ADD PRIMARY KEY (`civil_status_id`);

--
-- Indexes for table `tbl_date`
--
ALTER TABLE `tbl_date`
  ADD PRIMARY KEY (`date_id`);

--
-- Indexes for table `tbl_dependent`
--
ALTER TABLE `tbl_dependent`
  ADD PRIMARY KEY (`dependent_id`);

--
-- Indexes for table `tbl_dependent_to_beneficiary_details`
--
ALTER TABLE `tbl_dependent_to_beneficiary_details`
  ADD PRIMARY KEY (`dependent_to_beneficiary_details_id`);

--
-- Indexes for table `tbl_login_details`
--
ALTER TABLE `tbl_login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Indexes for table `tbl_medicine`
--
ALTER TABLE `tbl_medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `tbl_purchase_details`
--
ALTER TABLE `tbl_purchase_details`
  ADD PRIMARY KEY (`purchase_details_id`);

--
-- Indexes for table `tbl_purchase_order`
--
ALTER TABLE `tbl_purchase_order`
  ADD PRIMARY KEY (`purchase_order_id`);

--
-- Indexes for table `tbl_purchase_order_details`
--
ALTER TABLE `tbl_purchase_order_details`
  ADD PRIMARY KEY (`purchase_order_details_id`);

--
-- Indexes for table `tbl_purchase_received`
--
ALTER TABLE `tbl_purchase_received`
  ADD PRIMARY KEY (`purchase_received_id`);

--
-- Indexes for table `tbl_purchase_received_details`
--
ALTER TABLE `tbl_purchase_received_details`
  ADD PRIMARY KEY (`purchase_received_details_id`);

--
-- Indexes for table `tbl_received_details`
--
ALTER TABLE `tbl_received_details`
  ADD PRIMARY KEY (`received_details_id`);

--
-- Indexes for table `tbl_received_order`
--
ALTER TABLE `tbl_received_order`
  ADD PRIMARY KEY (`received_order_id`);

--
-- Indexes for table `tbl_received_order_details`
--
ALTER TABLE `tbl_received_order_details`
  ADD PRIMARY KEY (`received_order_details_id`);

--
-- Indexes for table `tbl_referral_transaction`
--
ALTER TABLE `tbl_referral_transaction`
  ADD PRIMARY KEY (`referral_transaction_id`);

--
-- Indexes for table `tbl_referral_transaction_details`
--
ALTER TABLE `tbl_referral_transaction_details`
  ADD PRIMARY KEY (`referral_transaction_details_id`);

--
-- Indexes for table `tbl_request_details`
--
ALTER TABLE `tbl_request_details`
  ADD PRIMARY KEY (`request_details_id`);

--
-- Indexes for table `tbl_request_order`
--
ALTER TABLE `tbl_request_order`
  ADD PRIMARY KEY (`request_order_id`);

--
-- Indexes for table `tbl_request_order_details`
--
ALTER TABLE `tbl_request_order_details`
  ADD PRIMARY KEY (`request_order_details_id`);

--
-- Indexes for table `tbl_return_medicine`
--
ALTER TABLE `tbl_return_medicine`
  ADD PRIMARY KEY (`return_medicine_id`);

--
-- Indexes for table `tbl_return_medicine_details`
--
ALTER TABLE `tbl_return_medicine_details`
  ADD PRIMARY KEY (`return_medicine_details_id`);

--
-- Indexes for table `tbl_return_referral_medicine`
--
ALTER TABLE `tbl_return_referral_medicine`
  ADD PRIMARY KEY (`return_referral_medicine_id`);

--
-- Indexes for table `tbl_return_referral_medicine_details`
--
ALTER TABLE `tbl_return_referral_medicine_details`
  ADD PRIMARY KEY (`return_referral_medicine_details_id`);

--
-- Indexes for table `tbl_send_details`
--
ALTER TABLE `tbl_send_details`
  ADD PRIMARY KEY (`send_details_id`);

--
-- Indexes for table `tbl_send_order`
--
ALTER TABLE `tbl_send_order`
  ADD PRIMARY KEY (`send_order_id`);

--
-- Indexes for table `tbl_send_order_details`
--
ALTER TABLE `tbl_send_order_details`
  ADD PRIMARY KEY (`send_order_details_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbl_supplier_medicine`
--
ALTER TABLE `tbl_supplier_medicine`
  ADD PRIMARY KEY (`supplier_medicine_id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tbl_transaction_details`
--
ALTER TABLE `tbl_transaction_details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `tbl_unit_category`
--
ALTER TABLE `tbl_unit_category`
  ADD PRIMARY KEY (`unit_category_id`);

--
-- Indexes for table `tbl_update_beneficiary_details`
--
ALTER TABLE `tbl_update_beneficiary_details`
  ADD PRIMARY KEY (`update_beneficiary_details_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activate_beneficiary_details`
--
ALTER TABLE `tbl_activate_beneficiary_details`
  MODIFY `activate_beneficiary_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_add_beneficiary_details`
--
ALTER TABLE `tbl_add_beneficiary_details`
  MODIFY `add_beneficiary_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_beneficiary_details`
--
ALTER TABLE `tbl_beneficiary_details`
  MODIFY `beneficiary_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_beneficiary_type`
--
ALTER TABLE `tbl_beneficiary_type`
  MODIFY `beneficiary_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_civil_status`
--
ALTER TABLE `tbl_civil_status`
  MODIFY `civil_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_date`
--
ALTER TABLE `tbl_date`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=877;

--
-- AUTO_INCREMENT for table `tbl_dependent`
--
ALTER TABLE `tbl_dependent`
  MODIFY `dependent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_dependent_to_beneficiary_details`
--
ALTER TABLE `tbl_dependent_to_beneficiary_details`
  MODIFY `dependent_to_beneficiary_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_login_details`
--
ALTER TABLE `tbl_login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_medicine`
--
ALTER TABLE `tbl_medicine`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_details`
--
ALTER TABLE `tbl_purchase_details`
  MODIFY `purchase_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_purchase_order_details`
--
ALTER TABLE `tbl_purchase_order_details`
  MODIFY `purchase_order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_purchase_received_details`
--
ALTER TABLE `tbl_purchase_received_details`
  MODIFY `purchase_received_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `tbl_received_details`
--
ALTER TABLE `tbl_received_details`
  MODIFY `received_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_received_order_details`
--
ALTER TABLE `tbl_received_order_details`
  MODIFY `received_order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `tbl_referral_transaction_details`
--
ALTER TABLE `tbl_referral_transaction_details`
  MODIFY `referral_transaction_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_request_details`
--
ALTER TABLE `tbl_request_details`
  MODIFY `request_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `tbl_request_order_details`
--
ALTER TABLE `tbl_request_order_details`
  MODIFY `request_order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_return_medicine_details`
--
ALTER TABLE `tbl_return_medicine_details`
  MODIFY `return_medicine_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_return_referral_medicine_details`
--
ALTER TABLE `tbl_return_referral_medicine_details`
  MODIFY `return_referral_medicine_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_send_details`
--
ALTER TABLE `tbl_send_details`
  MODIFY `send_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `tbl_send_order_details`
--
ALTER TABLE `tbl_send_order_details`
  MODIFY `send_order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_supplier_medicine`
--
ALTER TABLE `tbl_supplier_medicine`
  MODIFY `supplier_medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_transaction_details`
--
ALTER TABLE `tbl_transaction_details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `tbl_unit_category`
--
ALTER TABLE `tbl_unit_category`
  MODIFY `unit_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_update_beneficiary_details`
--
ALTER TABLE `tbl_update_beneficiary_details`
  MODIFY `update_beneficiary_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
