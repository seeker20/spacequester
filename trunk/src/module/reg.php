<?php
$db = new db();
$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/reg.tpl");

if(isset($_GET["reg"])||isset($_POST["reg"])) {
	if(isset($_GET["reg"])) {
		$uname = $_GET["uname"];
		$pass1 = $_GET["pass1"];
		$pass2 = $_GET["pass2"];
		$email = $_GET["email"];
		$rname = $_GET["rname"];
		$gyear = $_GET["gyear"];
		$agb   = $_GET["agb"];
	}
	else {
		$uname = $_POST["uname"];
		$pass1 = $_POST["pass1"];
		$pass2 = $_POST["pass2"];
		$email = $_POST["email"];
		$rname = $_POST["rname"];
		$gyear = $_POST["gyear"];
		$agb   = $_POST["agb"];
	}
	
	$uname = AntiHacker(trim($uname));
	$pass1 = AntiHacker($pass1);
	$pass2 = AntiHacker($pass2);
	$email = AntiHacker(trim($email));
	$rname = AntiHacker(trim($rname));
	$gyear = AntiHacker(trim($gyear));
	$agb   = AntiHacker($agb);
	
	if($uname=="") {
		//Usernamen angeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen einen Usernamen angeben."));
	}
	else if($pass1==""||$pass2=="") {
		//Das Passwort muss eingegeben werden und wiederholt werden
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen ein Passwort eingeben und es wiederholen."));
	}
	else if($pass1!=$pass2) {
		//Sie müssen das Passwort zweimal eingeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen das selbe Passwort zweimal angeben."));
	}
	else if($email=="") {
		//Sie müssen eine Email adresse angeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen eine Email adresse angeben."));
	}
	else if(strtoupper($agb)!="JA") {
		//Sie müssen in das Feld von AGB "JA" eingeben
		$mtpl->TextBlock("ERROR",array("MSG"),array("Sie müssen in das Feld AGB das wort \"JA\" eingeben."));
	}
	else {
		#Hier muss weitergemacht werden
		$pass = md5($pass1);
		$res1 = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE email='$email'");
		$res2 = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE uname='$uname'");
		if($db->count($res1)>0) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Es gibt bereits einen User mit dieser Email adresse."));
		}
		else if($db->count($res2)>0) {
			$mtpl->TextBlock("ERROR",array("MSG"),array("Es gibt bereits einen User mit diesem Usernamen."));
		}
		else {
			$isnkey = false;
			while(!$isnkey) {
				$regkey = random_key(20);
				$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE rkey='$regkey'");
				if($db->count($res1)<=0) $isnkey=true;
			}
			$db->query("INSERT INTO `" . SYSTEM_dbpref . "users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `group`) VALUES (NULL, '$uname', '$pass', '$email', '$rname', '$gyear', '$regkey', '1')");
			$mtpl->TextBlock("SUCCES",array("MSG"),array("Eintrag erfolgreich erstellt. Ihnen wird eine email an \"$email\" gesendet mit einem bestätigungs link. Danach können sie sofort lossurfen."));
			
			$absender = "noreplay@".str_replace("www","",$_SERVER["SERVER_NAME"]);
			$betreff  = "Regiestreirung auf ".$_SERVER["SERVER_NAME"];
			$text     = "Wilkommen bei ".str_replace("www","",$_SERVER["SERVER_NAME"])." $uname,\n\n";
			$text    .= "Ich freue mich das sie sich für meine webseite interesieren. Nadann mal los du brauchst nur noch\n";
			$text    .= "einen link anklicken und dann kannst du loslegen. EInfach folgenden Link anklicken oder im\n";
			$text	 .= "Browser aufrufen. http://".$_SERVER["SERVER_NAME"].str_replace("main.php","", $_SERVER["PHP_SELF"])."services/regconf.php?id=$regkey \n";
			$text	 .= "Danach einfach einloggen und lossurfen. \n\n";
			$text 	 .= "Viel Spaß wünscht ihnen ihr,\n";
			$text	 .= str_replace("www","",$_SERVER["SERVER_NAME"])." Team.";
			
			echo "<hr>".str_replace("\n","<br>",$text)."<hr>";
			if(!mail($email,$betreff,$text,"From: $absender")) {
				$mtpl->TextBlock("ERROR",array("MSG"),array("Konnte Email nicht verschicken bitte Kontaktirern sie den Administrator unter ".SYSTEM_ADMIN_mail));
			}
		}
	}
	
	$mtpl->clearList("SUCCES");
	$mtpl->clearList("ERROR");
}

$mtpl->out();
?>