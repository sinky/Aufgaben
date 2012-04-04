--
-- Tabellenstruktur für Tabelle `aufgaben`
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
