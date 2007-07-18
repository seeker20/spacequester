<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/loginpanel.tpl");
$mtpl->assign('self', $_SERVER["PHP_SELF"]);
$mtpl->assign('method','post');
$mtpl->assign('sitetitle','Login');

if(isset($_GET["login"])||isset($_POST["login"])) {
	if(isset($_GET["login"])) {
		$usern = $_GET["lpuser"];
		$userp = $_GET["lppass"];
	}
	else {
		$usern = $_POST["lpuser"];
		$userp = $_POST["lppass"];
	}
	
	$usern     = AntiHacker($usern);
	$userp     = AntiHacker($userp);
	
	if(trim($usern)==""||trim($usern)=="Username") {
		//Keinen Usernamen angegeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie m�ssen ihren Usernamen angeben."));
	}
	else if(trim($userp)==""||trim($userp)=="Passwort") {
		//Kein Passwort enigegeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie m�ssen ihr Passwort eingeben."));
	}
	else {
		$userp=md5($userp);
		$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE uname='$usern' AND pass='$userp'");
		if($db->count($res)<=0) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Falscher Username oder falsches Passwort."));
		}
		else {
			$dsatz = $db->get($res);
			if($dsatz["rkey"]!="") {
				$mtpl->TextBlock("ERROR",array("MSG"),array("Sie m�ssen sich erst freischalten."));
			}
			else {
				$_SESSION["login"]=$dsatz["id"]."#|#".$dsatz["uname"];
				$_SESSION["acces"]=$dsatz["group"];
				
				if($_GET["starget"]=="logout"||$_SESSION["starget"]=="logout") {
					$_SESSION["target"]=SYSTEM_start;
					$_SESSION["starget"]="";
					$_SESSION["lastaction"]=1;
				}
				
				$mtpl->TextBlock("SUCCES",array("MSG"),array("Anmelden erfolgreich."));
			}
		}
	}
	
	$mtpl->clearList("SUCCES");
	$mtpl->clearList("ERROR");
}

$mtpl->out();
?>