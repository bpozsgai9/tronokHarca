-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Nov 21. 22:06
-- Kiszolgáló verziója: 10.4.18-MariaDB
-- PHP verzió: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `thrones`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fights_with`
--

CREATE TABLE `fights_with` (
  `id` int(11) NOT NULL,
  `who_House_id` int(11) NOT NULL,
  `with_who_ House_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `fights_with`
--

INSERT INTO `fights_with` (`id`, `who_House_id`, `with_who_ House_id`) VALUES
(1, 7, 1),
(2, 1, 4),
(3, 1, 3),
(4, 5, 1),
(5, 5, 2),
(6, 5, 3),
(7, 5, 4),
(8, 5, 5),
(9, 5, 6),
(10, 5, 7);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `house`
--

CREATE TABLE `house` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `symbol` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `number_of_soldiers` int(11) NOT NULL,
  `picture` varchar(200) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `house`
--

INSERT INTO `house` (`id`, `name`, `symbol`, `number_of_soldiers`, `picture`) VALUES
(1, 'Lannister', 'Lion', 100000, 'house_lannister.PNG'),
(2, 'Arryn', 'Falcon', 30000, 'house_arryn.PNG'),
(3, 'Baratheon', 'Deer', 130000, 'house_baratheon.PNG'),
(4, 'Stark', 'Wolf', 95000, 'house_stark.PNG'),
(5, 'Targaryen', 'Dragon', 0, 'house_targaryen.PNG'),
(6, 'Tully', 'Fish', 5000, 'house_tully.PNG'),
(7, 'Tyrell', 'Flower', 150000, 'house_tyrell.PNG'),
(8, 'Unknown', 'Unknown', 0, 'Unknown.PNG');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `killed_by`
--

