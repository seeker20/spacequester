<h3>Sternen Feld Info</h3>

<?php
if(isset($_GET["pos"])) {
	$pos 		= explode("-",mysql_real_escape_string($_GET["pos"]));
	$tmpPos = htmlentities(mysql_real_escape_string($_GET["pos"]));
}
else {
	$pos 	= explode("-",mysql_real_escape_string($_POST["pos"]));
	$tmpPos = mysql_real_escape_string($_POST["pos"]);
}

if($tmpPos == "--")
{
	echo "Sie Fliegen gerade";
	exit();
}

include "../daten/galaxy/typs.inc.php";

if(isset($_GET["ac"])||isset($_POST["ac"])) {
	include "../daten/ships/ships.php";
	
	if(isset($_GET["ac"])) $ac=$_GET["ac"];
	else if(isset($_POST["ac"])) $ac=$_POST["ac"];
	#aktion ausführen
	if($ac==1) {
		#Zeil Anfleigen
		$nx 		= $pos[0];
		$ny 		= $pos[1];
		$nsector 	= $pos[2];
		
		$sqlab 		= "select * from schiffe where id='" . $_SESSION["ship"] . "'";
		$res   		= mysql_query($sqlab);
		$dsatz 		= mysql_fetch_assoc($res);
		
		$oy			= $dsatz["y"];
		$ox			= $dsatz["x"];
		$osector	= $dsatz["sector"];
		
		#nur sector intern Fleigen
		$count=0;
		$posarray;
		$timearray;
			
		#daten asurechnen
		if($ny<$oy) {
			for($i=$oy;$i>=$ny;$i--) {
				if($posarray[$count-1]!=$ox . "-" . $i . "-" . $osector) {
					$posarray[$count]=$ox . "-" . $i . "-" . $osector;
					$count++;
				}
			}
		}
		else if($ny>$oy) {
			for($i=$oy;$i<=$ny;$i++) {
				if($posarray[$count-1]!=$ox . "-" . $i . "-" . $osector) {
					$posarray[$count]=$ox . "-" . $i . "-" . $osector;
					$count++;
				}
			}
		}
			
		if($osector==$nsector) {
			if($nx<$ox) {
				for($i=$ox;$i>=$nx;$i--) {
					if($posarray[$count-1]!=$i . "-" . $ny . "-" . $osector) {
						$posarray[$count]=$i . "-" . $ny . "-" . $osector;
						$count++;
					}
				}
			}
			else if($nx>$ox) {
				for($i=$ox;$i<=$nx;$i++) {
					if($posarray[$count-1]!=$i . "-" . $ny . "-" . $osector) {
						$posarray[$count]=$i . "-" . $ny . "-" . $osector;
						$count++;
					}
				}
			}
		}
		else if($nsector<$osector) {
			for($i=$ox;$i>=1;$i--) {
				if($posarray[$count-1]!=$i . "-" . $ny . "-" . $osector) {
					$posarray[$count]=$i . "-" . $ny . "-" . $osector;
					$count++;
				}
			}
				
			for($i=$osector-1;$i>=$nsector;$i--) {
				$fp = fopen("../daten/galaxy/" . $i . ".txt","r");
				$y  = 0;
				$x  = 0;
				while($line = fgets($fp,2000)) {
					$line = trim($line);
					$y++;
					if($y==$ny) {
						$res  = get_mark($line,"[*]");
						$x    = count($res);
						break;
					}
				}
				fclose($fp);
					
				for($s=$x;$s>=1;$s--) {
					if($posarray[$count-1]!=$s . "-" . $ny . "-" . $i) {
						$posarray[$count]=$s . "-" . $ny . "-" . $i;
						if($s==$nx&&$i==$nsector) {
							break;
						}
						$count++;
					}
				}
			}
		}
		else if($nsector>$osector) {
			#geth zurzeit nicht
			
			$fp = fopen("../daten/galaxy/" . $osector . ".txt","r");
			$y  = 0;
			$x  = 0;
			while($line = fgets($fp,2000)) {
				$line = trim($line);
				$y++;
				if($y==$ny) {
					$res  = get_mark($line,"[*]");
					$x    = count($res);
					break;
				}
			}
			fclose($fp);
					
			for($i=$ox;$i<=$x;$i++) {
				if($posarray[$count-1]!=$i . "-" . $ny . "-" . $osector) {
					$posarray[$count]=$i . "-" . $ny . "-" . $osector;
					$count++;
				}
			}
				
			for($i=$osector+1;$i<=$nsector;$i++) {
				$fp = fopen("../daten/galaxy/" . $i . ".txt","r");
				$y  = 0;
				$x	= 0;
				while($line = fgets($fp,2000)) {
					$line = trim($line);
					$y++;
					if($y==$ny) {
						$res  = get_mark($line,"[*]");
						$x    = count($res);
						break;
					}
				}
				fclose($fp);
					
				for($s=1;$s<=$x;$s++) {
					if($posarray[$count-1]!=$s . "-" . $ny . "-" . $i) {
						$posarray[$count]=$s . "-" . $ny . "-" . $i;
						if($s==$nx&&$i==$nsector) {
							break;
						}
						$count++;
					}
				}
			}
		}
		
		$timearray[0] = time()+$ships[$dsatz["schifstypid"]][5]/2;
		for($i=1;$i<count($posarray)-1;$i++) {
			$timearray[$i] = $timearray[$i-1]+$ships[$dsatz["schifstypid"]][5];
		}
		$timearray[count($timearray)] = $timearray[count($timearray)-1]+$ships[$dsatz["schifstypid"]][5]/2;
			
			
		if($ox==$nx&&$oy==$ny&&$osector==$nsector) {
			echo "<p><font color='red'>Sie befinden sich bereits auf diesem Feld.</font></p>";
		}
		else {
			$timestring = implode("#",$timearray);
			$posstring  = implode("#",$posarray);
			
			$sqlab  = "INSERT INTO `schiffs_auftraege` ( `id` , `schiffsid` , `pos_array` , `time_array` ) VALUES (";
			$sqlab .= "NULL , '" . $_SESSION["ship"] . "', '" . $posstring . "', '" . $timestring . "')";
			mysql_query($sqlab);
			echo "<p><font color='green'>Sie sind erfolgreich losgeflogen.</font></p>";
		}
	}
}
	
