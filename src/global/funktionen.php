<?php

require ("config.php");

/*function weiterleiten($goes)
 {
 	echo "<html>\n";
 	echo "<head>\n";
 	echo "<meta http-equiv=\"refresh\" content=\"5; $goes\">\n";
 	echo "</head>\n";
 	echo "<body>\n";
 	echo "<center>\n";
 	echo "<p>Sie werden in 5 sekunden weiter geleitet, falls die weiterleitung nicht funktioniert<br> klicken Sie <a href=\"$goes\" target=\"_self\">hier</a></p>\n";
 	echo "</center>\n";
 	echo "</body>\n";
 	echo "</html>\n";
 }
*/

function generate_code($input)
{
	$date = date("dmYHis");
	$wort = strlen($input);
	$key  = $date + $wort;
	$key  = md5($key);
	$nwo  = sha1($wort);
	$nda  = sha1($date);

	$schluessel = $nwo.$key.$nda;
	return $schluessel;
}

function sry()
{
	echo "Sorry Sie koennen sich nicht mehr registrieren";
	exit();
}

function no_spammail($mail='') {
	// these vars replace the @s and dots
	$ats = "<span>@</span>";
	$dots = "<span>.</span>";

  $str = "";         
  $a = unpack("C*", $mail);
  foreach ($a as $b)
  	$str .= sprintf("%%%X", $b);
    $enc_mail = str_replace("@",$ats,$mail);
    $enc_mail = str_replace(".",$dots,$enc_mail);
    //here the link is rendered
    $str = "<a href=\"mailto:" . $str . "\">" . $enc_mail . "</a>";
	return $str;
} 

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


#bb-code
#bb code test function
function bbcodetest($str) {
	#grund test
	#[b] [i] [u] [left] [right] [center] [indent] [list] [img]
	$t1 = array('[b]','[i]','[u]','[left]','[right]','[center]','[indent]','[list]','[img]');
	$t2 = array('[/b]','[/i]','[/u]','[/left]','[/right]','[/center]','[/indent]','[/list]','[/img]');
	for($i=0;	$i < count($t1);$i++) {
		$arrResult1=substr_count($str,$t1[$i]);
		$arrResult2=substr_count($str,$t2[$i]);
		if($arrResult1!=$arrResult2) {
			return false;
		}
	}
	
	#[color] [size] [font]
	$t1 = array('[color','[size','[font');
	$t2 = array('[/color]','[/size]','[/font]');
	for($i=0;	$i < count($t1);$i++) {
		$arrResult1=substr_count($str,$t1[$i]);
		$arrResult2=substr_count($str,$t2[$i]);
		if($arrResult1!=$arrResult2) {
			return false;
		}
	}
	
	#[email] [url] [quote] [thread] [post]
	$t1 = array('[email=','[email]','[url=','[url]');
	$t2 = array('[/email]','[/url]','[/quote]');
	
	for($i=0;	$i < count($t1);) {
		$arrResult1 =substr_count($str,$t1[$i]);
		$arrResult1+=substr_count($str,$t1[$i+1]);
		$arrResult2=substr_count($str,$t2[$i/2]);
	
		if($arrResult1!=$arrResult2) {
			return false;
		}
		$i+=2;
	}
	
	$arrResult1 =substr_count($str,"[");
	$arrResult2 =substr_count($str,"]");
	if($arrResult1!=$arrResult2) {
		return false;
	}
	
	#tag para sicherheit
	$t1 = array('[email=','[url=','[quote=','[thread=','[post=');
	for($i=0;$i< count($t1);$i++) {
		if(substr_count($str,$t1[$i] . "["))
			return false;
		else if(substr_count($str,$t1[$i] . "]"))
			return false;
	}
	
	return true;
}

