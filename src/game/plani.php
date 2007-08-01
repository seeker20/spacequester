<?php
echo "<h3>Planet Überischt</h3>";


$sqlab 	= "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
$res   	= mysql_query($sqlab);
if(mysql_num_rows($res)>0) {
	$dsatz = mysql_fetch_assoc($res);
	
	$pos = $dsatz["x"] . "-" . $dsatz["y"] . "-" . $dsatz["sector"];
	
	echo "<p>Aktuelle Position: <a href='main.php?target=viewstar&pos=" . $pos . "'>" . $pos . "</a></p>";
	echo "<p>Sie können Keine Andere Aktion machen.</p>";
}
else {
	$sqlab 	= "select * from schiffe where id='" . $_SESSION["ship"] . "'";
	$res   	= mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$pos = $dsatz["x"] . "-" . $dsatz["y"] . "-" . $dsatz["sector"];
	
	echo "<p>Aktuelle Position: <a href='main.php?target=viewstar&pos=" . $pos . "'>" . $pos . "</a></p>";
	#weiter aktione wie in die abr gehen usw...
}
?>