<h2>{sitetitle}</h2>

{loginerror}
<p>Fehler beim anmelden: {errormessage}</p>
<p><a href='{self}'>Zurück</a></p>
{/loginerror}

{loginsucces}
<p><font color='green'>Erfolgreich Angemeldet</font></p>
{/loginsucces}
{logoutsucces}
<p><font color='green'>Erfolgreich Abgemeldet</font></p>
{/logoutsucces}

{login}
<form action='{self}' method='{method}'>
<table border='0'>
<tr><td>Username:</td><td><input type='text' name='username'></td></tr>
<tr><td>Passwort:</td><td><input type='password' name='userpass'></td></tr>
<tr><td><input type='submit' name='login' value='Login'></td><td><input type='reset' value='Zurücksetzen'></td></tr>
</table>
<input type='hidden' name='skey' value='{skey}'>
</form>
{/login}

{admin}
{ADMIN_MENUE}
<br>
<hr>
{ADMIN_FRAME}
{/admin}