<?php
session_start();
if($_SESSION["status"] != "Admin")
{
	die("Kein Zugriff!!!!!!");
}
require ("../../global/mysql_connect.php");

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "scan";
}

if($action == "scan")
{
$sql = ('
SELECT users1.lastip AS lastip,
COUNT("users1.lastip") AS anzahl 
FROM users AS users1, users AS users2 
WHERE users1.lastip = users2.lastip AND
      users1.lastlogin = users2.lastlogin 
GROUP BY users1.lastip');
$result = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_assoc($result))
{
	echo "<form action=clone.php?action=exe method=post>\n";
	if($row['anzahl'] > 1)
	{
		$result = mysql_query('SELECT * from users WHERE lastip= "'.$row['lastip'].'" AND lastlogin= "'.$row['lastlogin'].'"') or die(mysql_error());
		while($mrow = mysql_fetch_array($result))
		{
			echo "<table border=0>\n";
			echo "<tr>\n";
			echo "<td>Parameter</td>\n";
			echo "<td>Wert</td>\n";
			echo "</tr>\n";

			$id    = $mrow['id'];
			$name  = $mrow['name'];
			$email = $mrow['email'];
			$ip    = $mrow['lastip'];
			$reg   = $mrow['regdate'];
			$ll    = $mrow['lastlogin'];

			echo "<tr>\n";
			echo "<td>Id:</td>\n";
			echo "<td>$id</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Name:</td>\n";
			echo "<td>$name</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>E-mail:</td>\n";
			echo "<td>$email</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>IP:</td>\n";
			echo "<td>$ip</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Lastlogin:</td>\n";
			echo "<td>$ll</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Account wegen \"Multi\" Sperren</td>\n";
			echo "<td><input type=checkbox name=sperr value=$name></td>\n";
			echo "</td>\n";
			echo "</table>\n";
			echo "<br><br>\n";
		}
	}
	echo "<input type=submit value=Execute>\n";
}
}

if($action == "exe")
{
	echo $_POST['sperr'];
}
?>