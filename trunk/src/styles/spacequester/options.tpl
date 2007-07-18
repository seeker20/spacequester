<h3>{SITETITLE}</h3>

{IF !isset {POST=akt}}
	{IF !isset {GET=akt}}
		<b>Wilkommen {USERNAME}</b> in ihrem verwaltungs Zentrum.<br /> Hier können sie leicht alle einstellungen an ihrem Account vornhemen.
		<br />
		<hr />
		<br />
		<a href='main.php?akt=nameedit' title='Usernamen ändern'>Usernamen ändern</a><br /><br />
		<a href='main.php?akt=passedit' title='Passwort ändern'>Passwort ändern</a><br /><br />
		<a href='main.php?akt=optionsedit' title='Account optionen ändern'>Account optionen ändern</a>
	{ELSE}
		<a href='main.php?akt=nameedit' title='Usernamen ändern'>Usernamen ändern</a>&nbsp;&nbsp;&nbsp;<a href='main.php?akt=passedit' title='Passwort ändern'>Passwort ändern</a>&nbsp;&nbsp;&nbsp;<a href='main.php?akt=optionsedit' title='Account optionen ändern'>Account optionen ändern</a><br />
		<br />
		<hr />
		<br />
		<?php if($_GET["akt"]=="nameedit") { ?>
			Geben sie einfach den gewünscheten Usernamen unten ein und drücken sie auf "Usernamen Ändern". Es wird geprüft ob der Username schon exisitert ansonsten wird ihr Username geändert.<br /><br />
			<form action='main.php' method='post'>
				<input type='hidden' name='akt' value='nameedit' />
				<input type='text' name='username' value='{USERNAME}' />&nbsp;&nbsp;<input type='submit' value='Usernamen Ändern' />&nbsp;&nbsp;<input type='reset' value='Abbrechen' />
			</form>
		<?php } else if($_GET["akt"]=="passedit") {?>
			Geben sie einfach ihr altes Passwort und 2mal das neue ein. Danach nur noch auf PAsswort ändern klicken.<br /><br />
			<form action='main.php' method='post'>
				<input type='hidden' name='akt' value='passedit' />
				<table border='0'>
					<tr>
						<td>Altes Passwort</td><td>:</td><td><input type='password' name='oldpass' value='' /><br /></td>
					</tr>
					<tr>
						<td>Neues Passwort</td><td>:</td><td><input type='password' name='newpass1' value='' /><br /></td>
					</tr>
					<tr>
						<td>Neues Passwort (wdh.)</td><td>:</td><td><input type='password' name='newpass2' value='' /><br /></td>
					</tr>
				</table>
				<input type='submit' value='Passwort ändern' />&nbsp;&nbsp;<input type='reset' value='Abbrechen' />
			</form>
		<?php } else if($_GET["akt"]=="optionsedit") { ?>
			Editiern sie eifnach ihre Daten und klicken sie auf speichern.<br /><br />
			<form action='main.php' method='post'>
				<input type='hidden' name='akt' value='optionsedit' />
				<table border='0'>
					<tr><td>Richtiger Name</td><td>:</td><td><input type='text' name='rname' value='{REALNAME}' /></td></tr>
					<tr><td>Geburtsjahr</td><td>:</td><td><input type='text' name='gyear' value='{GYEAR}' /></td></tr>
				</table>
				<input type='submit' value='Änderungen Speichern' />&nbsp;&nbsp;<input type='reset' value='Abbrechen' />
			</form>
		<?php } ?>
	{ENDIF}
{ELSE}
	{SUCCES}
		<font color='green'>{MSG}</font><br />
	{/SUCCES}
	{ERROR}
		<font color='red'>{MSG}</font><br />
	{/ERROR}
	<br />
	<b>Wählen sie einfach einen Menü Punkt aus zum editieren.</b><br /><br />
	<hr />
	<br />
	<a href='main.php?akt=nameedit' title='Usernamen ändern'>Usernamen ändern</a><br /><br />
	<a href='main.php?akt=passedit' title='Passwort ändern'>Passwort ändern</a><br /><br />
	<a href='main.php?akt=optionsedit' title='Account optionen ändern'>Account optionen ändern</a>
{ENDIF}