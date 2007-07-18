<h3>Todo Admin Modul</h3>
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
	$db->query("DELETE from " . SYSTEM_dbpref . "todo where id='".$_GET["del"]."'");
	echo "<font color='green'>Löschen erfolgreich</font><br />\n";
}
//Lösche alle Einträge
if(isset($_GET["cl"])) {
	$db->query("TRUNCATE TABLE " . SYSTEM_dbpref . "todo");
	echo "<font color='green'>Datenbank erfolgreich geleert.</font><br />\n";
}
//Neuer Eintrag
if(isset($_GET["ne"])) {
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='todo' value='Todo' /></td>";
	echo "<td><select name='status' size='1'>";
	echo "<option value='geplannt'>Geplannt</option>";
	echo "<option value='bearbeitung'>In Bearbeitung</option>";
	echo "<option value='fertig'>Fertig</option>";
	echo "</select>";
	echo "</td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td><input type='submit' name='ne' value='Eintrag Anlegen' /></td>";
	echo "<td><input type='reset' value='Leeren' /></td>";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='conf' value='$conf' />\n";
	echo "</form>\n";
}
else if(isset($_POST["ne"])) {
	$todo    = trim($_POST["todo"]);
	$status  = trim($_POST["status"]);
	
	if($todo==""||$todo=="Todo") {
		echo "<font color='red'>Sie müssen einen Title für die Aufgabe geben.</font><br />\n";
	}
	else {
		$db->query("INSERT INTO `" . SYSTEM_dbpref . "todo` ( `id` , `todo` , `status` ) VALUES ( NULL , '$todo', '$status' )");
		
		echo "<font color='green'>Eintrag erfolgreich erstellt.</font><br />\n";
	}
}
//Eintrag bearbeiten
if(isset($_GET["ed"])) {
	$res = $db->query("select * from " . SYSTEM_dbpref . "todo where id='".$_GET["ed"]."'");
	$dsatz = $db->get($res);
	
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='todo' value='".$dsatz["todo"]."' /></td>";
	echo "<td><select name='status' size='1'>";
	if($dsatz["status"]=="geplannt") {
		echo "<option value='geplannt'>Geplannt</option>";
		echo "<option value='bearbeitung'>In Bearbeitung</option>";
		echo "<option value='fertig'>Fertig</option>";
	}
	else if($dsatz["status"]=="bearbeitung") {
		echo "<option value='bearbeitung'>In Bearbeitung</option>";
		echo "<option value='fertig'>Fertig</option>";
		echo "<option value='geplannt'>Geplannt</option>";
	}
	else {
		echo "<option value='fertig'>Fertig</option>";
		echo "<option value='bearbeitung'>In Bearbeitung</option>";
		echo "<option value='geplannt'>Geplannt</option>";
	}
	echo "</select>";
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
	$todo    = trim($_POST["todo"]);
	$status  = trim($_POST["status"]);
	$id    = trim($_POST["id"]);
	
	if($todo==""||$todo=="Todo") {
		echo "<font color='red'>Sie müssen einen Title für die Aufgabe geben.</font><br />\n";
	}
	else {
		$db->query("UPDATE `" . SYSTEM_dbpref . "todo` SET `todo` = '$todo', `status`= '$status' WHERE `id` = '$id'");
		
		echo "<font color='green'>Eintrag erfolgreich bearbeitet.</font><br />\n";
	}
}
?>

<table border='0' cellspacing="0" cellpadding="0" width='98%'>
<tr align='center'><th style='border-width:1px;border-style:solid;'>Todo</th><th style='border-width:1px;border-style:solid;'>Status</th><th style='border-width:1px;border-style:solid;'>Aktion</th></tr>
<?php
//Ausgabe
$res = $db->query("select * from " . SYSTEM_dbpref . "todo order by id desc");
while($dsatz=$db->get($res)) {
	echo "<tr align='center'>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["todo"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["status"]."</td>";
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