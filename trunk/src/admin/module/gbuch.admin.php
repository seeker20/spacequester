<h3>G�stebuch Admin Modul</h3>
<form action='main.php' method='get'>
<input type='submit' value='Neuer Eintrag' name='ne'>&nbsp;&nbsp;&nbsp;<input type='submit' name='cl' value='L�sche Alle Eintr�ge'>
<input type='hidden' name='conf' value='<?php if(isset($_GET["conf"])) echo $_GET["conf"]; else echo $_POST["conf"]; ?>'>
</form>

<?php
$db = new db();

if(isset($_GET["conf"])) $conf = $_GET["conf"]; 
else $conf = $_POST["conf"];
//Inhalt l�schen
if(isset($_GET["del"])) {
	$db->query("DELETE from " . SYSTEM_dbpref . "gbuch where id='".$_GET["del"]."'");
	echo "<font color='green'>L�schen erfolgreich</font><br>\n";
}
//L�sche alle Eintr�ge
if(isset($_GET["cl"])) {
	$db->query("TRUNCATE TABLE " . SYSTEM_dbpref . "gbuch");
	echo "<font color='green'>Datenbank erfolgreich geleert.</font><br>\n";
}
//Neuer Eintrag
if(isset($_GET["ne"])) {
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='name' value='Name'></td>";
	echo "<td><input type='text' name='email' value='E-mail'></td>";
	echo "<td><input type='text' name='hp' value='Homepage'></td>";
	echo "<td><input type='text' name='date' value='".date("d.m.Y H:i:s")."'></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td colspan='4' align='center'><textarea wrap='off' cols='76' name='text'>Text</textarea></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td colspan='2'><input type='submit' name='ne' value='Eintrag Anlegen'></td>";
	echo "<td colspan='2'><input type='reset' value='Leeren'></td>";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='conf' value='$conf'>\n";
	echo "</form>\n";
}
else if(isset($_POST["ne"])) {
	$name   = trim($_POST["name"]);
	$email  = trim($_POST["email"]);
	$hp     = trim($_POST["hp"]);
	$date   = trim($_POST["date"]);
	$text   = trim($_POST["text"]);
	
	if($name==""||$name=="Name") {
		echo "<font color='red'>Sie m�ssen einen Namen f�r den Eintrag geben.</font><br>\n";
	}
	else if($email==""||$email=="E-mail") {
		echo "<font color='red'>Sie m�ssen eine Email adresse angeben.</font><br>\n";
	}
	else if($text==""||$text=="Text") {
		echo "<font color='red'>Sie m�ssen einen Text angeben.</font><br>\n";
	}
	else {
		if($hp=="Homepage") $hp="";
		if($date=="") {
			$date=date("d.m.Y H:i:s");
		}
		
		$db->query("INSERT INTO `" . SYSTEM_dbpref . "gbuch` ( `id` , `name` , `email` , `hp` , `text` , `date` ) VALUES ( NULL , '$name', '$email', '$hp', '$text', '$date' )");
		
		echo "<font color='green'>Eintrag erfolgreich erstellt.</font><br>\n";
	}
}
//Eintrag bearbeiten
if(isset($_GET["ed"])) {
	$res = $db->query("select * from " . SYSTEM_dbpref . "gbuch where id='".$_GET["ed"]."'");
	$dsatz = $db->get($res);
	
	echo "<form action='main.php' method='post'>\n";
	echo "<table border='0'>\n";
	echo "<tr>";
	echo "<td><input type='text' name='name' value='".$dsatz["name"]."'></td>";
	echo "<td><input type='text' name='email' value='".$dsatz["email"]."'></td>";
	echo "<td><input type='text' name='hp' value='".$dsatz["hp"]."'></td>";
	echo "<td><input type='text' name='date' value='".$dsatz["date"]."'></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td colspan='4' align='center'><textarea wrap='off' cols='76' name='text'>".$dsatz["text"]."</textarea></td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td><input type='submit' name='ed' value='Eintrag Bearbeiten'></td>";
	echo "<td>&nbsp;</td>";
	echo "<td><input type='reset' value='Aktuell'></td>";
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='conf' value='$conf'>\n";
	echo "<input type='hidden' name='id' value='".$_GET["ed"]."'>\n";
	echo "</form>\n";
}
else if(isset($_POST["ed"])) {
	$name   = trim($_POST["name"]);
	$email  = trim($_POST["email"]);
	$hp     = trim($_POST["hp"]);
	$date   = trim($_POST["date"]);
	$text   = trim($_POST["text"]);
	$id     = trim($_POST["id"]);
	
	if($name==""||$name=="Name") {
		echo "<font color='red'>Sie m�ssen einen Namen f�r den Eintrag geben.</font><br>\n";
	}
	else if($email==""||$email=="E-mail") {
		echo "<font color='red'>Sie m�ssen eine Email adresse angeben.</font><br>\n";
	}
	else if($text==""||$text=="Text") {
		echo "<font color='red'>Sie m�ssen einen Text angeben.</font><br>\n";
	}
	else {
		if($hp=="Homepage") $hp="";
		if($date=="") {
			$date=date("d.m.Y H:i:s");
		}
		
		$db->query("UPDATE `" . SYSTEM_dbpref . "gbuch` SET `name` = '$name', `email`= '$email', `hp`= '$hp', `text`= '$text', `date`= '$date' WHERE `id` = '$id'");
		
		echo "<font color='green'>Eintrag erfolgreich bearbeitet.</font><br>\n";
	}
}
?>

<table border='0' cellspacing="0" cellpadding="0" width='98%'>
<tr align='center'><th style='border-width:1px;border-style:solid;'>Name</th><th style='border-width:1px;border-style:solid;'>E-mail</th><th style='border-width:1px;border-style:solid;'>Homepage</th><th style='border-width:1px;border-style:solid;'>Text</th><th style='border-width:1px;border-style:solid;'>Datum</th><th style='border-width:1px;border-style:solid;'>Aktion</th></tr>
<?php
//Ausgabe
$res = $db->query("select * from " . SYSTEM_dbpref . "gbuch order by id desc");
while($dsatz=$db->get($res)) {
	echo "<tr align='center'>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["name"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'><a href='mailto:".$dsatz["email"]."'>".$dsatz["email"]."</a></td>";
	echo "<td style='border-width:1px;border-style:solid;'>";
	if($dsatz["hp"]!="") echo "<a href='".$dsatz["hp"]."' target='_blank'>".$dsatz["hp"]."</a>";
	else echo "Keine Homepage";
	echo "</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".str_replace('\n',"<br>", $dsatz["text"])."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>".$dsatz["date"]."</td>";
	echo "<td style='border-width:1px;border-style:solid;'>";
	echo "<a href='main.php?ed=".$dsatz["id"]."&conf=$conf'><img border='0' src='".SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin/edit.gif' title='Bearbeite den Eintrag' alt='Edit'></a>";
	echo "&nbsp;";
	echo "<a href='main.php?del=".$dsatz["id"]."&conf=$conf'><img border='0' src='".SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin/delete.gif' title='L�schen des Eintrags' alt='Delete'></a>";
	echo "</td>";
	echo "</tr>\n";
}
?>
</table>
<br>