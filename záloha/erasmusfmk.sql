-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 172.17.0.1:3306
-- Čas generovania: Sun 27.Mar 2022, 17:44
-- Verzia serveru: 8.0.25-15
-- Verzia PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `erasmusfmk`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `editovanie`
--

CREATE TABLE `editovanie` (
  `id` int NOT NULL,
  `skolsky_rok` int NOT NULL,
  `semester` enum('ZS','LS') NOT NULL,
  `zamknutie` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Sťahujem dáta pre tabuľku `editovanie`
--

INSERT INTO `editovanie` (`id`, `skolsky_rok`, `semester`, `zamknutie`) VALUES
(1, 2223, 'ZS', 0),
(2, 2223, 'LS', 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `skoly`
--

CREATE TABLE `skoly` (
  `id` int NOT NULL,
  `nazov` varchar(255) NOT NULL,
  `kapacita` int NOT NULL,
  `krajina` varchar(255) NOT NULL,
  `stav` tinyint(1) NOT NULL,
  `mk` tinyint(1) NOT NULL,
  `av` tinyint(1) NOT NULL,
  `md` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Sťahujem dáta pre tabuľku `skoly`
--

INSERT INTO `skoly` (`id`, `nazov`, `kapacita`, `krajina`, `stav`, `mk`, `av`, `md`) VALUES
(1, 'Škola 1', 2, 'Slovenská republika', 1, 1, 0, 0),
(2, 'Škola 2', 3, 'Portugalsko', 1, 0, 1, 1),
(3, 'Škola 3', 2, 'Rakúsko', 1, 0, 1, 0),
(4, 'Škola 4', 1, 'Dánsko', 1, 1, 0, 1),
(5, 'Škola 5', 2, 'Maďarsko', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `studenti`
--

CREATE TABLE `studenti` (
  `id` int NOT NULL,
  `meno` varchar(255) NOT NULL,
  `priezvisko` varchar(255) NOT NULL,
  `kod` varchar(100) NOT NULL,
  `skolsky_rok` int NOT NULL,
  `semester` enum('ZS','LS') NOT NULL,
  `priorita_1` int NOT NULL,
  `priorita_2` int DEFAULT NULL,
  `priorita_3` int DEFAULT NULL,
  `vybrana_skola` int DEFAULT NULL,
  `kategoria` enum('MK','AV','MD') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stav` tinyint(1) NOT NULL,
  `anglictina` float DEFAULT NULL,
  `priemer` float DEFAULT NULL,
  `poznamky` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Sťahujem dáta pre tabuľku `studenti`
--

INSERT INTO `studenti` (`id`, `meno`, `priezvisko`, `kod`, `skolsky_rok`, `semester`, `priorita_1`, `priorita_2`, `priorita_3`, `vybrana_skola`, `kategoria`, `stav`, `anglictina`, `priemer`, `poznamky`) VALUES
(1, 'Meno1', 'Priezvisko1', 'K11111', 2223, 'ZS', 1, 2, 3, NULL, 'MK', 1, 99.5, 1.23, 'Toto je prvy student'),
(2, 'Meno2', 'Priezvisko2', 'K22222', 2223, 'ZS', 1, 2, 3, NULL, 'MK', 1, 22.2, 22.2, 'Toto je 2 student. '),
(3, 'Meno3', 'Priezvisko3', 'K33333', 2223, 'ZS', 4, 3, 5, NULL, 'AV', 1, 85.3, 1.34, 'Je to pán.'),
(4, 'Meno4', 'Priezvisko4', 'K44444', 2223, 'ZS', 2, 1, 2, NULL, 'MK', 1, 44.4, 44.4, 'Toto je stvrty student. '),
(5, 'Meno5', 'Priezvisko5', 'K55555', 2223, 'ZS', 4, NULL, NULL, NULL, 'MD', 1, NULL, 2.14, 'Tiež je to pán.');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `editovanie`
--
ALTER TABLE `editovanie`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `skoly`
--
ALTER TABLE `skoly`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `editovanie`
--
ALTER TABLE `editovanie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pre tabuľku `skoly`
--
ALTER TABLE `skoly`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pre tabuľku `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
