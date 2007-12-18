-- phpMyAdmin SQL Dump
-- version 2.9.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 21. November 2006 um 18:26
-- Server Version: 5.0.27
-- PHP-Version: 5.2.0
-- 
-- Datenbank: `game`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `alianzen`
-- 

CREATE TABLE `alianzen` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `internetext` text NOT NULL,
  `externetext` text NOT NULL,
  `bewerbungstext` text NOT NULL,
  `datum` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `gruender` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `alianzen`
-- 

INSERT INTO `alianzen` VALUES (1, '-=Microsoft=-', '-=MS=-', 'Test2', 'Test1', 'Test3', '', '', '', 'Damian');
INSERT INTO `alianzen` VALUES (2, 'die ch100\\''s', 'CH100', '', '', '', '', '', '', 'ch100');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `allyraenge`
-- 

CREATE TABLE `allyraenge` (
  `id` int(3) NOT NULL auto_increment,
  `allyid` int(3) NOT NULL,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  `AA` tinyint(1) NOT NULL,
  `UK` tinyint(1) NOT NULL,
  `BW` tinyint(1) NOT NULL,
  `ML` tinyint(1) NOT NULL,
  `RM` tinyint(1) NOT NULL,
  `AV` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `allyraenge`
-- 

INSERT INTO `allyraenge` VALUES (1, 1, 'TestRang', 1, 1, 1, 1, 1, 1);
INSERT INTO `allyraenge` VALUES (2, 1, 'TestRang2', 0, 1, 1, 0, 0, 0);
INSERT INTO `allyraenge` VALUES (3, 1, 'Second Gründer', 1, 1, 1, 1, 1, 1);
INSERT INTO `allyraenge` VALUES (4, 2, 'Co Gründer', 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bewerbungen`
-- 

CREATE TABLE `bewerbungen` (
  `id` int(11) NOT NULL auto_increment,
  `allyid` int(3) NOT NULL,
  `user` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `datum` varchar(255) NOT NULL,
  `type` enum('bewerbung','einladung') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Daten für Tabelle `bewerbungen`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bugs`
-- 

CREATE TABLE `bugs` (
  `id` int(3) NOT NULL auto_increment,
  `owner` varchar(255) collate latin1_general_ci NOT NULL,
  `ip` varchar(255) collate latin1_general_ci NOT NULL,
  `url` varchar(255) collate latin1_general_ci NOT NULL,
  `beschreibung` text collate latin1_general_ci NOT NULL,
  `status` enum('gemeldet','in arbeit','behoben') collate latin1_general_ci NOT NULL,
  `kommentar` text collate latin1_general_ci NOT NULL,
  `datum` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `bugs`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `error`
-- 

CREATE TABLE `error` (
  `id` int(11) NOT NULL auto_increment,
  `datum` varchar(255) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `status` enum('hinweis','nachfrage','danger','critical') NOT NULL default 'hinweis',
  `neu` enum('ja','nein') NOT NULL default 'ja',
  `user` varchar(255) NOT NULL default '',
  `ip` varchar(255) NOT NULL default '',
  `was` text NOT NULL,
  `system` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `error`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mail`
-- 

CREATE TABLE `mail` (
  `id` int(11) NOT NULL auto_increment,
  `absender` varchar(255) NOT NULL,
  `empfaenger` varchar(255) NOT NULL,
  `datum` varchar(255) NOT NULL,
  `status` enum('neu','gelesen','papierkorb','geloescht') NOT NULL,
  `owner` enum('ausgang','geloescht') NOT NULL,
  `titel` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `mail`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `news`
-- 

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `datum` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `news`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schiffe`
-- 

CREATE TABLE `schiffe` (
  `id` int(11) NOT NULL auto_increment,
  `schiffsid` varchar(255) NOT NULL default '',
  `userid` int(11) NOT NULL default '0',
  `schifstypid` int(11) NOT NULL default '0',
  `schild` int(3) NOT NULL default '100',
  `huelle` int(3) NOT NULL default '100',
  `waffen` text NOT NULL,
  `ausruestung` text NOT NULL,
  `lager` text NOT NULL,
  `x` int(3) NOT NULL default '0',
  `y` int(3) NOT NULL default '0',
  `sector` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `schiffe`
-- 

INSERT INTO `schiffe` VALUES (1, 'Damian', 1, 2, 100, 100, '', '', '', 4, 4, 2);
INSERT INTO `schiffe` VALUES (2, 'MasterShip', 2, 0, 100, 100, '', '', '', 2, 4, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schiffs_auftraege`
-- 

CREATE TABLE `schiffs_auftraege` (
  `id` int(11) NOT NULL auto_increment,
  `schiffsid` varchar(255) NOT NULL default '',
  `pos_array` text NOT NULL,
  `time_array` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `schiffs_auftraege`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `screen`
-- 

CREATE TABLE `screen` (
  `id` int(11) NOT NULL auto_increment,
  `kat` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `datum` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `screen`
-- 

INSERT INTO `screen` VALUES (1, '', '1.png', 'Aufgenommen in der Zeit der entwicklung von Damian', '2006-10-17 20:30:01');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `station`
-- 

CREATE TABLE `station` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `sector` int(3) NOT NULL,
  `x` int(3) NOT NULL,
  `y` int(3) NOT NULL,
  `einwohner` int(3) NOT NULL,
  `groesse` int(3) NOT NULL,
  `res` text NOT NULL,
  `nachfrage` text NOT NULL,
  `produktion` text NOT NULL,
  `typ` enum('station','planet') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `station`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `users`
-- 

CREATE TABLE `users` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `lastlogin` varchar(255) NOT NULL default '',
  `lastip` varchar(255) NOT NULL default '',
  `regdate` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `credits` int(3) NOT NULL default '0',
  `schifid` int(3) NOT NULL default '0',
  `beruf` int(3) NOT NULL default '0',
  `alianzid` int(3) NOT NULL,
  `rangid` int(3) NOT NULL,
  `lastaction` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `users`
-- 

INSERT INTO `users` VALUES (1, 'Damian', '9935f3f5e3914a65a4262feb215bc0fe', 'damian@tss-clan.eu', '18.10.2006', '127.0.0.1', '17.10.2006', '', 5000, 1, 2, 1, 1, '');
-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `wichtige_nachrichten`
-- 

CREATE TABLE `wichtige_nachrichten` (
  `id` int(11) NOT NULL auto_increment,
  `von` varchar(255) NOT NULL,
  `datum` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `target` enum('all','alianz') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `wichtige_nachrichten`
-- 

INSERT INTO `wichtige_nachrichten` VALUES (1, 'Administration', '18.10.2006', 'Test', 'Hiermit teste ich das "wichtige" mail system', 'all');
INSERT INTO `wichtige_nachrichten` VALUES (2, 'fkrauthan', '21.11.2006 17:40', 'Einladungen', 'Einladungen können nun abgewissen werden annehmen kommt später.', 'all');

ALTER TABLE `users` ADD `status` ENUM( 'Benutzer', 'Admin' ) NOT NULL ;
