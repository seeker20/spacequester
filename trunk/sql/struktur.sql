-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 18. Juli 2007 um 16:55
-- Server Version: 5.0.27
-- PHP-Version: 5.2.0
-- 
-- Datenbank: `spacequester`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_acces`
-- 
-- Erzeugt am: 04. April 2007 um 14:52
-- Aktualisiert am: 18. Juli 2007 um 15:07
-- 

DROP TABLE IF EXISTS `s1_acces`;
CREATE TABLE IF NOT EXISTS `s1_acces` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(255) collate latin1_general_ci NOT NULL,
  `acces_groups` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_admin`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:24
-- 

DROP TABLE IF EXISTS `s1_admin`;
CREATE TABLE IF NOT EXISTS `s1_admin` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(16) NOT NULL default '0.0.0.0',
  `securekey` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_admin_menue`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:25
-- 

DROP TABLE IF EXISTS `s1_admin_menue`;
CREATE TABLE IF NOT EXISTS `s1_admin_menue` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_gbuch`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:12
-- 

DROP TABLE IF EXISTS `s1_gbuch`;
CREATE TABLE IF NOT EXISTS `s1_gbuch` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_links`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:12
-- 

DROP TABLE IF EXISTS `s1_links`;
CREATE TABLE IF NOT EXISTS `s1_links` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_menue`
-- 
-- Erzeugt am: 18. Juli 2007 um 14:30
-- Aktualisiert am: 18. Juli 2007 um 16:49
-- 

DROP TABLE IF EXISTS `s1_menue`;
CREATE TABLE IF NOT EXISTS `s1_menue` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `acces_groups` varchar(255) NOT NULL,
  `menue_id` int(11) NOT NULL,
  `top_entry` int(11) NOT NULL,
  `pos` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_news`
-- 
-- Erzeugt am: 18. März 2007 um 16:36
-- Aktualisiert am: 18. März 2007 um 17:38
-- 

DROP TABLE IF EXISTS `s1_news`;
CREATE TABLE IF NOT EXISTS `s1_news` (
  `id` int(11) NOT NULL auto_increment,
  `topic` varchar(255) collate latin1_general_ci NOT NULL,
  `text` text collate latin1_general_ci NOT NULL,
  `date` varchar(255) collate latin1_general_ci NOT NULL,
  `autor` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_pics`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:12
-- 

DROP TABLE IF EXISTS `s1_pics`;
CREATE TABLE IF NOT EXISTS `s1_pics` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `katid` int(9) NOT NULL,
  `katname` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_pmmessages`
-- 
-- Erzeugt am: 18. Juli 2007 um 15:01
-- Aktualisiert am: 18. Juli 2007 um 15:01
-- 

DROP TABLE IF EXISTS `s1_pmmessages`;
CREATE TABLE IF NOT EXISTS `s1_pmmessages` (
  `id` int(11) NOT NULL auto_increment,
  `idabse` int(11) NOT NULL,
  `idempf` int(11) NOT NULL,
  `betreff` text collate latin1_general_ci NOT NULL,
  `message` text collate latin1_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('gelesen','ungelesen','neu') collate latin1_general_ci NOT NULL,
  `folder` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_sessions`
-- 
-- Erzeugt am: 18. Juli 2007 um 16:11
-- Aktualisiert am: 18. Juli 2007 um 16:51
-- 

DROP TABLE IF EXISTS `s1_sessions`;
CREATE TABLE IF NOT EXISTS `s1_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `sessionid` text NOT NULL,
  `namea` text NOT NULL,
  `valuea` text NOT NULL,
  `erstellt` text NOT NULL,
  `erstellt_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_ships`
-- 
-- Erzeugt am: 18. Juli 2007 um 16:12
-- Aktualisiert am: 18. Juli 2007 um 16:12
-- 

DROP TABLE IF EXISTS `s1_ships`;
CREATE TABLE IF NOT EXISTS `s1_ships` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `shipname` varchar(255) collate latin1_general_ci NOT NULL,
  `shipfilename` varchar(255) collate latin1_general_ci NOT NULL,
  `inhalt_db_id` int(11) NOT NULL,
  `waffen_db_id` int(11) NOT NULL,
  `healt` varchar(255) collate latin1_general_ci NOT NULL,
  `shield` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_sites`
-- 
-- Erzeugt am: 18. Juli 2007 um 15:04
-- Aktualisiert am: 18. Juli 2007 um 15:12
-- 

DROP TABLE IF EXISTS `s1_sites`;
CREATE TABLE IF NOT EXISTS `s1_sites` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `feld` int(11) NOT NULL,
  `feldpos` int(11) NOT NULL,
  `type` enum('user','system','modul') NOT NULL,
  `acces_groups` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_todo`
-- 
-- Erzeugt am: 18. März 2007 um 16:12
-- Aktualisiert am: 18. März 2007 um 17:12
-- 

DROP TABLE IF EXISTS `s1_todo`;
CREATE TABLE IF NOT EXISTS `s1_todo` (
  `id` int(11) NOT NULL auto_increment,
  `todo` varchar(255) NOT NULL,
  `status` enum('geplannt','bearbeitung','fertig') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_users`
-- 
-- Erzeugt am: 04. April 2007 um 14:24
-- Aktualisiert am: 13. Juni 2007 um 20:53
-- 

DROP TABLE IF EXISTS `s1_users`;
CREATE TABLE IF NOT EXISTS `s1_users` (
  `id` int(11) NOT NULL auto_increment,
  `uname` varchar(255) collate latin1_general_ci NOT NULL,
  `pass` text collate latin1_general_ci NOT NULL,
  `email` varchar(255) collate latin1_general_ci NOT NULL,
  `rname` varchar(255) collate latin1_general_ci NOT NULL,
  `gyear` date NOT NULL,
  `rkey` text collate latin1_general_ci NOT NULL,
  `class` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;
