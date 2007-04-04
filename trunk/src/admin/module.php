<?php
function loadNewInstallData($path,$tpl,$isxml,$mod) {
	if($isxml) {
		//Laden der Infos aus der XML
		$fp = fopen($path,"r");
		$in = "";
		while($line=fgets($fp)) {
			$in .= $line;
		}
		fclose($fp);
		
		$plug       = get_mark($in,"<plugin>*</plugin>");
		for($i=0;$i<count($plug);$i++) {
			//Inhalte rausfischen
			$tmp	 	= get_mark($plug[$i],"<head>*</head>");
			$con 		= $tmp[0];
		
			$tmp	 	= get_mark($plug[$i],"<version>*</version>");
			$version 	= $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<name>*</name>");
			$name 	 	= $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<minversion>*</minversion>");
			$minversion = $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<maxversion>*</maxversion>");
			$maxversion = $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<autor>*</autor>");
			$autor 	 	= $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<description>*</description>");
			$description= $tmp[0];
			
			$tmp	 	= get_mark($plug[$i],"<url>*</url>");
			$url		= $tmp[0];
			
			if($mod==1) {
				$tpl->TextRepeater("READYFORINSTALL",array("VERSION","NAME","MINV","MAXV","AUTOR","DESC","URL","ID"),
									array($version,$name,$minversion,$maxversion,$autor,$description,$url,$path));
			}
			else {
				$tpl->TextRepeater("INSTALLT",array("VERSION","NAME","MINV","MAXV","AUTOR","DESC","URL","ID"),
									array($version,$name,$minversion,$maxversion,$autor,$description,$url,$path));
			}
		}
	}
	else {
		//Entpapcken in Temp Ordner und XML Datei erneut einlesen und daten weider löschen
	}
}

function scanDirectory($path,$tpl,$mod) {
	$dir = dir($path);
	
	while($obj = $dir->read()) {
		if($obj!='.' && $obj!='..') {
			if(!is_dir($path . '/'.$obj)) {
				$splitname = explode(".",$obj);
				if($splitname[1]=='modul') {
					//Neues Modul gefunden laden und anzeigen
					if($splitname[2]=='xml') {
						loadNewInstallData($path.$obj,$tpl,true,$mod);
					}
					else {
						loadNewInstallData($path.$obj,$tpl,false,$mod);
					}
				}
			}
			else if($obj[0]!='.'){
				scanDirectory($path.$obj."/",$tpl);
			}
		}
	}
}
$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/admin/module.tpl");
$mtpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin");

