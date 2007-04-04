<?php
$db = new db();

$gbout = "&nbsp;";
if(isset($_POST["gbuch"])) {
	#hier die daten asuwerten
	$err = false;
	if(isset($_POST["gfname"])) {
		$gfname = mysql_real_escape_string(trim($_POST["gfname"]));
		if($gfname=='') {
			$gbout.="Kein Name eingegben.<br>\n";
			$err=true;
		}
	}
	else $gfname="";
	if(isset($_POST["gfemail"])) {
		$gfemail = mysql_real_escape_string(trim($_POST["gfemail"]));
		if($gfemail=='') {
			$gbout.="Keine email eingegben.<br>\n";
			$err=true;
		}
	}
	else $gfemail="";
	if(isset($_POST["gfhp"])) {
		$gfhp = mysql_real_escape_string(trim($_POST["gfhp"]));
	}
	else $gfhp="";
	if(isset($_POST["gftext"])) {
		$gftext = mysql_real_escape_string(trim($_POST["gftext"]));
		if($gftext=='') {
			$gbout.="Kein Text eingegben.<br>\n";
			$err=true;
		}
	}
	else $gftext="";
	
	if(!$err) {
		$res = $db->query("select * from " . SYSTEM_dbpref . "gbuch where name='$gfname' and email='$gfemail' and hp='$gfhp' and text='$gftext'");
		if($db->count($res)>0) {
			$gbout.="Doppel Eintrag.<br>\n";
		}
		else {
			$date = date("j.m.Y H:m:s");
			$db->query("INSERT INTO `" . SYSTEM_dbpref . "gbuch` ( `id` , `name` , `email` , `hp` , `text` , `date` ) VALUES ( NULL , '" . $gfname . "', '" . $gfemail . "', '" . $gfhp . "', '" . $gftext . "', '" . $date . "' )");
		}
	}
}

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/gbuch.tpl");
$mtpl->assign('sitetitle','Gästebuch');
$mtpl->assign('gberrorout',$gbout);
$mtpl->assign('self', $_SERVER["PHP_SELF"]);
$mtpl->assign('method','post');

$res = $db->query("select * from " . SYSTEM_dbpref . "gbuch order by id desc");
while($dsatz=$db->get($res)) {
	$mtpl->TextRepeater("list",array("gbuchname","gbuchemail","gbuchhp","gbuchdate","gbuchtext"),
						array($dsatz["name"],$dsatz["email"],$dsatz["hp"], $dsatz["date"], str_replace('\n',"<br>", $dsatz["text"])));
}
$mtpl->clearList("list");

$mtpl->out();
?>