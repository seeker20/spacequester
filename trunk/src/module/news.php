<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/news.tpl");
$mtpl->assign('sitetitle','News');

$res = $db->query("select * from " . SYSTEM_dbpref . "news order by id desc");
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("newsdate","newstopic","newstext","newsautor"),
						array($dsatz["date"],$dsatz["topic"],str_replace('\n',"<br>", $dsatz["text"]), $dsatz["autor"]));
}
$mtpl->clearList("list");

$mtpl->out();
?>