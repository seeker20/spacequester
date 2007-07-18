<h3>News Admin Modul</h3>
<form action='main.php' method='get'>
<input type='submit' value='Neuer Eintrag' name='ne' />&nbsp;&nbsp;&nbsp;<input type='submit' name='cl' value='Lösche Alle Einträge' />
<input type='hidden' name='conf' value='<?php if(isset($_GET["conf"])) echo $_GET["conf"]; else echo $_POST["conf"]; ?>' />
</form>

<?php
$db = new db();

if(isset($_GET["conf"])) $conf = $_GET["conf"]; 
else $conf = $_POST["conf"];
//Inhalt löschen
if(isset($_GET["del"])) {
	$db->query("DELETE from " . SYSTEM_dbpref . "news where id='".$_GET["del"]."'");
	echo "<font color='green'>Löschen erfolgreich</font><br />\n";
}
//Lösche alle Einträge
if(isset($_GET["cl"])) {
	$db->query("TRUNCATE TABLE " . SYSTEM_dbpref . "news");
	echo "<font color='green'>Datenbank erfolgreich geleert.</font><br />\n";
}
//Neuer Eintrag
if(isset($_GET["ne"])) {
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='title' value='Title' /></td>";
	echo "<td><input type='text' name='date' value='".date("d.m.Y H:i:s")."' /></td>";
	echo "<td><input type='text' name='autor' value='Autor' /></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td colspan='3' align='center'><textarea wrap='off' cols='56' name='text'>Meldung</textarea></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td><input type='submit' name='ne' value='Eintrag Anlegen' /></td>";
	echo "<td>&nbsp;</td>";
	echo "<td><input type='reset' value='Leeren' /></td>";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='conf' value='$conf' />\n";
	echo "</form>\n";
}
else if(isset($_POST["ne"])) {
	$title = trim($_POST["title"]);
	$date  = trim($_POST["date"]);
	$autor = trim($_POST["autor"]);
	$text  = trim($_POST["text"]);
	
	if($title==""||$title=="Title") {
		echo "<font color='red'>Sie müssen einen Title angeben.</font><br />\n";
	}
	else if($autor==""||$autor=="Autor") {
		echo "<font color='red'>Sie müssen einen Autor angeben.</font><br />\n";
	}
	else if($text==""||$text=="Meldung") {
		echo "<font color='red'>Sie müssen einen Text angeben.</font><br />\n";
	}
	else {
		if($date=="") {
			$date=date("d.m.Y H:i:s");
		}
		
		$db->query("INSERT INTO `" . SYSTEM_dbpref . "news` ( `id` , `topic` , `text` , `date` , `autor` ) VALUES ( NULL , '$title', '$text', '$date', '$autor' )");
		
		echo "<font color='green'>Eintrag erfolgreich erstellt.</font><br />\n";
	}
}
//Eintrag bearbeiten
if(isset($_GET["ed"])) {
	$res = $db->query("select * from " . SYSTEM_dbpref . "news where id='".$_GET["ed"]."'");
	$dsatz = $db->get($res);
	
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='title' value='".$dsatz["topic"]."' /></td>";
	echo "<td><input type='text' name='date' value='".$dsatz["date"]."' /></td>";
	echo "<td><input type='text' name='autor' value='".$dsatz["autor"]."' /></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td colspan='3' align='center'><textarea wrap='off' cols='56' name='text'>".$dsatz["text"]."</textarea></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td><input type='submit' name='ed' value='Eintrag Bearbeiten' /></td>";
	echo "<td>&nbsp;</td>";
	echo "<td><input type='reset' value='Aktuell' /></td>";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='conf' value='$conf' />\n";
	echo "<input type='hidden' name='id' value='".$_GET["ed"]."' />\n";
	echo "</form>\n";
}
else if(isset($_POST["ed"])) {
	$title = trim($_POST["title"]);
	$date  = trim($_POST["date"]);
	$autor = trim($_POST["autor"]);
	$text  = trim($_POST["text"]);
	$id    = trim($_POST["id"]);
	
	if($title==""||$title=="Title") {
		echo "<font color='red'>Sie müssen einen Title angeben.</font><br />\n";
	}
	else if($autor==""||$autor=="Autor") {
		echo "<font color='red'>Sie müssen einen Autor angeben.</font><br />\n";
	}
	else if($text==""||$text=="Meldung") {
		echo "<font color='red'>Sie müssen einen Text angeben.</font><br />\n";
	}
	else {
		if($date=="") {
			$date=date("d.m.Y H:i:s");
		}
		$db->query("UPDATE `" . SYSTEM_dbpref . "news` SET `autor` = '$autor', `topic`= '$title', `date` = '$date', `text` = '$text' WHERE `id` = '$id'");
		
		echo "<font color='green'>Eintrag erfolgreich bearbeitet.</font><br />\n";
	}
}
?>

<table border='0' cellspacing="0" cellpadding="0" width='98%'>
<tr align='center'><th style='border-width:1px;border-style:solid;'>Überschrift</th><th style='border-width:1px;border-style:solid;'>Text</th><th style='border-width:1px;border-style:solid;'>Datum</th><th style='border-width:1px;border-style:solid;'>Autor</th><th style='border-width:1px;border-style:solid;'>Aktion</th></tr>
<?php
//Ausgabe
$res = $db->query("select * from " . SYSTEM_dbpref . "news order by id desc");
while($dsatz=$db->get($res)) {
	echo "<tr align='center'>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["topic"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".str_replace('\n',"<br>", $dsatz["text"])."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["date"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["autor"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>";
	echo "<a href='main.php?ed=".$dsatz["id"]."&conf=$conf'><img border='0' src='".SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin/edit.gif' title='Bearbeite den Eintrag' alt='Edit' /></a>";
	echo "&nbsp;";
	echo "<a href='main.php?del=".$dsatz["id"]."&conf=$conf'><img border='0' src='".SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin/delete.gif' title='Löschen des Eintrags' alt='Delete' /></a>";
	echo "</td>";
	echo "</tr>\n";
}
?>
</table>
<br />