<?php
if($_SESSION['status'] != "Admin")
{
	die("
		<h1>ACCESS DENIED</h1>
		<p>Du bist nicht berrechtigt dich hier aufzuhalten</p>
	");
}
else
{
	define("ADMIN",true);
}

if(!defined("ADMIN"))
{
	die("
		<h1>ACCESS DENIED</h1>
		<p>Du bist nicht berrechtigt dich hier aufzuhalten</p>
	");
}

?>
<h1>Willkommen am Admin</h1>
<p>Hier kannst du alle Verwaltungsaufgaben durchf&uuml;hren</p>
<table border='0' width='97%' style="height: 97%">
	<tr>
		<td width='50%'>
			<div id='abgerundedeecken3' align='center'>
				<?
					$action   = $_REQUEST['mtarget'];
					$actionid = $_REQUEST['id'];
					
					//echo $action."<br>".$actionid."<br>";
					
					switch($action)
					{
						case "user":
							require("./admin/user.php");
						break;
						
						case "news":
							require("./admin/news.php");
						break;
					}
				?>
			</div>

			<br>

			<div id='abgerundedeecken4' align='center'>
			
			</div>

		</td>
		<td>
			<div id='abgerundedeecken5' align='center'>
			<h4>Benutzer-Verwaltung</h4>
					<div id=navcontainer>
						<ul id="navlist">
							<li><a href=main.php?target=admin&mtarget=user&id=1>Benutzer liste anzeigen</a></li>
							<li><a href=main.php?target=admin&mtarget=user&id=2>Benutzer Infos einsehen</a></li>
							<li><a href=main.php?target=admin&mtarget=user&id=3>Benutzer hinzuf&uuml;gen</a></li>
							<li><a href=main.php?target=admin&mtarget=user&id=4>Benutzer Sperren</a></li>
							<li><a href=main.php?target=admin&mtarget=user&id=5>Benutzer l&ouml;schen</a></li>
							<li><a href=main.php?target=admin&mtarget=user&id=6>Benutzer Resetten</a></li>
						</ul>
					</div>
					<hr>
				<h4>News-System</h4>
					<div id=navcontainer>
						<ul id=navlist>
							<li><a href=main.php?target=admin&mtarget=news&id=1>News Anzeigen</a></li>
							<li><a href=main.php?target=admin&mtarget=news&id=2>News Schreiben</a></li>
							<li><a href=main.php?target=admin&mtarget=news&id=3>News Resetten</a></li>
						</ul>
					</div>
			</div>
		</td>
</tr>
			

</table>

		