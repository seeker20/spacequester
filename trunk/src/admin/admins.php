<?php
$tpl = new tpl(SYSTEM_STYLE_PATH . "/" . $_SESSION["style"] . "/admin/admins.tpl");
$tpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin/");

if(isset($_GET['action'])||isset($_POST['action'])) {
	if($_GET['action'] == "delete") {
		$res = $db->query('SELECT name FROM '.SYSTEM_dbpref."admin WHERE id = '".mysql_real_escape_string($_GET['id'])."';");
		$dbsatz = $db->get($res);
		$admin = $dbsatz['name'];
		$db->query("DELETE FROM ".SYSTEM_dbpref."admin WHERE id = '".mysql_real_escape_string($_GET['id'])."';");
		$tpl->assign('INFO','Admin "'.$admin.'" erfolgreich gelöscht!');
	} else if($_POST['action'] == "save") {
		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($_POST['username'] != "") {
				if($_POST['password'] != "") {
					$username = mysql_real_escape_string($_POST['username']);
					if($db->count($db->query("SELECT * FROM ".SYSTEM_dbpref."admin WHERE name='$username'",true))>0) {
						$tpl->assign('INFO','Admin "' . $username . '" gibt es bereits.');
					}
					else {
						$password = $_POST['password'];
						$password = md5($password);
						$res = $db->query("INSERT INTO ".SYSTEM_dbpref."admin (name, password, securekey) VALUES ('$username', '$password', '" . SYSTEM_ADMIN_dkey . "')",true);
						if($res == true) {
							$tpl->assign('INFO','Admin "' . $username . '" erfolgreich erstellt!');
						} else {
							$tpl->assign('INFO','Admin "' . $username . '" konnte nicht erstellt werden. Eventuell existiert dieser Namen bereits!');
						}
					}
				} else {
					$tpl->assign('INFO','Kein Passwort angegeben');
				}
			} else {
				$tpl->assign('INFO','Kein Benutzername angegeben');
			}
		}
	} else if($_POST['action'] == "saveedit") {
		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($_POST['username'] != "") {
				$username = mysql_real_escape_string($_POST['username']);
				$password = $_POST['password'];
					
				$dsatz    = $db->get($db->query("SELECT * FROM ".SYSTEM_dbpref."admin WHERE id='" . mysql_real_escape_string($_POST["id"]) . "'",true));
					
				if($password=='') $password=$dsatz["password"];
				else $password = md5($password);
					
				if($db->count(($res=$db->query("SELECT * FROM ".SYSTEM_dbpref."admin WHERE name='$username'",true)))>0) {
					$dsatz = $db->get($res);
					if($dsatz['id']!=$_POST['id']) {
						$tpl->assign('INFO','Admin "' . $username . '" gibt es bereits.');
					}
					else {
						$res = $db->query("UPDATE ".SYSTEM_dbpref."admin SET name='$username', password='$password' WHERE id='" . mysql_real_escape_string($_POST['id']) . "'");
						
						if($res == true) {
							$tpl->assign('INFO','Admin "' . $username . '" erfolgreich geändert!');
						} else {
							$tpl->assign('INFO','Admin "' . $username . '" konnte nicht bearbetet werden. Eventuell existiert dieser Namen bereits!');
						}
					}
				}
				else {
					$res = $db->query("UPDATE ".SYSTEM_dbpref."admin SET name='$username', password='$password' WHERE id='" . mysql_real_escape_string($_POST["id"]) . "'");
					
					if($res == true) {
						$tpl->assign('INFO','Admin "' . $username . '" erfolgreich geändert!');
					} else {
						$tpl->assign('INFO','Admin "' . $username . '" konnte nicht bearbetet werden. Eventuell existiert dieser Namen bereits!');
					}
				}
			} else {
				$tpl->assign('INFO','Kein Benutzername angegeben');
			}
		} else {
			$tpl->assign('INFO','Nicht alle Felder ausgefüllt!');
		}
	} else {
		$tpl->assign('INFO','');
	}
} else {
	$tpl->assign('INFO','');
}

if(isset($_GET["id"])||isset($_POST["id"])) {
	if(isset($_GET["id"])) 	$id = $_GET["id"];
	else					$id = $_POST["id"];
	$db->query("SELECT * FROM ".SYSTEM_dbpref."admin WHERE id = '".mysql_real_escape_string($_GET['id'])."';");
	$dsatz = $db->get();
	
	$tpl->assign('ADMINNAME',$dsatz['name']);
	$tpl->assign('AID',$dsatz['id']);
}
	
$res = $db->query('SELECT * FROM '.SYSTEM_dbpref.'admin');
while($dsatz=$db->get($res)) {
	$tpl->TextRepeater('list', array('admin_name','admin_ip','ADMINID'),array($dsatz['name'],$dsatz['ip'],$dsatz["id"]));
}
$tpl->clearList('list');
$tpl->out();
?>