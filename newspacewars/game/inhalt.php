<?php
$menu = $_GET['menu'];

switch($menu)
{
	case "impressum":
		require("./impressum.php");
	break;
}
