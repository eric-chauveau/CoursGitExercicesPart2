<?php
include('includes\DbImage.class.php');
$DBImage=new DBImage();
//fixer les identifiants
$DBImage->setLogin('nom_serveur', 'utilisateur', 'mot_de_passe','db3');
//sauver une image
$DBImage->write('logo.gif', 'mypict');
?>
 
