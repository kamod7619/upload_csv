-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 05:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upload_csv`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency_details`
--

CREATE TABLE `agency_details` (
  `id` int(11) NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `agency_task` varchar(255) NOT NULL,
  `agency_location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agency_details`
--

INSERT INTO `agency_details` (`id`, `agency_name`, `agency_task`, `agency_location`, `created_at`) VALUES
(1, 'Healthflex', 'Hospitalization', 'California', '2024-07-26 03:15:51'),
(2, 'Harmony', 'Hospitalization', 'California', '2024-07-26 03:15:51'),
(3, 'CCHHA', 'Hospitalization', 'California', '2024-07-26 03:15:51'),
(4, 'Healthflex', 'Hospitalization', 'California', '2024-07-26 03:15:51'),
(5, 'Harmony', 'Hospitalization', 'California', '2024-07-26 03:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`id`, `employee_id`, `employee_name`, `created_at`) VALUES
(1, 1207, 'Ferrolino, Johnry', '2024-07-26 03:15:51'),
(2, 1207, 'Ferrolino, Johnry', '2024-07-26 03:15:51'),
(3, 1207, 'Ferrolino, Johnry', '2024-07-26 03:15:51'),
(4, 1207, 'Ferrolino, Johnry', '2024-07-26 03:15:51'),
(5, 1207, 'Ferrolino, Johnry', '2024-07-26 03:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `upload_data`
--

CREATE TABLE `upload_data` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `patient_name` text DEFAULT NULL,
  `mrn` varchar(255) NOT NULL,
  `assessment_type` varchar(255) DEFAULT NULL,
  `insurance_name` varchar(255) DEFAULT NULL,
  `information_source` varchar(255) DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_data`
--

INSERT INTO `upload_data` (`id`, `employee_id`, `agency_id`, `patient_name`, `mrn`, `assessment_type`, `insurance_name`, `information_source`, `production_date`, `visit_date`, `created_at`) VALUES
(1, 1, 1, 'VODICKA, CHRISTINE A', '57248', '', 'United Healthcare', 'Phone', '2024-06-26', '0000-00-00', '2024-07-26 03:15:51'),
(2, 2, 2, 'JESICA, ROWENA S', '23412', '', 'United Healthcare', 'Portal', '2024-06-26', '0000-00-00', '2024-07-26 03:15:51'),
(3, 3, 3, 'VENICIA, BUGATI R', '45324', '', 'United Healthcare', 'Phone', '2024-06-26', '0000-00-00', '2024-07-26 03:15:51'),
(4, 4, 4, 'ROXANE, VERONIC R', '87956', '', 'United Healthcare', 'Portal', '2024-06-26', '0000-00-00', '2024-07-26 03:15:51'),
(5, 5, 5, 'KARMAL, KAMARENE H', '43521', '', 'United Healthcare', 'Phone', '2024-06-26', '0000-00-00', '2024-07-26 03:15:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency_details`
--
ALTER TABLE `agency_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency_details`
--
ALTER TABLE `agency_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `upload_data`
--
ALTER TABLE `upload_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
