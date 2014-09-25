<?php
include('includes\DbImage.class.php');
$DBImage=new DBImage();
//charger &  afficher l'image
$stream=$DBImage->read('mypict');
header('Content-type: image/gif');
echo $stream;
?>
