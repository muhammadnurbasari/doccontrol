-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2020 at 05:28 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doccontrol`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_code` varchar(4) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_code`, `department_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `status`) VALUES
(1, 'QA', 'Quality Assurance', '2020-01-19', NULL, NULL, 1, NULL, NULL, 1),
(2, 'PPIC', 'Production Planning and Inventory Control', '2020-01-19', NULL, NULL, 1, NULL, NULL, 1),
(3, 'PROD', 'Produksi', '2020-01-21', '2020-01-21', '2020-01-21', 2, 2, 2, 0),
(4, 'PURC', 'Purchasing', '2020-01-21', NULL, NULL, 2, NULL, NULL, 1),
(5, 'HRD', 'Human Resource Department', '2020-01-21', NULL, NULL, 2, NULL, NULL, 1),
(6, 'PROD', 'Produksi', '2020-01-21', NULL, NULL, 2, NULL, NULL, 1),
(7, 'MGN', 'Management', '2020-01-22', '2020-01-22', NULL, 1, 1, NULL, 1),
(8, 'pro', 'sdfsdfsd', '2020-01-25', NULL, '2020-01-25', 1, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `distributions`
--

CREATE TABLE `distributions` (
  `distributions_id` int(11) NOT NULL,
  `doc_release_details_id` int(11) NOT NULL,
  `confirm_by` int(11) NOT NULL,
  `confirm_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int(11) NOT NULL,
  `document_code` varchar(4) NOT NULL,
  `document_name` varchar(30) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`document_id`, `document_code`, `document_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `status`) VALUES
(1, 'QP', 'Quality Procedural', '2020-01-21', NULL, NULL, 1, NULL, NULL, 1),
(2, 'cb', 'Coba', '2020-01-21', '2020-01-21', '2020-01-21', 1, 1, 1, 0),
(3, 'SOP', 'Standart Operational Procedura', '2020-01-22', NULL, NULL, 1, NULL, NULL, 1),
(4, 'FORM', 'Form', '2020-01-22', NULL, NULL, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doc_category`
--

CREATE TABLE `doc_category` (
  `doc_category_id` int(11) NOT NULL,
  `doc_category_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doc_category`
--

INSERT INTO `doc_category` (`doc_category_id`, `doc_category_name`, `department_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `status`) VALUES
(1, 'Tindakan Perbaikan', 2, '2020-01-21', '2020-01-21', '2020-01-21', 1, 1, 1, 0),
(2, 'Penanganan Perubahan', 2, '2020-01-21', '2020-01-21', '2020-01-21', 1, 1, 1, 0),
(3, 'Penanganan Perubahan', 2, '2020-01-26', '2020-01-26', '2020-01-26', 2, 2, 2, 0),
(4, 'Tindakan Perbaikan', 1, '2020-01-23', '2020-01-23', NULL, 1, 1, NULL, 1),
(5, 'Penanganan Perubahan', 2, '2020-01-26', '2020-01-26', NULL, 2, 2, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doc_release_details`
--

CREATE TABLE `doc_release_details` (
  `doc_release_details_id` int(11) NOT NULL,
  `doc_header_header_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doc_release_header`
--

CREATE TABLE `doc_release_header` (
  `doc_release_header_id` int(11) NOT NULL,
  `doc_release_code` varchar(16) NOT NULL,
  `doc_release_date` date NOT NULL,
  `doc_title` varchar(100) NOT NULL,
  `doc_type_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `doc_category_id` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL,
  `revisi_no` int(11) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `doc_file` varchar(500) NOT NULL,
  `revisi_note` varchar(100) DEFAULT NULL,
  `expired_note` varchar(100) DEFAULT NULL,
  `doc_status` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `revised_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `revised_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doc_release_header`
--

INSERT INTO `doc_release_header` (`doc_release_header_id`, `doc_release_code`, `doc_release_date`, `doc_title`, `doc_type_id`, `department_id`, `doc_category_id`, `doc_no`, `revisi_no`, `description`, `doc_file`, `revisi_note`, `expired_note`, `doc_status`, `created_at`, `revised_at`, `deleted_at`, `created_by`, `revised_by`, `deleted_by`) VALUES
(1, 'RDP-20200125-001', '2020-01-25', 'penanganan perubahan', 4, 1, 5, 1, NULL, 'monitoring perubahan', 'ticket.pdf', NULL, NULL, 0, '2020-01-25', NULL, NULL, 1, NULL, NULL),
(2, 'RDP-20200125-002', '2020-01-25', 'coba 2', 4, 1, 5, 2, NULL, 'coba saja', 'sales_(2).pdf', NULL, NULL, 0, '2020-01-25', NULL, NULL, 1, NULL, NULL),
(3, 'RDP-20200125-003', '2020-01-25', 'coba lagi', 3, 1, 4, 1, NULL, 'coba', 'sales_(1).pdf', NULL, NULL, 0, '2020-01-25', NULL, NULL, 1, NULL, NULL),
(4, 'RDP-20200125-004', '2020-01-25', 'njkgggj', 3, 1, 4, 2, NULL, 'vjvvjvjvj', 'sales.pdf', NULL, NULL, 0, '2020-01-25', NULL, NULL, 1, NULL, NULL),
(5, 'RDP-20200125-005', '2020-01-25', 'uiuiiughu', 3, 1, 5, 1, NULL, 'ghjgjhgjgjhg', 'Pricelist_Dell_Per_Oktober_2019.pdf', NULL, NULL, 0, '2020-01-25', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `release_approves`
--

CREATE TABLE `release_approves` (
  `release_approves_id` int(11) NOT NULL,
  `doc_release_header_id` int(11) NOT NULL,
  `approve_status` int(11) NOT NULL,
  `approve_dept_date` date NOT NULL,
  `approve_dc_date` date NOT NULL,
  `approve_mr_date` date NOT NULL,
  `approve_dept_note` varchar(40) NOT NULL,
  `approve_dc_note` varchar(40) NOT NULL,
  `approve_mr_note` varchar(40) NOT NULL,
  `approve_dept_by` int(11) NOT NULL,
  `approve_dc_by` int(11) NOT NULL,
  `approve_mr_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `name`, `password`, `level_id`, `address`, `email`, `phone_number`, `department_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `status`) VALUES
(1, 'tia', 'tia agisti', '$2y$10$hgKKhRfyEfzGpxn9T5Y15eqMw7ARqFwBlJSaSHQVVen/MnKD1/SIO', 3, 'jl pegangsaan no 17', 'tia.agisti@gmail.com', '081293245820', 1, '2020-01-23', '2020-01-23', NULL, 1, 1, NULL, 1),
(2, 'rahman', 'nurahman', '$2y$10$7aFI.UQ.RxJd.Ldw8SQIuufB3Cve/6iaF8MXirMorbS8xK2wfE4XC', 1, 'bitung blok l4', 'ngasiman20@gmail.com', '081293245825', 2, '2020-01-23', '2020-01-23', NULL, 1, 1, NULL, 1),
(3, 'abbas', 'muhammad nur basari', '$2y$10$2YiXwIL6U3Bv/7rOIBBeXuIKJLtn5ZhMdvGKeGKLgAGNCuPw2TK4.', 1, 'tigaraksa', 'abbas@gmail.com', '081293245820', 2, '2020-01-21', '2020-01-21', NULL, 1, 1, NULL, 1),
(4, 'coba', 'coba saja', '$2y$10$dLhyA1zvS31IkRxsU2p2buq5yhRzwtuYYpQRv5EfXSf23a5HGJOa2', 2, 'tangerang', 'coba@gmail.com', '081293245820', 1, '2020-01-20', NULL, '2020-01-20', 1, NULL, 1, 0),
(5, 'coba mgn', 'mgn', '$2y$10$QL2HsPkc1My6CVkrgzvQy.QnVGIBIh1aL9F5mazhLLxBtZka4Tlzy', 4, 'coba saja', 'coba2@gmail.com', '081293245820', 7, '2020-01-23', NULL, NULL, 1, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `distributions`
--
ALTER TABLE `distributions`
  ADD PRIMARY KEY (`distributions_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `doc_category`
--
ALTER TABLE `doc_category`
  ADD PRIMARY KEY (`doc_category_id`);

--
-- Indexes for table `doc_release_details`
--
ALTER TABLE `doc_release_details`
  ADD PRIMARY KEY (`doc_release_details_id`);

--
-- Indexes for table `doc_release_header`
--
ALTER TABLE `doc_release_header`
  ADD PRIMARY KEY (`doc_release_header_id`);

--
-- Indexes for table `release_approves`
--
ALTER TABLE `release_approves`
  ADD PRIMARY KEY (`release_approves_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `distributions`
--
ALTER TABLE `distributions`
  MODIFY `distributions_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doc_category`
--
ALTER TABLE `doc_category`
  MODIFY `doc_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doc_release_details`
--
ALTER TABLE `doc_release_details`
  MODIFY `doc_release_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doc_release_header`
--
ALTER TABLE `doc_release_header`
  MODIFY `doc_release_header_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `release_approves`
--
ALTER TABLE `release_approves`
  MODIFY `release_approves_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
