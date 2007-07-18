<?php
#PHP-BB Code
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

#bb code
function bbcode($str) {
	#[code] tag speichern
	$bbcodea        =  get_mark($str,"[code]*[/code]");
	
	#[nopars] tag speichern
	$bbnoparsea     = get_mark($str,"[noparse]*[/noparse]");
	
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
		$substr2 		= get_mark($str,"[quote=" . $substr[$i] . "]*[/quote]");
		$bbreplace      = array('[quote=' . $substr[$i] . ']','[/quote]');
		$bbreplacements = array($zitat . "Zitat von <strong>" . $substr[$i] . '</strong><div style="font-style:italic">',$substr2[0]);
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[color=Option]
	$substr 		= get_mark($str,"[color=*]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = array('[color=' . $substr[$i] . ']', '[/color]');
		$bbreplacements = array ('<font color="' . $substr[$i] . '">','</font>');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[size=Option] 
	$substr 		= get_mark($str,"[size=*]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = array('[size=' . $substr[$i] . ']', '[/size]');
		$bbreplacements = array ('<font size="' . $substr[$i] . '">','</font>');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[font=Option]
	$substr 		= get_mark($str,"[font=*]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = array('[font=' . $substr[$i] . ']', '[/font]');
		$bbreplacements = array ('<font face="' . $substr[$i] . '">','</font>');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
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
		$substr2 		= get_mark($str,"[email=" . $substr[$i] . "]*[/email]");
		$bbreplace      = array('[email=' . $substr[$i] . ']','[/email]');
		$bbreplacements = array('<a href="mailto:' . $substr[$i] . '">',$substr2[0] . '">');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	#[url]
	$substr 				= get_mark($str,"[url]*[/url]");
	for($i=0;$i < count($substr);$i++) {
		$bbreplace      = array('[url]' . $substr[$i],'[/url]');
		$bbreplacements = array('<a target="_blank" href="' . $substr[$i] . '">' . $substr[$i],'</a>');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	$bbreplace      = '[/url]';
	$bbreplacements = '</a>';
	$str = str_replace($bbreplace,$bbreplacements,$str);
	#[url=Option]
	$substr 			= get_mark($str,"[url=*]");
	for($i=0;$i < count($substr);$i++) {
		$substr2 		= get_mark($str,"[url=" . $substr[$i] . "]*[/url]");
		$bbreplace      = array('[url=' . $substr[$i] . ']' . $substr2[0],'[/url]');
		$bbreplacements = array('<a target="_blank" href="' . $substr[$i] . '">' . $substr2[0],'</a>');
		$str = str_replace($bbreplace,$bbreplacements,$str);
	}
	
	#bbcode die code zeichen in HTML umwandeln und dan wieder ersetezn
	for($i=0;$i < count($bbcodea);$i++) {
		$bbreplace      = array("&","\\","<",">","\n","\t");
		$bbreplacements = array("&amp;","&quot;","&lt;","&gt;","<br />","A");
		$bbcodea[$i]=str_replace($bbreplace,$bbreplacements,$bbcodea[$i]);
	}
	$bbcodea2 = get_mark($str,"[code]*[/code]");
	
	$str = str_replace($bbcodea2,$bbcodea,$str);
	$str = str_replace("[code]",'<div style="margin:20px; margin-top:5px"><div style="margin-bottom:2px;font: 11px verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif;" align="left">Code:</div><pre dir="ltr" style="margin: 0px;padding: 6px;border: 1px inset;width: auto;height: 98px;text-align: left;overflow: auto;background: #E1E4F2;color: #000000;">'."\n",$str);
	$str = str_replace("[/code]","</pre></div>\n",$str);
	
	#noparse einfügen
	$bbnoparsea2 = get_mark($str,"[noparse]*[/noparse]");
	$str       = str_replace($bbnoparsea2,$bbnoparsea,$str);
	$str 	   = str_replace("[noparse]","",$str);
	$str 	   = str_replace("[/noparse]","",$str);
	
	
	return $str;
}
?>