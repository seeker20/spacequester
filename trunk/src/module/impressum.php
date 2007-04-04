<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/impressum.tpl");
$mtpl->assign('SITETITLE','Impressum');

$mtpl->assign('NAME',SYSTEM_ADMIN_name);
$mtpl->assign('STARSSE',SYSTEM_ADMIN_strasse);
$mtpl->assign('POSTLEITZAHL',SYSTEM_ADMIN_psz);
$mtpl->assign('ORT',SYSTEM_ADMIN_ort 	);
$mtpl->assign('TEL',SYSTEM_ADMIN_tel);
$mtpl->assign('MAIL',SYSTEM_ADMIN_mail);

$mtpl->out();
?>