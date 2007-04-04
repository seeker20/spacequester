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

-- 
-- Daten für Tabelle `s1_acces`
-- 


-- 
-- Daten für Tabelle `s1_admin`
-- 

INSERT INTO `s1_admin` VALUES (13, 'fkrauthan', 'deba5ebc6d72f0bafb498aa7a73300ea', '127.0.0.1', 'dbakeyspacequester');

-- 
-- Daten für Tabelle `s1_admin_menue`
-- 

INSERT INTO `s1_admin_menue` VALUES (8, 'Übersicht', 'main.php?ltarget=global');
INSERT INTO `s1_admin_menue` VALUES (9, 'Admin''s', 'main.php?ltarget=admins');
INSERT INTO `s1_admin_menue` VALUES (10, 'UserSites', 'main.php?ltarget=usites');
INSERT INTO `s1_admin_menue` VALUES (11, 'Module', 'main.php?ltarget=module');

-- 
-- Daten für Tabelle `s1_gbuch`
-- 


-- 
-- Daten für Tabelle `s1_links`
-- 


-- 
-- Daten für Tabelle `s1_menue`
-- 

INSERT INTO `s1_menue` VALUES (10, 'Home', 'main.php?target=home', 0);
INSERT INTO `s1_menue` VALUES (11, 'News', 'main.php?starget=news', 0);
INSERT INTO `s1_menue` VALUES (12, 'Gästebuch', 'main.php?starget=gbuch', 0);
INSERT INTO `s1_menue` VALUES (13, 'Regiestrieren', 'main.php?starget=reg', 0);
INSERT INTO `s1_menue` VALUES (14, 'Login', 'main.php?starget=loginpanel', 0);

-- 
-- Daten für Tabelle `s1_news`
-- 

INSERT INTO `s1_news` VALUES (1, 'NeuAnfang', 'Ich habe heute damit begonnen das Komplete Browsergame neu\r\nzu schreiben. Als grundlage dient nun das Phönix View CMS\r\nwas eine Leichtere Modul verwaltung und einfachere Template\r\nEinsetzung ermöglicht. Ich werde schaun das ich nach dem\r\nSki Lager anfange teile die gut funktionirt haben zu\r\nportiren und den Style an den alten SpaceQuester Style\r\nanpassen.\r\nMFG,\r\nfkrauthan', '18.03.2007 16:36:36', 'fkrauthan');

-- 
-- Daten für Tabelle `s1_pics`
-- 


-- 
-- Daten für Tabelle `s1_sessions`
-- 

INSERT INTO `s1_sessions` VALUES (148, '75k0snvds4p642q', '', '', '1175691113', '2007-04-04');
INSERT INTO `s1_sessions` VALUES (149, 'l4m7xsk8sthg2', 'JavaScript|#|style|#|sitentitle|#|Cookies|#|lastaction|#|ltarget|#|target|#|starget|#|login|#|acces|#|adminskey|#|adminid|#|lastsecaction', '1|#|spacequester|#|home|#|1|#|2|#|module|#|home|#|admin|#|2#|#fkrauthan|#|1|#|adminkeySpecial123|#|13|#|', '1175691806', '2007-04-04');
INSERT INTO `s1_sessions` VALUES (147, 'fy4g59hkwpyav6c', 'JavaScript|#|style|#|sitentitle|#|Cookies|#|lastaction|#|ltarget|#|target|#|login|#|acces|#|starget', '1|#|spacequester|#|home|#|1|#|1|#||#|home|#|2#|#fkrauthan|#|0|#|news', '1175691106', '2007-04-04');
INSERT INTO `s1_sessions` VALUES (146, '92pq0n4860u055f', '', '', '1175690837', '2007-04-04');
INSERT INTO `s1_sessions` VALUES (144, '5uc8eh80830b2o4', '', '', '1175688537', '2007-04-04');
INSERT INTO `s1_sessions` VALUES (145, 'y4mq384u0kb4789', 'JavaScript|#|style|#|sitentitle|#|Cookies|#|target|#|login|#|lastaction|#|ltarget|#|starget', '1|#|spacequester|#|home|#|1|#|home|#|2#|#fkrauthan|#|2|#||#|news', '1175690822', '2007-04-04');

-- 
-- Daten für Tabelle `s1_sites`
-- 

INSERT INTO `s1_sites` VALUES (9, 'UserPanel', 'userpanel.php', 1, 0, 'system');
INSERT INTO `s1_sites` VALUES (10, 'Menue', 'menue.php', 2, 0, 'system');
INSERT INTO `s1_sites` VALUES (11, 'InhaltderWebseite', 'frame.php', 3, 0, 'system');
INSERT INTO `s1_sites` VALUES (12, 'LoginPanel', 'loginpanel.php', 2, 0, 'system');
INSERT INTO `s1_sites` VALUES (13, 'Game InfoBar', 'infobar.php', 4, 0, 'system');
INSERT INTO `s1_sites` VALUES (14, 'Game Menü', 'menue.php', 5, 0, 'system');

-- 
-- Daten für Tabelle `s1_todo`
-- 


-- 
-- Daten für Tabelle `s1_users`
-- 

INSERT INTO `s1_users` VALUES (2, 'fkrauthan', 'deba5ebc6d72f0bafb498aa7a73300ea', 'fkrauthan@gmx.net', 'Florian Krauthan', '0000-00-00', '', 0, 1);
