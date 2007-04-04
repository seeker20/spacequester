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
	#� �
	$string = str_replace("�","&ouml;",$string);
	$string = str_replace("�","&Ouml;",$string);
		
	#� �
	$string = str_replace("�","&uuml;",$string);
	$string = str_replace("�","&Uuml;",$string);
		
	#� �
	$string = str_replace("�","&auml;",$string);
	$string = str_replace("�","&Auml;",$string);
	
	return $string;
}

#Error String ausgeben
function printError($string) {
	echo "<font color='red'>" . Sonderzeichen($string) . "</font>";
}
?>