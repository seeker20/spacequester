<?php
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

#Update URL
define("SYSTEM_UPDATE_URL", "../src-services/"); #Link dahin von wo er die updates beziehen soll
define("SYSTEM_UPDATE_AUTO","OFF"); #Soll er automaitsch auf Updates prüfen

#DB-Daten
define("SYSTEM_db_mod",		"1"); #1=MYSQL 2=FileSystem
define("SYSTEM_dbpref", 	"s1_"); # DB Prefix muss für beide gestet werden
define("SYSTEM_dbname", 	"spacequester");
define("SYSTEM_dbuser", 	"spacequester");
define("SYSTEM_dbpass", 	"");
define("SYSTEM_dburl",  	"localhost");
define("SYSTEM_dbpath",		"textdb/"); #muss nur beim FileSystem Mod gesetzt sein

#System Functions
define("SYSTEM_FUNCTIONS", 	"functions/");

#title
define("SYSTEM_TITLE", 		"SpaceQuester Returns");

#version
define("SYSTEM_VERSION", 	"0.1 pre Alpha1.9");

#Standard-Style
define("SYSTEM_STYLE_PATH", "styles/");
define("SYSTEM_STYLE",     	"spacequester");
define("SYSTEM_STYLE_IMAGE_PATH", "/images/");

#Plugins
define("SYSTEM_plugin_path", "system_module/"); #System Modul Pfad

#System start
define("SYSTEM_start",       "home");
#Module
define("SYSTEM_modul_path",  "module/"); #Pfad zu den Modulen
#System
define("SYSTEM_system_path", "system_module/"); #System Modul Pfad

#ErrorSeits Intern
define("SYSTEM_ERROR_FOLDER", ""); #Eroro File Folder
define("SYSTEM_ERROR_FILE",   ""); #ErrorFile

#Pictures
define("SYSTEM_PIC_path",	   "daten/pictures/"); # Pfad zu den Bildern

#Sicherheits schlüssel
define("SYSTEM_ADMIN_lkey",    "loginkeySpecial123"); #loign secrutiy key
define("SYSTEM_ADMIN_skey",    "adminkeySpecial123"); #admin secrutiy key
define("SYSTEM_ADMIN_dkey",    "dbasekeySpecial123"); #db admin secrutiy key

#Session Verwatlung
define("SYSTEM_SESSION_mod",   "1"); #1 Bei Mysql Session verwatlung und 2 bei TextFileSessio verwatlung 
define("SYSTEM_SESSION_path",  "daten/sessions/"); #Pfad zu den Session Datein muss nur gestezt sein wenn mod auf 1 steht
define("SYSTEM_SESSION_halt",  "0"); #WIe lange eine Session hält

#Daten zum ADmin bereich
define("SYSTEM_ADMIN_path",    "admin/"); #Pfad zu den Admin daten
define("SYSTEM_ADMIN_start",   "global"); #ADmin Start seite
define("SYSTEM_ADMIN_editor",  "admin/seditor/editor.php"); #Seiten Editor

#Modul datas
define("SYSTEM_ADMIN_minst",   "daten/install_packages/"); #Pfad wo die Installdaten von Modulen liegt
define("SYSTEM_ADMIN_infosm",  "2"); #Modus wohin die Daten gepsicehrt werden sollen von INstalierten Modulen
define("SYSTEM_ADMIN_infosp",  "daten/installd_moduls/"); #Pfad wo daten gepsichert werden bei mod=2
?>