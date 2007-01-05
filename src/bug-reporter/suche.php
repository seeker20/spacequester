<?php

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "main";
}

if($action == "main")
{
	?>
	<form action=main.php?target=suche&action=such method=post>
	<input type=text name=begriff>
	<input type=submit value=suche>
	</form>
	<?php
}

if($action == "such")
{
	$err = false;
	$target = $_POST['begriff'];
	if(!$target)
	{
		echo "So kann ich nix finden ;-)\n";
	}
	$sql = ("SELECT * FROM bugs WHERE (beschreibung LIKE '%".mysql_real_escape_string($target)."%') OR (Owner LIKE '%".mysql_real_escape_string($target)."%')");
	if(!$err)
	{
		$result = mysql_query($sql) or die(mysql_error());
		$anzahl = mysql_num_rows($result);
		echo "Gefunden: $anzahl\n";
		echo "<table>\n";
		while($row=mysql_fetch_array($result))
		{
			$owner        = $row['owner'];
			$url          = $row['url'];
			$beschreibung = $row['beschreibung'];
			$status       = $row['status'];
			$kommentar    = $row['kommentar'];
			$datum        = $row['datum'];
	
			?>
				<tr>
					<td>Datum</td>
					<td><?php echo $datum; ?></td>
				</tr>
	
				<tr>
					<td>Geschrieben von:</td>
					<td><?php echo $owner; ?></td>
				</tr>
	
				<tr>
					<td>Status:</td>
					<td><?php echo $status; ?></td>
				</tr>

				<tr>
					<td>Url:</td>
					<td><?php echo $url; ?></td>
				</tr>

				<tr>
					<td>Beschreibung:</td>
					<td><?php echo $beschreibung; ?></td>
				</tr>

				<tr>
					<td>Kommentar:</td>
					<td><?php echo $kommentar; ?></td>
				</tr>
			<?php
		}
		echo "</table>\n";
	}
}

?>