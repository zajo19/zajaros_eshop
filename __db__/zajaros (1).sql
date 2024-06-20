-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 11:19 PM
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
-- Database: `zajaros`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_kategorie`
--

CREATE TABLE `t_kategorie` (
  `id` int(100) NOT NULL,
  `nazov` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kategorie`
--

INSERT INTO `t_kategorie` (`id`, `nazov`) VALUES
(1, 'Helma'),
(2, 'Chrániče'),
(3, 'Rukavice'),
(4, 'Hokejka'),
(5, 'Bránka'),
(6, 'Puk');

-- --------------------------------------------------------

--
-- Table structure for table `t_produkty`
--

CREATE TABLE `t_produkty` (
  `ID` int(100) NOT NULL,
  `nazov` varchar(255) DEFAULT NULL,
  `znacka` varchar(255) DEFAULT NULL,
  `popis` text DEFAULT NULL,
  `cena` double(10,2) DEFAULT NULL,
  `mnozstvo` int(100) DEFAULT NULL,
  `kategorie` char(100) DEFAULT NULL,
  `obrazok` varchar(255) DEFAULT NULL,
  `kategoria_id` int(100) DEFAULT NULL,
  `t_kategorie` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_produkty`
--

INSERT INTO `t_produkty` (`ID`, `nazov`, `znacka`, `popis`, `cena`, `mnozstvo`, `kategorie`, `obrazok`, `kategoria_id`, `t_kategorie`) VALUES
(1, 'Hokejová Helma Bauer RE-AKT 150', 'Bauer', 'Prémiová helma s modernou ochranou proti nárazom', 149.99, 20, 'Helma', '[URL k obrázku helmy]', 1, 0),
(2, 'Hokejové Chrániče Ramien CCM Jetspeed FTW', 'CCM', 'Ľahké a pohodlné chrániče ramien s vynikajúcou ochranou', 109.99, 15, 'Chrániče', '[URL k obrázku chráničov]', 2, 0),
(3, 'Hokejové Rukavice Warrior Alpha DX', 'Warrior', 'Profesionálne rukavice s maximálnou flexibilitou a ochranou', 129.99, 10, 'Rukavice', '[URL k obrázku rukavíc]', 3, 0),
(4, 'Hokejka Bauer Vapor FlyLite', 'Bauer', 'Ultra ľahká hokejka pre maximálny výkon', 199.99, 25, 'Hokejka', '[URL k obrázku hokejky]', 4, 0),
(5, 'Hokejová Bránka Winnwell 72\"', 'Winnwell', 'Profesionálna hokejová bránka s pevnou konštrukciou', 249.99, 5, 'Bránka', '[URL k obrázku bránky]', 5, 0),
(6, 'Hokejový Puk A&R Black', 'A&R', 'Štandardný hokejový puk pre tréning a zápasy', 2.99, 100, 'Puk', '[URL k obrázku puku]', 6, 0),
(7, 'Hokejové Chrániče Nôh Bauer Supreme 2S Pro', 'Bauer', 'Vysoko odolné chrániče nôh s maximálnou ochranou a komfortom', 129.99, 12, 'Chrániče', '[URL k obrázku chráničov nôh]', 2, 0),
(8, 'Hokejová Prilba CCM Tacks 710', 'CCM', 'Prilba s dokonalým prispôsobením a ochranou proti nárazom', 179.99, 18, 'Helma', '[URL k obrázku prilby]', 1, 0),
(9, 'Hokejové Rukavice Bauer Nexus 2N', 'Bauer', 'Rukavice so skvelou ochranou a pohodlným strihom', 139.99, 14, 'Rukavice', '[URL k obrázku rukavíc]', 3, 0),
(10, 'Hokejka CCM Ribcor Trigger 5 Pro', 'CCM', 'Hokejka s vynikajúcim výkonom a rýchlym uvoľnením puku', 219.99, 20, 'Hokejka', '[URL k obrázku hokejky]', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `ID` bigint(20) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_kategorie`
--
ALTER TABLE `t_kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_produkty`
--
ALTER TABLE `t_produkty`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_kategorie`
--
ALTER TABLE `t_kategorie`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_produkty`
--
ALTER TABLE `t_produkty`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
