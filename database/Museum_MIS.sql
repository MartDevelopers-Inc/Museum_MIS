-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 07, 2021 at 01:53 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Museum_MIS`
--

-- --------------------------------------------------------

--
-- Table structure for table `accomodations`
--

CREATE TABLE `accomodations` (
  `accomodation_id` varchar(200) NOT NULL,
  `accomodation_user_id` varchar(200) DEFAULT NULL,
  `accomodation_check_indate` varchar(200) DEFAULT NULL,
  `accomodation_room_id` varchar(200) DEFAULT NULL,
  `accomodation_payment_status` varchar(200) DEFAULT NULL,
  `accomodation_check_out_date` varchar(200) DEFAULT NULL,
  `accomodation_created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accomodations`
--

INSERT INTO `accomodations` (`accomodation_id`, `accomodation_user_id`, `accomodation_check_indate`, `accomodation_room_id`, `accomodation_payment_status`, `accomodation_check_out_date`, `accomodation_created_at`) VALUES
('1a2cd11b573cb904a6ae4b685207936634d9f37aca', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2021-10-05', 'f353d6688af07998304842e655ff7a534b0865dd68', 'Paid', '2021-10-06', '2021-10-05 06:53:28.948628'),
('8f37e0207f308b060940b8c730cf9d9b2afe908982', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2021-10-05', '2d22e2a95183b7d24e479fbf4c8dd36b629ee16048', 'Paid', '2021-10-08', '2021-10-05 07:22:43.177749'),
('90e7e7bb2a629b51e4f0f924bc92feef398098676c', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2021-10-14', 'fb656d406989aad3222975886bc124bbe726e2d7c2', 'Paid', '2021-10-16', '2021-10-07 07:31:52.071853');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` varchar(200) NOT NULL,
  `event_details` longtext DEFAULT NULL,
  `event_date` varchar(200) DEFAULT NULL,
  `event_cost` varchar(200) DEFAULT NULL,
  `event_status` varchar(200) NOT NULL DEFAULT '0',
  `event_tickets` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_details`, `event_date`, `event_cost`, `event_status`, `event_tickets`) VALUES
('72d051bb3b51fecb904f4ddeaf4bdb2167dde6470b', 'Exclusive charity event for only 100 members.', '2021-10-05', '2500', 'Open', '100');

-- --------------------------------------------------------

--
-- Table structure for table `membership_packages`
--

CREATE TABLE `membership_packages` (
  `package_id` varchar(200) NOT NULL,
  `package_name` longtext DEFAULT NULL,
  `package_pricing` varchar(200) NOT NULL,
  `package_details` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membership_packages`
--

