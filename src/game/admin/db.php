<?php
if(!defined("ADMIN"))
{
	die("
		<h1>ACCESS DENIED</h1>
		<p>Du bist nicht berrechtigt dich hier aufzuhalten</p>
	");
}
?>
<h4>Datenbank Verwaltung</h4>

<?php

if($actionid == 1)
{
	// Datenbank resetten /* Truncate */
	if(isset($_GET['yes']))
	{
		echo "<font color=green>Tabellen werden geleert</font><br>";
		$sql = ("TRUNCATE alianzen;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE allyraenge;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE bewerbungen;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE bugs;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE error;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE mail;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE news;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE rundmails;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE schiffe;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE schiffs_auftraege;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE station;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE users;");
		mysql_query($sql) or die(mysql_error());
		$sql = ("TRUNCATE wichtige_nachrichten;");
		mysql_query($sql) or die(mysql_error());
		echo "<font color=green>Alle Tabellen geleert</font>";
		$date = date("d.m.Y");
		echo "<br><font color=green>User Damian wird angelegt</font>";
		$passwort = md5("bodde05");
		$sql = ("INSERT INTO users (name,passwort,email,regdate,status) VALUES
					('Damian','$passwort','damian@localhost','$date','Admin')");
		mysql_query($sql) or die(mysql_error());
		echo "<br><font color=green>User Damian mit Adminrechte wurde erfolgreich angelegt</font>";
		if($_SESSION["JavaScript"]==true) {
			echo '<script language="JavaScript">location.href="main.php?target=logout";';
			echo '<' . "/" . 'script>';
		}
		
	}
	else
	{
		echo "Wollen Sie wirklich alle Tabellen Resetten?<br>";
		echo "<a href=main.php?target=admin&mtarget=db&id=1&yes><font color=red>Ja</font></a><br>
";
		echo "<a href=main.php?target=admin&mtarget=db><font color=green>Nein</font></a>";
	}
}

if($actionid == 2)
{
	// Datenbank optimieren
}