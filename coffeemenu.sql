-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 25. bře 2016, 00:40
-- Verze serveru: 10.1.10-MariaDB
-- Verze PHP: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `coffeemenu`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `menu_item`
--

CREATE TABLE `menu_item` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_cz` double NOT NULL,
  `price_bitcoin` double DEFAULT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `menu_item`
--

INSERT INTO `menu_item` (`id`, `name`, `price_cz`, `price_bitcoin`, `order`) VALUES
('81901d7b-2448-4e7b-8b27-e50a5df6f435', 'swag', 3000, 0, 2),
('8e78f175-a828-43f3-ade8-c8b3b89aa75a', 'cappucino', 9999, 0, 1),
('be3bbaaa-93a2-444e-8e90-e3192766e2d9', 'latte', 52, 0, 3);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D754D5505E237E06` (`name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
