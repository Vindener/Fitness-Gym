-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 13 2024 р., 10:04
-- Версія сервера: 5.7.39
-- Версія PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `fitness_gym`
--

-- --------------------------------------------------------

--
-- Структура таблиці `Blog`
--

CREATE TABLE `Blog` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Blog`
--

INSERT INTO `Blog` (`post_id`, `user_id`, `title`, `content`, `photo`, `created_at`) VALUES
(1, 5, 'ушошуо', 'ацаца', '', '2024-05-26 13:47:57'),
(2, 5, 'fwfw', 'wfwf', '', '2024-05-27 21:12:04'),
(3, 5, 'fef', 'wfwf', '', '2024-05-27 21:14:35'),
(4, 5, 'wfwf', 'fwfw', '1603726353_1603660829_Screenshot.jpg', '2024-05-28 16:19:06'),
(5, 5, 'цац', 'аца', 'ec307899c52d5d40af68cdda8a3302d5.png', '2024-05-28 16:36:06'),
(6, 5, 'цац', 'аца', 'ec307899c52d5d40af68cdda8a3302d5.png', '2024-05-28 16:37:20'),
(7, 5, 'fwf', 'wfw', 'Audi_80_B3_front_20081201.jpg', '2024-05-28 16:37:35'),
(8, 5, 'wfw', 'fwf', '', '2024-05-28 16:38:00'),
(9, 5, 'wfw', 'fwfw', 'Audi_80_B3_front_20081201.jpg', '2024-05-28 16:38:14');

-- --------------------------------------------------------

--
-- Структура таблиці `Lessons`
--

CREATE TABLE `Lessons` (
  `class_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `trainer_id` int(11) DEFAULT NULL,
  `hour_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Lessons`
--

