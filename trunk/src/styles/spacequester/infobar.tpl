<table border='0' width='95%'>
	<tr><td align='left'>Linke Azeige</td><td align='center'><span id='time'><?php echo date("H:i:m"); ?></span></td><td align='right'>Rehcte Anzeige</td></tr>
</table>

<script language="javascript">
<!-- 
	function Uhrzeit() {
		var jetzt=new Date();
		var stunde=jetzt.getHours();
		var minute=jetzt.getMinutes();
		var sekunde=jetzt.getSeconds();

		std_string = (stunde < 10) ? "0"+stunde : ""+stunde;
		min_string = (minute < 10) ? "0"+minute : ""+minute;
		sek_string = (sekunde < 10) ? "0"+sekunde : ""+sekunde;

		this.document.getElementById("time").innerHTML = std_string+":"+min_string+":"+sek_string;
	}
	Uhrzeit();
	window.setInterval('Uhrzeit()',1000)
//-->
</script>
