-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 16 2017 г., 10:23
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.0.24-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `support_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `pass`, `created`, `last_login`, `support_email`) VALUES
(1, 'admin', '$2y$10$1gs6NM5bYZuK3gFxzf440u8Yj3e57YwhPM9LiGn5QFcM4Qpi3cmJS', '2017-11-08 22:00:00', '2017-11-16 06:50:13', 'kurmeldeveloper@gmail.com');

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
(1, '<h1>You subscribed to http://summer-catchers.dev/</h1>\n', '2017-11-10 08:50:14', 0, 1);

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
(37, 'Summer_Catchers_screenshot2.jpg', 0, 480593),
(38, 'Summer_Catchers_screenshot3.jpg', 0, 1207326),
(39, 'Summer_Catchers_screenshot4.jpg', 0, 858813),
(40, 'Summer_Catchers_screenshot5.jpg', 0, 172606),
(41, 'Summer_Catchers_screenshot6.jpg', 0, 717402),
(42, 'Summer_Catchers_screenshot7.jpg', 0, 771493),
(43, 'Summer_Catchers_screenshot8.jpg', 0, 226729),
(44, 'Summer_Catchers_screenshot9.jpg', 0, 761035);

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
(8, 'kurmeldeveloper@gmail.com', 0, '$2y$10$mRuwXrY899yQcXwFbNS3r.h.UhmlYZUXySvlx94l7ZIl60nrXZG8S', NULL, '2017-11-15 13:12:21');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT для таблицы `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