$fp = fopen("../daten/galaxy/" . $pos[2] . ".txt","r");
for($i=0;$i < $pos[0];$i++) {
	$line = trim(fgets($fp,2000));
}
$splitfilds = get_mark($line,"[*]");

$fieldida 	= explode(",",$splitfilds[$pos[1]-1]);

echo "<b>" . $fieldtyp[$fieldida[1]][0] . " (" . $tmpPos . ")<b><br><br>";
echo "<table border='0' width='90%'>";
echo "<tr><td width='50%'>";
if($_SESSION["gmod"]=="1") {
	echo "<img src='../daten/galaxy/graphics/" . $fieldida[0] . ".png' border='0' alt='" . $fieldtyp[$fieldida[1]][2] . "'>";
}
else {
	echo $fieldtyp[$fieldida[1]][2];
}
echo "</td><td width='15%'>&nbsp;</td><td>";
$sqlab 	= "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
$res   	= mysql_query($sqlab);
if(mysql_num_rows($res)>0) {
	echo "<p>Sie Fliegen gerade.</p>";
}
else {
	$position = $_GET['pos'];
	#echo $position;
	$position = explode("-",$position);
	#echo "<br>$position";
	$ox = mysql_real_escape_string($position[0]);
	$oy = mysql_real_escape_string($position[1]);
	$osector = mysql_real_escape_string($position[2]);
	$sql = ("SELECT eigentumer FROM station WHERE x='$ox' AND y='$oy' AND sector='$osector'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$eigentumerid = $row['eigentumer'];
	
	$sql = ("SELECT name FROM users WHERE id='$eigentumerid'");
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$eigentumername = $row['name'];
	//die($_SESSION['user']);
	#echo "<br>X: $ox Y: $oy SEC: $osector";
	echo '<div id="navcontainer">';
	echo '<ul id="navlist">';
	if($fieldtyp[$fieldida[1]][3]) {
		echo "<li><a href='main.php?target=viewstar&pos=" . $tmpPos . "&ac=1'>Anfliegen</a></li>";
	}
	if(($fieldtyp[$fieldida[1]][4]) && ($_SESSION['user'] != $eigentumername)) {
		echo "<li><a href='main.php?target=viewstar&pos=" . $tmpPos . "&ac=2'>Handeln</a></li>";
	}
	if(($fieldtyp[$fieldida[1]][5]) && ($_SESSION['user'] != $eigentumername)) {
		echo "<li><a href='main.php?target=viewstar&pos=" . $tmpPos . "&ac=3'>Angreifen</a></li>";
	}
	if(($fieldtyp[$fieldida[1]][6]) && ($_SESSION['user'] != $eigentumername)) {
		echo "<li><a href='main.php?target=viewstar&pos=" . $tmpPos . "&ac=4'>Besetzen</a></li>";
	}
	echo '</ul>';
	echo '</div>';
}
echo "</td></tr>";
echo "</table>";
echo "<br>";
echo "<a href='main.php?target=galaxy&gala=" . $pos[2] . "'>Zurück</a><br>";
?>