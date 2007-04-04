<h3>{sitetitle}</h3>

<table width='90%' border='0'>
<tr>
<td style="width: 50%" align='center'>
<div class="picElement1"><a href='main.php'>Gruppenübersicht</a></div>
</td>
<td align='center'>
{IF isset {GET=gpid}}
<div class="picElement1"><a href='main.php?gpid={GRUPPENID}'>{GRUPPENNAME}</a></div>
{ELSE IF isset {GET=pid}}
<div class="picElement1"><a href='main.php?gpid={GRUPPENID}'>{GRUPPENNAME}</a></div>
{ENDIF}
</td>
</tr>
</table>

<br><hr>

{IF isset {GET=pid}}
<table border='0'>
<tr><td><div class='picElement3'><a href='main.php?pid={BEVORPICID}'><-</a></div></td><td style='width:500px;' align='center'><div class='picElement4'>{PICNAME}</div></td><td><div class='picElement3'><a href='main.php?pid={NEXTPICID}'>-></a></div></td></tr>
<tr><td>&nbsp;</td><td style='width:200px;height:190px;' align='center'>
<a href='{PIC_SERVICE}{PICSRC}' target='_blank'><img border='0' src='{PIC_SERVICE}{PICSRC}|180' alt='{PICNAME}' title='{PICNAME}'></a>
</td><td>&nbsp;</td></tr>
<tr><td><div class='picElement3'><a href='main.php?pid={BEVORPICID}'><-</a></div></td><td style='width:500px;' align='center'><div class='picElement4'>{PICBESCHR}</div></td><td><div class='picElement3'><a href='main.php?pid={NEXTPICID}'>-></a></div></td></tr>
</table>
{ELSE}
{IF isset {GET=gpid}}
{LIST1}
<div class='picElement2'><a href='main.php?pid={PID}'><img border='0' src='{PIC_SERVICE}{PICSRC}|50' alt='{PICNAME}' title='{PICNAME}'></a></div>
{/LIST1}
{ELSE}
{LIST2}
<div class='picElement2'><a href='main.php?gpid={GPID}'><img border='0' src='{PIC_SERVICE}{PICSRC}|50' alt='{KATNAME}' title='{KATNAME}'></a></div>
{/LIST2}
{ENDIF}
{ENDIF}