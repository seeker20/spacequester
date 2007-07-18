<h3>{SITETITLE}</h3>
<p>Sie haben <b>{ANZNPM}</b> neue Nachricht(en)</p>

<br />
<form action='main.php' method='get'>
	<input type='submit' name='vpme' value='Posteingang' />&nbsp;&nbsp;&nbsp;<input type='submit' name='vpma' value='Postausgang' />&nbsp;&nbsp;&nbsp;<input type='submit' name='vpmf' value='Ordner Anzeigen' />&nbsp;&nbsp;&nbsp;<input type='submit' name='npm' value='Neue Nachricht' />
</form>

{INFO}
<p>{TEXT}</p>
{/INFO}

{PMEINGANG}
<p><b>Posteingang</b></p>
<table border='1' width='95%'>
<tr><th>ID</th><th>Absender</th><th>Betreff</th><th>Datum</th><th>Status</th><th>Aktion</th></tr>
	{eNPMMSG}
		<tr><td align='center'><b>{ID}</b></td><td align='center'><b><a href='main.php?npm={ABSENDERN}'>{ABSENDERN}</a></b></td><td align='center'><b><a href='main.php?view={ID}'>{BETREFF}</a></b></td><td align='center'><b>{DATE}</b></td><td align='center'><b>Ungelesen</b></td><td align='center'><b>
			<a href='main.php?view={ID}'><img src='{IMAGE_PATH}email-letter.png' border='0' alt='Lesen' title='PM lesen' /></a>&nbsp;&nbsp;
			<a href='main.php?npm={ABSENDERN}'><img src='{IMAGE_PATH}email-reply.png' border='0' alt='Antworten' title='PM Antworten' /></a>&nbsp;&nbsp;
			<a href='main.php?delpm={ID}'><img src='{IMAGE_PATH}email-remove.png' border='0' alt='Löschen' title='PM löschen' /></a>
		</b></td></tr>
	{/eNPMMSG}
	{eURPMMSG}
		<tr><td style='font-style:italic;' align='center'>{ID}</td><td style='font-style:italic;' align='center'><a href='main.php?npm={ABSENDERN}'>{ABSENDERN}</a></td><td style='font-style:italic;' align='center'><a href='main.php?view={ID}'>{BETREFF}</a></td><td style='font-style:italic;' align='center'>{DATE}</td><td style='font-style:italic;' align='center'>Ungelesen</td><td style='font-style:italic;' align='center'>
			<a href='main.php?view={ID}'><img src='{IMAGE_PATH}email-letter.png' border='0' alt='Lesen' title='PM lesen' /></a>&nbsp;&nbsp;
			<a href='main.php?npm={ABSENDERN}'><img src='{IMAGE_PATH}email-reply.png' border='0' alt='Antworten' title='PM Antworten' /></a>&nbsp;&nbsp;
			<a href='main.php?delpm={ID}'><img src='{IMAGE_PATH}email-remove.png' border='0' alt='Löschen' title='PM löschen' /></a>
		</td></tr>
	{/eURPMMSG}
	{eRPMMSG}
		<tr><td align='center'>{ID}</td><td align='center'><a href='main.php?npm={ABSENDERN}'>{ABSENDERN}</a></td><td align='center'><a href='main.php?view={ID}'>{BETREFF}</a></td><td align='center'>{DATE}</td><td>Gelesen</td><td align='center'>
			<a href='main.php?view={ID}'><img src='{IMAGE_PATH}email-letter.png' border='0' alt='Lesen' title='PM lesen' /></a>&nbsp;&nbsp;
			<a href='main.php?npm={ABSENDERN}'><img src='{IMAGE_PATH}email-reply.png' border='0' alt='Antworten' title='PM Antworten' /></a>&nbsp;&nbsp;
			<a href='main.php?delpm={ID}'><img src='{IMAGE_PATH}email-remove.png' border='0' alt='Löschen' title='PM löschen' /></a>
		</td></tr>
	{/eRPMMSG}
</table>
{/PMEINGANG}

{PMAUSGANG}
<p><b>Postausgang</b></p>
<table border='1' width='95%'>
<tr><th>ID</th><th>Empfänger</th><th>Betreff</th><th>Datum</th><th>Status</th><th>Aktion</th></tr>
	{pAMSG}
		<tr><td align='center'>{ID}</td><td align='center'><a href='main.php?npm={ABSENDERN}'>{ABSENDERN}</a></td><td align='center'><a href='main.php?view={ID}'>{BETREFF}</a></td><td align='center'>{DATE}</td><td>Gelesen</td><td align='center'>
			<a href='main.php?view={ID}'><img src='{IMAGE_PATH}email-letter.png' border='0' alt='Lesen' title='PM lesen' /></a>&nbsp;&nbsp;
			<a href='main.php?npm={ABSENDERN}'><img src='{IMAGE_PATH}email-reply.png' border='0' alt='Antworten' title='PM Antworten' /></a>&nbsp;&nbsp;
			<a href='main.php?delpm={ID}'><img src='{IMAGE_PATH}email-remove.png' border='0' alt='Löschen' title='PM löschen' /></a>
		</td></tr>
	{/pAMSG}
