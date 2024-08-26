-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 26 2024 г., 11:13
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `medOborudovanie`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oborudovanie`
--

CREATE TABLE `oborudovanie` (
  `id_oborudovanie` int NOT NULL,
  `id_type_oborudovanie` int DEFAULT NULL,
  `id_uz` int DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `date_create` varchar(10) DEFAULT NULL,
  `date_postavki` date DEFAULT NULL,
  `date_release` date DEFAULT NULL,
  `date_dogovora` date DEFAULT NULL,
  `date_last_TO` date DEFAULT NULL,
  `status` int DEFAULT NULL,
  `id_serviceman` int DEFAULT NULL,
  `date_dogovor_service` date DEFAULT NULL,
  `srok_dogovor_service` date DEFAULT NULL,
  `summa_dogovor_service` double DEFAULT NULL,
  `type_work_dogovor_service` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `oborudovanie`
--

INSERT INTO `oborudovanie` (`id_oborudovanie`, `id_type_oborudovanie`, `id_uz`, `cost`, `date_create`, `date_postavki`, `date_release`, `date_dogovora`, `date_last_TO`, `status`, `id_serviceman`, `date_dogovor_service`, `srok_dogovor_service`, `summa_dogovor_service`, `type_work_dogovor_service`) VALUES
(9, 4, 3, 2682144.59, '0000-00-00', '0000-00-00', '2021-01-01', '0000-00-00', '0000-00-00', 0, 1, '2024-08-26', '2024-08-27', 52, '5'),
(11, 11, 4, 0, '2020-01-01', '2024-08-24', '2021-01-01', '0000-00-00', '2024-08-24', 0, 12, NULL, NULL, NULL, NULL),
(12, 4, 5, 0, '2005-01-01', '0000-00-00', '2005-01-01', '0000-00-00', '0000-00-00', 0, 2, NULL, NULL, NULL, NULL),
(14, 4, 6, 0, '2015-01-01', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(17, 11, 9, 0, '2009-01-01', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(18, 2, 13, 0, '0000-00-00', '0000-00-00', '2018-01-01', '0000-00-00', '0000-00-00', 0, 2, NULL, NULL, NULL, NULL),
(19, 11, 15, 0, '0000-00-00', '0000-00-00', '2013-01-01', '0000-00-00', '0000-00-00', 0, 3, NULL, NULL, NULL, NULL),
(21, 4, 16, 0, '0000-00-00', '0000-00-00', '2012-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(22, 4, 20, 0, '0000-00-00', '0000-00-00', '2018-01-01', '0000-00-00', '0000-00-00', 0, 4, NULL, NULL, NULL, NULL),
(23, 4, 21, 0, '0000-00-00', '0000-00-00', '2024-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(24, 4, 22, 0, '0000-00-00', '0000-00-00', '2012-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(25, 2, 23, 0, '0000-00-00', '0000-00-00', '2020-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(26, 2, 25, 0, '0000-00-00', '0000-00-00', '2019-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(27, 11, 26, 0, '0000-00-00', '0000-00-00', '2014-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(28, 4, 27, 0, '0000-00-00', '0000-00-00', '2014-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(29, 11, 32, 0, '0000-00-00', '0000-00-00', '2012-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(30, 4, 34, 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(31, 12, 14, 0, '0000-00-00', '0000-00-00', '2009-01-01', '0000-00-00', '0000-00-00', 0, 2, NULL, NULL, NULL, NULL),
(32, 12, 20, 0, '0000-00-00', '0000-00-00', '2020-01-01', '0000-00-00', '0000-00-00', 0, 2, NULL, NULL, NULL, NULL),
(33, 12, 20, 0, '0000-00-00', '0000-00-00', '2015-01-01', '0000-00-00', '0000-00-00', 0, 2, NULL, NULL, NULL, NULL),
(34, 12, 32, 0, '0000-00-00', '0000-00-00', '2017-01-01', '0000-00-00', '0000-00-00', 0, 0, NULL, NULL, NULL, NULL),
(35, 11, 7, NULL, '2019', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(36, 11, 36, NULL, '2018', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(37, 11, 37, NULL, '2015', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(38, 11, 37, NULL, '2009', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(39, 11, 38, NULL, '2019', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(40, 11, 39, NULL, '2015', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(41, 11, 40, NULL, '2021', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(42, 11, 41, NULL, '2020', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(43, 11, 42, NULL, '2022', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(44, 11, 43, NULL, '2022', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(45, 11, 44, NULL, '2020', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(46, 11, 45, NULL, '2021', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(47, 11, 46, NULL, '2022', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(48, 11, 47, NULL, '2005', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(49, 11, 47, NULL, '2021', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(50, 11, 48, NULL, 'УЗ «Иванов', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(51, 2, 36, NULL, '2018', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(52, 2, 37, NULL, '2014', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(53, 2, 38, NULL, '2021', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL),
(54, 2, 39, NULL, '2015', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(55, 11, 49, NULL, '2018', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(56, 2, 49, NULL, '2018', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(57, 2, 6, NULL, '2014', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL),
(58, 2, 47, NULL, '2014', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, NULL, NULL, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oborudovanie`
--
ALTER TABLE `oborudovanie`
  ADD PRIMARY KEY (`id_oborudovanie`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oborudovanie`
--
ALTER TABLE `oborudovanie`
  MODIFY `id_oborudovanie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
