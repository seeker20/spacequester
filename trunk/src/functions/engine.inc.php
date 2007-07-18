<?php
#PHP-Template-Parser
if(!(defined("CMS"))) {
	die("kein Zugriffs recht");
}

class tpl {
	var $template_file;
	var $replace_array;
	
	var $DebugMode = false;

	var $delimiterStart = "{";
	var $delimiterEnd   = "}";
	
	function setStartDelim($delim="{") {
		$this->delimiterStart = $delim;
	}

	function setEndDelim($delim="}") {
		$this->delimiterEnd = $delim;
	}
	
	function tpl($template_file) {
		if(file_exists($template_file)) {
			$fp   = fopen($template_file ,"r");
			$this->template_file="";
			while($line=fgets($fp,2000)) {
				$this->template_file .= trim($line);
				$this->template_file .= "\n";
			}
			fclose($fp);
			
			return $this->template_file;
		}
		else {
			$this->template_file = "";
			die("failed to load template file");
		}
	}
	
	function CopyInTpl($tag,$path,$params="") {
		$fp = @fopen($path,"r");
		if(!$fp) {
			die("Konnte TemplateFile \"$path\" nicht öffnen");
		}
		$in = "";
		while($line=fgets($fp)) {
			$in.=$line."\n";
		}
		fclose($fp);
		
		$search = $this->delimiterStart.$tag.$this->delimiterEnd;
		if($params!="") {
			$replace="<?php $params ?>".$in;
		}
		else {
			$replace = $in;
		}
		$this->template_file = str_replace($search,$replace,$this->template_file);
		
		return $this->template_file;
	}
	
	function CopyInTplRepeater($tag,$path,$params="") {
		$fp = @fopen($path,"r");
		if(!$fp) {
			die("Konnte TemplateFile \"$path\" nicht öffnen");
		}
		$in = "";
		while($line=fgets($fp)) {
			$in.=$line."\n";
		}
		fclose($fp);
		
		$search = $this->delimiterStart.$tag.$this->delimiterEnd;
		if($params!="") {
			$replace = "<?php $params ?>".$in.$this->delimiterStart.$tag.$this->delimiterEnd;
		}
		else {
			$replace = $in.$this->delimiterStart.$tag.$this->delimiterEnd;
		}
		$this->template_file = str_replace($search,$replace,$this->template_file);
		
		return $this->template_file;
	}
	
	function TextBlock($blockname,$blockarray,$inhaltarray) {
		if(count($blockarray)!=count($inhaltarray)) {
			die("Die Anzahl der Elemente Stimmt nicht überein.");
		}
		
		$tmparray = get_mark($this->template_file,$this->delimiterStart . $blockname . $this->delimiterEnd . "*" . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd);
		
		$temp = $tmparray[0];
		for($i=0;$i<count($blockarray);$i++) {
			$temp    = str_replace($this->delimiterStart . $blockarray[$i] . $this->delimiterEnd,$inhaltarray[$i],$temp);
		}
		$temp .= "\n";
		
		$this->template_file = str_replace($this->delimiterStart . $blockname . $this->delimiterEnd . $tmparray[0] . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd, $temp , $this->template_file);
	}
	
	function TextRepeater($blockname,$blockarray,$inhaltarray) {
		if(count($blockarray)!=count($inhaltarray)) {
			die("Die Anzahl der Elemente Stimmt nicht überein.");
		}
		
		$tmparray = get_mark($this->template_file,$this->delimiterStart . $blockname . $this->delimiterEnd . "*" . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd);
		
		$temp = $tmparray[0];
		for($i=0;$i<count($blockarray);$i++) {
			$temp    = str_replace($this->delimiterStart . $blockarray[$i] . $this->delimiterEnd,$inhaltarray[$i],$temp);
		}
		$temp .= "\n";
		
		$this->template_file = str_replace($this->delimiterStart . $blockname . $this->delimiterEnd . $tmparray[0] . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd,
		$temp . $this->delimiterStart . $blockname . $this->delimiterEnd . $tmparray[0] . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd, $this->template_file);
	}
	
	function clearList($blockname) {
		$tmparray = get_mark($this->template_file,$this->delimiterStart . $blockname . $this->delimiterEnd . "*" . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd);
		
		$this->template_file = str_replace($this->delimiterStart . $blockname . $this->delimiterEnd . $tmparray[0] . $this->delimiterStart . "/" . $blockname . $this->delimiterEnd,"",$this->template_file);
	}
	
	function assign($searchString,$key=false) {
		if(is_array($searchString)) {
			foreach($searchString as $var => $key) {
				$search = $this->delimiterStart.$var.$this->delimiterEnd;
				$replace = $key;
				$this->template_file = str_replace($search,$replace,$this->template_file);
			}
		}
		else {
			$search = $this->delimiterStart.$searchString.$this->delimiterEnd;
			$replace = $key;
			$this->template_file = str_replace($search,$replace,$this->template_file);
		}
		return $this->template_file;
	}
	
