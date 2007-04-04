<?php
$db = new db();
$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/admin.tpl");
$mtpl->assign('sitetitle','Admin Bereich');

$mtpl->assign('self', $_SERVER["PHP_SELF"]);
$mtpl->assign('method','post');

$admin = false;

//Logout
if(isset($_GET["ac"])) {
	if($_GET["ac"]=='logout') {
		$_SESSION["adminskey"]	= '';
		$_SESSION["adminid"]	= '';
		$mtpl->TextBlock("logoutsucces","","");
	}
}
else if(isset($_POST["ac"])) {
	if($_POST["ac"]=='logout') {
	$_SESSION["adminskey"]		= '';
		$_SESSION["adminid"]	= '';
	}
}

if($_SESSION["adminid"]!='') {
	if($_SESSION["adminskey"]!=SYSTEM_ADMIN_skey) {
		$admin = false;
	}
	else {
		$db->query("select * from " . SYSTEM_dbpref . "admin where id='" . $_SESSION["adminid"] . "'");
		if($db->count()<=0) {
			$admin = false;
		}
		else {
			$admin = true;
		}
	}
}

if(!$admin) {
	if(isset($_POST["login"])) {
		$mtpl->clearList("login");
		if(!(isset($_POST["username"]))) {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Kein Username übergeben."));
		}
		else if(!(isset($_POST["userpass"]))) {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Kein Passwort übergeben."));
		}
		else if(!(isset($_POST["skey"]))) {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Kein Security Key übergeben."));
		}
		else if($_POST["skey"]!=SYSTEM_ADMIN_lkey) {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Security Keys stimmen nicht überein."));
		}
		else if($_POST["username"]=="") {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Keinen Usernamen angegeben."));
		}
		else if($_POST["userpass"]=="") {
			$mtpl->TextBlock("loginerror",array("errormessage"),array("Kein Passwort eingegeben."));
		}
		else {
			$username = mysql_real_escape_string($_POST["username"]);
			$userpass = md5($_POST["userpass"]);
			$db->query("select * from " . SYSTEM_dbpref . "admin where name='$username' and password='$userpass'");
			if($db->count()<=0) {
				$mtpl->TextBlock("loginerror",array("errormessage"),array("Die Anmeldedaten Stimmen nicht."));
			}
			else {
				$dsatz = $db->get();
				if($dsatz["securekey"]!=SYSTEM_ADMIN_dkey) {
					$mtpl->TextBlock("loginerror",array("errormessage"),array("Der Security Code im Usereintrag ist falsch."));
				}
				else {
					$_SESSION["adminskey"]	= SYSTEM_ADMIN_skey;
					$_SESSION["adminid"]	= $dsatz["id"];
					
					$db->query("UPDATE " . SYSTEM_dbpref . "admin Set ip = '".getenv("REMOTE_ADDR")."' WHERE id = '".$_SESSION["adminid"]."';");
					
					$admin=true;
					
					$mtpl->TextBlock("loginsucces","","");
				}
			}
		}
	}
	else {
		$mtpl->TextBlock("login",array("skey"),array(SYSTEM_ADMIN_lkey));
	}
}

if($admin) {
	$mtpl->TextBlock("admin",array("ADMIN_MENUE","ADMIN_FRAME"),array("<?php include \"" . SYSTEM_ADMIN_path . "/admin_menue.php\"; ?>",ReadTplFile(SYSTEM_ADMIN_path . "/admin_frame.php")));
}


$mtpl->clearList("login");
$mtpl->clearList("loginerror");
$mtpl->clearList("loginsucces");
$mtpl->clearList("admin");
$mtpl->clearList("logoutsucces");

$mtpl->out();