<!doctype html public \"-//W3C//DTD HTML 4.0 //EN\">
<html>
<head>
<title>Init Site...</title>
<?php
	setcookie("c-test","1",time()+120);
	
	echo "<META http-equiv='refresh' content='0;URL=main.php?init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "'>\n";
?>
<script language="JavaScript" type="text/javascript">
<!--
<?php
	echo "location.href='main.php?j=1&init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "';\n";
?>
//-->
</script>
</head>
<body>
<?php
	echo "<p><a href='main.php?init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "'>Init...</a></p>";
?>
</body>
</html>