<?php
$db = new db();

if(!isset($MENUE_ID)||$MENUE_ID=="") {
	$MENUE_ID=0;
}
if(!isset($MENUE_NAME)||$MENUE_NAME=="") {
	$MENUE_NAME='Navigation';
}

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/menue.tpl");
$mtpl->assign('sitetitle',$MENUE_NAME);

$res = $db->query("select * from " . SYSTEM_dbpref . "menue WHERE menue_id='$MENUE_ID' ORDER BY pos ASC");
while($dsatz=$db->get($res)) {
	$is = false;
	if($dsatz["acces_groups"]=="") {
		$is = true;
	}
	else {
		if($_SESSION["acces"]=="") $acces=0;
		else $acces = $_SESSION["acces"];
		
		$split = explode("#",ReAntiHacker($dsatz["acces_groups"]));
		for($i=0;$i<count($split);$i++) {
			if($acces==$split[$i]) {
				$is=true;
				break;
			}
		}
	}
	
	if($is) {
		$mtpl->TextRepeater("list",array("linktarget","linkname"),
							array($dsatz["target"],$dsatz["name"]));
	}
}
$mtpl->clearList("list");

$mtpl->out();
?>