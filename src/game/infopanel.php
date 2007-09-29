<table border='0' width='95%' style="height: 90%">
	<?php
	$sqlab 		= "select * from users where name='" . $_SESSION["user"] . "'";
	$res   		= mysql_query($sqlab);
	$dsatz 		= mysql_fetch_assoc($res);
	
	$credits	= $dsatz["credits"];
	
	$sqlab 	  = "select * from schiffe where id='" . $_SESSION["ship"] . "'";
	$res      = mysql_query($sqlab);
	
	$dsatz2   = mysql_fetch_assoc($res);
	
	$sqlab    = "select * from schiffe where userid='" . $dsatz["id"] . "' and x='" . $dsatz2["x"] . "' and y='" . $dsatz2["y"] . "' and sector='" . $dsatz2["sector"] . "'";
	$res      = mysql_query($sqlab);
	
	if(mysql_num_rows($res) > 1) {
		$shiplist  = "<form name='changship' action='main.php' method='post'>";
		if($_SESSION["JavaScript"]==true) {
			$shiplist .= "<select name='ship' onChange='document.changship.submit();'>";
		}
		else {
			$shiplist .= "<select name='ship'>";
		}
		$shiplist .= "<option value='" . $dsatz2["id"] . "'>" . $dsatz2["schiffsid"] . "</option>";
		$shiplist .= "<option value='" . $dsatz2["id"] . "'>&nbsp;</option>";
		while($dsatz3=mysql_fetch_assoc($res)) {
			$shiplist .= "<option value='" . $dsatz3["id"] . "'>" . $dsatz3["schiffsid"] . "</option>";
		}
		$shiplist .= "</select>";
		
		if($_SESSION["JavaScript"]==false) {
			$shiplist .= "&nbsp;<input type='submit' value='W&#228;chseln'>";
		}
		$shiplist .= "<input type='hidden' name='target' value='" . $tmpTarget . "'>";
		$shiplist .= "<input type='hidden' name='shipswitch' value='1'>";
		$shiplist .= "</form>";
	}
	else {
		$shiplist  = "<select name='ship'>";
		$shiplist .= "<option>" . htmlentities($dsatz2["schiffsid"]) . "</option>";
		$shiplist .= "</select>";
	}
	
	$sqlab = "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
	$res   = mysql_query($sqlab);
	
	$clock  = "<div id='abgerundedeecken2'>";
	if($_SESSION["JavaScript"]==true) {
		$clock .= "<span id='dateinput'></span><br>";
		$clock .= "<span id='timeinput'></span>";
		if(mysql_num_rows($res)>0) {
			$clock .= "<br><span id='flyinput'></span>";
		}
	}
	else {
		$clock .= date("d.m.Y");
		$clock .= "<br>Keine Aktuelle Zeit";
		if(mysql_num_rows($res)>0) {
			//$dsatz  = mysql_fetch_assoc($res);
			$clock .= "<br>Sie Fliegen gerade";
		}
	}
	$clock .= "</div>";
	
	echo "<tr><td align='left' width='20%'>";
	echo $shiplist . "<br>";
	$sqlab = "select * from bewerbungen where user='" . $_SESSION["user"] . "' and type='einladung'";
	$res   = mysql_query($sqlab);
	if(mysql_num_rows($res)>0) {
		$text = "Neue Einladung";
		if(mysql_num_rows($res)>1) $text .= "en";
		echo "<div align='center'><blink><a href='main.php?target=einladung' title='" . mysql_num_rows($res) . " " . $text . "'>";
		if($_SESSION["gmod"]=="1") {
			#grafischer link
			echo "<img src='../daten/icons/neweinladung.png' border='0' alt='" . $text . "' title='" . mysql_num_rows($res) . " " . $text . "'>";
		}
		else {
			echo $text;
		}
		echo "</a></blink></div>";
	}
	echo "</td><td align='center' width='60%'>";
	echo $clock;
	echo "</td><td align='right'>";
	echo $credits . " Credits<br>";
	$sqlab = "select * from mail where empfaenger='" . $_SESSION["user"] . "' and status='neu'";
	$res   = mysql_query($sqlab);
	if(mysql_num_rows($res)>0) {
		$text = "Neue Nachricht";
		if(mysql_num_rows($res)>1) $text .= "en";
		echo "<div align='center'><blink><a href='main.php?target=message&action=eingang' title='" . mysql_num_rows($res) . " " . $text . "'>";
		if($_SESSION["gmod"]=="1") {
			#grafischer link
			echo "<img border='0' src='../daten/icons/newmessag.png' alt='" . $text . "' title='" . mysql_num_rows($res) . " " . $text . "'>";
		}
		else {
			echo $text;
		}
		echo "</a></blink></div>";
	}
	echo "</td></tr>";
	?>
