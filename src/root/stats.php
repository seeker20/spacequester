<?php
$sql = ("SELECT * FROM users");
$result = mysql_query($sql) or die(mysql_error());
$users = mysql_num_rows($result);

echo "
<h5>Statistiken</h5>
<table border=0>
	<tr>
		<td>Anzahl spieler:</td>
		<td>$users</td>
	</tr>
</table>
"

?>