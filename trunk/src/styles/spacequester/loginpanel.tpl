<h3>{sitetitle}</h3>
{IF !isset {POST=login}}
	<form action='{self}' method='{method}'>
	<input type='text'  size='15' name='lpuser' value='Username'><br>
	<input type='password' size='15' name='lppass' value='Passwort'><br>
	<input type='submit' name='login' value='Einloggen'>&nbsp;<input type='reset' value='Abbrechen'>
	</form>
{ELSE}
	{SUCCES}
		<p><font color='green'>{MSG}</font></p>
		<p><a href='main.php?target=ghaupt'>Weiter zum Spiel</a></p>
		<script language="JavaScript">
		<!--
			location.href='main.php?target=ghaupt';
		//-->
		</script>
	{/SUCCES}
	{ERROR}
		<p><font color='red'>{MSG}</font></p>
	{/ERROR}
{ENDIF}