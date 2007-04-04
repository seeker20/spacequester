<?php
$CMS = true;
include "configs/config.inc.php";
include SYSTEM_FUNCTIONS . "engine.inc.php";
include SYSTEM_FUNCTIONS . "stringmanipulation.inc.php";
include SYSTEM_FUNCTIONS . "phpexectue.inc.php";
include SYSTEM_FUNCTIONS . "phpbb.inc.php";
include SYSTEM_FUNCTIONS . "helptools.inc.php";

if(SYSTEM_db_mod=="1") {
	include SYSTEM_FUNCTIONS . "mysqldb.inc.php";
}
else {
	include SYSTEM_FUNCTIONS . "textdb.inc.php";
}

$db = new db();
if(SYSTEM_db_mod=="1") {
	$db->init(SYSTEM_dbpref,SYSTEM_dburl,SYSTEM_dbuser,SYSTEM_dbpass,SYSTEM_dbname);
}
else {
	$db->init(SYSTEM_dbpref,SYSTEM_dbpath);
}


if(SYSTEM_SESSION_mod=="1") {
	require_once SYSTEM_FUNCTIONS . "session.mysql.inc.php";
}
else {
	require_once SYSTEM_FUNCTIONS . "session.text.inc.php";
}
ob_start();

sstartSession();
?>