</table>
{/PMAUSGANG}

{PMFOLDER}
<p><b>Funktion ist noch nicht fertig.</b></p>
{/PMFOLDER}

{VIEWPM}
<table border='0' width='90%'>
	<tr><th width='10%' align='left'>Absender</th><td><a href='main.php?npm={ABSENDERID}'>{ABSENDERN}</a></td></tr>
	<tr><th width='10%' align='left'>Empfänger</th><td><a href='main.php?npm={EMPFID}'>{EMPFN}</a></td></tr>
	<tr><th width='10%' align='left'>Betreff</th><td>{BETREFF}</td></tr>
	<tr><th width='10%' align='left'>Datum</th><td>{DATE}</td></tr>
	<tr><th width='10%' align='left'>Ordner</th><td>{FOLDER}</td></tr>
	<tr><th width='10%' align='left'>Status</th><td>{STATUS}</td></tr>
	<tr><td colspan='2'><hr /></td></tr>
	<tr><td colspan='2'>{TEXT}</td></tr>
	<tr><td colspan='2'><hr /></td></tr>
	<tr><td colspan='2'>
		<form action='main.php' method='get'>
			<input type='hidden' name='betr' value='{BETREFF}' /><input type='hidden' name='txt' value='{TEXT}' /><input type='hidden' name='empf' value='{ABSENDERN}' /><input type='submit' value='Antworten' name='ant' /><input type='hidden' name='id' value='{ID}' />&nbsp;&nbsp;&nbsp;<input type='submit' name='setur' value='Als ungelesen Markieren' />&nbsp;&nbsp;&nbsp;<input type='submit' value='Löschen' name='delpm' />
		</form>
	</td></tr>
</table>
{/VIEWPM}

{IF isset {GET=npm}}
<br />
<p><b>Neue Nachricht:</b></p>
<form action='main.php' method='post'>
	<table border='0' width='90%'>
		<tr><th width='10%' align='left'>Empfänger</th><td><input type='text' name='empf' value='<?php if($_GET["npm"]!=""&&$_GET["npm"]!="Neue Nachricht") echo $_GET["npm"]; ?>' size='50' /></td></tr>
		<tr><th width='10%' align='left'>Betreff</th><td><input type='text' name='betr' value='' size='50' /></td></tr>
		<tr><th width='10%' align='left'>Datum</th><td>{ADATE}</td></tr>
		<tr><td colspan='2'><hr /></td></tr>
		<tr><th width='10%' align='left'>Nachricht</th><td><textarea name='msg' cols='45' rows='5'></textarea></td></tr>
		<tr><td colspan='2'><hr /></td></tr>
		<tr><td colspan='2'>
			<input type='submit' value='Absenden' name='cnpm' />&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen' />&nbsp;&nbsp;&nbsp;Kopie in Postausgang <input type='checkbox' name='kpa' />
		</td></tr>
	</table>
</form>
{ELSE IF isset {GET=ant}}
<br />
<p><b>Auf nachricht Antworten:</b></p>
<form action='main.php' method='post'>
	<table border='0' width='90%'>
		<tr><th width='10%' align='left'>Empfänger</th><td><input type='text' name='empf' value='<?php echo $_GET["empf"]; ?>' size='50' /></td></tr>
		<tr><th width='10%' align='left'>Betreff</th><td><input type='text' name='betr' value='<?php echo "Re:".str_replace("Re:","",$_GET["betr"]); ?>' size='50' /></td></tr>
		<tr><th width='10%' align='left'>Datum</th><td>{ADATE}</td></tr>
		<tr><td colspan='2'><hr /></td></tr>
		<tr><th width='10%' align='left'>Nachricht</th><td><textarea name='msg' cols='45' rows='5'><?php echo "\n\n---------------------------------------------\n".str_replace("<br />","\n",$_GET["txt"]); ?></textarea></td></tr>
		<tr><td colspan='2'><hr /></td></tr>
		<tr><td colspan='2'>
			<input type='submit' value='Absenden' name='cnpm' />&nbsp;&nbsp;&nbsp;<input type='submit' value='Abbrechen' />&nbsp;&nbsp;&nbsp;Kopie in Postausgang <input type='checkbox' name='kpa' />
		</td></tr>
	</table>
</form>
{ENDIF}