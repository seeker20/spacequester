<h3>Galaxy Map</h3>

<?php
if(isset($_POST["oldgala"])) {
	$mingal = 1;
	$maxgal = 0;
	
	$liste =opendir('../daten/galaxy/');
	
	while ($datei = readdir($liste)) {
		if ($datei!="." && $datei!="..") {
			$data = explode(".",$datei);
			if($data[1]=="txt") {
				$maxgal++;
			}
		}
	}
	
	if($_POST["oldgala"]==$mingal&&isset($_POST["min"])) {
		$galaxy=$maxgal;
	}
	else if(isset($_POST["min"])) {
		$galaxy=$_POST["oldgala"]-1;
	}
	else if($_POST["oldgala"]==$maxgal&&isset($_POST["plus"])) {
		$galaxy=$mingal;
	}
	else if(isset($_POST["plus"])) {
		$galaxy=$_POST["oldgala"]+1;
	}
}
else if(isset($_GET["gala"])) {
	$galaxy = mysql_real_escape_string($_GET["gala"]);
}
else {
	$sqlab = "select * from schiffe where id='" . $_SESSION["ship"] . "'";
	$res   = mysql_query($sqlab);
	$dsatz = mysql_fetch_assoc($res);
	
	$galaxy=$dsatz["sector"];
}

echo "<form action='main.php' method='post'>";
echo "<input type='submit' name='min' value='<<<'>&nbsp;&nbsp;<input type='text' disabled size='5' value='" . $galaxy . "'>&nbsp;&nbsp;<input type='submit' name='plus' value='>>>'>";
echo "<input type='hidden' name='target' value='galaxy'>";
echo "<input type='hidden' name='oldgala' value='" . $galaxy . "'>";
echo "</form>";

echo "<hr>";

echo "<br>";

echo "<table border='1' cellspacing='0' cellpadding='0'>";

$fp = fopen("../daten/galaxy/" . $galaxy . ".txt","r");
include "../daten/galaxy/typs.inc.php";

$y = 0;

$sqlab = "select * from schiffe where id='" . $_SESSION["ship"] . "'";
$res   = mysql_query($sqlab);
$dsatz = mysql_fetch_assoc($res);
$shpos = $dsatz["x"] . "-" . $dsatz["y"] . "-" . $dsatz["sector"];

while($line = fgets($fp,2000)) {
	$line = trim($line);
	$y++;
	echo "<tr>";
	$splitfilds = get_mark($line,"[*]");
	for($i=0;$i < count($splitfilds);$i++) {
		$fieldida = explode(",",$splitfilds[$i]);
		
		echo "<td align='center' width='50' height='50'>";
		$pos = $i+1 . "-" . $y . "-" . $galaxy;
		echo "<a style='text-decoration: none;' href='main.php?target=viewstar&pos=" . $pos . "'>";
		if($_SESSION["gmod"]=="1") {
			echo "<img src='../daten/galaxy/graphics/pic_small.php?id=" . $fieldida[0] . "' border='0' alt='" . $fieldtyp[$fieldida[1]][2] . "'>";
		}
		else {
			echo $fieldtyp[$fieldida[1]][2];
		}
		echo "</a>";
		if($pos==$shpos) {
			//echo '<div style="position: absolute; z-index: 1;" id="Ebene1">S</div>';
		}
		echo "</td>";
	}
	echo "</tr>";
}
fclose($fp);

echo "</table>";
?>
