<html>
	<head>
		<title>Regiestrierung best&auml;tigen</title>
		<META http-equiv='refresh' content='5;URL=../main.php'>
	</head>
	<body>
		<h1>Regiestirerung Best&auml;tigen</h1>
		<?php
			if(!isset($_GET["id"])) die ("<p>Kein Best&auml;tigungs Key &Uuml;bergeben</p>");
			
			$rkey = mysql_real_escape_string($_GET["id"]);
			
			if($rkey=="") die ("<p>Der Best&auml;tigungs Key ist leer.</p>");
			
			$db = new db();
			
			$res = $db->query("SELECT * FROM " . SYSTEM_dbpref . "users WHERE rkey='$rkey'");
			if($db->count($res)<=0) die ("<p>Konnte keinen User mit diesem Best&auml;tigungs Link finden.</p>");
			
			$db->query("UPDATE " . SYSTEM_dbpref . "users SET rkey='' WHERE rkey='$rkey'");
			
			die ("<p>Sie wurden erfolgreich freigeschalten.</p>");
		?>
		
		<p>Sie werden automaitsch in 5 Sekunden auf die Home seite umgeleitet. <a href='../main.php'>Zur&uuml;ck zur Homepage</a></p>
	</body>
</html>