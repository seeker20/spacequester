<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/todo.tpl");
$mtpl->assign('sitetitle','Todos');

$res = $db->query("select * from " . SYSTEM_dbpref . "todo");
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("todo","status"),
						array($dsatz["todo"],$dsatz["status"]));
}
$mtpl->clearList("list");

$mtpl->out();
?>