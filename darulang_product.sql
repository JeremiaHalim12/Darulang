-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2022 at 09:07 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darulang_product`
--
CREATE DATABASE IF NOT EXISTS `darulang_product` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `darulang_product`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `amount`) VALUES(4, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES(1, 'Totebag');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `time` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `time`, `location`, `user_id`) VALUES(1, '2022-06-12', 'Jalan Moh Hata', 4);
INSERT INTO `order` (`id`, `time`, `location`, `user_id`) VALUES(2, '2022-06-12', 'Jalan Mystery no 17', 4);
INSERT INTO `order` (`id`, `time`, `location`, `user_id`) VALUES(9, '2022-11-18', 'asdsadasd', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_has_product`
--

DROP TABLE IF EXISTS `order_has_product`;
CREATE TABLE `order_has_product` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_has_product`
--

INSERT INTO `order_has_product` (`order_id`, `product_id`, `amount`) VALUES(1, 1, '2');
INSERT INTO `order_has_product` (`order_id`, `product_id`, `amount`) VALUES(2, 2, '3');
INSERT INTO `order_has_product` (`order_id`, `product_id`, `amount`) VALUES(9, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stock`, `image`, `category_id`) VALUES(1, 'Milk Carton Totebag', 259000, 9, 'Milk Carton Totebag.jpg', 1);
INSERT INTO `product` (`id`, `name`, `price`, `stock`, `image`, `category_id`) VALUES(2, 'Totebag', 159000, 20, 'Totebag.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(1, 'Admin', '0', 'Admin@email.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(2, 'User', '0', 'User@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '-');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(3, 'Frank', '081234561', 'frank@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(4, 'Jack', '081234562', 'jack@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(5, 'Brown', '081234563', 'brown@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(6, 'Kloop', '081234564', 'kloop@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(7, 'Hush', '081234565', 'hush@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(8, 'Dumb', '081234563', 'dumb@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(9, 'Tina', '081234564', 'tina@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(10, 'Dr Dru', '12345678', 'dru@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');
INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES(11, 'michael', '0812344789', 'michael@email.com', '827ccb0eea8a706c4c34a16891f84e7b', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `fk_cart_vegetables1_idx` (`product_id`),
  ADD KEY `fk_cart_user1` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_Order_User1_idx` (`user_id`);

--
-- Indexes for table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `fk_Order_has_Vegetables_Vegetables1_idx` (`product_id`),
  ADD KEY `fk_Order_has_Vegetables_Order1_idx` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Vegetables_Category_idx` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cart_vegetables1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_Order_User1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_Order_has_Vegetables_Order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Order_has_Vegetables_Vegetables1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_Vegetables_Category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
