<?php
$CMS = true;
include "../configs/config.inc.php";
include "../".SYSTEM_FUNCTIONS."thumbnail.inc.php";

$paras = $_GET["paras"];

$parasa= explode("|",$paras);

$path  = $parasa[0];

$thum = new thumbnail("../" . SYSTEM_PIC_path . $path);

if(count($parasa)==2) {
	$thum->size_auto($parasa[1]);
}
else {
	$groesse=getimagesize("../" . SYSTEM_PIC_path . $path);
	$thum->size_height($groesse[1]);
	$thum->size_width($groesse[0]);
}

$thum->show();
?>