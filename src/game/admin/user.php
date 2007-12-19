<?php
if(!defined("ADMIN"))
{
	die("
		<h1>ACCESS DENIED</h1>
		<p>Du bist nicht berrechtigt dich hier aufzuhalten</p>
	");
}
?>
<h4>User-Verwaltung</h4>
<hr>

<?php
if($actionid == 1)
{
	$sql = ("SELECT id,name,status FROM users ORDER BY status DESC");
	$result = mysql_query($sql) or die(mysql_error());
	$anzahl = mysql_num_rows($result);
	echo "Das System hat: $anzahl Registrierte Spieler";
	echo "<table><tr><td>ID</td><td>Nick</td><td>Status</td></tr>";
	while($row = mysql_fetch_array($result))
	{
		$userid   = $row['id'];
		$username = $row['name'];
		$userstat = $row['status'];
		echo "<tr>
				<td><a href=main.php?target=admin&mtarget=user&id=2&userid=$userid>$userid</a></td>
				<td><a href=main.php?target=admin&mtarget=user&id=2&userid=$userid>$username</a></td>
				<td>$userstat</td>
		</tr>";
	}
	echo "</table>";
}

if($actionid == 2)
{
	if($_GET['userid'])
	{
		$userid = $_REQUEST['userid'];
		echo "<a href=main.php?target=admin&mtarget=user&id=2>Zur&uuml;ck</a>";
	}
	elseif($_GET['exec'])
	{
		$username = mysql_real_escape_string($_POST['username']);
		$sql = ("SELECT id FROM users WHERE name='$username'");
		$result = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows <= 0)
		{
			echo "Die Benutzer ".htmlentities($username)." gibt es leider nicht in der DB";
			echo "<a href=main.php?target=admin&mtarget=user&id=2>Zur&uuml;ck</a>";
			exit();
		}
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
	}
	if(isset($_GET['userid']) || isset($_GET['exec']))
	{
		$sql = ("SELECT * FROM users WHERE id='$userid'");
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
				
	}
	else
	{
		?>
			<form action=main.php?target=admin&mtarget=user&id=2&exec method=post>
			<table>
				<tr>
					<td>Nickname:</td>
					<td><input type=text name=username></td>
				</tr>
			</table>
			<input type=submit>
		<?php
	}
}
?>