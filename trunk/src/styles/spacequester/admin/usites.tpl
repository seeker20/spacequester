<b>UserSites</b><br><br>

{ERROR}
<font color='red'>{ERRMSG}</font>
<br>
{/ERROR}
{SUCCES}
<font color='green'>{SUCCESMSG}</font>
<br>
{/SUCCES}

{IF isset {POST=vschc}}
Vorschau von "{SITENAME}":<br>
<div align='left' style="padding:2px; margin:2px 5px 2px 5px; border:1pt solid #0000ff;">
{CONTENT}
</div>
<form action='main.php' method='post'>
<table border='0' width='80%'>
<tr><td>Name der Seite:</td><td><input type='text' name='newsite' value='{SNAME}'></td></tr>
<tr><td colspan='2' align='center'>Inhalt der Seite:</td></tr>
<tr><td>Inhtalt:</td><td>{EDITOR}</td></tr>
</table>
<br>
<input type='submit' value='Seite Erstellen' name='new'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Vorschau' name='vschc'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen'>
</form>
{ELSE IF isset {GET=newsite}}
Erstellen einer neuen Seite:<br><br>
<form action='main.php' method='post'>
<table border='0' width='80%'>
<tr><td>Name der Seite:</td><td><input type='text' name='newsite' value=''></td></tr>
<tr><td colspan='2' align='center'>Inhalt der Seite:</td></tr>
<tr><td>Inhtalt:</td><td>{EDITOR}</td></tr>
</table>
<br>
<input type='submit' value='Seite Erstellen' name='new'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Vorschau' name='vschc'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen'>
</form>
{ELSE IF isset {POST=vsch}}
Vorschau von "{SITENAME}":<br>
<div align='left' style="padding:2px; margin:2px 5px 2px 5px; border:1pt solid #0000ff;">
{CONTENT}
</div>
<form action='main.php' method='post'>
<input type='hidden' name='editsite' value='{SITENAME}'>
<table border='0' width='80%'>
<tr><td>Name der Seite:</td><td>{SNAME}</td></tr>
<tr><td colspan='2' align='center'>Inhalt der Seite:</td></tr>
<tr><td>Inhtalt:</td><td>{EDITOR}</td></tr>
</table>
<br>
<input type='submit' value='Seite Ändern' name='edit'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Vorschau' name='vsch'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen'>
</form>
{ELSE IF isset {GET=editsite}}
Bearbeiten der Seite "{SITENAME}":<br><br>

<form action='main.php' method='post'>
<input type='hidden' name='editsite' value='{SITENAME}'>
<table border='0' width='80%'>
<tr><td>Name der Seite:</td><td>{SNAME}</td></tr>
<tr><td colspan='2' align='center'>Inhalt der Seite:</td></tr>
<tr><td>Inhtalt:</td><td>{EDITOR}</td></tr>
</table>
<br>
<input type='submit' value='Seite Ändern' name='edit'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Vorschau' name='vsch'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen'>
</form>
{ELSE IF isset {GET=delsite}}
Wollen sie die Seite "{DELID}" wirklich löschen?<br>
<form action='main.php' method='post'>
<input type='hidden' name='delsite' value='{DELID}'>
<input type='submit' value='Ja'name='del'>&nbsp;&nbsp;&nbsp;<input type='submit' value='Nein'>
</form>
{ELSE}
<table border='1' width='98%'>
<tr>
<th>ID</th><th>Name</th><th>File</th><th>Aktion</th>
</tr>
{LIST}
<tr>
<td>{USID}</td><td>{USNAME}</td><td>{USFILE}</td><td align='center'><a href='main.php?editsite={USFILE}'><img title='Bearbeite die Seite' alt='Edit' src="{IMAGE_PATH}/edit.gif" border="0" /></a>&nbsp;&nbsp;&nbsp;<a href='main.php?delsite={USFILE}'><img title='Löscht die Seite' alt='Delete' src="{IMAGE_PATH}/delete.gif" border="0" /></a></td>
</tr>
{/LIST}
</table>
<br>
<div align='left'>
<form action='main.php' method='GET'>
&nbsp;&nbsp;&nbsp;<input type='submit' value='Neue Seite' name='newsite'>
</form>
</div>
{ENDIF}