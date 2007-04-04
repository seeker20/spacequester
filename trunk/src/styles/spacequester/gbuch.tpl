<h2>{sitetitle}</h2>
<p>{gberrorout}</p>
{IF isset {GET=t}}
<form action='{self}' method='{method}'>
<table border='0' width='90%'>
<tr><td width='50%' align='center'><div class='newsElement1'>Name</div></td><td align='center'><div class='newsElement1'><input size='40%' type='text' name='gfname'></div></td></tr>
<tr><td width='50%' align='center'><div class='newsElement1'>Email</div></td><td align='center'><div class='newsElement1'><input size='40%' type='text' name='gfemail'></div></td></tr>
<tr><td width='50%' align='center'><div class='newsElement1'>HP</div></td><td align='center'><div class='newsElement1'><input size='40%' type='text' name='gfhp'></div></td></tr>
<tr><td width='50%' align='center'><div class='newsElement1'>Text</div></td><td align='center'><div class='newsElement1'><textarea name="gftext" cols="40%" rows="8%"></textarea></div></td></tr>
</table>
<input type='submit' name='gbuch'>
<p><a href='main.php'>Zurück</a></p>
</form>
{ELSE}
<p><a href='main.php?t=1'>Eintragen</a></p>
{ENDIF}
<table border='0' width='90%'>
{list}
<tr>
<td align='center' width='50%'><div class='newsElement1'><a href='mailto:{gbuchemail}'>{gbuchname}</a></div></td><td align='center'><div class='newsElement1'>{gbuchdate}</div></td>
</tr><tr>
<td colspan='2' align='center'><div class='newsElement1'><a href='{gbuchhp}' target='_blank'>{gbuchhp}</a></div></td>
</tr><tr>
<td colspan='2' align='center'><div class='newsElement1'>{gbuchtext}</div></td>
</tr><tr>
<td colspan='2' align='center'>&nbsp;</td>
</tr>
{/list}
</table>