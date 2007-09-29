<?php
session_start();
define("USER_IP",$_SERVER['REMOTE_ADDR']);

require("../data/funktionen.php");
require("../data/config.php");
require("../data/sql.connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Space Wars</title>
<meta name="description" content="Space Wars Beowsergame" />
<meta name="author" content="damian,niklas" />
<link rel="stylesheet" type="text/css" href="../styles/default.css" />
</head>

<body>
<div id="root">
	
	<div id="banner">
	banner
	</div>

	<div id="menu">
	<?php
		require("menu.php");
	?>
	</div>
		
	<div id="text">
	<?php
		require("inhalt.php");
	?>
	</div>
<br style="clear:both" />
</div>

</body>

</html>