//Zu Instalierendes Modul Entfernen
if(isset($_GET["lri"])||isset($_POST["lri"])) {
	if(isset($_GET["lri"])) $lri = $_GET["lri"];
	else $lri = $_POST["lri"];
	
	$fp = fopen($lri,"r");
	$in = "";
	while($line=fgets($fp)) {
		$in .= $line;
	}
	fclose($fp);
	$err = false;	
	
	$err = unlink($lri);
	
	//Erstelle Pfad
	$pathsplit=split("/",$lri);
	$path = "";
	for($i=0;$i<count($pathsplit)-1;$i++) {
		$path .= $pathsplit[$i]."/";
	}
	
	$files = get_mark($in,"<file>*</file>");
	for($i=0;$i<count($files);$i++) {
		$filesplit = get_mark($files[$i],"<src>*</src>");
		$err = unlink($path.$filesplit[0]);
	}
	
	if(!$err) {
		#fehler
		$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Konnte Datei(n) nicht löschen."));
	}
	else {
		#erfolgreich
		$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Löschen erfolgreich."));
	}
}
else if(isset($_GET["inst"])||isset($_POST["inst"])) {
	#Module Instalieren
	if(isset($_GET["inst"])) $inst=$_GET["inst"];
	else $inst=$_POST["inst"];
	
	$fp = fopen($inst,"r");
	$in = "";
	while($line=fgets($fp)) {
		$in .= $line;
	}
	fclose($fp);
	
	$pathsplit=split("/",$inst);
	$path = "";
	for($i=0;$i<count($pathsplit)-1;$i++) {
		$path .= $pathsplit[$i]."/";
	}
	
	$plug = get_mark($in,"<plugin>*</plugin>");
	for($i=0;$i<count($plug);$i++) {
		$datas = get_mark($plug[$i],"<data>*</data>");
		for($i2=0;$i2<count($datas);$i2++) {
			//Zuerst die Daten kopieren
			$files = get_mark($datas[$i2],"<file>*</file>");
			for($i3=0;$i3<count($files);$i3++) {
				$srctmp = get_mark($files[$i3],"<src>*</src>");
				$src    = $srctmp[0];
				
				$targettmp = get_mark($files[$i3],"<target>*</target>");
				$target    = $targettmp[0];
				
				if($target=="USERSITE") {
					//Schaun wie weiter verfahren werden soll
					if(SYSTEM_USERSITESM==1) {
						#mysql modus
					}
					else {
						#Ordner Modus
						copy_file($path.$src,SYSTEM_USERSITESF.$src);
					}
				}
				else {
					if($target=="MODULE") {
						$target=SYSTEM_modul_path;
					}
					else if($target=="SYSTEM_MODULE") {
						$target=SYSTEM_system_path;
					}
					else if($target=="PLUGINS") {
						$target=SYSTEM_plugin_path;
					}
					else if($target=="ADMIN_MODULE") {
						$target=SYSTEM_ADMIN_path."module/";
					}
					else {
						$target=SYSTEM_ADMIN_infosp;
					}
					
					copy_file($path.$src,$target.$src);
				}
			}
			
			#Mysql strukturen
			$sqls = get_mark($datas[$i2],"<sql>*</sql>");
			for($i3=0;$i3<count($sqls);$i3++) {
				$nametmp = get_mark($sqls[$i3],"<name>*</name>");
				$name    = $nametmp[0];
				
				$modustmp = get_mark($sqls[$i3],"<modus>*</modus>");
				$modus    = $modustmp[0];
				
				$sqltmp   = get_mark($sqls[$i3],"<query>*</query>");
				$sql      = $sqltmp[0];
				
				$query = "";
				
				if($modus=="CREATE") {
					$query = "CREATE TABLE `".SYSTEM_dbpref.$name."` (".$sql.")";
				}
				else if($modus=="UPDATE") {
					$query = "UPDATE `".SYSTEM_dbpref.$name."` SET ".$sql;
				}
				else if($modus=="DELETE") {
					$query = "DROP TABLE `".SYSTEM_dbpref.$name."`";
				}
				else if($modus=="INSERT") {
					$query = "INSERT INTO `".SYSTEM_dbpref.$name."` (".$sql.")";
				}
				
				$db->query($query);
			}
		}
	}
	
	if(SYSTEM_ADMIN_infosm==1) {
		#mysql modus
	}
	else {
		$pathsplit=split("/",$inst);
		$filenam  =$pathsplit[count($pathsplit)-1];
		copy_file($inst,SYSTEM_ADMIN_infosp.$filenam);
	}
	
	$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Modul erfolgreich instaliert."));
}
else if(isset($_GET["linst"])||isset($_POST["linst"])) {
	#Instalierte Module löschen
	if(isset($_GET["linst"])) $linst=$_GET["linst"];
	else $linst=$_POST["linst"];
	
	$fp = fopen($linst,"r");
	$in = "";
	while($line=fgets($fp)) {
		$in .= $line;
	}
	fclose($fp);
	
	$pathsplit=split("/",$linst);
	$path = "";
	for($i=0;$i<count($pathsplit)-1;$i++) {
		$path .= $pathsplit[$i]."/";
	}
	
	$plug = get_mark($in,"<plugin>*</plugin>");
	for($i=0;$i<count($plug);$i++) {
		$datas = get_mark($plug[$i],"<data>*</data>");
		for($i2=0;$i2<count($datas);$i2++) {
			//Zuerst die Daten kopieren
			$files = get_mark($datas[$i2],"<file>*</file>");
			for($i3=0;$i3<count($files);$i3++) {
				$srctmp = get_mark($files[$i3],"<src>*</src>");
				$src    = $srctmp[0];
				
				$targettmp = get_mark($files[$i3],"<target>*</target>");
				$target    = $targettmp[0];
				
				if($target=="USERSITE") {
					//Schaun wie weiter verfahren werden soll
					if(SYSTEM_USERSITESM==1) {
						#mysql modus
					}
					else {
						#Ordner Modus
						unlink(SYSTEM_USERSITESF.$src);
					}
				}
				else {
					if($target=="MODULE") {
						$target=SYSTEM_modul_path;
					}
					else if($target=="SYSTEM_MODULE") {
						$target=SYSTEM_system_path;
					}
					else if($target=="PLUGINS") {
						$target=SYSTEM_plugin_path;
					}
					else if($target=="ADMIN_MODULE") {
						$target=SYSTEM_ADMIN_path."module/";
					}
					else {
						$target=SYSTEM_ADMIN_infosp;
					}
					
					unlink($target.$src);
				}
			}
			
			#Mysql strukturen
			$sqls = get_mark($datas[$i2],"<sql>*</sql>");
			for($i3=0;$i3<count($sqls);$i3++) {
				$nametmp = get_mark($sqls[$i3],"<name>*</name>");
				$name    = $nametmp[0];
				
				$modustmp = get_mark($sqls[$i3],"<modus>*</modus>");
				$modus    = $modustmp[0];
				
				$sqltmp   = get_mark($sqls[$i3],"<query>*</query>");
				$sql      = $sqltmp[0];
				
				$query = "";
				
				if($modus=="CREATE") {
					$query = "DROP TABLE `".SYSTEM_dbpref.$name."`";
				}
				
				$db->query($query);
			}
		}
	}
	
	if(SYSTEM_ADMIN_infosm==1) {
		#mysql modus
	}
	else {
		$pathsplit=split("/",$linst);
		$filenam  =$pathsplit[count($pathsplit)-1];
		unlink(SYSTEM_ADMIN_infosp.$filenam);
	}
	
	$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Modul erfolgreich gelöscht."));
}
else if(isset($_GET["deinst"])||isset($_POST["deinst"])) {
	#Module Deinstalieren
	if(isset($_GET["deinst"])) $deinst=$_GET["deinst"];
	else $deinst=$_POST["deinst"];
	
	$fp = fopen($deinst,"r");
	$in = "";
	while($line=fgets($fp)) {
		$in .= $line;
	}
	fclose($fp);
	
	$pathsplit=split("/",$deinst);
	$path = "";
	for($i=0;$i<count($pathsplit)-1;$i++) {
		$path .= $pathsplit[$i]."/";
	}
	
	$plug = get_mark($in,"<plugin>*</plugin>");
	for($i=0;$i<count($plug);$i++) {
		$datas = get_mark($plug[$i],"<data>*</data>");
		for($i2=0;$i2<count($datas);$i2++) {
			//Zuerst die Daten kopieren
			$files = get_mark($datas[$i2],"<file>*</file>");
			for($i3=0;$i3<count($files);$i3++) {
				$srctmp = get_mark($files[$i3],"<src>*</src>");
				$src    = $srctmp[0];
				
				$targettmp = get_mark($files[$i3],"<target>*</target>");
				$target    = $targettmp[0];
				
				if($target=="USERSITE") {
					//Schaun wie weiter verfahren werden soll
					if(SYSTEM_USERSITESM==1) {
						#mysql modus
					}
					else {
						#Ordner Modus
						copy_file(SYSTEM_USERSITESF.$src,SYSTEM_ADMIN_minst.$src);
					}
				}
				else {
					if($target=="MODULE") {
						$target=SYSTEM_modul_path;
					}
					else if($target=="SYSTEM_MODULE") {
						$target=SYSTEM_system_path;
					}
					else if($target=="PLUGINS") {
						$target=SYSTEM_plugin_path;
					}
					else if($target=="ADMIN_MODULE") {
						$target=SYSTEM_ADMIN_path."module/";
					}
					else {
						$target=SYSTEM_ADMIN_infosp;
					}
					
					copy_file($target.$src,SYSTEM_ADMIN_minst.$src);
				}
			}
			
			#Mysql strukturen
			$sqls = get_mark($datas[$i2],"<sql>*</sql>");
			for($i3=0;$i3<count($sqls);$i3++) {
				$nametmp = get_mark($sqls[$i3],"<name>*</name>");
				$name    = $nametmp[0];
				
				$modustmp = get_mark($sqls[$i3],"<modus>*</modus>");
				$modus    = $modustmp[0];
				
				$sqltmp   = get_mark($sqls[$i3],"<query>*</query>");
				$sql      = $sqltmp[0];
				
				$query = "";
				
				if($modus=="CREATE") {
					$query = "DROP TABLE `".SYSTEM_dbpref.$name."`";
				}
				
				$db->query($query);
			}
		}
	}
	
	if(SYSTEM_ADMIN_infosm==1) {
		#mysql modus
	}
	else {
		$pathsplit=split("/",$deinst);
		$filenam  =$pathsplit[count($pathsplit)-1];
		copy_file(SYSTEM_ADMIN_infosp.$filenam,SYSTEM_ADMIN_minst.$filenam);
	}
	
	$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Modul erfolgreich deinstaliert."));
}
else if(isset($_GET["conf"])||isset($_POST["conf"])) {
	if(isset($_GET["conf"])) $conf=$_GET["conf"];
	else $conf=$_POST["conf"];
	
	$fp = fopen($conf,"r");
	$in = "";
	while($line=fgets($fp)) {
		$in .= $line;
	}
	fclose($fp);
	
	$admintmp = get_mark($in,"<admin>*</admin>");
	$admin    = $admintmp[0];
	
	$filetmp  = get_mark($admin,"<file>*</file>");
	$file	  = $filetmp[0];
	
	if($file=="") {
		$mtpl->TextBlock("CONFIG",array("CONTENT","ID"),array("Kein Admin Modul verfügbar.",$conf));
	}
	else {
		$mtpl->TextBlock("CONFIG",array("CONTENT","ID"),array(ReadTplFile(SYSTEM_ADMIN_path."module/".$file),$conf));
	}
}

//Nach schaun ob es neue Packete zum Instalieren gibt und diese Im richtigen Feld anzeigen
scanDirectory(SYSTEM_ADMIN_minst,$mtpl,1);
scanDirectory(SYSTEM_ADMIN_infosp,$mtpl,2);


$mtpl->clearList("ERROR");
$mtpl->clearList("SUCCES");

$mtpl->clearList("READYFORINSTALL");
$mtpl->clearList("INSTALLT");
$mtpl->clearList("CONFIG");

$mtpl->out();
?>
