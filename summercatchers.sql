-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 22 2017 г., 14:41
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.0.24-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `summercatchers`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `support_email` varchar(255) DEFAULT NULL,
  `support_pass` varchar(255) DEFAULT NULL,
  `send_email` varchar(255) DEFAULT NULL,
  `send_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `pass`, `created`, `last_login`, `support_email`, `support_pass`, `send_email`, `send_pass`) VALUES
(1, 'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2017-11-08 22:00:00', '2017-11-22 12:15:41', 'summercatchers@gmail.com', 'swan4815162342', 'info.summercatchers@gmail.com', 'bear4815162342');

-- --------------------------------------------------------

--
-- Структура таблицы `citations`
--

CREATE TABLE `citations` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `who` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `citations`
--

INSERT INTO `citations` (`id`, `text`, `who`) VALUES
(1, 'The graphics have retro style pixel art, but it is done in a high quality modern art style.', 'Nick, blogjob.com'),
(2, '...the music of Summer Catchers is a particular highlight, with cheerful, catchy tunes that are reminiscent of classic Sonic soundtracks.', 'FreakOrama, alphabetagamer.com'),
(3, '...another game with a gorgeous art style and a ton of mystique that\'s glued together with a satisfying side-scrolling physics driving mechanic.', 'Jared Nelson, toucharcade.com');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `text`) VALUES
(14, 'Anrey', 'test@email.com', 'test\nMessage'),
(15, 'Andrey_K', 'kurmeldeveloper@gmail.com', 'Test\nMessage');

-- --------------------------------------------------------

--
-- Структура таблицы `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `queued` tinyint(4) NOT NULL DEFAULT '0',
  `is_greeting` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `emails`
--

INSERT INTO `emails` (`id`, `body`, `created`, `queued`, `is_greeting`) VALUES
(1, '<h1>For confirming your subscription please click the link below.</h1>\n', '2017-11-10 08:50:14', 0, 1),
(3, '<p>Test message</p>\n', '2017-11-22 15:23:16', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `thumbnail` tinyint(4) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `filename`, `thumbnail`, `size`) VALUES
(32, 'thumb1.jpg', 1, 31310),
(33, 'thumb3.jpg', 1, 46919),
(34, 'thumb4.jpg', 1, 40159),
(35, 'thumb5.jpg', 1, 34305),
(36, 'Summer_Catchers_screenshot1.jpg', 0, 652821),
(38, 'Summer_Catchers_screenshot3.jpg', 0, 1207326),
(39, 'Summer_Catchers_screenshot4.jpg', 0, 858813),
(40, 'Summer_Catchers_screenshot5.jpg', 0, 172606),
(41, 'Summer_Catchers_screenshot6.jpg', 0, 717402),
(42, 'Summer_Catchers_screenshot7.jpg', 0, 771493),
(43, 'Summer_Catchers_screenshot8.jpg', 0, 226729),
(44, 'Summer_Catchers_screenshot9.jpg', 0, 761035),
(45, 'Summer_Catchers_screenshot6.jpg', 2, 717402),
(46, 'Summer_Catchers_screenshot5.jpg', 2, 172606),
(47, 'Summer_Catchers_screenshot4.jpg', 2, 858813),
(48, 'Summer_Catchers_screenshot2.jpg', 0, 423536);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribes`
--

CREATE TABLE `subscribes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `code` varchar(255) NOT NULL,
  `notice_delivered` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subscribes`
--

INSERT INTO `subscribes` (`id`, `email`, `active`, `code`, `notice_delivered`, `created`) VALUES
(14, 'kurmeldeveloper@gmail.com', 1, '3075156ad3fdbe9b25efc869f6e56b378af27f94c0da05a1f1a850980d9c1429', 1, '2017-11-22 12:34:16');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `citations`
--
ALTER TABLE `citations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `citations`
--
ALTER TABLE `citations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
