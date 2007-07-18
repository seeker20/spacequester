<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/options.tpl");
$mtpl->assign('SITETITLE','User Einstellungen');

$usera = explode("#|#",$_SESSION["login"]);

if(isset($_POST["akt"])) {
	if($_POST["akt"]=='nameedit') {
		if(!isset($_POST["username"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Kein Username übergeben."));
		}
		else if(trim($_POST["username"])=="") {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen einen Usernamen angeben."));
		}
		else if($_POST["username"]==$usera[1]) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen einen neuen Usernamen angeben."));
		}
		else {
			$db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE uname='".AntiHacker($_POST["username"])."'");
			if($db->count()>0) {
				$mtpl->TextBlock("ERROR",array("MSG"),array("Diesen Usernamen gibt es bereits."));
			}
			else {
				$db->query("UPDATE " . SYSTEM_dbpref . "users SET uname='".AntiHacker($_POST["username"])."' WHERE id='".$usera[0]."'");
				
				$_SESSION["login"]=$usera[0]."#|#".$_POST["username"];
				$usera[1]=$_POST["username"];
				$mtpl->TextBlock("SUCCES",array("MSG"),array("Der Username wurde erfolgreich geändert."));
			}
		}
	}
	else if($_POST["akt"]=='passedit') {
		if(!isset($_POST["oldpass"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Kein altes Passwort übergeben."));
		}
		else if(!isset($_POST["newpass1"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Kein neues Passwort übergeben."));
		}
		else if(!isset($_POST["newpass2"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Keine wiederholung vom neuen Passwort übergeben."));
		}
		else if(trim($_POST["oldpass"])=="") {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen ihr altes Passwort angeben."));
		}
		else if(trim($_POST["newpass1"])=="") {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen ein neues Passwort angeben."));
		}
		else if(trim($_POST["newpass2"])=="") {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen ihr neues Passwort wiederholen."));
		}
		else if(trim($_POST["newpass1"])!=trim($_POST["newpass2"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen 2mal das Selbe passwort eingeben."));
		}
		else {
			$db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE pass='".md5(AntiHacker($_POST["oldpass"]))."'");
			if($db->count()<=0) {
				$mtpl->TextBlock("ERROR",array("MSG"),array("Sie haben ein falsches Passwort angegeben."));
			}
			else {
				$db->query("UPDATE " . SYSTEM_dbpref . "users SET pass='".md5(AntiHacker($_POST["newpass1"]))."' WHERE id='".$usera[0]."'");
				$mtpl->TextBlock("SUCCES",array("MSG"),array("Ihr Passwort wurde erfolgreich geändert."));
			}
		}
	}
	else if($_POST["akt"]=='optionsedit') {
		if(!isset($_POST["rname"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Keinen namen übergeben."));
		}
		else if(!isset($_POST["gyear"])) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Kein Geburtstag Jahr übergeben."));
		}
		else {
			$db->query("UPDATE " . SYSTEM_dbpref . "users SET rname='".AntiHacker($_POST["rname"])."', gyear='".AntiHacker($_POST["gyear"])."'  WHERE id='".$usera[0]."'");
			$mtpl->TextBlock("SUCCES",array("MSG"),array("Die Änderungen wurden erfolgreich gespeichert."));
		}
	}
	
	$mtpl->clearList("SUCCES");
	$mtpl->clearList("ERROR");
}

$db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='".$usera[0]."'");
$dsatz = $db->get();

$mtpl->assign('REALNAME',ReAntiHacker($dsatz["rname"]));
$mtpl->assign('GYEAR',ReAntiHacker($dsatz["gyear"]));

$mtpl->assign('USERNAME',$usera[1]);
	
$mtpl->out();
?>