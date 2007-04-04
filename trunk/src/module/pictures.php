<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/pictures.tpl");

$mtpl->assign('PIC_SERVICE','services/thunbils.php?paras=');
$mtpl->assign('sitetitle','Pictures');

#list1 asufüllen
if(isset($_GET["gpid"])) {
	$katarry;
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . mysql_escape_string($_GET["gpid"]) . "'");
	while($dsatz=$db->get()) {
		$mtpl->TextRepeater("LIST1",array("PICSRC","KATNAME","PICNAME","GPID","PID"),
						array($dsatz["target"],$dsatz["katname"],$dsatz["name"], $dsatz["katid"], $dsatz["id"]));	
	}
	$mtpl->clearList("LIST1");
}

#list2 asufüllen
$db->query("select * from " . SYSTEM_dbpref . "pics");

if($db->count()<=0) {
	$string = "<p>Keine Bilder verfügar.</p>\n";
}
else {
	$katarray;
	
	while($dsatz=$db->get()) {
		$err=false;
		for($i=0;$i<count($katarray);$i++) {
			if($katarray[$i]==$dsatz["katid"]) {
				$err=true;
				break;
			}
		}
		if(!$err) {
			$katarray[count($katarray)]=$dsatz["katid"];	
			$res	 = $db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . $dsatz["katid"] . "'",true);
			$num	 = $db->count($res);
			
			srand(microtime()*1000000);
			$num 	 = rand(0,$num);
			
			for($i=0;$i<$num;$i++) $dsatz=$db->get($res);
			
			$mtpl->TextRepeater("LIST2",array("PICSRC","KATNAME","PICNAME","GPID","PID"),
						array($dsatz["target"],$dsatz["katname"],$dsatz["name"], $dsatz["katid"], $dsatz["id"]));				
		}
	}
	$mtpl->clearList("LIST2");
}

#GruppenID und Namen einsetzen
if(isset($_GET["gpid"])) {
	$gpid = $_GET["gpid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . mysql_escape_string($gpid) . "'");
	$dsatz = $db->get();
	
	$gname = $dsatz["katname"];
	
	$mtpl->assign('GRUPPENID',$gpid);
	$mtpl->assign('GRUPPENNAME',$gname);
}
else if(isset($_GET["pid"])) {
	$pid = $_GET["pid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where id='" . mysql_escape_string($pid) . "'");
	$dsatz = $db->get();
	
	$gname = $dsatz["katname"];
	$pid   = $dsatz["katid"];
	
	$mtpl->assign('GRUPPENID',$pid);
	$mtpl->assign('GRUPPENNAME',$gname);
}


#Bilder erstellen anhand der id
if(isset($_GET["pid"])) {
	$pid = $_GET["pid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where id='" . mysql_escape_string($pid) . "'");
	$dsatz = $db->get();
	
	$mtpl->assign('PICNAME',$dsatz["name"]);
	$mtpl->assign('PICBESCHR',$dsatz["beschreibung"]);
	$mtpl->assign('PICSRC',$dsatz["target"]);
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . $dsatz["katid"] . "'");

	$previd=0;
	$nextid=0;
	$next=false;
	while($dsatz2=$db->get()) {
		if($dsatz2["id"]==$dsatz["id"]) {
			$next=true;
		}
		else if($next) {
			$next=false;
			$nextid=$dsatz2["id"];
			break;
		}
		else {
			$previd=$dsatz2["id"];
		}
	}
	
	if($previd==0)
		$previd=$dsatz["id"];
	if($nextid==0)
		$nextid=$dsatz["id"];
		
	$mtpl->assign('BEVORPICID',$previd);
	$mtpl->assign('NEXTPICID',$nextid);
}

$mtpl->out();
?>