-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Lut 2016, 13:41
-- Wersja serwera: 5.6.26
-- Wersja PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt_kino`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bilety`
--

CREATE TABLE IF NOT EXISTS `bilety` (
  `ID_Biletu` int(11) NOT NULL,
  `Nazwa` varchar(100) NOT NULL,
  `Cena` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `bilety`
--

INSERT INTO `bilety` (`ID_Biletu`, `Nazwa`, `Cena`) VALUES
(1, 'Studencki', 17),
(2, 'Normalny', 28),
(3, 'Uczniowski', 14);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `filmy`
--

CREATE TABLE IF NOT EXISTS `filmy` (
  `ID_Filmu` int(11) NOT NULL,
  `Tytul` varchar(100) NOT NULL,
  `Podtytul` varchar(200) DEFAULT NULL,
  `Opis` text NOT NULL,
  `Data_premiery` date NOT NULL,
  `Rezyseria` varchar(200) DEFAULT NULL,
  `Scenariusz` varchar(200) DEFAULT NULL,
  `Produkcja` varchar(100) DEFAULT NULL,
  `Okladka` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `filmy`
--

INSERT INTO `filmy` (`ID_Filmu`, `Tytul`, `Podtytul`, `Opis`, `Data_premiery`, `Rezyseria`, `Scenariusz`, `Produkcja`, `Okladka`) VALUES
(26, 'Alvin i wiewiórki', 'Wielka wyprawa', 'Przez zbieg okolicznosci wiewiorki mysla, ze Dave chce si? ozenic i je porzucic. Wyruszaja wiec w podroz, by zapobiec oswiadczynom. ', '2016-02-22', 'Walt Becker', 'Randi Mayem Singer, Adam Sztykiel\r\n', 'USA', 'Alvin_i_wiewiorki_wielka_wyprawa2015.jpg'),
(28, 'Deadpool', NULL, 'Byly zolnierz oddzialow specjalnych zostaje poddany niebezpiecznemu eksperymentowi. Niebawem uwalnia swoje alter ego i rozpoczyna polowanie na czlowieka, ktory niemal zniszczyl jego zycie. ', '2016-02-12', 'Tim Miller', 'Rhett Reese, Paul Wernick\r\n', 'Kanada, USA', 'Deadpool2016.jpg'),
(29, 'Dziewczyna z portretu', NULL, 'Malzenstwo artystow malarzy - Einara i Gerdy Wegener zostaje poddane probie, gdy mezczyzna zmienia plec. ', '2016-01-22', 'Tom Hooper', 'Lucinda Coxon', 'Niemcy, USA, Wielka Brytania', 'Dziewczyna_z_portretu2015.jpg'),
(30, 'Ugotowany', NULL, 'Adam Jones gromadzi doborowa zaloge, by stworzyc najlepsza restauracje na swiecie.', '2015-10-23', 'John Wells', 'Steven Knight', 'USA', 'Ugotowany2015.jpg'),
(31, 'Zjawa', NULL, 'Hugh Glass szuka zemsty na ludziach, ktorzy zostawili go powaznie rannego po ataku niedzwiedzia. ', '2016-01-29', 'Alejandro González Iñárritu', 'Alejandro González Iñárritu, Mark L. Smith\r\n', 'USA', 'Zjawa2015.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `filmy_gatunki`
--

CREATE TABLE IF NOT EXISTS `filmy_gatunki` (
  `Film` int(11) NOT NULL,
  `Kategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `filmy_gatunki`
--

INSERT INTO `filmy_gatunki` (`Film`, `Kategoria`) VALUES
(29, 5),
(29, 2),
(26, 7),
(26, 8),
(26, 1),
(28, 6),
(28, 3),
(30, 2),
(30, 1),
(31, 2),
(31, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE IF NOT EXISTS `kategorie` (
  `ID_Kategorii` int(11) NOT NULL,
  `Nazwa` varchar(50) NOT NULL,
  `Opis` text
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`ID_Kategorii`, `Nazwa`, `Opis`) VALUES
(1, 'Komedia', NULL),
(2, 'Dramat', NULL),
(3, 'Sci-Fi', NULL),
(4, 'Przygodowy', NULL),
(5, 'Biograficzny', NULL),
(6, 'Akcja', NULL),
(7, 'Animacja', NULL),
(8, 'Familijny', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny_filmow`
--

CREATE TABLE IF NOT EXISTS `oceny_filmow` (
  `ID_Oceny` int(11) NOT NULL,
  `Film` int(11) NOT NULL,
  `Uzytkownik` int(11) NOT NULL,
  `Ocena` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `oceny_filmow`
--

INSERT INTO `oceny_filmow` (`ID_Oceny`, `Film`, `Uzytkownik`, `Ocena`) VALUES
(38, 28, 7, 4),
(39, 26, 7, 4),
(40, 30, 7, 5),
(41, 29, 7, 3),
(42, 31, 7, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokazy`
--

CREATE TABLE IF NOT EXISTS `pokazy` (
  `ID_Pokazu` int(11) NOT NULL,
  `Data` datetime NOT NULL,
  `Film` int(11) NOT NULL,
  `Sala` int(11) NOT NULL,
  `Rodzaj_obrazu` varchar(50) NOT NULL,
  `Rodzaj_dzwieku` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pokazy`
--

INSERT INTO `pokazy` (`ID_Pokazu`, `Data`, `Film`, `Sala`, `Rodzaj_obrazu`, `Rodzaj_dzwieku`) VALUES
(27, '2016-02-22 15:00:00', 26, 3, '2D', 'Dubbing'),
(28, '2016-02-22 15:00:00', 26, 4, '3D', 'Dubbing'),
(29, '2016-02-22 19:00:00', 26, 3, '2D', 'Dubbing'),
(30, '2016-02-23 15:00:00', 26, 4, '3D', 'Dubbing'),
(31, '2016-02-12 19:00:00', 28, 3, '2D', 'Napisy'),
(32, '2016-02-12 19:00:00', 28, 4, '2D', 'Napisy'),
(33, '2016-02-10 20:00:00', 30, 3, '2D', 'Napisy'),
(34, '2016-02-11 20:00:00', 30, 4, '2D', 'Napisy'),
(35, '2016-01-23 17:00:00', 29, 3, '2D', 'Lektor');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE IF NOT EXISTS `rezerwacje` (
  `ID_Rezerwacji` int(11) NOT NULL,
  `Pokaz` int(11) NOT NULL,
  `Uzytkownik` int(11) DEFAULT NULL,
  `Imie` varchar(100) NOT NULL,
  `Nazwisko` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Data_rezerwacji` datetime NOT NULL,
  `Sciezka` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `rezerwacje`
--

INSERT INTO `rezerwacje` (`ID_Rezerwacji`, `Pokaz`, `Uzytkownik`, `Imie`, `Nazwisko`, `Email`, `Data_rezerwacji`, `Sciezka`) VALUES
(100, 31, 7, 'Marcin', 'Bator', 'marcin_bator@o2.pl', '2016-02-11 14:16:39', '004469ef6936eed628eefad4e6169a99'),
(101, 34, 7, 'Marcin', 'Bator', 'marcin_bator@o2.pl', '2016-02-11 14:17:06', NULL),
(102, 27, 7, 'Katarzyna', 'Karol', 'kasiakarol@gmail.com', '2016-02-11 14:18:10', 'aec8c190cacf2da9db93ecc1692bbad6'),
(104, 32, 1, 'Test', 'Test', 'test@test.pl', '2016-02-11 17:45:56', 'f474266fe61aa29808e51a37fb18bd46'),
(105, 30, 1, 'Test', 'Test', 'test@test.pl', '2016-02-11 17:50:03', 'cff4e06c4bef0ff551de46290652871f'),
(106, 32, 1, 'test', 'test', 'test@test.pl', '2016-02-11 22:10:10', 'deff2488161f31203775bf08fc908cc2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `ID_Sali` int(11) NOT NULL,
  `Numer_sali` varchar(50) NOT NULL,
  `Rodzaj` varchar(50) NOT NULL,
  `Uklad_siedzen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`ID_Sali`, `Numer_sali`, `Rodzaj`, `Uklad_siedzen`) VALUES
(3, '2', 'Standard', '0,0,0,0,0,1,1,1,1,1,1,1,0,0,0,0,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,0/1,1,1,0,0,0,0,1,1,1,1,1,1,1,1,1,1,0/1,1,1,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1'),
(4, '5', 'Standard', '1,1,1,1,1,1,1,1,1,1,1,1,1,1/1,1,1,1,1,1,1,1,1,1,1,1,1,1/1,1,1,1,1,1,1,1,1,1,1,1,1,1/1,1,1,1,1,1,1,1,1,1,1,1,1,1/1,1,1,1,1,1,1,1,1,1,1,1,1,1/1,1,1,1,1,1,1,1,1,1,1,1,1,1/\r\n0,0,1,1,1,1,1,1,1,1,1,1,0,0/1,1,1,1,1,1,1,1,1,1,1,1,1,1/0,0,0,0,1,1,1,1,1,1,1,1,1,1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_rezerwacji`
--

CREATE TABLE IF NOT EXISTS `szczegoly_rezerwacji` (
  `Rezerwacja` int(11) NOT NULL,
  `Siedzenie` varchar(10) NOT NULL,
  `Bilet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `szczegoly_rezerwacji`
--

INSERT INTO `szczegoly_rezerwacji` (`Rezerwacja`, `Siedzenie`, `Bilet`) VALUES
(100, 'H1', 1),
(100, 'H2', 1),
(100, 'H3', 1),
(100, 'H4', 1),
(101, 'E6', 1),
(101, 'E7', 1),
(101, 'E8', 1),
(101, 'E9', 1),
(104, 'E6', 1),
(104, 'E7', 1),
(104, 'E8', 1),
(104, 'E9', 1),
(106, 'D6', 1),
(106, 'D7', 1),
(102, 'F3', 2),
(102, 'F6', 2),
(105, 'E7', 2),
(105, 'E8', 2),
(102, 'F4', 3),
(102, 'F5', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `ID_Uzytkownika` int(11) NOT NULL,
  `Login` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Haslo` varchar(100) DEFAULT NULL,
  `Rola` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_Uzytkownika`, `Login`, `Email`, `Haslo`, `Rola`) VALUES
(1, 'test', 'test@test.pl', '098f6bcd4621d373cade4e832627b4f6', 'Uzytkownik'),
(7, 'admin', 'admin@admin.pl', '21232f297a57a5a743894a0e4a801fc3', 'Moderator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy_tymczasowi`
--

CREATE TABLE IF NOT EXISTS `uzytkownicy_tymczasowi` (
  `ID_Uzytkownika_tymczasowego` int(11) NOT NULL,
  `Login` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Haslo` varchar(100) DEFAULT NULL,
  `Kod_aktywacyjny` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

CREATE TABLE IF NOT EXISTS `wiadomosci` (
  `ID_Wiadomosci` int(11) NOT NULL,
  `Tresc` text NOT NULL,
  `Typ` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `wiadomosci`
--

INSERT INTO `wiadomosci` (`ID_Wiadomosci`, `Tresc`, `Typ`) VALUES
(1, 'Link aktywacyjny zostal wyslany na adres e-mail podany podczas rejestracji.', 'Wiadomosc'),
(2, 'Klikniety link jest niewlasciwy.', 'Blad'),
(3, 'Konto nie zostalo aktywowane! Link aktywacyjny zostal wyslany ponownie.', 'Blad'),
(6, 'Zaloguj sie aby oddac glos na film!', 'Blad'),
(7, 'Zaloguj sie aby zarezerwowac bilet!', 'Blad'),
(8, 'Konto zostalo aktywowane. Mozesz sie teraz zalogowac.', 'Wiadomosc');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `bilety`
--
ALTER TABLE `bilety`
  ADD PRIMARY KEY (`ID_Biletu`);

--
-- Indexes for table `filmy`
--
ALTER TABLE `filmy`
  ADD PRIMARY KEY (`ID_Filmu`);

--
-- Indexes for table `filmy_gatunki`
--
ALTER TABLE `filmy_gatunki`
  ADD KEY `Film` (`Film`),
  ADD KEY `Kategoria` (`Kategoria`);

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`ID_Kategorii`);

--
-- Indexes for table `oceny_filmow`
--
ALTER TABLE `oceny_filmow`
  ADD PRIMARY KEY (`ID_Oceny`),
  ADD KEY `Film` (`Film`),
  ADD KEY `Uzytkownik` (`Uzytkownik`);

--
-- Indexes for table `pokazy`
--
ALTER TABLE `pokazy`
  ADD PRIMARY KEY (`ID_Pokazu`),
  ADD KEY `Film` (`Film`),
  ADD KEY `Sala` (`Sala`);

--
-- Indexes for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`ID_Rezerwacji`),
  ADD KEY `Pokaz` (`Pokaz`),
  ADD KEY `Uzytkownik` (`Uzytkownik`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`ID_Sali`);

--
-- Indexes for table `szczegoly_rezerwacji`
--
ALTER TABLE `szczegoly_rezerwacji`
  ADD PRIMARY KEY (`Rezerwacja`,`Siedzenie`),
  ADD KEY `Bilet` (`Bilet`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_Uzytkownika`);

--
-- Indexes for table `uzytkownicy_tymczasowi`
--
ALTER TABLE `uzytkownicy_tymczasowi`
  ADD PRIMARY KEY (`ID_Uzytkownika_tymczasowego`);

--
-- Indexes for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`ID_Wiadomosci`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `bilety`
--
ALTER TABLE `bilety`
  MODIFY `ID_Biletu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `filmy`
--
ALTER TABLE `filmy`
  MODIFY `ID_Filmu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `ID_Kategorii` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `oceny_filmow`
--
ALTER TABLE `oceny_filmow`
  MODIFY `ID_Oceny` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT dla tabeli `pokazy`
--
ALTER TABLE `pokazy`
  MODIFY `ID_Pokazu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `ID_Rezerwacji` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT dla tabeli `sale`
--
ALTER TABLE `sale`
  MODIFY `ID_Sali` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `uzytkownicy_tymczasowi`
--
ALTER TABLE `uzytkownicy_tymczasowi`
  MODIFY `ID_Uzytkownika_tymczasowego` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `ID_Wiadomosci` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `filmy_gatunki`
--
ALTER TABLE `filmy_gatunki`
  ADD CONSTRAINT `filmy_gatunki_ibfk_1` FOREIGN KEY (`Film`) REFERENCES `filmy` (`ID_Filmu`),
  ADD CONSTRAINT `filmy_gatunki_ibfk_2` FOREIGN KEY (`Kategoria`) REFERENCES `kategorie` (`ID_Kategorii`);

--
-- Ograniczenia dla tabeli `oceny_filmow`
--
ALTER TABLE `oceny_filmow`
  ADD CONSTRAINT `oceny_filmow_ibfk_1` FOREIGN KEY (`Film`) REFERENCES `filmy` (`ID_Filmu`),
  ADD CONSTRAINT `oceny_filmow_ibfk_2` FOREIGN KEY (`Uzytkownik`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`);

--
-- Ograniczenia dla tabeli `pokazy`
--
ALTER TABLE `pokazy`
  ADD CONSTRAINT `pokazy_ibfk_1` FOREIGN KEY (`Film`) REFERENCES `filmy` (`ID_Filmu`),
  ADD CONSTRAINT `pokazy_ibfk_2` FOREIGN KEY (`Sala`) REFERENCES `sale` (`ID_Sali`);

--
-- Ograniczenia dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`Pokaz`) REFERENCES `pokazy` (`ID_Pokazu`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`Uzytkownik`) REFERENCES `uzytkownicy` (`ID_Uzytkownika`);

--
-- Ograniczenia dla tabeli `szczegoly_rezerwacji`
--
ALTER TABLE `szczegoly_rezerwacji`
  ADD CONSTRAINT `szczegoly_rezerwacji_ibfk_1` FOREIGN KEY (`Rezerwacja`) REFERENCES `rezerwacje` (`ID_Rezerwacji`),
  ADD CONSTRAINT `szczegoly_rezerwacji_ibfk_2` FOREIGN KEY (`Bilet`) REFERENCES `bilety` (`ID_Biletu`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
