<h3>{sitetitle}</h3>

<table border='0' width='90%' cellpadding='0' cellspacing='1'>
	<tr style='background-color: #FF9900;'>
		<th style="border:1px solid #000000;">ID</th><th style="border:1px solid #000000;">Username</th><th style="border:1px solid #000000;">-/-</th>
	</tr>
	{LIST1}
		<tr align='center' style='background-color: #FFCC00;'>
			<td style="border:1px solid #000000;">{USERID}</td><td style="border:1px solid #000000;"><a href='main.php?starget=showuser&id={USERID}' title='Profil von {USERNAME} anzeigen'>{USERNAME}</a></td><td style="border:1px solid #000000;"><a href='main.php?starget=pminterface&npm={USERNAME}'><img src='{IMAGE_PATH}email-reply.png' border='0' alt='PM schicken' title='PM schicken' /></a></td>
		</tr>
	{/LIST1}
</table>