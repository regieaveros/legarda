-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2019 at 09:08 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tdframe`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL COMMENT 'User Complete Name',
  `admin_type_idr` int(11) NOT NULL DEFAULT '1' COMMENT 'User Type',
  `user_img` varchar(150) NOT NULL COMMENT 'Profile Picture',
  `email_str` varchar(150) NOT NULL,
  `title_str` varchar(150) NOT NULL,
  `company_str` varchar(150) NOT NULL,
  `username_str` varchar(150) NOT NULL,
  `password_psw` varchar(150) NOT NULL,
  `branch_vtb` int(11) NOT NULL,
  `active_bol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_help`
--

CREATE TABLE `tbl_admin_help` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `admin_vta` varchar(150) NOT NULL,
  `faq_vta` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_logs`
--

CREATE TABLE `tbl_admin_logs` (
  `id` int(11) NOT NULL,
  `admin_idr` int(11) NOT NULL,
  `activity_lng` longtext NOT NULL,
  `date_dtm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_notifications`
--

CREATE TABLE `tbl_admin_notifications` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `admin_idr` int(11) NOT NULL,
  `table_idr` int(11) NOT NULL,
  `notification_str` varchar(150) NOT NULL,
  `viewed_bol` int(11) NOT NULL,
  `date_dat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_reports`
--

CREATE TABLE `tbl_admin_reports` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `query_lng` varchar(150) NOT NULL,
  `group_idr` int(11) NOT NULL,
  `date_field_str` varchar(150) NOT NULL,
  `admin_type_arr` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_tables`
--

CREATE TABLE `tbl_admin_tables` (
  `id` int(11) NOT NULL,
  `admin_type_idr` varchar(150) NOT NULL,
  `table_idr` varchar(150) NOT NULL,
  `filter_str` longtext NOT NULL,
  `update_fields_str` varchar(150) NOT NULL COMMENT 'Update Fields (Field Name Seperated by '','')',
  `show_fields_str` varchar(150) NOT NULL COMMENT 'Show Fields (Index, id=0)',
  `add_bol` int(11) NOT NULL,
  `update_bol` int(11) NOT NULL,
  `delete_bol` int(11) NOT NULL,
  `view_bol` int(11) NOT NULL DEFAULT '1',
  `descending_bol` int(11) NOT NULL,
  `insert_notifications_bol` int(11) NOT NULL,
  `update_notifications_bol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_type`
--

CREATE TABLE `tbl_admin_type` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `group_arr` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `branch_name_str` varchar(150) NOT NULL,
  `region_str` varchar(150) NOT NULL,
  `branch_category_idr` int(11) NOT NULL,
  `contact_person_str` varchar(150) NOT NULL,
  `obsolete_bol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_category`
--

CREATE TABLE `tbl_branch_category` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail`
--

CREATE TABLE `tbl_detail` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `base_url_str` varchar(150) NOT NULL,
  `website_name_str` varchar(150) NOT NULL,
  `copyright_str` varchar(150) NOT NULL,
  `bg_img` varchar(150) NOT NULL COMMENT 'Login Background Image',
  `logo_log` varchar(50) NOT NULL,
  `favicon_log` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_detail`
--

INSERT INTO `tbl_detail` (`id`, `display_name_str`, `base_url_str`, `website_name_str`, `copyright_str`, `bg_img`, `logo_log`, `favicon_log`) VALUES
(1, 'General Settings', 'https://froneri-systems.com/assetmanagement/', 'Froneri Philippines Inc.', 'Froneri Philippines Inc. All rights reserved 2018.', 'General Settings.jpg', 'Detail-01.png', 'Detail-01.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `fa_icon_str` varchar(150) NOT NULL,
  `description_lng` longtext NOT NULL,
  `dashboard_col` varchar(150) NOT NULL DEFAULT '#0363a0',
  `dashboard_display_bol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_table`
--

CREATE TABLE `tbl_table` (
  `id` int(11) NOT NULL,
  `group_idr` int(11) NOT NULL,
  `display_name_str` varchar(150) NOT NULL,
  `title_str` varchar(150) NOT NULL,
  `row_limit_int` int(11) NOT NULL DEFAULT '10',
  `column_limit_int` int(11) NOT NULL,
  `autoid_bol` int(11) NOT NULL,
  `datatable_bol` int(11) NOT NULL COMMENT 'Make Data Table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_table_field_filters`
--

CREATE TABLE `tbl_table_field_filters` (
  `id` int(11) NOT NULL,
  `table_idr` int(11) NOT NULL,
  `field_str` varchar(150) NOT NULL,
  `filter_sql_lng` longtext NOT NULL,
  `no_null_bol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_help`
--
ALTER TABLE `tbl_admin_help`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_logs`
--
ALTER TABLE `tbl_admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_notifications`
--
ALTER TABLE `tbl_admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_reports`
--
ALTER TABLE `tbl_admin_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_tables`
--
ALTER TABLE `tbl_admin_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_type`
--
ALTER TABLE `tbl_admin_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branch_category`
--
ALTER TABLE `tbl_branch_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_detail`
--
ALTER TABLE `tbl_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_table`
--
ALTER TABLE `tbl_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_table_field_filters`
--
ALTER TABLE `tbl_table_field_filters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_help`
--
ALTER TABLE `tbl_admin_help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_logs`
--
ALTER TABLE `tbl_admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_notifications`
--
ALTER TABLE `tbl_admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_reports`
--
ALTER TABLE `tbl_admin_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_tables`
--
ALTER TABLE `tbl_admin_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_type`
--
ALTER TABLE `tbl_admin_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_branch_category`
--
ALTER TABLE `tbl_branch_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_detail`
--
ALTER TABLE `tbl_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_table`
--
ALTER TABLE `tbl_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_table_field_filters`
--
ALTER TABLE `tbl_table_field_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
