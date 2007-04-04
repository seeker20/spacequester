<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/loginpanel.tpl");
$mtpl->assign('self', $_SERVER["PHP_SELF"]);
$mtpl->assign('method','post');
$mtpl->assign('sitetitle','LoginPanel');
$mtpl->out();
?>