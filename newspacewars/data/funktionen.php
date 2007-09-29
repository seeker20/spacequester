<?php

function fehler($skript, $code)
{
	$code_color = array("0xdb001" => "color: red;");
	echo "
	<html>
	<head>
		<title>BlueScreen</title>
	</head>
	<body bgcolor=blue text=white>
	<pre>
	
	Es trat beim aufruf <?=$skript;?> folgende Fehlermeldung auf: <?=code;?>

	* Probieren Sie es sp&auml;ter erneut
	* Falls diese Fehler geh&auml;ft auftreten sollte, melden Sie es den Admin

	</pre>
	</body>
	</html>

	";
}
