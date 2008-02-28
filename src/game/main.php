<?php
#Session
session_start();
//echo $_SESSION['status'];

?>
          
<?php
//Includes
include "../global/mysql_connect.php";
include "../global/funktionen.php";
//include "../global/querys.php";
include "../global/config.php";
?>

<?php
#style switcher
if(isset($_GET["newstyle"])) {
	$_SESSION["UserStyle"] = $_GET["newstyle"];
	$sql = ("UPDATE users SET style='".mysql_real_escape_string($_SESSION["UserStyle"])."'");
	mysql_query($sql) or die(mysql_error());
}
?>

<?php
if(isset($_GET["target"])) {
	$tmpTarget = htmlentities($_GET["target"]);
}
else if(isset($_POST["target"])) {
	$tmpTarget = $_POST["target"];
}
else {
	$tmpTarget = "home";
}
?>
<html>
	<head>
		<title>SpaceQuester Game</title>
		
		
<?php
if($_SESSION["user"]=='') {
	echo '<META http-equiv="refresh" content="0;URL=../index.php?target=login';
	echo '">';
	echo "</head>";
	echo "<body>";
	echo "<p>Load...</p>";
	echo "</body>";
	echo "</html>";
	exit();
}
else {
	echo '<META http-equiv="refresh" content="1500;URL=main.php?target=' . $tmpTarget . '&re=1">';
}
?>

<?php
#schauen ob spierl angekommen sit
$sqlab = "select * from schiffs_auftraege";
$res   = mysql_query($sqlab);
while($dsatz=mysql_fetch_assoc($res)) {
	$timearray = explode("#",$dsatz["time_array"]);
	$lasttime  = $timearray[count($timearray)-1];
	if($lasttime <= time()) {
		$posarray = explode("#",$dsatz["pos_array"]);
		$lastposa = explode("-",$posarray[count($posarray)-1]);
		
		$sqlab = "update schiffe set sector='" . $lastposa[2] . "', x='" . $lastposa[1] . "', y='" . $lastposa[0] . "' where id='" . $dsatz ["schiffsid"] . "'";
		mysql_query($sqlab);
		
		$sqlab = "delete from schiffs_auftraege where id='" . $dsatz["id"] . "'";
		mysql_query($sqlab);
	}
}
?>

<?php
#flug abbrechen
if(isset($_GET["sac"])) {
	if($_GET["sac"]=='ab') {
		#flug abbrechen
		$sqlab = "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
		$res   = mysql_query($sqlab);
		if(mysql_num_rows($res)>0) {
			if($timearray[0]>$time) {
				$pospos = explode("-",$posarray[0]);
				$sector = $pospos[2];
				$x      = $pospos[1];
				$y      = $pospos[0];
			}
			else {
				for($i=0;$i<count($timearray);$i++) {
					if($timearray[$i]<=$time) {
						$pospos = explode("-",$posarray[$i]);
						$sector = $pospos[2];
						$x      = $pospos[1];
						$y      = $pospos[0];
					}
				}
			}
			
			$sqlab = "update schiffe set x='" . $x . ", y='" . $y . "', sector='" . $sector . "' where id='" . $_SESSION["ship"] . "'";
			mysql_query($sqlab);
			
			$sqlab = "delete from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
			mysql_query($sqlab);
		}
	}
}
?>

<?php
#Schiff wechseln
if(isset($_POST["shipswitch"])) {
	$_SESSION["ship"]=mysql_real_escape_string($_POST["ship"]);
	$sqlab = "update users set schifid='" . $_SESSION["ship"] . "' where id='" . $_SESSION["user"] . "'";
	mysql_query($sqlab);
}
?>

<?php
#Schiffs namen wechseln
if(isset($_POST["shipnameswitch"])) {
	$sqlab = "update schiffe set schiffsid='" . mysql_real_escape_string($_POST["shipname"]) . "' where id='" . $_SESSION["ship"] . "'";
	mysql_query($sqlab);
}
?>

<?php
#User Online? Updater
$time = time();
if(isset($_GET["re"])) {
	$time += 500;
}
$sqlab = "update `users` set lastaction='" . $time . "' where name='" . $_SESSION["user"] . "'";
mysql_query($sqlab);

$time = time();

$time_new = $time-1500;
$sqlab = "update `users` set lastaction='' where `lastaction` < '" . $time_new . "'";
mysql_query($sqlab);
?>

<?php
	echo '<link type="text/css" rel="stylesheet" href="../daten/styles/' . $_SESSION["UserStyle"] . '/game.css">';
?>

	</head>
	<body>
		<div id='menue' align='center'>
			<div id='abgerundedeecken1' style="height:65px;">
				<p><img src='../daten/logo/logo.png' border='0' alt='Space Quester Logo'></p>
			</div>
			<br>
			<div id='abgerundedeecken'>
				<?php
					include "menue.php";
				?>
			</div>
		</div>
		<div id='main' align='center'>
			<div id='abgerundedeecken1' style="height:65px;">
				<?php
					include "infopanel.php";
				?>
			</div>
			<br>
			<div id='abgerundedeecken'>
				<?php
					include "frames.php";
				?>
			</div>
		</div>
	</body>
</html>
	
