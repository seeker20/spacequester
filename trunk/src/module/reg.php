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
	
	$uname = mysql_real_escape_string(trim($uname));
	$pass1 = trim($pass1);
	$pass2 = trim($pass2);
	$email = mysql_real_escape_string(trim($email));
	$rname = mysql_real_escape_string(trim($rname));
	$gyear = mysql_real_escape_string(trim($gyear));
	$agb   = trim($agb);
	
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
			$db->query("INSERT INTO `s1_users` (`id`, `uname`, `pass`, `email`, `rname`, `gyear`, `rkey`, `class`, `group`) VALUES (NULL, '$uname', '$pass', '$email', '$rname', '$gyear', '$regkey', '', '1')");
			$mtpl->TextBlock("SUCCES",array("MSG"),array("Eintrag erfolgreich erstellt. Ihnen wird eine email an \"$email\" gesendet mit einem bestätigungs link. Danach können sie sofort loslegen und in die Tiefen des Universums vordringen."));
			
			$absender = "noreplay@fkrauthan.de";
			$betreff  = "Regiestreirung bei SpaceQuester";
			$text     = "Wilkommen bei SpaceQuester $uname,\n\n";
			$text    .= "Du scheinst dich für das Browsergame SpaceQuester zu interesieren. Nadann mal los du bruachst nur noch\n";
			$text    .= "einen link anklicken und dann kannst du loslegen. EInfach folgenden Link anklicken oder im\n";
			$text	 .= "Browser aufrufen. http://".$_SERVER["SERVER_NAME"].str_replace("main.php","", $_SERVER["PHP_SELF"])."regconf.php?id=$regkey \n";
			$text	 .= "Danach können sie sich einloggen eine Klasse auswählen und sofort loslegen. \n\n";
			$text 	 .= "Viel Spaß wünscht ihnen ihr,\n";
			$text	 .= "SpaceQuester Team.";
			
			echo $text;
			if(!mail($email,$betreff,$text,"From: $absender")) {
				$mtpl->TextBlock("ERROR",array("MSG"),array("Konnte Email nicht verschicken bitte Kontaktirern sie den Administrator unter webmaster@fkrauthan.de."));
			}
		}
	}
	
	$mtpl->clearList("SUCCES");
	$mtpl->clearList("ERROR");
}

$mtpl->out();
?>