INSERT INTO `membership_packages` (`package_id`, `package_name`, `package_pricing`, `package_details`) VALUES
('1fe5837af6b5ce10bb93d1e25421e932b85c5a1748', 'Platinum ', '2500', 0x506c6174696e756d207061636b6167652069732074686520746f702072616e6b696e67206d656d62657273686970207061636b61676520696e206f7572206d757365756d206d656d62657273686970207061636b61676573206869657261726368792c2074686973207061636b61676520676976657320796f7520756e6c696d6974656420616e642066756c6c2061636365737320746f206d757365756d20666163696c697469657320616e6420756e6c696d6974656420646973636f756e7473206f6e207265736572766174696f6e7320616e6420726f6f6d20626f6f6b696e67732e20),
('931dc8d2ae72977609c7ca79ab0c985397e9483ea0', 'Gold', '1000', 0x476f6c64206d656d62657273686970207061636b61676520676976657320796f7520756e6c696d697465642061636365737320746f204d757365756d20666163696c697469657320616e64206d61737369766520646973636f756e7473206f6e20796f7572207265736572766174696f6e7320616e6420626f6f6b696e67732e0d0a),
('a1d438eb1a9248bee6d164a9550ea30ace608c2c6a', 'Silver', '500', 0x53696c76657220697320746865207365636f6e64207061636b61676520696e20746865206869657261636879206f66206d656d62657273686970207061636b616765732c20697420676976657320796f75206c696d697465642061636365737320746f20746865204d757365756d20666163696c697469657320616e64206d61737369766520646973636f756e7473206f6e20796f757220626f6f6b696e677320616e64207265736572766174696f6e732e),
('ae8418b998e520fe8dd77ae01e0eb49ffde683f522', 'Bronze', '250', 0x42726f6e7a65206d656d62657273686970207061636b61676520697320746865206c6f77657374207061636b6167652c20697420676976657320796f75206c696d697465642061636365737320616e6420646973636f756e74732e2054686973206d656d62657273686970207061636b6167652069732073756974656420666f72206576657279206f6e652e);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(200) NOT NULL,
  `notification_user_id` varchar(200) DEFAULT NULL,
  `notification_title` longtext DEFAULT NULL,
  `notification_details` longtext DEFAULT NULL,
  `notification_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(200) NOT NULL,
  `payment_user_id` varchar(200) NOT NULL,
  `payment_amount` varchar(200) NOT NULL,
  `payment_confirmation_code` varchar(200) NOT NULL,
  `payment_service_paid_id` varchar(200) NOT NULL,
  `payment_created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_user_id`, `payment_amount`, `payment_confirmation_code`, `payment_service_paid_id`, `payment_created_at`) VALUES
('02afb3f6e7264fc36b02ee4cb019f1c6e2854c6889', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', 'I4O57YKJWB', '5eb14377f7892057fafad4b54d3d897a810f0d804e', '2021-10-07 09:53:48.188769'),
('030feb6f07ee7ef839bae1114028ce06eaf157eca5', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', '0NYAIKL2XU', '95b4e7766fdf3ef846979039b66f25202b4ee1dac0', '2021-10-07 09:56:22.746645'),
('30eac514663136baf5b4cb0365b8b7de776f763aee', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', '06D2WM5ISJ', '7db891bdd2d24c6df4e6ac1444f2fbf1df2ce6d4e9', '2021-10-07 09:46:26.836127'),
('385ffcbc16dbe8e1d35d63d7cab3d10e4d01aa86d7', 'be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', '1000', '93GEAV1M2F', '2', '2021-10-07 07:31:03.978132'),
('7c860c13dc64e14662835744b6f8703eb9031a2566', 'be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', '2000', 'U6BO5TNLMR', '06e9ad19de814c7777fe0b58ea0fd31610af625998', '2021-10-05 06:40:43.203354'),
('8aec5bf858f7ca18126c1c47400e4d64406b1e7a9c', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '1000', 'OBVK0C98Y1', '1', '2021-10-07 07:01:14.696946'),
('8ff434ac9d1686200b1ba5196105492ff7f0baad16', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', 'ZKX7HFB2L1', '67fcd610b39e4475a277ef790836bea127ac7cbe0a', '2021-10-06 02:45:28.328809'),
('95c3744ff73718f8123bbc96c1cbc610ea6c8fd3d4', 'be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', '2500', 'DJONT3FX91', 'd21032dcd64cc6990da402c30bb0e7e2094c478189', '2021-10-06 02:45:37.674397'),
('a679479bbc38e956bcad2b8f8ab6b79967a7e5126c', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', '6T4HWBLAUM', 'ca84ece590c16fbc98c1184a6f3880bc946362338a', '2021-10-07 09:55:47.560930'),
('aeb46d2de740fabe5639ba15db447c671530829a30', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2500', 'Y1RAHX58UI', '64526406f22bc20b9f3f185c53d4dcf400cc68ca2a', '2021-10-07 09:56:13.850165'),
('aecb9ed8cbadd8ab4451f16024b50842d526ef8362', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '21000', 'KN1U50VBI2', '90e7e7bb2a629b51e4f0f924bc92feef398098676c', '2021-10-07 07:31:52.015924'),
('d71793d5ffac0098fa1d21fb2eb8369afe70834ea6', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2000', 'DCOT25SPRI', '1e5db4232fffe2ea26f3ff083e3aedbad4d960fd45', '2021-10-05 06:38:48.709633'),
('f3b30b0289edd1b203035fee909a1df93d0624938f', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '7500', '1RSZEA2QFP', '8f37e0207f308b060940b8c730cf9d9b2afe908982', '2021-10-05 07:22:42.866061');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` varchar(200) NOT NULL,
  `reservation_user_id` varchar(200) DEFAULT NULL,
  `reservation_date` varchar(200) DEFAULT NULL,
  `reservation_details` longtext DEFAULT NULL,
  `reservation_payment_status` varchar(200) DEFAULT NULL,
  `reservation_status` varchar(200) NOT NULL DEFAULT 'Pending',
  `reservation_created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `reservation_user_id`, `reservation_date`, `reservation_details`, `reservation_payment_status`, `reservation_status`, `reservation_created_at`) VALUES
('06e9ad19de814c7777fe0b58ea0fd31610af625998', 'be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', '2021-10-11', '    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Paid', 'Approved', '2021-10-05 06:40:43.284972'),
('1e5db4232fffe2ea26f3ff083e3aedbad4d960fd45', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '2021-09-27', '    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Paid', 'Approved', '2021-10-05 06:38:56.957750');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` varchar(200) NOT NULL,
  `room_number` varchar(200) DEFAULT NULL,
  `room_type` longtext DEFAULT NULL,
  `room_status` varchar(200) NOT NULL DEFAULT 'Vacant',
  `room_rate` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_type`, `room_status`, `room_rate`) VALUES
('2d22e2a95183b7d24e479fbf4c8dd36b629ee16048', 'RM-86529 ', 'Single', 'Occupied', '2500'),
('4e139e2c74fb7db2e7da8375ab4f1e9314b27eea3c', 'RM-51829 ', 'Double', 'Vacant', '4500'),
('f353d6688af07998304842e655ff7a534b0865dd68', 'RM-41839 ', 'Single', 'Occupied', '5500'),
('fb656d406989aad3222975886bc124bbe726e2d7c2', 'RM-75260 ', 'Presidential Suite', 'Occupied', '10500');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(20) NOT NULL,
  `name` longtext DEFAULT NULL,
  `tagline` longtext DEFAULT NULL,
  `logo` longtext DEFAULT NULL,
  `mailer_host` varchar(200) DEFAULT NULL,
  `mailer_username` varchar(200) DEFAULT NULL,
  `mailer_from_email` varchar(200) DEFAULT NULL,
  `mailer_password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `tagline`, `logo`, `mailer_host`, `mailer_username`, `mailer_from_email`, `mailer_password`) VALUES
