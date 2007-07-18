<?php
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

#UserSeites
define("SYSTEM_USERSITESM",	 "2"); #1=MYSQL 2=FileSystem
define("SYSTEM_USERSITESF",  "UserSites/"); #muss nur beim FileSystem Mod gesetzt sein
?>