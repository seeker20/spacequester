<?php

#Session
session_start();

if(isset($_GET["newstart"])) {
	if(isset($_GET["j"])) {
		$_SESSION["JavaScript"] = true;
	}
	else {
		$_SESSION["JavaScript"] = false;
	}
	
	if(isset($_COOKIE["c-test"])) {
		$_SESSION["Cookies"] = true;
		setcookie("c-test","",time());
		$_SESSION["urladdon"]="";
	}
	else {
		$_SESSION["Cookies"] = false;
		$_SESSION["urladdon"]="&" . strip_tags(SID);
	}
	
	$_SESSION["UserStyle"]    = "default";
	
	$_SESSION["new"] = true;
	
	//funktion hat einen Fehler muss bearbeitet werden
	if($_SESSION["JavaScript"] == true) { 
		echo '<script language="JavaScript">location.href="main.php';
		if(isset($_GET["target"])) {
			echo "?target=" . $_GET["target"];
			echo $_SESSION["urladdon"];
		}
		else 
			echo str_replace("&","?",$_SESSION["urladdon"]);
			
		echo '";<' . "/" . 'script>';
		$reloade = true;
	}
}
?>

<?php
//Includes
include "../global/mysql_connect.php";
include "../global/funktionen.php";
//include "../global/querys.php";
include "../global/config.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>SpaceQuester</title>
		<meta http-equiv="Content-Language" content="de" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		
<?php
if($_SESSION["Cookies"]==''||$_SESSION["UserStyle"]=='') {
	echo '<META http-equiv="refresh" content="0;URL=../index.php';
	if(isset($_GET["target"])) {
		echo "?target=" . $_GET["target"];
	}
	else if(isset($_POST["target"])) {
		echo "?target=" . $_POST["target"];
	}
	
	echo '">';
	echo "</head>";
	echo "<body>";
	echo "<p>Load...</p>";
	echo "</body>";
	echo "</html>";
	exit();
}
?>

<link type="text/css" rel="stylesheet" href="../daten/styles/main.css">


	</head>
	<body>
		<div name='Title' id='title' align='center'>
			<h1>SpaceQuester Returns</h1>
		</div>
		<div name='Menue' id='menue' align='center'>
			<?php
				include "menue.php";
			?>
		</div>
		<div name='Haupt' id='main' align='center'>
			<?php
				include "frames.php";
			?>
		</div>
	</body>
</html>
	
