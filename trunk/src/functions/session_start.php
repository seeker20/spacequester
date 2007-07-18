<?php
define("CMS", true);

if(!is_file("configs/config.inc.php")) $add="../";
else $add="";

include $add."configs/config.inc.php";
include $add.SYSTEM_FUNCTIONS . "engine.inc.php";
include $add.SYSTEM_FUNCTIONS . "stringmanipulation.inc.php";
include $add.SYSTEM_FUNCTIONS . "phpexectue.inc.php";
include $add.SYSTEM_FUNCTIONS . "phpbb.inc.php";
include $add.SYSTEM_FUNCTIONS . "helptools.inc.php";
include $add.SYSTEM_FUNCTIONS . "security.inc.php";

if(SYSTEM_db_mod=="1") {
	include $add.SYSTEM_FUNCTIONS . "mysqldb.inc.php";
}
else {
	include $add.SYSTEM_FUNCTIONS . "textdb.inc.php";
}

$db = new db();
if(SYSTEM_db_mod=="1") {
	$db->init(SYSTEM_dbpref,SYSTEM_dburl,SYSTEM_dbuser,SYSTEM_dbpass,SYSTEM_dbname);
}
else {
	$db->init(SYSTEM_dbpref,SYSTEM_dbpath);
}


if(SYSTEM_SESSION_mod=="1") {
	require_once $add.SYSTEM_FUNCTIONS . "session.mysql.inc.php";
}
else {
	require_once $add.SYSTEM_FUNCTIONS . "session.text.inc.php";
}
ob_start();

sstartSession();
?>