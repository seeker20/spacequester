<?php
$sql = ("SELECT * FROM users");
$result = mysql_query($sql) or die(mysql_error());
$users = mysql_num_rows($result);

?>