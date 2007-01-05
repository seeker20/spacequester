<h2>Login</h2>

<?php
if(isset($_GET["ac"])||isset($_POST["ac"])) {
	#aktion
	if(isset($_GET["ac"]))
		$ac = $_GET["ac"];
	else
		$ac = $_POST["ac"];
		
	if($ac=="ulogin") {
		#login
		$login = mysql_real_escape_string($_POST["uname"]);
		$pass  = mysql_real_escape_string($_POST["upass"]);
		$modus = mysql_real_escape_string($_POST["umod"]);
		
		if($login==''||$pass==''||$modus=='') {
			echo "Sie muessen alle Felder ausfllen um sich anzumelden<br>";
		}
		else {
			$pass  = md5($pass);
			$sqlab = "select * from users where name='" . $login . "' and passwort='" . $pass . "'";
			$res   = mysql_query($sqlab);
			if(mysql_num_rows($res)<=0) {
				echo "User gibt es nicht oder das Passwort gibt es nicht.<br>";
			}
			else {
				$dsatz = mysql_fetch_assoc($res);
				if($dsatz["link"]!='') {
					echo "Sie mssen sich erst Freischalten.<br>";
				}
				else {
					$date = date("d.m.Y");
					
					if($dsatz["lastlogin"]=='') {
						#neuer Spieler
						
						$_SESSION["usern"]	= $dsatz["id"];
						$_SESSION["gmod"] 	= $modus;
						
						echo "<form action='main.php' method='post'>";
						echo "<p>Bitte w&#228;hlen sie ihren Beruf den sie haben wollen. Nachdem kreigen sie ein Schiff zugewissen. Anosnten hat diese auswahl keine einfluss auf das Spiel.</p>";
						echo "<p>Beruf: <select name='beruf'>";
						echo "<option value='1'>S&#246;ldner</option>";
						echo "<option value='2'>H&#228;ndler</option>";
						echo "<option value='3'>Soldat</option>";
						echo "<option value='4'>Pirat</option>";
						echo "</select>";
						echo "</p>";
						echo "<input type='submit' value='Beruf ausw&#228hlen'>&nbsp;&nbsp;&nbsp;<input type='reset'>";
						echo "<input type='hidden' name='target' value='login'>";
						echo "<input type='hidden' name='ac' value='sberuf'>";
						echo "</form>";
					}
					else {
						$time = time();
						
						#spierel anmelden
						$sqlab = "update users set lastlogin='" . $date . "', lastaction='" . $time . "' where id='" . $dsatz["id"] . "'";
						mysql_query($sqlab);
						
						$_SESSION["user"]   = $dsatz["name"];
						$_SESSION["ship"]   = $dsatz["schifid"];
						$_SESSION["gmod"]   = $modus;
						$_SESSION["status"] = $dsatz["status"];
						
						if($_SESSION["JavaScript"]==true) {
							echo '<script language="JavaScript">location.href="../game/main.php";';
							echo '<' . "/" . 'script>';
						}
						else {
							echo "<p><a href='../game/main.php'>Hier gehst weiter</a></p>";
						}
					}
				}
			}
		}
	}
	else if($ac=="sberuf") {
		#beruf asuw�len
		if(!(isset($_POST["beruf"]))) {
			echo "Sie m&#252;ssen einen Beruf w&#228;hlen.<br>";
		}
		else {
			srand((double)microtime()*1000000);
			
			$liste =opendir('../daten/galaxy/');
			$galaxy=0;
			while ($datei = readdir($liste)) {
				if ($datei!="." && $datei!="..") {
					$data = explode(".",$datei);
					if($data[1]=="txt") {
						$galaxy++;
					}
				}
			}
			closedir($liste);
			
			$galaxy = rand(1,$galaxy);
			
			$x  = 0;
			$y  = 0;
			
			$fp = fopen("../daten/galaxy/" . $galaxy . ".txt","r");
			while($line = fgets($fp,2000)) {
				$line = trim($line);
				$res  = get_mark($line,"[*]");
				$x    = count($res);
				$y++;
			}
			fclose($fp);

			$x 		= rand(1,$x);
			$y 		= rand(1,$y);
			
			$mod 	= mysql_real_escape_string($_POST["beruf"])-1;
			$date = date("d.m.Y");
			
			include "../daten/ships/ships.php";
			
			$sqlab  = "select * from schiffe where userid='" . $_SESSION["usern"] . "'";
			$res    = mysql_query($sqlab);
			if(mysql_num_rows($res) > 0) {
				echo "Reload Sperre bitte laden sie diese Seite nicht neu.<br>";
			}
			else {
				$sqlab  = "INSERT INTO `schiffe` ( `id` , `schiffsid` , `userid` , `schifstypid` , `schild` , `huelle` , `waffen` , `ausruestung` , `lager` , `x` , `y` , `sector` ) VALUES (";
				$sqlab .= "NULL , 'No Name', '" . $_SESSION["usern"] . "', '" . $mod . "', '" . $ships[$mod][1] . "', '" . $ships[$mod][2] . "', '', '', '', '" . $x . "', '" . $y . "', '" . $galaxy . "')";
				mysql_query($sqlab);
				
				$sqlab  = "select * from schiffe where userid='" . $_SESSION["usern"] . "'";
				$res    = mysql_query($sqlab);
				$dsatz  = mysql_fetch_assoc($res);
			
			
				$time = time();
			
				$sqlab  = "update users set lastlogin='" . $date . "', lastaction='" . $time . "', schifid='" . $dsatz["id"] . "', credits='5000', beruf='" . $mod . "' where id='" . $_SESSION["usern"] . "'";
				mysql_query($sqlab);
				
				$sqlab  = "select * from users where id='" . $_SESSION["usern"] . "'";
				$res    = mysql_query($sqlab);
				$dsatz  = mysql_fetch_assoc($res);
				
				$_SESSION["ship"]=$dsatz["schifid"];
				$_SESSION["user"]=$dsatz["name"];
			}
			
			if($_SESSION["JavaScript"]==true) {
				echo '<script language="JavaScript">location.href="../game/main.php";';
				echo '<' . "/" . 'script>';
			}
			else {
				echo "<p><a href='../game/main.php'>Hier gehst weiter</a></p>";
			}
		}
	}
}
else {
	echo "<form action='main.php' method='post'>";
	echo "<table border='0'>";
	echo "<tr><td>Username</td><td>:</td><td><input type='text' name='uname'></td><tr>";
	echo "<tr><td>Passwort</td><td>:</td><td><input type='password' name='upass'></td></tr>";
	echo "<tr><td>Modus</td><td>:</td><td>";
	echo "<select name='umod'>";
	echo "<option value='1'>Normal</option>";
	echo "<option value='2'>Spaar Modus</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><input type='submit' value='Login'></td><td>&nbsp;</td><td><input type='reset'></td></tr>";
	echo "</table>";
	echo "<input type='hidden' name='target' value='login'>";
	echo "<input type='hidden' name='ac' value='ulogin'>";
	echo "</form>";
}