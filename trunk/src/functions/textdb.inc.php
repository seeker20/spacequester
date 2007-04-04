<?php
#PHP-Template-Parser
if(!(isset($CMS))) {
	die("kein Zugriffs recht");
}

class db {
	var $path;
	var $prefix;
	
	function init($prefix,$path) {
		$this->prefix = $prefix;
		$this->path = $path;
		if(!is_dir($path)) {
			die ("TextDB Ordner nicht vorhanden.");
		}
	}
	
	function query($query) {
		return $res;
	}
	
	function get($result) {
		//return mysql_fetch_assoc($result);
	}
	
	function count($result) {
		//return mysql_num_rows($result);
	}
}
?>