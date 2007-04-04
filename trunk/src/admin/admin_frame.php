<?php
if(isset($_GET["ltarget"])) {
	$ltarget=$_GET["ltarget"];
	$_SESSION["lastsecaction"]='';
}
else if(isset($_POST["ltarget"])) {
	$ltarget=$_POST["ltarget"];
	$_SESSION["lastsecaction"]='';
}
else if($_SESSION["ltarget"]!='') {
	$ltarget=$_SESSION["ltarget"];
}
else {
	$ltarget=SYSTEM_ADMIN_start;
}

if($_SESSION["ltarget"]!=$ltarget) {
	$_SESSION["ltarget"]=$ltarget;
}

if($ltarget=="") {
	printError("Kein Ziel übergeben.");
}
else {
	if(!file_exists(SYSTEM_ADMIN_path . "/" . $ltarget . ".php")) {
		printError("System Admin Seite \"" . $ltarget . "\" wurde nicht gefunden.");
	}
	else {
		include SYSTEM_ADMIN_path . $ltarget . ".php";
	}
}
?>