CREATE TABLE `killed_by` (
  `id` int(11) NOT NULL,
  `who_Person_id` int(11) NOT NULL,
  `by_who_Person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `killed_by`
--

INSERT INTO `killed_by` (`id`, `who_Person_id`, `by_who_Person_id`) VALUES
(1, 10, 1),
(2, 20, 1),
(3, 23, 1),
(4, 24, 1),
(5, 28, 1),
(6, 10, 2),
(7, 29, 2),
(8, 33, 2),
(9, 38, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `member_of_house`
--

CREATE TABLE `member_of_house` (
  `id` int(11) NOT NULL,
  `Person_id` int(11) NOT NULL,
  `House_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `member_of_house`
--

INSERT INTO `member_of_house` (`id`, `Person_id`, `House_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 5),
(4, 4, 5),
(5, 5, 4),
(6, 6, 4),
(7, 7, 4),
(8, 8, 6),
(9, 9, 5),
(10, 10, 4),
(11, 11, 6),
(12, 12, 6),
(14, 14, 5),
(15, 15, 5),
(16, 16, 8),
(17, 17, 7),
(18, 18, 4),
(19, 19, 6),
(20, 20, 7),
(21, 21, 7),
(22, 22, 1),
(23, 23, 7),
(24, 24, 3),
(25, 25, 5),
(26, 26, 4),
(27, 27, 4),
(28, 28, 4),
(29, 29, 3),
(30, 30, 6),
(31, 31, 4),
(32, 32, 3),
(33, 33, 3),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 5),
(38, 38, 8);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `parent_Person_id` int(11) NOT NULL,
  `child_Person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `parent`
--

INSERT INTO `parent` (`id`, `parent_Person_id`, `child_Person_id`) VALUES
(1, 36, 1),
(2, 36, 2),
(3, 36, 35),
(4, 1, 34),
(5, 1, 13),
(6, 1, 22),
(7, 2, 34),
(8, 2, 13),
(9, 2, 22),
(10, 33, 32),
(11, 4, 25),
(12, 4, 37),
(13, 4, 9),
(14, 25, 15),
(15, 18, 15),
(16, 26, 18),
(17, 26, 6),
(18, 26, 10),
(19, 10, 28),
(20, 10, 31),
(21, 10, 5),
(22, 10, 7),
(23, 10, 27),
(24, 8, 28),
(25, 8, 31),
(26, 8, 5),
(27, 8, 7),
(28, 8, 27),
(29, 12, 8),
(30, 12, 11),
(31, 23, 20),
(32, 20, 21),
(33, 20, 17);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `age` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `picture` varchar(200) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `person`
--

INSERT INTO `person` (`id`, `name`, `age`, `title`, `picture`) VALUES
(1, 'Jamie', 44, 'first-born', 'jamie.PNG'),
(2, 'Cersei', 44, 'second-born', 'cersei.PNG'),
(3, 'Aemon', 81, 'second-born', 'aemon.PNG'),
(4, 'Areys', 54, 'first-born', 'areys.PNG'),
(5, 'Aria', 16, 'third-born', 'arya.PNG'),
(6, 'Benjen', 43, 'second-born', 'benjen.PNG'),
(7, 'Brandon', 12, 'third-born', 'brandon.PNG'),
(8, 'Catelyn', 40, 'second-born', 'catelyn.PNG'),
(9, 'Daenerys', 25, 'second-born', 'daenerys.PNG'),
(10, 'Eddard', 55, 'first-born', 'eddard.PNG'),
(11, 'Edmure', 37, 'third-born', 'edmure.PNG'),
(12, 'Hoster', 61, 'first-born', 'hoster.PNG'),
(13, 'Joffrey', 16, 'second-born', 'joffrey.PNG'),
(14, 'Jon', 81, 'first-born', 'jon.PNG'),
(15, 'Jon Snow', 32, 'second-born', 'jon_snow.PNG'),
(16, 'Petyr (Littlefinger)', 37, 'Unknown', 'littlefinger.PNG'),
(17, 'Loras', 26, 'first-born', 'loras.PNG'),
(18, 'Lyanna', 21, 'second-born', 'lyanna.PNG'),
(19, 'Lysa', 44, 'first-born', 'lysa.PNG'),
(20, 'Mace', 71, 'first-born', 'mace.PNG'),
(21, 'Margaery', 27, 'second-born', 'margaery.PNG'),
(22, 'Myrcella', 18, 'first-born', 'myrcella.PNG'),
(23, 'Olenna', 81, 'first-born', 'olenna.PNG'),
(24, 'Renly', 29, 'third-born', 'renly.PNG'),
(25, 'Rhaegar', 24, 'first-born', 'rhaegar.PNG'),
(26, 'Rickard', 31, 'first-born', 'rickard.PNG'),
(27, 'Rickon', 12, 'fourth-born', 'rickon.PNG'),
(28, 'Robb', 27, 'first-born', 'robb.PNG'),
(29, 'Robert', 57, 'first-born', 'robert.PNG'),
(30, 'Robin', 15, 'first-born', 'robin.PNG'),
(31, 'Sansa', 18, 'second-born', 'sansa.PNG'),
(32, 'Shireen', 10, 'first-born', 'shireen.PNG'),
(33, 'Stannis', 40, 'second-born', 'stannis.PNG'),
(34, 'Tommen', 14, 'third-born', 'tommen.PNG'),
(35, 'Tyrion', 36, 'third-born', 'tyrion.PNG'),
(36, 'Tywin', 60, 'first-born', 'tywin.PNG'),
(37, 'Viserys', 24, 'first-born', 'viserys.PNG'),
(38, 'Gal', 55, 'second-Born', 'unknown.PNG');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `fights_with`
--
ALTER TABLE `fights_with`
  ADD PRIMARY KEY (`id`),
  ADD KEY `who_House_id` (`who_House_id`),
  ADD KEY `with_who_ House_id` (`with_who_ House_id`);

--
-- A tábla indexei `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `killed_by`
--
ALTER TABLE `killed_by`
  ADD PRIMARY KEY (`id`),
  ADD KEY `who_Person_id` (`who_Person_id`),
  ADD KEY `by_who_Person_id` (`by_who_Person_id`);

--
-- A tábla indexei `member_of_house`
--
ALTER TABLE `member_of_house`
  ADD PRIMARY KEY (`id`),
  ADD KEY `House_id` (`Person_id`),
  ADD KEY `Person_id` (`House_id`);

--
-- A tábla indexei `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_Person_id` (`parent_Person_id`),
  ADD KEY `child_Person_id` (`child_Person_id`);

--
-- A tábla indexei `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `fights_with`
--
ALTER TABLE `fights_with`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `house`
--
ALTER TABLE `house`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `killed_by`
--
ALTER TABLE `killed_by`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `member_of_house`
--
ALTER TABLE `member_of_house`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT a táblához `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT a táblához `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1159;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `fights_with`
--
ALTER TABLE `fights_with`
  ADD CONSTRAINT `fights_with_ibfk_1` FOREIGN KEY (`who_House_id`) REFERENCES `house` (`id`),
  ADD CONSTRAINT `fights_with_ibfk_2` FOREIGN KEY (`with_who_ House_id`) REFERENCES `house` (`id`);

--
-- Megkötések a táblához `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `house_ibfk_1` FOREIGN KEY (`id`) REFERENCES `member_of_house` (`Person_id`);

--
-- Megkötések a táblához `killed_by`
--
ALTER TABLE `killed_by`
  ADD CONSTRAINT `killed_by_ibfk_1` FOREIGN KEY (`who_Person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `killed_by_ibfk_2` FOREIGN KEY (`by_who_Person_id`) REFERENCES `person` (`id`);

--
-- Megkötések a táblához `member_of_house`
--
ALTER TABLE `member_of_house`
  ADD CONSTRAINT `member_of_house_ibfk_1` FOREIGN KEY (`House_id`) REFERENCES `person` (`id`);

--
-- Megkötések a táblához `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`parent_Person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `parent_ibfk_2` FOREIGN KEY (`child_Person_id`) REFERENCES `person` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
