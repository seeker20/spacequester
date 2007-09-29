<?php

$con_id = @mysql_connect(SQL_HOST,SQL_USER,SQL_PASS,SQL_DATA);

if(!$con_id)
{
	fehler("sql.connect.php","0xdb001");
	exit();
}
mysql_select_db(SQL_DATA,$con_id);
?>

