<?php
header ("Content-type: image/png");
$groesse=getimagesize("./" . $_GET["id"] . ".png");
$breite	=$groesse[0];
$hoehe	=$groesse[1];

$hoehe2=$hoehe*50/$breite;
$image1 = imagecreate(50,$hoehe2);

$image = imagecreatefrompng("./" . $_GET["id"] . ".png");
imagecopyresized($image1, $image, 0,0, 0,0,100,$hoehe2,$breite,$hoehe);

ImagePNG($image1);
?>