INSERT INTO `Lessons` (`class_id`, `title`, `description`, `trainer_id`, `hour_id`) VALUES
(4, 'Вечірні вправи', 'Набор вправ для підтримки організму після роботи', 20, 11),
(7, 'Бокс', ' ', 20, 5),
(9, 'Рання зарядка', ' ', 33, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `OrderItems`
--

CREATE TABLE `OrderItems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `OrderItems`
--

INSERT INTO `OrderItems` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 9, 3, 3, '12.00'),
(2, 9, 4, 2, '22.00'),
(3, 10, 3, 1, '12.00'),
(4, 10, 4, 1, '22.00'),
(5, 13, 2, 1, '12.00'),
(6, 18, 4, 1, '22.00'),
(7, 20, 4, 1, '22.00'),
(8, 21, 4, 1, '22.00'),
(9, 22, 4, 2, '22.00'),
(10, 23, 4, 1, '22.00'),
(11, 24, 1, 1, '100.00'),
(12, 24, 4, 3, '22.00'),
(13, 25, 5, 2, '10.00'),
(14, 26, 5, 3, '10.00'),
(15, 27, 4, 1, '22.00'),
(16, 27, 5, 2, '10.00');

-- --------------------------------------------------------

--
-- Структура таблиці `Orders`
--

CREATE TABLE `Orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Orders`
--

INSERT INTO `Orders` (`order_id`, `user_id`, `total`, `created_at`) VALUES
(1, 5, '34.00', '2024-05-26 19:47:52'),
(2, NULL, '34.00', '2024-05-26 19:50:37'),
(3, NULL, '0.00', '2024-05-26 19:51:36'),
(4, NULL, '0.00', '2024-05-26 19:51:45'),
(5, NULL, '46.00', '2024-05-26 19:52:07'),
(6, NULL, '46.00', '2024-05-26 19:53:31'),
(7, NULL, '46.00', '2024-05-26 19:53:43'),
(8, NULL, '46.00', '2024-05-26 19:54:46'),
(9, 5, '80.00', '2024-05-26 19:55:02'),
(10, NULL, '34.00', '2024-05-26 20:06:38'),
(11, 5, '0.00', '2024-05-26 20:10:52'),
(12, NULL, '12.00', '2024-05-27 17:02:21'),
(13, NULL, '12.00', '2024-05-27 17:02:34'),
(14, NULL, '22.00', '2024-05-27 17:05:04'),
(15, NULL, '34.00', '2024-05-27 17:05:23'),
(16, 5, '34.00', '2024-05-27 17:05:54'),
(17, 5, '44.00', '2024-05-27 17:09:05'),
(18, 5, '22.00', '2024-05-27 17:10:14'),
(19, 5, '0.00', '2024-05-27 17:10:41'),
(20, 5, '22.00', '2024-05-27 17:10:53'),
(21, 5, '22.00', '2024-05-27 17:16:47'),
(22, 5, '44.00', '2024-05-27 19:37:58'),
(23, 5, '22.00', '2024-05-27 21:30:59'),
(24, 5, '166.00', '2024-05-28 08:53:48'),
(25, 5, '20.00', '2024-05-28 09:04:30'),
(26, 3, '30.00', '2024-05-28 09:24:59'),
(27, 5, '42.00', '2024-05-28 17:00:33');

-- --------------------------------------------------------

--
-- Структура таблиці `Products`
--

CREATE TABLE `Products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Products`
--

INSERT INTO `Products` (`product_id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Дорогий протеїн', 'Повний вітамінів', '100.00', NULL, '2024-05-26 19:42:17'),
(2, 'Пробник вітамнів С', 'Аскорбінка', '12.00', NULL, '2024-05-26 19:42:24'),
(3, 'Пробник вітамнів Д', ' ', '12.00', NULL, '2024-05-26 19:43:19'),
(4, 'True Whey - GymBeam', 'Концентрат білку', '769.00', 'photo_2024-06-06_17-39-57.jpg', '2024-05-26 19:43:26'),
(5, 'Organic Oils Льняной', 'Лляний протеїн Organic Oils — це чудове джерело білків рослинного походження, вітамінів і клітковини для збалансованого харчування, і підтримки здоров\'я організму.\r\nВисока поживна цінність лляного протеїну забезпечується використанням низькотемпературних механічних засобів очищення й перероблення насіння, що допомагають зберегти все цінне всередині. Тонкий помел забезпечує підвищену розчинність лляного білка, миттєве насичення смаком, забезпечує максимальне засвоєння організмом білків, вітамінів та інших корисних речовин.', '89.00', 'photo_2024-06-06_17-41-01.jpg', '2024-05-28 08:53:27');

-- --------------------------------------------------------

--
-- Структура таблиці `Registrations`
--

CREATE TABLE `Registrations` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Registrations`
--

INSERT INTO `Registrations` (`registration_id`, `user_id`, `class_id`, `registration_date`) VALUES
(1, 5, 4, '2024-05-03'),
(2, 5, 5, '2024-05-03'),
(3, 5, 6, '2024-05-03'),
(4, 5, 7, '2024-05-03'),
(5, 5, 4, '2024-05-04'),
(6, 5, 5, '2024-05-04'),
(7, 5, 6, '2024-05-04'),
(8, 5, 7, '2024-05-04'),
(9, 5, 8, '2024-05-04'),
(11, 5, 4, '2024-05-24'),
(12, 5, 4, '2024-05-02'),
(13, 5, 4, '2024-05-09'),
(14, 5, 4, '2024-05-05'),
(15, 5, 4, '2024-05-26'),
(16, 5, 7, '2024-05-26'),
(17, 5, 6, '2024-05-02'),
(18, 5, 6, '2024-05-27'),
(19, 5, 7, '2024-05-02'),
(20, 5, 6, '2024-05-28');

-- --------------------------------------------------------

--
-- Структура таблиці `Reviews`
--

CREATE TABLE `Reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Reviews`
--

INSERT INTO `Reviews` (`review_id`, `user_id`, `class_id`, `rating`, `comment`, `created_at`) VALUES
(1, 5, 4, 3, 'все було непогано', '2024-05-26 13:40:28'),
(2, 5, 4, 3, 'все було непогано', '2024-05-26 13:40:54'),
(3, 5, 7, 5, '', '2024-05-26 13:40:57'),
(4, 5, 7, 5, '', '2024-05-26 13:41:58'),
(5, 5, 9, 3, '', '2024-05-28 15:48:38');

-- --------------------------------------------------------

--
-- Структура таблиці `Time`
--

CREATE TABLE `Time` (
  `time_id` int(11) NOT NULL,
  `hour` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Time`
--

INSERT INTO `Time` (`time_id`, `hour`) VALUES
(1, 8),
(2, 9),
(3, 10),
(4, 11),
(5, 12),
(6, 13),
(7, 14),
(8, 15),
(9, 16),
(10, 17),
(11, 18),
(12, 19),
(13, 20),
(14, 21);

-- --------------------------------------------------------

--
-- Структура таблиці `Trainers`
--

CREATE TABLE `Trainers` (
  `trainer_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Trainers`
--

INSERT INTO `Trainers` (`trainer_id`, `name`, `bio`, `photo`) VALUES
(18, 'Ігор', 'крутий тренер зі стажем 1 рік', 'photo_2024-05-04_12-57-12.jpg'),
(20, 'Іван', 'Старий тренер з досвідом', ''),
(33, 'Олексій', ' ', '');

-- --------------------------------------------------------

--
-- Структура таблиці `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `password`, `email`, `name`, `access`) VALUES
(1, 'wfw', '5456a01a16b4f37bdba654e8c92d9f85', 'wfw', 'wf', 1),
(3, 'user', 'eb05a98ef49ab804cbb6e25a1ae77dd5', 'fefe', 'wfw', 1),
(5, 'admin', '6f4e4c2368e144da23fdbffe852abae9', 'fedf', 'gee', 2),
(6, 'user1', '547caa3456af7dbba6059bc7fe3105b4', 'аркар3 ', 'аца', 1),
(8, 'user2', '76d8e159ca6a2d2dc25cb0789a03223d', 'hf', 'fwfw', 1),
(10, 'user3', '65a54f10c9d112a07d6b97452ebbe276', 'fhuehfu', 'udwud', 1),
(11, 'user4', '96167f7b8ec026bfb08c2e51a6c3baf7', 'fjwifjni', 'fwfjw', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `Blog`
--
ALTER TABLE `Blog`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `Lessons`
--
ALTER TABLE `Lessons`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Індекси таблиці `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Індекси таблиці `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`product_id`);

--
-- Індекси таблиці `Registrations`
--
ALTER TABLE `Registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- Індекси таблиці `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Індекси таблиці `Time`
--
ALTER TABLE `Time`
  ADD PRIMARY KEY (`time_id`);

--
-- Індекси таблиці `Trainers`
--
ALTER TABLE `Trainers`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Індекси таблиці `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `Blog`
--
ALTER TABLE `Blog`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `Lessons`
--
ALTER TABLE `Lessons`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `OrderItems`
--
ALTER TABLE `OrderItems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблиці `Orders`
--
ALTER TABLE `Orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблиці `Products`
--
ALTER TABLE `Products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `Registrations`
--
ALTER TABLE `Registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблиці `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `Time`
--
ALTER TABLE `Time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблиці `Trainers`
--
ALTER TABLE `Trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблиці `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `Blog`
--
ALTER TABLE `Blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Обмеження зовнішнього ключа таблиці `Lessons`
--
ALTER TABLE `Lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `Trainers` (`trainer_id`);

--
-- Обмеження зовнішнього ключа таблиці `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);

--
-- Обмеження зовнішнього ключа таблиці `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Обмеження зовнішнього ключа таблиці `Reviews`
--
ALTER TABLE `Reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `Lessons` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