(1, 'Kitale Museum', 'Preserving Kenyan`s natural and cultural heritage', NULL, 'smtp.gmail.com', 'martdevelopers254@gmail.com', 'martdevelopers254@gmail.com', '0704031263');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` varchar(200) NOT NULL,
  `ticket_user_id` varchar(200) DEFAULT NULL,
  `ticket_event_id` varchar(200) DEFAULT NULL,
  `ticket_payment_status` varchar(200) DEFAULT NULL,
  `ticket_status` varchar(200) DEFAULT NULL,
  `ticket_purchased_on` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `ticket_user_id`, `ticket_event_id`, `ticket_payment_status`, `ticket_status`, `ticket_purchased_on`) VALUES
('64526406f22bc20b9f3f185c53d4dcf400cc68ca2a', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '72d051bb3b51fecb904f4ddeaf4bdb2167dde6470b', 'Paid', NULL, 'Oct,07 2021'),
('95b4e7766fdf3ef846979039b66f25202b4ee1dac0', '23e3dd4f5e406a18417bd5daff155338a38e18149a', '72d051bb3b51fecb904f4ddeaf4bdb2167dde6470b', 'Paid', NULL, 'Oct,07 2021');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(200) NOT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `user_phone` varchar(200) DEFAULT NULL,
  `user_idno` varchar(200) DEFAULT NULL,
  `user_email` varchar(200) DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_profile_pic` varchar(200) DEFAULT NULL,
  `user_access_level` varchar(200) DEFAULT NULL,
  `user_created_on` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_idno`, `user_email`, `user_password`, `user_profile_pic`, `user_access_level`, `user_created_on`) VALUES
('23e3dd4f5e406a18417bd5daff155338a38e18149a', 'Doe James Jane', '90012849123', '390813841', 'doejane90039@gmail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', NULL, 'Member', '01, Oct 2021'),
('be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', 'Jasmine Doe', '087654523', '234541312', '90jasmine@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', NULL, 'Member', '01, Oct 2021'),
('c76edb38f08fed2e522c62c1061cd7b4216add1709', 'James Doe', '071001289', '1909093', 'jamesdoe@gmail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', NULL, 'Staff', '01, Oct 2021'),
('ffbc610e0d2e31c8485ef5a07251241c513d14b09c', 'System Admin', '9010090', '23467890', 'sysadmin@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', NULL, 'Administrator', '28 Sep 2021');

-- --------------------------------------------------------

--
-- Table structure for table `user_membership_package`
--

CREATE TABLE `user_membership_package` (
  `user_membership_package_id` int(200) NOT NULL,
  `user_membership_package_user_id` varchar(200) DEFAULT NULL,
  `user_membership_package_package_id` varchar(200) DEFAULT NULL,
  `user_membership_package_payment_status` varchar(200) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_membership_package`
--

INSERT INTO `user_membership_package` (`user_membership_package_id`, `user_membership_package_user_id`, `user_membership_package_package_id`, `user_membership_package_payment_status`) VALUES
(1, '23e3dd4f5e406a18417bd5daff155338a38e18149a', '931dc8d2ae72977609c7ca79ab0c985397e9483ea0', 'Paid'),
(2, 'be9b00804dc1f53501f126c90dbd37c4d3c6e9983d', '931dc8d2ae72977609c7ca79ab0c985397e9483ea0', 'Paid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accomodations`
--
ALTER TABLE `accomodations`
  ADD PRIMARY KEY (`accomodation_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `membership_packages`
--
ALTER TABLE `membership_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_membership_package`
--
ALTER TABLE `user_membership_package`
  ADD PRIMARY KEY (`user_membership_package_id`),
  ADD KEY `Membership` (`user_membership_package_user_id`),
  ADD KEY `Package` (`user_membership_package_package_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_membership_package`
--
ALTER TABLE `user_membership_package`
  MODIFY `user_membership_package_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_membership_package`
--
ALTER TABLE `user_membership_package`
  ADD CONSTRAINT `Membership` FOREIGN KEY (`user_membership_package_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Package` FOREIGN KEY (`user_membership_package_package_id`) REFERENCES `membership_packages` (`package_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
