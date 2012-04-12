--
-- Tabellenstruktur für Tabelle
--

CREATE TABLE IF NOT EXISTS `aufgaben` (
  `id` mediumint(9) NOT NULL auto_increment,
  `text` text NOT NULL,
  `datecreated` int(11) NOT NULL default '0',
  `datecompleted` int(11) NOT NULL default '0',
  `completed` tinyint(4) NOT NULL default '0',
  `priority` tinyint(4) NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



--
-- Daten für Tabelle
--

INSERT INTO `aufgaben` (`id`, `text`, `datecreated`, `datecompleted`, `completed`, `priority`) VALUES
(1, 'Aufgabe 1', 1333906869, 0, 0, 3),
(2, 'Aufgabe 2', 1333906871, 0, 0, 2),
(3, 'Aufgabe 4', 1333906873, 0, 0, 1),
(4, 'Aufgabe 3', 1333907150, 1333907151, 1, 2);
