<h3>{sitetitle}</h3>
<div id="navcontainer">
<ul id="navlist">
{list}
<li><a href='{linktarget}'>{linkname}</a></li>
{/list}
<?php if(isset($_SESSION["login"])&&$_SESSION["login"]!="") { ?>
	<li><a href='main.php?logout=1'>Logout</a></li>
<?php } ?>
<?php if(isset($_GET["logout"])) { ?>
	<script language="JavaScript">
	<!--
		location.href='main.php?target=loginpanel';
	//-->
	</script>
<?php } ?>
<li><a href='main.php?starget=impressum'>Impressum</a></li>
</ul>
</div>