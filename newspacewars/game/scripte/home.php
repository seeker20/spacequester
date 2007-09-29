<br>
<table border='0' width='97%' style="height: 97%">
	<tr>
		<td width='50%'>
			<div id='abgerundedeecken3' align='center'>
				<?php
					$sqlab = "select * from schiffs_auftraege where schiffsid='" . $_SESSION["ship"] . "'";
					$res   = mysql_query($sqlab);
					if(mysql_num_rows($res)>0) {
						$dsatz = mysql_fetch_assoc($res);
						
						$timearray = explode("#",$dsatz["time_array"]);
						$posarray  = explode("#",$dsatz["pos_array"]);
						$time      = time();
						if($timearray[0]>$time) {
							$pospos = explode("-",$posarray[0]);
							$sector = $pospos[2];
							$x      = $pospos[0];
							$y      = $pospos[1];
						}
						else {
							for($i=0;$i<count($timearray);$i++) {
								if($timearray[$i]<=$time) {
									$pospos = explode("-",$posarray[$i]);
									$sector = $pospos[2];
									$x      = $pospos[0];
									$y      = $pospos[1];
								}
							}
						}
						
						$fp 	 = fopen("../daten/galaxy/" . $sector . ".txt","r");
					
						for($i=0;$i < $y;$i++) {
							$line = fgets($fp,2000);
						}
					
						$positiona = get_mark(trim($line),"[*]");
						$position  = explode(",",$positiona[$x-1]);
					
					
						echo "<br>";
						echo "<img src='../daten/galaxy/graphics/" . $position[0] . ".png' alt='SternFeld'>";
						fclose($fp);
					}
					else {
						$sqlab = "select * from schiffe where id='" . $_SESSION["ship"] . "'";
						$res   = mysql_query($sqlab);
						$dsatz = mysql_fetch_assoc($res);
						$fp 	 = fopen("../daten/galaxy/" . $dsatz["sector"] . ".txt","r");
					
						for($i=0;$i < $dsatz["y"];$i++) {
							$line = fgets($fp,2000);
						}
					
						$positiona = get_mark(trim($line),"[*]");
						$position  = explode(",",$positiona[$dsatz["x"]-1]);
					
					
						echo "<br>";
						echo "<img src='../daten/galaxy/graphics/" . $position[0] . ".png' alt='SternFeld'>";
						fclose($fp);
						
						$sector = $dsatz["sector"];
						$x      = $dsatz["x"];
						$y      = $dsatz["y"];
					}
					
			echo "</div>";
			echo "<br>";
			
			include "../daten/galaxy/typs.inc.php";
			
			$typ   			= $fieldtyp[$position[1]][0];
			
			if($fieldtyp[$position[1]][1]) {
				#daten aus db holen
				$sqlab = "select * from station where sector='" . $sector . "' and x='" . $x . "' and y='" . $y . "'";
				$res   = mysql_query($sqlab);
				$dsatz = mysql_fetch_assoc($res);
				
				$umfang		= $dsatz["groesse"];
				$einwohner	= $dsatz["einwohner"];
				
			}
			else {
				$umfang		= "---";
				$einwohner	= "---";
			}
			
			$position = $y . ":" . $x . ":" . $sector;
			
			echo "<div id='abgerundedeecken4' align='center'>";
				echo "<br>";
				echo "<table border='0' width='95%'>";
				echo "<tr><td>Typ</td><td>:</td><td>" . $typ . "</td></tr>";
				echo "<tr><td>Gr&ouml;sse</td><td>:</td><td>" . $umfang . "</td></tr>";
				echo "<tr><td>Einwohner</td><td>:</td><td>" . $einwohner . "</td></tr>";
				echo "<tr><td>Position</td><td>:</td><td><a href='main.php?target=viewstar&pos=" . str_replace(":","-",$position) . "'>" . $position . "</a></td></tr>";
				echo "</table>";
			echo "</div>";
			echo "<br>";
		echo "</td>";
		echo "<td>";
			echo "<div id='abgerundedeecken5' align='center'>";
				$sqlab = "select * from schiffe where sector='" . $sector . "' and x='" . $x . "' and y='" . $y . "'";
				$res   = mysql_query($sqlab);
				echo "<h3>Spieler auf diesem Feld</h3>";
				$time_new = time()+500;
				while($dsatz=mysql_fetch_assoc($res)) {
					$sqlab = "select * from schiffs_auftraege where schiffsid='" . $dsatz["id"] . "'";
					$res2   = mysql_query($sqlab);
					if(mysql_num_rows($res2)<=0) {
						$sqlab = "select * from users where id='" . $dsatz["userid"] . "'";
						$res2  = mysql_query($sqlab);
						$dsatz2=mysql_fetch_assoc($res2);
					
						echo htmlentities($dsatz["schiffsid"]) . "&nbsp;(";
						if($dsatz2["lastaction"]=='') {
							echo "<font color='red'>";
						}
						else {
							if($dsatz2["lastaction"] < $time_new) {
								echo "<font color='green'>";
							}
							else {
								echo "<font color='yellow'>";
							}
						}
						echo htmlentities($dsatz2["name"]) . "</font>)";
						echo "<br>";
					}
				}
				#alle spieler die unterwegs sind hier nachpr�fen ob die gerade auf deisem sektor sind
				$sqlab = "select * from schiffs_auftraege";
				$res3   = mysql_query($sqlab);
				while($dsatz3=mysql_fetch_assoc($res3)) {
					$timearray = explode("#",$dsatz3["time_array"]);
					$posarray  = explode("#",$dsatz3["pos_array"]);
					$time      = time();
					if($timearray[0]>$time) {
						$pospos = explode("-",$posarray[0]);
						$_sector = $pospos[2];
						$_x      = $pospos[0];
						$_y      = $pospos[1];
					}
					else {
						for($i=0;$i<count($timearray);$i++) {
							if($timearray[$i]<=$time) {
								$pospos = explode("-",$posarray[$i]);
								$_sector = $pospos[2];
								$_x      = $pospos[0];
								$_y      = $pospos[1];
							}
						}
					}
					
					if($_sector==$sector&&$_x==$x&&$_y==$y) {
						$sqlab = "select * from schiffe where id='" . $dsatz3["schiffsid"] . "'";
						$res   = mysql_query($sqlab);
						$dsatz = mysql_fetch_assoc($res);
						
						$sqlab = "select * from users where id='" . $dsatz["userid"] . "'";
						$res2  = mysql_query($sqlab);
						$dsatz2=mysql_fetch_assoc($res2);
					
						echo "<font color='#99FFCC'>" . htmlentities($dsatz["schiffsid"]) . "</font>&nbsp;(";
						if($dsatz2["lastaction"]=='') {
							echo "<font color='red'>";
						}
						else {
							if($dsatz2["lastaction"] < $time_new) {
								echo "<font color='green'>";
							}
							else {
								echo "<font color='yellow'>";
							}
						}
						echo $dsatz2["name"] . "</font>)";
						echo "<br>";
					}
				}
			echo "</div>";
			?>
			<br>
		</td>
	</tr>
</table>