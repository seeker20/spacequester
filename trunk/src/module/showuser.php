<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/showuser.tpl");
$mtpl->assign('sitetitle','User Profil Anzeigen');
$mtpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH);

$usera = explode("#|#",$_SESSION["login"]);
$thisuserid = $usera[0];


$db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='$thisuserid'");
$dsatz = $db->get();

$mtpl->assign('ID',       ReAntiHacker($dsatz["id"]));
$mtpl->assign('USERNAME', ReAntiHacker($dsatz["uname"]));
$mtpl->assign('USERMAIL', ReAntiHacker($dsatz["email"]));
$mtpl->assign('NAME',     ReAntiHacker($dsatz["rname"]));
$mtpl->assign('GEBDATE',  ReAntiHacker($dsatz["gyear"]));

$mtpl->out();
?>