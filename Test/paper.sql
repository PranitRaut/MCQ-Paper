-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 12:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paper`
--

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `exam_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `batch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `teacher_id`, `exam_name`, `exam_description`, `created_at`, `batch`) VALUES
(1, 2, 'Maths', 'Practice exam', '2024-11-16 10:26:46', '10th/B'),
(2, 2, 'English', 'Grammer test', '2024-11-16 10:27:12', '9th/A'),
(3, 3, 'Computer', 'Practice Exam', '2024-11-18 05:58:24', '9th/A'),
(4, 4, 'History', 'Mock test', '2024-11-19 10:13:50', '10th/B'),
(5, 4, 'Science', 'Basic Exam', '2024-11-19 10:16:41', '9th/A');

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `attempt_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `questions_answered` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_attempts`
--

INSERT INTO `exam_attempts` (`id`, `student_id`, `exam_id`, `score`, `attempt_date`, `questions_answered`) VALUES
(1, 1, 1, 3, '2024-11-16 10:58:46', '{\"1\":\"A\",\"2\":\"C\",\"3\":\"C\"}'),
(2, 2, 2, 5, '2024-11-18 06:06:49', '{\"6\":\"C\",\"7\":\"B\",\"8\":\"C\",\"9\":\"B\",\"10\":\"A\"}'),
(3, 2, 3, 4, '2024-11-18 06:19:55', '{\"11\":\"C\",\"12\":\"B\",\"13\":\"D\",\"14\":\"A\",\"15\":\"B\"}'),
(4, 3, 1, 5, '2024-11-19 10:08:04', '{\"1\":\"A\",\"2\":\"C\",\"3\":\"C\",\"4\":\"B\",\"5\":\"B\"}'),
(5, 1, 4, 5, '2024-11-19 10:51:10', '{\"17\":\"A\",\"18\":\"C\",\"19\":\"B\",\"20\":\"C\",\"21\":\"B\"}'),
(6, 2, 5, 4, '2024-11-19 11:12:51', '{\"22\":\"C\",\"23\":\"D\",\"24\":\"B\",\"26\":\"A\",\"27\":\"A\"}');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 1, 'What is the square root of 144?\r\n', '12', '14', '16', '18', 'A'),
(2, 1, 'What is 15+28?', '40', '42', '43', '45', 'C'),
(3, 1, 'What is 7×8?', '49', '54', '56', '59', 'C'),
(4, 1, 'What is the sum of the angles in a triangle?', '90°', '180°', '270°', '360°', 'B'),
(5, 1, 'Which of the following is a multiple of 6?', '20', '36', '46', '55', 'B'),
(6, 2, 'Identify the correct form of the verb in this sentence: \r\n\"She ___ to the market yesterday.\"\r\n', 'Go', 'Goes', 'Went', 'Gone', 'C'),
(7, 2, 'Choose the correct sentence:', 'He don’t like coffee.', 'He doesn’t like coffee.', 'He didn’t liked coffee.', 'He doesn’t likes coffee.', 'B'),
(8, 2, 'What is the correct plural form of \"child\"?', ' Childs', ' Childes', 'Children', 'Childrens', 'C'),
(9, 2, 'Choose the correct form of the adjective: \r\n\"This book is ___ than the one I read last week.\"\r\n', 'Good', 'Better', 'Best', 'More Better', 'B'),
(10, 2, 'What is the correct tense for the sentence: \r\n\"I ___ him yesterday.\"', 'saw', 'see', 'seen', 'sees', 'A'),
(11, 3, 'Which of the following is an input device?', 'Printer ', 'Monitor', 'Keyboard', 'Speaker', 'C'),
(12, 3, ' What does the \"Save\" button do in a computer program?\r\n', 'It deletes the file ', 'It stores the document ', 'It opens a file ', 'It prints the file', 'B'),
(13, 3, 'What is the function of the \"mouse\" in a computer?', 'To display text on the screen ', 'To store files and folders', 'To generate sound', 'To move the cursor and interact with objects', 'D'),
(14, 3, 'What is the full form of \"USB\"?', 'Universal Serial Bus ', 'Universal Software Bus', ' United States Bus ', 'Universal System Bus', 'A'),
(15, 3, 'Which of the following is a popular search engine?', 'Windows 10 ', 'PowerPoint ', 'Google', 'Excel', 'C'),
(17, 4, 'What was the name of Shivaji Maharaj mother?', ' Jijabai ', ' Rani Lakshmi ', 'Rajmata', 'Durga Bai', 'A'),
(18, 4, 'Which fort was Shivaji Maharaj first major victory?', 'Sinhagad ', 'Raigad', 'Torna', 'Agra', 'C'),
(19, 4, 'What was the title given to Shivaji Maharaj?', ' Samrat ', 'Chhatrapati', 'Maharaja', 'Emperor', 'B'),
(20, 4, 'Where was Shivaji Maharaj crowned as the Chhatrapati?', 'Rajgad ', 'Pune', 'Raigad', 'Mumbai', 'C'),
(21, 4, 'Who was Shivaji Maharaj?', ' A King of England ', 'A great warrior and king of Maratha', 'A famous scientist ', 'A poet', 'B'),
(22, 5, 'What is the boiling point of water?', ' 0°C ', '50°C', '100°C', '200°C', 'C'),
(23, 5, 'Which part of the plant conducts photosynthesis?', 'Roots ', 'Stem', 'Flowers', 'Leaves', 'D'),
(24, 5, 'Which of the following is a solid?', ' Water ', 'Ice', 'Steam', 'Air', 'B'),
(26, 5, 'Which of the following is a planet closest to the Sun?', 'Earth', 'Mars', 'Mercury', 'Venus ', 'C'),
(27, 5, 'What gas do we breathe in that is necessary for life?', 'Oxygen', 'Carbon dioxide ', 'Nitrogen', 'Hydrogen', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `batch` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `batch`) VALUES
(1, 'joy', 'joy@11', '$2y$10$DTa.EIzImDUGW3wwQUeqneCQh6ApjQXG9oVzfoSERlnbz35uQmYDi', '10th/B'),
(2, 'John', 'john@33', '$2y$10$Cl80vkEhR8TC7KNXpun.Le.pCY2WHj2oon0OXaCv6rsxwUOO/6GEG', '9th/A'),
(3, 'jerry', 'jerry@111', '$2y$10$GanArgts2uMqOXQqPt5vH.hBjW5J.AWmrPngfgGoeWEYgeFiDhnyO', '10th/B');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

--
-- {admin pass= 1234567}     {teacher pass = 123456}   {student pass= 12345}
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Roy', 'roy@11', '$2y$10$aq2ob175EZ3Q1q311j5pFuezQldaY1bgIAYnCYs/lUfwp57b/gjRG', 'admin', '2024-11-15 06:57:00'),
(2, 'Jack', 'jack@22', '$2y$10$xtPsQ55AHa.URyAZVLVCwOYPQBwhwGpoCuRV6F9PSdL2/ilKaLM.K', 'teacher', '2024-11-15 06:58:23'),
(3, 'smith', 'smith@55', '$2y$10$kA170dBiqTbgR49XATYeUePTJIYFfedzmqshJxfDM6oXV3d2/Wqby', 'teacher', '2024-11-18 05:44:46'),
(4, 'Brown', 'brown@88', '$2y$10$nMijGLFdgmxVJfeHSjB9MeuofiEiYWAo0TvuIYBkxLgH351N2EGia', 'teacher', '2024-11-19 10:09:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD CONSTRAINT `exam_attempts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `exam_attempts_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
