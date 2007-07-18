<?php
#Hilfe Tools fürs CMS
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

#Kopiert ein File
function copy_file($src,$target) {
	copy($src,$target);
	unlink($src);
}

#Erzeugt eine Zufallszahl
function random_number($start,$end) {
	return rand($start,$end);
}

#Erzeugt einen Zufalls Buchstaben erzeugen
function random_char() {
	$keys = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$zuf  = rand(0,strlen($keys));
	return $keys[$zuf];
}

#Erzeugt einen Zufalls String
function random_key($anzst,$keys=true,$numb=true) {
	if(($keys==false&&$numb==false)||$anzst==0) return "";
	srand((double)microtime()*1000000);
	
	$key = "";
	for($n=0; $n<$anzst;$n++) {
		if($keys==true&&$numb==true) {
			$kon = rand(0,1);
			if($kon==0) {
				$key .= random_number(0,9);
			}
			else {
				$key .= random_char();
			}
		}
		else if($keys==true) {
			$key .= random_char();
		}
		else {
			$key .= random_number(0,9);
		}
	}
	
	return $key;
}
?>