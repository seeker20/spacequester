<?php
#PHP-Code asuführen zur laufzeit
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

#PHP zur aluifzeit ausführen
function phpWrapper($content) {
	ob_start();
	$content = str_replace('<'.'?php','<'.'?',$content);
	eval('?'.'>'.trim($content).'<'.'?');
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
?>