<?php
session_start();

include "../global/funktionen.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="author" CONTENT="Florian Krauthan">
<META NAME="publisher" CONTENT="Florian Krauthan">
<META NAME="description" CONTENT="Meine Homepage zum Vorstellen meiner Projekte.">
<META NAME="language" CONTENT="de">
<META NAME="keywords" CONTENT="Flosoft, fkrauthan, Projekte, Downloads, Homepage, Spiele, Florian, Krauthan, Website, flosoft-online">
<META NAME="robots" CONTENT="index">
<META NAME="page-topic" CONTENT="computer, kinder, spiel, sonstiges">
<META NAME="audience" CONTENT="alle">
<META NAME="page-typ" CONTENT="anleitung, faq, private homepage, produktinfo, software, download">
<META NAME="revisit-after" CONTENT="01 month">
<META NAME="generator" CONTENT="Meta Tag Generator 2003">
<title>BB-Codes</title>

<?php
	echo '<link type="text/css" rel="stylesheet" href="../daten/styles/' . $_SESSION["UserStyle"] . '/game.css">';
?>

<?php 
if(isset($_GET["m"])) {
	if($_GET["m"] != 1) {
		echo '<script type="text/javascript" language="JavaScript" src="daten/js/utils.js"></script>';
	}
}
?>
</head>

<body class='maincolor'>
<h1 align='center'>BB-Codes</h1>

<?php

if(!(isset($_GET["m"]))) {
	$m=1;
}
else {
	$m=$_GET["m"];
}
?>

<table border='0' class='smallborder' cellspacing='0' cellpadding='2'>
	<tr>
		<th class='hsmallborder' width='20%'>BB-Code</th><th class='hsmallborder' width='40%'>Beispiel</th><th class='hsmallborder' width='40%'>Effect</th>
	</tr>
	<tr>
		<td class='hsmallborder'>[b]Text[/b]<br>[i]Text[/i]<br>[u]Text[/u]</td>
		<td class='hsmallborder'>[b]dieser Text ist fett[/b]<br>[i]dieser Text ist kursiv[/i]<br>[u]dieser Text ist unterstrichen[/u]</td>
		<td class='hsmallborder'><?php echo bbcode("[b]dieser Text ist fett[/b]") . "<br>" . bbcode("[i]dieser Text ist kursiv[/i]") . "<br>" . bbcode("[u]dieser Text ist unterstrichen[/u]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[color=Option]Text[/color]</td>
		<td class='hsmallborder'>[color=blue]dieser Text ist blau[/color]</td>
		<td class='hsmallborder'><?php echo bbcode("[color=blue]dieser Text ist blau[/color]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[size=Option]Text[/size]</td>
		<td class='hsmallborder'>[size=+2]dieser Text ist zwei Größen größer als normal[/size]</td>
		<td class='hsmallborder'><?php echo bbcode("[size=+2]dieser Text ist zwei Größen größer als normal[/size]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[font=Option]Text[/font]</td>
		<td class='hsmallborder'>[font=courier]dieser Text verwendet die Courier-Schriftart[/font]</td>
		<td class='hsmallborder'><?php echo bbcode("[font=courier]dieser Text verwendet die Courier-Schriftart[/font]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[left]Text[/left]<br>[center]Text[/center]<br>[right]Text[/right]</td>
		<td class='hsmallborder'>[left]linksbündig[/left]<br>[center]zentriert[/center]<br>[right]rechtsbündig[/right]</td>
		<td class='hsmallborder'><?php echo bbcode("[left]linksbündig[/left]") . "<br>" . bbcode("[center]zentriert[/center]") . "<br>" . bbcode("[right]rechtsbündig[/right]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[indent]Text[/indent]</td>
		<td class='hsmallborder'>[indent]dieser Text ist eingerückt[/indent]</td>
		<td class='hsmallborder'><?php echo bbcode("[indent]dieser Text ist eingerückt[/indent]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[email]Text[/email]<br>[email=Option]Text[/email]</td>
		<td class='hsmallborder'>[email]myname@domain.com[/email]<br>[email=myname@domain.com]Schreib mir eine E-Mail[/email]</td>
		<td class='hsmallborder'><?php echo bbcode("[email]myname@domain.com[/email]") . "<br>" . bbcode("[email=myname@domain.com]Schreib mir eine E-Mail[/email]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[url]Text[/url]<br>[url=Option]Text[/url]</td>
		<td class='hsmallborder'>[url]http://www.fkrauthan.de[/url]<br>[url=http://www.fkrauthan.de]fkrauthan.de[/url]</td>
		<td class='hsmallborder'><?php echo bbcode("[url]http://www.fkrauthan.de[/url]") . "<br>" . bbcode("[url=http://www.fkrauthan.de]fkrauthan.de[/url]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[list]Text[/list]</td>
		<td class='hsmallborder'>[list]<br>[*]erster Eintrag<br>[*]zweiter Eintrag<br>[/list]</td>
		<td class='hsmallborder'><?php echo bbcode("[list][*]erster Eintrag[*]zweiter Eintrag[/list]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[quote]Zitat[/quote]<br>[quote=Benutzername]Text[/quote]</td>
		<td class='hsmallborder'>[quote]fkrauthan[/quote]<br>[quote=Florian Krauthan]fkrauthan[/quote]</td>
		<td class='hsmallborder'><?php echo bbcode("[quote]fkrauthan[/quote]") . "<br>" . bbcode("[quote=Florian Krauthan]fkrauthan[/quote]"); ?> </td>
	</tr>
	<tr>
		<td class='hsmallborder'>[img]Text[/img]</td>
		<td class='hsmallborder'>[img]daten/pics/imgexampel.png[/img]</td>
		<td class='hsmallborder'><?php echo bbcode("[img]imgexampel.png[/img]"); ?></ts>
	</tr>
</table>

<?php
if($m!=1) {
	echo "<hr>";
	
	echo "<p align='center'><a href='#' OnClick='JavaScript:window.close();'>Schliesen</a></p>";
}
?>
</body>
</html>