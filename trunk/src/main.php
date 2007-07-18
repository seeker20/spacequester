<?php
#Prüft die Daten ab
if(isset($_GET["init"])) {
	if(isset($_GET["j"])) {
		$_SESSION["JavaScript"]	=true;
	}
	else {
		$_SESSION["JavaScript"]	=false;
	}
	$_SESSION["style"]			=SYSTEM_STYLE;
	$_SESSION["sitentitle"]		=SYSTEM_start;
	
	if(isset($_COOKIE["c-test"])) {
		$_SESSION["Cookies"]=true;
	}
	else {
		$_SESSION["Cookies"]=false;
	}
}

if(isset($_COOKIE["c-test"])) {
	$_SESSION["Cookies"]=true;
}

if(empty($_SESSION["style"])) {
	if(!$tmp=setcookie("c-test","1",time()+120)) {
		$_SESSION["Cookies"]=false;
	}
		
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">";
	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Init Site...</title>\n";
	echo "<META http-equiv='refresh' content='0;URL=main.php?init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "' />\n";
	echo '<script language="JavaScript" type="text/javascript">'."\n";
	echo '<!--'."\n";
	echo "location.href='main.php?j=1&init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "';"."\n";
	echo '//-->'."\n";
	echo '<'.'/'.'script>'."\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<p><a href='main.php?init=1";
	if(isset($_GET["target"])) {
		echo "&target=" . $_GET["target"];
	}
	else if(isset($_GET["starget"])) {
		echo "&starget=" . $_GET["starget"];
	}
	echo "'>Init...</a></p>\n";
	echo "</body>\n";
	echo "</html>";
	exit(-1);
}

if($_SESSION["Cookies"]==false) {
	//define("SESSON_LINK_SYSTEM",true);
}
?>

<?php
#admin prüfer
if($_SESSION["admin"]!=''&&$_SESSION["admin"]!=$SYSTEM_adminkey) {
	$_SESSION["admin"]='';
	$_SESSION["adminrender"]='';
}
?>

<?php
#admin render swithcer
if($_SESSION["admin"]!=''&&isset($_GET["adminrender"])) {
	$_SESSION["adminrender"]=$_GET["adminrender"];
}
?>

<?php
$tpl = new tpl(SYSTEM_STYLE_PATH . "/" . $_SESSION["style"] . "/main.tpl");
$tpl->assign('TITLE',SYSTEM_TITLE);
$tpl->assign('styleroot',SYSTEM_STYLE_PATH . "/" . $_SESSION["style"]);
$tpl->assign('loginpanel',"<?php include \"loginpanel.php\";?>");
$tpl->assign('adminlink',"<a href='main.php?starget=admin'>AdminLogin</a>");

//Module
$ids;
$db->query("select * from " . SYSTEM_dbpref . "sites order by feldpos asc");
while($dsatz=$db->get()) {
	if($dsatz['type']=='user'&&SYSTEM_USERSITESM==2) {
		$path = SYSTEM_USERSITESF;
	}
	else if($dsatz['type']=='system') {
		$path = SYSTEM_system_path;
	}
	else if($dsatz['type']=='modul') {
		$path = SYSTEM_modul_path;
	}
	
	$is=false;
	for($i=0;$i<count($ids);$i++) {
		if($ids[$i]==$dsatz["feld"]) {
			$is=true;
		}
	}
	
	if(!$is) {
		$ids[count($ids)]=$dsatz["feld"];
	}
	
	$is = false;
	if($dsatz["acces_groups"]=="") {
		$is = true;
	}
	else {
		if($_SESSION["acces"]=="") $acces=0;
		else $acces = $_SESSION["acces"];
		
		$split = explode("#",$dsatz["acces_groups"]);
		for($i=0;$i<count($split);$i++) {
			if($acces==$split[$i]) {
				$is=true;
				break;
			}
		}
	}
	
	if($is) {
		$tpl->CopyInTplRepeater("FELD_" . $dsatz["feld"],$path . "/" . $dsatz["adress"],$dsatz["params"]);
	}
	
}
for($i=0;$i<count($ids);$i++) {
	$tpl->assign("FELD_" . $ids[$i],"");
}

$tpl->assign('PRODUKTION',"fkr-soft");
$tpl->assign('PRODUKTNAME',"Phönix View CMS");
$tpl->assign('AUTOR',"Florian Krauthan");
$tpl->assign('VERSION',SYSTEM_VERSION);

$tpl->out();
?>