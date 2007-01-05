<h2>Das SpaceQuester Team</h2>

<table border='0' width='90%'>
<?php
$fp = fopen("../daten/team.txt","r");
while($line = fgets($fp,2000)) {
	$autor = trim($line);
	$aufgabe = trim(fgets($fp,2000));
	$alter = trim(fgets($fp,2000));
	$beschr = trim(fgets($fp,2000));
	$pic = trim(fgets($fp,2000));
	
	if(isset($_GET["t"])&&$autor==$_GET["t"]) {
		echo "<tr>";
		echo "<td colspan='2' width='100%' align='center'><font size='+2'>" . $aufgabe . "</font></td>";
		echo "</tr><tr>";
		echo "<td width='50%' align='left'>" . $autor . "<br>";
		echo $alter . "<br><hr>";
		echo $beschr . "</td>";
		echo "<td rowspan='2' width='50%' align='center'><img src='" . $pic . "' alt='No Picture'></td>";
		echo "</tr>";
		
		break;
	}
	else if(!(isset($_GET["t"]))) {
		echo "<tr>";
		echo "<td colspan='2' width='100%'  align='center'><font size='+1'>" . $aufgabe . "</font></td>";
		echo "</tr><tr>";
		echo "<td width='50%' align='center'><a href='main.php?target=team&t=" . $autor . "'>" . $autor . "</a></td>";
		echo "</tr>";
	}
}
fclose($fp);
?>
</table>

<?php
if(isset($_GET["t"])) {
	echo "<br><a href='main.php?target=team'>Zurck</a>";
}
?>