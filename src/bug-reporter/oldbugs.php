<p>Hier finden Sie die schon gemeldeten Bugs</p>
<hr>
<table border=1>
	<tr>
		<td>Von:</td>
		<td>Datum</td>
		<td>Beschreibung</td>
		<td>Kommentar</td>
		<td>Status</td>
	</tr>
<?php
$sql = ("SELECT * FROM bugs");
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($result))
{
	$owner = $row['owner'];
	$besch = $row['beschreibung'];
	$datum = $row['datum'];
	$komen = $row['kommentar'];
	$statu = $row['status'];

	if($statu == "gemeldet")
	{
		$style = "color: red;";
	}

	if($statu == "in arbeit")
	{
		$style = "color: yellow;";
	}

	if($statu == "behoben")
	{
		$style = "color: green;";
	}

	echo "<tr>\n";
	echo "	<td>".$owner."</td>\n";
	echo "	<td>".$datum."</td>\n";
	echo "	<td>".$besch."</td>\n";
	echo "	<td>".$komen."</td>\n";
	echo "	<td><p style=\"$style\">$statu</p></td>\n";
	echo "</tr>\n";
}
?>
</table>