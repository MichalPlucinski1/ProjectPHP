-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Mar 2022, 20:56
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bank`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cities`
--

CREATE TABLE `cities` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Country` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `cities`
--

INSERT INTO `cities` (`ID`, `Name`, `Country`) VALUES
(1, 'Poznan', 'Poland'),
(2, 'Gotham', 'USA'),
(3, 'Warszawa', 'Poland');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transactions`
--

CREATE TABLE `transactions` (
  `id_transaction` int(10) UNSIGNED NOT NULL,
  `sender_account` int(11) UNSIGNED DEFAULT NULL,
  `receiver_account` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `receiver_name` varchar(120) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `value` decimal(13,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `sender_account`, `receiver_account`, `title`, `receiver_name`, `date`, `value`) VALUES
(9, 10490, 25795, 'przelew srodkow', 'Olga Nowicka', '2022-03-31 17:49:05', '25.50'),
(12, 10490, 25795, 'przelew Maciej T', 'Antonio G', '2022-03-31 18:18:59', '124.76'),
(13, 25795, 8265, 'Przelew', 'Nie pamietam imienia', '2022-03-31 18:47:29', '124.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types`
--

CREATE TABLE `types` (
  `ID` int(1) UNSIGNED NOT NULL,
  `Type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `types`
--

INSERT INTO `types` (`ID`, `Type`) VALUES
(1, 'user'),
(2, 'meneger'),
(3, 'admin'),
(4, 'error');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` int(11) UNSIGNED ZEROFILL NOT NULL,
  `account_number` int(11) UNSIGNED ZEROFILL NOT NULL,
  `balance` decimal(13,2) UNSIGNED DEFAULT 0.00,
  `name` varchar(12) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `birthdate` date NOT NULL,
  `type` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `joindate` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` text NOT NULL,
  `city` int(1) UNSIGNED NOT NULL,
  `email` varchar(70) NOT NULL,
  `id_accountant` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `code`, `account_number`, `balance`, `name`, `surname`, `birthdate`, `type`, `joindate`, `password`, `city`, `email`, `id_accountant`) VALUES
(3, 00000000001, 00000000001, NULL, 'Michał', 'Pluciński', '2002-09-19', 3, '2022-03-31 11:59:35', '$argon2id$v=19$m=65536,t=4,p=1$Njg1ODc2ODU$qyK0IQZlmCqax/e5C6HEXA', 1, 'michal.plucinski@uczen.zsk.poznan.pl', NULL),
(84, 00000097887, 00000074391, NULL, 'Mateusz', 'Bukszpan', '2022-03-01', 2, '2022-03-31 16:24:18', '$argon2id$v=19$m=65536,t=4,p=1$Z3dGMlAyejJYQ3h1ajhlVg$hAF1KNSS8TLb4SdFZnt6+ayPaHhNOgrCk4IA8/zIEpA', 1, 'mateusz.bukszpan@abank.com', NULL),
(89, 00000031470, 00000008265, '670.00', 'Jan', 'Palikot', '2022-03-23', 1, '2022-03-31 16:55:42', '$argon2id$v=19$m=65536,t=4,p=1$MmJ1VDVFZmZ1QVdnUHFFag$nxDKuOYVZNJKhyrOdLGe3jk8yjSbXIwBJ8OPWnYcHfc', 1, 'jan.palikot@mail.com', 84),
(94, 00000054615, 00000025795, '321.76', 'Olga', 'Nowicka', '2022-03-09', 1, '2022-03-31 17:21:43', '$argon2id$v=19$m=65536,t=4,p=1$RUJlN0JqdjJ6eHNwV3Fjbg$S+Q9/eIu5Bai0KykxgxyxjLqaf4gNuWHdaewkDUPHas', 1, 'olga.nowicka@mail.com', 84),
(95, 00000010602, 00000073054, NULL, 'Mariusz', 'Miskowicz', '2022-03-10', 2, '2022-03-31 17:26:58', '$argon2id$v=19$m=65536,t=4,p=1$VTBNN3A3b3lDZVBxTGNKZw$7B5O+s/2gmuwkCgTb9mjRp2xt8WoTUvyES7cmDtuo1k', 1, 'mariusz.miskowicz@mail.com', NULL),
(96, 00000004952, 00000010490, '395.24', 'Kajetan', 'Wachowski', '2022-03-24', 1, '2022-03-31 17:29:05', '$argon2id$v=19$m=65536,t=4,p=1$Z2FwTTUyeXhhQ01LajE0NQ$jbRz5sbtIaIbu0CJEHM/DckeAhJFo9YPoh/2Uaocp5g', 1, 'kajetan.wachowski@mail.com', 95);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indeksy dla tabeli `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `sender_account` (`sender_account`,`receiver_account`),
  ADD KEY `receiver_account` (`receiver_account`);

--
-- Indeksy dla tabeli `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD UNIQUE KEY `account_number_2` (`account_number`),
  ADD UNIQUE KEY `code_2` (`code`),
  ADD KEY `code` (`code`),
  ADD KEY `id_accountant` (`id_accountant`),
  ADD KEY `city` (`city`),
  ADD KEY `city_2` (`city`),
  ADD KEY `type` (`type`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cities`
--
ALTER TABLE `cities`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `types`
--
ALTER TABLE `types`
  MODIFY `ID` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_account`) REFERENCES `users` (`account_number`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`receiver_account`) REFERENCES `users` (`account_number`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`city`) REFERENCES `cities` (`ID`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`id_accountant`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_4` FOREIGN KEY (`type`) REFERENCES `types` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
