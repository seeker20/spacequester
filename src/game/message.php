<table border='0' width='97%' style="height: 97%">
	<tr>
		<td width='50%'>
			<div id='abgerundedeecken3' align='center'>
				<?php
				$whoami = $_SESSION["user"];
if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	echo "<h3>Message</h3>";
	echo "<p>W&auml;hlen sie einfach eine Funktion. Hier k&ouml;nnen sie Messages schreiben Ihre Messages lesen";
	echo " Bitte beachten sie das es nicht gestatet ist ilegale aktivit&auml;ten zu Planen";
	echo " Mit der benutztung dieses Sytsemes stimmen Sie automatisch zu das sie die verantwortung";
	echo " f&uuml;r die anchrichten &Uuml;bernhemen.</p>";
	echo "<img src=../daten/bilder/server.png width=100 height=100>";
}
if($action == "wichtig")
{
// 	$titel  = $_GET['titel'];
	$id     = $_GET['id'];
	$target = $_GET['ziel'];

	$sql = ("SELECT * FROM wichtige_nachrichten WHERE id='".mysql_real_escape_string($id)."' AND target= '".mysql_real_escape_string($target)."'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$titel  = $row['titel'];
	$target = $row['target'];
	$id     = $row['id'];
	$von    = $row['von'];
	$text   = $row['text'];
	$datum  = $row['datum'];

	echo "Email von <b>$von</b> wurde gesendet um $datum<br>\n";
	echo "Betref: $titel<br>\n";
	echo "<hr>$text<br><br>\n";
}

if($action == "eingang")
{
	$sql = ("SELECT * FROM mail WHERE empfaenger= '$whoami' AND status != 'papierkorb' AND status != 'geloescht'");
	$result = mysql_query($sql) or die(mysql_error());
	$anz = mysql_num_rows($result);
	echo "<h3>Posteingang</h3>";
	echo "Sie haben $anz Nachrichten<br>\n";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0' width='95%'>\n";
	echo " <tr>\n";
	echo "  <td class='hsmallborder'>Titel</td>\n";
	echo "  <td class='hsmallborder'>Absender</td>\n";
	echo "  <td class='hsmallborder'>Status</td>\n";
	echo "  <td class='hsmallborder'>Aktion</td>\n";
	echo " </tr>\n";
	while($row=mysql_fetch_array($result))
	{
		$id       = $row['id'];
		$status   = $row['status'];
		$titel    = $row['titel'];
		$text     = $row['text'];
		$datum    = $row['datum'];
		$absender = $row['absender'];

		echo "<tr>\n";
		echo " <td class='hsmallborder'><a href=main.php?target=message&action=read&id=$id>$titel</a></td>\n";
		echo " <td class='hsmallborder'>$absender</td>\n";
		echo " <td class='hsmallborder'>$status</td>\n";
		echo "<td class='hsmallborder'><a href=main.php?target=message&action=read&id=$id>Lesen</a></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}

if($action == "papkorb")
{
	$sql = ("SELECT * FROM mail WHERE empfaenger= '$whoami' AND status= 'papierkorb' AND status != 'geloescht'");
	$result = mysql_query($sql) or die(mysql_error());
	echo "<h3>Paperkorb</h3>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0'>\n";
	echo " <tr>\n";
	echo "  <td class='hsmallborder'>titel</td>\n";
	echo "  <td class='hsmallborder'>absender</td>\n";
	echo "  <td class='hsmallborder'>datum</td>\n";
	echo "  <td class='hsmallborder'>Aktionen</td>\n";
	echo " </tr>\n";
	while($row=mysql_fetch_array($result))
	{
		$id       = $row['id'];
		$titel    = $row['titel'];
		$absender = $row['absender'];
		$datum    = $row['datum'];

		echo " <tr>\n";
		echo "  <td class='hsmallborder'>$titel</td>\n";
		echo "  <td class='hsmallborder'>$absender</td>\n";
		echo "  <td class='hsmallborder'>$datum</td>\n";
		echo "  <td class='hsmallborder'>\n";
		echo "<a href=main.php?target=message&action=mail_aktionen&do=3&id=$id>Email l&#246;schen</a><br>\n";
		echo "<a href=main.php?target=message&action=mail_aktionen&do=1&id=$id>Email wiederherstellen</a>\n";
		echo "  </td>\n";
		echo " </tr>\n";
	}
	echo "</table>\n";
}

if($action == "read")
{
	$id    = $_GET['id'];
	
	$sql = ("SELECT * FROM mail WHERE id='".mysql_real_escape_string($id)."' AND empfaenger ='$whoami' AND status != 'geloescht'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$anz = mysql_num_rows($result);

	$id       = $row['id'];
	$titel    = $row['titel'];
	$text     = $row['text'];
	$status   = $row['status'];
	$datum    = $row['datum'];
	$absender = $row['absender'];

	$sql = ("UPDATE mail SET status= 'gelesen' WHERE id= '".mysql_real_escape_string($id)."' AND empfaenger= '$whoami'");
	mysql_query($sql) or die(mysql_error());

	echo "Email von <b>$absender</b> wurde gesendet um $datum<br>\n";
	echo "Betref: $titel<br>\n";
	echo "Status: <b>$status</b><br>\n";
	echo "<hr>$text<br><hr>Aktionen:<br>\n";

	echo '<div id="navcontainer">';
	echo '<ul id="navlist">';
	if($status == 'gelesen')
	{
		echo "<li><a href=main.php?target=message&action=mail_aktionen&do=4&id=$id>Als Neu Makieren</a>\n";
	}
	else
	{
		echo "<li><a href=main.php?target=message&action=mail_aktionen&do=1&id=$id>Als Gelesen Makieren</a></li>\n";
	}
	echo "<li><a href=main.php?target=message&action=mail_aktionen&do=2&id=$id>Mail ins M&#252;ll schmeisen</a></li><li><a href=main.php?target=message&action=mail_aktionen&do=3&id=$id>Mail l&#246;schen</a></li>\n";
	echo "</ul>\n";
	echo "</div>\n";
	echo "<hr>\n";
}

if($action == "mail_aktionen")
{
	$id    = $_GET['id'];
// 	$titel = $_GET['titel'];
	$do    = $_GET['do'];

	

	if($do == "1")
	{
		/// Mail als gelesen Makieren
		$sql = ("UPDATE mail SET status= 'gelesen' WHERE id= '".mysql_real_escape_string($id)."' AND empfaenger= '$whoami'");
		mysql_query($sql) or die(mysql_error());
		echo "<br>Mail erfolgreich als <b>Gelesen</b> Makiert\n";
		
	}
	elseif($do == "2")
	{
		/// Mail Ins Papierkorb tun
		$sql = ("UPDATE mail SET status= 'papierkorb' WHERE id= '".mysql_real_escape_string($id)."' AND empfaenger= '$whoami'");
		mysql_query($sql) or die(mysql_error());
		echo "<br>Mail erfolgreich ins <b>Papierkorb</b> geschmissen\n";
		
	}
	elseif($do == "3")
	{
		/// Mail löschen
		$sql = ("UPDATE mail SET status= 'geloescht' WHERE id= '".mysql_real_escape_string($id)."' AND empfaenger= '$whoami'");
		mysql_query($sql) or die(mysql_error());
		echo "<br>Mail wurde erfolgreich <b>vernichtet</b>\n";
		
	}
	elseif($do == "4")
	{
		/// Mail als Neu makieren
		$sql = ("UPDATE mail SET status= 'neu' WHERE id= '".mysql_real_escape_string($id)."' AND empfaenger= '$whoami'");
		mysql_query($sql) or die(mysql_error());
		echo "<br>Mail wurde erfolgreich als <b>Neu</b> makiert<br>\n";
		
	}
	else
	{
		echo "Sorry, aber ich kenn diesen funktion leider nicht :)\n";
	}
}

if($action == "ausgang")
{
	$sql = ("SELECT * FROM mail WHERE absender= '$whoami' AND owner != 'geloescht'");
	$result = mysql_query($sql) or die(mysql_error());
	echo "<h3>Postausgang</h3>";
	echo "<table border='0' class='smallborder' cellspacing='0' cellpadding='0'>\n";
	echo " <tr>\n";
	echo "  <td class='hsmallborder'>Empf&#228;nger</td>\n";
	echo "  <td class='hsmallborder'>Titel</td>\n";
	echo "  <td class='hsmallborder'>Datum</td>\n";
	echo "  <td class='hsmallborder'>Aktionen</td>\n";
	echo " </tr>\n";
	while($row = mysql_fetch_array($result))
	{
		$id         = $row['id'];
		$titel      = $row['titel'];
		$datum      = $row['datum'];
		$empfaenger = $row['empfaenger'];

		echo " <tr>\n";
		echo "  <td class='hsmallborder'>$empfaenger</td>\n";
		echo "  <td class='hsmallborder'>$titel</td>\n";
		echo "  <td class='hsmallborder'>$datum</td>\n";
		echo "  <td class='hsmallborder'>\n";
		echo "<a href=main.php?target=message&action=owner_kommands&id=$id&do=1>Email l&#246;schen</a><br>\n";
		echo "<a href=main.php?target=message&action=owner_kommands&id=$id&do=2>Email bearbeiten</a>\n";
		echo "  </td>\n";
		echo " </tr>\n";
	}
	echo "</table>\n";
}

if($action == "owner_kommands")
{
	$do    = $_GET['do'];
// 	$titel = $_GET['titel'];
	$id    = $_GET['id'];

	if($do == "1")
	{
		$sql = ("UPDATE mail SET owner= 'geloescht' WHERE id= '".mysql_real_escape_string($id)."' AND absender= '$whoami'");
		mysql_query($sql) or die(mysql_error());
		echo "Email wurde erfolgreich vernichtet<br>\n";
		
	}
	elseif($do == "2")
	{
		$sql = ("SELECT * FROM mail WHERE owner != 'geloescht' AND id= '".mysql_real_escape_string($id)."' AND absender= '$whoami'");
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);

		$text       = $row['text'];
		$empfaenger = $row['empfaenger'];

		?>
			<form action=main.php?target=message&action=write_mail method=post>
			<table>
				<tr>
					<td>Empf&#228;nger</td>
					<td>:</td>
					<td><input type=text name=empfaenger  style="border: 0px;" value=<?php echo $empfaenger; ?>></td>
				</tr>

				<tr>
					<td>Betref</td>
					<td>:</td>
					<td><input type=text name=betref style="border: 0px;"  value=<?php echo $titel; ?>></td>
				</tr>

				<tr>
					<td>Text</td>
					<td>:</td>
					<td><textarea name=inhalt cols=25 rows=18 style="border: 0px;"><?php echo $text; ?></textarea></td>
				</tr>
			</table>
			<input type=submit value=Schicken>
			</form>
		<?php
		
	}
}

if($action == "write")
{
	?>
	<br>
	<form action=main.php?target=message&action=write_mail method=post>
	<table>
		<tr>
			<td>Empf&#228;nger</td>
			<td>:</td>
			<td><input type=text name=empfaenger style="border: 0px;"></td>
		</tr>

		<tr>
			<td>Betref</td>
			<td>:</td>
			<td><input type=text name=betref  style="border: 0px;"></td>
		</tr>

		<tr>
			<td>Text</td>
			<td>:</td>
			<td><textarea name=inhalt cols=25 rows=18  style="border: 0px;"></textarea></td>
		</tr>
	</table>
	<input type=submit value=Schicken>
	</form>
	<?php
}

if($action == "write_mail")
{
	$err = false;
	$empfaenger = htmlentities($_POST['empfaenger']);
	$betref     = htmlentities($_POST['betref']);
	$text       = htmlentities($_POST['inhalt']);
	$datum      = date("d.m.Y");

	if(!$whoami)
	{
		echo "<br>Fehler - Bitte Loggen Sie sich erneut ein<br>\n";
		$err = true;
	}

	if(!$empfaenger || !$betref || !$text)
	{
		echo "<br>Sie haben nicht alle Felder ausgef&#252;llt<br>\n";
		$err = true;
	}
	
	$sqlab = "select * from mail where absender='" .mysql_real_escape_string($whoami) . "' and empfaenger='" . mysql_real_escape_string($empfaenger) . "' and titel='" . mysql_real_escape_string($betref) . "' and text='" . mysql_real_escape_string($text) . "'";
	$res   = mysql_query($sqlab);
	if(mysql_num_rows($res) > 0) {
		echo "Reload Sperre<br><br>\n";
		$err = true;
	}

	if(!$err)
	{
		$sqlab = "select * from users where name='" . mysql_real_escape_string($empfaenger) . "'";
		$res    = mysql_query($sqlab);
		if(mysql_num_rows($res)<= 0) {
			echo "User existiert nicht<br><br>\n";
			$err = true;
		}
	}

	if(!$err)
	{
		$sql = ("INSERT INTO mail (absender, empfaenger, datum, status, owner, titel, text) VALUES ('".mysql_real_escape_string($whoami)."','".mysql_real_escape_string($empfaenger)."','$datum','neu','ausgang','".mysql_real_escape_string($betref)."','".mysql_real_escape_string($text)."')");
		mysql_query($sql) or die(mysql_error());
		echo "Email gesendet\n";
	}
}
				?>
				<br><br>
<!-- 				<img src=../daten/bilder/server.png width=100 height=100> -->
			</div>

			<br>

			<div id='abgerundedeecken4' align='center'>
			<?php
				$sql = ("SELECT * FROM wichtige_nachrichten WHERE target='alianz' OR target='all'");
				$result = mysql_query($sql) or die(mysql_error());
				$anzahl = mysql_num_rows($result);
				echo "Im wichtige Nachrichten System befinden sich $anzahl nachrichten<br>\n";
				echo "<table>\n";
				while($row=mysql_fetch_array($result))
				{
					$titel  = $row['titel'];
					$target = $row['target'];
					$id     = $row['id'];
					$von    = $row['von'];
					$text   = $row['text'];
					$datum  = $row['datum'];
					echo "<tr>\n";
					echo "<td>$datum</td>\n";
					echo "<td>$target</td>\n";
					echo "<td>$titel</td>\n";
					echo "<td><a href=main.php?target=message&action=wichtig&id=$id&ziel=$target>Lesen</a></td>\n";
					echo "</tr>\n";
// 					echo "$datum | $target | $titel <a href=main.php?target=message&action=wichtig&titel=$titel&id=$id>Lesen</a><br>\n";
				}
				echo "</table>\n";
			?>
			</div>

		</td>
		<td>
			<div id='abgerundedeecken5' align='center'>
			<?php		
				$sql = ("SELECT * FROM mail WHERE empfaenger= '$whoami' AND status= 'papierkorb'");
				$result = mysql_query($sql) or die(mysql_error());
				$pappierkorb = mysql_num_rows($result);

				$sql = ("SELECT * FROM mail WHERE empfaenger= '$whoami' AND status= 'neu'");
				$result = mysql_query($sql) or die(mysql_error());
				$neu    = mysql_num_rows($result);

				echo '<div id="navcontainer">';
					echo '<ul id="navlist">';
						echo '<li><a href=main.php?target=message&action=eingang>Zum Posteingang gehen (' . $neu . ')</a></li>';
						echo '<li><a href=main.php?target=message&action=ausgang>Zum Postausgang gehen</a></li>';
						echo '<li><a href=main.php?target=message&action=papkorb>Zum Papierkorb gehen (' . $pappierkorb . ')</a></li>';
						echo '<li><a href=main.php?target=message&action=write>Eine Nachricht verfassen</a></li>';
					echo '</ul>';
				echo '</div>';
			?>
			</div>
			

</table>