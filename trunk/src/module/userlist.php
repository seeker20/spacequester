<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/userlist.tpl");

$mtpl->assign('sitetitle','Mitglieder Liste');
$mtpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH);

$db->query("select * from " . SYSTEM_dbpref . "users");
while($dsatz=$db->get()) {
	$mtpl->TextRepeater("LIST1",array("USERID","USERNAME"),
						array(ReAntiHacker($dsatz["id"]),ReAntiHacker($dsatz["uname"])));	
}

$mtpl->clearList("LIST1");
$mtpl->out();
?>