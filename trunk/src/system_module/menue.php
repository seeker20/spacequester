<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/menue.tpl");
$mtpl->assign('sitetitle','Navigation');

if($_SESSION["login"]=="") {
	$res = $db->query("select * from " . SYSTEM_dbpref . "menue WHERE log='0'");
}
else {
	$res = $db->query("select * from " . SYSTEM_dbpref . "menue WHERE log='1'");
}
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("linktarget","linkname"),
						array($dsatz["target"],$dsatz["name"]));
}
$mtpl->clearList("list");

if(isset($_GET["logout"])) {
	$_SESSION["login"]="";
	$_SESSION["acces"]="";
}

$mtpl->out();
?>