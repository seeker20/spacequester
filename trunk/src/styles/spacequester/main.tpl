<!doctype html public \"-//W3C//DTD HTML 4.0 //EN\">
<html>
<head>
<title>{TITLE}</title>
<link type="text/css" rel="stylesheet" href="{styleroot}/main.css">
</head>
<body>
<div id='doppelframe1' align='center'>
	<div class='leftElement'>
		<img src='Logo.jpg' alt='Kein Logo verfügbar'>
	</div>
	<div class='rightElemnt'>
		<?php if(!isset($_SESSION["login"])||$_SESSION["login"]=="") { ?>
			<h1>{TITLE}</h1>
		<?php } else { ?>
			{FELD_4}
		<?php } ?>
	</div>
</div>
<div class='middelElemnt'>
	&nbsp;{FELD_1}
</div>
<div id='doppelframe2' align='center'>
	<div class='leftElement' style='overflow:auto;'>
		<?php if(!isset($_SESSION["login"])||$_SESSION["login"]=="") { ?>
			{FELD_2}
		<?php } else { ?>
			{FELD_5}
		<?php } ?>
	</div>
	<div class='rightElemnt' style='overflow:auto;'>
		{FELD_3}
	</div>
</div>
<div class='middelElemnt' align='center'>
	{PRODUKTION}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.fkrauthan.de' target='_blank'>{PRODUKTNAME}</a> {VERSION}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='main.php?starget=admin'>{AUTOR}</a>
</div>
</body>
</html>