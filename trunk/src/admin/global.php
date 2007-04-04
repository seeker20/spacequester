<?php
function dirCount($dirName) {
	$i = 0;
	$dir = dir($dirName);

	while($obj = $dir->read()) {
		if($obj!='.' && $obj!='..') {
			if(!is_dir($dirName.$obj)) {
				$i++;
			}
		}
	}
	return $i;
}

$tpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/admin/global.tpl");
$tpl->assign('SYSTEM_VERSION',SYSTEM_VERSION);
$tpl->assign('USERSITES',dirCount(SYSTEM_USERSITESF));
if(SYSTEM_UPDATE_AUTO=="ON") {
	#Auf Updates Prüfen
	$fp = @fopen(SYSTEM_UPDATE_URL . "updater.php", "r");
	if(!$fp) {
		$tpl->TextBlock('ERROR',array("ERRMSG"),array('Konnte die Aktuelle Version nicht abfragen!'));
	}
	else {
		$inetversion = fgets($fp);
		$tpl->TextBlock('ISVERSIONCHECK',array("INET_VERSION"),array($inetversion));
		if($inetversion!=SYSTEM_VERSION) {
			$tpl->TextBlock('ISVERSIONCHECKNV',array("INET_VERSION"),array($inetversion));
			$tpl->TextBlock('INFO',array("TEXT"),array("Es ist eine Neue Version verfügbar"));
		}
		else {
			$tpl->TextBlock('ISVERSIONCHECKSA',array("INET_VERSION"),array($inetversion));
		}
		fclose($fp);
	}
}
$tpl->assign('MODULES',dirCount(SYSTEM_modul_path));
$tpl->assign('SMODULES',dirCount(SYSTEM_system_path));

$tpl->clearList('ERROR');
$tpl->clearList('INFO');
$tpl->clearList('ISVERSIONCHECK');
$tpl->clearList('ISVERSIONCHECKSA');
$tpl->clearList('ISVERSIONCHECKNV');
$tpl->out();
?>