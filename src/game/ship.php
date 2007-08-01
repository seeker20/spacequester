<br>
<table border='0' width='97%' style="height: 97%">
	<tr>
		<td width='50%'>
			<div id='abgerundedeecken3' align='center'>
				<?php 
					include "../daten/ships/ships.php";
					$sqlab = "select * from schiffe where id='" . $_SESSION["ship"] . "'";
					$res   = mysql_query($sqlab);
					$dsatz = mysql_fetch_assoc($res);
					
					echo "<br>";
					echo "<img src='../daten/ships/graphics/" . $ships[$dsatz["schifstypid"]][3] . "' alt='Schiffs Bild'>";
					echo "<br><br>";
					echo "<form action='main.php' method='post'>";
					echo "<input type='text' size='15%' name='shipname' value='" . $dsatz["schiffsid"] . "'>";
					echo "&nbsp;&nbsp;<input type='submit' name='shipnameswitch' value='&Auml;ndern'>&nbsp;<input type='reset' value='Default'>";
					echo "<input type='hidden' name='target' value='ship'>";
					echo "</form>";
				?>
			</div>
			<br>
			
			<div id='abgerundedeecken4' align='center'>
				<?php
					echo "<br>Beschreibung:<br>";
					echo $ships[$dsatz["schifstypid"]][4];
				?>
			</div>
			<br>
		</td>
		<td>
			<div id='abgerundedeecken5' align='center'>
				<table border='0'>
					<?php
						if(isset($_GET["view"])) {
							if($_GET["view"]==1) {
								echo "<tr><td colspan='3' align='center'><b>Rohstoffe</b></td></tr>";
								$data = explode(",",$dsatz["lager"]);
								for($i=0;$i < count($data);$i++) {
									if(trim($data[$i])!='') {
										$data2 = explode(":",$data[$i]);
										echo "<tr><td align='center'>" . $data2[0] . "</td><td>:</td><td>" . $data2[1] . "</td></tr>";
									}
								}
							}
							else if($_GET["view"]==2) {
								echo "<tr><td colspan='3' align='center'><b>Ausrüstung</b></td></tr>";
								$data = explode(",",$dsatz["ausruestung"]);
								for($i=0;$i < count($data);$i++) {
									if(trim($data[$i])!='') {
										$data2 = explode(":",$data[$i]);
										echo "<tr><td align='center'>" . $data2[0] . "</td><td>:</td><td>" . $data2[1] . "</td></tr>";
									}
								}
							}
							echo "<tr><td colspan='3' align='center'><br><a href='main.php?target=ship'>Zur&uuml;ck</a></td></tr>";
						}
						else {
							echo "<tr><td colspan='3' align='center'><b>Lage Men&uuml;</b></td></tr>";
							echo "<tr><td colspan='3' align='center'>&nbsp;</td>";
							echo "<tr><td colspan='3' align='center'><a href='main.php?target=ship&view=1'>Rohstoffe</a></td></tr>";
							echo "<tr><td colspan='3' align='center'><a href='main.php?target=ship&view=2'>Ausrüstung</a></td></tr>";
						}
					?>
				</table>
			</div>
			<br>
		</td>
	</tr>
</table>