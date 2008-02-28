<h4>Bank</h4>
<?php
$action = $_GET['maction'];
// UserID feststellen
$sql = ("SELECT id FROM users WHERE name='".$_SESSION['user']."'");
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($result);
$userid = $row['id'];
//echo "USER: $userid<br>";

if($action == "bankinfo")
{
	$bankname = $_GET['id'];
	$bankname = htmlentities($bankname);
	$bankname = mysql_real_escape_string($bankname);
	
	$sql = ("SELECT * FROM bank WHERE id='$bankname'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$name          = $row['name'];
	$eig_kapital   = $row['eig_kapital'];
	$fremd_kapital = $row['fremd_kapital'];
	$gut_zins      = $row['gut_zins'];
	$schuld_zins   = $row['schuld_zins'];
	$steuern       = $row['steuern'];
	$managerid     = $row['managerid'];
	
	// Manager name rausfinden
	$sql = ("SELECT name FROM users WHERE id='$managerid'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$managername = $row['name'];
	
	echo "Der Bank <b>$name</b> wird betreut von <b>$managername</b>.<br>
			Der Bank hat einen fremd Kapital von <b>$fremd_kapital</b>.<br>
			Dabei einen eigen Kapital in h&ouml;he von <b>$eig_kapital</b><br>
			<hr><h5>Steuern</h5>
			<table><tr><td>Hab Zins</td><td>$gut_zins</td></tr>
					<tr><td>Soll Zins</td><td>$schuld_zins</td></tr>
			</table><hr>";
}

if($action == "kontoinfo")
{
	$konto = $_GET['id'];
	$konto = htmlentities($konto);
	$konto = mysql_real_escape_string($konto);
	
	// Prüfen ob der kontonummer vom user ist.
	check_konto_owner($konto,$userid);
	
	$sql = ("SELECT * FROM ");
	
	echo "<a href=main.php?target=bank&maction=ueberweisung&id=$konto>&Uuml;berweisungen</a>";
}

if($action == "ueberweisung")
{
	$konto = $_GET['id'];
	$konto = htmlentities($konto);
	$konto = mysql_real_escape_string($konto);
	
	// Prüfen ob der kontonummer vom user ist.
	check_konto_owner($konto,$userid);
	
	if(isset($_GET['test']))
	{
		$empfaenger = $_POST['emp'];
		$betrag     = $_POST['betrag'];
		$verwend    = $_POST['verwend'];
		
		$empfaenger = htmlentities($empfaenger);
		$betrag     = htmlentities($betrag);
		$verwend    = htmlentities($verwend);
		
		$empfaenger = mysql_real_escape_string($empfaenger);
		$betrag     = mysql_real_escape_string($betrag);
		$verwend    = mysql_real_escape_string($verwend);
		
		// Prüfen ob der verwendungszwweck nicht mehr als 20 Zeichen befasst.
		if(strlen($verwend) > 20)
		{
			$meldung = "Sorry Verwendungszweck ist zu lang";
		}
		else
		{
			// Prüfen ob der Konto genug geld hat.
			$sql = ("SELECT kapital FROM konto WHERE kto_nr='$konto'");
			$result = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$guthaben = $row['kapital'];
			echo "Guthaben: $guthaben<br>Bezahlen: $betrag<br>";
			if($guthaben < $betrag)
			{
				$meldung = "Sorry du hast nicht genug Geld";
			}
			else
			{
				// Prüfen ob der Empfaenger excisitiert
			}
		}
	}
	?>
    <font color="red"><?=$meldung;?></font>
	<form action=main.php?target=bank&maction=ueberweisung&id=<?=$konto;?>&test method=post>
		<table>
        	<tr>
            	<td>Target Konto</td>
                <td>:</td>
                <td><input type="text" name="emp" /></td>
            </tr>
      		<tr>
            	<td>Betrag</td>
                <td>:</td>
                <td><input type="text" name="betrag" /></td>      
            </tr>
            <tr>
            	<td>Verwendungzweck</td>
                <td>:</td>
                <td><input type="text" name="verwend" maxlength="20" /> Max 20 Zeichen</td>
            </tr>
        </table>
        <input type="submit" value="&Uuml;berweisen" /><br />
        <input type="reset" value="Vergessen" />
    </form> 
    <?php
}

if(!isset($action))
{
	$sql = ("SELECT * FROM konto WHERE eigentum_id='$userid'");
	$result = mysql_query($sql) or die(mysql_error());
	$anzahl = mysql_num_rows($result);
	echo "Du hast $anzahl Bankkontos";
	if($anzahl > 0)
	{
		echo "<table><tr><td>Konto Nummer</td><td>Bei</td><td>Kapital</td></tr>";
		while($row = mysql_fetch_array($result))
		{
			$kto_nr  = $row['kto_nr'];
			$kapital = $row['kapital'];
			
			//Feststellen bei welche Bank diese Konto ist
			$sql1 = ("SELECT bankid FROM rechnung WHERE kto_nr='$kto_nr'");
			$result1 = mysql_query($sql1) or die(mysql_error());
			$row1 = mysql_fetch_array($result1);
			$bankid = $row1['bankid'];
			
			// Nun haben wir den Bankid, wolln aber n name haben
			$sql2 = ("SELECT name FROM bank WHERE id='$bankid'");
			$result2 = mysql_query($sql2) or die(mysql_error());
			$row2 = mysql_fetch_array($result2);
			$bankname = $row2['name'];
			
			echo "<tr>
				<td><a href='main.php?target=bank&maction=kontoinfo&id=$kto_nr'>$kto_nr</a></td>
				<td><a href='main.php?target=bank&maction=bankinfo&id=$bankid'>$bankname</a></td>
				<td>$kapital</td></tr>";
		}
		echo "</table>";
	}
	
}
?>
