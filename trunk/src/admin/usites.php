<?php
$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/admin/usites.tpl");
$mtpl->assign('IMAGE_PATH',SYSTEM_STYLE_PATH . $_SESSION["style"] . "/" . SYSTEM_STYLE_IMAGE_PATH ."admin");

if(isset($_GET["delsite"])||isset($_POST["delsite"])) {
	if(isset($_GET["delsite"])) $delid = $_GET["delsite"];
	else						$delid = $_POST["delsite"];
	
	if(!isset($_GET["del"])&&!isset($_POST["del"])) {
		$mtpl->assign('DELID',$delid);
	}
	else {
		#lösch aktion ausführen
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(!file_exists(SYSTEM_USERSITESF . $delid . ".site")) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Konnte die Seite \"$delid.site\" nicht finden."));
			}
			else {
				if(!unlink(SYSTEM_USERSITESF . $delid. ".site")) {
					$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Konnte die Seite \"$delid.site\" nicht löschen."));
				}
				else {
					$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Die Seite \"$delid.site\" wurde erfolgreich gelöscht."));
				}
			}
		}
	}
}
else if(isset($_GET["newsite"])||isset($_POST["newsite"])) {
	if(!isset($_GET["new"])&&!isset($_POST["new"])&&!isset($_POST["vschc"])) {
		$editor = "";
		$fp = fopen(SYSTEM_ADMIN_editor,"r");
		while($line = fgets($fp)) {
			$editor .= str_replace("{CONTENT}","",trim($line));
		}
		fclose($fp);
		
		$mtpl->assign('EDITOR',$editor);
	}
	else if(isset($_POST["vschc"])) {
		$sitename    = str_replace(' ','_',$_POST['newsite']) . '.site';
		$sitecontent = $_POST['content'];
		
		$mtpl->assign("CONTENT",Sonderzeichen(bbcode($sitecontent)));
		
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(file_exists(SYSTEM_USERSITESF . $sitename)) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Die Seite \"$sitename\" existiert schon."));
			}
			$mtpl->assign('SITENAME',$sitename);
			$mtpl->assign('SNAME',str_replace('.site','',$sitename));
				
			$editor = "";
			$fp = fopen(SYSTEM_ADMIN_editor,"r");
			while($line = fgets($fp)) {
				$editor .= str_replace("{CONTENT}",$content,trim($line));
			}
			fclose($fp);
				
			$mtpl->assign('EDITOR',$editor);
		}
	}
	else {
		$sitename    = str_replace(' ','_',$_POST['newsite']) . '.site';
		$sitecontent = $_POST['content'];
		
		#create aktion ausführen
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(file_exists(SYSTEM_USERSITESF . $sitename)) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Die Seite \"$sitename\" existiert schon."));
			}
			else {
				$fp = @fopen(SYSTEM_USERSITESF . '/' . $sitename,"w");
				if(!$fp) {
					$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Konnte Seite \"$sitename\" nicht erzeugen."));
				}
				else {
					fputs($fp,$sitecontent);
					fclose($fp);
					$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Seite \"$sitename\" erfolgreich erzeugt."));
				}
			}
		}
	}
}


else if(isset($_GET["editsite"])||isset($_POST["editsite"])) {
	if(isset($_GET["editsite"])) $editid = $_GET["editsite"];
	else						 $editid = $_POST["editsite"];
	if(!isset($_GET["edit"])&&!isset($_POST["edit"])&&!isset($_POST["vsch"])) {
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(!file_exists(SYSTEM_USERSITESF . $editid . ".site")) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Die Seite \"$editid\" existiert nicht."));
			}
			else {
				$mtpl->assign('SITENAME',$editid.".site");
				$mtpl->assign('SNAME',$editid);
				
				$content = "";
				$fp = fopen(SYSTEM_USERSITESF . $editid . ".site","r");
				while($line = fgets($fp)) {
					$content .= trim($line) . "\n";
				}
				fclose($fp);
				
				$editor = "";
				$fp = fopen(SYSTEM_ADMIN_editor,"r");
				while($line = fgets($fp)) {
					$editor .= str_replace("{CONTENT}",$content,trim($line));
				}
				fclose($fp);
				
				$mtpl->assign('EDITOR',$editor);
			}
		}
	}
	else if(isset($_POST["vsch"])) {
		$sitecontent = $_POST['content'];
		$mtpl->assign("CONTENT",Sonderzeichen(bbcode($sitecontent)));
		
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(!file_exists(SYSTEM_USERSITESF . $editid)) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Die Seite \"$editid\" existiert nicht."));
			}
			else {
				$mtpl->assign('SITENAME',$editid.".site");
				$mtpl->assign('SNAME',$editid);
				
				$editor = "";
				$fp = fopen(SYSTEM_ADMIN_editor,"r");
				while($line = fgets($fp)) {
					$editor .= str_replace("{CONTENT}",$content,trim($line));
				}
				fclose($fp);
				
				$mtpl->assign('EDITOR',$editor);
			}
		}
	}
	else {
		$sitecontent = $_POST['content'];
		
		#create aktion ausführen
		if(SYSTEM_USERSITESM==1) {
			#mysqlmod
		}
		else {
			if(!file_exists(SYSTEM_USERSITESF . $editid . ".site")) {
				$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Die Seite \"$editid\" existiert nicht."));
			}
			else {
				$fp = @fopen(SYSTEM_USERSITESF . $editid . ".site","w");
				if(!$fp) {
					$mtpl->TextBlock("ERROR",array("ERRMSG"),array("Konnte Seite \"$editid\" nicht bearbeiten."));
				}
				else {
					fputs($fp,$sitecontent);
					fclose($fp);
					$mtpl->TextBlock("SUCCES",array("SUCCESMSG"),array("Seite \"$editid\" erfolgreich bearbeitet."));
				}
			}
		}
	}
}

if(SYSTEM_USERSITESM==1) {
	#mysqlmod
}
else {
	$i = 0;
	$dir = dir(SYSTEM_USERSITESF);

	while($obj = $dir->read()) {
		if($obj!='.' && $obj!='..') {
			if(!is_dir(SYSTEM_USERSITESF . $obj)) {
				$i++;
				$mtpl->TextRepeater("LIST",array("USID","USNAME","USFILE"),
										   array($i,ucfirst(str_replace(".site","",$obj)),$obj));
			}
		}
	}
	
	$mtpl->clearList("LIST");
}
$mtpl->clearList("ERROR");
$mtpl->clearList("SUCCES");
$mtpl->clearList("PREV");
$mtpl->out();
?>