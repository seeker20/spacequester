<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/admin/admin_menue.tpl");
$mtpl->assign('sitetitle','Admin Navigation');

$res = $db->query("select * from " . SYSTEM_dbpref . "admin_menue");
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("linktarget","linkname"),
						array($dsatz["target"],$dsatz["name"]));
}
$mtpl->clearList("list");

$mtpl->out();
?>