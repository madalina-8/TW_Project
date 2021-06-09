-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 09, 2021 la 08:33 AM
-- Versiune server: 10.4.18-MariaDB
-- Versiune PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `project`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `modify_status1`
--

CREATE TABLE `modify_status1` (
  `id` int(11) NOT NULL,
  `Field` varchar(100) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `modify_status1`
--

INSERT INTO `modify_status1` (`id`, `Field`, `Status`) VALUES
(1, 'Year', 1),
(2, 'Sex', 1),
(3, 'Country', 1),
(4, 'Region', 1);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `modify_status1`
--
ALTER TABLE `modify_status1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `modify_status1`
--
ALTER TABLE `modify_status1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
