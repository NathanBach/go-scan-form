-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2020 at 09:34 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `qrid` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `user_data` json NOT NULL,
  `insert_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`qrid`, `section_name`, `form_name`, `user_data`, `insert_date`, `updated_date`, `delete_flag`) VALUES
(1, 'Test section', 'Test form', '{\"people\": {\"people1\": {\"lastname\": \"Yamamoto\", \"firstname\": \"Genzou\"}, \"people2\": {\"lastname\": \"Ishii\", \"firstname\": \"Sayuri\"}, \"people3\": {\"lastname\": \"Kachimo\", \"firstname\": \"Tina\"}}, \"version\": \"1\", \"language\": \"0\", \"device_id\": \"0000\", \"move_date\": \"20200920\", \"company_name\": \"Plate inc.\", \"demander_name\": {\"lastname\": \"Kurokawa\", \"firstname\": \"Shingo\"}, \"temp_re_entry\": \"0\", \"create_deman_date\": \"20200610114134\", \"create_re_counter\": \"都民の声窓口/食堂\", \"demander_name_kata\": {\"lastname\": \"Kurokawa\", \"firstname\": \"Shingo\"}, \"create_phone_number\": \"088776652\"}', '2020-07-30 07:08:12', '2020-07-29 17:00:00', 0),
(2, '都市整備局', 'マ写申込書', '{\"people\": {\"people1\": {\"lastname\": \"Quy\", \"firstname\": \"Phan\"}, \"people2\": {\"lastname\": \"Huong\", \"firstname\": \"Nguyen\"}, \"people3\": {\"lastname\": \"Long\", \"firstname\": \"Dinh\"}, \"people4\": {\"lastname\": \"Gia\", \"firstname\": \"Phan\"}}, \"version\": \"1\", \"language\": \"0\", \"device_id\": \"0000\", \"move_date\": \"20200920\", \"company_name\": \"Samsung Vietnam\", \"demander_name\": {\"lastname\": \"Hien\", \"firstname\": \"Phan\"}, \"temp_re_entry\": \"0\", \"create_deman_date\": \"20200720114134\", \"create_re_counter\": \"都民の声窓口/食堂\", \"demander_name_kata\": {\"lastname\": \"Hien\", \"firstname\": \"Phan\"}, \"create_phone_number\": \"0964224872\"}', '2020-07-31 10:32:35', '2020-07-31 03:32:35', 0),
(3, 'Section 1', 'Form 1', '{\"people\": {\"people1\": {\"lastname\": \"Quan\", \"firstname\": \"Dang\"}, \"people2\": {\"lastname\": \"Hien\", \"firstname\": \"Phan\"}, \"people3\": {\"lastname\": \"Long\", \"firstname\": \"Dinh\"}, \"people4\": {\"lastname\": \"Gia\", \"firstname\": \"Phan\"}}, \"version\": \"1\", \"language\": \"0\", \"device_id\": \"0000\", \"move_date\": \"20201220\", \"company_name\": \"FPT Software\", \"demander_name\": {\"lastname\": \"Khoa\", \"firstname\": \"Nguyen\"}, \"temp_re_entry\": \"1\", \"create_deman_date\": \"20200726114134\", \"create_re_counter\": \"都民の声窓口/食堂/その他 Other\", \"demander_name_kata\": {\"lastname\": \"Khoa\", \"firstname\": \"Dang\"}, \"create_phone_number\": \"0987675252\"}', '2020-08-01 00:00:00', '2020-08-01 08:10:21', 0),
(4, 'Section 2', 'Form 2', '{\"people\": {\"people1\": {\"lastname\": \"Khoa\", \"firstname\": \"Dang\"}, \"people2\": {\"lastname\": \"Hien\", \"firstname\": \"Phan\"}, \"people3\": {\"lastname\": \"Nghia\", \"firstname\": \"Dang\"}}, \"version\": \"1\", \"language\": \"0\", \"device_id\": \"0000\", \"move_date\": \"20201212\", \"company_name\": \"Lampart Vietnam\", \"demander_name\": {\"lastname\": \"Quan\", \"firstname\": \"Nguyen\"}, \"temp_re_entry\": \"1\", \"create_deman_date\": \"20200826114134\", \"create_re_counter\": \"都民の声窓口/食堂/その他 Other\", \"demander_name_kata\": {\"lastname\": \"Quan\", \"firstname\": \"Dang\"}, \"create_phone_number\": \"09992221\"}', '2020-08-02 02:00:00', '2020-08-01 08:12:59', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`qrid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `qrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
