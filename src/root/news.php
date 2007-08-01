<h2>News</h2>

<table border='0' width='100%'>
	<tr>
		<th align='left'>Title</th><th align='right'>Datum</th>
	</tr>
	<tr>
		<td colspan='2'><hr></td>
	</tr>
	
	<?php
	$sql_news  				= ("select * from news");
	
	$res 		= mysql_query($sql_news) or die(mysql_error());
	$first 	= true;
	while($dsatz=mysql_fetch_assoc($res)) {
		echo "<tr>";
		if(!$first) {
			echo "<td colspan='2'><hr></td>";
			echo "</tr><tr>";
		}
		else {
			$first=false;
		}
		echo "<td align='left'>" . $dsatz["titel"] . "</td><td align='right'>" . $dsatz["datum"] . "</td>";
		echo "</tr><tr>";
		echo "<td colspan='2'>" . $dsatz["text"] . "</td>";
		echo "</tr>";
		echo "</tr>";
	}
	?>
</table>