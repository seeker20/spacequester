<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/links.tpl");
$mtpl->assign('sitetitle','Links');

$res = $db->query("select * from " . SYSTEM_dbpref . "links");
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("linktarget","linkname"),
						array($dsatz["target"],$dsatz["name"]));
}
$mtpl->clearList("list");

$mtpl->out();
?>