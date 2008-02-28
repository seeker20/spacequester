<?php

$sql = ("SELECT * FROM users");
$result = mysql_query($sql) or die(mysql_error());
$all_ready = mysql_num_rows($result);


if ($all_ready >= $user_max_regist)
{
	echo "Sorry, Sie k&ouml;nnen sich nicht Registrieren, denn das System l&auml;sst kein weitere Usern mehr an.\n";
}
else {

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else if(isset($_POST['action'])) {
	$action = $_POST['action'];
}
else
{
	$action = "main";
}

if($action == "aktive")
{
	include "../global/mysql_connect.php";
	
	echo "<html>";
	echo "<head>";
	echo "<title>SpaceQuester Freischaltung</title>";
	echo "</head>";
	echo "<body>";
	echo "<h1>Freischaltung ihres Accounts</h1>";
	
	$target = mysql_real_escape_string($_GET['email']);
	$code   = mysql_real_escape_string($_GET['code']);
	
	$sqlab = "select * from users where email='" . $target . "' and link='" . $code . "'";
	$res   = mysql_query($sqlab);
	if(mysql_num_rows($res)<=0) {
		echo "<p>Der Angegbene Code stimmt entweder nicht berein oder konnte keinem User zugeordnet werden.</p>";
	}
	else {
		$sqlab = "update users set link='' where email='" . $target . "'";
		mysql_query($sqlab);
		echo "<p>Sie sind nun freigeschalten sie mssten sich jetzt mit ihren daten anmelden knnen.</p>";
	}
	
	echo "<p><a href='../index.php'>Zur&#252;ck zum Spiel</a></p>";
	
	echo "</body>";
	echo "</html>";
}
else {
	echo "<h2>Registrierung</h2>";
}

if($action == "registrierung")
{
	$name      	= $_POST['name'];
	$email1    	= $_POST['email1'];
	$email2    	= $_POST['email2'];
	$passwort1 	= $_POST['passwort1'];
	$passwort2 	= $_POST['passwort2'];
	
	$err				= false;

	if(!$name || !$email1 || !$email2 || !$passwort1 || !$passwort2)
	{
		echo "Sie haben nicht alle Felder ausgefllt<br>\n";

		if(!$name)
		{
			echo "<b>Name fehlt</b><br>\n";
		}

		if(!$email1)
		{
			echo "<b>Email fehlt</b><br>\n";
		}

		if(!$email2)
		{
			echo "<b>Email best&#228;igung fehlt</b><br>\n";
		}

		if(!$passwort1)
		{
			echo "<b>Passwort fehlt</b><br>\n";
		}

		if(!$passwort2)
		{
			echo "<b>Passwort best&#228;igung fehlt</b><br>\n";
		}

		echo "Bitte f&#252;llen Sie die oben genannten Felder aus\n";
		
		$err=true;
	}

	if($email1 != $email2)
	{
		echo "Die beiden email adressen stimmen <b>nicht</b> &#252;berein<br>\n";
		$err=true;
	}

	if($passwort1 != $passwort2)
	{
		echo "Die beiden passw&#246;tern stimmen <b>nicht</b> &#252;berein<br>\n";
		$err=true;
	}

	$passwort = md5($passwort1);
	$email    = $email1;
	$regi_dat = date("d.m.Y");
	$ip       = $_SERVER['REMOTE_ADDR'];

	/// Ist zur Debuggen gedacht
// 	echo "$name $email $regi_dat $ip";

	$sql_is_register	= ("select * from users where name='$name' and passwort='$passwort' and email='$email'");
	$sql_is_username	= ("select * from users where name='$name'");
	$sql_is_useremail	= ("select * from users where email='$email'");
	
	if(mysql_num_rows(mysql_query($sql_is_register)) > 0) {
		echo "Es wurde bereits ein User mit diesen Daten registiert";
		$err=true;
	}
	
	if(mysql_num_rows(mysql_query($sql_is_username)) > 0) {
		echo "Es gibt bereits einen User mit diesem Namen";
		$err=true;
	}
	
	if(mysql_num_rows(mysql_query($sql_is_useremail)) > 0) {
		echo "Es gibt bereits einen user mit dieser Mail adresse";
		$err=true;
	}
	
	if(!$err) {
		$link = generate_code($name);
		
		$sql_register 		= ("INSERT INTO users (name,passwort,email,regdate,lastip,link) VALUES ('$name','$passwort','$email','$regi_dat','$ip','$link')");
		
		$text 	= "Wilkommen bei SpaceQuester,\r\n";
		$text .= "Sie müssen nur noch auf den Volgenden link klicken und können dann sofort in ein\r\n";
		$text .= "intergalaktisches Abenteuer starten und Geschichte umschreiben. Einfach auf volgenden\r\n";
		$text .= "link klicken und loslegen\r\n";
		$text .= "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . "?target=registrierung&action=aktive&email=$email&code=$link\r\n\r\n";
		$text .= "Viel Spaß in SpaceQuester wünscht ihnen ihr Admin Team";
		
		$result_mail = mail($email,"Registrierung bei SpaceQuester",$text,"FROM: spacequester@fkrauthan.de");
		if($result_mail == 0)
		{
			echo "<br>Fehler beim senden der email<br>\n";
			echo "Kontaktieren Sie ein Admin<br>\n";
			echo "<b>Errorlog erstellt</b><br>\n";
			$skript = $_SERVER["PHP_SELF"];
			$status = "critical";
			$text = "Ein User hat keine email bekommen.\n";
			$sql = ("INSERT INTO error (datum, path, status, user, ip, was) VALUES ('$regi_dat','$skript','$status','$name','$ip','$text')");
			mysql_query($sql) or die(mysql_error());
		}
		else
		{
			echo "<br>Email versendet<br>\n";
		}
		mysql_query($sql_register) or die(mysql_error());
	}
}

if($action == "main")
{
	?>
		<p>Bitte f&#252;llen sie alle Felder aus.</p>
		<form action='main.php' method='post'>
		<table>
			<tr>
				<td>Name:</td>
				<td><input type='text' name='name'></td>
			</tr>

			<tr>
				<td>Email:</td>
				<td><input type='text' name='email1'></td>
			</tr>

			<tr>
				<td>Email (wiederholen):</td>
				<td><input type='text' name='email2'></td>
			</tr>

			<tr>
				<td>Passwort:</td>
				<td><input type='password' name='passwort1'></td>
			</tr>

			<tr>
				<td>Passwort (wiederholen):</td>
				<td><input type='password' name='passwort2'></td>
			</tr>
		</table>
		<input type='hidden' name='target' value='registrierung'>
		<input type='hidden' name='action' value='registrierung'>
		<input type='submit' value='Registrieren'>
		</form>
	<?php
}
}
?>

