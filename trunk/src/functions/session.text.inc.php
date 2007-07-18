<?php
#PHP-Text-Session manager
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

function sstartSession() {
	$sid 	= "";
	$time 	= time();
	$date   = date("Y-m-d");
	
	//Alte Einträge Löschen
	$time_new 	= $time-SYSTEM_SESSION_halt;
	$dir 		= dir(SYSTEM_SESSION_path);
	
	while($obj = $dir->read()) {
		if($obj!='.' && $obj!='..') {
			if(!is_dir(SYSTEM_SESSION_path.'/'.$obj)) {	
				$filenames = split("_",$obj);
				if(SYSTEM_SESSION_halt>0) {
					if($filenames[1]<$time_new) {
						unlink(SYSTEM_SESSION_path.$obj);
					}
				}
				else {
					if($filenames[2]!=$date.'.sid') {
						unlink(SYSTEM_SESSION_path.$obj);
					}
				}
			}
		}
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
	
	//Prüfen ob Session noch aktiv ist
	if($sid!="") {
		$dir = dir(SYSTEM_SESSION_path);
		while($obj = $dir->read()) {
			if($obj!='.' && $obj!='..') {
				if(!is_dir(SYSTEM_SESSION_path.'/'.$obj)) {
					$filenames = split("_",$obj);
					if($filenames[0]==$sid) {
						$sid=$obj;
					}
				}
			}
		}
	}
	
	if($sid=="") {
		//Neue Session anlegen
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
			
			$isnotnewkey=false;
			
			while($obj = $dir->read()) {
				if($obj!='.' && $obj!='..') {
					if(!is_dir(SYSTEM_SESSION_path.'/'.$obj)) {
						$filenames = split("_",$obj);
						if($filenames[0]==$sid) {
							$isnotnewkey=true;
						}
					}
				}
			}
		}
		
		if(isset($_COOKIE["c-test"])) {
			#Setzen wir das Session Cookie
			if(SYSTEM_SESSION_halt>0) {
				setcookie("SID",$sid, $time+SYSTEM_SESSION_halt);
			}
			else {
				setcookie("SID",$sid, 0);
			}
		}
		
		$fp = @fopen(SYSTEM_SESSION_path.$sid . "_" . $time . "_" . $date . ".sid","w");
		if($fp) {
			fclose($fp);
		}
	}
	else {
		//Session laden
		$fp = @fopen(SYSTEM_SESSION_path.$sid,"r");
		if($fp) {
			while($line=fgets($fp)) {
				$linsplit = explode('|##|',$line);
				for($i=0;$i<count($linsplit);$i++) {
					$txtsplit = explode('|#|',$linsplit[$i]);
					$_SESSION[$txtsplit[0]]=$txtsplit[1];
				}
			}
			fclose($fp);
		}
		$sida = split("_",$sid);
		$sid=$sida[0];
	}
	define ("SID", $sid);
}

function sstopSession() {
	$dir 	   = dir(SYSTEM_SESSION_path);
	$sname     = "";
	while($obj = $dir->read()) {
		if($obj!='.' && $obj!='..') {
			if(!is_dir(SYSTEM_SESSION_path.'/'.$obj)) {
				$filenames = split("_",$obj);
				if($filenames[0]==SID) {
					unlink(SYSTEM_SESSION_path.$obj);
					$sname = $obj;
				}
			}
		}
	}
	$date   = date("Y-m-d");
	
	
	$fp = @fopen(SYSTEM_SESSION_path.SID . "_" . time() . "_" . $date . ".sid","w");
	if($fp) {
		foreach ($_SESSION as $key => $value) {
			fputs($fp,$key.'|#|'.$value.'|##|');
		}
		fclose($fp);
	}
}
	