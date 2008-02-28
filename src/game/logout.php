<h2>Logout</h2>
<?php
$sql = "UPDATE users SET lastaction='' WHERE name='".$_SESSION['user']."'";
//echo $sql."<br>";
mysql_query($sql) or die(mysql_error());
//die($_SESSION['user']);
$_SESSION["user"] = '';
$_SESSION["ship"] = '';
$_SESSION["gmod"] = '';

if($_SESSION["JavaScript"]==true) {
	echo '<script language="JavaScript">location.href="../root/main.php";';
	echo '<' . "/" . 'script>';
}
else {
	echo "<p><a href='../root/main.php'>Hier gehst weiter</a></p>";
}
session_destroy();
?>