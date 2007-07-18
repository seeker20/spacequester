<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/pminterface.tpl");
$mtpl->assign('SITETITLE','PM Nachrichten');
$mtpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH);

//Aktuelle Datum setzen
$mtpl->assign('ADATE', date("Y-m-d H:i:s"));
//Anzahl neuer Nachrichten abfragen
$usera = explode("#|#",$_SESSION["login"]);
$thisuserid = $usera[0];

$db->query("SELECT * FROM " . SYSTEM_dbpref . "pmmessages WHERE idempf='$thisuserid' AND status='neu'");
$mtpl->assign('ANZNPM',$db->count());


if(isset($_GET["view"])||isset($_POST["view"])) {
	#Eine Nachricht lesen
	if(isset($_GET["view"])) $id = $_GET["view"];
	else $id = $_POST["view"];
	
	$db->query("SELECT * FROM " . SYSTEM_dbpref . "pmmessages WHERE idempf='$thisuserid' AND id='$id'");
	$dsatz = $db->get();
	
	//Namen Raussuchen
	$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='".$dsatz["idabse"]."'");
	$dsatz2 = $db->get($res);
	$aname = $dsatz2["uname"];
	
	$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='".$dsatz["idempf"]."'");
	$dsatz2 = $db->get($res);
	$ename = $dsatz2["uname"];
	
	$mtpl->TextBlock("VIEWPM",array("ID","ABSENDERN","BETREFF","ABSENDERID","DATE","FOLDER","STATUS","TEXT","EMPFN","EMPFID"),
							array(ReAntiHacker($dsatz["id"]),ReAntiHacker($aname),ReAntiHacker($dsatz["betreff"]),ReAntiHacker($dsatz["idabse"]),ReAntiHacker($dsatz["date"]),ReAntiHacker($dsatz["folder"]),ReAntiHacker($dsatz["status"]),str_replace("\n","<br />",ReAntiHacker($dsatz["message"])),ReAntiHacker($ename),ReAntiHacker($dsatz["idempf"])));
			
	if($dsatz["status"]!="gelesen")
		$db->query("UPDATE " . SYSTEM_dbpref . "pmmessages SET status='gelesen' WHERE idempf='$thisuserid' AND id='$id'");
}
else if(isset($_GET["vpme"])||isset($_POST["vpme"])) {
	#Posteingang anzeigen
	$mtpl->TextBlock("PMEINGANG","","");
}
else if(isset($_GET["vpma"])||isset($_POST["vmpa"])) {
	#Postausgang anzeigen
	$mtpl->TextBlock("PMAUSGANG","","");
}
else if(isset($_GET["vpmf"])||isset($_POST["vmpf"])) {
	#Einen Ordnern anzeigen
	$mtpl->TextBlock("PMFOLDER","","");
}
else if(isset($_GET["cnpm"])||isset($_POST["cnpm"])) {
	#erstelle neue nachricht
	if(isset($_GET["cnpm"])) {
		$empf = AntiHacker($_GET["empf"]);
		$betr = AntiHacker($_GET["betr"]);
		$msg  = AntiHacker($_GET["msg"]);
	}
	else {
		$empf = AntiHacker($_POST["empf"]);
		$betr = AntiHacker($_POST["betr"]);
		$msg  = AntiHacker($_POST["msg"]);
	}
	
	
	if(($msg=trim($msg))=="") $mtpl->TextBlock("INFO", array("TEXT"), array("Error: Sie müssen einen Texteingeben."));
	else if(($empf=trim($empf))=="") $mtpl->TextBlock("INFO", array("TEXT"), array("Error: Sie müssen einen Empfänger auswählen."));
	else if(($betr=trim($betr))=="") $mtpl->TextBlock("INFO", array("TEXT"), array("Error: Sie müssen einen Betreff auswählen."));
	else {
		//Prüfen ob es den User überhaupt gibt
		$db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE uname='$empf'");
		$dsatz = $db->get();
		if($dsatz["id"]=="") {
			$mtpl->TextBlock("INFO", array("TEXT"), array("Error: Es gibt diesen user nicht."));
		}
		else {
			$empf  = $dsatz["id"];
			$adate = date("Y-m-d H:i:s");
			$db->query("INSERT INTO `cm_pmmessages` ( `id` , `idabse` , `idempf` , `betreff` , `message` , `date` , `status` , `folder` ) VALUES ( NULL , '$thisuserid', '$empf', '$betr', '$msg', '$adate', 'neu', 'Posteingang' )");
			
			if(isset($_GET["kpa"])||isset($_POST["kpa"])) {
				$db->query("INSERT INTO `cm_pmmessages` ( `id` , `idabse` , `idempf` , `betreff` , `message` , `date` , `status` , `folder` ) VALUES ( NULL , '$thisuserid', '$empf', '$betr', '$msg', '$adate', 'gelesen', 'Postausgang' )");
				
				$mtpl->TextBlock("INFO", array("TEXT"), array("Nachricht wurde erfolgreich gesendet. Eine Kopie wurde in ihren Postausgang geschrieben"));
			}
			else {
				$mtpl->TextBlock("INFO", array("TEXT"), array("Nachricht wurde erfolgreich gesendet."));
			}
		}
	}
}
else {
	#Posteingang zeigen
	$mtpl->TextBlock("PMEINGANG","","");
}

