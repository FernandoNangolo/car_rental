-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15-Jul-2024 às 19:34
-- Versão do servidor: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `manufacturer` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `registration_plate` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `fuel_type` varchar(20) DEFAULT NULL,
  `transmission` varchar(20) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `photo` varchar(600) DEFAULT NULL,
  `description` text,
  `status` enum('available','rented') DEFAULT 'available',
  `rented_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cars`
--

INSERT INTO `cars` (`id`, `manufacturer`, `brand`, `model`, `registration_plate`, `type`, `fuel_type`, `transmission`, `mileage`, `photo`, `description`, `status`, `rented_by`) VALUES
(190, 'Honda', 'Civic', '2022', 'DEF456', 'Sedan', 'Petrol', 'Automatic', 10000, 'honda_civic.jpg', 'A reliable and fuel-efficient car.', 'available', NULL),
(191, 'Ford', 'Mustang', '2023', 'GHI789', 'Coupe', 'Petrol', 'Manual', 500, 'ford_mustang.jpg', 'A powerful and stylish sports car.', 'available', NULL),
(192, 'Chevrolet', 'Impala', '2021', 'JKL012', 'Sedan', 'Petrol', 'Automatic', 15000, 'chevrolet_impala.jpg', 'A spacious and comfortable sedan.', 'available', NULL),
(193, 'Tesla', 'Model 3', '2023', 'MNO345', 'Sedan', 'Electric', 'Automatic', 3000, 'tesla_model_3.jpg', 'An electric car with advanced features.', 'available', NULL),
(194, 'BMW', 'X5', '2022', 'PQR678', 'SUV', 'Diesel', 'Automatic', 8000, 'bmw_x5.jpg', 'A luxury SUV with great performance.', 'available', NULL),
(195, 'Audi', 'A4', '2023', 'STU901', 'Sedan', 'Petrol', 'Automatic', 4000, 'audi_a4.jpg', 'A premium sedan with a sleek design.', 'available', NULL),
(196, 'Mercedes-Benz', 'C-Class', '2022', 'VWX234', 'Sedan', 'Petrol', 'Automatic', 6000, 'mercedes_c_class.jpg', 'A high-end sedan with top-notch features.', 'available', NULL),
(197, 'Nissan', 'Leaf', '2023', 'YZA567', 'Hatchback', 'Electric', 'Automatic', 2000, 'nissan_leaf.jpg', 'An eco-friendly electric car.', 'available', NULL),
(198, 'Hyundai', 'Tucson', '2022', 'BCD890', 'SUV', 'Petrol', 'Automatic', 9000, 'hyundai_tucson.jpg', 'A versatile and spacious SUV.', 'available', NULL),
(199, 'Kia', 'Sorento', '2023', 'EFG123', 'SUV', 'Petrol', 'Automatic', 1000, 'kia_sorento.jpg', 'A stylish and comfortable SUV.', 'available', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rental_history`
--

CREATE TABLE `rental_history` (
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'fernando', 'fer'),
(3, 'nangolo', 'nan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rented_by` (`rented_by`);

--
-- Indexes for table `rental_history`
--
ALTER TABLE `rental_history`
  ADD PRIMARY KEY (`car_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`rented_by`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `rental_history`
--
ALTER TABLE `rental_history`
  ADD CONSTRAINT `rental_history_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
