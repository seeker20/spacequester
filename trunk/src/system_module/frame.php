<?php
include "configs/frame.inc.php";

if(isset($_GET["target"])) {
	$target=$_GET["target"];
	$_SESSION["lastaction"]=1;
	$_SESSION["ltarget"]='';
}
else if(isset($_POST["target"])) {
	$target=$_POST["target"];
	$_SESSION["lastaction"]=1;
	$_SESSION["ltarget"]='';
}
else if($_SESSION["target"]!='') {
	$target=$_SESSION["target"];
}
else {
	$target=SYSTEM_start;
}

if($_SESSION["target"]!=$target) {
	$_SESSION["target"]=$target;
}
$content = "";

if(isset($_GET["starget"])||isset($_POST["starget"])||$_SESSION["lastaction"]==2) {
	#System Bereiche
	$_SESSION["lastaction"]=2;
	
	if(isset($_GET["starget"])) {
		$starget = $_GET["starget"];
		$_SESSION["ltarget"]='';
	}
	else if(isset($_POST["starget"])) {
		$starget = $_POST["starget"];
		$_SESSION["ltarget"]='';
	}
	else if(isset($_SESSION["starget"]))
		$starget = $_SESSION["starget"];
		
	if($_SESSION["starget"]!=$starget) {
		$_SESSION["starget"]=$starget;
	}
	
	if($starget=="") {
		printError("Kein Ziel übergeben.");
	}
	else {
		if(!file_exists(SYSTEM_modul_path . $starget . ".php")) {
			printError("System Seite \"" . $starget . "\" wurde nicht gefunden.");
		} else {
			$dsatz = $db->get($db->query("SELECT * FROM " . SYSTEM_dbpref . "acces WHERE file='".$starget . ".php'"));
			$is    = false;
			if($dsatz["acces_groups"]=="") {
				$is = true;
			}
			else {
				if($_SESSION["acces"]=="") $acces=0;
				else $acces = $_SESSION["acces"];
				
				$split = explode("#",$dsatz["acces_groups"]);
				for($i=0;$i<count($split);$i++) {
					if($acces==$split[$i]) {
						$is=true;
						break;
					}
				}
				
				if(!$is) {
					printError("Sie besitzen nicht das Zugansrecht um die seite \"" . $starget . "\" aufzurufen.");
				}
			}
			if($is) {
				include SYSTEM_modul_path . $starget . ".php";
			}
		}
	}
}
else if(SYSTEM_USERSITESM==1) {
	#mysqlmod
}
else {
	#FileSystemMod
	if(!is_dir(SYSTEM_USERSITESF)) {
		printError("UserSeits Ordner nicht gefunden.");
	}
	else if(!file_exists(SYSTEM_USERSITESF . $target . ".site")) {
		printError("User Seite \"" . $target . "\" wurde nicht gefunden.");
	}
	else {
		$dsatz = $db->get($db->query("SELECT * FROM " . SYSTEM_dbpref . "acces WHERE file='".$target . ".site'"));
		$is    = false;
		if($dsatz["acces_groups"]=="") {
			$is=true;
		}
		else if($_SESSION["acces"]=="") {
			printError("Sie besitzen nicht das Zugansrecht um die seite \"" . $target . "\" aufzurufen.");
		}
		else {
			$split = explode("#",$dsatz["acces_groups"]);
			for($i=0;$i<count($split);$i++) {
				if($_SESSION["acces"]==$split[$i]) {
					$is=true;
					break;
				}
			}
			
			if(!$is) {
				printError("Sie besitzen nicht das Zugansrecht um die seite \"" . $target . "\" aufzurufen.");
			}
		}
		
		if($is) {
			$fp   = fopen(SYSTEM_USERSITESF .$target . ".site","r");
			$content = "";
			while($line=fgets($fp,2000)) {
				$content .= trim($line);
				$content .= "\n";
			}
			fclose($fp);
			
			if($content=="") {
				printError("User Seite \"" . $target . "\" ist leer.");
			}
		}
	}
}

if($content!="") {
	$content = Sonderzeichen($content);
	$content = bbcode($content);
	echo phpWrapper($content);
}
?>