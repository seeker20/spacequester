<?php
$db = new db();

$mtpl = new tpl(SYSTEM_STYLE_PATH . $_SESSION["style"] . "/pictures.tpl");

$mtpl->assign('PIC_SERVICE','services/thunbils.php?paras=');
$mtpl->assign('sitetitle','Pictures');

#list1 asufüllen
if(isset($_GET["gpid"])) {
	$katarry;
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . AntiHacker($_GET["gpid"]) . "'");
	while($dsatz=$db->get()) {
		$mtpl->TextRepeater("LIST1",array("PICSRC","KATNAME","PICNAME","GPID","PID"),
						array(ReAntiHacker($dsatz["target"]),ReAntiHacker($dsatz["katname"]),ReAntiHacker($dsatz["name"]), ReAntiHacker($dsatz["katid"]), ReAntiHacker($dsatz["id"])));	
	}
}

#list2 asufüllen
$db->query("select * from " . SYSTEM_dbpref . "pics");

if($db->count()<=0) {
	$mtpl->TextRepeater("NOPICTURES","","");
}
else {
	$katarray;
	
	while($dsatz=$db->get()) {
		$err=false;
		for($i=0;$i<count($katarray);$i++) {
			if($katarray[$i]==ReAntiHacker($dsatz["katid"])) {
				$err=true;
				break;
			}
		}
		if(!$err) {
			$katarray[count($katarray)]=ReAntiHacker($dsatz["katid"]);	
			$res	 = $db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . ReAntiHacker($dsatz["katid"]) . "'",true);
			$num	 = $db->count($res);
			
			srand(microtime()*1000000);
			$num 	 = rand(0,$num);
			
			for($i=0;$i<$num;$i++) $dsatz=$db->get($res);
			
			$mtpl->TextRepeater("LIST2",array("PICSRC","KATNAME","PICNAME","GPID","PID"),
						array(ReAntiHacker($dsatz["target"]),ReAntiHacker($dsatz["katname"]),ReAntiHacker($dsatz["name"]), ReAntiHacker($dsatz["katid"]), ReAntiHacker($dsatz["id"])));				
		}
	}
}

#GruppenID und Namen einsetzen
if(isset($_GET["gpid"])) {
	$gpid = $_GET["gpid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . AntiHacker($gpid) . "'");
	$dsatz = $db->get();
	
	$gname = ReAntiHacker($dsatz["katname"]);
	
	$mtpl->assign('GRUPPENID',$gpid);
	$mtpl->assign('GRUPPENNAME',$gname);
}
else if(isset($_GET["pid"])) {
	$pid = $_GET["pid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where id='" . AntiHacker($pid) . "'");
	$dsatz = $db->get();
	
	$gname = ReAntiHacker($dsatz["katname"]);
	$pid   = ReAntiHacker($dsatz["katid"]);
	
	$mtpl->assign('GRUPPENID',$pid);
	$mtpl->assign('GRUPPENNAME',$gname);
}


#Bilder erstellen anhand der id
if(isset($_GET["pid"])) {
	$pid = $_GET["pid"];
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where id='" . AntiHacker($pid) . "'");
	$dsatz = $db->get();
	
	$mtpl->assign('PICNAME',ReAntiHacker($dsatz["name"]));
	$mtpl->assign('PICBESCHR',ReAntiHacker($dsatz["beschreibung"]));
	$mtpl->assign('PICSRC',ReAntiHacker($dsatz["target"]));
	
	$db->query("select * from " . SYSTEM_dbpref . "pics where katid='" . AntiHacker($dsatz["katid"]) . "'");

	$previd=0;
	$nextid=0;
	$next=false;
	while($dsatz2=$db->get()) {
		if(ReAntiHacker($dsatz2["id"])==ReAntiHacker($dsatz["id"])) {
			$next=true;
		}
		else if($next) {
			$next=false;
			$nextid=ReAntiHacker($dsatz2["id"]);
			break;
		}
		else {
			$previd=$dsatz2["id"];
		}
	}
	
	if($previd==0)
		$previd=ReAntiHacker($dsatz["id"]);
	if($nextid==0)
		$nextid=ReAntiHacker($dsatz["id"]);
		
	$mtpl->assign('BEVORPICID',$previd);
	$mtpl->assign('NEXTPICID',$nextid);
}

$mtpl->clearList("LIST1");
$mtpl->clearList("LIST2");
$mtpl->clearList("NOPICTURES");

$mtpl->out();
?>