<h2>Screenshots</h2>
<table>
<?php

$sql = ("SELECT * FROM screen");
$result = mysql_query($sql) or die(mysql_error());
$anzahl = mysql_num_rows($result);

if($anzahl <= 0)
{
	echo "Bis jetzt noch keine Screenshots verfuegbar<br>\n";
}

while($row = mysql_fetch_array($result))
{
	$id    = $row['id'];
	$url   = $row['url'];
	$text  = $row['beschreibung'];
	$kat   = $row['kat'];
	$datum = $row['datum'];

	echo "<tr>\n";
	echo " <td><a href=../daten/screenshots/$url target=_blank><img src=../daten/screenshots/$url width=100 height=100 border=0></a></td>\n";
	echo " <td>$kat</td>\n";
	echo " <td>$text</td>\n";
	echo "</tr>\n";
	echo "<hr>\n";
}
?>
</table>