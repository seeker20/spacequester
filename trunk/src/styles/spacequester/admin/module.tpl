<h3>Modul Verwaltung</h3>
{ERROR}
<font color='red'>{ERRMSG}</font>
<br />
{/ERROR}
{SUCCES}
<font color='green'>{SUCCESMSG}</font>
<br />
{/SUCCES}

{CONFIG}
<div style='width:98%; border-style:solid; border-width:1px; background-color:#efffff'>
{CONTENT}
</div>
<br />
{/CONFIG}

{IF isset {GET=econ}}
Ändere Config
{ELSE IF isset {GET=imod}}
Instaliere Modul
{ELSE IF isset {GET=dmod}}
{ELSE}

<table border='1' width='98%'>
<tr><th>Status</th><th>Name</th><th>Version</th><th>Benötigte Version</th><th>Beschreibung</th><th>Aktion</th></tr>
{READYFORINSTALL}
<tr><td>Install Ready</td><td><a href='{URL}' target='_blank' title='{URL}'>{NAME}</a></td><td>{VERSION}</td><td>{MINV}-{MAXV}</td><td>{DESC}</td><td><a href='main.php?inst={ID}'><img src='{IMAGE_PATH}/install.gif' border='0' alt='Instalieren' title='Instaliert das Aktuelle Modul.' /></a>/<a href='main.php?lri={ID}'><img src='{IMAGE_PATH}/delete.gif' border='0' alt='Löschen' title='Löscht das Aktuelle Modul.' /></a></td></tr>
{/READYFORINSTALL}

{INSTALLT}
<tr><td>Installiert</td><td><a href='{URL}' target='_blank' title='{URL}'>{NAME}</a></td><td>{VERSION}</td><td>{MINV}-{MAXV}</td><td>{DESC}</td><td><a href='main.php?conf={ID}'><img src='{IMAGE_PATH}/edit.gif' border='0' alt='Bearbeiten' title='Das Aktuelle Modul bearbeiten.' /></a>/<a href='main.php?deinst={ID}'><img src='{IMAGE_PATH}/uninstall.gif' border='0' alt='Deinstalieren' title='Deinstaliert das Aktuelle Modul.' /></a>/<a href='main.php?linst={ID}'><img src='{IMAGE_PATH}/delete.gif' border='0' alt='Löschen' title='Löscht das Aktuelle Modul.' /></a></td</tr>
{/INSTALLT}

</table>
<br />
{ENDIF}