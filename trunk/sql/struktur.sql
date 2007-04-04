-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 04. April 2007 um 15:05
-- Server Version: 5.0.27
-- PHP-Version: 5.2.0
-- 
-- Datenbank: `spacequester`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_acces`
-- 

DROP TABLE IF EXISTS `s1_acces`;
CREATE TABLE IF NOT EXISTS `s1_acces` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(255) collate latin1_general_ci NOT NULL,
  `acces_groups` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_admin`
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

DROP TABLE IF EXISTS `s1_menue`;
CREATE TABLE IF NOT EXISTS `s1_menue` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `log` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_news`
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
-- Tabellenstruktur für Tabelle `s1_sessions`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_sites`
-- 

DROP TABLE IF EXISTS `s1_sites`;
CREATE TABLE IF NOT EXISTS `s1_sites` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `feld` int(11) NOT NULL,
  `feldpos` int(11) NOT NULL,
  `type` enum('user','system','modul') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `s1_todo`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;
