-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 11:12 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icbt_gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `service_id`, `trainer_id`, `booking_date`, `booking_time`, `status`, `notes`) VALUES
(1, 1, 1, NULL, '2025-03-08', '16:30:00', 'pending', 'no'),
(17, 1, 1, 1, '2023-03-10', '10:00:00', 'confirmed', 'Focus on upper body'),
(18, 1, 3, 2, '2023-03-15', '17:00:00', 'pending', 'Yoga class'),
(19, 2, 2, 3, '2023-03-12', '14:00:00', 'confirmed', 'Progress tracking session'),
(20, 1, 1, NULL, '2025-09-02', '10:30:00', 'pending', 'no'),
(21, 1, 1, NULL, '2025-09-02', '10:30:00', 'pending', 'no'),
(22, 3, 2, NULL, '2025-09-02', '10:30:00', 'pending', 'no'),
(23, 4, 1, NULL, '2025-09-02', '10:30:00', 'pending', 'no'),
(24, 5, 2, NULL, '2025-09-02', '10:30:00', 'pending', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `access_days_per_week` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `name`, `description`, `price`, `duration_days`, `access_days_per_week`) VALUES
(1, 'Student Plan', '3 Days/Week Access, Group Training Only, Access to Cardio & Weights', '4000.00', 30, 3),
(2, 'Gold Plan', '5 Days/Week Access, Monthly Trainer Session, Full Facility Use', '7000.00', 30, 5),
(3, 'Platinum Plan', 'Unlimited Access, Personal Training, Monthly Progress Check', '10000.00', 30, 7);

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `body_fat_percentage` decimal(5,2) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `user_id`, `date`, `weight`, `height`, `body_fat_percentage`, `notes`) VALUES
(1, 1, '2003-02-05', '84.00', '175.00', '25.00', 'very fat'),
(3, 4, '2025-09-02', '85.00', '180.00', '25.00', 'My doctor said control the food'),
(4, 5, '2025-09-02', '85.00', '180.00', '25.00', 'my doctor said control the food');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `duration_minutes`, `price`) VALUES
(1, 'Personal Training', 'Get customized workout plans and one-on-one guidance from certified fitness trainers.', 60, '1500.00'),
(2, 'Progress Tracking', 'Track your workouts, steps, and calories through our online dashboard with real-time graphs.', 30, '500.00'),
(3, 'Group Classes', 'Join fun and motivating sessions like Zumba, Yoga, and Bootcamp led by professional instructors.', 45, '800.00'),
(4, 'Nutrition Advice', 'Learn how to eat right with help from our expert diet plans and healthy eating guidelines.', 60, '1200.00');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `first_name`, `last_name`, `email`, `specialization`, `bio`) VALUES
(1, 'John', 'Doe', 'john.doe@icbtkandy.edu.lk', 'Strength Training', 'Certified personal trainer with 5+ years of experience in strength training and bodybuilding.'),
(2, 'Jane', 'Smith', 'jane.smith@icbtkandy.edu.lk', 'Yoga & Pilates', 'Expert in yoga and pilates with a focus on flexibility and mindfulness.'),
(3, 'Mike', 'Johnson', 'mike.johnson@icbtkandy.edu.lk', 'Cardio & Weight Loss', 'Specialized in cardio workouts and weight loss programs.');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_services`
--

CREATE TABLE `trainer_services` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('student','staff','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `role`, `created_at`) VALUES
(1, '11111111111111111', 'johncena1@gmail.com', '$2y$10$yM7tHhqIoHuyfSwdMUPQhe3qmmC0yxN9foU3FjHdOojufW/BOidu.', 'john', 'cena', '0751111111', 'student', '2025-08-29 18:42:52'),
(2, '12345', 'menakaba@gmail.com', '$2y$10$ebH/L9UtalDh8yVu421wZOhk1XU/EboKQNRCM8r08JaOOYKuxpt1C', 'menaka', 'ba', '0111111111', 'student', '2025-08-31 02:43:22'),
(3, '12345678', 'menakanawarathne@gmail.com', '$2y$10$KtIWYaTT1wTzxjoyE1UCCewSAKSRRSOspTS91tuKyB0r0085Iyuna', 'menaka', 'nawarathne', '0701111111', 'student', '2025-08-31 06:13:24'),
(4, '1030870', 'menakanawarathne2@gmail.com', '$2y$10$bnqY4xIkpOQuuvPYdg9fce/wlqi.wvlg8RuD/QW7JiGQEyWJBCqDG', 'menaka', 'nawarathne2', '0701234567', 'student', '2025-08-31 06:36:42'),
(5, '1030875', 'menakanawarathne3@gmail.com', '$2y$10$ihZVZ0BPL/LD8T./dIhajObNo6fYTPcwkWvHN/E4gCjTnBBqhLCG6', 'menaka', 'nawarathne3', '0691234567', 'student', '2025-08-31 08:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE `user_memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired','cancelled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `trainer_services`
--
ALTER TABLE `trainer_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trainer_services`
--
ALTER TABLE `trainer_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_memberships`
--
ALTER TABLE `user_memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `trainer_services`
--
ALTER TABLE `trainer_services`
  ADD CONSTRAINT `trainer_services_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `trainer_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD CONSTRAINT `user_memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_memberships_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
