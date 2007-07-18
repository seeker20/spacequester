<?php
#PHP-Myslq-Session manager
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

function sstartSession() {
	$db = new db();
	
	$sid 	= "";
	$time 	= time();
	$date   = date("Y-m-d");
	
	//Alte Einträge Löschen
	if(SYSTEM_SESSION_halt>0) {
		$time_new = $time-SYSTEM_SESSION_halt;
		$db->query("delete from `" . SYSTEM_dbpref . "sessions` where `erstellt` < '" . $time_new . "'");
	}
	else {
		$db->query("delete from `" . SYSTEM_dbpref . "sessions` where not `erstellt_date` ='" . $date . "'");
	}

	if(isset($_COOKIE["SID"])) {
		$sid = $_COOKIE["SID"];
	}
	else if(isset($_GET["SID"])) {
		$sid = $_GET["SID"];
	}
	else if(isset($_POST["SID"])) {
		$sid = $_POST["SID"];
	}
	
	#prüfen ob session noch aktuell ist
	$db->query("SELECT * from " . SYSTEM_dbpref . "sessions where sessionid='" . AntiHacker($sid) . "' LIMIT 1");
	if($db->count()<=0) {
		$sid="";
	}
	
	if($sid=="") {
		#Neue Session starten
		srand(microtime()*1000000);
		$buchstaben = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","s","t","u","v","w","x","y","z");
		
		$isnotnewkey=true;
		while($isnotnewkey) {
			$sid = "";
			for($i=0;$i<15;$i++) {
				$zuf = rand(0,9);
				if($zuf<5) {
					$sid .=  rand(0,9);
				}
				else {
					$sid .=  $buchstaben[rand(0,count($buchstaben))];
				}
			}
			$db->query("SELECT * from " . SYSTEM_dbpref . "sessions where sessionid='" . $sid . "' LIMIT 1");
			if($db->count()<=0) {
				$isnotnewkey=false;
			}
		}
		
		if(isset($_COOKIE["c-test"])) {
			#Setzen wir das Session Cookie
			if(SYSTEM_SESSION_halt>0) {
				setcookie("SID",$sid, time()+SYSTEM_SESSION_halt);
			}
			else {
				setcookie("SID",$sid, 0);
			}
		}
		
		
		$db->query("INSERT INTO `" . SYSTEM_dbpref . "sessions` ( `id` , `sessionid` , `namea` , `valuea` , `erstellt` , `erstellt_date` ) VALUES ( NULL , '" . $sid . "', '', '', '" . $time . "', '" . $date . "')");
	}
	else {
		#Session register füllen
		$db->query("UPDATE " . SYSTEM_dbpref . "sessions set erstellt='" . $time . "' where sessionid='" . AntiHacker($sid) . "'");
		$db->query("SELECT * from " . SYSTEM_dbpref . "sessions where sessionid='" . AntiHacker($sid) . "' LIMIT 1");
		
		$dsatz  = $db->get();
		$namea  = explode("|#|",$dsatz["namea"]);
		$valuea = explode("|#|",$dsatz["valuea"]);
		
		if(count($namea)!=count($valuea)) {
			echo "<p>Session fehler</p>";
		}
		else {
			for($i=0;$i<count($namea);$i++) {
				$_SESSION[ReAntiHacker($namea[$i])]=ReAntiHacker($valuea[$i]);
			}
		}
	}
	
	define ("SID", $sid);
}

function sstopSession() {
	$db = new db();
	
	$namea;
	$valuea;
	
	foreach ($_SESSION as $key => $value) {
		if(trim($value)!="") {
			$namea[count($namea)]=AntiHacker($key);
			$valuea[count($valuea)]=AntiHacker($value);
		}
	}
	
	if(count($namea)!=count($valuea)) {
		die("Session kann nicht gespeichert werden.");
	}
	
	$nameat  = implode("|#|",$namea);
	$valueat = implode("|#|",$valuea);
	
	$db->query("UPDATE " . SYSTEM_dbpref . "sessions set namea='" . $nameat . "', valuea='" . $valueat . "' where sessionid='" . AntiHacker(SID) . "'");
}

?>