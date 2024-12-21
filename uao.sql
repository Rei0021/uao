-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 07:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uao`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisers`
--

CREATE TABLE `advisers` (
  `adviser_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `internal_phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `room_number` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisers`
--

INSERT INTO `advisers` (`adviser_id`, `full_name`, `position`, `department_name`, `internal_phone_no`, `email`, `room_number`) VALUES
(1, 'Mark Reyes', 'Adviser', 'Residence Office', '0987654321', 'sample@email.com', '1001'),
(2, 'Anthony Gomez', 'Adviser', 'Residence Office', '09936647618', 'sample@email.com', '1002'),
(3, 'Lily Marquez', 'Adviser', 'Residence Office', '2301348149', 'sample@email.com', '1003');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_number` int(11) NOT NULL,
  `course_title` varchar(100) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_number`, `course_title`, `instructor_id`, `department_name`) VALUES
(0, 'Advance Database', 1, 'CCS'),
(131, 'Advance Database', 1, 'CCS'),
(137, 'Web Systems', 2, 'CCS');

-- --------------------------------------------------------

--
-- Table structure for table `halls_of_residence`
--

CREATE TABLE `halls_of_residence` (
  `hall_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `halls_of_residence`
--

INSERT INTO `halls_of_residence` (`hall_id`, `name`, `address`, `phone_no`, `staff_id`) VALUES
(1, 'NONE', 'PLACEHOLDER', '000000000', 2),
(3, 'Gryffindor', 'Baliwasan', '09123456789', 2),
(4, 'Slytherin', 'Baliwasan', '09987654321', 1),
(5, 'Hufflepuff', 'Baliwasan', '09987654321', 1),
(6, 'Ravenclaw', 'Baliwasan', '09987654321', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

CREATE TABLE `inspections` (
  `inspection_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `flat_id` int(11) NOT NULL,
  `inspection_date` date DEFAULT NULL,
  `satisfactory_condition` enum('Yes','No') DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inspections`
--

INSERT INTO `inspections` (`inspection_id`, `staff_id`, `flat_id`, `inspection_date`, `satisfactory_condition`, `comments`) VALUES
(11, 1, 8, '2023-04-12', 'Yes', 'How about now?'),
(18, 2, 9, '2022-11-11', 'No', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `instructor_room` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `name`, `phone_no`, `email`, `instructor_room`) VALUES
(1, 'Jason Catadman', '092357289341', 'sample@email.com', 'LR 2'),
(2, 'John Augustus', '09762735173', 'sample@email.com', 'LAB 2'),
(3, 'Ceed Lorenzo', '09728462748', 'sample@email.com', 'LAB 2'),
(4, 'Justine Ann Albay', '09987654321', 'sample@email.com', 'LR 2');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_number` int(11) NOT NULL,
  `lease_number` int(11) NOT NULL,
  `semester` varchar(30) DEFAULT NULL,
  `payment_due` decimal(10,2) DEFAULT NULL,
  `banner_number` int(11) DEFAULT NULL,
  `place_number` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `first_date_reminder` date DEFAULT NULL,
  `second_date_reminder` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_number`, `lease_number`, `semester`, `payment_due`, `banner_number`, `place_number`, `payment_date`, `payment_method`, `first_date_reminder`, `second_date_reminder`) VALUES
(1, 1, 'First Semester', 800.00, 10, 5, '2024-12-20', 'Cash', '0000-00-00', '0000-00-00'),
(2, 2, 'WholeYear', 2250.00, 10, 6, '2024-12-21', 'Check', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `leases`
--

CREATE TABLE `leases` (
  `lease_number` int(11) NOT NULL,
  `lease_duration` varchar(30) DEFAULT NULL,
  `banner_number` int(11) DEFAULT NULL,
  `place_number` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leases`
--

INSERT INTO `leases` (`lease_number`, `lease_duration`, `banner_number`, `place_number`, `start_date`, `end_date`) VALUES
(1, 'First Semester', 10, 5, '2025-12-15', '0000-00-00'),
(2, 'Whole Year', 10, 6, '2025-01-12', '0000-00-00'),
(4, 'Summer Semester', 10, 7, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kin`
--

CREATE TABLE `next_of_kin` (
  `kin_id` int(11) NOT NULL,
  `banner_number` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residence_staff`
--

CREATE TABLE `residence_staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residence_staff`
--

INSERT INTO `residence_staff` (`staff_id`, `first_name`, `last_name`, `email`, `home_address`, `date_of_birth`, `gender`, `position`, `location`) VALUES
(1, 'Anna', 'Santos', 'santos@email.com', 'Tumaga', '1990-08-20', 'Female', 'Hall Manager', 'Hall'),
(2, 'Maria', 'Ramos', 'ramos@email.com', 'Tetuan', '1986-05-22', 'Female', 'Hall Manager', 'Hall'),
(3, 'John', 'Estrada', 'sample@email.com', 'Baliwasan', '1980-04-16', 'Male', 'Administrative Assistant', 'Residence Office'),
(9, 'Sample', 'Only', 'sample@email.com', 'Putik', '0000-00-00', 'Male', 'Cleaner', 'Hall');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `place_number` int(11) NOT NULL,
  `room_number` varchar(10) DEFAULT NULL,
  `monthly_rent` decimal(10,2) DEFAULT NULL,
  `room_type` enum('Hall','Flat') DEFAULT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`place_number`, `room_number`, `monthly_rent`, `room_type`, `hall_id`, `flat_id`) VALUES
(1, '1001', 1500.00, 'Hall', 3, NULL),
(2, '2002', 800.00, 'Flat', 1, NULL),
(5, '1002', 800.00, 'Flat', 1, 8),
(6, '11', 750.00, 'Hall', 3, 7),
(7, '11', 750.00, 'Hall', 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `banner_number` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `special_needs` text DEFAULT NULL,
  `additional_comments` text DEFAULT NULL,
  `current_status` enum('Placed','Waiting') DEFAULT NULL,
  `major` varchar(50) DEFAULT NULL,
  `minor` varchar(50) DEFAULT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `course_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`banner_number`, `first_name`, `last_name`, `category`, `special_needs`, `additional_comments`, `current_status`, `major`, `minor`, `adviser_id`, `course_number`) VALUES
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, 'Juan', 'Dela Cruz', 'First year', 'None', 'None', 'Waiting', 'No', 'Yes', 1, 0),
(11, 'Hanna', 'Fernandez', 'Fourth Year', 'None', 'None', 'Placed', 'Yes', 'No', 2, 0),
(12, 'Kyle', 'Alcantara', 'Second Year', 'None', 'None', 'Placed', 'Yes', 'No', 1, 0),
(16, 'Sample', 'Only', 'Graduate', 'None', 'Checking', 'Waiting', 'No', 'No', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_flats`
--

CREATE TABLE `student_flats` (
  `flat_id` int(11) NOT NULL,
  `apartment_number` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_bedrooms` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_flats`
--

INSERT INTO `student_flats` (`flat_id`, `apartment_number`, `address`, `total_bedrooms`) VALUES
(7, 'NONE', 'PLACEHOLDER', 0),
(8, '10', 'Baliwasan', 4),
(9, '20', 'Baliwasan', 2),
(10, '30', 'Baliwasan', 5),
(11, '40', 'Baliwasan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `banner_number` int(11) NOT NULL,
  `home_address` text DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`banner_number`, `home_address`, `mobile_phone`, `email`, `date_of_birth`, `gender`, `nationality`) VALUES
(10, 'Baliwasan', '09482611736', 'sample@email.com', '1997-01-23', 'Male', 'Filipino'),
(11, 'Tetuan', '09958336427', 'sample@email.com', '2000-05-22', 'Female', 'Filipino'),
(12, 'Lunzuran', '09753374883', 'sample@email.com', '1999-10-02', 'Male', 'Filipino'),
(16, 'Putik', '09849264833', 'sample@email.com', '2004-03-15', 'Male', 'American');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager') DEFAULT 'manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$vTblSdEAs9Bp8hqnoneJ4umaiKp2EyqJI3oxjTquvL/.UQlfBR7zK', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisers`
--
ALTER TABLE `advisers`
  ADD PRIMARY KEY (`adviser_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_number`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `halls_of_residence`
--
ALTER TABLE `halls_of_residence`
  ADD PRIMARY KEY (`hall_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `inspections`
--
ALTER TABLE `inspections`
  ADD PRIMARY KEY (`inspection_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `flat_id` (`flat_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_number`),
  ADD KEY `lease_number` (`lease_number`),
  ADD KEY `banner_number` (`banner_number`),
  ADD KEY `place_number` (`place_number`);

--
-- Indexes for table `leases`
--
ALTER TABLE `leases`
  ADD PRIMARY KEY (`lease_number`),
  ADD KEY `banner_number` (`banner_number`),
  ADD KEY `place_number` (`place_number`);

--
-- Indexes for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD PRIMARY KEY (`kin_id`),
  ADD KEY `banner_number` (`banner_number`);

--
-- Indexes for table `residence_staff`
--
ALTER TABLE `residence_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`place_number`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `flat_id` (`flat_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`banner_number`),
  ADD KEY `adviser_id` (`adviser_id`),
  ADD KEY `course_number` (`course_number`);

--
-- Indexes for table `student_flats`
--
ALTER TABLE `student_flats`
  ADD PRIMARY KEY (`flat_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD KEY `banner_number` (`banner_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisers`
--
ALTER TABLE `advisers`
  MODIFY `adviser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `halls_of_residence`
--
ALTER TABLE `halls_of_residence`
  MODIFY `hall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inspections`
--
ALTER TABLE `inspections`
  MODIFY `inspection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leases`
--
ALTER TABLE `leases`
  MODIFY `lease_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  MODIFY `kin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `residence_staff`
--
ALTER TABLE `residence_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `banner_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `student_flats`
--
ALTER TABLE `student_flats`
  MODIFY `flat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `halls_of_residence`
--
ALTER TABLE `halls_of_residence`
  ADD CONSTRAINT `halls_of_residence_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `residence_staff` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inspections`
--
ALTER TABLE `inspections`
  ADD CONSTRAINT `inspections_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `residence_staff` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inspections_ibfk_2` FOREIGN KEY (`flat_id`) REFERENCES `student_flats` (`flat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`lease_number`) REFERENCES `leases` (`lease_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`banner_number`) REFERENCES `students` (`banner_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`place_number`) REFERENCES `rooms` (`place_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leases`
--
ALTER TABLE `leases`
  ADD CONSTRAINT `leases_ibfk_1` FOREIGN KEY (`banner_number`) REFERENCES `students` (`banner_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leases_ibfk_2` FOREIGN KEY (`place_number`) REFERENCES `rooms` (`place_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD CONSTRAINT `next_of_kin_ibfk_1` FOREIGN KEY (`banner_number`) REFERENCES `students` (`banner_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls_of_residence` (`hall_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`flat_id`) REFERENCES `student_flats` (`flat_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`adviser_id`) REFERENCES `advisers` (`adviser_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`course_number`) REFERENCES `courses` (`course_number`) ON UPDATE CASCADE;

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`banner_number`) REFERENCES `students` (`banner_number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
