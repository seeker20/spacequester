{IF !isset {GET=agb}}
<h3>Regiestrieren</h3>
{ELSE}
<h3>AGB</h3>
{ENDIF}

{IF !isset {POST=reg}}
	{IF !isset {GET=agb}}
		<p>Bitte füllen sie alle Felder die mit einem * gekenzeichned sind aus.</p>
		<form action='main.php' method='post'>
			<table border='0'>
				<tr><td>*Username</td><td>:</td><td><input type='text' name='uname'></td></tr>
				<tr><td>*Passwort</td><td>:</td><td><input type='password' name='pass1'></td></tr>
				<tr><td>*Passwort nochmal</td><td>:</td><td><input type='password' name='pass2'></td></tr>
				<tr><td>*Email</td><td>:</td><td><input type='text' name='email'></td></tr>
				<tr><td>Richtiger Name</td><td>:</td><td><input type='text' name='rname'></td></tr>
				<tr><td>Geburtsjahr</td><td>:</td><td><input type='text' name='gyear'></td></tr>
				<tr><td>*<a href='main.php?agb' target='blank'>AGB</a> zu stimmen</td><td>:</td><td align='center'>Bitte "JA" in das textfeld. <input type='text' name='agb'></td></tr>
				<tr><td><input type='submit' name='reg' value='Regiestrieren'></td><td>&nbsp;</td><td><input type='reset' value='Zurücksetzen'></td>
			</table>
		</form>
	{ELSE}
		<b>Hier steht die AGB</b>
	{ENDIF}
{ELSE}
	{SUCCES}
		<p><font color='green'>{MSG}</font></p>
	{/SUCCES}
	{ERROR}
		<p><font color='red'>{MSG}</font></p>
		<p><a href='main.php'>Zurück</a></p>
	{/ERROR}
{ENDIF}