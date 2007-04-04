{INFO}<br>
<b>Admins</b><br><br>
{IF isset {GET=new}}
<form action="main.php" method="POST">
	<input type="hidden" name="action" value="save">
	<table>
		<tr>
			<td><b>Neuer Admin</b></td>
		</tr>
		<tr>
			<td>Benutzername:</td>
			<td><input type="input" name="username" value=""><br></td>
		</tr>
		<tr>
			<td>Passwort:</td>
			<td><input type="password" name="password" value=""><br></td>
		</tr>
		<tr>
			<td><input type="submit" value="Erstellen"></td>
		</tr>
	</table>
</form>
{ELSE IF isset {GET=edit}}
<form action="main.php" method="POST">
	<input type="hidden" name="action" value="saveedit">
	<input type="hidden" name="id" value="{AID}">
	<table>
		<tr>
			<td><b>Admin bearbeiten</b></td>
		</tr>
		<tr>
			<td>Benutzername:</td>
			<td><input type="input" name="username" value="{ADMINNAME}"><br></td>
		</tr>
		<tr>
			<td>Passwort:</td>
			<td><input type="password" name="password" value=""><br></td>
		</tr>
		<tr>
			<td><input type="submit" value="Ändern"></td>
		</tr>
	</table>
</form>
{ELSE}
<form action="main.php" method="GET">
<input type="hidden" name="new" value="1">
<input type="submit" value="Neuer Admin">
</form>
<table border="1" width="98%">
	<tr>
		<td><b>Name</b></td>
		<td><b>IP</b></td>
		<td width="50"><b>Funktionen</b></td>
	</tr>
	{list}
	<tr>
		<td>{admin_name}</td>
		<td>{admin_ip}</td>
		<td width="50">
		<a href="main.php?edit=1&id={ADMINID}"><img title='Bearbeitet den aktuellen Admin' alt='Edit' src="{IMAGE_PATH}/edit.gif" border="0" /></a>
		<a href="main.php?action=delete&id={ADMINID}"><img title='Löscht den aktuellen Admin' alt='Delete' src="{IMAGE_PATH}/delete.gif" border="0" /></a>
		</td>
	</tr>
	{/list}
</table>
{ENDIF}