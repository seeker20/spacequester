<?php
if(isset($_GET["ajax"])) {
	session_start();
	
	#include "config.php";
	#include "includes/mysql_connect.inc.php";
	#include "includes/languag.inc.php";
	#include "includes/random.inc.php";
	#include "includes/utilitis.inc.php";
}
?>

<?php
if(isset($_GET["target"])) {
	$target = $_GET["target"];
}
else if(isset($_POST["target"])) {
	$target = $_POST["target"];
}
else {
	$target = "home";
}
?>

<?php
$tmpTarget = $target;
$target 	.= ".php";

if($tmpTarget == "admin")
{
	echo "<a href=./admin/ target=_blank>Admin-Panel</a>\n";
	exit();
}

if(!(file_exists($target)))
{
	if(!(file_exists("error.php")))
	{
		//$errorl = new LangObject($_SESSION["Language"], "in_error");
		echo "<h2>Fehler: Seite nicht gefunden</h2>";
		echo "<p>Er konnte die angegebene seite nciht finden</p>";
		echo "<p>Die seite " . $target . " wurde nciht gefunden</p>";
		echo "<p>Veruschen sie es sp&#228;ternochmal ansonsten kontaktiren</p>";
		echo "<p>sie bitte den webmaster</p>";
	}
	else
	{
		include "error.php";
	}
}
else {
	include $target;
}

?>