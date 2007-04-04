<?php
$db = new db();

if(isset($_GET["target"])) {
	$ziel=$_GET["target"];
	$stype = "target";
	$isnew = true;
}
else if(isset($_POST["target"])) {
	$ziel=$_POST["target"];
	$stype = "target";
	$isnew = true;
}
else if(isset($_GET["starget"])||isset($_POST["starget"])||$_SESSION["lastaction"]==2) {
	if(isset($_GET["starget"])) {
		$ziel = $_GET["starget"];
		$isnew = true;
	}
	else if(isset($_POST["starget"])) {
		$ziel = $_POST["starget"];
		$isnew = true;
	}
	else if(isset($_SESSION["starget"]))
		$ziel = $_SESSION["starget"];
	
	$stype = "starget";
}
else if($_SESSION["target"]!=''&&$_SESSION["lastaction"]==1) {
	$ziel=$_SESSION["target"];
	$stype = "target";
}
else {
	$ziel=SYSTEM_start;
}

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/userpanel.tpl");
$mtpl->assign("TITLE",SYSTEM_TITLE);
$mtpl->assign("SITETITLE",ucfirst($ziel));
$mtpl->assign("SITETARGET",$ziel);
$mtpl->assign("STYPE",$stype);

if(isset($_GET["ltarget"])&&$_SESSION["target"]!=''&&!isset($isnew )) {
	$mtpl->TextBlock("ITEM",array("SSITETITLE","SSTARGET"),array(ucfirst($_GET["ltarget"]),$_GET["ltarget"]));
}
else if(isset($_POST["ltarget"])&&$_SESSION["target"]!=''&&!isset($isnew )) {
	$mtpl->TextBlock("ITEM",array("SSITETITLE","SSTARGET"),array(ucfirst($_POST["ltarget"]),$_POST["ltarget"]));
}
else if($_SESSION["ltarget"]!=''&&$_SESSION["target"]!=''&&!isset($isnew )) {
	$mtpl->TextBlock("ITEM",array("SSITETITLE","SSTARGET"),array(ucfirst($_SESSION["ltarget"]),$_SESSION["ltarget"]));
}
$mtpl->clearList("ITEM");

$mtpl->out();
?>