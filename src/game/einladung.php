<?php
echo "<h3>Einladungen</h3>";

$sqlab = "select * from bewerbungen where user='" . $_SESSION["user"] . "' and type='einladung'";
$res   = mysql_query($sqlab);
if(mysql_num_rows($res)<=0) {
	echo "<p>Keine Einladungen vorhanden.</p>";
}
else {
	if(isset($_GET["id"])||isset($_POST["id"])) {
		if(isset($_GET["id"])) {
			echo "<h3>Einladungen anzeigen</h3>";
			$id 	= trim(mysql_real_escape_string($_GET["id"]));
			$sqlab = "select * from bewerbungen where id='" . $id . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "<font color='red'>Diese Einlagung existiert nicht mehr.</font>";
			}
			else {
				$dsatz = mysql_fetch_assoc($res);
				$sqlab = "select * from alianzen where id='" . $dsatz["allyid"] . "'";
				$res2  = mysql_query($sqlab);
				$dsatz2= mysql_fetch_assoc($res2);
				echo "<div id='abgerundedeecken6'>Allianz Name: " . $dsatz2["name"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>Allianz Tag: " . $dsatz2["tag"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>Datum: " . $dsatz["datum"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>" . str_replace("\n","<br>",$dsatz["text"]) . "</div>";
				echo "<br>";
				echo "<form action='main.php' method='post'>";
				echo "<div id='abgerundedeecken6'><input type='submit' name='an' value='Annehmen'>&nbsp;&nbsp;<input type='submit' name='ab' value='Ablehnen'></div>";
				echo "<input type='hidden' name='target' value='einladung'>";
				echo "<input type='hidden' name='id' value='" . $id . "'>";
				echo "</form>";
			}
		}
		else {
			#asuwerten
			if(isset($_POST["ab"])) {
				#ablehnen
				$sqlab = "delete from bewerbungen where id='" . mysql_real_escape_string($_POST["id"]) . "'";
				mysql_query($sqlab);
				echo "<p><font color='green'>Bewerbung erfolgreich abgelehnt.</font></p>";
			}
		}
		echo "<p><a href='main.php?target=einladung'>Zur&uuml;ck</a></p>";
	}
	else {
		echo "<p>" . mysql_num_rows($res) . " Einladung";
		if(mysql_num_rows($res)>1) echo "en";
		echo " vorhanden.</p>";
	
		echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
		echo "<tr><th class='hsmallborder' align='center'>ID</th><th class='hsmallborder' align='center'>Allianz Name</th><th class='hsmallborder' align='center'>Allianz Tag</th><th class='hsmallborder' align='center'>Text</th><th class='hsmallborder' align='center'>Aktion</th></tr>";
		$num = 1;
		while($dsatz=mysql_fetch_assoc($res)) {
			echo "<tr>";
			echo "<td class='hsmallborder' align='center'>" . $num . "</td>";
			$sqlab = "select * from alianzen where id='" . $dsatz["allyid"] . "'";
			$res2  = mysql_query($sqlab);
			$dsatz2= mysql_fetch_assoc($res2);
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz2["id"] . "'>" . $dsatz2["name"] . "</a></td>";
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz2["id"] . "'>" . $dsatz2["tag"] . "</a></td>";
			echo "<td class='hsmallborder' align='center'>" . substr($dsatz["text"], 0, 25) . "...</td>";
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=einladung&id=" . $dsatz["id"] . "'>Lesen</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
?>