#fgt die sonderzeichen codes ein
function Sonderzeichen($string) {
	#��	$string = str_replace("�,"&ouml;",$string);
	$string = str_replace("�","&Ouml;",$string);
		
	#�
	$string = str_replace("","&uuml;",$string);
	$string = str_replace("�","&Uuml;",$string);
		
	#��	$string = str_replace("�,"&auml;",$string);
	$string = str_replace("�","&Auml;",$string);
	
	return $string;
}
	
#bb code
function bbcode($str) {
	#bb-code testen
	if(!bbcodetest($str)) {
		return "<p>BB-Code falsch dieser eintrag kann nicht angezeigt werden.</p>";
	}
	
	#[b] [i] [u]
	$bbreplace      = array('[b]','[/b]','[i]','[/i]','[u]','[/u]');
	$bbreplacements = array ('<b>','</b>','<i>','</i>','<u>','</u>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[left][right][center]
	$bbreplace      = array('[left]', '[/left]', '[right]', '[/right]', '[center]', '[/center]');
	$bbreplacements = array ('<div align="left">','</div>','<div align="right">','</div>','<div align="center">','</div>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[indent]
	$bbreplace      = array('[indent]', '[/indent]');
	$bbreplacements = array ('<blockquote>','</blockquote>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[list]
	$bbreplace      = array('[list]', '[/list]', '[*]');
	$bbreplacements = array ('<ul>','</ul>','<li>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[img]
	$bbreplace      = array('[img]', '[/img]');
	$bbreplacements = array ('<img border="0" alt="picture" src="','">');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[quote]
	$zitat          = '<div style="margin:20px; margin-top:5px; "><div style="margin-bottom:2px"><font size="-1">Zitat:</font></div><table cellpadding="6" cellspacing="0" border="0" width="100%"><tr><td class="alt2" style="border:1px inset"><div style="font-style:italic">';
	$zitat2         = '</div></td></tr></table></div>';
	$bbreplace      = array('[quote]', '[/quote]');
	$bbreplacements = array ($zitat . "<div>", $zitat2);
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[quote=Option]
	$zitat          = '<div style="margin:20px; margin-top:5px; "><div style="margin-bottom:2px"><font size="-1">Zitat:</font></div><table cellpadding="6" cellspacing="0" border="0" width="100%"><tr><td class="alt2" style="border:1px inset">';
	$substr 				= get_mark($str,"[quote=*]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = '[quote=' . $substr[$i] . ']';
		$bbreplacements = $zitat . "Zitat von <strong>" . $substr[$i] . '</strong><div style="font-style:italic">';
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[color=Option]
	$bbreplace      = array('[color=', '[/color]');
	$bbreplacements = array ('<font color="','</font>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[size=Option] klappt noch nicht
	$bbreplace      = array('[size=', '[/size]');
	$bbreplacements = array ('<font size="','</font>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[font=Option]
	$bbreplace      = array('[font=', '[/font]');
	$bbreplacements = array ('<font face="','</font>');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[email]
	$substr 				= get_mark($str,"[email]*[/email]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = '[email]' . $substr[$i];
		$bbreplacements = '<a href="mailto:' . $substr[$i] . '">' . $substr[$i];
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	$bbreplace      = '[/email]';
	$bbreplacements = '</a>';
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[email=Option]
	$substr 				= get_mark($str,"[email=*]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = '[email=' . $substr[$i] . ']';
		$bbreplacements = '<a href="mailto:' . $substr[$i] . '">';
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[url]
	$substr 				= get_mark($str,"[url]*[/url]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = '[url]' . $substr[$i];
		$bbreplacements = '<a target="_blank" href="' . $substr[$i] . '">' . $substr[$i];
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	$bbreplace      = '[/url]';
	$bbreplacements = '</a>';
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[url=Option]
	$bbreplace      = '[url=';
	$bbreplacements = '<a target="_blank" href="';
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#klammern schliesen
	$bbreplace      = array(']');
	$bbreplacements = array ('">');
	$str = str_replace($bbreplace,$bbreplacements,$str);
	
	return str_replace("\n","<br>",Sonderzeichen($str));
}

?>
