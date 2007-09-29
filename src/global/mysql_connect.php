<?php

$host     = "localhost";
$user     = "game";
$passwort = "game";
$database = "game";

$con_id = @mysql_connect($host, $user, $passwort);

if(!$con_id)
{
	echo "Fehler beim einwahlen ins DB\n";
	exit();
}

mysql_select_db($database,$con_id);

?>
