-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2022 at 09:12 AM
-- Server version: 5.7.37-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usersystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announce` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announce`) VALUES
('We have a new timesheet system!');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(20) NOT NULL,
  `status` int(1) DEFAULT NULL COMMENT '0 = clocked out and 1 = clocked in',
  `timeInfo` time DEFAULT NULL,
  `dateInfo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `status`, `timeInfo`, `dateInfo`) VALUES
(19, 0, '13:37:08', '2022-04-13'),
(22, 0, '15:09:28', '2022-04-05'),
(24, 0, '16:36:27', '2022-04-05'),
(32, 0, NULL, NULL),
(34, 0, '18:59:50', '2022-04-02'),
(36, 0, '20:20:49', '2022-04-13'),
(38, 0, NULL, NULL),
(40, 0, NULL, NULL),
(41, 0, '12:59:59', '2022-04-06'),
(42, 0, '12:58:21', '2022-04-06'),
(45, 0, '12:59:39', '2022-04-06'),
(46, 0, '13:00:21', '2022-04-06'),
(47, 0, NULL, NULL),
(48, 0, '12:59:39', '2022-04-06'),
(49, 0, NULL, NULL),
(51, 0, NULL, NULL),
(52, 0, NULL, NULL),
(53, 0, NULL, NULL),
(54, 0, NULL, NULL),
(55, 0, '14:17:01', '2022-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `emp_time_off`
--

CREATE TABLE `emp_time_off` (
  `request_id` int(20) NOT NULL,
  `id` int(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `startingdate` date NOT NULL,
  `endingdate` date NOT NULL,
  `leavetype` varchar(15) NOT NULL,
  `notes` varchar(250) NOT NULL,
  `status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_time_off`
--

INSERT INTO `emp_time_off` (`request_id`, `id`, `firstname`, `lastname`, `startingdate`, `endingdate`, `leavetype`, `notes`, `status`) VALUES
(110, 34, 'Dilkhush', 'D', '2022-04-27', '2022-04-28', 'SE', '', 'D'),
(113, 42, 'reid', 'anderson', '2022-04-27', '2022-11-30', 'LOA', 'i need a longer break !!!!!!!!!!!!', 'P'),
(114, 46, 'isaac', 'user', '2022-04-12', '2022-04-14', 'V', 'I wanna party', 'D'),
(115, 45, 'deb', 'warren', '2022-04-29', '2022-04-30', 'S', 'feeling ill', 'A'),
(117, 41, 'Vanessa', 'D', '2022-05-07', '2022-06-24', 'V', '', 'A'),
(119, 46, 'isaac', 'user', '2022-04-19', '2022-04-22', 'S', 'yaya', 'P'),
(121, 36, 'Bob', 'McBobby', '2022-04-15', '2022-04-17', 'SE', 'jjj', 'A'),
(124, 19, 'Ryan', 'O', '2022-04-14', '2022-04-16', 'V', 'test123', 'A'),
(125, 36, 'Bob', 'McBobby', '2022-04-25', '2022-04-30', 'V', 'test1234567890', 'D'),
(126, 22, 'Rao', 'F', '2022-04-14', '2022-04-15', 'V', '', 'P'),
(127, 22, 'Rao', 'F', '2022-04-16', '2022-04-17', 'SE', '123', 'D'),
(128, 22, 'Rao', 'F', '2022-04-18', '2022-04-19', 'OT', '1.5h', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `holiday` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`holiday`) VALUES
(' New Year&#039;s Day - Mon, Jan 3, 2022'),
('Family Day - Mon, Feb 21, 2022'),
('Good Friday - Fri, Apr 15, 2022'),
('Victoria Day - Mon, May 23, 2022'),
('Canada Day - Fri, Jul 1, 2022'),
(' British Columbia Day - Mon, Aug 1, 2022');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `shift` varchar(15) NOT NULL,
  `dateInfo` date NOT NULL,
  `empType` varchar(20) NOT NULL,
  `notes` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `firstname`, `lastname`, `shift`, `dateInfo`, `empType`, `notes`) VALUES
(19, 'Ryan', 'O', 'D', '2022-03-27', 'PsychSocial', 'D'),
(19, 'Ryan', 'O', 'N', '2022-03-31', 'PsychSocial', 'N'),
(19, 'Ryan', 'O', 'D', '2022-04-17', 'PsychSocial', 'D'),
(19, 'Ryan', 'O', 'N', '2022-04-21', 'PsychSocial', 'N'),
(19, 'Ryan', 'O', 'N', '2022-04-25', 'PsychSocial', 'N'),
(19, 'Ryan', 'O', 'N', '2022-04-29', 'PsychSocial', ''),
(22, 'Rao', 'F', 'D', '2022-03-27', 'RN', 'D'),
(22, 'Rao', 'F', 'N', '2022-03-31', 'RN', 'N'),
(22, 'Rao', 'F', 'D', '2022-04-06', 'RN', ''),
(22, 'Rao', 'F', 'H', '2022-04-10', 'RN', 'fdslakfjdlkfaj'),
(22, 'Rao', 'F', 'D', '2022-04-17', 'RN', 'D'),
(22, 'Rao', 'F', 'N', '2022-04-21', 'RN', 'N'),
(22, 'Rao', 'F', 'N', '2022-04-25', 'RN', 'N'),
(22, 'Rao', 'F', 'N', '2022-04-29', 'RN', 'N'),
(22, 'Rao', 'F', 'es', '2022-05-03', 'RN', ''),
(24, 'employee', 'E', 'D', '2022-03-27', 'Cook', 'D'),
(24, 'employee', 'E', 'N', '2022-03-31', 'Cook', 'N'),
(24, 'employee', 'E', 'D', '2022-04-17', 'Cook', 'D'),
(24, 'employee', 'E', 'N', '2022-04-21', 'Cook', 'N'),
(24, 'employee', 'E', 'N', '2022-04-25', 'Cook', 'N'),
(24, 'employee', 'E', 'N', '2022-04-29', 'Cook', ''),
(32, 'manager', 'M', 'D', '2022-03-27', 'RHCA', 'D'),
(32, 'manager', 'M', 'N', '2022-03-31', 'RHCA', 'N'),
(32, 'manager', 'M', 'D', '2022-04-06', 'RHCA', ''),
(32, 'manager', 'M', 'D', '2022-04-17', 'RHCA', 'D'),
(32, 'manager', 'M', 'N', '2022-04-21', 'RHCA', 'N'),
(32, 'manager', 'M', 'N', '2022-04-25', 'RHCA', 'N'),
(32, 'manager', 'M', 'N', '2022-04-29', 'RHCA', ''),
(34, 'Dilkhush', 'D', 'M', '2022-03-29', 'Maintenance', '123'),
(34, 'Dilkhush', 'D', 'N', '2022-03-31', 'Maintenance', 'N'),
(34, 'Dilkhush', 'D', 'D', '2022-04-17', 'Maintenance', 'it&#039;s'),
(34, 'Dilkhush', 'D', '', '2022-04-18', 'Maintenance', '.,:;?!@#$%&amp;()[]{}-+*/'),
(34, 'Dilkhush', 'D', 'N', '2022-04-21', 'Maintenance', 'N'),
(34, 'Dilkhush', 'D', 'N', '2022-04-25', 'Maintenance', 'N'),
(34, 'Dilkhush', 'D', 'H', '2022-04-27', 'Maintenance', 'hey'),
(34, 'Dilkhush', 'D', 'N', '2022-04-29', 'Maintenance', ''),
(36, 'Bob', 'McBobby', 'es', '2022-04-27', 'PsychSocial', 'test'),
(48, 'John', 'Smith', 'SE', '2022-04-07', 'RN', ''),
(48, 'John', 'Smith', 'es', '2022-04-18', 'RN', 'Test'),
(49, 'Nasa', 'Nap', 'N', '2022-04-07', 'RN', '');

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE `timesheet` (
  `id` int(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `dateInfo` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time DEFAULT NULL,
  `shift` varchar(5) NOT NULL,
  `lunch` varchar(3) DEFAULT NULL,
  `sick` double DEFAULT NULL,
  `vacation` double DEFAULT NULL,
  `regular` double DEFAULT NULL,
  `ot` double DEFAULT NULL,
  `notes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`id`, `firstname`, `lastname`, `dateInfo`, `timein`, `timeout`, `shift`, `lunch`, `sick`, `vacation`, `regular`, `ot`, `notes`) VALUES
