<h2>Passwort Vergessen</h2>

<?php
$err = false;
if(isset($_GET['action'])) {
	$action = $_GET['action'];
}
else if(isset($_POST["action"])) {
	$action = $_POST["action"];
}
else
{
	$action = "main";
}

if($action == "main")
{
?>
<form action='main.php' method=post>
Username oder email: <input type='text' name='passormail'>
<br><br>
<input type='submit' value='Senden'>
<input type='hidden' name='action' value='send'>
<input type='hidden' name='target' value='pwf'>
</form>
<?php
}

if($action == "send")
{
	$target = $_POST['passormail'];

	if(!$target)
	{
		echo "Keine daten eingef&#252;llt<br>\n";
		echo "Go back\n";
		$err = true;
	}
	

	$sql = ("SELECT * FROM users WHERE name='".mysql_real_escape_string($target)."'OR email='".mysql_real_escape_string($target)."'");
	if(!$err)
	{
		$result = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($result)<=0) {
			echo "user oder mailadresse wurde nicht gefunden<br>\n";
		}
		else {
			$row=mysql_fetch_array($result);
			$name  = $row['name'];
			$email = $row['email'];
			$key = rand(1,1000);
			$pass = md5($key);
			
			$sql = ("UPDATE users SET passwort = '$pass' WHERE name= '$name'");
			mysql_query($sql) or die(mysql_error());
				
			$result = mail($email, "SpaceQuetser Passwort aenderung","Ihre neue Passwort lautet: $key \r\nbitte aendern Sie es schnellst moeglich um.","FROM: spacequester@fkrauthan.de");
			if($result == 0)
			{
				echo "<br>Fehler beim senden der email<br>\n";
				echo "Kontaktieren Sie ein Admin<br>\n";
				echo "<b>Errorlog erstellt</b><br>\n";
				$skript = $_SERVER["PHP_SELF"];
				$status = "critical";
				$text = "Ein User hat keine passwort email bekommen.\n";
				$sql = ("INSERT INTO error (datum, path, status, user, ip, was) VALUES ('$regi_dat','$skript','$status','$name','$ip','$text')");
				mysql_query($sql) or die(mysql_error());
			}
			else
			{
				echo "<br>Email versendet<br>\n";
			}
		}
	}
}

?>