<?php
#String Manipulatiosn Funktionen
if(!(isset($CMS))) {
	die("kein Zugriffs recht");
}

#String ziwschen 2 zeichen finden
function get_mark($string,$mark) {
	$ausgabe = array();
	$template = explode("*",$mark);
	$mark = $template[0];
	$end = $template[1];
	$string = strstr($string,$mark);

	$temp = explode($mark,$string);
	$a = 1;
	foreach ($temp as $tempx) {
		$tempx = explode($end,$tempx);
		$tempx = $tempx[0];
		if ($tempx) {
			array_push ($ausgabe,$tempx);
		}
	}
	return $ausgabe;
}

#Sonderzeichen ersetzen
function Sonderzeichen($string) {
	#Ö ö
	$string = str_replace("ö","&ouml;",$string);
	$string = str_replace("Ö","&Ouml;",$string);
		
	#Ü ü
	$string = str_replace("ü","&uuml;",$string);
	$string = str_replace("Ü","&Uuml;",$string);
		
	#Ä ä
	$string = str_replace("ä","&auml;",$string);
	$string = str_replace("Ä","&Auml;",$string);
	
	return $string;
}

#Error String ausgeben
function printError($string) {
	echo "<font color='red'>" . Sonderzeichen($string) . "</font>";
}
?>