//Eine Nachricht als Ungelesen markeieren
if(isset($_GET["setur"])||isset($_POST["setur"])) {
	if(isset($_GET["setur"])) $id = AntiHacker($_GET["id"]);
	else $id = AntiHacker($_POST["id"]);
	
	$db->query("UPDATE " . SYSTEM_dbpref . "pmmessages SET status='ungelesen' WHERE idempf='$thisuserid' AND id='$id'");
	
	$mtpl->TextBlock("INFO", array("TEXT"), array("Nachricht erfolgreich als Ungelesen Markiert."));
}

//Eine Nachricht Löschen
if(isset($_GET["delpm"])||isset($_POST["delpm"])) {
	if(isset($_GET["delpm"])) {
		if(!isset($_GET["id"])) $id = AntiHacker($_GET["delpm"]);
		else $id = AntiHacker($_GET["id"]);
	}
	else {
		if(!isset($_POST["id"])) $id = AntiHacker($_POST["delpm"]);
		else $id = AntiHacker($_POST["id"]);
	}
	
	$db->query("DELETE FROM " . SYSTEM_dbpref . "pmmessages WHERE idempf='$thisuserid' AND id='$id'");
	
	$mtpl->TextBlock("INFO", array("TEXT"), array("Nachricht wurde erfolgreich gelöscht."));
}

//Einlesen des Posteingangs
$db->query("SELECT * FROM " . SYSTEM_dbpref . "pmmessages WHERE idempf='$thisuserid' AND folder='Posteingang'");
while($dsatz=$db->get()) {
	//Namen Raussuchen
	$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='".$dsatz["idabse"]."'",true);
	$dsatz2 = $db->get($res);
	$aname = $dsatz2["uname"];

	//Ausgeben der daten
	if($dsatz["status"]=="neu") {
		$mtpl->TextRepeater("eNPMMSG",array("ID","ABSENDERN","BETREFF","ABSENDERID","DATE"),
							array(ReAntiHacker($dsatz["id"]),ReAntiHacker($aname),ReAntiHacker($dsatz["betreff"]),ReAntiHacker($dsatz["idabse"]),ReAntiHacker($dsatz["date"])));
	}
	else if($dsatz["status"]=="ungelesen") {
		$mtpl->TextRepeater("eURPMMSG",array("ID","ABSENDERN","BETREFF","ABSENDERID","DATE"),
							array(ReAntiHacker($dsatz["id"]),ReAntiHacker($aname),ReAntiHacker($dsatz["betreff"]),ReAntiHacker($dsatz["idabse"]),ReAntiHacker($dsatz["date"])));
	}
	else if($dsatz["status"]=="gelesen") {
		$mtpl->TextRepeater("eRPMMSG",array("ID","ABSENDERN","BETREFF","ABSENDERID","DATE"),
							array(ReAntiHacker($dsatz["id"]),ReAntiHacker($aname),ReAntiHacker($dsatz["betreff"]),ReAntiHacker($dsatz["idabse"]),ReAntiHacker($dsatz["date"])));
	}
}

//Einlesen des Postausgangs
$db->query("SELECT * FROM " . SYSTEM_dbpref . "pmmessages WHERE idabse='$thisuserid' AND folder='Postausgang'");
while($dsatz=$db->get()) {
	//Namen Raussuchen
	$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE id='".$dsatz["idabse"]."'",true);
	$dsatz2 = $db->get($res);
	$aname = $dsatz2["uname"];

	//Ausgeben der daten
	$mtpl->TextRepeater("pAMSG",array("ID","ABSENDERN","BETREFF","ABSENDERID","DATE"),
							array(ReAntiHacker($dsatz["id"]),ReAntiHacker($aname),ReAntiHacker($dsatz["betreff"]),ReAntiHacker($dsatz["idabse"]),ReAntiHacker($dsatz["date"])));
}

$mtpl->clearList("eNPMMSG");
$mtpl->clearList("eURPMMSG");
$mtpl->clearList("eRPMMSG");

$mtpl->clearList("pAMSG");


$mtpl->clearList("PMEINGANG");
$mtpl->clearList("PMAUSGANG");
$mtpl->clearList("PMFOLDER");
$mtpl->clearList("VIEWPM");

$mtpl->clearList("INFO");

$mtpl->out();
?>