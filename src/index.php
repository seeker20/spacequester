<?php
setcookie("c-test","1",time()+180);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META NAME="author" CONTENT="Florian Krauthan">
<META NAME="expires" CONTENT="NEVER">
<META NAME="publisher" CONTENT="Florian Krauthan">
<META NAME="copyright" CONTENT="Florian Krauthan">
<META NAME="page-topic" CONTENT="Computer/Software/Spiele">
<META http-equiv="Content-Language" content="de">
<META NAME="keywords" CONTENT="Computer, PHP, Forum, Chat, fkrauthan, spiele, G&auml;stebuch, Downloads, Homepage, Florian, Krauthan, community">
<META NAME="description" CONTENT="Auf dieser Seite werde ich alle Projekte die ich im laufe der zeit programmeiren werde ausstellen auserdem gibt es ein Forum und eine Chat zum austauschen unter den Meidgleidern. Ich werde versuchen eine solide community aufzubauen.">
<META NAME="page-type" CONTENT="Private Homepage">
<META NAME="audience" CONTENT="Alle">
<META NAME="robots" CONTENT="INDEX,FOLLOW">
<?php
echo '<META http-equiv="refresh" content="0;URL=./root/main.php?newstart=1';
if(isset($_GET["target"])) {
	echo "&target=" . $_GET["target"];
}
echo '">';
?>
<title>SpaceQuester</title>

</head>
<script language="JavaScript">
<!--
<?php
echo "location.href='./root/main.php?j=1&newstart=1";
if(isset($_GET["target"])) {
	echo "&target=" . $_GET["target"];
}
echo "';";
?>
//-->
</script>

<body>
<h1>Wilkommen auf meiner Homepage</h1>
<p>Auf dieser setie wierd geschaut was ihr Browser alles unterstzt.</p>
<p>Falls es nicht weitergehen sollte klicken sie bitte 
<?php
echo "<a href='./root/main.php?newstart=1";
if(isset($_GET["target"])) {
	echo "&target=" . $_GET["target"];
}
echo "'>hier.</a></p>";
?>

</body>
</html>