(19, 'Ryan', 'O', '2022-04-13', '13:37:08', '13:37:13', 'C', 'No', 0, 0, 1, 0, 'fggf'),
(22, 'Rao', 'F', '2022-04-01', '05:30:16', '07:29:15', 'D', 'Yes', 1.1, 1, 7.8, 1.4, NULL),
(22, 'Rao', 'F', '2022-04-02', '07:20:18', '12:36:28', 'D', 'Yes', 0, 1, 7, 0, NULL),
(22, 'Rao', 'F', '2022-04-05', '15:09:28', '15:10:57', 'D', 'No', 0, 0, 8.9, 0, ''),
(22, 'Rao', 'F', '2022-04-15', '06:27:22', '17:36:36', 'D', 'Yes', 0, 1, 8.2, 1.4, NULL),
(22, 'Rao', 'F', '2022-04-16', '04:21:32', '15:38:33', 'D', 'Yes', 0, 1, 7, 0, NULL),
(24, 'employee', 'E', '2022-04-05', '16:36:27', '16:36:39', 'N', 'Yes', 0, 0, 8, 2.3, 'notes.'),
(34, 'Dilkhush', 'D', '2022-04-02', '18:57:34', '18:58:35', 'N', NULL, 0, 0, NULL, 0, NULL),
(34, 'Dilkhush', 'D', '2022-04-02', '18:59:50', '19:37:59', 'D', NULL, 0, 0, NULL, 0, NULL),
(36, 'Bob', 'McBobby', '2022-04-13', '13:40:53', '13:40:56', 'ds', 'No', 5.1, 0, 1, 0, 's'),
(36, 'Bob', 'McBobby', '2022-04-13', '20:20:49', '20:23:23', 'D', 'No', 0.1, 0, 1, 0, 'testing'),
(39, 'John', 'Smith', '2022-04-06', '12:22:14', '12:38:08', 'C', 'No', 0, 0, 1, 0, 'test'),
(41, 'Vanessa', 'D', '2022-04-06', '12:59:12', '12:59:48', 'D', 'Yes', 0, 0, 1, 0, ''),
(41, 'Vanessa', 'D', '2022-04-06', '12:59:59', '13:01:14', 'H', 'No', 0, 0, 5, 0, 'im hungry'),
(42, 'reid', 'anderson', '2022-04-06', '12:58:21', '13:00:39', 'M', NULL, 0, 0, NULL, 0, NULL),
(43, 'D', 'D', '2022-04-06', '12:58:38', '12:58:44', 'D', NULL, 0, 0, NULL, 0, NULL),
(45, 'deb', 'warren', '2022-04-06', '12:59:16', '12:59:21', 'D', NULL, 0, 0, NULL, 0, NULL),
(45, 'deb', 'warren', '2022-04-06', '12:59:39', '13:01:52', 'D', NULL, 0, 0, NULL, 0, NULL),
(46, 'isaac', 'user', '2022-04-06', '13:00:21', '13:01:04', 'N', NULL, 0, 0, NULL, 0, NULL),
(48, 'John', 'Smith', '2022-04-06', '12:59:39', '12:59:47', 'D', NULL, 0, 0, NULL, 0, NULL),
(50, 'afljaskljf', 'lkajdsfjal', '2022-04-06', '10:01:01', '13:02:02', 'H', 'Yes', 2, 5.56, 10, 3, ''),
(55, 'Lisa', 'Matthews', '2022-04-08', '14:17:01', '14:17:04', 'es', NULL, 0, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dateHired` date DEFAULT NULL,
  `empType` varchar(30) NOT NULL,
  `category` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `dateHired`, `empType`, `category`, `role`, `phone`, `password`) VALUES
(19, 'Ryan', 'O', 'ryan@ryanoberholtzer.com', '2022-03-02', 'PsychSocial', 'Regular', 'manager', '25043454333', '501e046640c72db5764953d828537770'),
(22, 'Rao', 'F', 'rao@rao.com', '2022-03-01', 'RN', 'Regular', 'manager', '2502221111', '44978a1316ed2a495d108b47badc18b9'),
(24, 'employee', 'E', 'employee@employee.com', '2022-02-27', 'Cook', 'Casual', 'employee', '2502222222', 'fa5473530e4d1a5a1e1eb53d2fedb10c'),
(32, 'manager', 'M', 'manager@manager.com', '2022-03-27', 'RHCA', 'Regular', 'manager', '2501111111', '1d0258c2440a8d19e716292b231e3190'),
(34, 'Dilkhush', 'D', 'dilkhush@dilkhush.com', '2022-03-02', 'Maintenance', 'Regular', 'manager', '2504444444', '7de33fccdc93716e92deccbb58ed729b'),
(36, 'Bob', 'McBobby', 'bob@gmail.com', '2022-03-31', 'PsychSocial', 'Casual', 'employee', '2504944333', '9f9d51bc70ef21ca5c14f307980a29d8'),
(38, 'Joe', 'McNice', 'joe@hotmail.com', '2022-03-29', 'RHCA', 'Casual', 'employee', '2509403444', '50d1b87fb44094fe7485bdd2b292f83c'),
(40, 'The Ultimate Ex', 'Cool Guy Swag Swaggi', 'theultimatecoolguyswag@gmail.com', '2022-04-08', 'PsychSocial', 'Regular', 'manager', '778 555 5555', 'b3e3f759b05b38302de5b418b8ef0897'),
(41, 'Vanessa', 'D', 'vd@email.com', '2022-04-08', 'Cook', 'Casual', 'employee', '000-000-000', 'f563eaae54b530aa2bac9fceeed5d3b8'),
(42, 'reid', 'anderson', 'randerson@gmail.com', '2022-04-06', 'Maintenance', 'Regular', 'employee', 'none of your', '7cc8f430a4e9076ca879ae0a32cd0ae2'),
(45, 'deb', 'warren', 'dwarren@okanagan.bc.ca', '2022-03-01', 'PsychSocial', 'Regular', 'employee', '4389', '0d107d09f5bbe40cade3de5c71e9e9b7'),
(46, 'isaac', 'user', 'user@user.user', '2022-04-04', 'Maintenance', 'Regular', 'employee', '5555555555', '0d107d09f5bbe40cade3de5c71e9e9b7'),
(47, 'nothing', 'else', 'feek_light@gmail.com', '2022-04-05', 'Cook', 'Regular', 'manager', '1234567892', '827ccb0eea8a706c4c34a16891f84e7b'),
(48, 'John', 'Smith', 'jsmith@test.com', '2022-04-06', 'RN', 'Regular', 'employee', '123456789', '0d107d09f5bbe40cade3de5c71e9e9b7'),
(49, 'Nasa', 'Nap', 'nasanap@hotmail.com', '2022-04-06', 'RN', 'Casual', 'employee', '1231231234', '202cb962ac59075b964b07152d234b70'),
(51, 'Sample', 'Test', 'sampletesing@gmail.com', '2022-04-13', 'Maintenance', 'Regular', 'manager', '5435434544', '9a4f76b199d762dfb861fe8614d88d90'),
(52, 'josh', 'josh', 'joshuapadronuy@gmail.com', '2022-04-11', 'RHCA', 'Regular', 'manager', '7785839552', 'f94adcc3ddda04a8f34928d862f404b4'),
(53, 'Natasha', 'N', 'nasanap@email.com', '2022-02-01', 'RHCA', 'Casual', 'manager', '1231231234', '202cb962ac59075b964b07152d234b70'),
(54, 'Zu', 'Kaboom', 'kaboom@live.ca', '2022-04-05', 'RHCA', 'Casual', 'employee', '2506554444', '202cb962ac59075b964b07152d234b70'),
(55, 'Lisa', 'Matthews', 'lisa@gmail.com', '2022-03-29', 'RHCA', 'Casual', 'manager', '2509993333', '202cb962ac59075b964b07152d234b70');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `users_attendance_delete` AFTER DELETE ON `users` FOR EACH ROW DELETE FROM attendance WHERE id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_attendance_insert` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO attendance (id, status) values (NEW.id, 0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_schedule_delete` AFTER DELETE ON `users` FOR EACH ROW DELETE FROM schedule WHERE id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_schedule_update` AFTER UPDATE ON `users` FOR EACH ROW UPDATE schedule SET firstname = NEW.firstname, lastname = NEW.lastname, empType = NEW.empType WHERE id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_timeoff_delete` AFTER DELETE ON `users` FOR EACH ROW DELETE FROM emp_time_off WHERE id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_timeoff_update` AFTER UPDATE ON `users` FOR EACH ROW UPDATE emp_time_off SET firstname = NEW.firstname, lastname = NEW.lastname WHERE id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_timesheet_update` AFTER UPDATE ON `users` FOR EACH ROW UPDATE timesheet SET firstname = NEW.firstname, lastname = NEW.lastname WHERE id = old.id
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announce`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_time_off`
--
ALTER TABLE `emp_time_off`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`,`dateInfo`);

--
-- Indexes for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`id`,`dateInfo`,`timein`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_time_off`
--
ALTER TABLE `emp_time_off`
  MODIFY `request_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