	function ifBlockReplace() {
		//GET und Post ausfüllen
		$tmparray = get_mark($this->template_file,$this->delimiterStart . "GET=*" . $this->delimiterEnd);
		for($i=0;$i<count($tmparray);$i++) {
			$tmpString = "\$_GET[\"" . $tmparray[$i] . "\"]";
			$this->assign("GET=" . $tmparray[$i],$tmpString);
		}
		$tmparray = get_mark($this->template_file,$this->delimiterStart . "POST=*" . $this->delimiterEnd);
		for($i=0;$i<count($tmparray);$i++) {
			$tmpString = "\$_POST[\"" . $tmparray[$i] . "\"]";
			$this->assign("POST=" . $tmparray[$i],$tmpString);
		}
		//ELSE IF
		$tmparray = get_mark($this->template_file,$this->delimiterStart . "ELSE IF *" . $this->delimiterEnd);
		for($i=0;$i<count($tmparray);$i++) {
			$tmparray2 = split(" ",$tmparray[$i]);
			$ifblock = "<?php } ";
			if($tmparray2[0]=="isset") {
				$ifblock .= "else if(isset(" . $tmparray2[1] . ")) {";
			}
			else if($tmparray2[0]=="!isset") {
				$ifblock .= "else if(!isset(" . $tmparray2[1] . ")) {";
			}
			$ifblock .= " ?>";
			
			$this->assign("ELSE IF " . $tmparray[$i],$ifblock);
		}
		//IF
		$tmparray = get_mark($this->template_file,$this->delimiterStart . "IF *" . $this->delimiterEnd);
		for($i=0;$i<count($tmparray);$i++) {
			$tmparray2 = split(" ",$tmparray[$i]);
			$ifblock = "<?php ";
			if($tmparray2[0]=="isset") {
				$ifblock .= "if(isset(" . $tmparray2[1] . ")) {";
			}
			else if($tmparray2[0]=="!isset") {
				$ifblock .= "if(!isset(" . $tmparray2[1] . ")) {";
			}
			$ifblock .= " ?>";
			
			$this->assign("IF " . $tmparray[$i],$ifblock);
		}
		//ELSE und ENDIF
		$this->assign("ENDIF","<?php } ?>");
		$this->assign("ELSE","<?php } else { ?>");
	}
	
	function sessionLinkReplace($urlstring,$content) {
		if(substr_count($urlstring,"SID")==0) {
			if(substr_count($urlstring,"?")==0) {
				$nurlstring = $urlstring."?SID=".SID;
			}
			else {
				$nurlstring = $urlstring."&SID=".SID;
			}
			
			$content = str_replace($urlstring,$nurlstring,$content);
		}
		
		return $content;
	}
	
	function sessionLinkSystem($content) {
		if(defined("SESSON_LINK_SYSTEM")) {
			$contenta1 = get_mark($content,"<a href=\"main.php*\"");
			$contenta2 = get_mark($content,"<a href='main.php*'");
			for($i=0;$i<count($contenta1);$i++) {
				$content = $this->sessionLinkReplace($contenta1[$i],$content);
			}
			for($i=0;$i<count($contenta2);$i++) {
				$content = $this->sessionLinkReplace($contenta2[$i],$content);
			}
			
			$contenta3 = get_mark($content,"<form*</form>");
			for($i=0;$i<count($contenta3);$i++) {
				if(substr_count($contenta3[$i],"<input type='hidden' name='SID' value='".SID."' />\n")==0) {
					$content = str_replace($contenta3[$i],$contenta3[$i]."<input type='hidden' name='SID' value='".SID."' />\n",$content);
				}
			}
			
			$contenta4 = get_mark($content,"location.href='*';");
			$contenta5 = get_mark($content,"location.href=\"*\";");
			for($i=0;$i<count($contenta4);$i++) {
				$content = $this->sessionLinkReplace($contenta4[$i],$content);
			}
			for($i=0;$i<count($contenta5);$i++) {
				$content = $this->sessionLinkReplace($contenta5[$i],$content);
			}
		}
		
		return $content;
	}
	
	function phpWrapper($content) {
		ob_start();
		$content = str_replace('<'.'?php','<'.'?',$content);
		eval('?'.'>'.trim($content).'<'.'?');
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	function getData() {
		return $this->template_file;
	}
	
	function saveData($string) {
		$this->template_file = $string;
	}
	
	function Sonderzeichen() {
		$this->template_file = Sonderzeichen($this->template_file);
	}
	
	function get() {
		$this->ifBlockReplace();
		$this->Sonderzeichen();
		$this->template_file = bbcode($this->template_file);
		
		if($this->DebugMode) {
			$fp = fopen("Debug.txt","w");
			fputs($fp,$this->template_file);
			fclose($fp);
		}
		return $this->sessionLinkSystem($this->phpWrapper($this->template_file));
	}

	function out() {
		echo($this->get());
	}
}

function ReadTplFile($file) {
	$fp = @fopen($file,"r");
	if(!$fp) {
		return "Konnte TemplateFile \"$file\" nicht öffnen";
	}
	$in = "";
	while($line=fgets($fp)) {
		$in.=$line."\n";
	}
	fclose($fp);
		
	return $in;
}
?>