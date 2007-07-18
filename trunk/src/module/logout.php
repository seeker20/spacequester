<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/logout.tpl");
if(isset($_SESSION["login"])&&$_SESSION["login"]!="") {
	$_SESSION["login"]="";
	$_SESSION["acces"]="";
	$mtpl->TextBlock("LOGOUTSUCCES","","");
}
else {
	$mtpl->TextBlock("LOGOUTERROR","","");
}

$mtpl->clearList("LOGOUTSUCCES");
$mtpl->clearList("LOGOUTERROR");
	
$mtpl->out();
?>