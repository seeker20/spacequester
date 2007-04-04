<?php
#PHP-Template-Parser
if(!(isset($CMS))) {
	die("kein Zugriffs recht");
}

class db {
	var $prefix;
	var $res;
	
	function init($prefix,$local,$user,$pass,$dbname) {
		$this->prefix = $prefix;
		
		mysql_connect($local,$user,$pass) or die (mysql_error());
		mysql_select_db($dbname) or die (mysql_error() . "<br>Konnte keine verbindung zur DB herstellen.");
	}
	
	function query($query,$ressave=false) {
		if($ressave) return mysql_query($query);
		else {
			$this->res = mysql_query($query);
			return $this->res;
		}
	}
	
	function get($result=false) {
		if(!$result)
			$result=$this->res;
			
		return mysql_fetch_assoc($result);
	}
	
	function count($result=false) {
		if(!$result)
			$result=$this->res;
			
		return mysql_num_rows($result);
	}
}
?>