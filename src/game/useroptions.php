<h3>Einstellungen</h3>

<?php

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "main";
}


$username = $_SESSION["user"];
$sql = ("SELECT * FROM users WHERE name= '$username'");
$result = mysql_query($sql) or die(mysql_error());

$row = mysql_fetch_array($result);
$email = $row['email'];

echo "Hallo ".htmlentities($username).", Sie sind im Zentrale wo Sie ihre Pers&#246;nliche daten k&#246;nnen<br><br>\n";

if($action == "main")
{
	echo '<div id="navcontainer" style="width: 250px">';
	echo '<ul id="navlist">';
	echo "<li><a href=main.php?target=useroptions&action=style>Style &auml;ndern</a></li>\n";
	echo "<li><a href=main.php?target=useroptions&action=email>Email adresse &auml;ndern</a></li>\n";
	echo "<li><a href=main.php?target=useroptions&action=passwort>Passwort &auml;ndern</a></li>\n";
	echo '</ul>';
	echo '</div>';
}

if($action == "style")
{
	if(isset($_GET['exec']))
	{
		$style = mysql_real_escape_string($_POST['style']);
		$sql = ("UPDATE users SET style='$style'");
		mysql_query($sql) or die(mysql_error());
		echo "Style erfolgreich ge&auml;ndert<br>";
		echo "Um den Style sofort zu activieren, klicken Sie bitte <a href=main.php?newstyle=$style>Hier</a><br>";

	}
	echo "
		<form action=main.php?target=useroptions&action=style&exec method=post>
		<p>Hier kannst du dein Style &auml;ndern</p>
		<select name=style>
			<option>default</option>
			<option>damian</option>
		</select>
		<input type=submit value=\"Style &auml;ndern\">	
	";	
}

if($action == "email")
{
	?>
		<form action='main.php?target=useroptions&action=save_email' method=post>
		<table>
			<tr>
				<td>Email Adresse:</td>
				<td><input type=text name=email1 value=<?php echo $email; ?>></td>
			</tr>
			<tr>
				<td>Email Adresse:</td>
				<td><input type=text name=email2 value=<?php echo $email; ?>></td>
			</tr>
		</table>
		
		<!--<input type='hidden' name='target' value='useroptions'>
		<input type='hidden' name='action' value='save_email'>-->
		<input type=submit value="Profil &#228;ndern">
		</form>
		<p><a href='main.php?target=useroptions'>Zur&uuml;ck</a></p>
	<?php
}

if($action == "passwort")
{
	?>
		<form action='main.php?target=useroptions&action=save_passwort' method=post>
		<table>
			<tr>
				<td>Passwort:</td>
				<td><input type=password name=pas1></td>
			</tr>
			<tr>
				<td>Passwort wiederholen:</td>
				<td><input type=password name=pas2></td>
			</tr>
		</table>
		<!--<input type='hidden' name='target' value='useroptions'>
		<input type='hidden' name='action' value='save_passwort'>-->
		<input type=submit value="Profil &#228;ndern">
		</form>
		<p><a href='main.php?target=useroptions'>Zur&uuml;ck</a></p>
	<?php
}

if($action == "save_passwort")
{
	$err = false;
	$pass1    = $_POST['pas1'];
	$pass2    = $_POST['pas2'];

	
	if($pass1 != $pass2)
	{
		echo "<br>Die beide Passw&#246;rter stimmen <b>nicht</b> überein\n";
		$err = true;
	}
	else
	{
		$passwort = md5($pass1);
		$sql = ("UPDATE users SET passwort= '$passwort' WHERE name='$username'");
		mysql_query($sql) or die(mysql_error());
	}
	

	if(!$err)
	{
		echo "<br>Daten erfolgreich geupdatet!\n";
	}
	
}


if($action == "save_email")
{
	$err = false;
	$email1    = $_POST['email1'];
	$email2    = $_POST['email2'];

	
	if($email1 != $email)
	{
		if($email1 != $email2)
		{
			echo "<br>Die beide Emails stimmen <b>nicht</b> &#252;berein\n";
			$err = true;
		}
		else
		{
			$email1 = mysql_real_escape_string($email);
			$email1 = htmlentities($email1);
			$sql = ("UPDATE users SET email= '$email1' WHERE name='$username'");
			mysql_query($sql) or die(mysql_error());
		}
	}

	if(!$err)
	{
		echo "<br>Daten erfolgreich geupdatet!\n";
	}
	
}
?>
