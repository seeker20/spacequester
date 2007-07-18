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

-- 
-- Daten für Tabelle `s1_acces`
-- 

INSERT IGNORE INTO `s1_acces` (`id`, `file`, `acces_groups`) VALUES (1, 'ghaupt.site', '1');
INSERT IGNORE INTO `s1_acces` (`id`, `file`, `acces_groups`) VALUES (2, 'pminterface.php', '1');

-- 
-- Daten für Tabelle `s1_admin`
-- 

INSERT IGNORE INTO `s1_admin` (`id`, `name`, `password`, `ip`, `securekey`) VALUES (13, 'fkrauthan', 'deba5ebc6d72f0bafb498aa7a73300ea', '127.0.0.1', 'dbakeyspacequester');

-- 
-- Daten für Tabelle `s1_admin_menue`
-- 

INSERT IGNORE INTO `s1_admin_menue` (`id`, `name`, `target`) VALUES (8, 'Übersicht', 'main.php?ltarget=global');
INSERT IGNORE INTO `s1_admin_menue` (`id`, `name`, `target`) VALUES (9, 'Admin''s', 'main.php?ltarget=admins');
INSERT IGNORE INTO `s1_admin_menue` (`id`, `name`, `target`) VALUES (10, 'UserSites', 'main.php?ltarget=usites');
INSERT IGNORE INTO `s1_admin_menue` (`id`, `name`, `target`) VALUES (11, 'Module', 'main.php?ltarget=module');

-- 
-- Daten für Tabelle `s1_gbuch`
-- 


-- 
-- Daten für Tabelle `s1_links`
-- 


-- 
-- Daten für Tabelle `s1_menue`
-- 

INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (10, 'Home', 'main.php?target=home', '', 0, 0, 0);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (11, 'News', 'main.php?starget=news', '', 0, 0, 1);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (12, 'Gästebuch', 'main.php?starget=gbuch', '', 0, 0, 2);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (13, 'Regiestrieren', 'main.php?starget=reg', '', 0, 0, 3);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (14, 'Login', 'main.php?starget=loginpanel', '', 0, 0, 4);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (15, 'Übersicht', 'main.php?target=ghaupt', '1', 1, 0, 0);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (16, 'PM Nachrichten', 'main.php?starget=pminterface', '1', 1, 0, 1);
INSERT IGNORE INTO `s1_menue` (`id`, `name`, `target`, `acces_groups`, `menue_id`, `top_entry`, `pos`) VALUES (17, 'Logout', 'main.php?starget=logout', '1', 1, 0, 2);

-- 
-- Daten für Tabelle `s1_news`
-- 

INSERT IGNORE INTO `s1_news` (`id`, `topic`, `text`, `date`, `autor`) VALUES (1, 'NeuAnfang', 'Ich habe heute damit begonnen das Komplete Browsergame neu\r\nzu schreiben. Als grundlage dient nun das Phönix View CMS\r\nwas eine Leichtere Modul verwaltung und einfachere Template\r\nEinsetzung ermöglicht. Ich werde schaun das ich nach dem\r\nSki Lager anfange teile die gut funktionirt haben zu\r\nportiren und den Style an den alten SpaceQuester Style\r\nanpassen.\r\nMFG,\r\nfkrauthan', '18.03.2007 16:36:36', 'fkrauthan');

-- 
-- Daten für Tabelle `s1_pics`
-- 


-- 
-- Daten für Tabelle `s1_pmmessages`
-- 


-- 
-- Daten für Tabelle `s1_sessions`
-- 

INSERT IGNORE INTO `s1_sessions` (`id`, `sessionid`, `namea`, `valuea`, `erstellt`, `erstellt_date`) VALUES (1, '77c521l55k74e', 'JavaScript|#|style|#|sitentitle|#|Cookies|#|lastaction|#|target|#|ship|#|starget|#|adminskey|#|adminid', '1|#|spacequester|#|home|#|1|#|2|#|ghaupt|#|1#|#My Ship|#|impressum|#|adminkeySpecial123|#|13', '1184770291', '2007-07-18');

-- 
-- Daten für Tabelle `s1_ships`
-- 

INSERT IGNORE INTO `s1_ships` (`id`, `userid`, `shipname`, `shipfilename`, `inhalt_db_id`, `waffen_db_id`, `healt`, `shield`) VALUES (1, 2, 'My Ship', 'bvfighter.xml', 0, 0, '500#500', '500#500');

-- 
-- Daten für Tabelle `s1_sites`
-- 

INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (9, 'UserPanel', 'userpanel.php', 1, 0, 'system', '', '');
INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (10, 'Menue', 'menue.php', 2, 0, 'system', '0', '$MENUE_NAME=''Menü'';');
INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (11, 'InhaltderWebseite', 'frame.php', 3, 0, 'system', '', '');
INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (12, 'LoginPanel', 'loginpanel.php', 2, 1, 'system', '0', '');
INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (13, 'Game InfoBar', 'infobar.php', 4, 0, 'system', '', '');
INSERT IGNORE INTO `s1_sites` (`id`, `name`, `adress`, `feld`, `feldpos`, `type`, `acces_groups`, `params`) VALUES (15, 'InGameMenü', 'menue.php', 2, 0, 'system', '1', '$MENUE_NAME=''Navigation'';\r\n$MENUE_ID=''1'';');

-- 
-- Daten für Tabelle `s1_todo`
-- 


-- 
-- Daten für Tabelle `s1_users`
-- 

INSERT IGNORE INTO `s1_users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `class`, `group`) VALUES (2, 'fkrauthan', 'deba5ebc6d72f0bafb498aa7a73300ea', 'fkrauthan@gmx.net', 'Florian Krauthan', '0000-00-00', '', 0, 1);
INSERT IGNORE INTO `s1_users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `class`, `group`) VALUES (3, 'PMTheQuick', '982df3ceccf25e6231970e8504dddf77', 'pamado@interGGA.ch', 'Pascal Mathis', '0000-00-00', '7q34V900Iy23OAKeT1', 0, 1);
INSERT IGNORE INTO `s1_users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `class`, `group`) VALUES (4, 'ch100', '131ab0607605332bea6a53a7bff79bc0', 'ch100@gmx.net', '', '0000-00-00', '', 0, 1);
INSERT IGNORE INTO `s1_users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `class`, `group`) VALUES (5, 'DerBlonde', '3cea65f5d20072cb93abb02bdd4b62c2', 'Matthias_Lochbrunner@web.de', 'Matthias', '0000-00-00', '', 0, 1);
