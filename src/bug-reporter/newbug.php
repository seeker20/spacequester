<?php

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "main";
}
$err = false;

if($action == "main")
{
?>
<form action=main.php?target=newbug&action=save_bug method=post>
<table>
	<tr>
		<td>Ihre Name</td>
		<td><input type=text name=name style="border:0px;"></td>
	</tr>

	<tr>
		<td>Die Url wo es auftritt</td>
		<td><input type=text name=url style="border:0px;"></td>
	</tr>

	<tr>
		<td>Beschreibung</td>
		<td><textarea name=bug rows=20 cols=50 style="border:0px;"></textarea></td>
	</tr>

</table>
<input type=submit value=Einsenden style="border: 0px; background-color: yellow;">
<input type=reset value=Resetten style="border: 0px; background-color: red;">
</form>
<?
}

if($action == "save_bug")
{
	$ip    = $_SERVER['REMOTE_ADDR'];
	$datum = date("d.m.Y");
	$owner = $_POST['name'];
	$besch = $_POST['bug'];
	$url   = $_POST['url'];

	// Security optionen ///
	$owner = htmlentities($owner);
	$besch = htmlentities($besch);
	$url   = htmlentities($url);

	if(!$owner || !$besch)
	{
		echo "Fehler";
		$err = true;
	}

	if(!$err)
	{
		echo "<META http-equiv=\"refresh\" content=\"3;URL=main.php\">\n";
		$sql = ("INSERT INTO bugs (owner,ip,url,beschreibung,datum) VALUES ('".mysql_real_escape_string($owner)."','".mysql_real_escape_string($ip)."','".mysql_real_escape_string($url)."','".mysql_real_escape_string($besch)."','".mysql_real_escape_string($datum)."')");
		mysql_query($sql) or die(mysql_error());
		echo "<h1><b>Vielen Dank</b></h1>\n";
	}

}