</table>

<?php
#flug counter
$sqlab = "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
$res   = mysql_query($sqlab);
if($_SESSION["JavaScript"]==true&&mysql_num_rows($res)>0) {
	$dsatz = mysql_fetch_assoc($res);
	$time  = $dsatz["time_array"];
	$time  = explode("#",$time);
	$time  = $time[count($time)-1];
	echo '<script Language="JavaScript" type="text/javascript">';
	echo 'var leuft = true;';
	echo 'var target = new Date(' . strftime("%Y",$time) . ', ' . strftime("%m",$time) . ', ' . strftime("%d",$time) . ', ' . strftime("%H",$time) . ', ' . strftime("%M",$time) . ', ' . strftime("%S",$time) . ', 0);';
	echo 'function FlugCounter () {';
	echo 'jetzt = new Date();';
	echo 'rest = target - jetzt;';
	echo 'rest = Math.floor(rest/1000);';

	echo 'if (leuft==true) {';
	echo 'tage = Math.floor(rest/86400);';
	echo 'rest %= 86400;';

	echo 'stunden = Math.floor(rest/3600);';
	echo 'if (stunden < 10) stunden = "0" + stunden;';
	echo 'rest %= 3600;';

	echo 'minuten = Math.floor(rest/60);';
	echo 'if (minuten < 10) minuten = "0" + minuten;';
	echo 'rest %= 60;';

	echo 'sekunden = rest;';
	echo 'if (sekunden < 10) sekunden = "0" + sekunden;}';
	
	echo 'if (sekunden==0&&minuten==0&&stunden==0) { var verbleibende_zeit = "Angekommen"; leuft=false;}else{';

	echo "var verbleibende_zeit = stunden + ':' + minuten + ':' + sekunden + '&nbsp;<a style=\"text-decoration:none\"href=\"main.php?target=home&sac=ab\">Abbrechen</a>';}";

	//Code wenn ein Formular verwendet wird
	echo 'document.getElementById("flyinput").innerHTML = verbleibende_zeit;';

	echo 'setTimeout("FlugCounter()", 1000);';
	echo '}';
	echo '<' . '/' . 'script>';
	
	echo '<script Language="JavaScript" type="text/javascript">';
	echo 'FlugCounter();';
	echo '<' . '/' . 'script>';
}
#zeti counter
if($_SESSION["JavaScript"]==true) {
	echo '<script Language="JavaScript" type="text/javascript">';
	echo 'var ZeitString, DatumsString = "";';

	echo 'function ZeitDatum () {';
	echo 'var Jetzt = new Date();';
  
	echo 'var Tag = Jetzt.getDate();';
	echo 'var Monat = Jetzt.getMonth()+1;';
      
	echo 'var Jahr = Jetzt.getFullYear();';
	echo 'DatumsString = Tag;';
	echo 'DatumsString += ((Monat<10) ? ".0" : ".") + Monat;';
	echo 'DatumsString += "." + Jahr;';
	echo 'document.getElementById("dateinput").innerHTML = DatumsString;';

      //aktuelle Uhrzeit
	echo 'Stunden = Jetzt.getHours();';
	echo 'Minuten = Jetzt.getMinutes();';
	echo 'Sekunden = Jetzt.getSeconds();';
	echo 'ZeitString = Stunden;';
	echo 'ZeitString += ((Minuten < 10) ? ":0" : ":") + Minuten;';
	echo 'ZeitString += ((Sekunden < 10) ? ":0" : ":") + Sekunden;';
	echo 'document.getElementById("timeinput").innerHTML = ZeitString;';

	echo 'setTimeout("ZeitDatum()", 1000);';
	echo '}';
	echo 'function popup(w,h,site) {';
	echo 'x = screen.availWidth/2-w/2;';
	echo 'y = screen.availHeight/2-h/2;';
	echo "var popupWindow = window.open(site,'','toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=' + w + ', height=' + h);";
	echo '}';
	echo '<' . '/' . 'script>';
	
	echo '<script Language="JavaScript" type="text/javascript">';
	echo 'ZeitDatum();';
	echo '<' . '/' . 'script>';
}
?>