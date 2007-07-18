<?php
#Sicherheits funktionen
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

function AntiHacker($str,$html=false) {
	$str = addslashes($str);
	
	if(!$html)
		$str = strip_tags($str);
		
	return trim($str);
}

function ReAntiHacker($str) {
	$str = stripslashes($str);
	
	return trim($str);
}

?>