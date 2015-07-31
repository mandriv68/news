-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 16 2015 г., 23:37
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `news`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `art_id` int(5) NOT NULL AUTO_INCREMENT,
  `art_title` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `art_description` text NOT NULL,
  `art_text` text NOT NULL,
  `art_author` varchar(255) NOT NULL,
  `art_datetime` datetime NOT NULL,
  `art_category` int(5) NOT NULL,
  PRIMARY KEY (`art_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`art_id`, `art_title`, `art_description`, `art_text`, `art_author`, `art_datetime`, `art_category`) VALUES
(1, 'Новость №1. AUDI', 'Ребята из Ингольштадта празднуют в 2009 году юбилей, поэтому разработок и новинок у них хоть отбавляй. И, как ни странно, общий уровень продаж у них растет. В скором времени из конюшен Audi выкатятся новые кабриолеты A5 и S5 (причем с новыми двигателями), R8 получит новый мотор V10 объемом 5,2 литра. Но самое главное, Audi выпустит новый седан S4.', '<p>Ребята из Ингольштадта празднуют в 2009 году юбилей, поэтому разработок и новинок у них хоть отбавляй. И, как ни странно, общий уровень продаж у них растет. В скором времени из конюшен Audi выкатятся новые кабриолеты A5 и S5 (причем с новыми двигателями), R8 получит новый мотор V10 объемом 5,2 литра. Но самое главное, Audi выпустит новый седан S4.</p>\r\n<p align="center"><img src="file/audi.jpg"></p>\r\n<p>Новая Audi S4 доказывает, что немцы всерьез взялись за спортивные седаны. Гонка с BMW не прекращается и это нам только на руку. S4 2010 года получит 3-литровый мотор TFSI V6. Этот турбодвигатель производит 333 лошади с крутящим моментом 440 Нм. Этого вполне достаточно, чтобы каждый день бороться за превосходство «четырех колец» на дорогах. Добавим к этому быструю 6-ступенчатую механику и новый 7-ступенчатый автомат с двумя сцеплениями, полный привод quattro и получим 5,1 секунды до 100 км/ч. Напоследок, Audi S4 будет еще и экономичной – 13,5 литров по городу. Стоить Audi S4 2010 будет от 49 тыс. долларов США.\r\n\r\n</p>', 'Пупкин', '2015-07-13 05:10:00', 1),
(2, 'Новость №2 BMW', 'Эта специальная серия была выпущена для омологации, чтобы допустить M3 к участию в гонках серии FIA GT 2 и IMSA GT USA. Всего было выпущено 356 экземпляров (350 + 6 прототипов). Все автомобили окрашивались в цвет British Racing Green и отличались форсированным до 295 лошадиных сил двигателем, а также развитым передним спойлером и задним антикрылом.', '<p>Эта специальная серия была выпущена для омологации, чтобы допустить M3 к участию в гонках серии FIA GT 2 и IMSA GT USA. Всего было выпущено 356 экземпляров (350 + 6 прототипов). Все автомобили окрашивались в цвет British Racing Green и отличались форсированным до 295 лошадиных сил двигателем, а также развитым передним спойлером и задним антикрылом.</p>\r\n<p align="center"><img src="file/bmw.jpg"></p>\r\n<h3>Отличительные особенности версии M3 GT:</h3>\r\n<h3><img align="right" src="file/08.06.2010/bmw (2).jpg" />Экстерьер:</h3>\r\n\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">единственный цвет: тёмно-зелёный металлик &quot;British Racing Green&quot; </li>\r\n  <li class="list_type">заднее антикрыло и спойлер переднего бампера с разделителем воздушного потока для улучшения       аэродинамики и прижимной силы </li>\r\n  <li class="list_type">логотипы&nbsp;&quot;BMW Motorsport International&quot; на молдингах дверей </li>\r\n\r\n<li class="list_type">легкосплавные&nbsp;колёсные диски BMW Motorsport  &quot;Forget M Double Spoke&quot; (7.5Jx17&quot;-передние,  8.5Jx17&quot;-задние)</li></ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p> \r\n<br>\r\n<br>\r\n<br>\r\n<h3><img align="right" src="file/08.06.2010/autowp.ru_61.jpg" />Интерьер:</h3>\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">Обивка центральной&nbsp;части       сидений и вставок дверных панелей с дверными ручками&nbsp;-       зелёная&nbsp;кожа&nbsp;Nappa Mexico Green. </li>\r\n  <li class="list_type">Отделка карбоном центральной       консоли, карбоновые накладки с логотипами &quot;BMW Motorsport       International&quot; на внутренней части дверных порогов.</li>\r\n  <li class="list_type">Трёхспицевый руль с подушкой       безопасности </li>\r\n\r\n<li class="list_type">Карбоновая планка с шильдиком &quot;BMW Motorsport  International Limited Edition&quot; над крышкой перчаточного ящика</li></ul>\r\n<p>&nbsp;</p>\r\n<br>\r\n<br>\r\n<br>\r\n<h3><img align="right" src="file/autowp.ru_71.jpg" />Технические:</h3>\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">Двигатель объёмом 3 литра и       мощностью 295 л.с. (серийно 3,0 литра 286 л.с.) </li>\r\n  <li class="list_type">Облегчённые двери из алюминия</li>\r\n  <li class="list_type">Более жёсткая подвеска</li>\r\n  <li class="list_type">Распорка передних стоек </li>\r\n</ul>\r\n<p>Стоимость M3 GT Coupe на момент выхода  DM 91.000.- </p>', 'Сидоров', '2015-07-13 06:35:00', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(5) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Политика'),
(2, 'Культура');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
