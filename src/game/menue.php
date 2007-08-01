<h3>Navigation</h3>
<div id="navcontainer">
<ul id="navlist">
	<li><a href='main.php?target=home'>&Uuml;bersicht</a></li>
	<li><a href='main.php?target=ship'>Raumschiff</a></li>
	<li><a href='main.php?target=galaxy'>Galaxy</a></li>
	<li><a href='main.php?target=plani'>Aktueller Planet</a></li>
	<li><a href='main.php?target=ally'>Allianz</a></li>
	<li><a href='main.php?target=ally&ac=13'>Allianz Liste</a></li>
	<li><a href='main.php?target=einladung'>Einladungen</a></li>
	<li><a href='main.php?target=message'>Nachrichten</a></li>
	<li><a href='main.php?target=useroptions'>Einstellungen</a></li>
	<li><a href='main.php?target=logout'>Logout</a></li>
	<?php
		if($_SESSION["status"] == "Admin")
		{
			echo "<br><li><a href=main.php?target=admin>Admin Panel</a></li>\n";
		}
	?>
</ul>
</div>