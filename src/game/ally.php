<?php
$sqlab = "select * from users where name='" . $_SESSION["user"] . "'";
$res   = mysql_query($sqlab);
$dsatz = mysql_fetch_assoc($res);

if($dsatz["alianzid"] > 0) {
	$userhomeali = $dsatz["alianzid"];
}
else {
	$userhomeali = 0;
}

if(isset($_GET["aliid"])) {
	$aliid = $_GET["aliid"];
}
else if($_POST["aliid"]) {
	$aliid = $_POST["aliid"];
}
else {
	$aliid = 0;
}

if(isset($_GET["ac"])) {
	$ac = $_GET["ac"];
}
else if(isset($_POST["ac"])) {
	$ac = $_POST["ac"];
}
else {
	$ac = 0;
}

$aliid 	= mysql_real_escape_string($aliid);
$ac		= mysql_real_escape_string($ac);

if($ac==0) {
	if($aliid==0) {
		if($userhomeali==0) {
			echo "<h3>Allianz Gr&uuml;nden/Beitreten</h3>";
			
			echo "<p>W&auml;hlen sie einfach eine Aktion:</p><br>";
			echo '<div id="navcontainer">';
			echo '<ul id="navlist">';
			echo "<li><a href='main.php?target=ally&ac=1'>Allianz Gr&uuml;nden</a></li>";
			echo "<li><a href='main.php?target=ally&ac=8'>Allianz Beitreten</a></li>";
			echo "<li><a href='main.php?target=ally&ac=15'>Allianz Suchen</a></li>";
			echo "<li><a href='main.php?target=ally&ac=13'>Allianzen Auflisten</a></li>";
			$sqlab = "select * from bewerbungen where user='" . $_SESSION["user"] . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)>0) {
				echo "<br><li><a href='main.php?target=ally&ac=14'>Bewerbung zur&uuml;ckziehen</a></li>";
			}
			echo '</ul>';
			echo '</div>';
		}
	}
}
else if($ac==1) {
	if(isset($_GET["ac"])) {
		echo "<h3>Allianz Gr&uuml;nden</h3>";
		echo "<form action='main.php' method='post'>";
		echo "<table border='0'>";
		echo "<tr><td>Allianz Tag (3-8 Zeichen)</td><td>:</td><td align='center'><input type='text' size='8' maxlength='8' name='alitag'></td></tr>";
		echo "<tr><td>Allianz Name (max. 35 Zeichen)</td><td>:</td><td align='center'><input type='text' size='20' maxlength='35' name='aliname'></td></tr>";
		echo "<tr><td colspan='3' align='center'><input type='submit' value='Allianz Gr&uuml;nden'></td></tr>";
		echo "</table>";
		echo "<input type='hidden' name='target' value='ally'>";
		echo "<input type='hidden' name='ac' value='1'>";
		echo "</form>";
	}
	else {
		#in db eintragen
		$allytag 	= trim(mysql_real_escape_string($_POST["alitag"]));
		$allyname = trim(mysql_real_escape_string($_POST["aliname"]));
		$err			= false;
		
		if($allytag==''||$allyname=='') {
			echo "<p>Sie m&uuml;ssen einen Ally Tag und einen Namen angeben.</p>";
			$err = true;
		}
		
		if(strlen($allytag) > 8||strlen($allytag) < 3||strlen($allyname) > 35) {
			echo "<p>Sie m&uuml;ssen bitte das Zeichenlimit und minimum einhalten das vorgegben ist.</p>";
			$err = true;
		}
		
		if(!$err) {
			$sqlab = "select * from alianzen where name='" . $allyname . "' or tag='" . $allytag . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res) > 0) {
				echo "<p>Es gibt bereits eine Allianz mit diesem Tag oder mit diesem Namen.</p>";
				$err = true;
			}
		}
		
		if(!$err) {
			$sqlab  = "INSERT INTO `alianzen` ( `id` , `name` , `tag` , `internetext` , `externetext` , `bewerbungstext` , `datum` , `hp` , `logo` , `gruender` ) VALUES (";
			$sqlab .= "NULL , '" . $allyname . "', '" . $allytag . "', '', '', '', '" . $date . "', '', '', '" . $_SESSION["user"] . "')";
			mysql_query($sqlab);
			
			$sqlab  = "select * from alianzen where tag='" . $allytag . "'";
			$res    = mysql_query($sqlab);
			$dsatz  = mysql_fetch_assoc($res);
			
			$sqlab 	= "update users set alianzid='" . $dsatz["id"] . "' where name='" . $_SESSION["user"] . "'";
			mysql_query($sqlab);
			
			$userhomeali = $dsatz["id"];
			
			echo "<p>Allianz <b>" . $allyname . " </b> erforlgreich gegr&uuml;ndet.</p>";
			echo "<hr>";
		}
		
		if($err) {
			echo "<p><a href='main.php?target=ally&ac=1>Zur&uuml;ck</a></p>";
		}
	}
}
else if($ac==2) {
	echo "<h3>Mitglieder Liste</h3>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><th class='hsmallborder'>ID</th><th class='hsmallborder'>Name</th><th class='hsmallborder'>Rang</th><th class='hsmallborder'>Aktuelle Schiffs Position</th><th class='hsmallborder'>Punkte</th><th class='hsmallborder'>Status</th></tr>";
	$sqlab 		= "select * from users where alianzid='" . $userhomeali . "'";
	$res   		= mysql_query($sqlab);
	$num		=1;
	$time_new 	= time()+500;
	while($dsatz = mysql_fetch_assoc($res)) {
		echo "<tr>";
		
		$sqlab 		= "select * from schiffe where id='" . $dsatz["schifid"] . "'";
		$res2   	= mysql_query($sqlab);
		$dsatz2 	= mysql_fetch_assoc($res2);
		$sqlab 		= "select * from schiffs_auftraege where schiffsid='" . $dsatz["schifid"] . "'";
		$res2		= mysql_query($sqlab);
		if(mysql_num_rows($res2)>0) {
			$dsatz2	   = mysql_fetch_assoc($res2);
			$timearray = explode("#",$dsatz2["time_array"]);
			$posarray  = explode("#",$dsatz2["pos_array"]);
			$time      = time();
			if($timearray[0]>$time) {
				$pospos = explode("-",$posarray[0]);
				$_sector = $pospos[2];
				$_x      = $pospos[0];
				$_y      = $pospos[1];
			}
			else {
				for($i=0;$i<count($timearray);$i++) {
					if($timearray[$i]<=$time) {
						$pospos = explode("-",$posarray[$i]);
						$_sector = $pospos[2];
						$_x      = $pospos[0];
						$_y      = $pospos[1];
					}
				}
			}
			
			$position = "<font color='#99FFCC'>" . $_x . "-" . $_y . "-" . $_sector . "</font>";
		}
		else {
			$position = $dsatz2["x"] . "-" . $dsatz2["y"] . "-" . $dsatz2["sector"];
		}
			
			
		$sqlab 		= "select * from alianzen where id='" . $userhomeali . "'";
		$res2   	= mysql_query($sqlab);
		$dsatz2 	= mysql_fetch_assoc($res2);
		
		if($dsatz2["gruender"]==$dsatz["name"]) {
			$rang = "Gr&uuml;nder";
		}
		else {
			$sqlab = "select * from users where name='" . $dsatz["name"] . "'";
			$res2  = mysql_query($sqlab);
			$dsatz2= mysql_fetch_assoc($res2);
		
			if($dsatz2["rangid"]==0) {
				$rang = "Neuling";
			}
			else {
				$sqlab = "select * from allyraenge where id='" . $dsatz2["rangid"] . "'";
				$res2  = mysql_query($sqlab);
				$dsatz3= mysql_fetch_assoc($res2);
				$rang  = $dsatz3["name"];
			}
		}
		
		echo "<td class='hsmallborder' align='center'>" . $num . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $dsatz["name"] . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $rang . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $position . "</td>";
		echo "<td class='hsmallborder' align='center'>Punkte fehlen noch</td>";
		echo "<td class='hsmallborder' align='center'>";
		if($dsatz["lastaction"]=='') {
			echo "<font color='red'>OFF";
		}
		else {
			if($dsatz["lastaction"] < $time_new) {
				echo "<font color='green'>ON";
			}
			else {
				echo "<font color='yellow'>Abwesend";
			}
		}
		echo "</font>";
		echo "</td>";
		echo "</tr>";
		$num++;
	}
	echo "</table>";
	
	echo "<br><a href='main.php?target=ally'>Schliesen</a>";
}
else if($ac==3) {
	#grund admin men�
	if(isset($_GET["t"]))
		$t = $_GET["t"];
	else if(isset($_POST["t"]))
		$t = $_POST["t"];
	else
		$t = 1;
	
	if(isset($_POST["t"])) {
		#updaten der jeweiliegn text felder
		$text = trim(mysql_real_escape_string($_POST["text"]));
		$text = strip_tags($text);
		
		if(stristr($text,"div")) {
			$text="";
		}
		if(stristr($text,"span")) {
			$text="";
		}
		
		if($text=='') {
			echo "<p>Sie m�ssen einen Text angeben oder sie verwenden HTML code.</p>";
		}
		else if(strlen($text) > 5000) {
			echo "<p>Zuviele Zeichen h&ouml;chtens 5000</p>";
		}
		else if(!bbcodetest($text)) {
			echo "<p>Der BB-Code beinhaltet fehler bitte &uuml;berpr�fen sie ihn.</p>";
		}
		else {
			if($t==1)
				$bereich="externetext";
			else if($t==2)
				$bereich="internetext";
			else 
				$bereich="bewerbungstext";
			$sqlab = "update alianzen set " . $bereich . "='" . $text . "' where id='" . $userhomeali . "'";
			mysql_query($sqlab);
			echo "<font color='green'>Erfolgreich gespeichert.</font>";
		}
		echo "<hr>";
	}
	echo "<br>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' align='center'><b>Allianz verwalten</b></td></tr>";
	echo "<tr><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=6'>Rechte Verwalten</a></td></tr>";
	echo "<tr><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=7'>Rechte Vergeben</a></td></tr>";
	echo "<tr><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=4'>AllyName �ndern</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a style='text-decoration: none;' href='main.php?target=ally&ac=5'>AllyTag �ndern</a></td></tr>";
	echo "</table>";
	echo "<br><br>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' align='center' colspan='3'><b>Textverwaltung</b></td></tr>";
	echo "<form name='allyoptions' action='main.php' method='post'>";
	echo "<tr><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=3&t=1'>Externer Text</td><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=3&t=2'>Interner Text</td><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=3&t=3'>Bewerbungstext</td></tr>";
	echo "<tr><td class='hsmallborder' colspan='3' align='left'>";
	if($t==1)
		echo "Externer Allianztext";
	else if($t==2)
		echo "Interner Allianztext";
	else 
		echo "Bewerbungstext";
	echo " (0 / 5000 Zeichen)</td></tr>";
	echo "<tr><td class='hsmallborder' colspan='3' align='center'><br><textarea cols='80%' rows='7%' name='text'>";
	
	$sqlab = "select * from alianzen where id='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	if($t==1)
		echo $dsatz["externetext"];
	else if($t==2)
		echo $dsatz["internetext"];
	else 
		echo $dsatz["bewerbungstext"];
	echo "</textarea><br><br></td></tr>";
	echo "<tr><td class='hsmallborder' colspan='3' align='center'><br><input type='submit' value='Speichern'>&nbsp;&nbsp;&nbsp;";
	if($_SESSION["JavaScript"]&&$t!=3) {
		echo "<a href='javascript:popup(700,500,\"bbcode.php?m=0\")'>BB-Code</a>";
	}
	else if($t!=3) {
		echo "<a href='bbcode.php?m=1' target = '_blank'>BB-Code</a>";
	}
	echo "&nbsp;&nbsp;&nbsp;<input type='reset' value='Zur&uuml;cksetzen'><br><br></td></tr>";
	if($t==1)
		echo "<input type='hidden' name='t' value='1'>";
	else if($t==2)
		echo "<input type='hidden' name='t' value='2'>";
	else 
		echo "<input type='hidden' name='t' value='3'>";
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='3'>";
	echo "</form>";
	echo "</table>";
	
	echo "<br><a href='main.php?target=ally'>Schliesen</a>";
}
else if($ac==4) {
	#name �ndern
	echo "<br>";
	if(isset($_POST["ac"])) {
		#eintragen
		$name = trim(mysql_real_escape_string($_POST["nname"]));
		$name = strip_tags($name);
		
		if($name=='') {
			echo "<font color='red'>Sie m�ssen einen Allianz Namen angeben.</font><br><br>";
		}
		else if(strlen($name) > 35) {
			echo "<font color='red'>Zeichen Maximum �berschritten.</font><br><br>";
		}
		else {
			$sqlab = "select * from alianzen where name='" . $name . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res) > 0) {
				echo "<font color='red'>Es gibt bereits eine Allianz mit diesem Namen.</font><br><br>";
			}
			else {
				$sqlab = "update alianzen set name='" . $name . "' where id='" . $userhomeali . "'";
				mysql_query($sqlab);
		
				echo "<font color='green'>Name erfolgreich ge�ndert</font><br><br>";
			}
		}
	}
	
	$sqlab = "select * from alianzen where id='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$allyname = $dsatz["name"];
	
	echo "<form action='main.php' method='post'>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td colspan='2' class='hsmallborder' align='center'><b>Wie soll die Allianz \"" . $allyname . "\" k&uuml;nftig hei�en?<b></td></tr>";
	echo "<tr><td width='40%' class='hsmallborder' align='center'>Neuer Name (max. 35 Zeichen):</td><td class='hsmallborder' align='center'><br><input type='text' maxlength='35' name='nname' value='" . $allyname . "'>&nbsp;&nbsp;<input type='submit' value='&Auml;ndern'>&nbsp;&nbsp;<input type='reset' value='Abbrechen'><br><br></td></tr>";
	echo "</table>";
	
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='4'>";
	
	echo "</form>";
	
	echo "<br><a href='main.php?target=ally&ac=3'>Schliesen</a>";
}
else if($ac==5) {
	#tag �ndern
	echo "<br>";
	if(isset($_POST["ac"])) {
		#eintragen
		$name = trim(mysql_real_escape_string($_POST["ntag"]));
		$name = strip_tags($name);
		
		if($name=='') {
			echo "<font color='red'>Sie m�ssen ein Allianz Tag angeben.</font><br><br>";
		}
		else if(strlen($name) > 8||strlen($name) < 3) {
			echo "<font color='red'>Zeichen Maximum �berschritten oder minimum unterschritten.</font><br><br>";
		}
		else {
			$sqlab = "select * from alianzen where tag='" . $name . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res) > 0) {
				echo "<font color='red'>Es gibt bereits eine Allianz mit diesem Tag.</font><br><br>";
			}
			else {
				$sqlab = "update alianzen set tag='" . $name . "' where id='" . $userhomeali . "'";
				mysql_query($sqlab);
		
				echo "<font color='green'>Tag erfolgreich ge�ndert</font><br><br>";
			}
		}
	}
	
	$sqlab = "select * from alianzen where id='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$allytag = $dsatz["tag"];
	
	echo "<form action='main.php' method='post'>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td colspan='2' class='hsmallborder' align='center'><b>Wie soll der Allianz Tag \"" . $allytag . "\" k&uuml;nftig hei�en?<b></td></tr>";
	echo "<tr><td width='40%' class='hsmallborder' align='center'>Neuer Tag (3-8 Zeichen):</td><td class='hsmallborder' align='center'><br><input type='text' maxlength='8' name='ntag' value='" . $allytag . "'>&nbsp;&nbsp;<input type='submit' value='&Auml;ndern'>&nbsp;&nbsp;<input type='reset' value='Abbrechen'><br><br></td></tr>";
	echo "</table>";
	
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='5'>";
	
	echo "</form>";
	
	echo "<br><a href='main.php?target=ally&ac=3'>Schliesen</a>";
}
else if($ac==6) {
	#rechte erstellen und bearbeiten
	echo "<br>";
	if(isset($_POST["ac"])) {
		if(isset($_POST["nrang"])) {
			#neuer rang
			$name = trim(mysql_real_escape_string($_POST["nrang"]));
			$name = strip_tags($name);
			
			if($name=='') {
				echo "<font color='red'>Sie m�ssen einen Rang namen angeben.</font><br><br>";
			}
			else {
				$sqlab = "select * from allyraenge where name='" . $name . "' and allyid='" . $userhomeali . "'";
				$res   = mysql_query($sqlab);
				if(mysql_num_rows($res) > 0) {
					echo "<font color='red'>Es gibt bereits ein Recht mit diesem Namen.</font><br><br>";
				}
				else {
					$sqlab  = "INSERT INTO `allyraenge` ( `id` , `allyid` , `name` ) VALUES (";
					$sqlab .= "NULL , '" . $userhomeali . "', '" . $name . "')";
					mysql_query($sqlab);
		
					echo "<font color='green'>Recht wurde erfolgreich hinzugef�gt.</font><br><br>";
				}
			}
		}
		else if(isset($_POST["ids"])) {
			#ragnlsite updaten
			$ids = explode("-",$_POST["ids"]);
			for($i=0;$i < count($ids);$i++) {
				$name = mysql_real_escape_string(strip_tags($_POST["rname_" . $ids[$i]]));
				$AA   = false;
				$UK   = false;		
				$BW   = false;
				$ML   = false;
				$RM   = false;
				$AV   = false;
				
				if(isset($_POST["AA_" . $ids[$i]])) $AA = true;
				if(isset($_POST["UK_" . $ids[$i]])) $UK = true;
				if(isset($_POST["BW_" . $ids[$i]])) $BW = true;
				if(isset($_POST["ML_" . $ids[$i]])) $ML = true;
				if(isset($_POST["RM_" . $ids[$i]])) $RM = true;
				if(isset($_POST["AV_" . $ids[$i]])) $AV = true;
				
				if($name=='') {
					echo "<font color='red'>Sie m�ssen einen Rang namen angeben.</font><br><br>";
				}
				else {
					$sqlab = "select * from allyraenge where name='" . $name . "' and allyid='" . $userhomeali . "'";
					$res   = mysql_query($sqlab);
					if(mysql_num_rows($res) > 0&&$_POST["oldname_" . $ids[$i]]!=$name) {
						echo "<font color='red'>Rang namen bereits vorhanden.</font><br><br>";
					}
					else {
						$sqlab = "update allyraenge set name='" . $name . "', AA='" . $AA . "', UK='" . $UK . "', BW='" . $BW . "', ML='" . $ML . "', RM='" . $RM . "', AV='" . $AV . "' where id='" . $ids[$i] . "'";
						mysql_query($sqlab);
						
						echo "<font color='green'>Recht erfolgreich beabreitet.</font><br><br>";
					}
				}
			}
			echo "<p><a href='main.php?target=ally&ac=6'>Clear</a></p>";
		}
	}
	else if(isset($_GET["lid"])) {
		#l�schen
		$lid   = mysql_real_escape_string($_GET["lid"]);
		$sqlab = "select * from allyraenge where id='" . $lid . "'";
		$res   = mysql_query($sqlab);
		$dsatz = mysql_fetch_assoc($res);
		if($dsatz["allyid"]!=$userhomeali) {
			echo "<font color='red'>Bitte beachten sie das wir sie gerade dabei erwicht haben zu bescheisen bitte manipuliren sie keine URLs.</font>";
		}
		else {
			$sqlab = "delete from allyraenge where id='" . $lid . "'";
			mysql_query($sqlab);
			echo "<font color='green'>Rang erfolgreich gel�scht.</font><br><br>";
		}
	}
	
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	$sqlab = "select * from allyraenge where allyid='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	if(mysql_num_rows($res)<=0) {
		echo "<tr><td class='hsmallborder' colspan='2' align='center'><b>Rechte konfigurieren</b></td></tr>";
		echo "<tr><td class='hsmallborder' colspan='2' align='center'>Es sind keine R&auml;nge angelegt</td></tr>";
	}
	else {
		#aus der db holen
		echo "<tr><td class='hsmallborder' colspan='8' align='center'><b>Rechte konfigurieren</b></td></tr>";
		echo "<tr><th class='hsmallborder'>&nbsp;</th><th class='hsmallborder'>Rang</th><th class='hsmallborder'>AA</th><th class='hsmallborder'>UK</th><th class='hsmallborder'>BW</th><th class='hsmallborder'>ML</th><th class='hsmallborder'>RM</th><th class='hsmallborder'>AV</th></tr>";
		$ids[0] = "";
		$c = 0;
		echo "<form action='main.php' method='post'>";
		while($dsatz=mysql_fetch_assoc($res)) {
			$ids[$c] = $dsatz["id"];
			$c++;
			echo "<tr>";
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=6&lid=" . $dsatz["id"] . "'>L&ouml;schen</a></td>";
			echo "<td class='hsmallborder' align='center'><input type='text' name='rname_" . $dsatz["id"] . "' value='" . $dsatz["name"] . "'></td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='AA_" . $dsatz["id"] . "' ";
			if($dsatz["AA"]==true) echo "checked ";
			echo "></td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='UK_" . $dsatz["id"] . "' ";
			if($dsatz["UK"]==true) echo "checked ";
			echo "></td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='BW_" . $dsatz["id"] . "' ";
			if($dsatz["BW"]==true) echo "checked ";
			echo "></td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='ML_" . $dsatz["id"] . "' ";
			if($dsatz["ML"]==true) echo "checked ";
			echo "</td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='RM_" . $dsatz["id"] . "' ";
			if($dsatz["RM"]==true) echo "checked ";
			echo "</td>";
			
			echo "<td class='hsmallborder' align='center'><input type='checkbox' name='AV_" . $dsatz["id"] . "' ";
			if($dsatz["AV"]==true) echo "checked ";
			echo "</td>";
			
			echo "<input type='hidden' name='oldname_" . $dsatz["id"] . "' value='" . $dsatz["name"] . "'";
			
			echo "</tr>";
		}
		echo "<input type='hidden' name='target' value='ally'>";
		echo "<input type='hidden' name='ac' value='6'>";
		echo "<input type='hidden' name='ids' value='" . implode("-",$ids) . "'>";
		echo "<tr><td colspan='8' class='hsmallborder' align='center'><input type='submit' value='&Auml;ndern'>&nbsp;&nbsp;<input type='reset' value='Zur&uuml;cksetzen'></td></tr>";
		echo "</form>";
	}
	echo "</table>";
	echo "<br>";
	echo "<form action='main.php' method='post'>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' colspan='2' align='center'><b>Neuen Rang anlegen</b></td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>Rangname:</td><td class='hsmallborder' align='center'><br><input type='text' name='nrang'>&nbsp;&nbsp;<input type='submit' value='Erstellen'>&nbsp;&nbsp;<input type='reset' value='Abbrechen'><br><br></td></tr>";
	echo "</table>";
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='6'>"; 
	echo "</form>";
	
	echo "<br>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' colspan='2' align='center'><b>Legende der Rechte</b></td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>L</td><td class='hsmallborder' align='center'>Eintrag l�schen</td></tr>";
	
	echo "<tr><td class='hsmallborder' align='center' width='20%'>AA</td><td class='hsmallborder' align='center'>Allianz aufl�sen</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>UK</td><td class='hsmallborder' align='center'>User kicken</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>BW</td><td class='hsmallborder' align='center'>Bewerbungen bearbetien und einsehen</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>ML</td><td class='hsmallborder' align='center'>Mitglieder sehen</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>RM</td><td class='hsmallborder' align='center'>Rund Nachricht schicken</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='20%'>AV</td><td class='hsmallborder' align='center'>Allianz verwalten</td></tr>";
	echo "</table>";
	
	echo "<br><a href='main.php?target=ally&ac=3'>Schliesen</a>";
}
else if($ac==7) {
	echo "<h3>Rechte Vergeben</h3>";
	
	if(isset($_POST["ids"])) {
		#alles �ndern
		$ids = explode("-",$_POST["ids"]);
		for($i=0;$i<count($ids);$i++) {
			$rang = trim(mysql_escape_string($_POST["drang_" . $ids[$i]]));
			if($rang!='') {
				$sqlab= "update users set rangid='" . $rang . "' where id='" . $ids[$i] . "'";
				mysql_query($sqlab);
				echo "<font color='green'>Rang erfolgreich ge�ndert</font><br><br>";
			}
			else {
				echo "<font color='red'>Keine ID �bergeben.</font><br><br>";
			}
		}
		echo "<p><a href='main.php?target=ally&ac=7'>Clear</a></p>";
	}
	
	echo "<form action='main.php' method='post'>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><th class='hsmallborder'>ID</th><th class='hsmallborder'>Name</th><th class='hsmallborder'>Rang</th><th class='hsmallborder'>Aktuelle Schiffs Position</th><th class='hsmallborder'>Punkte</th><th class='hsmallborder'>Status</th></tr>";
	$sqlab = "select * from users where alianzid='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	$num=1;
	$ids[0] = '';
	while($dsatz = mysql_fetch_assoc($res)) {
		echo "<tr>";
		
		$sqlab 		= "select * from schiffe where id='" . $dsatz["schifid"] . "'";
		$res2   	= mysql_query($sqlab);
		$dsatz2 	= mysql_fetch_assoc($res2);
		$position = $dsatz2["y"] . ":" . $dsatz2["x"] . ":" . $dsatz2["sector"];
			
			
		$sqlab 		= "select * from alianzen where id='" . $userhomeali . "'";
		$res2   	= mysql_query($sqlab);
		$dsatz2 	= mysql_fetch_assoc($res2);
		
		if($dsatz2["gruender"]==$dsatz["name"]) {
			$rang = "Gr&uuml;nder";
		}
		else {
			$ids[$num-1]= $dsatz["id"];
			
			$sqlab = "select * from users where name='" . $dsatz["name"] . "'";
			$res2  = mysql_query($sqlab);
			$dsatz2= mysql_fetch_assoc($res2);
			
			$rang = "<select name='drang_" . $dsatz["id"] . "' size='1'>";
			if($dsatz2["rangid"]==0) {
				$rang .= "<option value='0'>Neuling</option>";
				$sqlab= "select * from allyraenge where allyid='" . $userhomeali . "'";
				$res2  = mysql_query($sqlab);
				while($dsatz2=mysql_fetch_assoc($res2)) {
					$rang .= "<option value='" . $dsatz2["id"] . "'>" . $dsatz2["name"] . "</option>";
				}
			}
			else {
				$sqlab = "select * from allyraenge where id='" . $dsatz2["rangid"] . "'";
				$res2  = mysql_query($sqlab);
				$dsatz3= mysql_fetch_assoc($res2);
				$rang .= "<option value='" . $dsatz3["id"] . "'>" . $dsatz3["name"] . "</option>";
				$sqlab= "select * from allyraenge where allyid='" . $userhomeali . "'";
				$res2  = mysql_query($sqlab);
				while($dsatz2=mysql_fetch_assoc($res2)) {
					if($dsatz2["name"]!=$dsatz3["name"])
						$rang .= "<option value='" . $dsatz2["id"] . "'>" . $dsatz2["name"] . "</option>";
				}
				$rang .= "<option value='0'>Neuling</option>";
			}
			$rang .= "</select>";
		}
		
		echo "<td class='hsmallborder' align='center'>" . $num . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $dsatz["name"] . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $rang . "</td>";
		echo "<td class='hsmallborder' align='center'>" . $position . "</td>";
		echo "<td class='hsmallborder' align='center'>Punkte fehlen noch</td>";
		echo "<td class='hsmallborder' align='center'>";
		if($dsatz["lastaction"]=='') {
			echo "<font color='red'>OFF";
		}
		else {
			$time_new = time()+500;
			if($dsatz["lastaction"] < $time_new) {
				echo "<font color='green'>ON";
			}
			else {
				echo "<font color='yellow'>Abwesend";
			}
		}
		echo "</font>";
		echo "</td>";
		echo "</tr>";
		$num++;
	}
	echo "<tr><td class='hsmallborder' align='center' colspan='6'><input type='submit' value='&Auml;ndern'>&nbsp;&nbsp;&nbsp;<input type='reset' value='Zur&uuml;cksetzen'></td></tr>";
	echo "</table>";
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='7'>";
	echo "<input type='hidden' name='ids' value='" . implode("-",$ids) . "'>";
	echo "</form>";
	
	echo "<br><a href='main.php?target=ally&ac=3'>Schliesen</a>";
}
else if($ac==8) {
	#allianz beitreten
	echo "<h3>Allianz Beitreten</h3>";
	if(isset($_POST["bname"])||isset($_GET["bname"])) {
		#beitreten pr�fen
		if(isset($_GET["bname"])) {
			$bname = trim(mysql_escape_string($_GET["bname"]));
		}
		else {
			$bname = trim(mysql_escape_string($_POST["bname"]));
		}
		$sqlab = "select * from alianzen where name='" . $bname . "' or tag='" . $bname . "' or id='" . $bname . "'";
		$res   = mysql_query($sqlab);
		if(mysql_num_rows($res)<=0) {
			echo "<font color='red'>Es gibt keine Allianz mit diesem namen oder diesem Tag.</font><br><br>";
			echo "<p><a href='main.php?target=ally&ac=8'>Zur&uuml;ck</a></p>";
		}
		else {
			$dsatz = mysql_fetch_assoc($res);
			
			echo "<p>Bewerbung schreiben:</p>";
			echo "<form action='main.php' method='post'>";
			echo "<textarea name='bewerbung' cols='70%' rows='20%'>" . $dsatz["bewerbungstext"] . "</textarea>";
			echo "<br><br><input type='submit' value='Bewerben'>&nbsp;&nbsp;<input type='reset' value='L&ouml;schen'>";
			echo "<input type='hidden' name='target' value='ally'>";
			echo "<input type='hidden' name='ac' value='8'>";
			echo "<input type='hidden' name='id' value='" . $dsatz["id"] . "'>";
			echo "</form>";
		}
	}
	else if(isset($_POST["bewerbung"])) {
		#bewerbung absenden
		$bew = trim(mysql_escape_string($_POST["bewerbung"]));
		$id  = trim(mysql_escape_string($_POST["id"]));
		if($bew=='') {
			echo "<font color='red'>Sie brauchen einen Bewerbungstext.</font><br><br>";
			$err=true;
		}
		else {
			$sqlab = "select * from bewerbungen where user='" . $_SESSION["user"] . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)>0) {
				echo "<font color='red'>Sie scheinen schon eine Bewerbung gesendet zu haben.</font><br><br>";
				$err=true;
			}
			else {
				$date  = date("m.d.Y H:i:s");
				$sqlab = "INSERT INTO `bewerbungen` ( `id` , `allyid` , `user` , `text` , `datum` , `type` ) VALUES (";
				$sqlab.="NULL , '" . $id . "', '" . $_SESSION["user"] . "', '" . $bew . "', '" . $date . "', 'bewerbung')";
				mysql_query($sqlab);
				echo "<font color='green'>Sie haben sich erfolgreich beworben.</font><br><br>"; 
				echo "<p><a href='main.php?target=ally'>Zur&uuml;ck</a></p>";
			}
		}

		if(isset($err)) {
			echo "<p><a href='main.php?target=ally&ac=8&bname=" . $id . "'>Zur&uuml;ck</a></p>";
		}
	}
	else {
		echo "<form action='main.php' method='post'>";
		echo "<p>Geben sie den Allianz Tag oder Namen ein bei der sie Beitreten wollen.</p>";
		echo "<input type='text' name='bname'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Beitreten'>&nbsp;&nbsp;<input type='reset' value='Zur&uuml;cksetzen'>";
		echo "<input type='hidden' name='target' value='ally'";
		echo "<input type='hidden' name='ac' value='8'>";
		echo "</form>";
		echo "<p><a href='main.php?target=ally'>Zur&uuml;ck</a></p>";
	}
}
else if($ac==9) {
	#bewerbungen und einladungen managen
	if(isset($_GET["t"]))
		$t=$_GET["t"];
	else if(isset($_POST["t"]))
		$t=$_POST["t"];
	else
		$t=0;
	$kat = trim(mysql_real_escape_string($kat));
	if(isset($_GET["view"])) {
		#eintrag anzeigen
		if($t==0) {
			echo "<h3>Bewerbung anzeigen</h3>";
			$id 	= trim(mysql_real_escape_string($_GET["view"]));
			$sqlab = "select * from bewerbungen where id='" . $id . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "<font color='red'>Dieser User existiert nicht mehr.</font>";
			}
			else {
				$dsatz = mysql_fetch_assoc($res);
				echo "<div id='abgerundedeecken6'>Username: " . $dsatz["user"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>Datum: " . $dsatz["datum"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>" . str_replace("\n","<br>",$dsatz["text"]) . "</div>";
				echo "<br>";
				echo "<form action='main.php' method='post'>";
				echo "<div id='abgerundedeecken6'><input type='submit' name='ak' value='Aufnehmen'>&nbsp;&nbsp;&nbsp;<input type='submit' name='ab' value='Ablehnen'></div>";
				echo "<input type='hidden' name='target' value='ally'>";
				echo "<input type='hidden' name='ac' value='9'>";
				echo "<input type='hidden' name='bid' value='" . $id . "'>";
				echo "</form>";
			}
		}
		else if($t==1) {
			echo "<h3>Einladungen anzeigen</h3>";
			$id 	= trim(mysql_real_escape_string($_GET["view"]));
			$sqlab = "select * from bewerbungen where id='" . $id . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "<font color='red'>Dieser User existiert nicht mehr.</font>";
			}
			else {
				$dsatz = mysql_fetch_assoc($res);
				echo "<div id='abgerundedeecken6'>Username: " . $dsatz["user"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>Datum: " . $dsatz["datum"] . "</div>";
				echo "<br>";
				echo "<div id='abgerundedeecken6'>" . str_replace("\n","<br>",$dsatz["text"]) . "</div>";
				echo "<br>";
				echo "<form action='main.php' method='post'>";
				echo "<div id='abgerundedeecken6'><input type='submit' name='ezu' value='Einladun zur&uuml;ck ziehen'></div>";
				echo "<input type='hidden' name='target' value='ally'>";
				echo "<input type='hidden' name='ac' value='9'>";
				echo "<input type='hidden' name='bid' value='" . $id . "'>";
				echo "</form>";
			}
		}
		
		echo "<br><a href='main.php?target=ally&ac=9&t=" . $t . "'>Clear</a><br>";
	}
	else if(isset($_POST["bid"])) {
		if(isset($_POST["ak"])) {
			#ablehnen
			$id = trim(mysql_real_escape_string($_POST["bid"]));
			if($id=='') {
				echo "<font color='red'>Keine ID �bergeben.</font>";
			}
			else {
				$sqlab = "select * from bewerbungen where id='" . $id . "'";
				$res   = mysql_query($sqlab);
				if(mysql_num_rows($res)<=0) {
					echo "<font color='red'>Diese ID existiert nicht mehr.</font><br>";
				}
				else {
					$dsatz = mysql_fetch_assoc($res);
					if($dsatz["allyid"]!=$userhomeali) {
						echo "<font color='red'>Achtung wir haben sie beim betr�gen erwischt.</font><br>";
					}
					else {
						$sqlab = "update users set alianzid='" . $userhomeali . "', rangid='0' where name='" . $dsatz["user"] . "'";
						mysql_query($sqlab);
						
						$sqlab = "delete from bewerbungen where id='" . $id . "' LIMIT 1";
						mysql_query($sqlab);
						
						$date  = date("m.d.Y H:i:s");
						
						$text   = "Sie wurden erfolgreich in der Ally bei der sie sich beworben haben aufgneommen.";
						
						$sqlab  = "INSERT INTO `mail` ( `id` , `absender` , `empfaenger` , `datum` , `status` , `owner` , `titel` , `text` ) VALUES (";
						$sqlab .= "NULL , '" . $_SESSION["user"] . "', '" . $dsatz["user"] . "', '" . $date . "', 'neu', 'ausgang', 'Bewerbung Ally', '" . $text . "')";
						mysql_query($sqlab);
						
						echo "<font color='green'>Bewerbung erfolgreich angenommen.</font><br>";
					}
				}
			}
		}
		else if(isset($_POST["ab"])) {
			#aufnhemen
			$id = trim(mysql_real_escape_string($_POST["bid"]));
			if($id=='') {
				echo "<font color='red'>Keine ID �bergeben.</font><br>";
			}
			else {
				$sqlab = "select * from bewerbungen where id='" . $id . "'";
				$res   = mysql_query($sqlab);
				if(mysql_num_rows($res)<=0) {
					echo "<font color='red'>Diese ID existiert nicht mehr.</font><br>";
				}
				else {
					$dsatz = mysql_fetch_assoc($res);
					if($dsatz["allyid"]!=$userhomeali) {
						echo "<font color='red'>Achtung wir haben sie beim betr�gen erwischt.</font><br>";
					}
					else {
						$sqlab = "delete from bewerbungen where id='" . $id . "' LIMIT 1";
						mysql_query($sqlab);
						
						$date  = date("m.d.Y H:i:s");
						
						$text   = "Ihre Bewerbung wurde abgelehnt bitte reden sie mit dem Absender dieser mail �ber ihre Ablehnung.";
						
						$sqlab  = "INSERT INTO `mail` ( `id` , `absender` , `empfaenger` , `datum` , `status` , `owner` , `titel` , `text` ) VALUES (";
						$sqlab .= "NULL , '" . $_SESSION["user"] . "', '" . $dsatz["user"] . "', '" . $date . "', 'neu', 'ausgang', 'Bewerbung Ally', '" . $text . "')";
						mysql_query($sqlab);
						
						echo "<font color='green'>Bewerbung erfolgreich abgelehnt.</font><br>";
					}
				}
			}
		}
		else if(isset($_POST["ezu"])) {
			#einladung zur�ckziehen
			$id = trim(mysql_real_escape_string($_POST["bid"]));
			if($id=='') {
				echo "<font color='red'>Keine ID �bergeben.</font>";
			}
			else {
				$sqlab = "select * from bewerbungen where id='" . $id . "'";
				$res   = mysql_query($sqlab);
				if(mysql_num_rows($res)<=0) {
					echo "<font color='red'>Diese ID existiert nicht mehr.</font><br>";
				}
				else {
					$dsatz = mysql_fetch_assoc($res);
					if($dsatz["allyid"]!=$userhomeali) {
						echo "<font color='red'>Achtung wir haben sie beim betr�gen erwischt.</font><br>";
					}
					else {
						$sqlab = "delete from bewerbungen where id='" . $id . "' LIMIT 1";
						mysql_query($sqlab);
						
						$date  = date("m.d.Y H:i:s");
						
						$text   = "Die Einladung wurde zur�ckgezogen.";
						
						$sqlab  = "INSERT INTO `mail` ( `id` , `absender` , `empfaenger` , `datum` , `status` , `owner` , `titel` , `text` ) VALUES (";
						$sqlab .= "NULL , '" . $_SESSION["user"] . "', '" . $dsatz["user"] . "', '" . $date . "', 'neu', 'ausgang', 'Einladung in Ally', '" . $text . "')";
						mysql_query($sqlab);
						
						echo "<font color='green'>Einladung erfolgreich zur�ckgezogen.</font><br>";
					}
				}
			}
		}
	}
	else if(isset($_POST["esch"])) {
		echo "<br>";
		$user = trim(mysql_real_escape_string($_POST["empf"]));
		$btext= trim(mysql_real_escape_string($_POST["etext"]));
		if($user==''||$btext=='') {
			echo "<font color='red'>Sie m�ssen einen Empf�nger und einen Text angeben.</font><br>";
		}
		else {
			$sqlab = "select * from users where name='" . $user . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "<font color='red'>Der User existiert nicht.</font><br>";
			}
			else {
				$dsatz = mysql_fetch_assoc($res);
				$sqlab = "select * from bewerbungen where allyid='" . $userhomeali . "' and user='" . $user . "' and type='einladung'";
				$res   = mysql_query($sqlab);
				if(mysql_num_rows($res)>0) {
					echo "<font color='red'>Sie haben diesem User bereits eine Einladung geschickt.</font><br>";
				}
				else {
					$date  = date("m.d.Y H:i:s");
						
					$text   = "Sie haben eine einladung zum Beitrit in einer Ally bekommen.";
					$sqlab  = "INSERT INTO `mail` ( `id` , `absender` , `empfaenger` , `datum` , `status` , `owner` , `titel` , `text` ) VALUES (";
					$sqlab .= "NULL , '" . $_SESSION["user"] . "', '" . $user . "', '" . $date . "', 'neu', 'ausgang', 'Einladung in Ally', '" . $text . "')";
					mysql_query($sqlab);
					
					$sqlab  = "INSERT INTO `bewerbungen` ( `id` , `allyid` , `user` , `text` , `datum` , `type` ) VALUES (";
					$sqlab .= "NULL , '" . $userhomeali . "', '" . $user . "', '" . $btext . "', '" . $date . "', 'einladung')";
					mysql_query($sqlab);
					
					echo "<font color='green'>Sie haben " . $user ." erfolgreich eine einladung geschickt.</font><br>";
				}
			}
		}		
	}
	echo "<br>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' align='center' colspan='3'><b>Einladungen/Bewerbungen Managen</b></td></tr>";
	echo "<tr><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=9&t=0'>Bewerbungen</td><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=9&t=1'>Einladungen</td><td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=9&t=2'>Einladung Schreiben</td></tr>";
	echo "</table>";
	
	echo "<br>";
	
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><td class='hsmallborder' align='center' ";
	if($t!='2')
		echo "colspan='4'";
	echo "><b>";
	if($t==0)
		echo "Bewerbungen";
	else if($t==1)
		echo "Einladugen";
	else if($t==2)
		echo "Einladung Schreiben";
	echo "</b></td></tr>";
	
	if($t==0) {
		$sqlab = "select * from bewerbungen where allyid='" . $userhomeali . "' and type='bewerbung'";
		$res   = mysql_query($sqlab);
		$num   = 1;
		while($dsatz=mysql_fetch_assoc($res)) {
			echo "<tr>";
			echo "<td class='hsmallborder' align='center'>" . $num . "</td>";
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=9&t=0&view=" . $dsatz["id"] . "'>" . $dsatz["user"] . "</a></td>";
			echo "<td class='hsmallborder' align='center'>" . $dsatz["datum"] . "</td>";
			echo "<td class='hsmallborder' align='center'>" . substr($dsatz["text"], 0, 25) . "...</td>";
			echo "</tr>";
			$num++;
		}
	}
	else if($t==1) {
		$sqlab = "select * from bewerbungen where allyid='" . $userhomeali . "' and type='einladung'";
		$res   = mysql_query($sqlab);
		$num   = 1;
		while($dsatz=mysql_fetch_assoc($res)) {
			echo "<tr>";
			echo "<td class='hsmallborder' align='center'>" . $num . "</td>";
			echo "<td class='hsmallborder' align='center'><a style='text-decoration: none;' href='main.php?target=ally&ac=9&t=1&view=" . $dsatz["id"] . "'>" . $dsatz["user"] . "</a></td>";
			echo "<td class='hsmallborder' align='center'>" . $dsatz["datum"] . "</td>";
			echo "<td class='hsmallborder' align='center'>" . substr($dsatz["text"], 0, 25) . "...</td>";
			echo "</tr>";
			$num++;
		}
	}
	else if($t==2){
		echo "<form action='main.php' method='post'>";
		echo "<tr><td class='hsmallborder' align='center'>User: <input type='text' name='empf'></td></tr>";
		echo "<tr><td class='hsmallborder' align='center'><textarea name='etext' cols='80%' rows='15%'></textarea></td></tr>";
		echo "<tr><td class='hsmallborder' align='center'><input type='submit' value='Absenden' name='esch'>&nbsp;&nbsp;&nbsp;<input type='reset' value='Abbrechen'></td></tr>";
		echo "<input type='hidden' name='target' value='ally'>";
		echo "<input type='hidden' name='ac' value='9'>";
		echo "<input type='hidden' name='t' value='2'>";
		echo "</form>";
	}
	echo "</table>";
	
	echo "<br><a href='main.php?target=ally'>Schliesen</a>";
}
else if($ac==10) {
	#allianz aufl�sen
	echo "<h3>Allianz aufl�sen</h3>";
	if(!(isset($_GET["l"]))) {
		echo "<p>Wollen sie die Allianz wirklich aufl�sen?</p>";
		echo "<div id='navcontainer'>";
		echo "<ul id='navlist'>";
		echo "<li><a href='main.php?target=ally&ac=10&l=1'>Ja</a></li>";
		echo "<li><a href='main.php?target=ally'>Nein</a></li>";
		echo "</ul>";
		echo "</div>";
	}
	else {
		#l�schen
		
		#bewerbungen und einladungen l�schen
		$sqlab = "delete from bewerbungen where allyid='" . $userhomeali . "'";
		mysql_query($sqlab);
		
		#raenge l�schen
		$sqlab = "delete from allyraenge where allyid='" . $userhomeali . "'";
		mysql_query($sqlab);
		
		#an jeden user eine nachricht schreiben
		$sqlab = "select * from users where alianzid='" . $userhomeali . "'";
		$res   = mysql_query($sqlab);
		while($dsatz=mysql_fetch_assoc($res)) {
			$date  = date("m.d.Y H:i:s");
						
			$text   = "Ihre Ally wurde aufgel�st.";
						
			$sqlab  = "INSERT INTO `mail` ( `id` , `absender` , `empfaenger` , `datum` , `status` , `owner` , `titel` , `text` ) VALUES (";
			$sqlab .= "NULL , '" . $_SESSION["user"] . "', '" . $dsatz["user"] . "', '" . $date . "', 'neu', 'ausgang', 'Ally aufl�sung', '" . $text . "')";
			mysql_query($sqlab);
		}
		
		#allen usern die rechte entziehen und die allyid l�schen
		$sqlab = "update users set alianzid='0', rangid='0' where alianzid='" . $userhomeali . "'";
		mysql_query($sqlab);
		
		echo "<font color='green'>Die Allianz wurde erfolgreich aufgel�st.</font>";
	}
}
else if($ac==11) {
	#aus der allianz austreten
	echo "<h3>Aus Allianz austreten</h3>";
	if(!(isset($_GET["a"]))) {
		echo "<p>Wollen sie aus der Allianz wirklich austerten?</p>";
		echo "<div id='navcontainer'>";
		echo "<ul id='navlist'>";
		echo "<li><a href='main.php?target=ally&ac=11&a=1'>Ja</a></li>";
		echo "<li><a href='main.php?target=ally'>Nein</a></li>";
		echo "</ul>";
		echo "</div>";
	}
	else {
		$sqlab = "update users set alianzid='0', rangid='0' where name='" . $_SESSION["user"] . "'";
		mysql_query($sqlab);
		
		echo "<font color='green'>Sie sind erfolgreich ausgetreten.</font>";
	}
}
else if($ac==12) {
	#Gr�nder recht �bertragen
	if(!(isset($_POST["ng"]))&&!isset($_POST["ab"])) {
		echo "<h3>Gr�nder recht �bertragen</h3>";
		echo "<p>Wem wollen sie das Gr�nder recht �bergeben?</p>";
		echo "<form action='main.php' method='post'>";
		
		echo "<p>Neuer Gr&uuml;nder:</p>";
		echo "<p><select name='ngr' size='1'>";
		$sqlab = "select * from users where alianzid='" . $userhomeali . "'";
		$res   = mysql_query($sqlab);
		while($dsatz=mysql_fetch_assoc($res)) {
			if($dsatz["name"]!=$_SESSION["user"])
				echo "<option>" . $dsatz["name"] . "</option>";
		}
		echo "</select></p>";
		
		echo "<p>Ihr Zuk�nftiges Recht:</p>";
		echo "<p><select name='nre' size='1'>";
		$sqlab = "select * from allyraenge where allyid='" . $userhomeali . "'";
		$res   = mysql_query($sqlab);
		
		echo "<option value='0'>Neuling</option>";
		while($dsatz=mysql_fetch_assoc($res)) {
			echo "<option value='" . $dsatz["id"] . "'>" . $dsatz["name"] . "</option>";
		}
		echo "</select></p>";
		
		echo "<input type='submit' name='ng' value='&Uuml;bertragen'>&nbsp;&nbsp;&nbsp;";
		echo "<input type='submit' name='ab' value='Abbrechen'>";
		
		echo "<input type='hidden' name='target' value='ally'>";
		echo "<input type='hidden' name='ac' value='12'>";
		echo "</form>";
	}
	else if(isset($_POST["ab"])){
		$ac=0;
	}
	else {
		echo "<h3>Gr�nder recht �bertragen</h3>";
		
		$ngr = mysql_real_escape_string($_POST["ngr"]);
		$nre = mysql_real_escape_string($_POST["nre"]);
		if($ngr==''||$nre=='') {
			echo "<font color='red'>Kein Neuer Benutzer oder kein Neues Recht ausgew�hlt.</font><br>";
		}
		else {
			$sqlab = "select * from users where name='" . $ngr . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "<font color='red'>User existiert nicht mehr.</font><br>";
			}
			else {
				$sqlab = "update alianzen set gruender='" . $ngr . "' where id='" . $userhomeali . "'";
				mysql_query($sqlab);
				
				$sqlab = "update users set rangid='" . $nre . "' where name='" . $_SESSION["user"] . "'";
				mysql_query($sqlab);
				
				echo "<font color='green'>Sie haben erfolgreich den Gr�nder title abgetreten.</font><br>";
			}
		}
		
		echo "<p><a href='main.php?target=ally'>Zur&uuml;ck</a></p>";
	}
}
else if($ac==13) {
	#alle allys auflisten
	echo "<h3>Alle Allianzen</h3>";
	echo "<p><a href='main.php?target=ally&ac=15&l=1'>Suche</a></p>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><th class='hsmallborder' align='center'>ID</th><th class='hsmallborder' align='center'>Name</th><th class='hsmallborder' align='center'>Tag</th><th class='hsmallborder' align='center'>Mitglieder</th></tr>";
	$sqlab = "select * from alianzen";
	$res   = mysql_query($sqlab);
	$num   = 1;
	while($dsatz=mysql_fetch_assoc($res)) {
		echo "<tr>";
		$sqlab = "select * from users where alianzid='" . $dsatz["id"] . "'";
		$res2  = mysql_query($sqlab);
		$numbew= mysql_num_rows($res2);
		echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . $num . "</a></td>";
		echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . $dsatz["name"] . "</a></td>";
		echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . $dsatz["tag"] . "</a></td>";
		echo "<td align='center' class='hsmallborder'>" . $numbew . "</td>";
		echo "</tr>";
		$num++;
	}
	echo "</table>";
	echo "<p><a href='main.php?target=ally'>Zur&uuml;ck</a></p>";
}
else if($ac==14) {
	#bewerbung zurckziehen
	echo "<h3>Bewerbung zur�ckzeihen</h3>";
	if(!(isset($_GET["z"]))) {
		echo "<p>Wollen sie wirklich ihre bewerbung zur&uuml;ckziehen?</p>";
		echo "<div id='navcontainer'>";
		echo "<ul id='navlist'>";
		echo "<li><a href='main.php?target=ally&ac=14&z=1'>Ja</a></li>";
		echo "<li><a href='main.php?target=ally'>Nein</a></li>";
		echo "</ul>";
		echo "</div>";
	}
	else {
		$sqlab = "delete from bewerbungen where user='" . $_SESSION["user"] . "' LIMIT 1";
		mysql_query($sqlab);
		
		echo "<font color='green'>Sie haben irhe bewerbung eroglreich zur&uuml;ckgezogen</font>";
	}
}
else if($ac==15) {
	#ally suchen
	echo "<h3>Alle Allianzen</h3>";
	echo "<p><a href='main.php?target=ally&ac=13&s=1'>Alle Auflisten</a></p>";
	
	echo "<form action='main.php' method='post'>";
	if(isset($_POST["serach"])) {
		$search = $_POST["serach"];
	}
	else {
		$search = "";
	}
	echo "<p>Sichbegriff: <input type='text' name='serach' value='" . $search . "'>&nbsp;<input type='submit' value='Suche Starten'></p>";
	echo "<input type='hidden' name='target' value='ally'>";
	echo "<input type='hidden' name='ac' value='15'>";
	echo "</form>";
	
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	echo "<tr><th class='hsmallborder' align='center'>ID</th><th class='hsmallborder' align='center'>Name</th><th class='hsmallborder' align='center'>Tag</th><th class='hsmallborder' align='center'>Mitglieder</th></tr>";
	$sqlab = "select * from alianzen";
	$res   = mysql_query($sqlab);
	$num   = 1;
	if($search!='') {
		while($dsatz=mysql_fetch_assoc($res)) {
			if(substr_count($dsatz["tag"],$search)>0||substr_count($dsatz["name"],$search)>0) {
				echo "<tr>";
				$sqlab = "select * from users where alianzid='" . $dsatz["id"] . "'";
				$res2  = mysql_query($sqlab);
				$numbew= mysql_num_rows($res2);
				echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . $num . "</a></td>";
				echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . str_replace($search,"<b>" . $search . "</b>",$dsatz["name"]) . "</a></td>";
				echo "<td align='center' class='hsmallborder'><a style='text-decoration: none;' href='main.php?target=ally&aliid=" . $dsatz["id"] . "'>" . str_replace($search,"<b>" . $search . "</b>",$dsatz["tag"]) . "</a></td>";
				echo "<td align='center' class='hsmallborder'>" . $numbew . "</td>";
				echo "</tr>";
				$num++;
			}
		}
	}
	else {
		echo "<tr><td colspan='4' align='center' class='hsmallborder'>Kein Suchbegriff</td></tr>";
	}
	echo "</table>";
	
	echo "<p><a href='main.php?target=ally'>Zur&uuml;ck</a></p>";
}
if($aliid!=0&&$ac==0&&$userhomeali!=$aliid) {
	#tag anzeigen
	echo "<br>";
	$sqlab = "select * from alianzen where id='" . $aliid . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$sqlab = "select * from users where alianzid='" . $dsatz["id"] . "'";
	$res   = mysql_query($sqlab);
	$anzmitgleider = mysql_num_rows($res);
	
	if($userhomeali==0) {
		$sqlab = "select * from bewerbungen where user='" . $_SESSION["user"] . "' and type='bewerbung'";
		$res   = mysql_query($sqlab);
	}
	
	
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	if($dsatz["logo"]!='') {
		echo "<tr><td align='center'colspan='2'><img src='" . $dsatz["logo"] . "' alt='Logo der Allianz'></td></tr>";
	}
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Tag</td><td class='hsmallborder' align='center'>" . $dsatz["tag"] . "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Name</td><td class='hsmallborder' align='center'>" . $dsatz["name"] . "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Mitglieder</td><td class='hsmallborder' align='center'>" . $anzmitgleider . "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' colspan='2'>";
	echo "<br>";
	if(bbcode($dsatz["externetext"])=='') {
		echo "<br>";
	}
	else {
		echo bbcode($dsatz["externetext"]);
	}
	echo "<br><br>";
	echo "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Homepage</td><td class='hsmallborder' align='center'>";
	if($dsatz["hp"]!='') {
		echo "<a href='" . $dsatz["hp"] . "' target='_blank'>" . $dsatz["hp"] . "</a>";
	}
	else {
		echo "&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center'>Beitreten</td><td class='hsmallborder' align='center'>";
	if($userhomeali!=0) {
		echo "Sie sind bereits in einer Ally";
	}
	else {
		if(mysql_num_rows($res)>0) {
			$dsatz2 = mysql_fetch_assoc($res);
			if($dsatz2["allyid"]==$dsatz["id"]) {
				echo "Sie haben sich bei der Ally schon beworben";
			}
			else {
				echo "Sie haben sich bereits bei einer Ally beworben";
			}
		}
		else {
			echo "<a style='text-decoration: none;' href='main.php?target=ally&ac=8&bname=" . $dsatz["id"] . "'>Bewerben</a>";
		}
	}
	echo "</td></tr>";
	echo "</table>";
	
	echo "<br><a href='main.php?target=ally&ac=13'>Schliesen</a>";
}
else if($userhomeali!=0&&$ac==0) {
	$sqlab = "select * from alianzen where id='" . $userhomeali . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$sqlab = "select * from users where alianzid='" . $dsatz["id"] . "'";
	$res   = mysql_query($sqlab);
	$anzmitgleider = mysql_num_rows($res);
	
	$mlistview 		= false;
	$allyverwaltung = false;
	$bewerbungenview= false;
	$allyaufloesen  = false;
	if($dsatz["gruender"]==$_SESSION["user"]) {
		$rang = "Gr&uuml;nder";
	}
	else {
		$sqlab = "select * from users where name='" . $_SESSION["user"] . "'";
		$res   = mysql_query($sqlab);
		$dsatz2= mysql_fetch_assoc($res);
		
		if($dsatz2["rangid"]==0) {
			$rang = "Neuling";
		}
		else {
			#rang aus der rang db holen
			$sqlab = "select * from allyraenge where id='" . $dsatz2["rangid"] . "'";
			$res   = mysql_query($sqlab);
			$dsatz3= mysql_fetch_assoc($res);
			$rang  = $dsatz3["name"];
			
			if($dsatz3["ML"]) $mlistview = true;
			if($dsatz3["AV"]) $allyverwaltung = true;
			if($dsatz3["BW"]) $bewerbungenview = true;
			if($dsatz3["AA"]) $allyaufloesen = true;
		}
	}
	
	if($dsatz["gruender"]==$_SESSION["user"]) {
		$mlistview 		= true;
		$allyverwaltung	= true;
		$bewerbungenview= true;
		$allyaufloesen  = true;
	}
	
	echo "<h3>Ihre Allianz</h3>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='90%'>";
	if($dsatz["logo"]!='') {
		echo "<tr><td align='center'colspan='2'><img src='" . $dsatz["logo"] . "' alt='Logo der Allianz'></td></tr>";
	}
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Tag</td><td class='hsmallborder' align='center'>" . $dsatz["tag"] . "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Name</td><td class='hsmallborder' align='center'>" . $dsatz["name"] . "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Mitglieder</td><td class='hsmallborder' align='center'>" . $anzmitgleider;
	if($mlistview) {
		echo " (<a style='text-decoration: none;' href='main.php?target=ally&ac=2'>Mitgliederliste</a>)";
	}
	echo "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Rang</td><td class='hsmallborder' align='center'>" . $rang;
	if($allyverwaltung) {
		echo " (<a style='text-decoration: none;' href='main.php?target=ally&ac=3'>Allianz Verwalten</a>)";
	}
	echo "</td></tr>";
	if($bewerbungenview) {
		$sqlab = "select * from bewerbungen where allyid='" . $userhomeali . "' and type='bewerbung'";
		$res2  = mysql_query($sqlab);
		$numbew= mysql_num_rows($res2);
		echo "<tr><td class='hsmallborder' align='center' width='50%'>Bewerbungen</td><td class='hsmallborder' align='center'>";
		echo " <a style='text-decoration: none;' href='main.php?target=ally&ac=9'>Bewerbungen verwalten (" . $numbew . ")</a>";
		echo "</td></tr>";
	}
	echo "<tr><td class='hsmallborder' align='center' colspan='2'>";
	echo "<br>";
	if(bbcode($dsatz["externetext"])=='') {
		echo "<br>";
	}
	else {
		echo bbcode($dsatz["externetext"]);
	}
	echo "<br><br>";
	echo "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' width='50%'>Homepage</td><td class='hsmallborder' align='center'>";
	if($dsatz["hp"]!='') {
		echo "<a href='" . $dsatz["hp"] . "' target='_blank'>" . $dsatz["hp"] . "</a>";
	}
	else {
		echo "&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' colspan='2'>Interner Bereich</td></tr>";
	echo "<tr><td class='hsmallborder' align='center' colspan='2'>";
	echo "<br>";
	if(bbcode($dsatz["internetext"])=='') {
		echo "<br>";
	}
	else {
		echo bbcode($dsatz["internetext"]);
	}
	echo "<br><br>";
	echo "</td></tr>";
	if($allyaufloesen) {
		echo "<tr><td class='hsmallborder' align='center' colspan='2'><a style='text-decoration: none;' href='main.php?target=ally&ac=10'>Aufl&ouml;sen</a></td></tr>";
	}
	if($dsatz["gruender"]!=$_SESSION["user"]) {
		echo "<tr><td class='hsmallborder' align='center' colspan='2'><a style='text-decoration: none;' href='main.php?target=ally&ac=11'>Austreten</a></td></tr>";
	}
	else {
		echo "<tr><td class='hsmallborder' align='center' colspan='2'><a style='text-decoration: none;' href='main.php?target=ally&ac=12'>Gr�nder recht �bergeben</a></td></tr>";
	}
	echo "</table>";
}
?>